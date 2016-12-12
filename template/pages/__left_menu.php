<style>
#cssmenu, #cssmenu ul, #cssmenu ul li, #cssmenu ul li a {
    border: 0 none;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    display: block;
    line-height: 1;
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;
}
#cssmenu ul ul {
    display: none;
}
.holder {
    height: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: 0;
    margin-right: -35px;
    margin-top: -15px;
}
.holder:after, .holder:before {
    content: "";
    display: block;
    height: 6px;
    position: absolute;
    right: 20px;
    -webkit-transform: rotate(-135deg);
    -moz-transform: rotate(-135deg);
    transform: rotate(-135deg);
    width: 6px;
    z-index: 10;
}
.holder:after {
    border-left: 2px solid #ffffff;
    border-top: 2px solid #ffffff;
    top: 17px;
}
#cssmenu > ul > li > a:hover > span:after, 
#cssmenu > ul > li.active > a > span:after, 
#cssmenu > ul > li.open > a > span:after {
    border-color: #eeeeee;
}
.holder:before {
    border-left-color: inherit;
    border-left-style: solid;
    border-left-width: 2px;
    border-top-color: inherit;
    border-top-style: solid;
    border-top-width: 2px;
    top: 18px;
}
#cssmenu ul ul li a {
   /* background:#49505a;
    border-bottom: 1px solid #32373e;
    border-left: 1px solid #32373e;
    border-right: 1px solid #32373e;
    -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
    color: #eeeeee;
    font-size: 13px;*/
	display:block;
	min-height:35px;
    cursor: pointer;
    padding: 5px 0px;
    text-decoration: none;
    z-index: 1;
}
#cssmenu ul ul li:hover > a, 
#cssmenu ul ul li.open > a, 
#cssmenu ul ul li.active > a {
    background: none repeat scroll 0 0 #424852;
    color: #ffffff;
}
#cssmenu ul ul li:first-child > a {
    -webkit-box-shadow: none;
    box-shadow: none;
}
#cssmenu ul ul ul li:first-child > a {
    -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
}
#cssmenu ul ul ul li a {
    padding-left: 30px;
	color:#666666;
}
#cssmenu > ul > li > ul > li:last-child > a, 
#cssmenu > ul > li > ul > li.last > a {
    border-bottom: 0 none;
}
#cssmenu > ul > li > ul > li.open:last-child > a, 
#cssmenu > ul > li > ul > li.last.open > a {
    border-bottom: 1px solid #32373e;
}
#cssmenu > ul > li > ul > li.open:last-child > ul > li:last-child > a {
    border-bottom: 0 none;
}
#cssmenu ul ul li.has-sub > a:after {
    border-left: 2px solid #eeeeee;
    border-top: 2px solid #eeeeee;
    content: "";
    display: block;
    height: 5px;
    position: absolute;
    right: 20px;
    top: 11.5px;
    -webkit-transform: rotate(-135deg);
    -moz-transform: rotate(-135deg);
    transform: rotate(-135deg);
    width: 5px;
    z-index: 10;
}
#cssmenu ul ul li.active > a:after, 
#cssmenu ul ul li.open > a:after, 
#cssmenu ul ul li > a:hover:after {
    border-color: #ffffff;
}

</style>
<script type="text/javascript">
	$(document).ready(function () {
		$('#cssmenu li.has-sub > a').on('click', function(){
			$(this).removeAttr('href');
			var element = $(this).parent('li');
			if (element.hasClass('open')) {
				element.removeClass('open');
				element.find('li').removeClass('open');
				element.find('ul').slideUp();
			}
			else {
				element.addClass('open');
				element.children('ul').slideDown();
				element.siblings('li').children('ul').slideUp();
				element.siblings('li').removeClass('open');
				element.siblings('li').find('li').removeClass('open');
				element.siblings('li').find('ul').slideUp();
			}
		});

		$('#cssmenu>ul>li.has-sub>a').append('<span class="holder"></span>');
	});
</script>

<?




function constructLeftMenu($menus, $menuLink, $level=0){
	$arr = $menus;
	$ret = "";
	if(!is_array($arr) || count($arr)==0){
		return $ret;
	}
	//******************************
	$classImages = new Images();
	$thumbWidth = '48';
	$thumbHeight = '36';
	//******************************
	if($level=='0' && $menuLink){
		$arr = $menus[$menuLink]['children'];
	}
	if($level=='0'){
		$ret .= "<ul>\n";
	}elseif($level=='1'){
		$ret .= "<ul style=\"display:none;background-color:#CCCCCC;\">\n";
	}elseif($level=='2'){
		$ret .= "<ul style=\"display:none;\">\n";
	}
	foreach($arr as $menu){
		if($level=='0'){
			$ret .= "<li class=\"has-sub\" style=\"width:100%; border-bottom:dotted 1px #CCC; padding-bottom:3px; padding-top:3px;\">";
		}elseif($level=='1'){
			if(is_array($menu['children']) && count($menu['children'])>0){
				$ret .= "<li class=\"has-sub\">";
			}else{
				$ret .= "<li>";
			}
		}elseif($level=='2'){
			$ret .= "<li>";
		}
		if($level==0){
			if($menu['tumb']['0']['name']){
				
				$ret .= "<img src=\"$lnk\"  align=\"absmiddle\" border=\"1\" style=\" border:solid 1px #CCCCCC;\">";
			}else{
				$ret .= "<img src=\"/template/images/no_foto.jpg\"  align=\"absmiddle\" border=\"1\" style=\"border:solid 1px #CCCCCC;\">";
			}
		}
		$ret .= "<a href=\"".$menu['href']."\" class=\"\" ";
		if($level=='0'){
			$ret .= "style=\"width:210px; display: inline-table;\">";
		}
		$ret .= "$menu[name]";
		$ret .= "</a>\n";
		if(is_array($menu['children']) && count($menu['children'])>0){
			$ret .= constructLeftMenu($menu['children'], false, $level+1);
		}
		$ret .= "</li>\n";
	}
	$ret .= "</ul>\n";
	return $ret;
}
//echo "<pre>menus:"; print_r($menus); echo "</pre>";
//$leftMenu = constructLeftMenu($menus, 'left-tree-menu');
?>
<div style="min-height:450px; float:left; width:280px; margin-right:10px; padding-right:15px; border-right: #CCCCCC solid 1px;">
<div style="width:270px;float:left;padding-right: 0px;">

<div id='cssmenu'>
	<ul>
<? 
foreach($menus['left-tree-menu']['children'] as $rootMenu){ ?><? //if($row["id"] == $current["parent"]){echo " open";} ?>
<li class="has-sub" style="width:100%; border-bottom:dotted 1px #CCC; padding-bottom:3px; padding-top:3px;">
		<? //echo "row[id]=".$row["id"]; ?>
		<? //echo "current[parent]=".$current["parent"]; ?>
		<?  if($rootMenu['tumb']['0']['name']){
			$lnk = $classImages->createImageLink("loadimages", "48x36", $rootMenu['tumb']['0']['name']);
			echo "<img src=\"$lnk\" align=\"absmiddle\" border=\"1\" style=\"border:solid 1px #CCCCCC;\">";
		}else{
			echo "<img src=\"/template/images/no_foto.jpg\" align=\"absmiddle\" border=\"1\" style=\"border:solid 1px #CCCCCC;\">";
		} ?>
		<a href="<?=$rootMenu['href']?>" style="width:210px; display: inline-table;"><?=$rootMenu['name']?></a>
		<? //****************
			if(is_array($rootMenu['children']) && count($rootMenu['children'])>0){ ?>
				<ul style="background-color:#CCCCCC;">
					<? foreach($rootMenu['children'] as $sub1){ ?>
						<? if(is_array($sub1['children']) && count($sub1['children'])>0){ ?>
							<li class="has-sub"><a style="border-bottom:dotted 1px #FFF; padding-left:60px;" href="<?=$sub1['href']?>"><?=$sub1["name"]?></a>
							<ul style="">
								<? foreach($sub1['children'] as $sub2){?>
									<li><a style="border-bottom:dotted 1px #FFF;padding-left:60px;" href="<?=$sub2['href']?>"><?=$sub2["name"]?></a></li>
								<? } ?>
							</ul></li>
						<? }else{ ?>
							<li><a style="border-bottom:dotted 1px #FFF;padding-left:60px;" href="<?=$sub1["href"]?>"><?=$sub1["name"]?></a></li> 	
						<? } ?>
					<? //****************?>
					<? } ?>
				</ul>
				<? } ?>
		<? //****************?>
</li><? } ?>

</ul>
</div>

</div>
</div>