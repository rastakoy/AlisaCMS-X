<?  //require_once("__init.php"); ?>
<html>
<?  require_once("__head.php"); ?>
<body id="root_body">
<div align="center"><div id="container-all" align="left">
<?  require_once("__header.php"); ?>
<?  require_once("__horizontal_menu.php"); ?>
<?  require_once("__left_menu.php"); ?>

<!-- ======== CONTENT ============= -->
<div style="width:690px; float:right;">
<? //echo "<pre>array:"; print_r($array); echo "</pre>"; ?>
<?
if($loadPage){
	if($loadPage!="root"){
		//echo $loadPage;
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
			echo "<h2>Ошибка 404</h2>";
			echo "Данная страница не найдена";
			echo "</div>";
		}
	}
}
?>
</div>
<div style="float:none; clear:both;"></div>
<!-- ======== //CONTENT ============= -->

<div style="float:none; clear:both;"></div>
<div align="center"><? require_once("__footer.php"); ?></div>
    <!-- Start SiteHeart code -->
    <script>
    (function(){
    var widget_id = 756117;
    _shcp =[{widget_id : widget_id}];
    var lang =(navigator.language || navigator.systemLanguage
    || navigator.userLanguage ||"en")
    .substr(0,2).toLowerCase();
    var url ="widget.siteheart.com/widget/sh/"+ widget_id +"/"+ lang +"/widget.js";
    var hcc = document.createElement("script");
    hcc.type ="text/javascript";
    hcc.async =true;
    hcc.src =("https:"== document.location.protocol ?"https":"http")
    +"://"+ url;
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hcc, s.nextSibling);
    })();
    </script>
    <!-- End SiteHeart code -->

</div></div>

<div id="popup_bg" style="display:none;"></div>
<div id="popup_cont" style="display:none;"></div>
<div id="popup_title" style="display:none;"></div>
<div id="popup_close" style="display:none;"></div>

</body>
</html>