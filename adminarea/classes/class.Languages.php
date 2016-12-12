<?php
class Languages extends DatabaseInterface{
	
	public $defaultIndexes = array(
		"filters=>link",
		"filters=>type",
		"filters=>config",
		
		"pages=>link",
		"pages=>site",
		
		"notices=>hash"
	);
	
	/**
	
	*/
	function sortLanguages($languages){
		$languages = explode(",", preg_replace("/divLang_/", "", $languages));
		//print_r($languages);
		$langs = "";
		foreach($languages as $lang){
			$langs .= $lang."-".$GLOBALS['languages'][$lang]['0']."-".$GLOBALS['languages'][$lang]['1'].",";
		}
		$langs = preg_replace("/,$/", '', $langs);
		$query = $this->query("UPDATE `settings` SET `value`='$langs' WHERE `arrayName`='languages' ");
	}
	
	/**
	
	*/
	function getDataBases($options, $selLang){
		//echo "<pre>"; print_r($options); echo "</pre>";
		$return = array();
		foreach($options as $option){
			$q = "SHOW FIELDS FROM `$option[link]` ";
			//echo $q."<br/>";
			$query = $this->query($q);
			if($query){
				while($field=$query->fetch_assoc()){
					if( preg_match("/^varchar/", $field['Type']) || preg_match("/^text/", $field['Type']) ){
						$foo = false;
						foreach($GLOBALS['languages'] as $lang=>$lango){
							$prega = "/_$lang$/";
							if(preg_match($prega, $field['Field'])){
								$foo = true;
							}
						}
						if(!$foo && !$this->testFieldIsDeafault($option['link'], $field['Field'])){
							$field['hasLang'] = '1';
							$field['currentLang'] = $selLang;
							if($this->testFieldIsOff($option['link'], $field['Field'], $selLang)){
								$field['hasLang'] = '0';
							}
							$return[$option['link']][] = $field;
							//echo "<pre>"; print_r($field); echo "</pre>";
						}
					}
				}
			}
		}
		return $return;
	}
	
	/**
	
	*/
	function addLanguageField($table, $lang, $myField){
		$q = "SHOW FIELDS FROM `$table` WHERE `Field`='$myField' ";
		$query = $this->query($q);
		$field=$query->fetch_assoc();
		//print_r($field);
		$q = "ALTER TABLE  `$table` ADD  `".$myField."_".$lang."` $field[Type] NOT NULL AFTER  `$myField`";
		//echo $q;
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function deleteLanguageField($table, $lang, $myField){
		$q = "ALTER TABLE `$table` DROP `".$myField."_".$lang."`";
		//echo $q;
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function deleteLanguageFields($myLang, $array){
		//print_r($array);
		foreach($array as $table=>$fields){
			foreach($fields as $field){
				$q = "ALTER TABLE `$table` DROP `".$field['Field']."_".$myLang."`";
				$query = $this->query($q);
			}
		}
	}
	
	/**
	
	*/
	function saveLanguageField($myLang, $langs){
		$q = "SELECT * FROM `settings` WHERE `arrayName`='languages' ";
		$query = $this->query($q);
		$item = $query->fetch_assoc();
		$item = $item['value'];
		//echo $item;
		$item = explode(",", $item);
		foreach($item as $lang){
			$lang = explode("-", $lang);
			if($lang['0']==$myLang){
				$array[$langs['0']] = array($langs['1'], $langs['2']);
			}elseif($lang['0']!=$myLang){
				$array[$lang['0']] = array($lang['1'], $lang['2']);
			}
		}
		//print_r($array);
		$str = "";
		foreach($array as $key=>$lang){
			$str .= $key."-".$lang['0']."-".$lang['1'].",";
		}
		$str = preg_replace("/,$/", '', $str);
		//echo $str;
		$q = "UPDATE `settings` SET `value`='$str' WHERE `arrayName`='languages' ";
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function addNewLanguage(){
		$q = "SELECT * FROM `settings` WHERE `arrayName`='languages' ";
		$query = $this->query($q);
		$item = $query->fetch_assoc();
		$item = $item['value'];
		$value = $item.",new-new-newLanguage";
		$q = "UPDATE `settings` SET `value`='$value' WHERE `arrayName`='languages' ";
		//echo $q;
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function deleteLanguage($myLang){
		if($myLang==$GLOBALS['language']){
			return false;
		}
		$q = "SELECT * FROM `settings` WHERE `arrayName`='languages' ";
		$query = $this->query($q);
		$item = $query->fetch_assoc();
		$item = $item['value'];
		//echo $item;
		$item = explode(",", $item);
		foreach($item as $lang){
			$lang = explode("-", $lang);
			if($lang['0']!=$myLang){
				$array[$lang['0']] = array($lang['1'], $lang['2']);
			}
		}
		//print_r($array);
		$str = "";
		foreach($array as $key=>$lang){
			$str .= $key."-".$lang['0']."-".$lang['1'].",";
		}
		$str = preg_replace("/,$/", '', $str);
		//echo $str;
		$q = "UPDATE `settings` SET `value`='$str' WHERE `arrayName`='languages' ";
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function testFieldIsDeafault($option, $field){
		//echo "<pre>"; print_r($this->defaultIndexes); echo "</pre>";
		foreach($this->defaultIndexes as $index){
			$index = explode("=>", $index);
			if($index['0']==$option && $index['1']==$field){
				return true;
			}
		}
		return false;
	}
	
	/**
	
	*/
	function testFieldIsOff($option, $aField, $selLang){
		$q = "SHOW FIELDS FROM `$option` ";
		//echo $q;
		$query = $this->query($q);
		while($field=$query->fetch_assoc()){
				if($field['Field']==$aField."_".$selLang){
					//echo $field['Field']."==".$aField."_".$lang."<br/>";
					return false;
				}
		}
		return true;
	}
	
	/**
	
	*/
	function getOptionByOptionName($options, $optionName){
		foreach($options as $option){ if($option['link']==$optionName){ return $option; } }
		return false;
	}

	
	
}
?>