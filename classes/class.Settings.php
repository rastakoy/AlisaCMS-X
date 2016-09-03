<?php
class Settings extends DatabaseInterface{
	
	/**
	
	*/
	function getSettings(){
		$q = "SELECT * FROM `settings` ORDER BY `prior` ASC ";
		//echo $q;
		$query = $this->query($q);
		while($setting=$query->fetch_assoc()){
			$settings[] = $setting;
		}
		return $settings;
	}
	
	/**
	
	*/
	function saveSettings($array){
		print_r($array);
		foreach($array as $key=>$value){
			if(preg_match("/^param_/", $key)){
				$id = preg_replace("/^param_/", "", $key);
				$q = "UPDATE `settings` SET `value`='$value', `arrayName`='".($array['index_'.$id])."' WHERE `id`='$id' ";
				echo $q."\n";
				$query = $this->query($q);
			}
		}
	}
	
	/**
	
	*/
	function parseSettings(){
		$q = "SELECT * FROM `settings` ORDER BY `prior` ASC ";
		$query = $this->query($q);
		if($query){
			while($setting=$query->fetch_assoc()){
				if($setting['arrayName']=='languages'){
					foreach(explode(",", $setting['value']) as $value ){
						$mass = explode("-", $value);
						$array = array();
						$array[] = $mass['1'];
						$array[] = $mass['2'];
						if($mass['3']=="off"){
							$array[] = "off";
						}
						$GLOBALS[$setting['arrayName']][$mass['0']] = $array;
					}
				}else{
					$GLOBALS[$setting['arrayName']] = $setting['value'];
				}
			}
		}
	}
	
}
?>