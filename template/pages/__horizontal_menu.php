<style type="text/css">
vyp-menu, .vyp-menu li, .vyp-menu ul, .vyp-menu a, .vyp-menu:after {
	margin: 0; 
	padding: 0;
	z-index: 200;
	display: block;
}

.vyp-menu:after {
	background: #3C3C3C; /* убираем после меню действие float */ 
	clear: both;
	content: "";
}

.vyp-menu > li {
	float: left;
} /* горизонтальное размещение пунктов */

.vyp-menu li {
	white-space: nowrap; /* содержимое на одной строке */ 
	position: relative;
}

.vyp-menu > li, .vyp-menu > li > ul > li, .vyp-menu > li > ul > li > ul > li { overflow: hidden; } /* всё, что за пределами элемента, скрыто */
.vyp-menu > li:hover, .vyp-menu > li > ul > li:hover, .vyp-menu > li > ul > li > ul > li:hover {overflow: visible;}

.vyp-menu li ul li, .vyp-menu li ul li a { width: 300px; border:0px; }  /* фон подпунктов равной ширины */

.vyp-menu ul { position: absolute; background: #fff;}

.vyp-menu ul ul { left: 100%; top: 0; background: #fff; } /* третий и четвёртый список позиционируется не вниз, а вправо. Можно часть списков повернуть и влево, но тогда width должен быть задан в px */

.vyp-menu {
  background: #3C3C3C;
 /*background: -webkit-linear-gradient(#fff, #808080);
  background: -moz-linear-gradient(#fff, #808080);
  background: -o-linear-gradient(#fff, #808080);
  background: -ms-linear-gradient(#fff, #808080);
  background: linear-gradient(#fff, #808080);*/
}

.vyp-menu > li:first-child {border-radius: 5px 0 0 5px; border-left: none;}

.vyp-menu > li {
	border-left: 1px solid #999999;
	/*background-image: url(images/span.jpg);
	background-repeat: repeat-y;
	background-position: right;*/
}

.vyp-menu > li:hover {background: #3C3C3C;}

.vyp-menu li li {background: #3C3C3C content-box; padding: 1px 1px 0px 0px; border-right: 1px solid #000000;}

.vyp-menu li a {
  line-height: 40px;
  padding: 0 10px;
  text-decoration: none;
  color:#FFFFFF;
}
.vyp-menu li a:hover{
  color:#FFDB02;
}
ul.vyp-menu {
	padding-left: 15px;
}
</style>
<?
function constructMenu($menus, $menuLink, $level=0){
	$arr = $menus;
	$ret = "";
	if(!is_array($arr) || count($arr)==0){
		return $ret;
	}
	//******************************
	if($level=='0' && $menuLink){
		$arr = $menus[$menuLink]['children'];
	}
	if($level=='0'){
		$ret .= "<ul class=\"vyp-menu\">\n";
	}else{
		$ret .= "<ul>\n";
	}
	foreach($arr as $menu){
		$ret .= "<li><a href=\"".$menu['href']."\" class=\"a_hmta\">$menu[name]";
		if(is_array($menu['children']) && count($menu['children'])>0){
			$ret .= "&nbsp;<img src=\"/template/images/strelka.jpg\" border=\"0\" />";
		}
		$ret .= "</a>\n";
		if(is_array($menu['children']) && count($menu['children'])>0){
			$ret .= constructMenu($menu['children'], false, $level+1);
		}
		$ret .= "</li>\n";
	}
	$ret .= "</ul>\n";
	return $ret;
}
//echo "<pre>menus:"; print_r($menus); echo "</pre>";
echo constructMenu($menus, 'horizontal-dropout-menu');

 
//	$query_temp_c ="SELECT * FROM  items WHERE  parent=0 && folder=1 $dop_query  order by prior asc, name asc";
//	$resp_qt_c = mysql_query($query_temp_c);
//	//$row_qt_c = mysql_fetch_assoc($resp_qt_c);
//	//$query_temp_k - клиентам
//	$query_temp_k ="SELECT * FROM  items WHERE  parent=0 ";
//	$resp_qt_k = mysql_query($query_temp_k);
	//$row_qt_k = mysql_fetch_assoc($resp_qt_k);
 ?>
<? /*
<!-- <ul class="vyp-menu">
	<li><a href="/" class="a_hmta">Главная</a></li>
	<li><a href="/items/" class="a_hmt">Каталог продукции&nbsp;&nbsp;<img src="images/strelka.jpg" border="0" /></a>
		<ul>
			<? while($row_qt_c = mysql_fetch_assoc($resp_qt_c)){?>
			<li><a href="/items/<? echo $row_qt_c["href_name"]; ?>"><? echo $row_qt_c["name"]; ?></a>
				<? $query_temp_cc ="SELECT * FROM  items WHERE  parent=$row_qt_c[id] && folder=1";
				$resp_qt_cc = mysql_query($query_temp_cc);
				if(mysql_num_rows($resp_qt_cc)>0){?>
				<ul>
					<? while($row_qt_cc = mysql_fetch_assoc($resp_qt_cc)){?>
						<li><a href="/items/<? echo $row_qt_c["href_name"]; ?>/<? echo $row_qt_cc["href_name"]; ?>"><? echo $row_qt_cc["name"]; ?></a></li>
					<? } ?>
				</ul>
				<? } ?>
			</li>
			<? } ?>
		</ul>
	</li>
	<li><a href="/company/" class="a_hmt">О компании</a></li>
	<li><a href="/uslugi/" class="a_hmt">Наши услуги</a></li>
	<li><a href="/news/" class="a_hmt">Клиентам&nbsp;&nbsp;<img src="images/strelka.jpg" border="0" /></a>
		<ul>
			<? while($row_qt_k = mysql_fetch_assoc($resp_qt_k)){?>
			<li><a href="/news/<? echo $row_qt_k["href_name"]; ?>"><? echo $row_qt_k["name"]; ?></a>
				<? $query_temp_kc ="SELECT * FROM  items WHERE  parent=$row_qt_k[id] && folder=1 ";
				$resp_qt_kc = mysql_query($query_temp_kc);
				if(mysql_num_rows($resp_qt_kc)>0){?>
				<ul>
					<? while($row_qt_kc = mysql_fetch_assoc($resp_qt_kc)){?>
						<li><a href="/news/<? echo $row_qt_k["href_name"]; ?>/<? echo $row_qt_kc["href_name"]; ?>"><? echo $row_qt_kc["name"]; ?></a></li>
					<? } ?>
				</ul>
				<? } ?>
			</li>
			<? } ?>
		</ul>
	</li>
	<li><a href="/partners/" class="a_hmt">Партнеры</a></li>
	<li><a href="/produkt/" class="a_hmt">Наша продукция</a></li>
	<li><a href="/contact/" class="a_hmt">Контакты</a></li>
	<li><a href="http://www.sigma.pl.ua/files/price.xls" class=""><img src="images/price.jpg" border="0" /></a></li>
</ul>
-->
*/
?>