<h2>Управление фильтром</h2>
<? //echo "<pre>"; print_r($GLOBALS['languages']); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($filter); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($langFields); echo "</pre>"; ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <? if(is_array($GLOBALS['languages'])){ foreach($GLOBALS['languages'] as $key=>$lang){
  $langPrefix = "";
  if($GLOBALS['language']!=$key){ $langPrefix="_$key"; }
  	foreach($langFields as $langField){
  		if($key==$langField['filters']['0']['currentLang']){
			if($langField['filters']['0']['hasLang']=='1' || $GLOBALS['language']==$langField['filters']['0']['currentLang']){
  //if($GLOBALS['language']==$key || )?>
	<tr>
		<td width="150" height="30">Название <? if($GLOBALS['language']!=$key){ ?>(<?=$lang['1']?>)<? } ?></td>
		<td><input type="text" id="filterName<?=$langPrefix?>" value="<?=$filter["name$langPrefix"]?>" /></td>
	</tr>
  <? }}}}} ?>
  <!--<tr>
    <td width="150" height="30">Название</td>
    <td><input type="text" id="filterName" value="<?=$filter['name']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">Название украинское</td>
    <td><input type="text" id="filterNameUkr" value="<?=$filter['name_ukr']?>" /></td>
  </tr>
  -->
  <tr>
    <td width="150" height="30">Путь</td>
    <td><input type="text" id="filterLink" value="<?=$filter['link']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">Отобрежается в фильтрах на сайте</td>
    <td><input type="checkbox" id="filterInFilter" <? if($filter['inFilter']=='1'){ ?>checked<? } ?> /></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><button onclick="saveFilterClass()">Сохранить</button>&nbsp;&nbsp;
	<button onclick="__css_itemShowCSS_close()">Отменить</button></td>
  </tr>
</table>
<script>
var classLangs = new Array();
<? if(is_array($GLOBALS['languages'])){ $count=0; foreach($GLOBALS['languages'] as $key=>$lang){
	$langPrefix = "";
	if($GLOBALS['language']!=$key){ $langPrefix="_$key"; }
  		foreach($langFields as $langField){
  			if($key==$langField['filters']['0']['currentLang']){
				if($langField['filters']['0']['hasLang']=='1' || $GLOBALS['language']==$langField['filters']['0']['currentLang']){
					echo "classLangs[$count] = '$langPrefix';\n";
					$count++;
}}}}}
?>
//alert(classLangs);
//*********************************
function getFilterFieldType(type){
	paction =  "ajax=getFilterFieldType&type="+type+"&parent=<?=$filter['parent']?>&id=<?=$filter['id']?>";
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			document.getElementById("sel_fieldname").innerHTML = "";
			var inner = "";
			for(var j in data){
				inner += "<option value=\""+data[j]+"\">"+data[j]+"</option>";
			}
			document.getElementById("sel_fieldname").innerHTML = inner;
		}
	});
}
//*********************************
function saveFilterClass(){
	var paction =  "ajax=saveFilterClass";
	paction += "&filterId=<?=$filter['id']?>";
	for(var j=0; j<classLangs.length; j++){
		paction += "&filterName"+classLangs[j]+"="+encodeURIComponent(document.getElementById("filterName"+classLangs[j]).value);
	}
	paction += "&filterLink="+document.getElementById("filterLink").value;
	if(document.getElementById("filterInFilter").checked){
		paction += "&filterInFilter=1";
	}else{
		paction += "&filterInFilter=0";
	}
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			if(data.return=='ok'){
				__css_itemShowCSS_close();
			}else{
				alert("Ошибка редактирования");
			}
		}
	});
}
//*********************************

//*********************************

//*********************************
</script>