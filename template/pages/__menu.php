<? //echo "<pre>"; print_r($leftMenu); echo "</pre>"; ?>
<!--  -------------------------------------------------------------------- -->
<div class="menuitem" style="float:none;clear:both;"><strong>
<img src="/adminarea/template/images/green/icons/briffing.gif" align="absmiddle">
<a href="/adminarea/" class="amenu">Общие настройки</a></strong></div>
<!--  --------------------------------------------------------------------
<div class="menuitem" style="float:none;clear:both;"><strong>
<img src="/adminarea/template/images/green/icons/briffing.gif" align="absmiddle">
<a href="/adminarea/scheme" class="amenu">Схема сайта</a></strong></div> -->
<? foreach($leftMenu as $option){ ?>
<div class="menuitem" id="root<?=$option['link']?>menu">
<? if($option['submenu']){ ?><img src="/adminarea/template/tree/plus.jpg" style="cursor:pointer;"
onclick="openLeftBranch('<?=$option['link']?>')">&nbsp;<? }else{ ?>&nbsp;&nbsp;&nbsp;<? } ?>
<a href="<?=$GLOBALS['adminBase']?>/?option=<?=$option['link']?>"
class="amenu"><strong><?=$option['name']?></strong></a></div><? if($option['submenu']=='1'){ ?>
<div id="left_<?=$option['link']?>_0" class="items_left_menu" style="padding-bottom:25px;<?
if($params['option']!=$option['link']){?>display:none;<? } ?>"></div>
<? if($params['option']==$option['link']){?><script>
$(document).ready(function(){
	openLeftBranch('<?=$option['link']?>');
});
</script>
<? } } } ?>
<!--  -------------------------------------------------------------------- -->
<? if($administrator=='superadmin' && $administrator!='1'){ ?>
<div class="menuitem" style="float:none;clear:both;"><strong>
<a href="?option=settings" class="amenu">! Настройки сайта</a></strong></div>
<? } ?>
<!--  -------------------------------------------------------------------- -->
<div class="menuitem" style="float:none;clear:both;"><strong>
<a href="?option=trash" class="amenu">Утилизация</a></strong></div>
<!--  --------------------------------------------------------------------
<div class="menuitem" style="float:none;clear:both;"><strong>
<a href="/adminarea/exit/" class="amenu">! Выход</a></strong></div> -->
<!--  -------------------------------------------------------------------- -->
<div class="menuitem" style="transition:none;background:url(/adminarea/template/images/green/menu_hr_static_long.jpg); background-repeat:no-repeat;">&nbsp;</div> 
<!--  -------------------------------------------------------------------- -->
<script>

</script>
<!--  -------------------------------------------------------------------- -->