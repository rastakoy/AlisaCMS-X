<?
//echo "<pre>siteSettings:"; print_r($siteSettings); echo "</pre>";
//echo "<pre>mainItem:"; print_r($mainItem); echo "</pre>";
?>
<div id="div_myitems">
<h1 style="margin-bottom:5px;"><?=$mainItem['name']?></h1>
<?
$breadcrumbs = $mainItem['breadCrumbs'];
$root = array($array['0'], 'Каталог');
require_once("__breadcrumbs.php"); ?>
<div style="height:20px;"></div>
<!--  -----------------------------------------  -->
<div id="item_left_block"><div id="div_fancybox" style="">
<?
$key = '0';
foreach($mainItem['tumb'] as $key=>$image){
	if($key=='0'){
		$imglink = $classImages->createImageLink("loadimages", "320x240", $image['name']);
		//require("templates/imagePreweaver/iprew.php");
		//echo "<div class=\"div_itemimg\"><img id=\"itemgimg\" src=\"/loadimages/$img_row[link]\" class=\"item_image\" 
		//style=\"width:320px;height:240px;cursor:pointer;\"    />";
		//echo "</div>";
		echo "<div class=\"div_itemimg\"><a id=\"jqzoomer\" href=\"/loadimages/".($image['name'])."\" class=\"jqzoom\" rel='gal1'  title=\"\" >";
		echo "<img id=\"itemgimg\" src=\"$imglink\" class=\"item_image\" title=\"\"
		style=\"width:320px;height:240px;cursor:pointer;\"    />";
		echo "</a></div>";
		//****************************************
		//echo "<script>__ip_initIp('itemgimg')</"."script>";
		echo "<img src=\"/template/images/ico/itemButtonLeft.png\" ";
		echo "style=\"float:left;margin-top:25px;width:24px;\" class=\"itemButtonLeft\"  onClick=\"moveSubImages('left')\" />";
			echo "<div id=\"subImages\" style=\"margin-left:5px\" ><div id=\"subImagesContainer\" ";
			echo "style=\"width:".(count($mainItem['tumb'])*87)."\">";
			echo "<script>var subImagesContainerMarginMax=".((count($mainItem['tumb'])-1-6)*87).";</script>";
			echo "<script>var subImagesContainerStepMax=".(count($mainItem['tumb'])-3).";</script>";
		echo "<div class=\"div_itemimg\"><a rel=\"{gallery: 'gal1', smallimage: '$imglink',largeimage: '/loadimages/$image[name]'}\">";
		echo "<img src=\"/loadimages/$image[name]\" class=\"item_image_small\"  onClick=\"revolve_image(this)\" ";
		echo "style=\"cursor:pointer; width:80px; height:60px; \"   /></a></div>";
		echo "<script>curSimgParent='$mainItem[id]';</script>";
	}else{
		if($imglink!=""){
			$imglink = $classImages->createImageLink("loadimages", "320x240", $image['name']);
			echo "<div class=\"div_itemimg\"><a rel=\"{gallery: 'gal1', smallimage: '$imglink',largeimage: '/loadimages/$image[name]'}\">";
			echo "<img src=\"$imglink\" class=\"item_image_small\"  onClick=\"revolve_image(this)\" 
			style=\"cursor:pointer; width:80px; height:60px; \"   /></a></div>";
		}
	}
	$cc++;
}
if($cc==1){
	//echo "<div style=\"height: 100px;\"></div>";
}
if(count($mainItem['tumb'])>0){
	echo "</div></div>";
	echo "<img src=\"/template/images/ico/itemButtonRight.png\" style=\"float:left;margin-top:25px;width:24px;\" ";
	echo "class=\"itemButtonRight\" onClick=\"moveSubImages('right')\" />";?>
<script type="text/javascript">
$(document).ready(function() {
	//return false;
	$('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false
        });
});
</script>
<? } ?>
<script>
var subImagesContainerStep = 0;
var subImagesContainerValue = 85;
var subImagesContainerMargin = 0;
function moveSubImages(val, steps){
	if(val=="right"){
		if(subImagesContainerStep>-subImagesContainerStepMax){
			if(steps){
				subImagesContainerStep = -steps;
				if(subImagesContainerStep<-subImagesContainerStepMax){
					subImagesContainerStep = -subImagesContainerStepMax;
				}
			}else{
				subImagesContainerStep -= 1;
			}
			subImagesContainerMargin = subImagesContainerValue*subImagesContainerStep;
		}
	}
	if(val=="left"){
		if(subImagesContainerMargin<0){
			//alert(typeof steps);
			if(typeof steps!="undefined"){
				subImagesContainerStep = -steps;
				if(subImagesContainerStep>0){
					subImagesContainerStep = 0;
				}
			}else{
				subImagesContainerStep += 1;
			}
		}
		//alert(subImagesContainerValue*subImagesContainerStep);
		subImagesContainerMargin = subImagesContainerValue*subImagesContainerStep;
	}
	document.getElementById("subImagesContainer").style.marginLeft = subImagesContainerMargin;
}
//******************************************
var curSimgParent = false;
function revolve_image(rObj){
	var obj = document.getElementById("itemgimg");
	$(".item_image_small").css("border","1px solid #CCCCCC");
	obj.src = rObj.src.replace(/80x60\//, "");
	$(rObj).css("border","1px solid #A30001");
	testSrc = rObj.src.replace(/^.*\//, '');
	if(curSimgParent!=rObj.imgpar && curSimgParent){
		multiitem_change(rObj.imgpar,document.getElementById('fmiId_'+rObj.imgpar), testSrc);
	}
}
</script>
<?
if($key>0){
	echo "<div style=\"float:none;clear:both;\"></div>";
}
if(count($mainItem['tumb'])==0){
	echo "<div class=\"div_itemimg\"><img id=\"itemgimg\" src=\"/template/images/no_photo.jpg\" class=\"item_image\" 
	style=\"width:320px;height:240px;\"    />";
	echo "</div>";
}
echo "</div><div style=\"float:none;clear:both;\"></div>";
?>
</div>
<!--  -----------------------------------------  -->
<div id="item_right_block" style="width: 231.284px;">
<!--<div class="item_phone">
	<span class="item_phone_txt">Заказать по телефону</span><br/>
	<span class="item_phone_phone">(099) 423-02-99</span><br/>
	<span class="item_phone_phone">(096) 316-77-95</span>
</div>
<div class="item_separator" style="margin-bottom: 10px;"></div>-->

<!-- #############################################################  -->

<div class="__item_template_01_info_block" id="myItemPriceBlock" style="width:300px;">
<script>
var myPriceDigit='';
var  reccIndex='7255';
var  orderIndex='';
var  orderKey=-1;
</script>
<div style="float:left; width: 300px;line-height:25px;">
	<span>
	<b>На складе: </b><span style="" id="onStore">есть</span><br>
	<b>Цена:</b>
	</span><span class="filtername" style="display:inline;margin-top: 0px; margin-bottom: 5px;" id="itemPrice"><?=$mainItem['price']?> грн.</span><br>
	<span><input type="number" value="<?=($mainItem['isItemInBasket']['qtty'])?$mainItem['isItemInBasket']['qtty']:'1'?>"
	style="width:60px; height:30px;"
	id="qttyItem<?=($mainItem['isItemInBasket']['qtty'])?"_".$mainItem['isItemInBasket']['id']:'_'.$mainItem['id']?><?=($mainItem['isItemInBasket']['qtty'])?"_".$mainItem['isItemInBasket']['orderId']:''?>"
	step="1" min="1" max="1000" <? if($mainItem['isItemInBasket']['qtty']){
	?>onchange="changeOrderQtty(this)"<? } ?> ></span>
	<span id="spanEdiz" style=""></span><br>
	<b>Итого: </b><span id="itemItogo">0 грн.</span>
</div>
<div style="margin-top:30px;"><? if($mainItem['isItemInBasket']['qtty']>0){ ?>
<span id="basket_icon" style="background-image: url(/template/images/basket_empty.gif); margin-top: 0px;"></span>
<a id="basket_button" href="javascript:" onclick="showBasket(this)" class="item_bye_butt" style="margin-top: 0px;">В корзине</a><? }else{ ?>
<span id="basket_icon" style="background-image: url(/template/images/basket_empty.gif); margin-top: 0px;"></span>
<a id="basket_button" href="javascript:" onclick="addItemIntoOrder(this, '<?=$mainItem['id']?>')" class="item_bye_butt" style="margin-top: 0px;">Купить</a><? } ?>
<br><br><br>
</div>
</div>
<div style="float:none;clear:both;">
<div id="orderPoshiv" style="display:none;">
</div>
<script>
//var APriceBlock=false;
//$(document).ready(function(){
//	if(APriceBlock)  APriceBlock.innerHTML = "";
//	//APriceBlock = construct_price_block({"id":"myItemPriceBlock"});
//	if(multiitem){
//		document.getElementById('fmiId_7255').onclick();
//		//multiitem_change(reccIndex,document.getElementById('fmiId_7255').onclick());
//	}else{
//		multiitem_change(reccIndex, false);
//	}
//});
</script>
<!-- #############################################################  -->
<script>var mtmLevels = 0;activate_filter=false;</script>
<!-- #############################################################  -->
<div class="item_separator" style="margin-bottom: 10px;"></div>
<!-- #############################################################  -->
<!---->
<!-- #############################################################  -->
<!-- #############################################################  -->
<br><br><br><br>
<!-- <div class=\"item_separator\" style=\"margin-bottom: 10px;\">asd</div> -->

</div>
<!--  -----------------------------------------  -->
</div>
<!--  -----------------------------------------  -->
</div>