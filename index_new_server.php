<?php
	ini_set('display_errors', '1');
	//ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
	session_start();
	/* Обьявляем переменные для подключения к БД */
	$GLOBALS['offline'] = '1';
	if($GLOBALS['offline'] == '1'){
		$GLOBALS['host'] = 'localhost';
		$GLOBALS['database'] = 'board';
		$GLOBALS['user'] = 'root';
		$GLOBALS['pass'] = '';
		$GLOBALS['site'] = 'http://board.my/adminarea/';
		$GLOBALS['language'] = 'rus';
		$GLOBALS['activeInterval'] = '3600';
		$GLOBALS['onPage'] = '50';
	}else{
		$GLOBALS['host'] = 'localhost';
		$GLOBALS['database'] = 'ufs';
		$GLOBALS['user'] = 'ufs';
		$GLOBALS['pass'] = '2X3j5W7b';
		$GLOBALS['site'] = 'http://ufs-invest.com/';
		$GLOBALS['language'] = 'rus';
		$GLOBALS['activeInterval'] = '300';
		$GLOBALS['onPage'] = '50';
	}

	/* конец обьявления переменных */

	/* Автоподгрузка класов */

	//for php 5.3
	//spl_autoload_register(function ($className){
	//	include 'classes/class.'.$className.'.php';
	//});
	
	//for php 5.2
	function my_autoloader($className) {
		if(file_exists('classes/class.'.$className.'.php')){
			include 'classes/class.'.$className.'.php';
		}
	}
	spl_autoload_register('my_autoloader');
	
	/* Конец автоподгрузки класов */

	/* Данный участок кода разбивает строку адреса на массив */

	$string = preg_replace("/(^\/|\/$)/", "", $_SERVER['REQUEST_URI']);
	$core = new Core();
	$GLOBALS['string'] = $string;

	/* Конец разбиения строки аддреса */

	//Отслеживает загрузку файлов библиотекой qqfile
	//file_put_contents("test.txt", "$return\r\n------\r\n", FILE_APPEND);
	if(isset($_GET["qqfile"])){
		file_put_contents("test.txt", "$return\r\n------\r\n", FILE_APPEND);
		header("Content-type: text/plain; charset=windows-1251");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		$return = $core->loadImage($_GET);
		echo $return;
		
	//Отслеживает все POST'ы
	}elseif(isset($_POST['ajax'])){
		//Только Ajax POST'ы
		header("Content-type: text/plain; charset=windows-1251");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		$core->makePost($_POST);
	}else{
		if(preg_match("/^[a-z]{3}/", $string, $matches)){
			//if($core->testLanguage($matches['0'])){
			//	$_SESSION['language'] = $matches['0'];
			//	$GLOBALS['language'] = $matches['0'];
			//}else{
			//	header("Location: ".$GLOBALS['site'].$GLOBALS['language']."/");
			//	exit;
			//}
		}else{
			header("Location: ".$GLOBALS['site'].$GLOBALS['language']."/");
			exit;
		}
		$string = preg_replace("/^[a-z]{3}\/?/", "", $string);
		$string = explode('/', $string);
		header("Content-type: text/html; charset=windows-1251");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		$core->makePage($string);
	}

?>