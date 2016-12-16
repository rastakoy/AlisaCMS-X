<? 
if($mainItem['id']=='0'){
//echo "<pro>"; print_r($mainItem); echo "</pro>";
 ?>
<h1><? echo $mainItem['option']['name']; ?></h1>
<? //echo "<pro>"; print_r($mainItem['childrenItems']); echo "</pro>"; ?>

	<? foreach($mainItem['childrenItems']['data'] as $item){ ?>
		<div style="border-top:#999999 1px dashed; margin-top:20px;">
			<a class="podrob" style="color:#333333;" href="<?=$item['link']?>"><h3><?=$item['name']?></h3></a>
		</div>
	<? } ?>

<? 
}
?>