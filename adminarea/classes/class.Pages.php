<?php
class Pages extends Core{

	/**
	
	*/
	function getPages($array){
		if(count($array)=='1' && $array['0']=='pages'){
			$q = "SELECT * FROM `pages` WHERE `parent`='0' ORDER BY `prior` ASC ";
		}elseif(count($array)>='2' && $array['0']=='pages' && $array['1']!='editfilter'){
			$q = "SELECT * FROM `pages` WHERE `link`='$array[1]' LIMIT 0,1 ";
			$query = $this->query($q);
			$parent = $query->fetch_assoc();
			$q = "SELECT * FROM `pages` WHERE `parent`='$parent[id]' ORDER BY `prior` ASC ";
		}elseif(count($array)>='2' && $array['0']=='pages' && $array['1']=='editfilter'){
			$q = "SELECT * FROM `pages` WHERE `parent`='0' ORDER BY `prior` ASC ";
		}
		//echo $q;
		$query = $this->query($q);
		while($page=$query->fetch_assoc()){
			$pages[] = $page;
		}
		return $pages;
	}
	
	/**
	
	*/
	function getPageById($pageId){
		$q = "SELECT * FROM `pages` WHERE `id`='$pageId' ";
		$query = $this->query($q);
		$page = $query->fetch_assoc();
		//$page['images'] = $this->getPageImages($pageId);
		return $page;
	}
	
	/**
	
	*/
	function getPageByURL($links){
		$parent = '0';
		foreach($links as $link){
			if($link!="notices"){
				$query = $this->query("SELECT * FROM `pages` WHERE `link`='$link' AND `parent`='$parent' ");
				if($query->num_rows > 0){
					$childrenNotice = $query->fetch_assoc();
					$parent = $childrenNotice['id'];
				}
			}
		}
		return $childrenNotice;
	}
	
	/**
	
	*/
	function getPageImages($pageId){
		$q = "SELECT * FROM `images` WHERE `pageId`='$pageId' ORDER BY `prior` ASC ";
		$query = $this->query($q);
		while($image=$query->fetch_assoc()){
			$images[] = $image;
		}
		return $images;
	}
	
	/**
	
	*/
	function savePage($array){
		$id = $array['pageId'];
		$name = $array['pageName'];
		$cont = $array['pageCont'];
		$link = $array['pageLink'];
		$site = $array['pageSite'];
		$shortName = $array['pageShortName'];
		$menu1 = '0';
		$menu2 = '0';
		$menu3 = '0';
		if($array['pageMenu1']=='1'){ $menu1 = '1'; }
		if($array['pageMenu2']=='1'){ $menu2 = '1'; }
		if($array['pageMenu3']=='1'){ $menu3 = '1'; }
		$menus  = ", `menu1`='$menu1' ";
		$menus .= ", `menu2`='$menu2' ";
		$menus .= ", `menu3`='$menu3' ";
		$q  = "UPDATE `pages` SET `name`='$name', `shortName`='$shortName'";
		$q .= ", `link`='$link', `cont`='$cont', `site`='$site' $menus WHERE `id`='$id' ";
		echo $q;
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function addNewPage(){
		$q = "SELECT * FROM `pages` ORDER BY `prior` DESC LIMIT 0,1 ";
		$query = $this->query($q);
		if($query->num_rows > 0){
			$lastPage = $query->fetch_assoc();
			$prior = $lastPage['prior'] + 10;
		}else{
			
		}
		$q = "INSERT INTO `pages` (`name`, `prior`) VALUES ('Новая страница', '$prior') ";
		$query = $this->query($q);
		
		$q = "SELECT * FROM `pages` ORDER BY `prior` DESC LIMIT 0,1 ";
		$query = $this->query($q);
		$page = $query->fetch_assoc();
		
		$q = "UPDATE `pages` SET `link`='page-$page[id]'  WHERE `id`='$page[id]' ";
	}
	
}
?>