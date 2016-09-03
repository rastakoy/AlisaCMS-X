<? 
//require("topmenu.php");
if($loadPage){
	if($loadPage!="root"){
		//if($rights[$adminPage['id']]['rights']['0']!='1' && $loadPage!='loginForm'){
		//	echo "<div style=\"background-color:#FFFFFF; padding:10px;\">";
		//	echo "<h2>У вас нет прав на просмотр этой страницы</h2>";
		//	echo "</div>";
		//}elseif($adminPage['urlName']=='roles' && $user['status']!='1'){
		//	echo "<div style=\"background-color:#FFFFFF; padding:10px;\">";
		//	echo "<h2>У вас нет прав на просмотр этой страницы</h2>";
		//	echo "</div>";
		//}else
		if(file_exists("template/pages/".$loadPage.".php")){
			//echo "<div style=\"background-color:; padding:10px;\">";
			if(isset($selectLanguage) && $GLOBALS['language']==$selectLanguage){
				//echo "<h2>$adminPage[name]</h2>";
			}else{
				//echo "<h2>".$adminPage['name_'.$selectLanguage]."</h2>";
			}
			require("template/pages/".$loadPage.".php");
			//echo "</div>";
		}else{
			echo "<div style=\"background-color:#FFFFFF; padding:10px;\">";
			echo "<h2>Файл шаблона не найден</h2>";
			echo "</div>";
		}
	}
}
?>
