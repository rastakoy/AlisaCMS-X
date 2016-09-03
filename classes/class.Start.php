<?php
class Start extends DatabaseInterface{
	
	/**
	
	*/
	function constructor($array){
		$classData = new Data();
		foreach($array as $key=>$menu){
			$array[$key]['external'] = ($menu['external']=='1')?'Внешний':'Внутренний';
			if($menu['filter']){
				$query = $this->query("SELECT * FROM `filters` WHERE `id`='$menu[filter]' ");
				$filter = $query->fetch_assoc();
				$array[$key]['filterName'] = $filter['name'];
			}
		}
		return $array;
	}
	
	/**
	
	*/
	function setMenusPriors($array){
		$sprior = 10;
		$mass = explode(",", $array['ids']);
		$pid = false;
		foreach($mass as $k=>$v){
			$v =  preg_replace("/menus_/", "", $v);
			if($v!="ok"){
				if($sprior==10){
					$qu = "SELECT * FROM `menusettings` WHERE `id`='$v' ";
					//echo $qu;
					$query = $this->query($qu);
					$row = $query->fetch_assoc();
					$pid = $row["parent"];
				}
				$q = "UPDATE `menusettings` SET `prior`='$sprior' WHERE `id`='$v' AND `parent`='$array[parent]' ";
				//echo $q."\n";
				$query = $this->query($q);
				$sprior += 10;
			}
		}
	}
	
	/**
	
	*/
	function getPanel($menuId){
		$query = $this->query("SELECT * FROM `menusettings` WHERE `id`='$menuId' ");
		$panel = $query->fetch_assoc();
		return $panel;
	}
	
	/**
	
	*/
	function getFreeTables($main=false){
		$exceptions[] = "admins";
		$exceptions[] = "images";
		$exceptions[] = "menusettings";
		$exceptions[] = "settings";
		//****************************
		$query = $this->query("SELECT * FROM `menusettings` ");
		while($table=$query->fetch_assoc()){
			$menuTables[] = $table['link'];
		}
		//****************************
		$q = "SELECT `TABLE_NAME` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '".($GLOBALS['database'])."' ";
		$query = $this->query($q);
		while($table=$query->fetch_assoc()){
			$noexep = true;
			foreach($exceptions as $exception){ if($table['TABLE_NAME']==$exception){
				$noexep = false;
			}}
			if($noexep){
				foreach($menuTables as $menuTable){
					if($menuTable==$table['TABLE_NAME']){
						$noexep = false;
					}
				}
			}
			if($noexep){
				$tables[] = $table['TABLE_NAME'];
			}
		}
		//****************************
		if($main && $main!=''){
			$tables[] = $main;
		}
		return $tables;
	}
	
}















?>