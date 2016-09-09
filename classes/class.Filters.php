<?php
class Filters extends DatabaseInterface{

	public $defaultIndexes = array(
		"id", "parent", "folder", "prior", "filter", "visible", "tmp", "price",
		"name", "mini", "link", "css", "hash", "letters", "content", "addDate",
		"trash"
	);
	public $defaultShowIndexes = array(
		array("name", "Название", "VARCHAR", "100"),
		array("mini", "Миниописание", "VARCHAR", "255"),
		array("link", "HTML-путь", "VARCHAR", "100"),
		array("parent", "Родитель", "INT", "11"),
		array("price", "Цена", "INT", "11"),
		array("images", "Изображения"),
		array("content", "Описание", "TEXT"),
		array("visible", "Показ в сайте", "INT", "1", "1"),
		array("letters", "Буквенный код", "VARCHAR", "30"),
		array("addDate", "Дата добавления", "DATETIME", ""),
		array("metaTitle", "Заголовок", "VARCHAR", "200"),
		array("metaDescription", "Описание заголовка", "VARCHAR", "200"),
		array("tmp", "Новая запись", "INT", "1"),
		array("trash", "Утиль", "INT", "0")
	);
	
	/**
	
	*/
	function getRootFilters(){
		$query = $this->query("SELECT * FROM `filters` WHERE `folder`='1' AND `parent`='0' ORDER BY `prior` ASC ");
		while($filter=$query->fetch_assoc()){
			$filters[] = $filter;
		}
		return $filters;
	}
	
	/**
	
	*/
	function getFilters($array, $editItem=false){
		$externalData = new ExternalData();
		$admin = new Admin();
		//echo "<pre>"; print_r($array); echo "</pre>";
		//******************************
		if(count($array)=='1' && $array['0']=='filters'){
			$q = "SELECT * FROM `filters` WHERE `parent`='0' ORDER BY `prior` ASC ";
		}elseif(count($array)>='2' && $array['0']=='filters' && $array['1']!='editfilter'){
			$q = "SELECT * FROM `filters` WHERE `link`='$array[1]' AND `parent`='0' LIMIT 0,1 ";
			//echo $q."\n";
			$query = $this->query($q);
			if($query->num_rows=='0'){
				$q = "SELECT * FROM `filters` WHERE `id`='$array[1]' LIMIT 0,1 ";
				$query = $this->query($q);
				$parent = $query->fetch_assoc();
			}else{
				$parent = $query->fetch_assoc();
			}
			//print_r($parent);
			$q = "SELECT * FROM `filters` WHERE `parent`='$parent[id]' ORDER BY `prior` ASC ";
		}elseif(count($array)>='2' && $array['0']=='filters' && $array['1']=='editfilter'){
			$q = "SELECT * FROM `filters` WHERE `parent`='0' ORDER BY `prior` ASC ";
		}
		//echo $q;
		$query = $this->query($q);
		while($filter=$query->fetch_assoc()){
			$filter['default'] = '0';
			foreach($this->defaultShowIndexes as $key=>$index){
				if($index['0']==$filter['link']){
					$filter['default'] = '1';
				}
			}
			$config = json_decode($filter['config'], true);
			if($config['filtertype']=='8'){
				$options = MenuSettings::getMenu();
				foreach($options as $option){if($option['external']=='1'){$externals[$option['id']]=$option;}}
				$params['table'] = $externals[$config['externalSettings']['option']]['link'];
				$titles = MenuSettings::constructTitles($externals[$config['externalSettings']['option']]['title']);
				//echo "<pre>Titles:\n"; print_r($titles); echo "</pre>";
				$ids = array();
				//echo "<pre>"; print_r($config); echo "</pre>";
				if($config['externalSettings']['defaults']){
					$mass = explode(",", $config['externalSettings']['defaults']);
					foreach($mass as $mKey=>$mValue){
						$mValue=explode("=", $mValue);
						if($mValue['1']=='' || $mValue['1']=='0' || $mValue['0']=='' || $mValue['0']=='0'){
							unset( $mass[$mKey] );
							break;
						}else{
							$mass[$mKey]=array($mValue['0'], $mValue['1']);
						}
					}
					//echo "<pre>"; print_r($mass); echo "</pre>";
					foreach($mass as $mKey=>$mValue){
						if($mValue['0']=='id'){
							$ids[] = $mValue['1'];
						}elseif($mValue['0']=='name'){
							//echo $mass[$mKey]['1']."<br/>";
							//echo "name=(".$editItem[$mass[$mKey]['1']].")<br/>";
							if($editItem[$mass[$mKey]['1']]){
								$ids[] = $editItem[$mass[$mKey]['1']];
							}else{
								break;
							}
						}
					}
					//echo "<pre>"; print_r($editItem); echo "</pre>";
					//echo "<pre>Titles:\n"; print_r($titles); echo "</pre>";
					foreach($ids as $idKey=>$id){
						$subParams['table']=$params['table'];
						$subParams['params'] = array("id=$id");
						$foo = $externalData->getData($subParams);
						//echo $foo;
						$foo = json_decode($foo, true);
						//print_r($foo);
						$ids[$idKey] = $admin->iconvArray($foo['data']['0']);
					}
					$params['order'] = "letters";
					$params['orderType'] = "asc";
					if($config['externalSettings']['level'] == count($titles['0'])-1){
						$params['params'] = array(
							$this->constructLetters($config['externalSettings']['level']*3, $ids),
							"folder=0"
						);
					}else{
						$params['params'] = array(
							$this->constructLetters(($config['externalSettings']['level']+1)*3, $ids),
							"folder=1"
						);
					}
				}elseif($config['externalSettings']){
					//echo "YES\n\n";
					$params['params'] = array("parent=0","folder=0");
					$params['order'] = "prior";
					$params['orderType'] = "asc";
				}
				//echo "<pre>"; print_r($ids); echo "</pre>";
				//echo "<pre>"; print_r($params); echo "</pre>";
				$foo = $externalData->getData($params);
				//echo $foo;
				$foo = json_decode($foo, true);
				$foo = $admin->iconvArray($foo['data']);
				//echo "<pre>"; print_r($foo); echo "</pre>";
				$config['externals'] = $foo;
			}elseif($config['filtertype']=='7'){
				//echo "<pre>"; print_r($config); echo "</pre>";
				$subQuery = $this->query("SELECT * FROM `$config[tablename]` ORDER BY `prior` ASC ");
				$items = false;
				if($subQuery){
					while($item=$subQuery->fetch_assoc()){
						$items[] = $item;
					}
				}
				$config['items'] = $items;
			}
			$filter['config'] = $config;
			$filters[] = $filter;
		}
		return $filters;
	}
	
	/**
	
	*/
	function constructLetters($count, $ids){
		$str = "rlike(letters=^";
		//echo "count=$count";
		//echo "<pre>"; print_r($ids); echo "</pre>";
		foreach($ids as $item){
			$count = $count-3;
			$strT = $item['letters'];
		}
		$str .= $strT;
		if($count>0){
			$str .= "[A-Z]{".$count."}$)";
		}else{
			$str .= "$)";
		}
		//echo $str."<br/>";
		return $str;
		//[A-Z]{".(($config['externalSettings']['level'])*3)."}$)"
	}
	
	/**
	
	*/
	function getFilterParent($array){
		if(count($array)>='2' && $array['0']=='filters'){
			$q = "SELECT * FROM `filters` WHERE `link`='$array[1]' AND `parent`='0' LIMIT 0,1 ";
			$query = $this->query($q);
			$parent = $query->fetch_assoc();
		}
		return $parent;
	}
	
	/**
	
	*/
	function getFilterOption($filterId){
		//print_r($array);
		$array = explode(",", $array);
		$q = "SELECT * FROM `filters` WHERE `id`='$filterId' ";
		$query = $this->query($q);
		$parent = $query->fetch_assoc();
		//echo "<pre>"; print_r($parent); echo "</pre>";
		//**************************
		$q = "SELECT * FROM `filters` WHERE `parent`='$parent[id]' AND `link`='$array[1]' ";
		$query = $this->query($q);
		$parent = $query->fetch_assoc();
		$parentId = $parent['id'];
		//**************************
		$q = "SELECT * FROM `filters` WHERE `parent`='$parent[id]' AND `link`='$array[2]' ";
		$query = $this->query($q);
		$filter = $query->fetch_assoc();
		$itemId = $filter['id'];
		//**************************
		$config = json_decode($filter['config'], true);
		$filter['filtertype'] = $config['filtertype'];
		$filter['datatype'] = $config['datatype'];
		$filter['fieldname'] = $config['fieldname'];
		$filter['tablename'] = $config['tablename'];
		$filter['config'] = $config;
		$filter['isprev'] = $config['isprev'];
		print_r($config);
		//**************************
		//print_r($filter);
		$filter['fields'] = $this->getFilterFields($filter['tablename'], $filter['datatype'], $parentId, $itemId);
		//print_r($fields);
		return $filter;
	}
	
	/**
	
	*/
	function getFilterClass($filterId){
		$q = "SELECT * FROM `filters` WHERE `id`='$filterId' ";
		$query = $this->query($q);
		$filter = $query->fetch_assoc();
		$config = json_decode($filter['config'], true);
		//$filter['filtertype'] = $config['filtertype'];
		//$filter['datatype'] = $config['datatype'];
		//$filter['fieldname'] = $config['fieldname'];
		//$filter['tablename'] = $config['tablename'];
		$filter['config'] = $config;
		$filter['fields'] = $this->getFilterFields($filter['tablename'], $filter['parent'], $filter['id']);
		return $filter;
	}
	
	/**
	
	*/
	function getFilterFields($table, $parentId, $itemId){
		if($table==''){
			return false;
		}
		//echo "<pre>$table, $datatype, $parentId, $itemId</pre>";
		$q = "SHOW FIELDS FROM `$table` ";
		echo "<pre>$q</pre>";
		$query = $this->query($q);
		$return = array();
		while($field=$query->fetch_assoc()){
			echo "<pre>"; print_r($field); echo "</pre>";
			if($datatype=='int'){
				if(preg_match("/^int/", $field['Type'])){
					$return[] = $field['Field'];
				}
			}elseif($datatype=='double'){
				if(preg_match("/^double/", $field['Type'])){
					$return[] = $field['Field'];
				}
			}elseif($datatype=='varchar'){
				if(preg_match("/^varchar/", $field['Type'])){
					$return[] = $field['Field'];
				}
			}elseif($datatype=='text'){
				if(preg_match("/^text/", $field['Type'])){
					$return[] = $field['Field'];
				}
			}
		}
		return $return;
	}
	
	/**
	
	*/
	function testFieldIsNoDeafault($field){
		foreach($this->defaultIndexes as $index){
			if($index==$field){
				return false;
			}elseif(preg_match("/_[a-z]{3}$/", $field)){
				foreach($GLOBALS['languages'] as $lang=>$lango){
					if($GLOBALS['language']!=$lang){
						if($field == $index."_".$lang){
							return false;
						}
					}
				}
			}
		}
		return true;
	}
	
	/**
	
	*/
	function getFilterFieldsUse($fieldName, $parentId, $itemId){
		$q = "SELECT * FROM `filters` WHERE `parent`='$parentId' ORDER BY `prior` ASC ";
		$query = $this->query($q);
		while($filter = $query->fetch_assoc()){
			if($filter['id']!=$itemId){
				$config = json_decode($filter['config'], true);
				//echo "<pre>"; print_r($config); echo "</pre>";
				if($config['fieldname']==$fieldName){
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	
	*/
	function saveFilterField($array){
		//if(!$array['fieldId']){
		//	$q = "INSERT INTO `filters` ";
		//	$q .= "(parent) VALUES ($array[]) ";
		//}
		$q = "UPDATE `filters` SET %data% WHERE `id`='$array[fieldId]' ";
		//print_r($array);
		$data = "`name`='$array[fieldName]', ";
		$data .= "`link`='$array[fieldDBName]', ";
		$data .= "`datatype`='$array[fieldDataType]', ";
		$data .= "`datalength`='$array[fieldDataLength]', ";
		$data .= "`datadefault`='$array[fieldDataDefault]', ";
		$data .= "`tmp`='0', ";
		
		$data = preg_replace("/, ?$/", "", $data);
		$q = str_replace("%data%", $data, $q);
		//echo $q;
		$query = $this->query($q);
		if($query){
			return "{\"return\":\"ok\"}";
		}
		return "{\"return\":\"false\"}";
	}
	
	/**
	
	*/
	function saveFilterClass($array){
		$foo = false;
		//print_r($array);
		if($array['filterId']){
			if(is_array($GLOBALS['languages'])){ foreach($GLOBALS['languages'] as $key=>$lang){
				if($GLOBALS['language']==$key){
					$q  = "UPDATE `filters` SET `name`='$array[filterName]', `link`='$array[filterLink]', `inFilter`='$array[filterInFilter]' WHERE `id`='$array[filterId]' ";
				}else{
					$q = "";
					foreach($array as $akey=>$avalue){
						$prega = "/_$key\$/";
						//echo "$prega\n";
						if(preg_match($prega, $akey)){
							//echo "$akey\n";
							$q  = "UPDATE `filters` SET `name_$key`='$array[$akey]' WHERE `id`='$array[filterId]' ";
						}
					}
				}
				if($q!=''){
					//echo $q."\n";
					$query = $this->query($q);
					if($query){
						$foo = true;
					}
				}
			}}
		}
		if($foo){
			return "{\"return\":\"ok\"}";
		}
		return "{\"return\":\"false\"}";
	}
	
	/**
	
	*/
	function addFilterOption($array){
		$q = "INSERT INTO `filters` (`name`, `parent`, `prior`, `link`) VALUES ('Новая опция', '$array[parent]', '5', 'newopt') ";
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function addFilterClass($array){
		$q = "SELECT * FROM `filters` ORDER BY `id` DESC LIMIT 0,1 ";
		$query = $this->query($q);
		$filter = $query->fetch_assoc();
		$filter['id'] += 1;
		$parent = $filter['id'];
		$q  = "INSERT INTO `filters` (`id`, `name`, `parent`, `prior`, `link`, `folder`) ";
		$q .= "VALUES ('$filter[id]', '$array[name]', '0', '5', 'filter-$filter[id]', '1') ";
		if($this->query($q)){
			//print_r($this->defaultShowIndexes);
			foreach($this->defaultShowIndexes as $key=>$index){
				$config = "{\"filtertype\":\"\",\"datatype\":\"1\",\"tablename\":\"$array[table]\",\"fieldname\":\"$index[0]\",\"isprev\":\"0\"}";
				$q  = "INSERT INTO `filters` (`name`, `parent`, `prior`, `link`, `folder`, `config`) ";
				$q .= "VALUES ('$index[1]', '$filter[id]', '".(($key+1)*10)."', '$index[0]', '0', '$config') ";
				if($index['0']!='price' && $index['0']!='content'){
					$this->query($q);
				}elseif($index['0']=='price' && $array['isPrice']=='1'){
					$this->query($q);
				}elseif($index['0']=='content' && $array['isContent']=='1'){
					$this->query($q);
				}
				echo "$q\n";
			}
		}
	}
	
	/**
	
	*/
	function deleteFilterFolder($folderId){
		$q = "SELECT * FROM `filters` WHERE `parent`='$folderId'   ";
		$query = $this->query($q);
		while($filter=$query->fetch_assoc()){
			$q = "DELETE FROM `filters` WHERE `id`='$filter[id]' ";
			$subQuery = $this->query($q);
		}
		$q = "DELETE FROM `filters` WHERE `id`='$folderId' ";
		$subQuery = $this->query($q);
	}
	
	/**
	
	*/
	function getFilterDataFromId($parent){
		$q = "SELECT * FROM `filters` WHERE `parent`='$parent' ORDER BY `prior` ASC ";
		$query = $this->query($q);
		while($filtero = $query->fetch_assoc()){
			//$filter['id'] = $filtero['id'];
			//$filter['name'] = $filtero['name'];
			//$filter['fieldName'] = $filtero['link'];
			$filters[] = $filtero;
		}
		//print_r($filters);
		return $filters;
	}
	
	/**
	
	*/
	function getFieldsFromTable($table){
		$q = "SHOW FIELDS FROM `$table` ";
		$query = $this->query($q);
		while($field=$query->fetch_assoc()){
			$fields[] = $field;
		}
		return $fields;
	}
	
	/**
	
	*/
	function addNewField($array){
		//print_r($array);
		//*****************************
		$fields = $this->getFieldsFromTable($array['table']);
		foreach($fields as $field){
			if($field['Field']==$array['field']){
				return "{\"return\":\"used\"}";
			}
		}
		//*****************************
		if($array['type']=='1'){
			$q = "ALTER TABLE  `$array[table]` ADD  `$array[field]` INT($array[length]) NOT NULL";
		}elseif($array['type']=='2'){
			$q = "ALTER TABLE  `$array[table]` ADD  `$array[field]` DOUBLE NOT NULL";
		}elseif($array['type']=='3'){
			$q = "ALTER TABLE  `$array[table]` ADD  `$array[field]` VARCHAR($array[length]) NOT NULL";
		}
		//echo $q;
		$query = $this->query($q);
		if($query){
			return "{\"return\":\"ok\"}";
		}else{
			return "{\"return\":\"error\"}";
		}
	}
	
	/**
	
	*/
	function deleteFilterOption($id){
		$query = $this->query("DELETE FROM `filters` WHERE `id`='$id' ");
	}
	
	/**
	
	*/
	function cloneTemplate($id){
		$query = $this->query("SELECT * FROM `filters` WHERE `id`='$id' ");
		$parent = $query->fetch_assoc();
		$query = $this->query("SELECT * FROM `filters` WHERE `parent`='$id' ");
		while($child = $query->fetch_assoc()){
			$children[] = $child;
		}
		//*******************
		$sql = "INSERT INTO `filters` ";
		$keys = '';
		$vals = '';
		$q = "SHOW FIELDS FROM `filters` ";
		$query = $this->query($q);
		while($field=$query->fetch_assoc()){
			if($field['Field']!='id'){
				$fields[] = $field;
				$keys .= "`$field[Field]`, ";
				if($field['Field']=='name'){
					$vals .= "'".($parent[$field['Field']])." копия', ";
				}elseif($field['Field']=='link'){
					$vals .= "'".($parent[$field['Field']])."-copy', ";
				}else{
					$vals .= "'".($parent[$field['Field']])."', ";
				}
			}
		}
		$keys = preg_replace("/, $/", '', $keys);
		$vals = preg_replace("/, $/", '', $vals);
		$sql = $sql." ($keys) VALUES ($vals)";
		//echo $sql."\n";
		$query = $this->query($sql);
		if(!$query){
			return false;
		}
		$query = $this->query("SELECT * FROM `filters` ORDER BY `id` DESC LIMIT 0,1 ");
		$newParent = $query->fetch_assoc();
		//*******************
		foreach($children as $child){
			$sql = "INSERT INTO `filters` ";
			$keys = '';
			$vals = '';
			foreach($fields as $field){
				if($field['Field']!='id'){
					$keys .= "`$field[Field]`, ";
					if($field['Field']=='parent'){
						$vals .= "'$newParent[id]', ";
					}else{
						$vals .= "'".($child[$field['Field']])."', ";
					}
				}
			}
			$keys = preg_replace("/, $/", '', $keys);
			$vals = preg_replace("/, $/", '', $vals);
			$sql = $sql." ($keys) VALUES ($vals)";
			echo $sql."\n---------------\n";
			$query = $this->query($sql);
		}
		//$query = $this->query("");
	}
	
	/**
	
	*/
	function testFilterUseFieldName($array){
		//print_r($array);
		if(!$array['parentId']){
			return "{\"return\":\"0\",\"elementId\":\"$array[elementId]\"}";
		}
		$q = "SELECT * FROM `filters` WHERE `parent`='$array[parentId]' ";
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
		return "{\"return\":\"$return\",\"elementId\":\"$array[elementId]\"}";
	}
	
	/**
	
	*/
	function testForConformance($array){
		$admin = new Admin();
		$table = $array['table'];
		$filter = $array['filter'];
		//********************
		$fields = $this->getFieldsFromTable($table);
		$templateFields = $this->getFilterDataFromId($filter);
		//print_r($fields);
		//print_r($templateFields);
		$errors = false;
		foreach($templateFields as $field){
			$toError = '1';
			$mass = false;
			foreach($fields as $tableField){
				if($field['link']==$tableField['Field']){
					$prega = "/^$tableField[Field](:|$)/";
					//echo "$field[link] -- совпало\n";
					$toError = '-1';
					//$mass = $field;
				}
			}
			if($toError=='1'){
				$field['conformance'] = '0';
				$errors[] = $field;
			}else{
				$field['conformance'] = '1';
				$errors[] = $field;
			}
		}
		print_r($errors);
		//echo "$table:$filter";
	}
	
	/**
	
	*/
	function getTablesForFilters($options){
		
	}
	
	
}

























?>