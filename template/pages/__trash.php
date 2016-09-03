<?
//echo "<pre>"; print_r($trash); echo "</pre>";
?>
<div class="admintitle" style="padding:0px; margin:0px;" >
	<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
</div>

<div class="folders_all">
<h1 id="folders_title">Утилизация</h1>
<? foreach($trash as $option){ if($option['external']=='0' && $option['trash']){ ?>
<div class="trashFolderTitle"><?=$option['name']?></div>

<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($items); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? if(is_array($option['trash'])){ foreach($option['trash'] as $item){
$lnk = false;
if($item['folder']=='1' && $titles['0']!='static') { //Выписываем дирректорию
	if($item['tumb']['0']['name']){
		$lnk = $classImages->createImageLink("../loadimages", "44x33", $item['tumb']['0']['name']);
	}
?>
	<div class="ui-state-default-2 connectedSortable" id="prm_?option=<?=$params['option']?>,trashOption=<?=$option['link']?>,parents=<?=$item['parents']?>,itemId=<?=$item['id']?>">
	<div class="div_myitemname" style="padding-top: 0px;font-size:11px;">
		<table id="folder_1" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_1" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(1)"></td>
			<? 	if($lnk){ ?><td height="34" width="50" align="center" style="background-image:url(<?=$GLOBALS['adminBase']?>/template/images/itemFolder.jpg);background-repeat:no-repeat;">
				<img src="/loadimages/<?=$lnk?>" width="24" height="18" border="1" class="imggal" align="absmiddle" style="margin-right:5px;margin-top:3px;">
			<? }else{ ?><td height="34" width="50" align="center" style="background-image:url(<?=$GLOBALS['adminBase']?>/template/images/itemFolder.jpg);background-repeat:no-repeat;">
			<? } ?></td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_1"><?=$item['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Восстановить блок"><img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/restore_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="restoreFromTrash('<?=$option['link']?>', '<?=$item['id']?>')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteOptionFolder('<?=$loadPage?>', '<?=$item['id']?>', '<?=str_replace("'", "\\'", $item['name'])?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }else{ //Выписываем элемент
if($item['tumb']['0']['name']){
	$lnk = $classImages->createImageLink("../loadimages", "44x33", $item['tumb']['0']['name']);
}
?>
<div class="ui-state-default-2 connectedSortable"
id="prm_?action=lookItem,trashOption=<?=$option['link']?>,option=<?=$params['option']?>,parents=<?=$params['parents']?>,itemId=<?=$item['id']?>">
	<div class="div_myitemname" style="padding-top: 0px;font-size:11px;<? if($item['tmp']=='1'){ 
	?>background-color:#CCCCCC;<? } ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_105" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(105)"></td>
			<td height="34" width="20">
			<? if($lnk){ ?>
			<img src="/loadimages/<?=$lnk?>" width="44" height="33"
			border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
			<? }else{ ?>
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/no_img.gif" width="44" height="33"
			border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
			<? } ?>
			</td>
			<td height="34" width=""
			style="font-weight:bold;font-size:11px;"><span id="span_myitemname_105"><?=$item['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<!--<td height="34" width="20"><a href="javascript:" title="Клонировать запись"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>-->
			<td height="34" width="20"><a href="javascript:" title="Восстановить блок"><img src="/adminarea/template/images/green/myitemname_popup/restore_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="restoreFromTrash('<?=$option['link']?>', '<?=$item['id']?>')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteNotice('<?=$item['id']?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }}} ?>
</div>

<? } } ?>
</div>
<script>
function restoreFromTrash(option, itemId){
	var objs = document.getElementsByClassName("connectedSortable");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		if(obj.id.match(RegExp("itemId="+itemId+"(,|$)", "gi")) && obj.id.match(RegExp("trashOption="+option+"(,|$)", "gi"))){
			obj.innerHTML = "<div class=\"trashPreloader\" id=\"itemName_"+itemId+"_"+option+"\"></div>";
			var paction =  "ajax=restoreFromTrash";
			paction += "&itemId="+itemId;
			paction += "&option="+option;
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: paction,
				success: function(html) {
					console.log(html);
					var data = eval("("+html+")");
					if(data.itemId){
						var obj = document.getElementById("itemName_"+data.itemId+"_"+data.option);
						obj.parentNode.removeChild(obj);
					}else{
						console.log("Ошибка");
					}
				}
			});
		}
	}
}
</script>