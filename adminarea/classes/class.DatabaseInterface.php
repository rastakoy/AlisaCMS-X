<?php

	/**
	 * ��������� ��� ������� � ����� ������
	 * ���� ��� ������������ ������ ��� �������
	 * � ����������, ���� ����� ��������� ��������, ������ ����� ����� ����������� �� �����
	 *
	 * Class DatabaseInterface
	 */
class DatabaseInterface extends Mysqli{

	/**
	 * ����������� ������
	 *
	 * @param 		string $param1 - ���� ���� ������
	 * @param 		string $param2 - ������������ ���� ������
	 * @param 		string $param3 - ������ ���� ������
	 * @param 		string $param4 - �������� ���� ������
	 */
	function __construct($param1 = '', $param2 = '', $param3 = '', $param4 = ''){
		$param = array('host' => $param1, 'user' => $param2, 'pass' => $param3, 'database' => $param4);
		foreach($param as $key => $tParam){
			$param[$key] = ($tParam == '' ? $GLOBALS[$key] : $tParam);
		}
		parent::__construct($param['host'], $param['user'], $param['pass'], $param['database']);
		parent::set_charset("cp1251");
		parent::query("SET NAMES 'cp1251' COLLATE 'cp1251_general_ci'");
	}

	/**
	 * ������� query, � ������������ �������
	 *
	 * @name      	s_query
	 * @param     	$query
	 * @param 		int $resultmode
	 * @return 		bool|mysqli_result
	 * @throws 		Exception
	 * @author  	������� ����� <n.gilko@gmail.com>
	 * @version 	1.0
	 */
	private function s_query($query, $resultmode = MYSQLI_STORE_RESULT){
		$query = parent::query($query, $resultmode);
		if(!$query){
			throw new Exception("������ ���� ������ [������ �������: {$this->errno}, ������ ���������� {$this->connect_errno}]");
		}
		return $query;
	}

	/**
	 * ������� query ��� ���������� ��������
	 *
	 * @name        query
	 * @param 		string $query
	 * @param 		int    $resultmode
	 * @return 		bool|mysqli_result
	 * @author  	������� ����� <n.gilko@gmail.com>
	 * @version 	1.0
	 */
	function query($query, $resultmode = MYSQLI_STORE_RESULT){
		$query = trim($query);
		//********************************
		$exceptions[] = "INFORMATION_SCHEMA";
		$exceptions[] = "SHOW FIELDS";
		$exceptions[] = "DELETE";
		$exceptions[] = "UPDATE";
		$exceptions[] = "INSERT";
		$exceptions[] = "CREATE";
		$exceptions[] = "ALTER";
		$exceptions[] = "`admins`";
		$exceptions[] = "`menus`";
		$exceptions[] = "`blocks`";
		$exceptions[] = "`comments`";
		$exceptions[] = "`settings`";
		$exceptions[] = "`menusettings`";
		$exceptions[] = "`images`";
		$exceptions[] = "`trash`";
		$exceptions[] = "`users`";
		//********************************
		$paste = true;
		foreach($exceptions as $exception){
			$exception = "/".$exception."/";
			if(preg_match($exception, $query)){
				$paste = false;
			}
		}
		//********************************
		if($paste){
			if(preg_match("/ WHERE /", $query)){
				$query = preg_replace("/ WHERE /", " WHERE `trash`='0' AND ", $query);
			}elseif(preg_match("/ ORDER /", $query)){
				$query = preg_replace("/ ORDER /", " WHERE `trash`='0' ORDER ", $query);
			}else{
				$query .= " WHERE `trash`='0' ";
			}
			//echo $query."<br/>\n";
		}
		//********************************
		try{
			//echo $query."<br/>\n";
			if(preg_match("/^INSERT/", $query)){
				$table = explode("`", $query);
				$table = $table['1'];
				$q = $this->s_query($query, $resultmode);
				if($q){
					$return = $this->s_query("SELECT * FROM `$table` ORDER BY `id` DESC LIMIT 0,1", $resultmode);
					$item = $return->fetch_assoc();
					return $item;
				}else{
					return $q;
				}
			}else{
				return $this->s_query($query, $resultmode);
			}
		}catch(Exception $e){
			//Core::s_writeToLog(array(
			//	'date' => date('d-m-Y H:i:s'),
			//	'type' => 'badQuery',
			//	'query' => $query,
			//	'errorMessage' => $e->getMessage(),
			//	'stackTrace' => $e->getTrace()
			//));
		}
	}
	
	/**
	
	*/
	function encodeSQL($params, $start){
		if(is_array($params)){
			foreach($params as $key=>$value){
				preg_match("/(^>|^>=|^<|^<=)/", $value, $assig);
				echo "$assig";
				print_r($assig);
				echo "\n-----------\n";
			}
		}
		if(strlen($str)>0){
			$str = $start.$str;
		}
		return $str;
	}
	
	function okamaBlade($q){
		
	}

}