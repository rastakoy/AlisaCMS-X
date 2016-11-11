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
			//$option['children'] = $this->testItemForChildren($tableName, $option['id'], '1');
		//	$option['parents'] = $this->getParentsWay($tableName, $option['id']);
		//	$option['includeComments'] = $this->hasComments($tableName, $option);
		//	$option['tumb'] = $this->getImages($tableName, $option['id']);
			//echo $url."\n";
			//echo "optionName=$tableName:::".$option['href']."\nurl=$url\n";
		//	$prega = "/".str_replace("/", "\\/", $option['href'])."/";
			//echo "prega=$prega\n";
		//	if(preg_match($prega, $url) && $option['children']>0){
		//		//echo "prega=$prega\n";
		//		$option['openBranch'] = $this->getItems($tableName, $option['id'], true, $url);
		//	}else{
		//		$option['openBranch'] = false;
		//	}
		//	//echo $notice['href'];
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
		$q = "SELECT * FROM `orderstatuses` ORDER BY `prior` ASC ";
		$query = $this->query($q);
		while($status=$query->fetch_assoc()){
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
	
}















?>