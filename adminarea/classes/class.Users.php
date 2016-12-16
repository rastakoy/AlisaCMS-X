<?php
class Users extends DatabaseInterface{
	
	private $__SECRET = "alisacms-x";
	
	/**
	
	*/
	function getUser($array=false){
		$user = false;
		if($array['login'] && $array['password']){
			$password = __SECRET.$array['password'].__SECRET;
			$query = $this->query("SELECT * FROM `users` WHERE `login`='$array[login]' AND `password`='$password' ");
			if($query && $query->num_rows == '1'){
				$user = $query->fetch_assoc();
				setcookie("login", $array['login'], time()+(3600)*24*30, "/");
				setcookie("password", $password, time()+(3600)*24*30, "/");
				$_SESSION['login'] = $array['login'];
				$_SESSION['password'] = $password;
			}
		}elseif($_COOKIE['login'] && $_COOKIE['password']){
			$query = $this->query("SELECT * FROM `users` WHERE `login`='".($_COOKIE['login'])."' AND `password`='".($_COOKIE['password'])."' ");
			if($query && $query->num_rows == '1'){
				$user = $query->fetch_assoc();
				$_SESSION['login'] = $array['login'];
				$_SESSION['password'] = $password;
			}
		}elseif($_SESSION['login'] && $_SESSION['password']){
			$query = $this->query("SELECT * FROM `users` WHERE `login`='".($_SESSION['login'])."' AND `password`='".($_SESSION['password'])."' ");
			if($query && $query->num_rows == '1'){
				$user = $query->fetch_assoc();
				setcookie("login", $array['login'], time()+(3600)*24*30, "/");
				setcookie("password", $password, time()+(3600)*24*30, "/");
			}
		}
		//**************
		if(!$user){
			setcookie("login", "", time()+30, "/");
			setcookie("password", "", time()+30, "/");
			$_SESSION['login'] = '';
			$_SESSION['password'] = '';
			$query = $this->query("SELECT * FROM `users` WHERE `sid`='".($_COOKIE['PHPSESSID'])."' AND `reg`='0' LIMIT 0,1");
			if($query && $query->num_rows == '1'){
				$user = $query->fetch_assoc();
			}
		}
		//**************
		if(!$user){
			$query = $this->query("INSERT INTO `users` (`sid`, `addDate`) VALUES ('".($_COOKIE['PHPSESSID'])."', '".date('Y-m-d H:i:s')."') ");
			$user = $query->fetch_assoc();
		}
		//**************
		//echo "<pre>session:"; print_r($_SESSION); echo "</pre>";
		//echo "<pre>_COOKIE:"; print_r($_COOKIE); echo "</pre>";
		//echo "<pre>user:"; print_r($user); echo "</pre>";
		return $user;
	}
	
	/**
	
	*/
	function getUsersByAttribute($attr, $value, $orderBy=''){
		if($orderBy){
			$orderBy = preg_replace("/ {2,10}/", " ", $orderBy);
			$orderBy = explode(" ", trim($orderBy));
			$orderBy['1'] = strtoupper($orderBy['1']);
			$orderBy = "ORDER BY `$orderBy[0]` $orderBy[1]";
		}
		$q = "SELECT * FROM `users` WHERE `$attr`='$value' $orderBy ";
		//echo $q;
		$query = $this->query($q);
		//if($query){
			while($user=$query->fetch_assoc()){
				$users[] = $user;
			}
			return $users;
		//}else{
			echo "false";
			return false;
		//}
	}
	
	/**
	
	*/
	function getUserById($id){
		$query = $this->query("SELECT * FROM `users` WHERE `id`='$id' ");
		$user=$query->fetch_assoc();
		return $user;
	}
	
}