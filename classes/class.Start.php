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
	
	/**
	
	*/
	function testUseTable($array){
		$mytable = $array[$array['index']];
		$return = '1';
		$q = "SELECT `TABLE_NAME` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '".($GLOBALS['database'])."' ";
		$query = $this->query($q);
		while($table=$query->fetch_assoc()){
			if($table['TABLE_NAME']==$mytable){
				$return = '0';
			}
		}
		//****************************
		$query = $this->query("SELECT * FROM `menusettings` ");
		while($table=$query->fetch_assoc()){
			if($table['link']==$mytable){
				$return = '0';
			}
		}
		//****************************
		if($array['pattern']){
			$prega = "/$array[pattern]/";
			//echo "prega = $prega";
			if(!preg_match($prega, $mytable)){
				$return = '0';
			}
		}
		//****************************
		return "{\"return\":\"$return\",\"elementId\":\"$array[elementId]\"}";
	}
	
	/**
	
	*/
	function addNewTable($array){
		$file = file_get_contents('template/pages/default_SQL_table.txt', true);
		$file = str_replace("%table%", $array['tableName'], $file);
		//echo $file;
		$query = $this->query($file);
		if($query){
			$data = array("table"=>$array['tableName'],"data"=>$this->getFreeTables($array['tableName']));
			$data = json_encode($data);
			return $data;
		}else{
			return "{\"table\":\"error\"}";
		}
	}
	
	/**
	
	*/
	function savePanel($array){
		$query = $this->query("SELECT * FROM `menusettings` WHERE `id`='$array[id]' ");
		$panel = $query->fetch_assoc();
		//print_r($panel);
		//print_r($array);
		$titles = explode(":rules:", $panel['title']);
		$titles = ($titles['1'])?$array['titles'].":rules:".$titles['1']:$array['titles'];
		//print_r($titles);
		$submenu = '1';
		if($array['titleType']=='single'){
			$submenu = '0';
		}
		$q = "UPDATE `menusettings` SET `name`='$array[name]', `link`='$array[link]', `active`='$array[active]', `external`='$array[external]', ";
		$q .= "`filter`='$array[filter]', `submenu`='$submenu', `title`='$titles' WHERE `id`='$array[id]' ";
		//echo $q."\n";
		$query = $this->query($q);
	}
	
}















?>