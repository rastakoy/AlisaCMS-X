<?
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
			if(!$params['orderStatus']){
				$params['orderStatus'] = 'all';
			}
			$optionName = $params['option'];
			$query = $this->query("SELECT * FROM `menusettings` WHERE `link`='$params[option]' ");
			$option = $query->fetch_assoc();
			$parents = $classData->getParents($params);
			$titles = $classData->constructTitles($option['title'], $parents);
			$folder = $classData->getFolder($parents[count($parents)-1]['id'], $optionName);
			$items = $classOrders->getOrders($params);
			$items = $items['data'];
			$orderStatuses = $classOrders->getOrderStatuses(true);
			$showTemplate = true;
			$loadPage = '__orders';
			break;
		case 'assembly':
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
?>