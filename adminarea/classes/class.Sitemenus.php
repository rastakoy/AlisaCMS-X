<?php
class Sitemenus extends DatabaseInterface{
	
	/**
	
	*/
	function getMenus($name=false){
		$query = $this->query("SELECT * FROM `menus` WHERE `folder`='1' ORDER BY `prior` ASC ");
		while($menu=$query->fetch_assoc()){
			if($name!=false && $name==$menu['link']){
				$menu['children'] = ($menu['assocTable']!='')?
				$this->getAssocMenus($menu['assocTable'], $menu['assocId'], $menu['showItems'], $menu['assocTable']):$this->getMenu($menu['id']);
				$menus = $menu;
				return $menus;
			}else{
				$menu['children'] = ($menu['assocTable']!='')?
				$this->getAssocMenus($menu['assocTable'], $menu['assocId'], $menu['showItems'], $menu['assocTable']):$this->getMenu($menu['id']);
				$menus[$menu['link']] = $menu;
			}
		}
		return $menus;
	}
	
	/**
	
	*/
	function getMenu($parent){
		$query = $this->query("SELECT * FROM `menus` WHERE `folder`='0' AND `parent`='$parent' ORDER BY `prior` ASC ");
		while($menu=$query->fetch_assoc()){
			$menu['href'] = ($menu['assocTable']!='')?$menu['assocTable']:$menu['link'];
			if($menu['assocTable']!=''){
				$menu['children'] = $this->getAssocMenus($menu['assocTable'], $menu['assocId'], $menu['showItems'], $menu['href']);
			}
			$menus[] = $menu;
		}
		return $menus;
	}
	
	/**
	
	*/
	function getAssocMenus($assocTable='', $assocId='0', $showItems, $href){
		$classData = new Data();
		if(preg_match("/^[0-9]*$/", $assocId)){
			$assocSQL .= "AND `parent`='$assocId' ";
		}
		//echo "assocTable = $assocTable ::: showItems = $showItems<br/>";
		if(!$showItems){
			$assocSQL .= "AND `folder`='1' ";
		}else{
			$assocSQL .= "AND `id`!='' ";
		}
		$assocSQL = preg_replace("/^ ?AND/", '', $assocSQL);
		$q = "SELECT * FROM `$assocTable` WHERE $assocSQL ORDER BY `prior` ASC ";
		//echo $q."<br/>";
		$query = $this->query($q);
		while($menu=$query->fetch_assoc()){
			$menu['href'] = $href."/".$menu['link'];
			$menu['tumb'] = $classData->getImages($assocTable, $menu['id']);
			$menu['children'] = $this->getAssocMenus($assocTable, $menu['id'], $showItems, $menu['href']);
			$menus[] = $menu;
		}
		return $menus;
	}
	
}
?>