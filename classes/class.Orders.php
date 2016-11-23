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
		$q = "SELECT * FROM `orders` WHERE `orderStatus`!='1' $dQuery ORDER BY `addDate` DESC ";
		//echo $q;
		$query = $this->query($q);
		while($order=$query->fetch_assoc()){
			$order['name'] = "№".$this->addZeros($order['id'], 6);
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
	function addZeros($string, $count=6){
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
			$good['item'] = $classData->getItemById($array['shopDirectory'], $good['goodId']);
			$goods[] = $good;
		}
		return $goods;
	}
	
	/**
	
	*/
	function addNewGoodIntoOrder($array){
		//print_r($array);
		if(!$array['orderId']){
			$query = $this->query("SELECT * FROM `orders` WHERE `isAdmin`='1' AND `orderStatus`='1' ");
			if($query->num_rows>0){
				$order = $query->fetch_assoc();
				$array['orderId'] = $order['id'];
			}else{
				$q = "INSERT INTO `orders` (`orderStatus`, `isAdmin`) VALUES ('1', '1') ";
				$order = $query = $this->query($q);
				$array['orderId'] = $order['id'];
			}
		}
		if(!$array['orderId']){
			return "{\"error\":\"Не удалось определить идентификатор заказа\"}";
		}
		//**************************************
		if($array['goodId']){
			$query = $this->query("SELECT * FROM `$array[shopDirectory]` WHERE `id`='$array[goodId]' ");
			$good = $query->fetch_assoc();
			$query = $this->query("SELECT * FROM `assembly` WHERE `orderId`='$array[orderId]' AND `goodId`= '$array[goodId]' ");
			if($query){
				if($query->num_rows > 0){
					$item = $query->fetch_assoc();
					$query2 = $this->query("UPDATE `assembly` SET `qtty`=`qtty`+1, `price`='$good[price]' WHERE `id`='$item[id]' ");
					return "{\"orderId\":\"$array[orderId]\",\"itemId\":\"$item[id]\"}";
				}else{
					$q = "INSERT INTO `assembly` (`orderId`, `goodId`, `addDate`, `price`, `qtty`)
					VALUES ('$array[orderId]', '$array[goodId]', '".date('Y-m-d H:i:s')."', '$good[price]', '1') ";
					$item = $this->query($q);
					return "{\"orderId\":\"$array[orderId]\",\"itemId\":\"$item[id]\"}";
				}
			}else{
				return "{\"error\":\"Не удалось определить запрос\",\"\":\"\",\"\":\"\"}";
			}
		}
		//************
		$q = "INSERT INTO `assembly` (`orderId`, `addDate`) VALUES ('$array[orderId]', '".date('Y-m-d H:i:s')."') ";
		$item = $this->query($q);
		return "{\"action\":\"addGood\",\"orderId\":\"$array[orderId]\",\"itemId\":\"$item[id]\"}";
	}
	
	/**
	
	*/
	function deleteItemFromOrder($array){
		$query = $this->query("DELETE FROM `assembly` WHERE `id`='$array[itemId]' ");
		return "{\"orderId\":\"$array[orderId]\"}";
	}
	
	/**
	
	*/
	function changeOrderQtty($array){
		$query = $this->query("UPDATE `assembly` SET `qtty`='$array[qtty]' WHERE `id`='$array[itemId]' ");
		return "{\"orderId\":\"$array[orderId]\"}";
	}
	
	/**
	
	*/
	function getAdminOrder($array){
		$query = $this->query("SELECT * FROM `orders` WHERE `isAdmin`='1' AND `orderStatus`='1' ");
		if($query->num_rows>0){
			$order = $query->fetch_assoc();
			$array['orderId'] = $this->addZeros($order['id']);
		}else{
			$q = "INSERT INTO `orders` (`orderStatus`, `isAdmin`) VALUES ('1', '1') ";
			$order = $query = $this->query($q);
			$array['orderId'] = $this->addZeros($order['id']);
			$this->query("UPDATE `orders` SET `name`='$array[orderId]' WHERE `id`='$order[id]' ");
			
		}
		return "{\"orderId\":\"$array[orderId]\"}";
	}
	
	/**
	
	*/
	function confirmOrder($array){
		$query = $this->query("SELECT * FROM `orderstatuses` ORDER BY `prior` ASC LIMIT 0,2 ");
		while($oStatus=$query->fetch_assoc()){
			$status = $oStatus;
		}
		$errors = false;		
		$items = false;
		$query = $this->query("SELECT * FROM `assembly` WHERE `orderId`='$array[orderId]' ORDER BY `addDate` DESC ");
		while($item=$query->fetch_assoc()){
			$subQuery = $this->query("SELECT * FROM `$array[shopDirectory]` WHERE `id`='$item[goodId]' ");
			$good = $subQuery->fetch_assoc();
			$item['good'] = $good;
			//echo $good['name']."::".$good['onStore']."::".$item['qtty']."\n";
			if($good['onStore']>=$item['qtty'] && $item['qtty']>0){
				$items[] = $item;
			}else{
				$errors[] = $item;
			}
		}
		//return false;
		//********************************
		if(is_array($errors)){
			//print_r($errors);
			foreach($errors as $key=>$error){
				$str .= "\"$key\":{\"id\":\"$error[id]\",\"qtty\":\"".$error['good']['onStore']."\"},";
			}
			$str = preg_replace("/,$/", '', $str);
			return "{\"orderId\":\"$array[orderId]\",\"orderStatus\":\"$status[id]\",\"errors\":{".($str)."}}";
		}else{
			foreach($items as $item){
				$onStore = $item['good']['onStore'] - $item['qtty'];
				$tmpStore = $item['good']['tmpStore'] + $item['qtty'];
				$q = "UPDATE `$array[shopDirectory]` SET `onStore`='$onStore', `tmpStore`='$tmpStore' WHERE `id`='".$item['good']['id']."' ";
				$query = $this->query($q);
			}
			$q = "UPDATE `orders` SET `orderStatus`='$status[id]', `addDate`='".date('Y-m-d H:i:s')."' WHERE `id`='$array[orderId]' ";
			$query = $this->query($q);
			return "{\"orderId\":\"$array[orderId]\",\"orderStatus\":\"$status[id]\",\"errors\":false}";
		}
	}
	
	/**
	
	*/
	function addGoodToStore($array){
		$query = $this->query("SELECT * FROM `$array[table]` WHERE `id`='$array[id]' ");
		$item = $query->fetch_assoc();
		$store = $item['store'] + $array['qtty'];
		$onStore = $item['onStore'] + $array['qtty'];
		$query = $this->query("UPDATE `$array[table]` SET `store`='$store', `onStore`='$onStore' WHERE `id`='$array[id]' ");
		return "{\"table\":\"$array[table]\",\"id\":\"$array[id]\",\"store\":\"$store\",\"onStore\":\"$onStore\"}"; 
	}
	
	/**
	
	*/
	function removeGoodFromStore($array){
		$query = $this->query("SELECT * FROM `$array[table]` WHERE `id`='$array[id]' ");
		$item = $query->fetch_assoc();
		$store = $item['store'] - $array['qtty'];
		$onStore = $item['onStore'] - $array['qtty'];
		$query = $this->query("UPDATE `$array[table]` SET `store`='$store', `onStore`='$onStore' WHERE `id`='$array[id]' ");
		return "{\"table\":\"$array[table]\",\"id\":\"$array[id]\",\"store\":\"$store\",\"onStore\":\"$onStore\"}"; 
	}
	
	/**
	
	*/
	function associateClientWithOrder($array){
		$query = $this->query("UPDATE `orders` SET `userId`='$array[userId]' WHERE `id`='$array[orderId]' ");
		return "{\"orderId\":\"$array[orderId]\"}";
	}
	
	/**
	
	*/
	function lookNewOrders(){
		$query = $this->query("SELECT * FROM `orderstatuses` ORDER BY `prior` ASC LIMIT 0,2 ");
		while($oStatus=$query->fetch_assoc()){
			$status = $oStatus;
		}
		$q = "SELECT * FROM `orders` WHERE `orderStatus`='$status[id]' AND `looked`='0' ";
		//echo $q."\n";
		$query = $this->query($q);
		if($query){
			return "{\"count\":\"".($query->num_rows)."\"}";
		}
	}
	
}















?>