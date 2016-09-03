<?php
class Trash extends DatabaseInterface{
	
	/**
	
	*/
	function constructor($array){
		$classData = new Data();
		foreach($array as $key=>$option){
			if($option['external']=='0'){
				$items = false;
				$q = "SELECT * FROM `$option[link]` WHERE `trash`='1' ";
				//echo $q."<br/>\n";
				$query = $this->query($q);
				while($item=$query->fetch_assoc()){
					$item['tumb'] = $classData->getImages($option['link'], $item['id']);
					$items[] = $item;
				}
				$array[$key]['trash'] = $items;
			}
		}
		return $array;
	}
	
	/**
	
	*/
	function addToTrash($itemId, $option){
		$query = $this->query("UPDATE `$option` SET `trash`='1' WHERE `id`='$itemId' ");
		return "{\"itemId\":\"$itemId\"}";
	}
	
	/**
	
	*/
	function restoreFromTrash($itemId, $option){
		$query = $this->query("UPDATE `$option` SET `trash`='0' WHERE `id`='$itemId' ");
		return "{\"itemId\":\"$itemId\",\"option\":\"$option\"}";
	}
	
}















?>