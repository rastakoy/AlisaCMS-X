<head>
<title><?=$GLOBALS['version']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=WINDOWS-1251">
<base href="<?=$GLOBALS['site']?>"/>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="tree/seo_style_tree.css" rel="stylesheet" type="text/css"/>
<link href="styles/folders.css" rel="stylesheet" type="text/css"/>
<link href="styles/uc_window.css" rel="stylesheet" type="text/css"/>

<link href="style_manage_config.css" rel="stylesheet" type="text/css"/>-->

<link href="/adminarea/template/css/style.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/style_x.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/folders.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/style_myitems.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/myitemname_popup.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/style_css.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/seo_style_tree.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/help.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/style.qqfile.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/trash.css" rel="stylesheet" type="text/css">

<link href="/adminarea/template/css/settings.css" rel="stylesheet" type="text/css">
<link href="/adminarea/template/css/language.css" rel="stylesheet" type="text/css">


<script type="text/javascript" src="/adminarea/template/js/detect.js"></script>
<script type="text/javascript" src="/adminarea/template/js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="/adminarea/template/js/router.js"></script>
<script type="text/javascript" src="/adminarea/template/js/leftMenu.js"></script>
<script type="text/javascript" src="/adminarea/template/js/data.js"></script>
<script type="text/javascript" src="/adminarea/template/js/dop_popup_v_01.js"></script>
<script type="text/javascript" src="/adminarea/template/js/filters.js"></script>
<script type="text/javascript" src="/adminarea/template/js/notices.js"></script>
<script type="text/javascript" src="/adminarea/template/js/fileuploader.js"></script>
<script type="text/javascript" src="/adminarea/template/js/preloader.js"></script>
<script type="text/javascript" src="/adminarea/template/js/help.js"></script>

<script src="/adminarea/template/js/jquery.ui.core.js"></script>
<script src="/adminarea/template/js/jquery.ui.widget.js"></script>
<script src="/adminarea/template/js/jquery.ui.mouse.js"></script>
<script src="/adminarea/template/js/jquery.ui.sortable.js"></script>
<script src="/adminarea/template/js/jquery.ui.draggable.js"></script>
<link href="/adminarea/template/css/demos.css" rel="stylesheet" type="text/css" />

<!--<script src="/adminarea/template/tinymce/tinymce.min.js"></script>-->

<?  require_once("__tiny.php"); ?>


<style>
	#sortable { list-style-type: none; margin: 0; padding: 0; }
	#sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
</style>

<script>
var __GLOBALS = {
	"ajax":"<?=$GLOBALS['ajax']?>",
	"site":"<?=$GLOBALS['site']?>",
	"adminBase":"<?=$GLOBALS['adminBase']?>",
	"currentURL":false,
	"language":"<?=$GLOBALS['language']?>",
	"editing":false
};
<? if(is_array($params)){ ?>
var __PARAMS = <?=str_replace(',"', ",\n	\"", preg_replace(array("/^\{/", "/\}$/"), array("{\n	", "\n}"), json_encode($params)))."\n"?>;
<? }else{ ?>
var __PARAMS = {};
<? } ?>
</script>
</head>