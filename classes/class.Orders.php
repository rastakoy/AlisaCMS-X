<?php
class Orders extends DatabaseInterface{
	
	/**
	
	*/
	function getItemById($optionName, $id){
		$q = "SELECT * FROM `$optionName` WHERE `id`='$id' ";
		//echo $q;
		$query = $this->query($q);
		$option = $query->fetch_assoc();
		$option['tumb'] = $this->getImages($optionName, $option['id']);
		return $option;
	}
	
	/**
	
	*/
	function getOrders($status=false){
		$classData = new Data();
		if($status){
			$q = "SELECT * FROM `orders` WHERE `parent`='$parent' AND `folder`='1' ORDER BY `addDate` DESC ";
		}else{
			$q = "SELECT * FROM `orders` ORDER BY `addDate` DESC ";
		}
		$query = $this->query($q);
		while($option=$query->fetch_assoc()){
			$options[] = $option;
		}
		$return['data'] = $options;
		$return['option'] = $tableName;
		$return['parent'] = $parent;
		//print_r($options);
		return $return;
	}
	
	/**
	
	*/
	function getOrderStatuses(){
		$exceptions[] = "new";
		$exceptions[] = "working";
		$exceptions[] = "sended";
		$exceptions[] = "cancel";
		$q = "SELECT * FROM `orderstatuses` ORDER BY `prior` ASC ";
		$query = $this->query($q);
		while($status=$query->fetch_assoc()){
			foreach($exceptions as $exception) if($status['link']==$exception) $status['exception'] = '1';
			$statuses[] = $status;
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
		$prior = 20;
		while($item=$query->fetch_assoc()){
			if($item['link']!='new' && $item['link']!='cancel'){
				$subQuery = $this->query("UPDATE `orderstatuses` SET `prior`='$prior' WHERE  `id`='$item[id]' ");
				$prior += 10;
			}
		}
		//******************************
		$query = $this->query("UPDATE `orderstatuses` SET `prior`='10' WHERE `link`='new' ");
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
	
}















?>