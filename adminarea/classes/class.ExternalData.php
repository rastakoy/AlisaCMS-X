<?php
class ExternalData {
	
	public $__LOGIN = "kraina";
	public $__PASSWORD = "1234567890";
	public $__URL = "http://alisacms-x.my/external.php";
	//public $__URL = "http://kraina.my/external.php";
	
	/**
	
	*/
	function getData($params){
		$params = json_encode($params);
		$postdata = http_build_query($this->constructPost($params));
		$opts = array('http'=>array('method'  => 'POST','header'  => 'Content-type: application/x-www-form-urlencoded','content' => $postdata));
		$context  = stream_context_create($opts);
		$returns = file_get_contents($this->__URL, false, $context);
		return $returns;
	}
	
	/**
	
	*/
	function addData($params){
		$params = json_encode($params);
		$postdata = http_build_query($this->constructPost($params));
		$opts = array('http'=>array('method'  => 'POST','header'  => 'Content-type: application/x-www-form-urlencoded','content' => $postdata));
		$context  = stream_context_create($opts);
		$returns = file_get_contents($this->__URL, false, $context);
		return $returns;
	}
	
	/**
	
	*/
	function editData($params){
		$params = json_encode($params);
		$postdata = http_build_query($this->constructPost($params));
		$opts = array('http'=>array('method'  => 'POST','header'  => 'Content-type: application/x-www-form-urlencoded','content' => $postdata));
		$context  = stream_context_create($opts);
		$returns = file_get_contents($this->__URL, false, $context);
		return $returns;
	}
	
	/**
	
	*/
	function deleteData(){
		
		addToHistory($sql);
	}
	
	/**
	
	*/
	function constructPost($params){
		$array = array(
			'json' => $params,
			'API_login' => $this->__LOGIN,
			'API_password' => md5($this->__PASSWORD)
		);
		return $array;
	}
	
	/**
	
	*/
	function addToHistory($sql){
		$resp = mysql_query("INSERT INTO `history` (`content`) VALUES ('$sql') ");
	}
	
}