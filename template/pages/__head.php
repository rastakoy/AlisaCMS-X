<head>
<title><?=$GLOBALS['version']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=WINDOWS-1251">
<base href="<?=$GLOBALS['site']?>"/>

<link href="/template/css/style.css" rel="stylesheet" type="text/css" media="all">
<link href="/template/css/style.items.css" rel="stylesheet" type="text/css" media="all">
<link href="/template/css/style.item.css" rel="stylesheet" type="text/css" media="all">
<link href="/template/css/style.popup.css" rel="stylesheet" type="text/css" media="all">

<script type="text/javascript" src="/template/js/popup.js"></script>
<script type="text/javascript" src="/template/js/basket.js"></script>
<script type="text/javascript" src="/template/js/button.preloader.js"></script>

<!--<script type="text/javascript" src="/template/js/jquery/jquery-1.9.1.min.js"></script>-->
<script type="text/javascript" src="/template/js/jquery/jquery-1.7.1.min.js"></script>

<script src="/jqzoom/js/jquery.jqzoom-core.js" type="text/javascript"></script>
<link rel="stylesheet" href="/jqzoom/css/jquery.jqzoom.css" type="text/css">


<script>
var __GLOBALS = {
	"ajax":"<?=$GLOBALS['ajax']?>",
	"site":"<?=$GLOBALS['site']?>",
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