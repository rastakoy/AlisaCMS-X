<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">

	<div class="ui-state-default-2 connectedSortable" id="">
	<div class="div_myitemname" style="padding-top: 0px;">
		<table cellpadding="2" cellspacing="1" border="0" width="100%" bgcolor="#CCCCCC"><tr>
			<td height="34" width="20" style="font-weight:bold;" bgcolor="#FFFFFF">№</td>
			<td height="34" width="50" bgcolor="#FFFFFF">&nbsp;</td>
			<td height="34" width="180" style="font-weight:bold;" bgcolor="#FFFFFF">Название</td>
			<td height="34" width="100" style="font-weight:bold;" bgcolor="#FFFFFF" align="center">
			<img src="/template/images/basket/price.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="50" style="font-weight:bold;" align="center" bgcolor="#FFFFFF">
			<img src="/template/images/basket/inbasket.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="70" style="font-weight:bold;" align="center" bgcolor="#FFFFFF">%</td>
			<td height="34" width="120" style="font-weight:bold;" align="center" bgcolor="#FFFFFF">
			<img src="/template/images/basket/price-discount.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="100" align="" bgcolor="#FFFFFF">
			<img src="/template/images/basket/sum.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="30" bgcolor="#FFFFFF">&nbsp;</td>
			<td height="34" width="" bgcolor="#FFFFFF">&nbsp;</td>
		</tr></table>
	</div></div>
<? //echo "<pre>"; print_r($items); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? //echo "<pre>orderStatuses:"; print_r($orderStatuses); echo "</pre>"; ?>
<? if(is_array($items)){
$count=1;
$allSum=0;
foreach($items as $item){
$lnk = false;
if($item['folder']=='1' && $titles['0']!='static') { //Выписываем дирректорию  ?>

<? }else{ //Выписываем элемент
if($item['item']['tumb']['0']['name']){
	$lnk = $classImages->createImageLink("../loadimages", "44x33", $item['item']['tumb']['0']['name']);
}
?>
<div class="ui-state-default-2 connectedSortable"
id="prm_?action=editItem,option=<?=$params['option']?>,parents=<?=$params['parents']?>,itemId=<?=$item['id']?>">
	<div class="div_myitemname" style="padding-top: 0px;height:56px;">
		<table cellpadding="2" cellspacing="1" border="0" width="100%" bgcolor="#CCCCCC"><tr>
			<td height="54" width="20" bgcolor="#FFFFFF"><?=$count?></td>
			<? if($option['useimg']=='1'){ ?>
				<td height="34" width="50" bgcolor="#FFFFFF">
				<? if($lnk){ ?>
				<img src="/loadimages/<?=$lnk?>" width="44" height="33"
				border="1" class="imggal" align="absmiddle" style="">
				<? }else{ ?>
				<img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/no_img.gif" width="44" height="33"
				border="1" class="imggal" align="absmiddle" style="">
				<? } ?>
				</td>
			<? } ?>
			<td height="34" width="180" style="font-weight:bold;" bgcolor="#FFFFFF"><span
			id="itemName_<?=$item['id']?>"><?=$item['item']['name']?></span></td>
			<td height="34" width="100" align="center" bgcolor="#FFFFFF"><?=$item['price']?></td>
			<td height="34" width="50" align="center" bgcolor="#FFFFFF"><input type="number" style="width:45px;height:30px;" min="1" step="1"
			max="1000" id="qtty_<?=$item['id']?>_<?=$params['orderId']?>" value="<?=$item['qtty']?>"
			onchange="changeOrderQtty(this)"></td>
			<td height="34" width="70" style="font-weight:bold;" align="center" bgcolor="#FFFFFF">---</td>
			<td height="34" width="120" style="font-weight:bold;" align="center" bgcolor="#FFFFFF">---<?=$item['item']['priceDiscount']?></td>
			
			<?  // общая сумма расчета позиции
			$sum = $item['price'] * $item['qtty'];
			?>
			<td height="34" width="100" style="font-weight:bold;" align="" bgcolor="#FFFFFF"><?=$sum?></td>
			
			<td height="34" width="30" bgcolor="#FFFFFF"><a href="javascript:" title="Удалить товар"><img
			src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105"
			width="16" height="16" border="0" align="left" style="margin-right:5px;cursor:pointer;margin-top:5px;"
			onclick="deleteItemFromOrder('<?=$params['orderId']?>', '<?=$item['id']?>')"></a></td>
			<td height="34" width="" bgcolor="#FFFFFF">&nbsp;</td>
		</tr></table>
	</div>
</div>
<?
$count++;
$allSum += $sum;
}}} ?>


	<div class="ui-state-default-2 connectedSortable" id="">
	<div class="div_myitemname" style="padding-top: 0px;">
		<table cellpadding="2" cellspacing="1" border="0" width="100%" bgcolor="#CCCCCC"><tr>
			<td height="34" width="600" style="font-weight:bold; padding-left:22px;" bgcolor="#FFFFFF">Общая сумма</td>
			<td height="34" width="100" align="" bgcolor="#FFFFFF"><?=$allSum?></td>
			<td height="34" width="" bgcolor="#FFFFFF">&nbsp;</td>
		</tr></table>
	</div></div>


</div>

<div align="center">
	<div style="width:320px;height:30px;margin-top:14px;">
	<button onclick="confirmOrder('<?=$params['orderId']?>')" 	style="margin-right:15px;" >Продолжить покупку</button>
	<button onclick="__popup_close()" style="" >Закрыть корзину</button>
	</div>
</div>