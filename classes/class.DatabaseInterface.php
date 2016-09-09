<?php

	/**
	 * Интерфейс для общения с базой данных
	 * Пока что используется только для модулей
	 * В дальнейшем, если будет нормально работать, многое можно будет подчерпнуть из этого
	 *
	 * Class DatabaseInterface
	 */
class DatabaseInterface extends Mysqli{

	/**
	 * Конструктор класса
	 *
	 * @param 		string $param1 - хост базы данных
	 * @param 		string $param2 - пользователь базы данных
	 * @param 		string $param3 - пароль базы данных
	 * @param 		string $param4 - название базы данных
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
	 * Функция query, с возможностью отладки
	 *
	 * @name      	s_query
	 * @param     	$query
	 * @param 		int $resultmode
	 * @return 		bool|mysqli_result
	 * @throws 		Exception
	 * @author  	Николай Гилко <n.gilko@gmail.com>
	 * @version 	1.0
	 */
	private function s_query($query, $resultmode = MYSQLI_STORE_RESULT){
		$query = parent::query($query, $resultmode);
		if(!$query){
			throw new Exception("Ошибка базы данных [ошибка запроса: {$this->errno}, ошибка соединения {$this->connect_errno}]");
		}
		return $query;
	}

	/**
	 * Функция query для выполнения запросов
	 *
	 * @name        query
	 * @param 		string $query
	 * @param 		int    $resultmode
	 * @return 		bool|mysqli_result
	 * @author  	Николай Гилко <n.gilko@gmail.com>
	 * @version 	1.0
	 */
	function query($query, $resultmode = MYSQLI_STORE_RESULT){
		$exceptions[] = "INFORMATION_SCHEMA";	
		$exceptions[] = "SHOW FIELDS";
		$exceptions[] = "UPDATE";
		$exceptions[] = "INSERT";
		$exceptions[] = "CREATE";
		$exceptions[] = "`admins`";
		$exceptions[] = "`settings`";
		$exceptions[] = "`menusettings`";
		$exceptions[] = "`images`";
		$exceptions[] = "`trash`";
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
			return $this->s_query($query, $resultmode);
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

}