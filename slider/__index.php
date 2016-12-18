<link rel="stylesheet" href="../slider/style.css" type="text/css" media="screen" />	
<link rel="stylesheet" href="../slider/nivo-slider.css" type="text/css" media="screen" />
<script type="text/javascript" src="../slider/scripts/jquery.nivo.slider.js"></script>
<? 
	$img_query = "SELECT *  FROM `images` WHERE `externalId` = 1 AND `table` LIKE 'texts' ORDER BY PRIOR ASC";
	$img_resp = mysql_query($img_query);
	echo "<div id=\"slider\" class=\"nivoSlider\">";
	$cc = 0;
	while($img_row = mysql_fetch_assoc($img_resp)){
		echo "<a href=\"\"><img src=\"../loadimages/$img_row[name]\" /></a>";
		$cc++;
	}
	echo "</div>";
?>			 
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider();
});
</script>