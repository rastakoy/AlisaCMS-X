<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td><div style="float:left;">
		<?
		$classBarcode->code39($classBarcode->addZeros($item['id']));
		?>
	<div style="float:left;padding-left:20px; padding-top:20px;">
	<button onclick="managePrintBarCode('<?=$item['id']?>', '<?=$params['option']?>')"
	style="width:200px;height:25px;margin-bottom:7px;">Настроить макет ценника</button>
	<br/>
	<button onclick="printBarCode('<?=$item['id']?>', '<?=$params['option']?>')" style="width:200px;height:25px;">Вывести на печать</button><br/>
	</div>
	</div></td>
</tr></table>
<div id="barcodeContainer"></div>
<script>
function printBarCode(id, table){
	var obj1 = document.getElementById("barcodeContainer");
	var inner = "<iframe border=\"0\" style=\"display:none;\" src=\"";
	inner += "<?=$GLOBALS['adminBase']?>/template/pages/printbarcode.php?id="+id+"&table="+table+"\" ></iframe>";
	obj1.innerHTML = inner;
}
//******************************************
function managePrintBarCode(id, table){
	document.getElementById("popup_title").innerHTML = "Настройка макета ценника";
	__popup();
}
</script>