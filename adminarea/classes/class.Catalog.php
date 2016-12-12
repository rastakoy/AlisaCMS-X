<?php
class Catalog extends DatabaseInterface{

	/**
	
	*/
	function getItems($parent){
		$q = "SELECT * FROM `catalog` WHERE `parent`='$parent' ORDER BY `prior` ASC ";
		//echo $q;
		$query = $this->query($q);
		while($item=$query->fetch_assoc()){
			$classMenuSettings = new MenuSettings();
			$item['fullLink'] = $classMenuSettings->getHref('catalog', $item['id']);
			$item['images'] = $classMenuSettings->getImages($item['id'], 'catalog');
			$item['tumb'] = $classMenuSettings->getImages($item['id'], 'catalog');
			$items[] = $item;
		}
		return $items;
	}
	
	/**
	
	*/
	function getItemsFromLink($url){
		$parent = '0';
		foreach($url as $key=>$link){
			if($key>0){
				$q = "SELECT * FROM `catalog` WHERE `link`='$link' && `parent`='$parent' LIMIT 0,1 ";
				//echo $q."<br/>";
				$query = $this->query($q);
				$item = $query->fetch_assoc();
				$parents[] = $item;
				$parent = $item['id'];
			}
		}
		return $parents;
	}
	
	/**
	
	*/
	function getItemBreadLinksFromId($id){
		$q = "SELECT * FROM `catalog` WHERE `id`='$id' ";
		$query = $this->query($q);
		if($query){
			$item = $query->fetch_assoc();
			if($notice['parent']!='0'){
				$link = $this->getItemBreadLinksFromId($item['parent']);
				if($item['folder']=='1'){
					$link .= "/".$item['id'];
				}
				return $link;
			}else{
				return $item['id'];
			}
		}
		return false;
	}
	
	/**
	
	*/
	function getFolderFields($parent){
		//echo "parent=".$parent;
		$classFilters = new Filters();
		$fields = $classFilters->defaultShowIndexes;
		return $fields;
	}
	
	/**
	
	*/
	function saveNewCatalogFolder($array){
		$q  = "INSERT INTO `catalog` (`name`, `link`, `parent`, `visible`, `content`, `letters`, `folder`, `filter`) VALUES ";
		$q .= " ('$array[name]', '$array[link]', '$array[parent]', '$array[visible]', '$array[content]', '$array[letters]', '1', '$array[filter]' ) ";
		//echo $q;
		$query = $this->query($q);
		
	}
	
	/**
	
	*/
	function saveCatalogFolder($array){
		$lang = $array['lang'];
		$q  = "UPDATE `catalog` SET `name$lang`='$array[name]', `mini$lang`='$array[mini]', `link`='$array[link]', `parent`='$array[parent]', `visible`='$array[visible]', ";
		$q .= "`content$lang`='$array[content]', `letters`='$array[letters]', `filter`='$array[filter]' WHERE `id`='$array[id]' ";
		//echo $q;
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function getFolderData($id){
		$query = $this->query("SELECT * FROM `catalog` WHERE `id`='$id' ");
		$folder = $query->fetch_assoc();
		$classMenuSettings = new MenuSettings();
		$folder['fullLink'] = $classMenuSettings->getHref('catalog', $folder['id']);
		return $folder;
	}
	
	/**
	
	*/
	function getItemFilter($parents){
		if(!is_array($parents)){
			return false;
		}
		rsort($parents);
		foreach($parents as $parent){
			if($parent['filter']!='0'){
				$query = $this->query("SELECT * FROM `filters` WHERE `id`='$parent[filter]' ");
				if($query){
					return $query->fetch_assoc();
				}else{
					return false;
				}
			}
		}
		return false;
	}
	
	/**
	
	*/
	function getItem($parent, $itemId){
		$query = $this->query("SELECT * FROM `catalog` WHERE `id`='$itemId' ");
		if($query){
			if($query->num_rows==0){
				$subQuery = $this->query("INSERT INTO `catalog` (`tmp`, `parent`) VALUES ('1', '$parent') ");
				$subQuery = $this->query("SELECT * FROM `catalog` ORDER BY `id` DESC LIMIT 0,1 ");
				$item = $subQuery->fetch_assoc();
			}elseif($query->num_rows>0){
				$item = $query->fetch_assoc();
				$classMenuSettings = new MenuSettings();
				$item['images'] = $classMenuSettings->getImages($item['id'], 'catalog');
			}
			return $item;
		}
		return false;
	}
	
	/**
	
	*/
	function saveCatalogItem($array){
		$lang = $array['lang'];
		foreach($array as $key=>$value){
			if($key!="lang" && $key!="ajax" && $key!='itemId'){
				//echo "$key=>$value\n";
				$q = "UPDATE `catalog` SET `$key$lang`='$value' WHERE `id`='$array[itemId]' ";
				//echo "$q\n";
				$query = $this->query($q);
			}
		}
		$q = "UPDATE `catalog` SET `tmp`='0' WHERE `id`='$array[itemId]' ";
		$query = $this->query($q);
	}

}





























?>