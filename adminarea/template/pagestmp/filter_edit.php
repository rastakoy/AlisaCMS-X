<h2>Управление фильтром</h2>
<? //echo "<pre>"; print_r($GLOBALS); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($filter); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($options); echo "</pre>"; ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" id="table_allFilterSettings">
  <? foreach($GLOBALS['languages'] as $lang=>$lango){
  $prefix = "";
  if($GLOBALS['language']!=$lang){ $prefix = "_$lang"; }
  if(isset($filter["name$prefix"])){ ?>
  <tr>
    <td width="200" height="30">Название<? if($GLOBALS['language']!=$lang){ ?> (<?=$lango['1']?>)<? } ?></td>
    <td><input type="text" id="filterName<? if($GLOBALS['language']!=$lang){echo "_$lang";} ?>"
	value="<?=$filter["name$prefix"]?>" style="width:350px;" /></td>
  </tr>
  <? } } ?>
  <tr>
    <td width="200" height="30">Путь</td>
    <td><input type="text" id="filterLink" value="<?=$filter['link']?>"  style="width:350px;" /></td>
  </tr>
  <tr>
    <td height="30" width="200">Таблица в базе данных</td>
    <td><select onchange="getFilterFieldType()" id="sel_tablename" style="width:350px;">
	<option></option><? foreach($options as $option) { ?>
		<option value="<?=$option['link']?>"
		<? if($option['link']==$filter['tablename']){ ?>selected<? } ?>><?=$option['name']?> (<?=$option['link']?>)</option>
	<? } ?></select></td>
  </tr>
  <tr>
    <td height="30" width="200">Тип данных</td>
    <td><select onchange="getFilterFieldType()" id="filterDatatype" style="width:140px;">
		<option value="1" <? if($filter['datatype']=='1'){ ?>selected<? } ?>>Целое число</option>
		<option value="2" <? if($filter['datatype']=='2'){ ?>selected<? } ?>>Дробное число</option>
		<option value="3" <? if($filter['datatype']=='3'){ ?>selected<? } ?>>Строка</option>
	</select></td>
  </tr>
  <tr>
    <td height="30" width="200" valign="top" style="padding-top:10px;">Поле в базе данных</td>
    <td valign="top" style="padding-top:7px;"><select id="sel_fieldname" style="width:140px;"><? foreach($filter['fields'] as $field) { ?>
		<option value="<?=$field?>" <? if($field==$filter['fieldname']){ ?>selected<? } ?>><?=$field?></option>
		<? } ?></select>
		<a href="javascript:" onclick="addFieldToTable()"><img src="/adminarea/template/images/green/icons/plus_whitebg.gif"
		align="absmiddle" /></a>
		<a href="javascript:" onclick="openAddFieldToTable()">Добавить поле</a>
		<div id="div_fieldname" style="display:none;padding:5px;margin-top:5px;width:240px;border: 1px solid #CCCCCC;">
			<table width="100%" border="0" cellspacing="1" cellpadding="1">
				<tr><td width="100" height="30">Таблица</td>
					<td><b id="addTableName">cxz</b></td>
				</tr>
				<tr><td width="100" height="30">Тип данных</td>
					<td><b id="addFieldType">asd</b></td>
				</tr>
				<tr id="tdDBFieldLength"><td width="100" height="30">Длина</td>
					<td><input type="number" style="width:120px;" id="dbFieldLength"
					onkeyup="this.style.backgroundColor=''" onchange="this.style.backgroundColor=''" /></td>
				</tr>
				<tr><td width="100" height="30">Название</td>
					<td><input type="text" style="width:120px;" id="dbField"
					onkeyup="this.style.backgroundColor=''" onchange="this.style.backgroundColor=''" /></td>
				</tr>
				<tr><td colspan="2" height="30" style="padding-left:105px;">
					<button onclick="addDBField()">Добавить поле</button></td>
				</tr>
			</table>
		</div>
	</td>
  </tr>
  <tr>
    <td height="30" width="200"  valign="top" style="padding-top:10px;">Тип фильтра</td>
    <td valign="top" style="padding-top:7px;"><? //print_r($filter); ?><select id="filterType" style="width:350px;" onchange="testFilterType(this.value)"><option></option>
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
		<select id="externalOption_option" style="width:100%;margin-top:7px;margin-bottom:7px;"><option></option>
			<? foreach($externals as $ext){ ?><option value="<?=$ext['id']?>"
			<? if($ext['id']==$filter['config']['externalSettings']['option']){ ?>selected<? } ?>><?=$ext['name']?> (<?=$ext['link']?>)</option><? } ?>
		</select>
		<b>Уровень:</b><br/>
		<select id="externalOption_level" style="width:100%;margin-top:7px;margin-bottom:7px;"><option></option>
			<? foreach($externalLevels['0'] as $key=>$ext){ ?><option value="<?=$key?>"
			<? if($key==$filter['config']['externalSettings']['level']){ ?>selected<? } ?>><?=$ext?></option><? } ?>
		</select>
		<b>Стартовый уровень:</b>
		<? foreach($titles['0'] as $key=>$value){ ?>
		<div id="externalOption_start_<?=$key?>"
		style="padding-top:5px;border-bottom: 1px solid #CCCCCC;<? if($key>count($externalDefaults)){ ?>display:none;<? } ?>" >
			<div style=""><?=$value?></div>
			<select id="externalOption_startLevelSelect_<?=$key?>" style="width:45%;margin-top:5px;margin-bottom:5px;"
			onchange="testExternalDefaults(this)">
				<option value="0"></option>
				<option value="1" <? if($externalDefaults[$key]['0']=='id'){ ?>selected<? } ?> >Значение</option>
				<option value="2" <? if($externalDefaults[$key]['0']=='name'){ ?>selected<? } ?> >Поле</option>
			</select>&nbsp;&nbsp;
			
			<select id="externalOption_startLevelValue_<?=$key?>"
			style="width:45%;margin-top:5px;margin-bottom:5px;<? if($externalDefaults[$key]['0']!='id'){ ?>display:none;<? } ?>"
			onchange="testExternalDefaults(this)">
				<option value="0"></option>
				<? foreach($externalDefaults[$key]['2'] as $ext){ ?><option value="<?=$ext['id']?>"
				<? if($ext['id']==$externalDefaults[$key]['1']){ ?>selected<? } ?> ><?=$ext['name']?></option><? } ?>
			</select>
			
			<select id="externalOption_startLevelField_<?=$key?>"
			style="width:45%;margin-top:5px;margin-bottom:5px;<? if($externalDefaults[$key]['0']!='name'){ ?>display:none;<? } ?>"
			onchange="testExternalDefaults(this)">
				<option value="0"></option>
				<? foreach($externalDefaults[$key]['2'] as $ext){ ?><option value="<?=$ext['link']?>"
				<? if($ext['link']==$externalDefaults[$key]['1']){ ?>selected<? } ?> ><?=$ext['name']?></option><? } ?>
			</select>
		</div><? } ?>
	</div>
	</td>
  </tr>
  <tr>
    <td height="30"  >Использовать в предпоказе</td>
    <td><select id="sel_isprev" style="width:130px;">
		<option value="0" <? if($filter['isprev']=='0'){ ?>selected<? } ?>>Не использовать</option>
		<option value="1" <? if($filter['isprev']=='1'){ ?>selected<? } ?>>Использовать</option>
	</select></td>
  </tr>
  <tr>
    <td height="30" width="200">&nbsp;</td>
    <td><button onclick="saveFilterField()">Сохранить</button>&nbsp;&nbsp;
	<button onclick="__css_itemShowCSS_close()">Отменить</button></td>
  </tr>
</table>
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
function getFilterFieldType(type, newValue){
	document.getElementById("sel_tablename").style.backgroundColor = "";
	paction =  "ajax=getFilterFieldType&type="+document.getElementById("filterDatatype").value;
	paction += "&parent=<?=$filter['parent']?>&id=<?=$filter['id']?>";
	paction += "&table="+document.getElementById("sel_tablename").value;
	openAddFieldToTable(true);
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
				inner += "<option value=\""+data[j]+"\"  ";
				if(newValue){
					if(newValue==data[j]){
						inner += "selected";
					}
				}
				inner += " >"+data[j]+"</option>";
			}
			document.getElementById("sel_fieldname").innerHTML = inner;
		}
	});
}
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
function saveFilterField(){
	var paction =  "ajax=saveFilterField";
	paction += "&filterId=<?=$filter['id']?>";
	paction += "&filterName="+encodeURIComponent(document.getElementById("filterName").value);
	for(var j=0; j<langs.length; j++){
		if(document.getElementById("filterName_"+langs[j])){
			paction += "&filterName_"+langs[j]+"="+encodeURIComponent(document.getElementById("filterName_"+langs[j]).value);
		}
	}
	paction += "&filterLink="+document.getElementById("filterLink").value;
	paction += "&filterType="+document.getElementById("filterType").value;
	paction += "&filterDatatype="+document.getElementById("filterDatatype").value;
	paction += "&filterTableName="+document.getElementById("sel_tablename").value;
	paction += "&filterFieldName="+document.getElementById("sel_fieldname").value;
	paction += "&filterIsprev="+document.getElementById("sel_isprev").value;
	
	if(document.getElementById("filterType").value=='8'){
		paction += "&externalOption="+document.getElementById("externalOption_option").value;
		paction += "&externalLevel="+document.getElementById("externalOption_level").value;
		var defaults = '';
		var objs = document.getElementById("div_filterSettings_externalOption").getElementsByTagName("div");
		for(var j=0; j<objs.length; j++){
			var obj = objs[j];
			if(obj.id.match(/^externalOption_start_/) && obj.style.display!='none'){
				var id = obj.id.replace(/^externalOption_start_/gi, '');
				if(document.getElementById("externalOption_startLevelSelect_"+id).value=='1'){
					defaults += ",id:"+document.getElementById("externalOption_startLevelValue_"+id).value;
				}else if(document.getElementById("externalOption_startLevelSelect_"+id).value=='2'){
					defaults += ",name:"+document.getElementById("externalOption_startLevelField_"+id).value;
				}else{
					break;
				}
				//alert(obj.id);
			}
		}
		paction += "&defaults="+defaults.replace(/^,/gi, '');
		
	}
	//alert(paction);
	//return false;
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