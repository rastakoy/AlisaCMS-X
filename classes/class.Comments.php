<?php
class Comments extends DatabaseInterface{
	
	/**
	
	*/
	function getCommentsByParentId($parentId, $params=false){
		$sql = $this->encodeSQL($params, ", ");
		$q = "SELECT * FROM `comments` WHERE `parent`='$parentId' $sql ORDER BY `id` DESC ";
		//echo $q."\n-------\n";
		$query = $this->query($q);
		while($comment=$query->fetch_assoc()){
			$comments[] = $comment;
		}
		return $comments;
	}
	
	/**
	
	*/
	function getUserById($id){
		$query = $this->query("SELECT * FROM `users` WHERE `id`='$id' ");
		$user=$query->fetch_assoc();
		return $user;
	}
	
}