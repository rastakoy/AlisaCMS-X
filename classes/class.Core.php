<?php
class Core extends DatabaseInterface{
	
	/**
	
	*/
	function makePost($array){
		//print_r($array);
		$admin = new Admin();
		$array = $admin->iconvArray($array);
		$params = false;
		$paramsString = "";
		if($array['url']){
			$pregstr = "/(^\/".(str_replace("/", "", $GLOBALS['adminBase']))."\/|\/{1,100}$)/";
			$array['url'] = preg_replace($pregstr, "", $array['url']);
			$params = explode("?", $array['url']);
			$array['url'] = preg_replace("/\/$/", "", $params['0']);
			$paramsString = "?".$params['1'];
			$params = $this->constructParams($params['1']);
			//echo "<pre>params:"; print_r($params); echo "</pre>";
			$siteSettings = $this->constructSiteSettings();
			$siteMenus = $this->constructSiteMenus();
			$siteBlocks = $this->constructSiteBlocks();
			//echo "<pre>siteSettings:"; print_r($siteSettings); echo "</pre>";
			//$string = explode('/', $string);
		}
		//*************************************
		foreach($array as $key=>$value){
			$value = str_replace("\\", "\\\\", $value);
			$array[$key] = str_replace("'", "\\'", $value);
		}
		//*************************************
		if($params['lang']!='' && $params['lang']!=$GLOBALS['language']){
			$langPrefix='_'.$params['lang'];
		}
		//*************************************
		$showTemplate = false;
		$loadPage = false;
		$itemTemplate = false;
		//*************************************
		//$classAdmin = new Admin();
		$classSitemenus = new Sitemenus();
		$classOrders = new Orders();
		$classUsers = new Users();
		$classImages = new Images();
		//*************************************
		$menus = $classSitemenus->getMenus();
		$user = $classUsers->getUser($array);
		//*************************************
		if(!$user){
			//return false;
		}
		//*****************************************
		if(isset($url) && is_array($url) && count($url)>=1){
			switch($params['option']){
				case 'exit':
					$_SESSION['login'] = '';
					$_SESSION['password'] = '';
					break;
				default:
					
					break;
			}
			//return false;
		}
		//*****************************************
		require_once("classes/__ajax.php");
		//*****************************************
		if($showTemplate){
			if(isset($selectLanguage) && file_exists("template/pages/".$selectLanguage."/".$loadPage.".txt")){
				$file = file_get_contents("template/pages/".$selectLanguage."/".$loadPage.".txt");
			}
			if(isset($file)){ eval($file); }
			require("template/pages/__root.php");
		}
	}
	
	/**
	
	*/
	function makePage($array, $params){
		//print_r($params);
		//print_r($_SESSION);
		//$_SESSION['autoexit'] = "false";
		if(isset($_COOKIE['language'])){
			$selectLanguage = $_COOKIE['language'];
		}
		if(!isset($selectLanguage) && isset($_SESSION['language'])){
			$selectLanguage = $_SESSION['language'];
		}
		if(!isset($selectLanguage) && isset($GLOBALS['language'])){
			$selectLanguage = $GLOBALS['language'];
		}
		if($selectLanguage != $GLOBALS['language']){
			$langPrefix = "_".$selectLanguage;
		}
		//*****************************************
		if($array['1']=='exit'){
			$_SESSION['login'] = '';
			$_SESSION['password'] = '';
			//return false;
		}
		//*****************************************
		$siteSettings = $this->constructSiteSettings();
		//*****************************************
		$admin = new Admin();
		$login = $_SESSION['login'];
		$pass = $_SESSION['password'];
		$users = new Users();
		$user = $users->getUser($array);
		//***********************************
		$classSitemenus = new Sitemenus();
		$classData = new Data();
		$classImages = new Images();
		$classOrders = new Orders();
		//***********************************
		$menus = $classSitemenus->getMenus();
		$showTemplate = true;
		$loadPage = 'start';
		if($array['0']){
			$loadPage = $array['0'];
		}
		//print_r($array);
		switch($array['0']){
			case 'clients':
				$mainItem = $classData->getElementBySiteURL($array);
				if($mainItem['folder']=='1'){
					$loadPage = 'clients';
				}
				break;
			case 'items':
				$mainItem = $classData->getElementBySiteURL($array);
				if($mainItem['folder']=='0'){
					$loadPage = 'item';
					$mainItem['isItemInBasket'] = $classOrders->isItemInBasket($user['id'], $mainItem['id']);
				}
				break;
			default:
				break;
		}
		//***********************************
		require_once("template/pages/__template.php");
	}
	
	/**
	
	*/
	function loadImage($array){
		$parent = $array['parent'];
		$admin = new Admin();
		$email = $_COOKIE['useremail'];
		$password = $_COOKIE['userpassword'];
		if(!$email){
			$email = $_SESSION['useremail'];
			$password = $_SESSION['userpassword'];
		}
		//$user = $admin->getUser($email, $password);
		//if($user){
			$input = fopen("php://input", "r");
			$temp = tmpfile();
			$realSize = stream_copy_to_stream($input, $temp);
			fclose($input);
			
			$target = fopen("template/tmp/".$array["qqfile"], "w");
			fseek($temp, 0, SEEK_SET);
			stream_copy_to_stream($temp, $target);
			fclose($target);
			
			$query = $this->query("SELECT * FROM `images` ORDER BY `id` DESC  LIMIT 0,1 ");
			$lImage = $query->fetch_assoc();
			$nnn = ($lImage['id']+1).".jpg";
			$text = "loadImage ($realSize)\r\n$nnn\r\nСтарое название: ".($array["qqfile"])."\r\n".json_encode($admin->iconvArray($array))."\r\n";
			//***************
			$res = copy("template/tmp/".$array["qqfile"], "../loadimages/".$nnn);
			if(file_exists("template/tmp/".$array["qqfile"])){
				unlink("template/tmp/".$array["qqfile"]);
			}
			if($array['currentNotice']){
				$q = "INSERT INTO `images` ( `id`, `name`, `noticeId` ) VALUES ( '".($lImage['id']+1)."', '$nnn', '$array[currentNotice]' ) ";
			}elseif($array['currentPage']){
				$q = "INSERT INTO `images` ( `id`, `name`, `pageId` ) VALUES ( '".($lImage['id']+1)."', '$nnn', '$array[currentPage]' ) ";
			}elseif($array['currentCatalogItem']){
				$q = "INSERT INTO `images` ( `id`, `name`, `tableId`, `table` ) VALUES ( '".($lImage['id']+1)."', '$nnn', '$array[currentCatalogItem]', '$array[tableName]' ) ";
			}elseif($array['externalId']){
				$q = "INSERT INTO `images` ( `id`, `name`, `externalId`, `table` ) VALUES ( '".($lImage['id']+1)."', '$nnn', '$array[externalId]', '$array[table]' ) ";
			}
			//***************
			$text .= "query = ".$q."\r\n------\r\n";
			//file_put_contents("test.txt", $text, FILE_APPEND);
			//***************
			$classImages = new Images();
			$classImages->convertToJpeg("../loadimages/", $nnn, $array['qqfile']);
			if($res) {
				$query = $this->query($q);
				return "{\"success\":\"true\", \"newimgid\":\"".($nnn)."\"}";
			}else{
				return "{\"success\":\"false\"}";
			}
		//}else{
		//	return "{\"success\":\"noaccess\"}";
		//}
	}
	
	/**
	
	*/
	function constructParams($string){
		$params = urldecode($string);
		$params = iconv("UTF-8", "CP1251", $params);
		$paramss = explode(",", $params);
		if(is_array($paramss)){ foreach($paramss as $param){
			$param = explode("=", $param, 2);
			if($param['0']!='' && $param['1']!=''){
				$return[$param['0']] = $param['1'];
			}
		}}
		return $return;
	}
	
	/**
	
	*/
	function constructSiteSettings(){
		$query = $this->query("SELECT * FROM `settings` ORDER BY `id` ASC ");
		while($item=$query->fetch_assoc()){
			$settings[$item['arrayName']] = $item['value'];
		}
		return $settings;
	}
	
	//function testLanguage($language){
	//	$admin = new Admin();
	//	return $admin->getLanguageByPrefix($language);
	//}
	
}
?>