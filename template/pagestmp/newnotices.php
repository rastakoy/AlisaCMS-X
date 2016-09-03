<!--  ------------------------------------------------------------- -->
<div class="folders_all">Просмотр группы
			<h1 id="folders_title">Новые объявления</h1>
			<div id="folders_count_items">Элементов: <?=count($notices)?></div>
			<div id="all_show_items" style="margin-top:20px;"></div>
</div>

<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($notices); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? if(is_array($notices)){ foreach($notices as $notice){ ?>
<div class="ui-state-default-2 connectedSortable" id="prm_editItem/<?=$notice['link']?>">
	<div id="div_myitemname_1" class="div_myitemname" style="padding-top: 0px;<? if($notice['tmp']=='1'){ 
	?>background-color:#CCCCCC;<? } ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_105" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(105)"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show(105)" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_105" width="16" height="16" border="0"></a></td>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/no_img.gif" width="44" height="33" border="1" class="imggal" align="absmiddle" style="margin-right:5px;"></td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_105"><?=$notice['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<!--<td height="34" width="20"><a href="javascript:" title="Клонировать запись"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>-->
			<td height="34" width="20"><a href="javascript:" title="Одобрить объявление"><img src="/adminarea/template/images/green/myitemname_popup/ok_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="acceptNotice('<?=$notice['id']?>')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteNotice('<?=$notice['id']?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }} ?>
</div>
<!--  ------------------------------------------------------------- -->
<script>
function  acceptNotice(noticeId){
	var paction = "ajax=acceptNotice&noticeId="+noticeId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			getPage('/adminarea/newnotices/');
		}
	});
}
</script>