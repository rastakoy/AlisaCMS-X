<? 
if($mainItem['id']=='0'){
//echo "<pro>"; print_r($mainItem); echo "</pro>";
 ?>
<h1><? echo $mainItem['option']['name']; ?></h1>
<? //echo "<pro>"; print_r($mainItem['childrenItems']); echo "</pro>"; ?>

	<? foreach($mainItem['childrenItems']['data'] as $item){ ?>
		<?
		if($item['tumb']['0']['name']){
			$lnk = $classImages->createImageLink("loadimages", "215x195", $item['tumb']['0']['name']);
		}
		?>
		<div style="border-top:#999999 1px dashed; margin-top:20px;">
			<img src="<?=$lnk?>" border="0" style="margin-bottom:10px;width:215px;height:195px; float:left; padding-right:10px;" />
			<a class="podrob" style="color:#333333;" href="<?=$item['link']?>"><h3><?=$item['name']?></h3></a>
			<?=$item['content']?>
		</div>
		<div style="float:none; clear:both;"></div>
	<? } ?>

<? 
}
?>