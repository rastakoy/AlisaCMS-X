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

<? if(is_array($ports)){ ?><select id="portsFields" style="display:none;"><? foreach($ports as $port){ ?>
<option value="<?=$port['port']?>:<?=$port['id']?>"><?=$port['name']?></option>
<? } ?></select><? } ?>


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
  
<? if($GLOBALS['debugMode']=='1'){ ?>
  <tr>
    <td height="" colspan="2">
	<a href="javascript:"
	onclick="document.getElementById('print_r').style.display=((document.getElementById('print_r').style.display=='none')?'':'none')">
	<b>Отладка</b></a>
	<div id="print_r" style="display:none;">
<? //echo "langPrefix = $langPrefix<br/>"; ?>
<? //echo "<pre>"; print_r($GLOBALS['languages']); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($filter); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($langFields); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($GLOBALS); echo "</pre>"; ?>
<? echo "<pre>filter:"; print_r($filter); echo "</pre>"; ?>
<? //echo "<pre>options: "; print_r($options); echo "</pre>"; ?>
<? //echo "<pre>ports: "; print_r($ports); echo "</pre>"; ?>
<? //echo "<pre>tablesWIthPorts: "; print_r($tablesWIthPorts); echo "</pre>"; ?>
</div></td>
  </tr>
<? } ?>
  
  <tr>
    <td width="200" height="30">Название</td>
    <td><input type="text" id="fieldName"
	value="<?=$filter["name$langPrefix"]?>" style="width:350px;height:25px;padding-left:3px;" /></td>
  </tr>

  <tr>
    <td height="30" width="200">Тип данных</td>
    <td><select onchange="filterTypeProperties()" id="fieldDataType" style="width:140px;height:25px;">
		<? if($filter['tmp']=='1'){ ?><option></option><? } ?>
		<option value="int" <? if(preg_match("/^int(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Целое число</option>
		<option value="double" <? if(preg_match("/^double(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Дробное число</option>
		<option value="varchar" <? if(preg_match("/^varchar(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Строка</option>
		<option value="text" <? if(preg_match("/^text(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Текстовое поле</option>
		<option value="datetime" <? if(preg_match("/^datetime(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Дата</option>
		<option value="virtual" <? if(preg_match("/^virtual(:?|$)/", $filter['datatype'])){ ?>selected<? } ?>>Виртуальное поле</option>
	</select> <!--<strong>-›</strong>--> 
	
		<select onchange="filterTypeProperties()" id="fieldDataSubtype_int"
		style="width:140px;height:25px;<? if(!preg_match("/^int(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>" >
			<option value="" >Не выбрано</option>
			<option value="port" <? if(preg_match("/:port$/", $filter['datatype'])){ ?>selected<? } ?> >Порт</option>
			<option value="connector" <? if(preg_match("/:connector$/", $filter['datatype'])){ ?>selected<? } ?> >Коннектор</option>
			<option value="checkbox" <? if(preg_match("/:checkbox$/", $filter['datatype'])){ ?>selected<? } ?> >Чекбокс (галочка)</option>
			<option value="parent" <? if(preg_match("/:parent$/", $filter['datatype'])){ ?>selected<? } ?> >Родитель в дереве</option>
		</select>
		
		<select onchange="" id="fieldDataSubtype_double"
		style="width:140px;height:25px;<? if(!preg_match("/^double(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
			<option value="" >Не выбрано</option>
			<option value="price" <? if(preg_match("/:price$/", $filter['datatype'])){ ?>selected<? } ?>>Цена</option>
		</select>
	
		<select onchange="" id="fieldDataSubtype_varchar"
		style="width:180px;height:25px;<? if(!preg_match("/^varchar(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
			<option value="" >Не выбрано</option>
			<option value="colors" <? if(preg_match("/:colors$/", $filter['datatype'])){ ?>selected<? } ?>>Окно выбора цвета</option>
			<option value="stringlist" <? if(preg_match("/:test$/", $filter['datatype'])){ ?>selected<? } ?>>Строка с подсказкой</option>
			<option value="port" >Порт</option>
			<option value="connector" >Коннектор</option>
		</select>
		
		<select onchange="" id="fieldDataSubtype_text"
		style="width:180px;height:25px;<? if(!preg_match("/^text(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
			<option value="" >Не выбрано</option>
			<option value="tinymce" <? if(preg_match("/:tinymce$/", $filter['datatype'])){ ?>selected<? } ?>>Редактор TinyMCE</option>
		</select>
	</td>
  </tr>
  
  <tr id="tr_fieldConnector" style=";<? if(!preg_match("/:connector(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
	<td colspan="2">
	<fieldset  style="border:solid 1px #006600;">
		<legend><b>Настройка коннектора</b></legend>
		<table width="100%" border="0" cellspacing="1" cellpadding="1" id="table_connectorSettings">
		<tr>
			<td height="30" width="75" valign="top" style="padding-top:10px;">Данные из</td>
			<td valign="top" style="padding-top:5px;"><select onchange="changeConnectorTable(this, '<?=$filter['id']?>')" id="fieldDataSubtype_int_connector"
				style="width:150px;height:25px;<? if(!preg_match("/:connector(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>" >
					<option value="" >Не выбрано</option>
					<? foreach($options as $ctable){ if($ctable['link']!='filters'){ ?>
						<option value="<?=$ctable['link']?>"
						<? if($filter['config']['connector']['table']==$ctable['link']){ ?>selected<? } ?> ><?=$ctable['name']?></option>
					<? }} ?>
				</select>
			</td>
		</tr>
		<? if(is_array($filter['config']['connector']['data'])){
				foreach($filter['config']['connector']['data'] as $ckey=>$cmass){ ?>
			<tr>
				<td height="30" width="75" valign="top" style="padding-top:10px;"><?=$cmass['name']?></td>
				<td valign="top" style="padding-top:5px;">
					<input type="text" value="<?=$cmass['field']?>" id="connectorName_<?=$ckey?>" pattern="^[a-z]{1}[a-z0-9_]{2,19}$" 
					<? if(preg_match("/^[a-zA-Z]{1}[a-zA-Z0-9_]{2,20}$/", $cmass['field'])){ ?>class="inputok"<? } ?>
					style="width:130px;height:25px;padding-left:3px;" placeholder="Название поля" />
					<input type="text" value="<?=$cmass['fieldName']?>" id="psevdoName_<?=$ckey?>"
					style="width:130px;height:25px;padding-left:3px;" placeholder="Псевдоним поля" />
					<select onchange="changeConnectorFields(this, '<?=$filter['id']?>')" id="intConnector_<?=$ckey?>"
					style="width:130px;height:25px;" >
						<option value="" >Не выбрано</option>
						<? foreach($cmass['values'] as $cvalue){ ?>
							<option value="<?=$cvalue['id']?>" <? if($cmass['default']==$cvalue['id']){ ?>selected<? } ?> ><?=$cvalue['name']?></option>
						<? } ?>
					</select> условие
<script>
	var preloaderParams = false;
	preloaderParams = {
		'parentId':'<?=$filter['parent']?>',
		'callback':function(){
			alert("Тестирование");
		}
	}
	inputPreloader(document.getElementById("connectorName_<?=$ckey?>"), 'testFilterUseFieldName', preloaderParams);
	document.getElementById("psevdoName_<?=$ckey?>").onfocus = function(){
		document.getElementById("psevdoName_<?=$ckey?>").style.backgroundColor = '';
	}
</script>
				</td>
			</tr>
		<? }} ?>
		</table>
	</fieldset>
	</td>
  </tr>
  
  <tr id="tr_fieldDBName" style=";<? if(
  		preg_match("/^virtual(:?|$)/", $filter['datatype'])
		|| preg_match("/:connector(:?|$)/", $filter['datatype'])
  ){ ?>display:none;<? } ?>">
    <td height="30" width="200" valign="top" style="padding-top:10px;">Поле в базе данных</td>
    <td valign="top" style="padding-top:7px;"><input type="text" id="fieldDBName" style="width:200px;height:25px;padding-left:3px;"
	placeholder="Латинские a-z, A-Z, 0-9 и _" pattern="^[a-zA-Z]{1}[a-zA-Z0-9_]{2,19}$" maxlength="20"
	<? if($filter['link']!=''){ ?>class="inputok"<? } ?> value="<?=$filter['link']?>" />
	</td>
  </tr>
  <tr id="tr_fieldLength" style=";<? if(
  		preg_match("/^double(:?|$)/", $filter['datatype'])
  		|| preg_match("/^virtual(:?|$)/", $filter['datatype'])
		|| preg_match("/^text(:?|$)/", $filter['datatype'])
		|| preg_match("/^datetime(:?|$)/", $filter['datatype'])
		|| preg_match("/:connector(:?|$)/", $filter['datatype'])
  ){ ?>display:none;<? } ?>">
    <td height="30" width="200" valign="top" style="padding-top:10px;">Длина поля</td>
    <td valign="top" style="padding-top:7px;"><input type="text" id="fieldDataLength" style="width:35px;height:25px;padding-left:3px;"
	placeholder="" pattern="^[0-9]{1,3}$" maxlength="3" value="<?=$filter['datalength']?>" />
	</td>
  </tr>
  <tr id="tr_fieldDefault" style=";<? if(
  		preg_match("/^virtual(:?|$)/", $filter['datatype'])
		|| preg_match("/:connector(:?|$)/", $filter['datatype'])
  ){ ?>display:none;<? } ?>">
    <td height="30" width="200" valign="top" style="padding-top:10px;">Значение по умолчанию</td>
    <td valign="top" style="padding-top:7px;">
	<input type="text" id="fieldDataDefault" style="width:200px;height:25px;padding-left:3px;" value="<?=$filter['datadefault']?>" />
	</td>
  </tr>
  
  <tr id="tr_fieldVirtualTable" style=";<? if(!preg_match("/^virtual(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
    <td height="30" width="200" valign="" style="padding-top:5px;">Таблица с данными</td>
    <td valign="" style="">
	<? if(is_array($tablesWIthPorts)){ ?><select id="portsTables" style="width:200px;height:25px;" onchange="setConnectors(this.value)">
	<option></option><? foreach($tablesWIthPorts as $table){ ?>
		<option value="<?=$table['link']?>:<?=$table['id']?>"
		<? if($table['link']==$filter['config']['connectors']['table']){?>selected<? } ?> ><?=$table['name']?></option>
	<? } ?></select><? } ?>
	</td>
  </tr>
  <tr id="tr_fieldVirtual" style=";<? if(!preg_match("/^virtual(:?|$)/", $filter['datatype'])){ ?>display:none;<? } ?>">
    <td width="200" height="30" valign="top" style="padding-top:12px;">Коннекторы &nbsp;&nbsp;
	<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/plus_whitebg.gif" title="Добавить коннектор"
	style="cursor:pointer;border-radius:10px;" onclick="addNewConnector()" align="absmiddle"></td>
	<td height="30" width="200" valign="top">
		<table width="100%" cellpadding="0" cellspacing="0" border="0" id="connectorsTable"
		style="display:<? if($panel['external']=='1'){ echo "none"; } ?>" >
			<? foreach($filter['config']['connectors']['fields'] as $ckey=>$connector){ ?>
			<tr>
				<td height="30">
				<? //echo "<pre>"; print_r($connector); echo "</pre>"; ?>
				<input type="text" id="connector_<?=$ckey?>" value="<?=$connector['connector']?>"
				onfocus="this.style.backgroundColor=''" style="width:100px;height:25px;padding-left:3px;" />
				<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/connector.gif" style="position:absolute;margin-left:5px;margin-top:5px;">
				<? if(is_array($ports)){ ?><select id="portsFields_<?=$ckey?>" onfocus="this.style.backgroundColor=''"
				style="width:200px;height:25px;margin-left:40px;">
				<option value=""></option><? foreach($ports as $port){
				$prega = "/^".$filter['config']['connectors']['table']."\./";
				if(preg_match($prega, $port['port'])){ ?>
					<option value="<?=$port['port']?>:<?=$port['id']?>" <? if($port['port']==$connector['port']){?>selected<? }?> ><?=$port['port']?></option>
				<? }} ?></select><? } ?>
				</td>
				<td width="30"><img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/delete.gif" title="Удалить коннектор"
				style="cursor:pointer;" onclick="deleteConnector(this)" class="delimg_intable"></td>
			</tr>
			<? } ?>
		</table>
		<script>inputPreloader(document.getElementById("addNewTable"), 'testUseTable');</script>
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
  
  <tr id="" class="">
	<td colspan="2" style="text-transform:uppercase;" height="40"><b>Программное управление шаблоном поля</b>
	</td>
  </tr>
  
  <tr id="tr_fieldInit" class="tr_fieldset">
	<td colspan="2">
	<fieldset id="fsInit" style="border:solid 1px #006600;border:none;">
		<legend><img id="imgInit" src="/adminarea/template/tree/plus.jpg" style="cursor:pointer;" onclick="showSnippet('Init')">
		<b>Инициализация блока</b></legend>
		<table width="100%" border="0" cellspacing="1" cellpadding="1" id="table_fieldInit" style="display:none;">
			<tr><td id="td_codeInit"></td></tr>
			<tr><td><button onclick="saveSnippet('Init')">Сохранить</button>
			<button onclick="showSnippet('Init')">Закрыть</button></td></tr>
		</table>
	</fieldset>
	</td>
  </tr>
  
  <tr id="tr_fieldSender" class="tr_fieldset">
	<td colspan="2">
	<fieldset id="fsSender" style="border:solid 1px #006600;border:none;">
		<legend><img id="imgSender" src="/adminarea/template/tree/plus.jpg" style="cursor:pointer;" onclick="showSnippet('Sender', 'js')">
		<b>Отправка данных на сервер</b></legend>
		<table width="100%" border="0" cellspacing="1" cellpadding="1" id="table_fieldSender" style="display:none;">
			<tr><td id="td_codeSender"></td></tr>
			<tr><td><button onclick="saveSnippet('Sender')">Сохранить</button>
			<button onclick="showSnippet('Sender')">Закрыть</button></td></tr>
		</table>
	</fieldset>
	</td>
  </tr>
  
  <tr id="tr_fieldRecipient" class="tr_fieldset">
	<td colspan="2">
	<fieldset id="fsRecipient" style="border:solid 1px #006600;border:none;">
		<legend><img id="imgRecipient" src="/adminarea/template/tree/plus.jpg" style="cursor:pointer;" onclick="showSnippet('Recipient')">
		<b>Прием данных на сервере</b></legend>
		<table width="100%" border="0" cellspacing="1" cellpadding="1" id="table_fieldRecipient" style="display:none;">
			<tr><td id="td_codeRecipient"></td></tr>
			<tr><td><button onclick="saveSnippet('Recipient')">Сохранить</button>
			<button onclick="showSnippet('Recipient')">Закрыть</button></td></tr>
		</table>
	</fieldset>
	</td>
  </tr>
  
  <tr id="tr_fieldCustom" class="tr_fieldset">
	<td colspan="2">
	<fieldset id="fsCustom" style="border:solid 1px #006600;border:none;">
		<legend><img id="imgCustom" src="/adminarea/template/tree/plus.jpg" style="cursor:pointer;" onclick="showSnippet('Custom')">
		<b>Дополнительный код управления</b></legend>
		<table width="100%" border="0" cellspacing="1" cellpadding="1" id="table_fieldCustom" style="display:none;">
			<tr><td id="td_codeCustom"></td></tr>
			<tr><td><button onclick="saveSnippet('Custom')">Сохранить</button>
			<button onclick="showSnippet('Custom')">Закрыть</button></td></tr>
		</table>
	</fieldset>
	</td>
  </tr>
  
</table>
</div></div>
<script>
//*********************************
function saveFilterField(){
	var paction =  "ajax=saveFilterField";
	paction += "&fieldId=<?=$filter['id']?>";
	paction += "&langPrefix=<?=$langPrefix?>";
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
	var subtype = false;
	//console.log("type="+type);
	paction += "&fieldDataType="+type;
	if(document.getElementById("fieldDataSubtype_"+type) && document.getElementById("fieldDataSubtype_"+type).value!=""){
		paction += ":"+document.getElementById("fieldDataSubtype_"+type).value;
		subtype = document.getElementById("fieldDataSubtype_"+type).value;
	}
	//********************
	var dbField = document.getElementById("fieldDBName");
	if(document.getElementById("tr_fieldDBName").style.display=="none"){
		//paction += "&fieldDBName=";
	}else if(dbField.className.match(/ ?inputok ?/gi)){
		paction += "&fieldDBName="+document.getElementById("fieldDBName").value;
	}else{
		dbField.style.backgroundColor = '#FDDDD9';
		return false;
	}
	//********************
	if(type!="double" && type!="text" && type!="datetime" && type!="virtual" && subtype!='connector'){
		var lenObj = document.getElementById("fieldDataLength");
		if(!lenObj.value.match(/^[0-9]{1,3}$/gi) || lenObj.value=='' || lenObj.value=='0'){
			document.getElementById("fieldDataLength").style.backgroundColor = '#FDDDD9';
			return false;
		}
		paction += "&fieldDataLength="+document.getElementById("fieldDataLength").value;
	}
	//********************
	if(document.getElementById("tr_fieldDefault").style.display!="none"){
		paction += "&fieldDataDefault="+encodeURIComponent(document.getElementById("fieldDataDefault").value);
	}
	//********************
	if(type=="virtual"){
		var json = '{"connectors":{"table":"images","fields":{';
		var sjson = '';
		var sels = document.getElementById("connectorsTable").getElementsByTagName("select");
		for(var j=0; j<sels.length; j++){
			if(document.getElementById("connector_"+j).value==''){
				document.getElementById("connector_"+j).style.backgroundColor = '#FDDDD9';
				return false;
			}
			if(document.getElementById("portsFields_"+j).value==''){
				document.getElementById("portsFields_"+j).style.backgroundColor = '#FDDDD9';
				return false;
			}
			sjson += '"'+j+'":{';
			sjson += '"connector":"'+document.getElementById("connector_"+j).value+'",';
			sjson += '"port":"'+document.getElementById("portsFields_"+j).value.split(":")[0]+'"';
			sjson += '},';
		}
		json += sjson.replace(/,$/gi, '');
		json += '}}}';
		//"0":{"connector":"table","port":"images.table"},
		//"1":{"connector":"table.id","port":"images.externalId"}';
		//paction += "&config="+json;
		paction += "&config="+encodeURIComponent(json);
	}
	//********************
	if(type=="int" && subtype=="connector"){
		paction = paction.replace(/&fieldDataLength=[0-9]{1,3}$/gi, "");
		paction = paction.replace(/&fieldDataLength=[0-9]{1,3}&/gi, "&");
		if(document.getElementById("fieldDataSubtype_int_connector").value==''){
			document.getElementById("fieldDataSubtype_int_connector").style.backgroundColor = '#FDDDD9';
			return false;
		}
		var json = '{"connector":{"table":"'+(document.getElementById("fieldDataSubtype_int_connector").value)+'","data":{';
			var table = document.getElementById("table_connectorSettings");
			var ajson = "";
			for(var j=1; j<table.rows.length; j++){
				ajson += "\""+(j-1)+"\":{";
				if(!document.getElementById("connectorName_"+(j-1)).className.match(/ ?inputok ?/gi)){
					document.getElementById("connectorName_"+(j-1)).style.backgroundColor = '#FDDDD9';
					return false;
				}
				if(document.getElementById("psevdoName_"+(j-1)).value==''){
					document.getElementById("psevdoName_"+(j-1)).style.backgroundColor = '#FDDDD9';
					return false;
				}
				ajson += "\"field\":\""+document.getElementById("connectorName_"+(j-1)).value+"\",";
				ajson += "\"fieldName\":\""+document.getElementById("psevdoName_"+(j-1)).value+"\",";
				ajson += "\"default\":\""+document.getElementById("intConnector_"+(j-1)).value+"\"";
				ajson += "},";
			}
			ajson = ajson.replace(/,$/gi, '');
		json += ajson+"}}}";
		//paction += "&json="+encodeURIComponent(json);
		paction += "&json="+json;
	}
	
	//startPreloader();
	//console.log(paction);
	//return false;
	
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log("html="+html);
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
function saveSnippet(sType){
	var frame = document.getElementById("aceEditorFrame"+sType);
	var editor = frame.contentWindow.document.getElementById("editor");
	//console.log(editor.env.editor.getValue());
	var txt = encodeURIComponent(editor.env.editor.getValue());
	var paction = "ajax=saveFilterSnippet";
	paction += "&type="+sType;
	paction += "&option=<?=$params['option']?>";
	paction += "&fieldId=<?=$filter['id']?>";
	var type = document.getElementById("fieldDataType").value;
	paction += "&fieldType="+type;
	if(document.getElementById("fieldDataSubtype_"+type) && document.getElementById("fieldDataSubtype_"+type).value!=""){
		paction += "-"+document.getElementById("fieldDataSubtype_"+type).value;
	}
	paction += "&text="+txt;
	//console.log(paction);
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			stopPreloader();
		}
	});
}
//*********************************
function showSnippet(sType, pLang){
	var img = document.getElementById("img"+sType);
	if(img.getAttribute("src").match(/plus\.jpg$/gi)){
		startPreloader();
		document.getElementById("tr_field"+sType).className = "tr_fieldsetOpen";
		document.getElementById("table_field"+sType).style.display = "";
		document.getElementById("fs"+sType).style.border = "solid 1px #006600";
		img.setAttribute("src", img.getAttribute("src").replace(/plus\.jpg$/gi, "minus.jpg"));
		var inner = "<iframe src=\"<?=$GLOBALS['adminBase']?>/ace-editor-save/demo/autocompletion.html\" ";
		inner += "id=\"aceEditorFrame"+sType+"\" width=\"100%\" height=\"300\" frameborder=\"0\" style=\"display:;\" />";
		document.getElementById("td_code"+sType).innerHTML = inner;
	}else{
		document.getElementById("tr_field"+sType).className = "tr_fieldset";
		document.getElementById("table_field"+sType).style.display = "none";
		document.getElementById("fs"+sType).style.border = "none";
		img.setAttribute("src", img.getAttribute("src").replace(/minus\.jpg$/gi, "plus.jpg"));
		var inner = "";
		document.getElementById("td_code"+sType).innerHTML = inner;
		return false;
	}
	var paction = "ajax=showFilterSnippet";
	paction += "&type="+sType;
	paction += "&option=<?=$params['option']?>";
	paction += "&fieldId=<?=$filter['id']?>";
	var mode = "php";
	if(pLang){
		paction += "&ext="+pLang;
		if(pLang=='js'){
			mode = 'javascript';
		}
	}
	var type = document.getElementById("fieldDataType").value;
	paction += "&fieldType="+type;
	if(document.getElementById("fieldDataSubtype_"+type) && document.getElementById("fieldDataSubtype_"+type).value!=""){
		paction += "-"+document.getElementById("fieldDataSubtype_"+type).value;
	}
	//console.log(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			var frame = document.getElementById("aceEditorFrame"+sType);
			var editor = frame.contentWindow.document.getElementById("editor");
			editor.env.editor.setValue(html, 1);
			if(pLang){
				editor.env.editor.getSession().setMode("ace/mode/"+mode);
			}
			stopPreloader();
		}
	});
}
//*********************************
function addNewConnector(){
	var table = document.getElementById("connectorsTable");
	var newRow = table.insertRow();
	//console.log(table.rows.length);
	var has = false;	
	if(document.getElementById("portsFields_0")){
		var option = document.getElementById("portsFields_0").getElementsByTagName("option")[1];
		var selInner = "";
		selInner = document.getElementById("portsFields_0").innerHTML;
		cLength = table.rows.length;
		has = true;
	}else{
		cLength = '1';
	}
	var inner = "<td height=\"30\"><input type=\"text\" id=\"connector_"+(cLength-1)+"\" ";
	inner += "style=\"width:100px;height:25px;padding-left:3px;\" onfocus=\"this.style.backgroundColor=''\" /> ";
	inner += "<img src=\""+(__GLOBALS['adminBase'])+"/template/images/green/icons/connector.gif\" ";
	inner += "style=\"position:absolute;margin-left:5px;margin-top:5px;\"> ";
	inner += "<select id=\"portsFields_"+(cLength-1)+"\" style=\"width:200px;height:25px;margin-left:40px;\" ";
	inner += "onfocus=\"this.style.backgroundColor=''\" > ";
	if(has){
		inner += selInner;
	}
	inner += "</select>";
	inner += "</td><td width=\"30\"><img src=\""+(__GLOBALS['adminBase'])+"/template/images/green/icons/delete.gif\" ";
	inner += " title=\"Удалить коннектор\" style=\"cursor:pointer;\" onclick=\"deleteConnector(this)\" class=\"delimg_intable\"></td>";
	newRow.innerHTML = inner;
	if(has){
		document.getElementById("portsFields_"+(cLength-1)).getElementsByTagName("option")[0].selected = true;
	}else{
		setConnectors(document.getElementById("portsTables").value);
	}
}
//*********************************
function deleteConnector(sobj){
	var obj = sobj.parentNode.parentNode;
	obj.parentNode.removeChild(obj);
}
//*********************************
function setConnectors(tableName){
	tableName = tableName.split(":")[0];
	var objs = document.getElementById("portsFields").getElementsByTagName("option");
	var sels = document.getElementById("connectorsTable").getElementsByTagName("select");
	for(var jj=0; jj<sels.length; jj++){
		var sel = sels[jj];
		sel.value = "";
		var inner = "<option></option>";
		for(var j=0; j<objs.length; j++){
			var obj = objs[j];
			if(obj.value.split(".")[0]==tableName){
				//console.log(obj.value+"::"+obj.innerHTML);
				inner += "<option value=\""+obj.value+"\">"+(obj.value.split(":")[0])+"</option>";
			}
		}
		sel.innerHTML = inner;
	}
}
//*********************************
function getPorts(){
	var paction =  "ajax=getTablesPorts&fieldId="+<?=$filter['id']?>;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
		//	console.log(html);
		//	var data = eval("("+html+")");
		//	if(data.return=='ok'){
		//		getData('<?=$GLOBALS['adminBase']?>/?option=filters,parents=<?=$params['parents']?>');
		//	}else{
		//		alert("Ошибка редактирования");
		//	}
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
		if(obj.id.match(/^fieldDataSubtype_/)){
			if(obj.id.match(RegExp("_"+type, "gi"))){
				obj.style.display = "";
			}else{
				obj.style.display = "none";
			}
		}
	}
	//*************************
	document.getElementById("tr_fieldDBName").style.display = "";
	document.getElementById("tr_fieldDefault").style.display = "";
	document.getElementById("tr_fieldVirtual").style.display = "none";
	document.getElementById("tr_fieldVirtualTable").style.display = "none";
	document.getElementById("tr_fieldConnector").style.display = "none";
	if(type=="varchar"){
		document.getElementById("tr_fieldLength").style.display = "";
	}else if(type=="double"){
		document.getElementById("tr_fieldLength").style.display = "none";
	}else if(type=="int"){
		var subtype = document.getElementById("fieldDataSubtype_int").value;
		if(subtype=="connector"){
			document.getElementById("tr_fieldDBName").style.display = "none";
			document.getElementById("tr_fieldLength").style.display = "none";
			document.getElementById("tr_fieldDefault").style.display = "none";
			document.getElementById("tr_fieldConnector").style.display = "";
		}else{
			document.getElementById("tr_fieldDBName").style.display = "";
			document.getElementById("tr_fieldLength").style.display = "";
			document.getElementById("tr_fieldDefault").style.display = "";
		}
	}else if(type=="text"){
		document.getElementById("tr_fieldLength").style.display = "none";
	}else if(type=="datetime"){
		document.getElementById("tr_fieldLength").style.display = "none";
		document.getElementById("tr_fieldDefault").style.display = "none";
	}else if(type=="virtual"){
		document.getElementById("tr_fieldDBName").style.display = "none";
		document.getElementById("tr_fieldLength").style.display = "none";
		document.getElementById("tr_fieldDefault").style.display = "none";
		document.getElementById("tr_fieldVirtual").style.display = "";
		document.getElementById("tr_fieldVirtualTable").style.display = "";
		getPorts();
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