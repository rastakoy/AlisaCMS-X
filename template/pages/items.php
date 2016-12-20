<?
//echo "<pre>mainItem:"; print_r($mainItem); echo "</pre>";
?>

<div class="itemsContent" style="padding-right: 5px;">
<h3><?=$mainItem['name']?></h3>
<div id="itemsMultitype">

<? if(is_array($mainItem['childrenItems']['data'])){ foreach($mainItem['childrenItems']['data'] as $item){
if($item['tumb']['0']['name']){
	$lnk = $classImages->createImageLink("loadimages", "215x195", $item['tumb']['0']['name']);
}else{
	$lnk = "/template/images/no_photo.jpg";
}
?>
<div class="itemContainer" style="width:215px; border:#111111 solid 1px; border-radius:5px; background:url(/template/images/__bg_item.jpg) repeat-x top;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tbody><tr><td height="68" align="center" valign="middle">
<h2><a class="itemsItemName" href="/<?=$mainItem['href']?>/<?=$item['link']?>/">
<?=$item['name']?></a></h2></td></tr>
<tr><td style="border-bottom:#CCCCCC solid 1px;">
  <div align="center"><a href="/<?=$mainItem['href']?>/<?=$item['link']?>/"><img src="<?=$lnk?>" border="0" style="margin-bottom:10px;width:215px;height:195px;"></a></div></td>
</tr>
<? if($item['folder']=='0'){?>
<tr><td height="50" align="center" valign="middle">
<div style="width:110px; float:left; padding-top:4px;">	<span class="itemPrice"><?=$item['price']?> <span class="inItemPrice">грн.</span></span></div>
	<a href="/<?=$mainItem['href']?>/<?=$item['link']?>/">
	<div style="width:82px; height:30px; background-image:url(/template/images/kupit.jpg); float:right; margin-right:10px;"> </div>
	</a>
</td>
</tr>
<? } ?>
</tbody></table>
</div>
<? }} ?>
					 
</div>
</div>