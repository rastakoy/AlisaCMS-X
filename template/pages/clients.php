<? 
if($mainItem['id']=='0'){
//echo "<pro>"; print_r($mainItem); echo "</pro>";
 ?>
<h1><? echo $mainItem['option']['name']; ?></h1>
<? //echo "<pro>"; print_r($mainItem['childrenItems']); echo "</pro>"; ?>

	<? foreach($mainItem['childrenItems']['data'] as $item){ ?>
		<div style="border-top:#999999 1px dashed; margin-top:20px;">
			<h3><?=$item['name']?></h3>
			<a class="podrob" href="/<?=$mainItem['href']?>/<?=$item['link']?>/"><div>Подробнее</div></a>
		</div>
	<? } ?>

<? 
} else {
	echo "<h1>".$mainItem['name']."</h1>";
	echo $mainItem['content'];
	
$key = '0';
foreach($mainItem['tumb'] as $key=>$image){
	if($key=='0'){
		echo "<img src=\"/loadimages/$image[name]\" class=\"item_image_small\"  onClick=\"revolve_image(this)\" ";
		echo "style=\"cursor:pointer; width:100%; \"   />";
	} 
	$cc++;
}

}
?>