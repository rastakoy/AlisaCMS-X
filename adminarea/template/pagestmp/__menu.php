<? //echo "<pre>"; print_r($leftMenu); echo "</pre>"; ?>
<!--  -------------------------------------------------------------------- -->
<div class="menuitem" style="float:none;clear:both;"><strong>
<a href="/adminarea/" class="amenu">Стартовая</a></strong></div>
<? foreach($leftMenu as $option){ ?>
<div class="menuitem" id="root<?=$option['link']?>menu"><a href="/adminarea/<?=$option['link']?>/"
class="amenu"><strong><?=$option['name']?></strong></a></div><? if($option['submenu']=='1'){ ?>
<div class="items_left_menu" id="<?=$option['link']?>_left_menu" style="padding-bottom:25px;<?
if($array['0']!=$option['link']){?>display:none;<? } ?>"></div>
<script>
$(document).ready(function(){
	getLeftBranch('<?=$option['link']?>');
});
</script>
<? } } ?>
<!--  -------------------------------------------------------------------- -->
<? if($administrator=='superadmin' && $administrator!='1'){ ?>
<div class="menuitem" style="float:none;clear:both;"><strong>
<a href="/adminarea/settings/" class="amenu">! Настройки сайта</a></strong></div>
<? } ?>
<!--  -------------------------------------------------------------------- -->
<div class="menuitem" style="float:none;clear:both;"><strong>
<a href="/adminarea/exit/" class="amenu">! Выход</a></strong></div>
<!--  -------------------------------------------------------------------- -->
<div class="menuitem">&nbsp;</div> 
<!--  -------------------------------------------------------------------- -->
<script>

</script>
<!--  -------------------------------------------------------------------- -->