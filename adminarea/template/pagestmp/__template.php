<?php
$version = "AlisaCMS-X";
$__tree_show_image = 1;
$tree_index = 0;
//**************************************
//header("Cache-Control: no-cache, must-revalidate");
//header("Pragma: no-cache");
//require_once("../__config.php");
//require_once("../core/__functions.php");
//require_once("../core/__functions_csv.php");
//require_once("../core/__functions_tree_semantic.php");
//require_once("../core/__functions_images.php");
//require_once("../core/__functions_pages.php");
//require_once("../core/__functions_sitemap_0.1.php");
//require_once("../core/__functions_multilang.php");
//dbgo();
//$outinfo = "";
//require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
//$csv_class =& new csvToArray("csv_class"); //Объявление класса csv 
//$__page_parent=$_GET["parent"];
//print_r($_POST);

?>

<html>
<?  require_once("__head.php"); ?>

<body id="root_body">

<?  require_once("__tiny.php"); ?>
<div id="divinfo" style="display:none;"></div>
<div id="popupmy" style="display:none;">Тестируем проверку попапов для редактирования, скажем названия и описания изображения</div>
<div class="menu" id="inleftmenu"><div class="submenu">
	<div class="menutitle">Главное меню</div>
	<?  if($administrator){ require_once("__menu.php"); } ?>
</div></div>
<!--<img src="/adminarea/template/images/green/left_panel_close.gif" id="left_panel_close" width="10" height="50"/>-->
<table border="0" cellpadding="0" cellspacing="0" class="adminarea">
  <tr>
    <td class="adminarealeft" id="tdadminarealeft"><img src="/adminarea/template/images/spacer.gif" width="350" height="5"/></td>
    <td class="adminarearight" id="adminarearight" valign="top" style="padding:10px;">
<?  if(!$administrator){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="000">
  <tr>
    <td width="100" height="35">Логин</td>
    <td height="35"><input type="text" id="login" value="superadmin"></td>
  </tr>
  <tr>
    <td width="100" height="35">Пароль</td>
    <td height="35"><input type="text" id="password" value="test"></td>
  </tr>
  <tr>
    <td height="35" colspan="2"><button style="margin-left:100px;" onClick="login()">Войти</button></td>
    </tr>
</table>
<script>
function login(){
	var paction = "ajax=login&login="+document.getElementById("login").value;
	paction += "&password="+document.getElementById("password").value;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			if(data.return == 'ok'){
				document.location.href = "/adminarea/";
			}
		}
	});
}
//**********************
//$(document).ready(function(){
//	//alert(document.location.pathname);
//	if(document.location.pathname=='/adminarea/exit/'){
//		document.location.href = '/adminarea/';
//	}
//});
</script>
<? } ?></td>
  </tr></table>
<div id="div_uc_window" style="display:none;"><img src="/adminarea/template/images/green/icon_close_ucw.gif" class="img_icucw" onClick="close_ucw()">
<h3>Комментарии пользователя</h3><div id="div_ucw_cont"></div></div>

<div class="ui-state-default-3" id="helptitles" style="display:none;">
<div id="helptitles_title">Справка
<img src="/adminarea/template/images/green/myitemname_popup/help_close.gif" align="right" style="cursor:pointer;"
onclick="close_help_titles()" />
<img src="/adminarea/template/images/green/myitemname_popup/help_sver.gif" align="right" style="cursor:pointer;"
onclick="help_sver_menu_toggle(this)" />
</div><div id="helptitles_cont"></div></div>

<? if(isset($error)) echo "<script>alert('$error')</script>"; ?>
<?  require_once("__footer.php"); ?>
<? 
//$resp = mysql_query("select * from zakaz where remember=1 order by adddate desc limit 0,1");
//$row=mysql_fetch_assoc($resp);
//echo "<script>nztime=$row[adddate]; test_new_zakaz();<";echo"/script>";
?>

<div id="show_cssblock_bg" style="display:none;"></div>
<div id="show_cssblock_cont" style="display:none;"></div>
<div id="show_cssblock_close" style="display:none;"></div>

<div id="help_bg" style="display:none;"></div>
<div id="help_cont" style="display:none;"></div>
<div id="help_close" style="display:none;"></div>

<script>
$(document).ready(function(){
	//alert(window.location.pathname);
	<?
	$string = "";
	if(is_array($params)){ if(count($params)>0){ $string="?"; foreach($params as $key=>$value){
		$string .= "$key=$value,";
	} $string = preg_replace("/,$/", "", $string); }}
	if($administrator){?>
	getPage(window.location.pathname+'<?=$string?>');
	<? } ?>
})
</script>

</body>
</html>