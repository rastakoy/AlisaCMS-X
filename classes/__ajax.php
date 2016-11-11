<?
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
		if($classData->isExternal($array['option'])){
			$order = 'prior';
			$orderType = 'asc';
			if($array['link']=='towns'){ $order = 'name'; }
			//print_r($array);
			//$options = $classMenuSettings->getExternalOptions($array['option'], $array['parent'], true, $order, $orderType);
			$options = $classData->getExternalOptions($array['option'], $array['parent'], true, $order, $orderType);
		}else{
			$options = $classData->getItems($array['option'], $array['parent']);
		}
		//print_r($options);
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
		$parents = $classData->getParents($array['parents'], $array['table']);
		if(count($parents)>0){
			$array['parent'] = $parents[count($parents)-1]['id'];
		}else{
			$array['parent'] = '0';
		}
		$classData->savePriors($array);
		echo "{\"option\":\"$array[table]\",\"parents\":\"".($array['parents'])."\"}";
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
	case 'saveCatalogItem':
		$classCatalog->saveCatalogItem($array);
		break;
	case 'deleteFilterOption':
		$classFilters = new Filters();
		$classFilter->deleteFilterOption($array['id']);
		break;
	case 'saveNewFolder':
		echo $classData->saveNewFolder($array);
		break;
	case 'saveFolder':
		echo $classData->saveFolder($array);
		break;
	case 'addNewItem':
		echo $classData->saveItem($array);
		break;
	case 'saveItem':
		echo $classData->saveItem($array);
		break;
	case 'cloneTemplate':
		$classFilters = new Filters();
		$classFilters->cloneTemplate($array['id']);
		break;
	case 'deleteObjectFromCatalog':
		$classMenuSettings->deleteObjectFromCatalog($array['option'], $array['id']);
		break;
	case 'showItemImageProperties':
		$classImages->showItemImageProperties($array['imageId']);
		break;
	case 'setImagesPriors':
		$classImages->setImagesPriors($array['ids']);
		break;
	case 'addToTrash':
		echo $classTrash->addToTrash($array['itemId'], $array['option']);
		break;
	case 'restoreFromTrash':
		echo $classTrash->restoreFromTrash($array['itemId'], $array['option']);
		break;
	case 'setMenusPriors':
		echo $classStart->setMenusPriors($array);
		break;
	case 'testUseTable':
		echo $classStart->testUseTable($array);
		break;
	case 'addNewTable':
		echo $classStart->addNewTable($array);
		break;
	case 'savePanel':
		echo $classStart->savePanel($array);
		break;
	case 'testFilterUseFieldName':
		echo $classFilters->testFilterUseFieldName($array);
		break;
	case 'saveFilterField':
		echo $classFilters->saveFilterField($array);
		break;
	case 'testForConformance':
		echo $classFilters->testForConformance($array);
		break;
	case 'repareTableFields':
		echo $classFilters->repareTableFields($array);
		break;
	case 'getTablesPorts':
		echo $classFilters->getTablesPorts($array);
		break;
	case 'toggleVisible':
		if(!$array['field']){
			$array['field'] = 'visible';
		}
		echo $classData->toggleData($array);
		break;
	case 'changeConnectorTable':
		echo $classFilters->changeConnectorTable($array);
		break;
	case 'changeConnectorFields':
		echo $classFilters->changeConnectorFields($array);
		break;
	case 'showFilterSnippet':
		echo $classFilters->showFilterSnippet($array);
		break;
	case 'saveFilterSnippet':
		echo $classFilters->saveFilterSnippet($array);
		break;
	case 'getAllFoldersTree':
		$folders = $classData->getAllFoldersTree($array);
		$folders['data'] = $folders;
		$folders['elId'] = $array['elId'];
		$folders = $admin->iconvArray($folders, "CP1251", "UTF-8");
		$json = json_encode($folders);
		echo $json;
		break;
	case 'setNewItemParent':
		echo $classData->setNewItemParent($array);
		break;
	case 'getOrderStatuses':
		$statuses = $classOrders->getOrderStatuses();
		$statuses = $admin->iconvArray($statuses, "CP1251", "UTF-8");
		$json = json_encode($statuses);
		echo $json;
		break;
	case 'testNewOrderStatusName':
		echo $classOrders->testNewOrderStatusName($array);
		break;
	case 'testNewOrderStatusLink':
		echo $classOrders->testNewOrderStatusLink($array);
		break;
	case 'saveOrderStatus':
		echo $classOrders->saveOrderStatus($array);
		break;
	default:
		//Значение параметра ajax по-умолчанию
		break;
}
?>