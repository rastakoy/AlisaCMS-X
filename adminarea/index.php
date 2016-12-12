<?php
/* Обьявляем переменные для подключения к БД */
	$GLOBALS['offline'] = '1';
	if($GLOBALS['offline'] == '1'){
		ini_set('display_errors', '1');
		$GLOBALS['host'] = 'localhost';
		$GLOBALS['database'] = 'sigma';
		$GLOBALS['user'] = 'root';
		$GLOBALS['pass'] = '';
		$GLOBALS['site'] = 'http://sigma.my/';
		$GLOBALS['adminBase'] = "/adminarea";
		$GLOBALS['imagesDirectory'] = "../loadimages";
		$GLOBALS['ajax'] = $GLOBALS['adminBase'].'/index.php';
		$GLOBALS['language'] = 'rus';
		$GLOBALS['activeInterval'] = '3600';
		$GLOBALS['onPage'] = '50';
		$GLOBALS['debugMode'] = '1';
		
		ini_set('max_execution_time', 120);
	}else{
		//ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
		ini_set('display_errors', '1');
		$GLOBALS['host'] = 'ppsigma.mysql.ukraine.com.ua';
		$GLOBALS['database'] = 'ppsigma_sigmadb';
		$GLOBALS['user'] = 'ppsigma_user';
		$GLOBALS['pass'] = 'xphURbZw';
		$GLOBALS['site'] = 'http://www.sigma.pl.ua/';
		$GLOBALS['adminBase'] = "/adminarea";
		$GLOBALS['ajax'] = $GLOBALS['adminBase'].'/index.php';
		$GLOBALS['language'] = 'rus';
		$GLOBALS['activeInterval'] = '3600';
		$GLOBALS['onPage'] = '50';
		$GLOBALS['debugMode'] = '1';
		
		ini_set('max_execution_time', 120);
	}
	session_start();
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

	//print_r($_SERVER);
	$prega = "/(^\\".str_replace("/index.php", '', $GLOBALS['ajax'])."\/|\/{1,100}$)/";
	$string = preg_replace($prega, '', $_SERVER['REQUEST_URI']);
	$core = new Core();
	$GLOBALS['string'] = $string;
	//$string = preg_replace("/^[a-z]{3}\/?/", "", $string);
	$params = explode("?", $string);
	$string = preg_replace("/\/$/", "", $params['0']);
	$params = $core->constructParams($params['1']);
	$string = explode('/', $string);

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
		
	//Для автозапусков типа крона
	}elseif(isset($_GET['controller'])){
		$classController = new Controller();
		$classController->initController();
	//Отслеживает все POST'ы
	}elseif(isset($_POST['ajax'])){
		//Только Ajax POST'ы
		header("Content-type: text/plain; charset=windows-1251");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		$core->makePost($_POST);
	}else{
		header("Content-type: text/html; charset=windows-1251");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		$core->makePage($string, $params);
	}

?>