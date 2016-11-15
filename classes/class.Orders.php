<?php
class Orders extends DatabaseInterface{
	
	/**
	
	*/
	function getItemById($optionName, $id){
		$q = "SELECT * FROM `$optionName` WHERE `id`='$id' ";
		//echo $q;
		$query = $this->query($q);
		$option = $query->fetch_assoc();
		return $option;
	}
	function getOrderById($id){
		$q = "SELECT * FROM `orders` WHERE `id`='$id' ";
		//echo $q;
		$query = $this->query($q);
		$option = $query->fetch_assoc();
		return $option;
	}
	
	/**
	
	*/
	function getOrders($array=false){
		$classData = new Data();
		$classUsers = new Users();
		//******************************
		$filters[] = 'orderStatus';
		foreach($array as $key=>$aValue){
			foreach($filters as $filter){
				if($filter==$key){
					if($aValue=='all'){
						$dQuery .= " AND`$key`!='' ";
					}else{
						$dQuery .= " AND`$key`='$aValue' ";
					}
				}
			}
		}
		//******************************
		$q = "SELECT * FROM `orders` WHERE `id`!='' $dQuery ORDER BY `addDate` DESC ";
		//echo $q;
		$query = $this->query($q);
		while($order=$query->fetch_assoc()){
			$order['name'] = "¹".$this->addZeros($order['id'], 6);
			if($order['userId']){
				$users = $classUsers->getUsersByAttribute("id", $order['userId']);
				$order['user'] = $users['0'];
			}
			$orders[] = $order;
		}
		$return['data'] = $orders;
		$return['option'] = $tableName;
		$return['parent'] = $parent;
		//print_r($options);
		return $return;
	}
	
	/**
	
	*/
	function getOrderStatuses($needID=false){
		$exceptions[] = "new";
		$exceptions[] = "working";
		$exceptions[] = "sended";
		$exceptions[] = "cancel";
		$exceptions[] = "adding";
		$q = "SELECT * FROM `orderstatuses` ORDER BY `prior` ASC ";
		$query = $this->query($q);
		while($status=$query->fetch_assoc()){
			foreach($exceptions as $exception) if($status['link']==$exception) $status['exception'] = '1';
			if($needID){
				$statuses[$status['id']] = $status;
			}else{
				$statuses[] = $status;
			}
		}
		$return['data'] = $statuses;
		return $return;
	}
	
	/**
	
	*/
	function testNewOrderStatusName($array){
		//print_r($array);
		$q = "";
		if(!$array['myfieldId']){
			$array['myfieldId'] = '0';
		}
		$q = "SELECT * FROM `orderstatuses` ORDER BY `prior` ASC ";
		$query = $this->query($q);
		$myValue = $array[$array['index']];
		$return = '1';
		while($item=$query->fetch_assoc()){
			if($item['name']==$myValue && $array['myfieldId']!=$item['id']){
				$return = '0';
			}
		}
		//****************************
		if($array['pattern']){
			$prega = "/$array[pattern]/";
			//echo "prega = $prega";
			if(!preg_match($prega, $myValue)){
				$return = '0';
			}
		}
		//****************************
		$string  = "{\"return\":\"$return\",\"elementId\":\"$array[elementId]\"";
		if($array['callback']){
			$string .= ",\"callback\":$array[callback]";
		}
		$string .= "}";
		return $string;
	}
	
	/**
	
	*/
	function testNewOrderStatusLink($array){
		//print_r($array);
		$q = "";
		if(!$array['myfieldId']){
			$array['myfieldId'] = '0';
		}
		$q = "SELECT * FROM `orderstatuses` ORDER BY `prior` ASC ";
		$query = $this->query($q);
		$myValue = $array[$array['index']];
		$return = '1';
		while($item=$query->fetch_assoc()){
			if($item['link']==$myValue && $array['myfieldId']!=$item['id']){
				$return = '0';
			}
		}
		//****************************
		if($array['pattern']){
			$prega = "/$array[pattern]/";
			//echo "prega = $prega";
			if(!preg_match($prega, $myValue)){
				$return = '0';
			}
		}
		//****************************
		$string  = "{\"return\":\"$return\",\"elementId\":\"$array[elementId]\"";
		if($array['callback']){
			$string .= ",\"callback\":$array[callback]";
		}
		$string .= "}";
		return $string;
	}
	
	/**
	
	*/
	function saveOrderStatus($array){
		//print_r($array);
		$query = $this->query("SELECT * FROM `orderstatuses` ORDER BY `prior` DESC LIMIT 0,1 ");
		$status = $query->fetch_assoc();
		$newPrior = $status['prior']+10;
		if(!$array['id']){
			$query = $this->query("INSERT INTO `orderstatuses` (`prior`) VALUES ('$newPrior') ");
			$query = $this->query("SELECT * FROM `orderstatuses` ORDER BY `id` DESC LIMIT 0,1 ");
			$status = $query->fetch_assoc();
		}else{
			$query = $this->query("SELECT * FROM `orderstatuses` WHERE `id`='$array[id]' ");
			$status = $query->fetch_assoc();
		}
		$q = "UPDATE `orderstatuses` SET `name`='$array[name]', `link`='$array[link]' WHERE  `id`='$status[id]' ";
		//echo $q;
		$query = $this->query($q);
		$this->setStoreStatusesAndPriors();
	}
	
	/**
	
	*/
	function setStoreStatusesAndPriors(){
		$query = $this->query("SELECT * FROM `orderstatuses` WHERE `link`='new' LIMIT 0,1 ");
		$statusNew = $query->fetch_assoc();
		$query = $this->query("SELECT * FROM `orderstatuses` WHERE `link`='cancel' LIMIT 0,1 ");
		$statusNew = $query->fetch_assoc();
		//******************************
		$query = $this->query("SELECT * FROM `orderstatuses` ORDER BY `prior` ASC ");
		$prior = 30;
		while($item=$query->fetch_assoc()){
			if($item['link']!='new' && $item['link']!='cancel'){
				$subQuery = $this->query("UPDATE `orderstatuses` SET `prior`='$prior' WHERE  `id`='$item[id]' ");
				$prior += 10;
			}
		}
		//******************************
		$query = $this->query("UPDATE `orderstatuses` SET `prior`='10' WHERE `link`='adding' ");
		$query = $this->query("UPDATE `orderstatuses` SET `prior`='20' WHERE `link`='new' ");
		$query = $this->query("UPDATE `orderstatuses` SET `prior`='$prior' WHERE `link`='cancel' ");
	}
	
	/**
	
	*/
	function editOrderStatus($array){
		$query = $this->query("SELECT * FROM `orderstatuses` WHERE `id`='$array[id]' LIMIT 0,1 ");
		$status = $query->fetch_assoc();
		return "{\"id\":\"$status[id]\",\"name\":\"$status[name]\",\"link\":\"$status[link]\"}";
	}
	
	/**
	
	*/
	function saveOrderStatusesPriors($array){
		//print_r($array); //saveOrderStatusesPriors
		$prior = 10;
		$array['priors'] = explode(",", $array['priors']);
		foreach($array['priors'] as $id){
			$query = $this->query("UPDATE `orderstatuses` SET `prior`='$prior' WHERE `id`='$id' ");
			$prior += 10;
		}
		$this->setStoreStatusesAndPriors();
	}
	
	/**
	
	*/
	function setGoodFromTMPToClient($array){
		$query = $this->query("UPDATE `orderstatuses` SET `tmpStore`='0' ");
		$query = $this->query("UPDATE `orderstatuses` SET `tmpStore`='$array[value]' WHERE `id`='$array[id]' ");
	}
	
	/**
	
	*/
	function setOrderStatusColor($array){
		$query = $this->query("UPDATE `orderstatuses` SET `color`='$array[color]' WHERE `id`='$array[id]' ");
	}
	
	/**
	
	*/
	function addZeros($string, $count=7){
		if(strlen($string) < $count){
			$rstring = $string;
			for($j=0; $j<($count-strlen($string)); $j++){
				$rstring = "0".$rstring;
			}
		}
		return $rstring;
	}
	
	/**
	
	*/
	function getGoods($array){
		$classData = new Data();
		$q = "SELECT * FROM `assembly` WHERE `orderId`='$array[orderId]' ORDER BY `id` DESC ";
		$query = $this->query($q);
		while($good=$query->fetch_assoc()){
			//$query = $this->query("SELECT * FROM `$array[shopDirectory]` WHERE `id`='$good[itemId]' ");
			//$good['item'] = $query->fetch_assoc();
			$good['item'] = $classData->getItemById($array['shopDirectory'], $good['itemId']);
			$goods[] = $good;
		}
		return $goods;
	}
	
	/**
	
	*/
	function showAssembly($array){
		print_r($array);
	//	$classData = new Data();
	//	$q = "SELECT * FROM `assembly` WHERE `orderId`='$array[orderId]' ORDER BY `id` DESC ";
	//	$query = $this->query($q);
	//	while($good=$query->fetch_assoc()){
	//		//$query = $this->query("SELECT * FROM `$array[shopDirectory]` WHERE `id`='$good[itemId]' ");
	//		//$good['item'] = $query->fetch_assoc();
	//		$good['item'] = $classData->getItemById($array['shopDirectory'], $good['itemId']);
	//		$goods[] = $good;
	//	}
	//	return $goods;
	}
	
}















?>