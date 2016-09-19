<?php
class Admin extends Core{

	/**
	
	*/
	function isAdmin($login, $password){
		$q = "SELECT * FROM `admins` WHERE `login`='$login' AND `password`='$password' ";
		//echo $q;
		$query = $this->query($q);
		if($query->num_rows=='1'){
			$admin = $query->fetch_assoc();
			if($login=='superadmin'){
				return $admin;
				//return 'superadmin';
			}else{
				return $admin;
				//return true;
			}
		}else{
			return false;
		}
	}
	
	/**
	
	*/
	function getAdmins(){
		$q = "SELECT * FROM `admins` WHERE `login`!='superadmin' ";
		$query = $this->query($q);
		while($admin=$query->fetch_assoc()){
			$admins[] = $admin;
		}
		return $admins;
	}
	
	/**
	
	*/
	function deleteAdmin($adminId){
		$q = "DELETE FROM `admins` WHERE `id`='$adminId' ";
		//echo $q;
		$query = $this->query($q);
	}
	
	/**
	
	*/
	function addAdmin($login, $pass){
		if($login=='superadmin'){
			return "{\"return\":\"superadmin\"}";
		}
		$query = $this->query("SELECT * FROM `admins` WHERE `login`='$login' ");
		if($query->num_rows > 0){
			return "{\"return\":\"used\"}";
		}
		$pass = md5($pass);
		$q = "INSERT INTO `admins` (`login`, `password`) VALUES ('$login', '$pass') ";
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
	function jsonDecode($string){
		if($this->testStringFor1251($string)){
			$config = json_decode(iconv("CP1251", "UTF-8", $string), true);
			$array = $this->iconvArray($config, "UTF-8", "CP1251");
		}else{
			$array = json_decode($string, true);
		}
		return $array;
	}
	
	/**
	
	*/
	function testStringFor1251($string){
		for($j=0; $j<strlen($string); $j++){
			//echo mb_detect_encoding($string[$j], array('Windows-1251', 'UTF-8'))." ($string[$j]) <br/>\n";
			if(mb_detect_encoding($string[$j], array('Windows-1251', 'UTF-8'))=="Windows-1251"){
				return true;
			}
		}
		return false;
	}

	/**
	
	*/
	function iconvArray($array, $from="UTF-8", $to="CP1251"){
		$return = array();
		if(is_array($array)){
			foreach($array as $key=>$value){
				if(is_array($value)){
					$return[$key] = $this->iconvArray($value, $from, $to);
				}else{
					$return[$key] = iconv($from, $to, $value);
				}
			}
		}
		return $return;
	}
	
	/**
	
	*/
	function deleteImage($imageId){
		$q = "SELECT `name` FROM `images` WHERE `id`='$imageId' ";
		$query = $this->query($q);
		$image = $query->fetch_assoc();
		if(file_exists("../loadimages/".$image['name'])){
			unlink("../loadimages/".$image['name']);
		}
		$q = "DELETE FROM `images` WHERE `id`='$imageId' ";
		//echo $q;
		$query = $this->query($q);
		if($query){
			return "{\"return\":\"ok\",\"imgid\":\"$imageId\"}";
		}
		return "{\"return\":\"false\"}";
	}
	
	/**
	
	*/
	function deleteImagesFromNoticeId($noticeId){
		$q = "DELETE FROM `images` WHERE `noticeId`='$noticeId' ";
		$query = $this->query($q);
		if($query){
			return true;
		}
		return false;
	}
	
	/**
	
	*/
	function transliteral($txt){
		$rv = "";
		for($i=0; $i<strlen($txt); $i++){
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "A"){
				//1
				$rv.="a";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "B"){
				//2
				$rv.="b";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "V"){
				//3
				$rv.="v";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "G"){
				//4
				$rv.="g";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "D"){
				//5
				$rv.="d";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "E"){
				//6
				$rv.="e";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//7
				$rv.="yo";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//8
				$rv.="zh";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "Z"){
				//9
				$rv.="z";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "I"){
				//10
				$rv.="i";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//11
				$rv.="y";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "K"){
				//12
				$rv.="k";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "L"){
				//13
				$rv.="l";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "M"){
				//14
				$rv.="m";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "N"){
				//15
				$rv.="n";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//16
				$rv.="ya";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "O"){
				//17
				$rv.="o";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "P"){
				//18
				$rv.="p";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "R"){
				//19
				$rv.="r";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "S"){
				//20
				$rv.="s";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "T"){
				//21
				$rv.="t";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "U"){
				//22
				$rv.="u";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "F"){
				//23
				$rv.="f";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "H"){
				//24
				$rv.="h";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "C"){
				//25
				$rv.="c";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//26
				$rv.="ch";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//27
				$rv.="sh";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//28
				$rv.="sch";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//29
				$rv.="_";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//30
				$rv.="i";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//31
				$rv.="_";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//32
				$rv.="e";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"  || substr($txt, $i, 1) == "U"){
				//33
				$rv.="u";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//34
				$rv.="i";
			}
			if(substr($txt, $i, 1) == "�" || substr($txt, $i, 1) == "�"){
				//35
				$rv.="i";
			}
			if(substr($txt, $i, 1) == "-" || substr($txt, $i, 1) == " "){
				//36
				$rv.="_";
			}
			if(preg_match("/^[a-z0-9._]+$/", substr($txt, $i, 1))){
				//37
				$rv.=substr($txt, $i, 1);
			}
			if(substr($txt, $i, 1) == "J"){
				//22
				$rv.="j";
			}
			if(  substr($txt, $i, 1) == "."  ){
				//22
				//$rv.="_";
			}
		}
		//$rv = str_replace(".", "", $rv);
		return $rv;
	}
	
	function myPrint($array){
		echo "<pre>"; print_r($array); echo "</pre>";
	}
	
	
}
?>