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
			$items = $classOrders->getGoods($params);
			$orderStatuses = $classOrders->getOrderStatuses(true);	
		}
		$showTemplate = true;
		$loadPage = '__assembly';
		echo "TEST";
		//echo $classOrders->showAssembly($array);
		break;
	default:
		//Значение параметра ajax по-умолчанию
		echo "{\"ajaxStatus\":\"ok\"}";
		break;
}
?>