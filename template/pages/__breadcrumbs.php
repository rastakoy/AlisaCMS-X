<div><div xmlns:v="http://rdf.data-vocabulary.org/#" id="div_breadlinks"><span typeof="v:Breadcrumb"><a href="./" rel="v:url" property="v:title">�������</a> � </span><span typeof="v:Breadcrumb"><a href="<?=$root['0']?>" rel="v:url" property="v:title"><?=$root['1']?></a> � </span><?
foreach($breadcrumbs as $key=>$crumb){
	if($key==count($breadcrumbs)-1){
		echo "<span typeof=\"v:Breadcrumb\">�������</a></span>";
	}else{
		echo "<span typeof=\"v:Breadcrumb\"><a href=\"$crumb[href]/\" rel=\"v:url\" property=\"v:title\">$crumb[name]</a> � </span>";
	}
}
?></div>
</div>