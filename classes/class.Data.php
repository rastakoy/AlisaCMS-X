<?php
class Data extends DatabaseInterface{
	
	/**
	
	*/
	function getOptionByName($name){
		$query = $this->query("SELECT * FROM `menusettings` WHERE `link`='$name' ");
		if($query){
			if($query->num_rows == 1){
				return $query->fetch_assoc();
			}elseif($query->num_rows > 1){
				while($option = $query->fetch_assoc()){
					$options[] = $option;
				}
				return $option;
			}
		}
	}
	
	/**
	
	*/
	function getOptions($ignore=false){
		$q = "SELECT * FROM `menusettings` WHERE `active`='1' ORDER BY `prior` ASC ";
		if($ignore){
			$q = "SELECT * FROM `menusettings` ORDER BY `prior` ASC ";
		}
		$query = $this->query($q);
		while($option=$query->fetch_assoc()){
			$options[] = $option;
		}
		return $options;
	}
	
	/**
	
	*/
	function getParents($params, $option=false){
		$array = explode("->", is_array($params)?$params['parents']:$params);
		//echo "<pre>"; print_r($array); echo "</pre>";
		$parent = '0';
		$parents = array();
		foreach($array as $key=>$id){
			if($key>0){
				if($option){
					$q = "SELECT * FROM `$option` WHERE `parent`='$parent' AND `id`='$id' ";
				}else{
					$q = "SELECT * FROM `$params[option]` WHERE `parent`='$parent' AND `id`='$id' ";
				}
				//echo $q."<br/>";
				$query = $this->query($q);
				if($query){
					$item = $query->fetch_assoc();
					$parent = $item['id'];
					$parents[] = $item;
				}
			}
		}
		return $parents;
	}
	
	/**
	
	*/
	function getExternalParents($params){
		$array = explode("->", $params['parents']);
		//echo "<pre>"; print_r($array); echo "</pre>";
		$parent = '0';
		$parents = array();
		foreach($array as $key=>$id){
			if($key>0){
				//$q = "SELECT * FROM `$params[option]` WHERE `parent`='$parent' AND `id`='$id' ";
				//echo $q."<br/>";
				//$query = $this->query($q);
				//if($query){
				//	$item = $query->fetch_assoc();
				//	$parent = $item['id'];
				//	$parents[] = $item;
				//}
				$item = $this->getExternalItem($params['option'], $id, $langPrefix='');
				$parents[] = $item['0'];
			}
		}
		return $parents;
	}
	
	/**
	
	*/
	function isExternal($optionName){
		$q = "SELECT * FROM `menusettings` WHERE `link`='$optionName' ";
		$query = $this->query($q);
		$option = $query->fetch_assoc();
		if($option['external']==1){
			return true;
		}
		return false;
	}
	
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
	function getItems($tableName, $parent='0', $folder=true, $url=false){
		if(preg_match("/\/editItem\/[0-9]{1,12}\/$/", $url, $matches)){
			//echo "matches = $matches[0]:::";
			$edited = $matches['0'];
			$url = preg_replace("/\/editItem\/[0-9]{1,12}\/$/", "/", $url);
			//echo "url=$url";
			//unset($url[count($url)-1]);
			//print_r($url);
		}
		if($folder && !is_array($parent)){
			$q = "SELECT * FROM `$tableName` WHERE `parent`='$parent' AND `folder`='1' ORDER BY `prior` ASC ";
		}elseif(is_array($parent) && count($parent)>'1'){
			$parentNotice = $this->getNoticeFromLink($parent);
			$q = "SELECT * FROM `$tableName` WHERE `parent`='$parentNotice[id]'  ORDER BY `prior` ASC ";
		}elseif(is_array($parent) && count($parent)=='1'){
			$q = "SELECT * FROM `$tableName` WHERE `parent`='0' ORDER BY `prior` ASC ";
			$parent = '0';
		}else{
			$q = "SELECT * FROM `$tableName` WHERE `parent`='$parent' ORDER BY `prior` ASC ";
		}
		//echo $q;
		$query = $this->query($q);
		while($option=$query->fetch_assoc()){
			$option['children'] = $this->testItemForChildren($tableName, $option['id'], '1');
			$option['parents'] = $this->getParentsWay($tableName, $option['id']);
			$option['includeComments'] = $this->hasComments($tableName, $option);
			$option['tumb'] = $this->getImages($tableName, $option['id']);
			//echo $url."\n";
			//echo "optionName=$tableName:::".$option['href']."\nurl=$url\n";
			$prega = "/".str_replace("/", "\\/", $option['href'])."/";
			//echo "prega=$prega\n";
		//	if(preg_match($prega, $url) && $option['children']>0){
		//		//echo "prega=$prega\n";
		//		$option['openBranch'] = $this->getItems($tableName, $option['id'], true, $url);
		//	}else{
				$option['openBranch'] = false;
		//	}
			//echo $notice['href'];
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
	function testItemForChildren($tableName, $parent, $folder='0'){
		if($folder=='1'){
			$folder = " AND `folder`='1' ";
		}elseif($folder='2'){
			$folder = " AND `folder`='0' ";
		}
		$q = "SELECT * FROM `$tableName` WHERE `parent`='$parent' $folder ORDER BY `prior` ASC ";
		$query = $this->query($q);
		if($query){
			return $query->num_rows;
		}else{
			return '0';
		}
	}
	
	/**
	
	*/
	function getParentsWay($tableName, $parent, $href=''){
		if($parent=='0' || $parent==''){
			return '0'.$href;
		}
		$q = "SELECT * FROM `$tableName` WHERE `id`='$parent' ";
		//echo $q."<br/>";
		$query = $this->query($q);
		$item = $query->fetch_assoc();
		//echo "<pre>"; print_r($notice); echo "</pre>";
		$href = '->'.$item['id'].$href;
		return $this->getParentsWay($tableName, $item['parent'], $href);
	}
	
	/**
	
	*/
	function getImages($table, $parent){
		$q = "SELECT * FROM `images` WHERE `externalId`='$parent' AND `table`='$table' ORDER BY `prior` ASC ";
		$query = $this->query($q);
		while($image=$query->fetch_assoc()){
			$images[] = $image;
		}
		return $images;
	}
	
	/**
	
	*/
	function constructTitles($str, $parents=false){
		//echo "STR=".$str."<br/>";
		$admin = new Admin();
		$str = trim($str);
		$array = explode(":", $str, 4);
		$titleType = $array['0'];
		if($titleType=='catalog' || $titleType=='single'){
			$array = explode("\n", $array['1']);
			foreach($array as $key=>$value){
				$value = explode("->", $value);
				$array[$key] = $value;
			}
			return array((($titleType=='catalog')?"catalog":"single"), $array);
		//************************************
		}elseif($array['0']=='static'){
			$gArray = $array;
			$array = explode("\n", $array['1']);
			foreach($array as $key=>$value){
				$value = trim($value);
				if($value!=""){
					$value = explode("->", $value);
					$array[$key] = $value;
				}
			}
			//echo "<pre>"; print_r($parents); echo "</pre>";
			if($gArray['2']=='rules'){
				$arr = iconv("CP1251", "UTF-8", $gArray['3']);
				$arr = json_decode($arr, true);
				$arr = $admin->iconvArray($arr);
				if(is_array($parents)){ foreach($parents as $parent){
					foreach($arr as $key=>$value){
						//echo "$key==$parent[id]";
						if($key==$parent['id']){
							$arr2 = $value;
						}
					}
				}}
				if(is_array($arr2)){
					foreach($arr2 as $key=>$value){
						$value = trim($value);
						if($value!=""){
							$value = explode("->", $value);
							$arr2[$key] = $value;
						}
					}
					return array("static", $arr2);
				}
			}
			return array("static", $array);
		//************************************
		}else{
			$array = explode("\n", $array['0']);
			foreach($array as $key=>$value){
				$value = explode("->", $value);
				$array[$key] = $value;
			}
			return $array;
		}
		
	}
	
	/**
	
	*/
	function getExternalOptions($optionName, $parent='0', $folder='', $order='prior', $orderType='asc'){
		$externalData = new ExternalData();
		$admin = new Admin();
		$params['optionName'] = $optionName;
			$params['table'] = $optionName;
			if($folder=='1'){
				$params['params'] = array(
					"parent=$parent",
					"folder=1"
				);
			}elseif($folder=='2'){
				$params['params'] = array(
					"parent=$parent",
					"folder=0"
				);
			}else{
				$params['params'] = array(
					"parent=$parent"
				);
			}
			$params['order'] = 'name';
			$params['orderType'] = 'asc';
			//echo "PARAMS:"; print_r($params);
		$foo = $externalData->getData($params);
		//echo $foo;
		$foo = json_decode($foo, true);
		$foo = $admin->iconvArray($foo);
		//print_r($foo);
		$data['data'] = $foo['data'];
		$data['option'] = $optionName;
		if(is_array($data['data'])){ foreach($data['data'] as $key=>$item){
			//$item['href'] = "itemId_".$item['id'];
			$item['parents'] = $this->getExternalParentsLink($optionName, $item['id']);
			$item['children'] = $this->testExternalBranchForChildren($optionName, $item['id'], '1');
			$data['data'][$key] = $item;
			$data['parent'] = $parent;
		}}
		//echo "<pre>"; print_r($data); echo "</pre>";
		//echo "name=".$data[0]['name']."\n";
		//echo "folder=".$data[0]['folder']."\n";
		//echo "link=".$data[0]['link']."\n";
		//echo "id=".$data[0]['id']."\n";
		return $data;
	}
	
	/**
	
	*/
	function getExternalParentsLink($optionName, $parent, $href=''){
		if($parent=='0' || $parent==''){
			return "0".$href;
		}
		//******************************
		$externalData = new ExternalData();
		$admin = new Admin();
		//******************************
		$params['table'] = $optionName;
		$params['params'] = array("id=$parent");
		$foo = $externalData->getData($params);
		$foo = json_decode($foo, true);
		$item = $foo['data']['0'];
		//echo "test"; print_r($item);
		//echo "itemId_".$item['id']."/".$href."\n";
		$href = "->".$item['id'].$href;
		return $this->getExternalParentsLink($optionName, $item['parent'], $href);
	}
	
	/**
	
	*/
	function testExternalBranchForChildren($optionName, $parent, $folder='0'){
		$externalData = new ExternalData();
		$admin = new Admin();
		//******************************
		$params['table'] = $optionName;
		if($folder=='1'){
			$params['params'] = array(
				"parent=$parent",
				"folder=1"
			);
		}elseif($folder=='2'){
			$params['params'] = array(
				"parent=$parent",
				"folder=0"
			);
		}else{
			$params['params'] = array(
				"parent=$parent"
			);
		}
		$foo = $externalData->getData($params);
		//echo $foo;
		$foo = json_decode($foo, true);
		//print_r($foo);
		$foo = $admin->iconvArray($foo);
		if($foo['count']){
			return $foo['count'];
		}else{
			return '0';
		}
	}
	
	/**
	
	*/
	function getExternalItem($optionName, $id, $langPrefix=''){
		$externalData = new ExternalData();
		$admin = new Admin();
		//******************************
		$params['table'] = $optionName;
		$params['params'] = array(
			"id=$id"
		);
		$foo = $externalData->getData($params);
		//echo $foo;
		$foo = json_decode($foo, true);
		$foo = $admin->iconvArray($foo);
		return $foo['data'];
	}
	
	/**
	
	*/
	function getItemFilter($parents, $table=''){
		if(!is_array($parents)){
			return false;
		}
		rsort($parents);
		foreach($parents as $parent){
			if($parent['filter']!='0'){
				$q = "SELECT * FROM `filters` WHERE `id`='$parent[filter]' ";
				$query = $this->query($q);
				if($query){
					return $query->fetch_assoc();
				}
			}
		}
		$q = "SELECT * FROM `menusettings` WHERE `link`='$table' ";
		$query = $this->query($q);
		$menu = $query->fetch_assoc();
		if($menu['filter']){
			$q = "SELECT * FROM `filters` WHERE `id`='$menu[filter]' ";
			$query = $this->query($q);
			if($query){
				return $query->fetch_assoc();
			}
		}
		return false;
	}
	
	/**
	
	*/
	function saveItem($array){
		//print_r($array);
		if($array['parents']){
			if($array['parent']){
				$array['parents'] = $this->getParentsWay($array['option'], $array['parent']);
			}
			$parent = explode("->", $array['parents']);
			$parent = $parent[count($parent)-1];
			if(!$array['parent']){
				$array['parent'] = $parent;
			}
			$parents = $array['parents'];
			unset($array['parents']);
		}
		if($array['optionExternal']=='1'){
			return $this->saveExternalItem($array);
		}else{
			if(!$array['id']){
				$q  = "INSERT INTO `$array[option]` (`name`, `link`, `parent`, `visible`, `folder`, `addDate`) VALUES ";
				$q .= " ('$array[name]', '$array[link]', '$array[parent]', '$array[visible]', '0', '".date('Y-m-d H:i:s')."' ) ";
				//echo $q."\n\n";
				$query = $this->query($q);
				$q = "SELECT * FROM `$array[option]` ORDER BY `id` DESC LIMIT 0,1 ";
				//echo "MY: ".$q."\n";
				$query = $this->query($q);
				$item = $query->fetch_assoc();
				$q = "UPDATE `$array[option]` SET `tmp`='1', `visible`='1' WHERE `id`='$item[id]' ";
				$query = $this->query($q);
			}else{
				//echo $array['option']."\n\n";
				$item['id'] = $array['id'];
				$item['parent'] = $array['parent'];
				if($array['option']){
					$DBkeys = $this->getTableKeys($array['option']);
					//print_r($DBkeys);
					$langPrefix = $array['lang'];
					//*********************************
					$sql = "UPDATE `$array[option]` SET ";
					foreach($array as $key=>$value){
						if($key!='lang' && $key!='id' && $key!='option' && $key!='ajax' && $key!='parents'){
							$foo = true;
							foreach($DBkeys as $field){ $prega = "/$key$langPrefix\$/"; if(preg_match($prega, $field['Field'], $matches)){
								$asql .= ", `$key$langPrefix`='$value'";
								$foo = false;
							}}
							if($foo){
								$asql .= ", `$key`='$value'";
							}
						}
					}
					$asql .= ", `tmp`='0'";
					if($array['parent']){
						$query = $this->query("SELECT * FROM `$array[option]` WHERE `id`='$array[parent]' ");
						$parentFolder = $query->fetch_assoc();
						if($parentFolder['letters']){
							$asql .= ", `letters`='$parentFolder[letters]'";
						}
					}
					$asql = preg_replace("/^,/", '', $asql);
					$sql .= $asql." WHERE `id`='$item[id]' ";
					$asql = "";
					//echo $sql."\n";
					$query = $this->query($sql);
					//*********************************
					if(!$query){
						$option = $this->getOptionByName($array['option']);
						return "{\"error\":\"1\",\"filterId\":\"$option[filter]\",\"parents\":\"$parents\",\"itemId\":\"$item[id]\",\"option\":\"$array[option]\"}";
					}
				}
			}
			return "{\"parents\":\"$parents\",\"itemId\":\"$item[id]\",\"option\":\"$array[option]\"}";
		}
	}
	
	/**
	
	*/
	function setNewItemParent($array){
		$parent = $array['parent'];
		$table = $array['table'];
		print_r($array);
		//$query = $this->query("UPDATE `$array[table]` SET `parent`='$array[newParent]' WHERE `id`=$array[itemId] ");
		//$query = $this->query("SELECT * FROM `$array[table]` WHERE `id`='$array[parent]' ");
		//$parent = $query->fetch_assoc();
		//$query = $this->query("UPDATE `$array[table]` SET `letters`='$parent[letters]' WHERE `id`=$array[itemId] ");
		$parents = $array['parents'];
		$parents = explode("->", $parents);
		foreach($parents as $par){
			if($par==$array['oldParent']){
				$new[] = $array['parent'];
			}else{
				$new[] = $par;
			}
		}
		$parents = implode("->", $new);
		echo $parents;
		//$return['parents']
		//print_r($parent);
	}
	
	/**
	
	*/
	function getTableKeys($table){
		$query = $this->query("SHOW FIELDS FROM `$table`");
		while($field=$query->fetch_assoc()){
			$fields[] = $field;
		}
		return $fields;
	}
	
	/**
	
	*/
	function setLetters($id, $parent, $table){
		$lettersArray = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		$prefix = '';
		$query = $this->query("SELECT * FROM `$table` WHERE `folder`='1' AND `parent`='$parent' ORDER BY `letters` DESC LIMIT 0,1 ");
		$folder = $query->fetch_assoc();
		$letters = $folder['letters'];
		if($folder['parent']!='0'){
			$query = $this->query("SELECT * FROM `$table` WHERE `id`='$folder[parent]' ");
			if($query->num_rows > 0){
				$parentFolder = $query->fetch_assoc();
			}
		}
		if((!$letters || $letters=='') && !$parentFolder){
			$letters = "AAA";
			$q = "UPDATE `$table` SET `letters`='$letters' WHERE `id`='$id' ";
			echo $q;
			$query = $this->query($q);
		}elseif(!$letters && $parentFolder['letters']!=''){
			$letters = $parentFolder['letters']."AAA";
			$q = "UPDATE `$table` SET `letters`='$letters' WHERE `id`='$id' ";
			echo $q;
			$query = $this->query($q);
		}elseif($letters!=''){
			echo "letters=".$letters."\n";
			preg_match("/[A-Z]{3}$/", $letters, $matches);
			$prefix1 = preg_replace("/[A-Z]{3}$/", '', $letters);
			$prefix2 = $matches['0'];
			echo "prefix1 = $prefix1\n";
			echo "prefix2 = $prefix2\n";
			$count_1=0;
			$count_2=0;
			$count_3=0;
			foreach($lettersArray as $key_1=>$letter_1){
				foreach($lettersArray as $key_2=>$letter_2){
					foreach($lettersArray as $key_3=>$letter_3){
						$foo = $lettersArray[$key_1].$lettersArray[$key_2].$lettersArray[$key_3];
						if($foo==$prefix2){
							$count_1=$key_1;
							$count_2=$key_2;
							$count_3=$key_3;
							break;
						}
					}
				}
			}
			//***************************************************
			echo "$count_1:$count_2:$count_3\n";
			$count_3++;
			if($count_3 >= count($lettersArray)-1){
				$count_3 = '0';
				$count_2++;
				if($count_2 >= count($lettersArray)-1){
					$count_2 = '0';
					$count_1++;
				}
			}
			echo "$count_1:$count_2:$count_3\n";
			$foo = $lettersArray[$count_1]."-".$lettersArray[$count_2]."-".$lettersArray[$count_3];
			echo "foo = $foo\n";
			$foo = $prefix1.$lettersArray[$count_1].$lettersArray[$count_2].$lettersArray[$count_3];
			echo "foo = $foo\n";
			$q = "UPDATE `$table` SET `letters`='$foo' WHERE `id`='$id' ";
			echo $q."\n";
			$query = $this->query($q);
		}
	}
	
	/**
	
	*/
	function saveNewFolder($array){
		//print_r($array);
		//echo "saveNewLeftMenuFolder";
		if($array['optionExternal']=='1'){
			return $this->saveExternalFolder($array);
		}else{
			if($array['option']=="filters"){
				$q  = "INSERT INTO `$array[option]` (`name`, `link`, `parent`, `visible`, `folder`) VALUES ";
				$q .= " ('$array[name]', '$array[link]', '$array[parent]', '$array[visible]', '1' ) ";
			}else{
				$q  = "INSERT INTO `$array[option]` (`name`, `link`, `parent`, `visible`, `content`, `letters`, `folder`, `filter`) VALUES ";
				$q .= " ('$array[name]', '$array[link]', '$array[parent]', '$array[visible]', '$array[content]', '$array[letters]', '1', '$array[filter]' ) ";
			}
			//echo $q;
			$query = $this->query($q);
			$query = $this->query("SELECT * FROM `$array[option]` WHERE `folder`='1' ORDER BY `id` DESC LIMIT 0,1 ");
			$newFolder = $query->fetch_assoc();
			$this->setLetters($newFolder['id'], $newFolder['parent'], $array['option']);
			//$query = $this->query("SELECT * FROM `items` WHERE `parent`='$array[parent]' AND `folder`='1' ORDER BY `letters` DESC LIMIT 0,1 ");
			
		}
	}
	
	/**
	
	*/
	function saveFolder($array){
		$query = $this->query("SELECT * FROM `menusettings` WHERE link='$array[option]' LIMIT 0,1 ");
		$option = $query->fetch_assoc();
		$lang = $array['lang'];
		$q  = "UPDATE `$array[option]` SET `name$lang`='$array[name]', `link`='$array[link]', `visible`='$array[visible]', ";
		$q .= "`parent`='$array[parent]', ";
		if($option['usetext']=='1'){
			$q .= "`content$lang`='$array[content]', ";
		}
		if($option['useletters']=='1'){
			$q .= "`letters`='$array[letters]', ";
		}
		if($option['usetemplate']){
			$q .= "`filter`='$array[filter]' ";
		}
		$q .= "WHERE `id`='$array[id]' ";
		$q = preg_replace("/, ? ? ?WHERE/", " WHERE", $q);
		echo $q;
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function getFolder($id, $table){
		$query = $this->query("SELECT * FROM `$table` WHERE `id`='$id' AND `folder`='1' ");
		$folder = $query->fetch_assoc();
		$folder['tumb'] = $this->getImages($table, $folder['id']);
		return $folder;
	}
	
	/**
	
	*/
	function savePriors($array){
		$sprior = 10;
		$mass = explode(",", $array['ids']);
		$pid = false;
		//print_r($mass);
		foreach($mass as $k=>$v){
			//echo preg_replace("/li_images_sort_/", "", $v)."<br/>\n";
			$v =  preg_replace("/prm_/", "", $v);
			if($v!="ok"){
				if($sprior==10){
					if(preg_match("/^[0-9]*$/", $v)){
						$qu = "SELECT * FROM `$array[table]` WHERE `id`='$v' AND `parent`='$array[parent]' ";
					}else{
						$qu = "SELECT * FROM `$array[table]` WHERE `link`='$v' AND `parent`='$array[parent]' ";
					}
					//echo $qu;
					$query = $this->query($qu);
					$row = $query->fetch_assoc();
					$pid = $row["parent"];
				}
				if(preg_match("/^[0-9]*$/", $v)){
					$q = "UPDATE `$array[table]` SET `prior`='$sprior' WHERE `id`='$v' AND `parent`='$array[parent]' ";
				}else{
					$q = "UPDATE `$array[table]` SET `prior`='$sprior' WHERE `link`='$v' AND `parent`='$array[parent]' ";
				}
				//echo $q."\n";
				$query = $this->query($q);
				$sprior += 10;
			}
		}
	}
	
	/**
	
	*/
	function toggleData($array){
		if(!isset($array['value'])){
			$q = "SELECT * FROM `$array[option]` WHERE `id`='$array[itemId]' ";
			$query = $this->query($q);
			$item = $query->fetch_assoc();
			if($item[$array['field']]=='1'){
				$value = '0';
			}else{
				$value = '1';
			}
		}else{
			$value = $array['value'];
		}
		$q = "UPDATE `$array[option]` SET `$array[field]`='$value' WHERE `id`='$array[itemId]' ";
		echo $q;
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function getAllFoldersTree($array){
		$parent = $array['parent'];
		$table = $array['table'];
		$folders = array();
		$q = "SELECT * FROM `$table` WHERE `folder`='1' AND `parent`='$parent' ORDER BY `prior` ASC ";
		if($array['visible']=='1'){
			$q = "SELECT * FROM `$table` WHERE `folder`='1' AND `parent`='$parent' AND `visible`='1' ORDER BY `prior` ASC ";
		}
		//echo $q."\n";
		$query = $this->query($q);
		if($query){
			while($folder=$query->fetch_assoc()){
				$array['parent'] = $folder['id'];
				if($folder['id']==$array['folderId']){
					$folder['selected'] = '1';
				}
				$folder['children'] = $this->getAllFoldersTree($array);
				if(count($folder['children'])<1){
					unset($folder['children']);
				}
				//print_r($folder);
				$folders[] = $folder;
			}
		}
		//if($array['parent']=='0'){
		//	print_r($folders);
		//}
		return $folders;
	}
	
	/**
	
	*/
	function hasComments($tableName, $item){
		$q = "SELECT * FROM `menusettings` WHERE `link`='$tableName' ";
		$query = $this->query($q);
		if(!$query) return '0';
		$option = $query->fetch_assoc();
		if($option['comments']=='0') return '0';
		if($item['folder']=='1'){
			$q = "SELECT * FROM `comments` WHERE `option`='$tableName' AND `letters` LIKE('$item[letters]%') ";
		}else{
			$q = "SELECT * FROM `comments` WHERE `option`='$tableName' AND `parent`='$item[id]' ";
		}
		//echo $q."\n";
		$query = $this->query($q);
		if($query){
			if($query->num_rows>0){
				return '1';
			}else{
				return '0';
			}
		}else{
			return '0';
		}
	}
	
	/**
	
	*/
	//function foo($array){
	//	
	//}
	
}















?>