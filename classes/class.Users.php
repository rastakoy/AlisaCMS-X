<?php
class Users extends DatabaseInterface{
	
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
	
}