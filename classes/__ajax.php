<?
$siteSettings = $this->constructSiteSettings();
switch($array['ajax']){
	case 'showBasket':
		$siteSettings = $this->constructSiteSettings();
		$params['option'] = "assembly";
		$optionName = $params['option'];
		$query = $this->query("SELECT * FROM `menusettings` WHERE `link`='$params[option]' ");
		$option = $query->fetch_assoc();
		$params['orderId'] = $classOrders->getUserCurrentOrder($user);
		if($params['orderId']){
			$order = $classOrders->getOrderById($array['orderId']);
			$user = $classUsers->getUserById($order['userId']);
			$params['shopDirectory'] = $siteSettings['shopDirectory'];
			//echo "<pre>params:"; print_r($params); echo "</pre>";
			$items = $classOrders->getGoods($params);
			$orderStatuses = $classOrders->getOrderStatuses(true);	
		}
		$showTemplate = true;
		$loadPage = '__assembly';
		//echo $classOrders->showAssembly($array);
		break;
	case 'addItemIntoOrder':
		$array['shopDirectory'] = $siteSettings['shopDirectory'];
		$array['isAdmin'] = '0';
		$array['userId'] = $user['id'];
		//print_r($array);
		$json = $classOrders->addNewGoodIntoOrder($array, '0');
		$json = preg_replace("/\}$/", '', $json);
		//$json['preloaderClassId'] = $array['preloaderClassId'];
		//$json .= ",\"preloaderClassId\":\"$array[preloaderClassId]\"";
		
		//$json['preloaderClassPrefix'] = $array['preloaderClassPrefix'];
		//$json .= ",\"preloaderClassPrefix\":\"$array[preloaderClassPrefix]\"";
		
		//$json['preloaderTagName'] = $array['preloaderTagName'];
		//$json .= ",\"preloaderTagName\":\"$array[preloaderTagName]\"";
		
		//$json['goodId'] = $array['goodId'];
		$json .= ",\"goodId\":\"$array[goodId]\"";
		
		//$json['callback'] = $array['callback'];
		$json .= ",\"callback\":$array[callback]";
		
		$json .= ",\"preloaderClas\":\"".($array['preloaderTagName'].$array['preloaderClassPrefix'].$array['preloaderClassId'])."\"";
		
		//print_r($json);
		//$json = json_encode($json);
		echo $json."}";
		break;
	case 'changeOrderQtty':
		echo $classOrders->changeOrderQtty($array);
		break;
	case 'prepareShowBasket':
		$json .= "{\"goodId\":\"$array[goodId]\"";
		$json .= ",\"callback\":$array[callback]";
		$json .= ",\"preloaderClas\":\"".($array['preloaderTagName'].$array['preloaderClassPrefix'].$array['preloaderClassId'])."\"";
		echo $json."}";
		break;
	default:
		//Значение параметра ajax по-умолчанию
		echo "{\"ajaxStatus\":\"ok\"}";
		break;
}
?>