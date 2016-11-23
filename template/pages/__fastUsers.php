<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($option); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($items); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<?
$thumbWidth = '44';
$thumbHeight = '33';
$divHeight = "36";
$tdHeight = "34";
?>
<? if(is_array($users)){ foreach($users as $user){
$lnk = false;
if($item['folder']=='1' && $titles['0']!='static') { //Выписываем дирректорию
	if($item['tumb']['0']['name']){
		$lnk = $classImages->createImageLink("../loadimages", "44x33", $item['tumb']['0']['name']);
	}
?>
	<div class="ui-state-default-2 connectedSortable" id="prm_<?=$item['parents']?>,<?=$params['orderId']?>">
	<div class="div_myitemname" style="padding-top: 0px;height:<?=$divHeight?>px;cursor:pointer;" onclick="fastAssoc(this)">
		<table id="folder_1" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="<?=$tdHeight?>" width="20">&nbsp;</td>
			<? if($option['useimg']=='1'){ ?>
				<? if($lnk){ ?><td height="<?=$tdHeight?>" width="50" align="center" style="background-image:url(<?=$GLOBALS['adminBase']?>/template/images/itemFolder.jpg);background-repeat:no-repeat;background-position:left center;">
					<img src="/loadimages/<?=$lnk?>" width="24" height="18" border="1" class="imggal" align="absmiddle" style="margin-right:5px;margin-top:3px;">
				<? }else{ ?><td height="34" width="50" align="center" style="background-image:url(<?=$GLOBALS['adminBase']?>/template/images/itemFolder.jpg);background-repeat:no-repeat;background-position:left center;">
				<? } ?></td>
			<? } ?>
			<td height="34" width="" style="font-weight:bold;"><span id="itemName_<?=$item['id']?>"><?=$item['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
		</tr></table>
	</div>
</div>
<? }else{ //Выписываем элемент
if($item['tumb']['0']['name']){
	$lnk = $classImages->createImageLink("../loadimages", $thumbWidth."x".$thumbHeight, $item['tumb']['0']['name']);
}
?>
<div class="ui-state-default-2 connectedSortable"
id="prm_<?=$params['orderId']?>,<?=$user['id']?>">
	<div class="div_myitemname" style="padding-top: 0px;cursor:pointer;height:<?=$divHeight?>px;<? if($item['tmp']=='1'){ 
	?>background-color:#CCCCCC;<? } ?>" onclick="associateClientWithOrder('<?=$params['orderId']?>','<?=$user['id']?>')">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="<?=$tdHeight?>" width="20">&nbsp;</td>
			<? if($option['useimg']=='1'){ ?>
				<td height="34" width="20">
				<? if($lnk){ ?>
				<img src="/loadimages/<?=$lnk?>" width="<?=$thumbWidth?>" height="<?=$thumbHeight?>"
				border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
				<? }else{ ?>
				<img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/no_img.gif"
				width="<?=$thumbWidth?>" height="<?=$thumbHeight?>"
				border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
				<? } ?>
				</td>
			<? } ?>
			<td height="34" width="200" style="font-weight:bold;"><span id="itemName_<?=$item['id']?>"><?=$user['fio']?></span></td>
			<td height="34" width=""><?=$user['email']?></td>
			<td height="34" width="20">&nbsp;</td>
		</tr></table>
	</div>
</div>
<? }}} ?>
</div>
<? //echo "<pre>"; print_r($params); echo "</pre>"; ?>
<script>
//*********************************************************
//function foo(){}
//*********************************************************
</script>