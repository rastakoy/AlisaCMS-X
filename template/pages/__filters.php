<? if($filter['parent']=='0'){ ?>
<?
//echo "<pre>TITLES"; print_r($titles); echo "</pre>";
$addItem = true;
$addItemTitle = "Добавить<br/>".$titles['1']['2'][count($parents)];
?>
<div class="admintitle" style="padding:0px; margin:0px;" >
	<a href="javascript:getData('<?=$GLOBALS['adminBase']?>/?action=editItem,option=filter')" id="add_item_to_cat_button"
		style="width:85px;"><?=$addItemTitle?></a>
	<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
	<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	<?  //echo $__page_title; ?>
</div>
<div style="float:none; clear:both;"></div>
<div class="manageadminforms" id="edit_content" style="display:;padding-top:10px;">
<b style="text-transform:uppercase;" id="titlePanel">Управление шаблоном «<?=$filter['name']?>»</b>
<div style="height:20px;"></div>
<? //echo "<pre>"; print_r($GLOBALS['languages']); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($filter); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($langFields); echo "</pre>"; ?>
<div style="float:none;clear:both;"></div>
<div style="background-color:#A9C9A7; padding:15px;">
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
  <tr>
    <td width="150" height="30">Путь</td>
    <td><input type="text" id="filterLink" value="<?=$filter['link']?>" /></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><button onclick="saveFilterClass()">Сохранить</button>&nbsp;&nbsp;
	<button onclick="__css_itemShowCSS_close()">Отменить</button></td>
  </tr>
</table>
</div></div>
<script>
var classLangs = new Array();
<?
if(is_array($GLOBALS['languages'])){ $count=0; foreach($GLOBALS['languages'] as $key=>$lang){
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
	//console.log(paction);
	//return false;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			if(data.return=='ok'){
				getData('<?=$GLOBALS['adminBase']?>/?option=filters');
			}else{
				console.log("Ошибка редактирования");
			}
			stopPreloader();
		}
	});
}
//*********************************

//*********************************

//*********************************
</script>

<? }else{ ?>
<?
//echo "<pre>TITLES"; print_r($titles); echo "</pre>";
$addItem = true;
$addItemTitle = "Добавить<br/>".$titles['1']['2'][count($parents)];
?>

<? //echo "<pre>"; print_r($GLOBALS['languages']); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($filter); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($langFields); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($GLOBALS); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($filter); echo "</pre>"; ?>
<? //echo "<pre>options: "; print_r($options); echo "</pre>"; ?>

<div class="admintitle" style="padding:0px; margin:0px;" >
	<a href="javascript:getData('<?=$GLOBALS['adminBase']?>/?action=editItem,option=filter,parents=<?=$params['params']?>')" id="add_item_to_cat_button"
		style="width:85px;"><?=$addItemTitle?></a>
	<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
	<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	<?  //echo $__page_title; ?>
</div>
<div style="float:none; clear:both;"></div>
<div class="manageadminforms" id="edit_content" style="display:;padding-top:10px;">
<b style="text-transform:uppercase;" id="titlePanel">Управление шаблоном «<?=$filter['name']?>»</b>
<div style="height:20px;"></div>
<div style="float:none;clear:both;"></div>

<div class="languagesTabs"><? foreach($GLOBALS['languages'] as $key=>$lang){ ?>
	<span <?
	if((!$params['lang'] && $key==$GLOBALS['language']) || $params['lang']==$key){
		echo "class=\"active\"";
	}else{?>onclick="getData(window.location.pathname+'<?=$paramsString?>', 'lang', '<?=$key?>')"<? } ?> ><?=$lang['0']?></span>
<? } ?></div><div style="float:none;clear:both;"></div>
<div style="background-color:#A9C9A7; padding:15px;">
<table width="100%" border="0" cellspacing="1" cellpadding="1" id="table_allFilterSettings">
  <tr>
    <td width="200" height="30">Название</td>
    <td><input type="text" id="fieldName"
	value="<?=$filter["name$prefix"]?>" style="width:350px;height:25px;padding-left:3px;" /></td>
  </tr>
  <!--<tr>
    <td height="30" width="200">Таблица в базе данных</td>
    <td><select onchange="getFilterFieldType()" id="sel_tablename" style="width:350px;height:25px;">
	<option></option><? foreach($options as $option) { ?>
		<option value="<?=$option['link']?>"
		<? if($option['link']==$filter['tablename']){ ?>selected<? } ?>><?=$option['name']?> (<?=$option['link']?>)</option>
	<? } ?></select></td>
  </tr>-->
  <tr>
    <td height="30" width="200">Тип данных</td>
    <td><select onchange="filterTypeProperties()" id="fieldDataType" style="width:120px;height:25px;">
		<? if($filter['tmp']=='1'){ ?><option></option><? } ?>
		<option value="int" <? if(preg_match("/^int(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Целое число</option>
		<option value="double" <? if(preg_match("/^double(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Дробное число</option>
		<option value="varchar" <? if(preg_match("/^varchar(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Строка</option>
		<option value="text" <? if(preg_match("/^text(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Текстовое поле</option>
	</select> <strong>-›</strong> 
	
		<select onchange="" id="fieldDataSubype_int"
		style="width:140px;height:25px;<? if(!preg_match("/^int(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>" >
			<option value="" >Не выбрано</option>
		</select>
	
		<select onchange="" id="fieldDataSubype_double"
		style="width:140px;height:25px;<? if(!preg_match("/^double(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
			<option value="" >Не выбрано</option>
		</select>
	
		<select onchange="" id="fieldDataSubype_varchar"
		style="width:180px;height:25px;<? if(!preg_match("/^varchar(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
			<option value="" >Не выбрано</option>
			<option value="colors" <? if(preg_match("/:colors$/", $filter['datatype'])){ ?>selected<? } ?>>Окно выбора цвета</option>
			<option value="colors" <? if(preg_match("/:test$/", $filter['datatype'])){ ?>selected<? } ?>>Строка с подсказкой</option>
		</select>
		
		<select onchange="" id="fieldDataSubype_text"
		style="width:180px;height:25px;<? if(!preg_match("/^text(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
			<option value="" >Не выбрано</option>
			<option value="colors" <? if(preg_match("/:tinymce$/", $filter['datatype'])){ ?>selected<? } ?>>Редактор TinyMCE</option>
		</select>
	</td>
  </tr>
  <tr>
    <td height="30" width="200" valign="top" style="padding-top:10px;">Поле в базе данных</td>
    <td valign="top" style="padding-top:7px;"><input type="text" id="fieldDBName" style="width:200px;height:25px;padding-left:3px;"
	placeholder="Латинские a-z, 0-9 и _" pattern="^[a-z]{1}[a-z0-9_]{2,19}$" maxlength="20"
	<? if($filter['link']!=''){ ?>class="inputok"<? } ?> value="<?=$filter['link']?>" />
	</td>
  </tr>
  <tr id="tr_fieldLength" style=";<? if(preg_match("/^double(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
    <td height="30" width="200" valign="top" style="padding-top:10px;">Длина поля</td>
    <td valign="top" style="padding-top:7px;"><input type="text" id="fieldDataLength" style="width:35px;height:25px;padding-left:3px;"
	placeholder="" pattern="^[0-9]{1,3}$" maxlength="3" value="<?=$filter['datalength']?>" />
	</td>
  </tr>
  <tr>
    <td height="30" width="200" valign="top" style="padding-top:10px;">Значение по умолчанию</td>
    <td valign="top" style="padding-top:7px;">
	<input type="text" id="fieldDataDefault" style="width:200px;height:25px;padding-left:3px;" value="<?=$filter['datadefault']?>" />
	</td>
  </tr>
  
  <!--<tr>
    <td height="30" width="200"  valign="top" style="padding-top:10px;">Тип фильтра</td>
    <td valign="top" style="padding-top:7px;"><? //print_r($filter); ?><select id="filterType" style="width:350px;height:25px;"
	onchange="testFilterType(this.value)"><option></option>
		<option value="1" <? if($filter['filtertype']=='1'){ ?>selected<? } ?>>Двойной бегунок</option>
		<option value="2" <? if($filter['filtertype']=='2'){ ?>selected<? } ?>>Селектор с добавлением данных</option>
		<option value="3" <? if($filter['filtertype']=='3'){ ?>selected<? } ?>>Выпадающее меню</option>
		<option value="4" <? if($filter['filtertype']=='4'){ ?>selected<? } ?>>Флажок</option>
		<option value="5" <? if($filter['filtertype']=='5'){ ?>selected<? } ?>>Группа флажков</option>
		<option value="6" <? if($filter['filtertype']=='6'){ ?>selected<? } ?>>От-До</option>
		<option value="7" <? if($filter['filtertype']=='7'){ ?>selected<? } ?>>Селектор с выборкой из другой таблицы</option>
		<option value="8" <? if($filter['filtertype']=='8'){ ?>selected<? } ?>>Селектор с выборкой из внешнего источника</option>
		<option value="9" <? if($filter['filtertype']=='9'){ ?>selected<? } ?>>Просто строка</option>
	</select>
	<div id="div_filterSettings_externalOption" style="display:<? if($filter['filtertype']!='8'){
	?>none<? } ?>;padding:5px;margin-top:5px;width:340px;border: 1px solid #CCCCCC;">
		<b>Внешний источник:</b><br/>
		<select id="externalOption_option" style="width:100%;height:25px;margin-top:7px;margin-bottom:7px;"><option></option>
			<? if(is_array($externals)){ foreach($externals as $ext){ ?><option value="<?=$ext['id']?>"
			<? if($ext['id']==$filter['config']['externalSettings']['option']){ ?>selected<? } ?>><?=$ext['name']?> (<?=$ext['link']?>)</option><? }} ?>
		</select>
		<b>Уровень:</b><br/>
		<select id="externalOption_level" style="width:100%;height:25px;margin-top:7px;margin-bottom:7px;"><option></option>
			<? if(is_array($externalLevels['0'])){ foreach($externalLevels['0'] as $key=>$ext){ ?><option value="<?=$key?>"
			<? if($key==$filter['config']['externalSettings']['level']){ ?>selected<? } ?>><?=$ext?></option><? }} ?>
		</select>
		<b>Стартовый уровень:</b>
		<? if(is_array($titles['0'])){ foreach($titles['0'] as $key=>$value){ ?>
		<div id="externalOption_start_<?=$key?>"
		style="padding-top:5px;border-bottom: 1px solid #CCCCCC;<? if($key>count($externalDefaults)){ ?>display:none;<? } ?>" >
			<div style=""><?=$value?></div>
			<select id="externalOption_startLevelSelect_<?=$key?>" style="width:45%;height:25px;margin-top:5px;margin-bottom:5px;"
			onchange="testExternalDefaults(this)">
				<option value="0"></option>
				<option value="1" <? if($externalDefaults[$key]['0']=='id'){ ?>selected<? } ?> >Значение</option>
				<option value="2" <? if($externalDefaults[$key]['0']=='name'){ ?>selected<? } ?> >Поле</option>
			</select>&nbsp;&nbsp;
			
			<select id="externalOption_startLevelValue_<?=$key?>"
			style="width:45%;height:25px;margin-top:5px;margin-bottom:5px;<? if($externalDefaults[$key]['0']!='id'){ ?>display:none;<? } ?>"
			onchange="testExternalDefaults(this)">
				<option value="0"></option>
				<? foreach($externalDefaults[$key]['2'] as $ext){ ?><option value="<?=$ext['id']?>"
				<? if($ext['id']==$externalDefaults[$key]['1']){ ?>selected<? } ?> ><?=$ext['name']?></option><? } ?>
			</select>
			
			<select id="externalOption_startLevelField_<?=$key?>"
			style="width:45%;height:25px;margin-top:5px;margin-bottom:5px;<? if($externalDefaults[$key]['0']!='name'){ ?>display:none;<? } ?>"
			onchange="testExternalDefaults(this)">
				<option value="0"></option>
				<? foreach($externalDefaults[$key]['2'] as $ext){ ?><option value="<?=$ext['link']?>"
				<? if($ext['link']==$externalDefaults[$key]['1']){ ?>selected<? } ?> ><?=$ext['name']?></option><? } ?>
			</select>
		</div><? }} ?>
	</div>
	</td>
  </tr>-->
  
  <!--<tr>
    <td height="30"  >Использовать в предпоказе</td>
    <td><select id="sel_isprev" style="width:130px;height:25px;">
		<option value="0" <? if($filter['isprev']=='0'){ ?>selected<? } ?>>Не использовать</option>
		<option value="1" <? if($filter['isprev']=='1'){ ?>selected<? } ?>>Использовать</option>
	</select></td>
  </tr>-->
  
  <tr>
    <td height="30" width="200">&nbsp;</td>
    <td><button onclick="saveFilterField()" style="height:25px;">Сохранить</button>&nbsp;&nbsp;
	<button onclick="getData('<?=$GLOBALS['adminBase']?>/?option=filters,parents=<?=$params['parents']?>')" style="height:25px;">Отменить</button></td>
  </tr>
</table>
</div></div>
<script>
//*********************************
function saveFilterField(){
	var paction =  "ajax=saveFilterField";
	paction += "&fieldId=<?=$filter['id']?>";
	//********************
	if(document.getElementById("fieldName").value==''){
		document.getElementById("fieldName").style.backgroundColor = '#FDDDD9';
		return false;
	}
	paction += "&fieldName="+encodeURIComponent(document.getElementById("fieldName").value);
	//********************
	if(document.getElementById("fieldDataType").value==''){
		document.getElementById("fieldDataType").style.backgroundColor = '#FDDDD9';
		return false;
	}
	var type = document.getElementById("fieldDataType").value;
	paction += "&fieldDataType="+type;
	//********************
	var dbField = document.getElementById("fieldDBName");
	if(dbField.className.match(/ ?inputok ?/gi)){
		paction += "&fieldDBName="+document.getElementById("fieldDBName").value;
	}else{
		dbField.style.backgroundColor = '#FDDDD9';
		return false;
	}
	//********************
	if(document.getElementById("fieldDataSubype_"+type).value!=""){
		paction += ":"+document.getElementById("fieldDataSubype_"+type).value;
	}
	//********************
	if(type!="double" && type!="text"){
		var lenObj = document.getElementById("fieldDataLength");
		if(!lenObj.value.match(/^[0-9]{1,3}$/gi) || lenObj.value=='' || lenObj.value=='0'){
			document.getElementById("fieldDataLength").style.backgroundColor = '#FDDDD9';
			return false;
		}
	}
	//********************
	paction += "&fieldDataLength="+document.getElementById("fieldDataLength").value;
	paction += "&fieldDataDefault="+encodeURIComponent(document.getElementById("fieldDataDefault").value);
	
	startPreloader();
	//console.log(paction);
	//return false;
	
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			var data = eval("("+html+")");
			if(data.return=='ok'){
				getData('<?=$GLOBALS['adminBase']?>/?option=filters,parents=<?=$params['parents']?>');
			}else{
				alert("Ошибка редактирования");
			}
		}
	});
}
//*********************************
var defaultType = '<?=$filter['datatype']?>';
function filterTypeProperties(){
	var type = document.getElementById("fieldDataType").value;
	var objs = document.getElementsByTagName("select");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		if(obj.id.match(/^fieldDataSubype_/)){
			if(obj.id.match(RegExp("_"+type, "gi"))){
				obj.style.display = "";
			}else{
				obj.style.display = "none";
			}
		}
	}
	if(type=="varchar"){
		document.getElementById("tr_fieldLength").style.display = "";
	}else if(type=="double"){
		document.getElementById("tr_fieldLength").style.display = "none";
	}else if(type=="int"){
		document.getElementById("tr_fieldLength").style.display = "";
	}else if(type=="text"){
		document.getElementById("tr_fieldLength").style.display = "none";
	}
	var selObj = document.getElementById("fieldDataType").getElementsByTagName("option")[0];
	if(selObj.innerHTML==''){
		selObj.parentNode.removeChild(selObj);
	}
}
//*********************************
var preloaderParams = {
	"parentId":"<?=$filter['parent']?>",
	"myfieldId":"<?=$filter['id']?>"
}
inputPreloader(document.getElementById("fieldDBName"), 'testFilterUseFieldName', preloaderParams);
document.getElementById("fieldDataLength").onfocus = function(){
	this.style.backgroundColor = '';
}
document.getElementById("fieldDataType").onfocus = function(){
	this.style.backgroundColor = '';
}
document.getElementById("fieldName").onfocus = function(){
	this.style.backgroundColor = '';
}
//*********************************************************
document.getElementById('adminarearight').onkeyup = function(event){
	if(event.keyCode==13 && document.getElementById('editFilterFieldTester')){
		saveFilterField();
	}
	return false;
}
//*********************************
</script>
<div id="editFilterFieldTester" style="display:none;"></div>
<script>
//*********************************
function testExternalDefaults(obj){
	
}
//*********************************
function testFilterType(type){
	var objs = document.getElementById("table_allFilterSettings").getElementsByTagName("div");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		if(obj.id.match(/^(tr|div)_filterSettings/gi)){
			obj.style.display = "none";
		}
	}
	if(type=='8'){
		document.getElementById("div_filterSettings_externalOption").style.display = '';
	}
}
//*********************************
var langs = new Array();
<? if(count($GLOBALS['languages'])>0){
$count=0;
foreach($GLOBALS['languages'] as $lang=>$lango){ if($GLOBALS['language']!=$lang){ ?>
langs[<?=$count?>] = '<?=$lang?>';
<? $count++; } } } ?>
//alert(langs);
//*********************************
function openAddFieldToTable(foo){
	var obj = document.getElementById("div_fieldname");
	document.getElementById("addTableName").innerHTML = document.getElementById("sel_tablename").value;
	var type = document.getElementById("filterDatatype").value;
	if(type=='1'){
		document.getElementById("addFieldType").innerHTML = "Целое число";
		document.getElementById("tdDBFieldLength").style.display = "";
	}else if(type=='2'){
		document.getElementById("addFieldType").innerHTML = "Дробное число";
		document.getElementById("tdDBFieldLength").style.display = "none";
	}else if(type=='3'){
		document.getElementById("addFieldType").innerHTML = "Строка";
		document.getElementById("tdDBFieldLength").style.display = "";
	}
	//*****************************
	if(obj.style.display=="none"){
		if(!foo){
			obj.style.display="";
		}
	}else{
		if(!foo){
			obj.style.display="none";
		}
	}
}
//*********************************
//function saveFilterField(){
//	
//}
//*********************************
function addDBField(){
	if(document.getElementById("sel_tablename").value==''){
		alert("Определите таблицу в базе данных");
		document.getElementById("sel_tablename").style.backgroundColor = "#ffd7d7";
		return false;
	}
	//*************************************************
	var type = document.getElementById("filterDatatype").value;
	if(type!='2' && (document.getElementById("dbFieldLength").value=='' || !document.getElementById("dbFieldLength").value.match(/^[0-9]*$/))){
		alert("Определите длину поля");
		document.getElementById("dbFieldLength").style.backgroundColor = "#ffd7d7";
		return false;
	}
	//*************************************************
	if(document.getElementById("dbField").value=='' || !document.getElementById("dbField").value.match(/^[0-9a-zA-Z_]*$/)){
		var foo = "latinskoe_111 или latinskoe111 или latinskoe";
		alert("Название поля должно соответствовать таким требониям:\n"+foo);
		document.getElementById("dbField").style.backgroundColor = "#ffd7d7";
		return false;
	}
	//*************************************************
	var paction = "ajax=addDBField";
	paction += "&table="+document.getElementById("sel_tablename").value;
	paction += "&field="+document.getElementById("dbField").value;
	paction += "&length="+document.getElementById("dbFieldLength").value;
	paction += "&type="+type;
	//alert(paction)
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			if(data.return=='ok'){
				getFilterFieldType(document.getElementById("filterDatatype").value, document.getElementById("dbField").value);
				openAddFieldToTable();
				document.getElementById("dbField").value = "";
				document.getElementById("dbFieldLength").value = "";
			}else if(data.return=='used'){
				alert("Такое поле уже используется");
				document.getElementById("dbField").style.backgroundColor = "#ffd7d7";
			}else{
				alert("Неизвестная ошибка");
			}
		}
	});
}
//*********************************

//*********************************
</script>
<? } ?>