<div><div xmlns:v="http://rdf.data-vocabulary.org/#" id="div_breadlinks"><span typeof="v:Breadcrumb"><a href="./" rel="v:url" property="v:title">√лавна€</a> Ы </span><span typeof="v:Breadcrumb"><a href="<?=$root['0']?>" rel="v:url" property="v:title"><?=$root['1']?></a> Ы </span><?
foreach($breadcrumbs as $key=>$crumb){
	if($key==count($breadcrumbs)-1){
		echo "<span typeof=\"v:Breadcrumb\"> аталог</a></span>";
	}else{
		echo "<span typeof=\"v:Breadcrumb\"><a href=\"$crumb[href]/\" rel=\"v:url\" property=\"v:title\">$crumb[name]</a> Ы </span>";
	}
}
?></div>
</div>