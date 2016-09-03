<?php
class MenuSettings extends DatabaseInterface{
	
	/**
	
	*/
	function getMenu(){
		$options = array();
		$query = $this->query("SELECT * FROM `menusettings` WHERE `active`='1' ORDER BY `prior` ASC ");
        if($query)
		while($option=$query->fetch_assoc()){
			$options[] = $option;
		}
		return $options;
	}
	
	/**
	
	*/
	function getOptions($optionName, $parent='0', $folder=true, $url=false){
		if(preg_match("/\/editItem\/[0-9]{1,12}\/$/", $url, $matches)){
			//echo "matches = $matches[0]:::";
			$edited = $matches['0'];
			$url = preg_replace("/\/editItem\/[0-9]{1,12}\/$/", "/", $url);
			//echo "url=$url";
			//unset($url[count($url)-1]);
			//print_r($url);
		}
		if($folder && !is_array($parent)){
			$q = "SELECT * FROM `$optionName` WHERE `parent`='$parent' AND `folder`='1' ORDER BY `prior` ASC ";
		}elseif(is_array($parent) && count($parent)>'1'){
			$parentNotice = $this->getNoticeFromLink($parent);
			$q = "SELECT * FROM `$optionName` WHERE `parent`='$parentNotice[id]'  ORDER BY `prior` ASC ";
		}elseif(count($parent)=='1'){
			$q = "SELECT * FROM `$optionName` WHERE `parent`='0' ORDER BY `prior` ASC ";
			$parent = '0';
		}else{
			$q = "SELECT * FROM `$optionName` WHERE `parent`='$parent' ORDER BY `prior` ASC ";
		}
		echo $q;
		$query = $this->query($q);
		while($option=$query->fetch_assoc()){
			$option['children'] = $this->testBranchForChildren($optionName, $option['id'], '1');
			$option['href'] = $this->getHref($optionName, $option['id']);
			$option['tumb'] = $this->getImages($option['id'], $optionName);
			//echo $url."\n";
			//echo "optionName=$optionName:::".$option['href']."\nurl=$url\n";
			$prega = "/".str_replace("/", "\\/", $option['href'])."/";
			//echo "prega=$prega\n";
			if(preg_match($prega, $url) && $option['children']>0){
				//echo "prega=$prega\n";
				$option['openBranch'] = $this->getOptions($optionName, $option['id'], true, $url);
			}else{
				$option['openBranch'] = false;
			}
			//echo $notice['href'];
			$options[] = $option;
		}
		$return['data'] = $options;
		$return['option'] = $optionName;
		//print_r($options);
		return $return;
	}
	
	/**
	
	*/
	function getOptionById($optionName, $id){
		$q = "SELECT * FROM `$optionName` WHERE `id`='$id' ";
		//echo $q;
		$query = $this->query($q);
		$option = $query->fetch_assoc();
		return $option;
	}
	function getItemById($optionName, $id){
		$q = "SELECT * FROM `$optionName` WHERE `id`='$id' ";
		//echo $q;
		$query = $this->query($q);
		$option = $query->fetch_assoc();
		return $option;
	}
	
	/**
	
	*/
	function getOptionByLink($link){
		if(is_array($link)){
			$array = $link;
		}else{
			$array = explode("/", $link);
		}
		$parent = 0;
		$item = false;
		foreach($array as $key=>$link){
			if($key>0){
				$q = "SELECT * FROM `$array[0]` WHERE `parent`='$parent' AND `link`='$link' ";
				$query = $this->query($q);
				if($query){
					$item = $query->fetch_assoc();
					$parent = $item['id'];
				}
			}
		}
		return $item;
	}
	
	/**
	
	*/
	function getOptionsByLink($link){
		$array = explode("/", $link);
		$parent = 0;
		$parents = array();
		foreach($array as $key=>$link){
			if($key>0){
				$q = "SELECT * FROM `$array[0]` WHERE `parent`='$parent' AND `link`='$link' ";
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
	function testBranchForChildren($optionName, $parent, $folder='0'){
		if($folder=='1'){
			$folder = " AND `folder`='1' ";
		}elseif($folder='2'){
			$folder = " AND `folder`='0' ";
		}
		$q = "SELECT * FROM `$optionName` WHERE `parent`='$parent' $folder ORDER BY `prior` ASC ";
		$query = $this->query($q);
		if($query){
			return $query->num_rows;
		}else{
			return '0';
		}
	}
	
	/**
	
	*/
	function getHref($optionName, $parent, $href=''){
		if($parent=='0' || $parent==''){
			return $href;
		}
		$q = "SELECT * FROM `$optionName` WHERE `id`='$parent' ";
		//echo $q."<br/>";
		$query = $this->query($q);
		$item = $query->fetch_assoc();
		//echo "<pre>"; print_r($notice); echo "</pre>";
		$href = 'itemId_'.$item['id']."/".$href;
		return $this->getHref($optionName, $item['parent'], $href);
	}
	
	/**
	
	*/
	function deleteOptionFolder($optionName, $id){
		$option = $this->getOptionById($optionName, $id);
		$option['children'] = $this->testBranchForChildren($optionName, $id, '1');
		//print_r($option);
		$query = $this->query("SELECT * FROM `$optionName` WHERE `parent`='$option[id]' AND `folder`='0' ");
		while($item=$query->fetch_assoc()){
			$this->deleteOption($optionName, $item['id']);
		}
		$query = $this->query("SELECT * FROM `$optionName` WHERE `parent`='$option[id]' AND `folder`='1' ");
		while($folder=$query->fetch_assoc()){
			$this->deleteOptionFolder($optionName, $folder['id']);
		}
		$query = $this->query("DELETE FROM `$optionName` WHERE `id`='$option[id]' ");
	}
		
	/**
	
	*/
	function deleteOption($optionName, $id){
		if($optionName=='notices'){
			$classNotices = new Notices();
			$classNotices->deleteNoticeImages($id);
		}
		$query = $this->query("DELETE FROM `$optionName` WHERE `id`='$id' ");
		if($query){
			return "{\"return\":\"ok\"}";
		}else{
			return "{\"return\":\"false\"}";
		}
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
					$query = $this->query($qu);
					//echo $qu;
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
	function getImages($parent, $table){
		$q = "SELECT * FROM `images` WHERE `tableId`='$parent' AND `table`='$table' ORDER BY `prior` ASC ";
		$query = $this->query($q);
		while($image=$query->fetch_assoc()){
			$images[] = $image;
		}
		return $images;
	}
	
	/**
	
	*/
	function constructTitles($str){
		//echo "STR=".$str."<br/>";
		$array = explode(":", $str);
		if($array['0']!='catalog'){
			$array = explode("\n", $array['0']);
			foreach($array as $key=>$value){
				$value = explode("->", $value);
				$array[$key] = $value;
			}
			return $array;
		}else{
			$array = explode("\n", $array['1']);
			foreach($array as $key=>$value){
				$value = explode("->", $value);
				$array[$key] = $value;
			}
			return array("catalog", $array);
		}
		
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
	function getExternalHref($optionName, $parent, $href=''){
		if($parent=='0' || $parent==''){
			return $href;
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
		$href = "itemId_".$item['id']."/".$href;
		return $this->getExternalHref($optionName, $item['parent'], $href);
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
			$item['href'] = $this->getExternalHref($optionName, $item['id']);
			$item['children'] = $this->testExternalBranchForChildren($optionName, $item['id'], '1');
			$data['data'][$key] = $item;
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
	function getExternalItems($optionName, $parent='0', $folder='', $order='prior', $orderType='asc'){
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
		$data = $foo['data'];
		if(is_array($data)){ foreach($data as $key=>$item){
			$data[$key]['fullLink'] = $this->getExternalHref($optionName, $item['id']);
			$data[$key]['link'] = "itemId_".$item['id'];
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
	function getExternalItemsFromLink($url){
		$externalData = new ExternalData();
		$admin = new Admin();
		//******************************
		$parent = '0';
		$params['table'] = $url['0'];
		foreach($url as $key=>$link){
			$link = str_replace("itemId_", "", $link);
			if($key>0){
				$params['params'] = array(
					"id=$link",
					"parent=$parent"
				);
				$foo = $externalData->getData($params);
				//echo "foo=$foo";
				$foo = json_decode($foo, true);
				
				if($foo['result']=='true'){
					$item = $foo['data']['0'];
					$item = $admin->iconvArray($item);
					$item['fullLink'] = $this->getExternalHref($url['0'], $item['id']);
					$parents[] = $item;
					$parent = $item['id'];
				}
			}
		}
		return $parents;
	}
	
	/**
	
	*/
	function saveNewLeftMenuFolder($array){
		//print_r($array);
		//echo "saveNewLeftMenuFolder";
		if($array['optionExternal']=='1'){
			return $this->saveExternalFolder($array);
		}else{
			$q  = "INSERT INTO `catalog` (`name`, `link`, `parent`, `visible`, `content`, `letters`, `folder`, `filter`) VALUES ";
			$q .= " ('$array[name]', '$array[link]', '$array[parent]', '$array[visible]', '$array[content]', '$array[letters]', '1', '$array[filter]' ) ";
			echo $q;
			//$query = $this->query($q);
		}
	}
	
	/**
	
	*/
	function saveExternalFolder($array){
		$externalData = new ExternalData();
		$admin = new Admin();
		//******************************
		//print_r($array);
		if(!$array['id']){
			$params['action'] = 'addData';
			$params['table'] = $array['option'];
			$params['params'] = array(
				"name"=>$array['name'],
				"link"=>$array['link'],
				"parent"=>$array['parent'],
				"folder"=>1
			);
		}else{
			$params['action'] = 'editData';
			$params['table'] = $array['option'];
			$params['id'] = $array['id'];
			$params['lang'] = $array['lang'];
			$params['params'] = array(
				"name"=>$array['name'],
				"parent"=>$array['parent'],
				"folder"=>1
			);
			$params['where'] = array(
				"id=$array[id]"
			);
		}
		$params = $admin->iconvArray($params, "CP1251", "UTF-8");
		//******************************
		$foo = $externalData->editData($params);
		//echo $foo;
		return $foo;
	}
	
	/**
	
	*/
	function saveNewLeftMenuItem($array){
		//print_r($array);
		if($array['optionExternal']=='1'){
			return $this->saveExternalItem($array);
		}else{
			if(!$array['id']){
				$q  = "INSERT INTO `$array[option]` (`name`, `link`, `parent`, `visible`, `content`, `letters`, `folder`, `filter`, `addDate`) VALUES ";
				$q .= " ('$array[name]', '$array[link]', '$array[parent]', '$array[visible]', '$array[content]', '$array[letters]', '0', '$array[filter]', '".date('Y-m-d H:i:s')."' ) ";
				//echo $q."\n\n";
				$query = $this->query($q);
				$query = $this->query("SELECT * FROM `$array[option]` ORDER BY `id` DESC LIMIT 0,1 ");
				$item = $query->fetch_assoc();
				$q = "UPDATE `$array[option]` SET `tmp`='1' WHERE `id`='$item[id]' ";
				$query = $this->query($q);
			}else{
				echo $array['option']."\n\n";
				$item['id'] = $array['id'];
				$item['parent'] = $array['parent'];
				if($array['option']){
					$DBkeys = $this->getTableKeys($array['option']);
					//print_r($DBkeys);
					$langPrefix = $array['lang'];
					//*********************************
					$sql = "UPDATE `$array[option]` SET ";
					foreach($array as $key=>$value){
						if($key!='lang' && $key!='id' && $key!='option' && $key!='ajax'){
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
					$asql = preg_replace("/^,/", '', $asql);
					$sql .= $asql." WHERE `id`='$item[id]' ";
					$asql = "";
					//echo $sql."\n";
					$query = $this->query($sql);
					//*********************************
				}
			}
			return "{\"parent\":\"$item[parent]\",\"itemId\":\"$item[id]\"}";
		}
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
	function saveExternalItem($array){
		$externalData = new ExternalData();
		$admin = new Admin();
		//******************************
		//print_r($array);
		if(!$array['id']){
			$params['action'] = 'addData';
			$params['table'] = $array['option'];
			$params['params'] = array(
				"name"=>$array['name'],
				"link"=>$array['link'],
				"parent"=>$array['parent'],
				"folder"=>'0'
			);
		}else{
			$params['action'] = 'editData';
			$params['table'] = $array['option'];
			$params['id'] = $array['id'];
			$params['lang'] = $array['lang'];
			$params['params'] = array(
				"name"=>$array['name'],
				"parent"=>$array['parent'],
				"folder"=>'0'
			);
			$params['where'] = array(
				"id=$array[id]"
			);
		}
		$params = $admin->iconvArray($params, "CP1251", "UTF-8");
		//print_r($params);
		//******************************
		$foo = $externalData->editData($params);
		//echo $foo;
		return $foo;
	}
	
	/**
	
	*/
	function getExternalDefaults($config, $fields){
		//echo "<pre>"; print_r($config); echo "</pre>";
		//echo "<pre>"; print_r($fields); echo "</pre>";
		$externalData = new ExternalData();
		$admin = new Admin();
		//******************************
		$foo = explode(",", $config['externalSettings']['defaults']);
		foreach($foo as $key=>$value){
			$value = explode("=", $value);
			$foo[$key] = $value;
		}
		//echo "<pre>"; print_r($foo); echo "</pre>";
		//******************************
		$array = array();
		foreach($foo as $key=>$value){
			if($value['0']=="id"){
				$params['table'] = $config['myoption']['link'];
				$params['params'] = array("id=$value[1]");
				$json = $externalData->editData($params);
				$json = json_decode($json, true);
				$json = $admin->iconvArray($json['data']);
				//echo "<pre>"; print_r($json); echo "</pre>";
				$params['table'] = $config['myoption']['link'];
				$params['params'] = array("parent=".$json['0']['parent'], "folder=1");
				$params['order'] = 'name';
				$params['orderType'] = 'asc';
				$json = $externalData->editData($params);
				$json = json_decode($json, true);
				$json = $admin->iconvArray($json['data']);
				$foo[$key]['2'] = $json;
				//echo "<pre>"; print_r($json); echo "</pre>";
			}elseif($value['0']=="name"){
				foreach($fields as $field){
					if($field['default']=='0' && $field['config']['filtertype']=='8'  && $field['config']['fieldname']!=$config['fieldname']){
						$foo[$key]['2'][] = $field;
					}elseif($field['config']['fieldname']==$config['fieldname']){
						break;
					}
				}
			}
		}
		//echo "<pre>"; print_r($foo); echo "</pre>";
		return $foo;
	}
	
	/**
	
	*/
	function deleteObjectFromCatalog($table, $id){
		$query = $this->query("SELECT * FROM `images` WHERE `tableId`='$id' && `table`='$table' ");
		if($query){
			while($image=$query->fetch_assoc()){
				if(file_exists("../loadimages/$image[name]")){
					unlink("../loadimages/$image[name]");
				}
			}
			$squery = $this->query("DELETE FROM `images` WHERE `tableId`='$id' && `table`='$table' ");
			$squery = $this->query("DELETE FROM `$table` WHERE `id`='$id' ");
		}
	}
	

}








?>