<?php
class Core extends DatabaseInterface{
	
	function makePost($array){
		//print_r($array);
		$admin = new Admin();
		$array = $admin->iconvArray($array);
		$params = false;
		$paramsString = "";
		if($array['url']){
			$array['url'] = preg_replace("/(^\/adminarea\/|\/{1,100}$)/", "", $array['url']);
			$params = explode("?", $array['url']);
			$array['url'] = preg_replace("/\/$/", "", $params['0']);
			$paramsString = "?".$params['1'];
			$params = $this->constructParams($params['1']);
			echo "<pre>"; print_r($params); echo "</pre>";
			//$string = explode('/', $string);
		}
		//*************************************
		foreach($array as $key=>$value){
			$array[$key] = str_replace("'", "\\'", $value);
		}
		//*************************************
		$showTemplate = false;
		$loadPage = false;
		$itemTemplate = false;
		$classMenuSettings = new MenuSettings();
		$classSettings = new Settings();
		$classSettings->parseSettings();
		$classPages = new Pages();
		$classLanguages = new Languages();
		$classCatalog = new Catalog();
		
		$externalData = new ExternalData();
		
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
			switch($url['0']){
				case 'exit':
					$_SESSION['login'] = '';
					$_SESSION['password'] = '';
					break;
				case 'pages':
					$classFilters = new Filters();
					$showTemplate = true;
					$loadPage = 'pages';
					//print_r($url);
					$pages = $classPages->getPages($url);
					//print_r($pages);
					//$filterParent = $classFilters->getFilterParent($url);
					break;
				case 'filters':
					$classFilters = new Filters();
					$showTemplate = true;
					$loadPage = 'filters';
					$filters = $classFilters->getFilters($url);
					$filterParent = $classFilters->getFilterParent($url);
					$options = $classMenuSettings->getMenu();
					break;
				case 'notices':
					$classNotices = new Notices();
					//$notices = $classNotices->getNotices();
					$showTemplate = true;
					$loadPage = 'notices';
					if($url[count($url)-2]=="editItem"){
						unset($url[count($url)-1]);
						unset($url[count($url)-1]);
					}
					if($url[count($url)-2]=="editFolder"){
						unset($url[count($url)-1]);
						unset($url[count($url)-1]);
						unset($url[count($url)-1]);
					}
					$notices = $classNotices->getNotices($url);
					$parentNotice = $classNotices->getNoticeFromLink($url);
					//print_r($url);
					//$parentNotice = $classNotices->getParentNotice($notices['0']['parent']);
					break;
				case 'catalog':
					$classFilters = new Filters();
					$showTemplate = true;
					$loadPage = 'catalog';
					$parents = $classCatalog->getItemsFromLink($url);
					$folder = $classCatalog->getFolderData($parents[count($parents)-1]['id']);
					//echo "PARENTS<pre>"; print_r($parents); echo "</pre>";
					//echo "<pre>"; print_r($url); echo "</pre>";
					//echo $parents[count($parents)-1]['id'];
					$fields = $classCatalog->getFolderFields($parents[count($parents)-1]['id']);
					//echo "<pre>"; print_r($fields); echo "</pre>";
					$filters = $classFilters->getFilters(array("filters"));
					//echo "<pre>"; print_r($filters); echo "</pre>";
					if($params['action']=='addNewFolder'){
						
					}elseif($params['action']=='editFolder'){
						
					}elseif($params['action']=='editItem'){
						$item = $classCatalog->getItem($params['parent'], $params['itemId']);
						//echo "<pre>"; print_r($item); echo "</pre>";
						$filter = $classCatalog->getItemFilter($parents);
						$fields = $classFilters->getFilters(array("filters",$filter['link']), $item);
						//echo "<pre>"; print_r($fields); echo "</pre>";
					}else{
						//echo "<pre>"; print_r($parents); echo "</pre>";
						//echo "parent=".$parents[count($parents)-1]['id'];
						$items = $classCatalog->getItems($parents[count($parents)-1]['id']);
					}
					break;
				case 'newnotices':
					$showTemplate = true;
					$loadPage = 'newnotices';
					$classNotices = new Notices();
					$notices = $classNotices->getNewNotices();
					//print_r($notices);
					break;
				case 'settings':
					//$showTemplate = true;
					//$loadPage = 'settings';
					break;
				default:
					//echo count($url);
					//print_r($url);
					if(!$url || $url['0']==''){
						$showTemplate = true;
						$loadPage = 'startPage';
					}else{
						//print_r($array);
						$classFilters = new Filters();
						$showTemplate = true;
						$loadPage = 'rightPanel';
						$optionName = preg_replace("/\/.*$/", "", $array['url']);
						$query = $this->query("SELECT * FROM `menusettings` WHERE `link`='$optionName' ");
						$option = $query->fetch_assoc();
						$titles = $classMenuSettings->constructTitles($option['title']);
						if($classMenuSettings->isExternal($optionName)){
							$parents = $classMenuSettings->getExternalItemsFromLink($url);
							$folder = $parents[count($parents)-1];
							$fields = $classCatalog->getFolderFields($parents[count($parents)-1]['id']);
							//echo "<pre>"; print_r($fields); echo "</pre>";
							$filters = $classFilters->getFilters(array("filters"));
							//echo "<pre>"; print_r($filters); echo "</pre>";
							if($params['action']=='addNewFolder'){
								
							}elseif($params['action']=='editFolder'){
								
							}elseif($params['action']=='editItem'){
								if($params['lang']!='' && $params['lang']!=$GLOBALS['language']){ $langPrefix='_'.$params['lang']; }
								if($params['itemId']==''){
									//echo "addNew";
								}
								$item = $classMenuSettings->getExternalItem($optionName, $params['itemId'], $langPrefix);
								$filter['link'] = $option['filter'];
								$fields = $classFilters->getFilters(array("filters",$filter['link']));
							}else{
								$parent = str_replace("itemId_", "", preg_replace("/^.*\//", "", $array['url']));
								$order = 'prior';
								$orderType = 'asc';
								if($array['link']=='towns'){ $order = 'name'; }
								$items = $classMenuSettings->getExternalItems($optionName, $parent, '', $order, $orderType);
							}
						}else{
							$parents = $classMenuSettings->getOptionsByLink($array['url']);
							if($params['action']=='addNewFolder'){
								
							}elseif($params['action']=='editFolder'){
								
							}elseif($params['action']=='editItem'){
								if($params['lang']!='' && $params['lang']!=$GLOBALS['language']){ $langPrefix='_'.$params['lang']; }
								if($params['itemId']==''){
									//echo "addNew";
								}
								$item = $classMenuSettings->getItemById($optionName, $params['itemId']);
								//echo "<pre>"; print_r($item); echo "</pre>";
								$filter = $classCatalog->getItemFilter($parents);
								//echo "<pre>"; print_r($filter); echo "</pre>";
								if(count($parents)=='0'){
									$filter['link'] = $option['filter'];
								}
								$fields = $classFilters->getFilters(array("filters",$filter['link']));
								//echo "<pre>"; print_r($fields); echo "</pre>";
							}else{
								if(count($parents)=='0'){
									$items = $classMenuSettings->getOptions($optionName, '0', '');
								}else{
									$items = $classMenuSettings->getOptions($optionName, $parents[count($parents)-1]['id']);
								}
								$items = $items['data'];
							}
							//print_r($items);
						}
					}
					break;
			}
			//return false;
		}
		//*****************************************
		switch($array['ajax']){
			case 'getLeftBranch':
				//echo "url=$array[url]\n";
				$href = $array['url'];
				//echo "href=$href\n";
				if(preg_match("/notices\/editFolder\/[0-9]{1,12}\/$/", $array['url'], $matches)){
					$id = preg_replace("/([a-zA-Z\/]*|\/$)/", "", $matches['0']);
					//echo "id=$id\n";
					$href = $classMenuSettings->getHref($array['link'], $id);
					$href = "/adminarea/notices/".preg_replace("/folder_[0-9]{1,12}\/$/", "", $href);
					//echo "href=$href\n";
				}
				//print_r($array);
				if($classMenuSettings->isExternal($array['link'])){
					$order = 'prior';
					$orderType = 'asc';
					if($array['link']=='towns'){ $order = 'name'; }
					$options = $classMenuSettings->getExternalOptions($array['link'], '0', true, $order, $orderType);
				}else{
					$options = $classMenuSettings->getOptions($array['link'], '0', true, $href);
					//print_r($options);
				}
				//print_r($options);
				$options = $admin->iconvArray($options, "CP1251", "UTF-8");
				$options = json_encode($options);
				echo $options;
				break;
			case 'openLeftBranch':
				if($classMenuSettings->isExternal($array['option'])){
					$order = 'prior';
					$orderType = 'asc';
					if($array['link']=='towns'){ $order = 'name'; }
					//print_r($array);
					$options = $classMenuSettings->getExternalOptions($array['option'], $array['parent'], true, $order, $orderType);
				}else{
					$options = $classMenuSettings->getOptions($array['option'], $array['parent']);
				}
				//print_r($notices);
				$options = $admin->iconvArray($options, "CP1251", "UTF-8");
				$options = json_encode($options);
				echo $options;
				break;
			case 'getFilterOption':
				$classFilters = new Filters();
				$showTemplate = true;
				$loadPage = 'filter_edit';
				$filter = $classFilters->getFilterOption($array['link']);
				//echo "<pre>"; print_r($filter); echo "</pre>";
				$options = $classMenuSettings->getMenu();
				foreach($options as $option){if($option['external']=='1'){$externals[$option['id']]=$option;}}
				$a=false;foreach($options as $option){if($option['external']!='1'){$a[]=$option;}}$options=$a;
				//echo "<pre>"; print_r($filter); echo "</pre>";
				if($filter['filtertype']=='8'){
					$externalLevels = $classMenuSettings->constructTitles($externals[$filter['config']['externalSettings']['option']]['title']);
					$titles = $classMenuSettings->constructTitles($externals[$filter['config']['externalSettings']['option']]['title']);
					$filter['config']['myoption'] = $externals[$filter['config']['externalSettings']['option']];
					//echo "<pre>"; print_r($array); echo "</pre>";
					$url = explode(",", $array['link']);
					//echo "<pre>"; print_r($url); echo "</pre>";
					$filters = $classFilters->getFilters($url);
					//echo "<pre>"; print_r($filters); echo "</pre>";
					$externalDefaults = $classMenuSettings->getExternalDefaults($filter['config'], $filters);
					//echo "<pre>"; print_r($titles); echo "</pre>";
				}elseif($filter['filtertype']=='7'){
					//echo "TEST";
				}
				break;
			case 'getFilterFieldType':
				$classFilters = new Filters();
				$items = $classFilters->getFilterFields($array['table'], $array['type'], $array['parent'], $array['id']);
				//print_r($items);
				$items = json_encode($items);
				echo $items;
				break;
			case 'saveFilterField':
				$classFilters = new Filters();
				//$array = $admin->iconvArray($array);
				if(isset($array['link'])==''){
					$array['link'] = $admin->transliteral($array['filterName']);
				}
				echo $classFilters->saveFilterField($array);
				break;
			case 'addFilterOption':
				$classFilters = new Filters();
				$classFilters->addFilterOption($array);
				break;
			case 'addFilterClass':
				$classFilters = new Filters();
				$options = $classMenuSettings->getMenu();
				$classFilters->addFilterClass($array);
				break;
			case 'savePriors':
				$parents = $classMenuSettings->getOptionsByLink($array['url']);
				preg_match("/[a-zA-Z0-9]{1,100}\/?/", $array['url'], $matches);
				$array['table'] = str_replace("/", "", $matches['0']);
				if(count($parents)>0){
					$array['parent'] = $parents[count($parents)-1]['id'];
				}else{
					$array['parent'] = '0';
				}
				//print_r($parents);
				//print_r($array);
				$classMenuSettings->savePriors($array);
				echo "{\"table\":\"$array[table]\",\"parent\":\"".($parents[count($parents)-1]['id'])."\"}";
				break;
			case 'editFilterClass':
				$classFilters = new Filters();
				$showTemplate = true;
				$loadPage = 'filter_editclass';
				$filter = $classFilters->getFilterClass($array);
				$options = $classMenuSettings->getMenu();
				$filterOption = $classLanguages->getOptionByOptionName($options, 'filters');
				if(is_array($GLOBALS['languages'])){ foreach($GLOBALS['languages'] as $key=>$lang){
					$dataBases = $classLanguages->getDataBases(array("0"=>$filterOption), $key);
					//echo "<pre>"; print_r($dataBases); echo "</pre>";
					$langFields[] = $dataBases;
				}}
				//echo "<pre>"; print_r($langFields); echo "</pre>";
				break;
			case 'saveFilterClass':
				$classFilters = new Filters();
				if(isset($array['link'])==''){
					$array['link'] = $admin->transliteral($array['filterName']);
				}
				echo $classFilters->saveFilterClass($array);
				break;
			case 'openNoticeBranch':
				$classNotices = new Notices();
				$notices = $classNotices->getNotices($array['parent']);
				//print_r($notices);
				$notices = $admin->iconvArray($notices, "CP1251", "UTF-8");
				$notices = json_encode($notices);
				echo $notices;
				break;
			case 'getEditNotice':
				$classNotices = new Notices();
				$classFilters = new Filters();
				$notice = $classNotices->getEditNotice($array['id']);
				$filterId = $classNotices->defineFilter($array['id']);
				$images = $classNotices->getNoticeImages($array['id']);
				//echo "filterId=$filterId";
				$filters = $classFilters->getFilterDataFromId($filterId);
				$showTemplate = true;
				$loadPage = 'notice_edit';
				break;
			case 'getEditNoticeFolder':
				$classNotices = new Notices();
				$notice = $classNotices->getEditNoticeFolder($array['id']);
				$filters = Filters::getFilters(array('filters'));
				$showTemplate = true;
				$loadPage = 'notice_editclass';
				break;
			case 'saveNoticeFolder':
				$classNotices = new Notices();
				//$array = $admin->iconvArray($array);
				echo $classNotices->saveNoticeFolder($array);
				break;
			case 'saveNotice':
				$classNotices = new Notices();
				//$array = $admin->iconvArray($array);
				$filterId = $classNotices->defineFilter($array['noticeId']);
				$filters = Filters::getFilterDataFromId($filterId);
				echo $classNotices->saveNotice($array, $filters);
				break;
			case 'deleteImage':
				echo $admin->deleteImage($array['imageId']);
				break;
			case 'addNoticeFolder':
				$classNotices = new Notices();
				$href = $classNotices->getHref($array['parent']);
				$href = "notices/".$href."editFolder/".$classNotices->addNoticeFolder($array['parent'])."/";
				echo "{\"return\":\"$href\"}";
				break;
			case 'deleteOptionFolder':
				$href = $classMenuSettings->deleteOptionFolder($array['optionName'], $array['folderId']);
				break;
			case 'deleteNotice':
				echo $classMenuSettings->deleteOption('notices', $array['noticeId']);
				break;
			case 'getEditPage':
				//$classFilters = new Filters();
				$showTemplate = true;
				$loadPage = 'pageEdit';
				$link = explode(",", $array['link']);
				$page = $classPages->getPageByURL($link);
				$images = $classPages->getPageImages($page['id']);
				break;
			case 'savePage':
				//$array = $admin->iconvArray($array);
				$classPages->savePage($array);
				break;
			case 'getSettings':
				$showTemplate = true;
				$loadPage = 'settings';
				$settings = $classSettings->getSettings();
				$admins = $admin->getAdmins();
				//print_r($admins);
				break;
			case 'saveSettings':
				//$array = $admin->iconvArray($array);
				$settings = $classSettings->saveSettings($array);
				break;
			case 'addNewPage':
				$classPages->addNewPage($array);
				break;
			case 'deleteFilterFolder':
				//print_r($array);
				$classFilters = new Filters();
				$classFilters->deleteFilterFolder($array['folderId']);
				break;
			case 'changeShowTemp':
				//$array = $admin->iconvArray($array);
				//print_r($array);
				$classNotices = new Notices();
				$classNotices->changeShowTemp($array);
				break;
			case 'login':
				$_SESSION['login'] = $login;
				$_SESSION['password'] = $pass;
				//echo $login;
				echo "{\"return\":\"ok\"}";
				break;
			case 'deleteAdmin':
				$admin->deleteAdmin($array['adminId']);
				break;
			case 'addAdmin':
				echo $admin->addAdmin($array['login'], $array['pass']);
				break;
			case 'acceptNotice':
				$classNotices = new Notices();
				$classNotices->acceptNotice($array['noticeId']);
				break;
			case 'saveLanguagesPrior':
				$classLanguages->sortLanguages($array['ids']);
				break;
			case 'getLanguage':
				$showTemplate = true;
				$loadPage = 'language';
				$selLang = $array['language'];
				$options = $classMenuSettings->getMenu();
				//print_r($options);
				$dataBases = $classLanguages->getDataBases($options, $selLang);
				//echo "<pre>"; print_r($dataBases); echo "</pre>";
				//$classLanguages->getLanguage($array['ids']);
				break;
			case 'addLanguageField':
				//print_r($array);
				$classLanguages->addLanguageField($array['table'], $array['language'], $array['field']);
				break;
			case 'deleteLanguageField':
				//print_r($array);
				$classLanguages->deleteLanguageField($array['table'], $array['language'], $array['field']);
				break;
			case 'deleteLanguageFields':
				//print_r($array);
				break;
			case 'addNewLanguage':
				//print_r($array);
				$classLanguages->addNewLanguage();
				break;
			case 'saveLanguageField':
				//print_r($array);
				//$array = $admin->iconvArray($array);
				$classLanguages->saveLanguageField($array['myLanguage'], $array['language']);
				break;
			case 'deleteLanguage':
				$options = $classMenuSettings->getMenu();
				$dataBases = $classLanguages->getDataBases($options, $array['language']);
				$classLanguages->deleteLanguageFields($array['language'], $dataBases);
				$classLanguages->deleteLanguage($array['language']);
				break;
			case 'addDBField':
				$classFilters = new Filters();
				echo $classFilters->addNewField($array);
				break;
			case 'showNoticeComments':
				$classNotices = new Notices();
				$notices = $classNotices->getComments($array['noticeId']);
				$notices = $admin->iconvArray($notices, "CP1251", "UTF-8");
				$notices = json_encode($notices);
				echo $notices;
				break;
			case 'deleteNoticeComment':
				$classNotices = new Notices();
				$classNotices->deleteNoticeComment($array['commentId']);
				break;
			case 'saveNewCatalogFolder':
				$classCatalog->saveNewCatalogFolder($array);
				break;
			case 'saveCatalogFolder':
				$classCatalog->saveCatalogFolder($array);
				break;
			case 'getHelp':
				$cont = file_get_contents('http://www.frukt-studio.biz/help.php?action='.$array['action']);
				echo $cont;
				break;
			case 'transliteral':
				echo $admin->transliteral($array['value']);
				break;
			case 'addNewItem':
				$item = $classCatalog->getItem($array['parent'], false);
				echo "{\"parent\":\"$array[parent]\",\"itemId\":\"$item[id]\"}";
				break;
			case 'saveCatalogItem':
				$classCatalog->saveCatalogItem($array);
				break;
			case 'deleteFilterOption':
				$classFilters = new Filters();
				$classFilter->deleteFilterOption($array['id']);
				break;
			case 'saveNewLeftMenuFolder':
				//$classCatalog->saveNewCatalogFolder($array);
				echo $classMenuSettings->saveNewLeftMenuFolder($array);
				break;
			case 'saveNewLeftMenuItem':
				//$classCatalog->saveNewCatalogFolder($array);
				echo $classMenuSettings->saveNewLeftMenuItem($array);
				break;
			case 'addLeftMenuNewItem':
				echo $classMenuSettings->saveNewLeftMenuItem($array);
				break;
			case 'cloneTemplate':
				$classFilters = new Filters();
				$classFilters->cloneTemplate($array['id']);
				break;
			case 'deleteObjectFromCatalog':
				$classMenuSettings->deleteObjectFromCatalog($array['option'], $array['id']);
				break;
		}
		//*****************************************
		if($showTemplate){
			if(isset($selectLanguage) && file_exists("template/pages/".$selectLanguage."/".$loadPage.".txt")){
				$file = file_get_contents("template/pages/".$selectLanguage."/".$loadPage.".txt");
			}
			if(isset($file)){ eval($file); }
			require("template/pages/__root.php");
		}
	
	}
	
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
		//$languages = $admin->getLanguages();
		//if(file_exists("template/pages/".$selectLanguage."/".$template.".txt")){
		//	$file = file_get_contents("template/pages/".$selectLanguage."/".$template.".txt");
		//}elseif(file_exists("template/pages/".$GLOBALS['language']."/".$template.".txt")){
		//	$file = file_get_contents("template/pages/".$GLOBALS['language']."/".$template.".txt");
		//}else{
		//	//$file = "echo \"Template not found\";";
		//}
		//if($file){
		//	eval($file);
		//}
		require_once("template/pages/__template.php");
	}
	
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
			$text = "loadImage ($realSize)\r\n$nnn\r\nСтарое название: ".($array["qqfile"])."\r\n------\r\n";
			file_put_contents("test.txt", $text, FILE_APPEND);
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
			}
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