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
			//echo "<pre>"; print_r($params); echo "</pre>";
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
		$classMenuSettings = new MenuSettings();
		$classData = new Data();
		$classSettings = new Settings();
		$classSettings->parseSettings();
		$classPages = new Pages();
		$classLanguages = new Languages();
		$classCatalog = new Catalog();
		$classImages = new Images();
		$classFilters = new Filters();
		
		$classTrash = new Trash();
		$classStart = new Start();
		$classBarcode = new Barcode();
		$classOrders = new Orders();
		
		$externalData = new ExternalData(); //класс для работы с данными из внешних источников
		
		//echo "<pre>"; print_r($admin->iconvArray($exData)); echo "</pre>";
		//$classCatalog = new Catalog();
		//echo "<pre>"; print_r($GLOBALS); echo "</pre>";
		//*****************************************
		if($array['ajax']=='getPage'){
			$url = preg_replace("/\/adminarea\//", "", $array['url']);
			$url = preg_replace("/\/$/", "", $url);
			$url = explode("/", $url);
		}
		//*****************************************
		//print_r($array);
		$login = $array['login'];
		if(!$login){
			$login = $_SESSION['login'];
		}
		$pass = md5($array['password']);
		if(!$pass){
			$pass = $_SESSION['password'];
		}
		$administrator = $admin->isAdmin($login, $pass);
		if(!$administrator){
			//return false;
		}
		//*****************************************
		if(isset($url) && is_array($url) && count($url)>=1){
			if($url['0']=='filters'){
				$params['option'] = 'filters';
			}
			switch($params['option']){
				case 'exit':
					$_SESSION['login'] = '';
					$_SESSION['password'] = '';
					break;
			//	case 'filters':
			//		$classFilters = new Filters();
			//		$showTemplate = true;
			//		$loadPage = 'filters';
			//		//echo "<pre>"; print_r($url); echo "</pre>";
			//		//$filters = $classFilters->getFilters($url);
			//		$filters = $classFilters->getRootFilters();
			//		$filterParent = $classFilters->getFilterParent($url);
			//		$options = $classMenuSettings->getMenu();
			//		break;
				case 'trash':
					$trash = $classMenuSettings->getMenu();
					$trash = $classTrash->constructor($trash);
					$showTemplate = true;
					$loadPage = '__trash';
					break;
				case 'orders':
					$optionName = $params['option'];
					//$optionName = preg_replace("/\/.*$/", "", $array['url']);
					$query = $this->query("SELECT * FROM `menusettings` WHERE `link`='$params[option]' ");
					$option = $query->fetch_assoc();
					if($classData->isExternal($params['option'])){
						$parents = $classData->getExternalParents($params);
					}else{
						$parents = $classData->getParents($params);
					}
					$titles = $classData->constructTitles($option['title'], $parents);
					$folder = $classData->getFolder($parents[count($parents)-1]['id'], $optionName);
					//if(count($parents)=='0'){
					//	//$items = $classMenuSettings->getOptions($params['option'], '0', '');
					//	$items = $classData->getItems($params['option'], '0', '');
					//}else{
					//	$items = $classData->getItems($params['option'], $parents[count($parents)-1]['id'], '');
					//}
					$items = $classOrders->getOrders();
					$items = $items['data'];
					
					
					$showTemplate = true;
					$loadPage = '__orders';
					break;
				default:
					//echo count($url);
					//print_r($url);
					if(!$params['option']){
						if($params['action']=='editMenus'){
							$panel = $classStart->getPanel($params['menuId']);
							$titles = $classData->constructTitles($panel['title']);
							$filters = $classFilters->getRootFilters();
							//$admin->myPrint($titles);
							if($panel['external']!='1'){
								$freeTables = $classStart->getFreeTables($panel['link']);
							}else{
								$freeTables = $classStart->getFreeTables();
							}
							//$admin->myPrint($freeTables);
						}else{
							$menus = $classMenuSettings->getMenu(false);
							$menus = $classStart->constructor($menus);
						}
						$showTemplate = true;
						$loadPage = '__start';
					}else{
						//print_r($array);
						$showTemplate = true;
						$loadPage = '__data';
						$optionName = $params['option'];
						//$optionName = preg_replace("/\/.*$/", "", $array['url']);
						$query = $this->query("SELECT * FROM `menusettings` WHERE `link`='$params[option]' ");
						$option = $query->fetch_assoc();
						if($classData->isExternal($params['option'])){
							$parents = $classData->getExternalParents($params);
						}else{
							$parents = $classData->getParents($params);
						}
						$titles = $classData->constructTitles($option['title'], $parents);
						//echo "<pre>"; print_r($parents); echo "</pre>";
						if($params['action']=='addNewFolder'){
							$fields = $classCatalog->getFolderFields($parents[count($parents)-1]['id']);
						}elseif($params['action']=='editFolder'){
							$folder = $classData->getFolder($params['folderId'], $optionName);
							$fields = $classCatalog->getFolderFields($parents[count($parents)-1]['id']);
						}elseif($params['action']=='editItem'){
							if($params['option']=='filters'){
								$loadPage = '__filters';
								$filter = $classFilters->getFilterClass($params['itemId']);
								$filter = $classFilters->makeConnectors($filter);
								$options = $classData->getOptions(true);
								$filterOption = $classMenuSettings->getMenuItemByName($params['option']);
								$ports = $classFilters->getTablesPorts();
								$tablesWIthPorts = $classFilters->getTablesHasPorts();
								if(is_array($GLOBALS['languages'])){ foreach($GLOBALS['languages'] as $key=>$lang){
									$dataBases = $classLanguages->getDataBases(array("0"=>$filterOption), $key);
									//echo "<pre>"; print_r($dataBases); echo "</pre>";
									$langFields[] = $dataBases;
								}}
								//$filter = $classFilters->getFilterOption($params['itemId']);
								break;
							}
							if($params['itemId']==''){
								//echo "addNew";
							}
							$item = $classData->getItemById($params['option'], $params['itemId']);
							//echo "<pre>"; print_r($item); echo "</pre>";
							$filter = $classData->getItemFilter($parents, $params['option']);
							//echo "<pre>"; print_r($filter); echo "</pre>";
							if(count($parents)=='0'){
								$filter['link'] = $option['filter'];
							}
							$fields = $classFilters->getFilters(array("filters",$filter['link']));
							$fieldsJSON = json_encode($admin->iconvArray($fields, "CP1251", "UTF-8"));
							//echo "<pre>"; print_r($fields); echo "</pre>";
						}else{
							if($classData->isExternal($params['option'])){
								$order = 'prior';
								$orderType = 'asc';
								$items = $classData->getExternalOptions($params['option'], $parents[count($parents)-1]['id'], '', $order, $orderType);
							}else{
								$folder = $classData->getFolder($parents[count($parents)-1]['id'], $optionName);
								if(count($parents)=='0'){
									//$items = $classMenuSettings->getOptions($params['option'], '0', '');
									$items = $classData->getItems($params['option'], '0', '');
								}else{
									$items = $classData->getItems($params['option'], $parents[count($parents)-1]['id'], '');
								}
							}
							$items = $items['data'];
						}
					}
					break;
			}
			//return false;
		}
		//*****************************************
		require_once("__ajax.php");
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
		$admin = new Admin();
		$login = $_SESSION['login'];
		$pass = $_SESSION['password'];
		$administrator = $admin->isAdmin($login, $pass);
		//***********************************
		//print_r($array);
		switch($array['0']){
			default:
				//$rates = $admin->getCreditCalculator();
				$classMenuSettings = new MenuSettings();
				$leftMenu = $classMenuSettings->getMenu();
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
	
	//function testLanguage($language){
	//	$admin = new Admin();
	//	return $admin->getLanguageByPrefix($language);
	//}
	
}
?>