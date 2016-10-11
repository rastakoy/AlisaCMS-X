<? if($params['action']=='editMenus'){ ?>
<div class="admintitle" style="padding:0px; margin:0px;" >
	<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
	<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	<?  //echo $__page_title; ?>
</div>
<b style="text-transform:uppercase;" id="titlePanel">Редактирование панели «<?=$panel['name']?>»</b>
<div style="height:20px;"></div>
<div class="languagesTabs"><? foreach($GLOBALS['languages'] as $key=>$lang){ ?>
	<span <?
	if((!$params['lang'] && $key==$GLOBALS['language']) || $params['lang']==$key){
		echo "class=\"active\"";
	}else{?>onclick="getData(window.location.pathname+'/<?=$paramsString?>', 'lang', '<?=$key?>')"<? } ?> ><?=$lang['0']?></span>
<? } ?></div>
<div style="float:none;clear:both;"></div>
<div style="background-color:#A9C9A7; padding:15px;">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Название</td>
		<td><input type="text" id="name" style="width:100%;height:25px;" value="<?=$panel['name']?>"
		onkeyup="addNameToTitle();__GLOBALS.editing=true;" onchange="addNameToTitle();__GLOBALS.editing=true;"></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Ресурс</td>
	  <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25"><input type="checkbox" id="intCheck" onchange="__GLOBALS.editing=true;" 
			<? if($panel['external']=='0'){ echo "checked"; } ?> onclick="showInternalSettings(this)" ></td>
            <td width="110">Внутренний</td>
            <td width="25"><input type="checkbox" id="extCheck" onchange="__GLOBALS.editing=true;" 
			<? if($panel['external']=='1'){ echo "checked"; } ?> onclick="showExternalSettings(this)" ></td>
            <td>Внешний</td>
          </tr>
        </table></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" id="internalTable"
style="display:<? if($panel['external']=='1'){ echo "none"; } ?>" >
	<tr>
		<td width="150" height="30">Таблица</td>
		<td><select id="internalTableSelect" style="width:150px;height:25px;"><? foreach($freeTables as $ftable){ ?>
		<option value="<?=$ftable?>" <? if($ftable==$panel['link']){ echo "selected"; } ?> ><?=$ftable?></option>
		<? } ?></select>
		<button style="width:160px;height:25px;">Управление таблицами</button>
		</td>
	</tr>
	<tr>
		<td width="150" height="30">&nbsp;</td>
		<td><input type="text" id="addNewTable" style="width:150px;height:25px;padding-right:20px;padding-left:3px;"
		placeholder="table name" pattern="^[a-z]{1}[a-z0-9_]{2,19}$" maxlength="20">
		<button style="width:160px;height:25px;" onclick="addNewTable()">Добавить таблицу</button>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" id="externalTable"
style="display:<? if($panel['external']=='0'){ echo "none"; } ?>" >
	<tr>
		<td width="150" height="30">Внешняя таблица</td>
		<td><input type="text" id="externalTableName" style="width:150px;height:25px;padding-right:20px;padding-left:3px;"
		placeholder="Внешняя таблица" value="<?=$panel['link']?>" ></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Конструктор блока</td>
		<td><select id="filterSelect" style="width:150px;height:25px;"><? foreach($filters as $filter){ ?>
		<option value="<?=$filter['id']?>" <? if($panel['filter']==$filter['id']){ echo "selected"; } ?> ><?=$filter['name']?></option>
		<? } ?></select>
		<button style="width:160px;height:25px;" onclick="testForConformance()">Проверить таблицу</button>
		</td>
	</tr>
</table>

<!--<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Древовидность</td>
		<td><input type="checkbox" id="visible" onchange="__GLOBALS.editing=true;" checked=""></td>
	</tr>
</table>-->

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Заголовки</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"><select style="width:115px;height:25px;" onchange="changeTitlesType(this.value)" id="titleType">
				<option value="single" <? if($titles['0']=='single'){ echo "selected"; } ?> >Одиночный</option>
				<option value="catalog" <? if($titles['0']=='catalog'){ echo "selected"; } ?> >Каталог</option>
				<option value="static" <? if($titles['0']=='static'){ echo "selected"; } ?> >Статичный</option>
			</select></td>
            <td width=""> — Тип конструкции заголовков</td>
          </tr>
        </table></td>
	</tr>
	
	<tr id="single_0" style="display:<? if($titles['0']!='single') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
		<td width="120">
			<input type="text" style="width:115px;height:25px;padding-left:3px;" value="<? if($titles['0']=='single') echo $titles['1']['0']['0']; ?>">
		</td>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	<tr id="catalog_0" style="display:<? if($titles['0']!='catalog') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
		<? foreach($titles['1']['0'] as $key=>$title){ if($key<2){ ?><td width="120">
			<input type="text" style="width:115px;height:25px;padding-left:3px;" value="<? if($titles['0']=='catalog') echo $title; ?>">
		</td><? }} ?>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	<tr id="static_0" style="display:<? if($titles['0']!='static') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr id="substatic_0">
		<? foreach($titles['1']['0'] as $key=>$title){ ?><td width="90">
			<input type="text" style="width:85px;height:25px;padding-left:3px;" value="<? if($titles['0']=='static') echo $title; ?>">
		</td><? } ?>
		<td><img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/plus_whitebg.gif" style="cursor:pointer;"
		onclick="addNewCell()"></td></tr></table></td>
	</tr>
	
	<tr id="single_1" style="display:<? if($titles['0']!='single') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
		<td width="120">
			<input type="text" style="width:115px;height:25px;padding-left:3px;" value="<? if($titles['0']=='single') echo $titles['1']['1']['0']; ?>">
		</td>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	<tr id="catalog_1" style="display:<? if($titles['0']!='catalog') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
		<? foreach($titles['1']['1'] as $key=>$title){ if($key<2){ ?><td width="120">
			<input type="text" style="width:115px;height:25px;padding-left:3px;" value="<? if($titles['0']=='catalog') echo $title; ?>">
		</td><? }} ?>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	<tr id="static_1" style="display:<? if($titles['0']!='static') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr id="substatic_1">
		<? foreach($titles['1']['1'] as $key=>$title){ ?><td width="90">
			<input type="text" style="width:85px;height:25px;padding-left:3px;" value="<? if($titles['0']=='static') echo $title; ?>">
		</td><? } ?>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	
	<tr id="single_2" style="display:<? if($titles['0']!='single') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
		<td width="120">
			<input type="text" style="width:115px;height:25px;padding-left:3px;" value="<? if($titles['0']=='single') echo $titles['1']['2']['0']; ?>">
		</td>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	<tr id="catalog_2" style="display:<? if($titles['0']!='catalog') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
		<? foreach($titles['1']['2'] as $key=>$title){ if($key<2){ ?><td width="120">
			<input type="text" style="width:115px;height:25px;padding-left:3px;" value="<? if($titles['0']=='catalog') echo $title; ?>">
		</td><? }} ?>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	<tr id="static_2" style="display:<? if($titles['0']!='static') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr id="substatic_2">
		<? foreach($titles['1']['2'] as $key=>$title){ ?><td width="90">
			<input type="text" style="width:85px;height:25px;padding-left:3px;" value="<? if($titles['0']=='static') echo $title; ?>">
		</td><? } ?>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	
	
	<tr id="single_3" style="display:<? if($titles['0']!='single') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
		<td width="120">
			<input type="text" style="width:115px;height:25px;padding-left:3px;" value="<? if($titles['0']=='single') echo $titles['1']['3']['0']; ?>">
		</td>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	<tr id="catalog_3" style="display:<? if($titles['0']!='catalog') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
		<? foreach($titles['1']['3'] as $key=>$title){ if($key<2){ ?><td width="120">
			<input type="text" style="width:115px;height:25px;padding-left:3px;" value="<? if($titles['0']=='catalog') echo $title; ?>">
		</td><? }} ?>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	<tr id="static_3" style="display:<? if($titles['0']!='static') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr id="substatic_3">
		<? foreach($titles['1']['3'] as $key=>$title){ ?><td width="90">
			<input type="text" style="width:85px;height:25px;padding-left:3px;" value="<? if($titles['0']=='static') echo $title; ?>">
		</td><? } ?>
		<td>&nbsp;</td></tr></table></td>
	</tr>
	<tr id="static_4" style="display:<? if($titles['0']!='static') echo "none"; ?>;">
		<td width="150" height="30">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr id="delsubstatic_">
		<? foreach($titles['1']['3'] as $key=>$title){ ?><td width="90" align="center">
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/delete.gif" style="cursor:pointer;"
		onclick="deleteCell(this)" class="delimg_intable">
		</td><? } ?>
		<td>&nbsp;</td></tr></table></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Отображать в меню</td>
		<td><input id="panelActive" type="checkbox" id="visible" onchange="__GLOBALS.editing=true;"  <? if($panel['active']=='1') echo "checked"; ?> ></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">&nbsp;</td>
		<td><button onclick="savePanel()">Сохранить</button>  <button onclick="getData(window.location.pathname)">Отменить</button></td>
	</tr>
</table>
</div>
<script>
//*********************************************************

//*********************************************************

//*********************************************************
function constructTitles(){
	var titleType = document.getElementById("titleType").value;
	var titles = titleType+":";
	if(titleType=="catalog"){
		for(var j=0; j<4; j++){
			titles += document.getElementById("catalog_"+j).getElementsByTagName("input")[0].value+"->";
			titles += document.getElementById("catalog_"+j).getElementsByTagName("input")[1].value+"\n";
		}
	}else if(titleType=="single"){
		for(var j=0; j<4; j++){
			titles += document.getElementById("single_"+j).getElementsByTagName("input")[0].value+"\n";
		}
	}else if(titleType=="static"){
		for(var j=0; j<4; j++){
			var objs = document.getElementById("static_"+j).getElementsByTagName("input");
			for(var jj=0; jj<objs.length; jj++){
				if(jj>0) titles += "->";
				titles += objs[jj].value;
			}
			titles += "\n";
		}
	}
	return titles.replace(/\n$/gi, '');
}
//*********************************************************
function savePanel(){
	var paction = "ajax=savePanel";
	paction += "&id=<?=$panel['id']?>";
	paction += "&name="+encodeURIComponent(document.getElementById("name").value);
	if(document.getElementById("extCheck").checked){
		paction += "&external=1";
		paction += "&link="+document.getElementById("externalTableName").value;
	}else{
		paction += "&external=0";
		paction += "&link="+document.getElementById("internalTableSelect").value;
	}
	paction += "&filter="+document.getElementById("filterSelect").value;
	paction += "&active="+((document.getElementById("panelActive").checked)?"1":"0");
	paction += "&titleType="+document.getElementById("titleType").value;
	paction += "&titles="+encodeURIComponent(constructTitles());
	__GLOBALS.editing = false;
	startPreloader();
	//console.log(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			//globalEdit=false;
			getData('<?=$GLOBALS['adminBase']?>/');
			//openLeftBranch('<?=$optionName?>', '<?=$parents[count($parents)-1]['id']?>');
			//openLeftBranch('<?=$optionName?>', '<?=$parents[count($parents)-1]['id']?>');
			//__css_itemShowCSS();
			//var obj = document.getElementById("show_cssblock_cont");
			//$(obj).empty();
			//$(obj).append(html);	
		}
	});
}
//*********************************************************
function showExternalSettings(obj){
	if(!obj.checked){
		obj.checked = true;
		return false;
	}
	document.getElementById("intCheck").checked = false;
	document.getElementById("internalTable").style.display = "none";
	document.getElementById("externalTable").style.display = "";
}
//*********************************************************
function showInternalSettings(obj){
	if(!obj.checked){
		obj.checked = true;
		return false;
	}
	document.getElementById("extCheck").checked = false;
	document.getElementById("internalTable").style.display = "";
	document.getElementById("externalTable").style.display = "none";
}
//*********************************************************
function deleteCell(img){
	if(confirm("Удалить столбец?")){
		var objs = document.getElementsByClassName("delimg_intable");
		var column = -1;
		for(var j=0; j<objs.length; j++){
			var obj = objs[j];
			if(obj==img){
				column = j;
			}
		}
		//*****************
		var trObjs = document.getElementsByTagName("tr");
		var atrObjs = {};
		var delTrObjs = {};
		for(var j=0; j<trObjs.length; j++){
			var trObj = trObjs[j];
			if(trObj.id.match(/^substatic_/)){
				atrObjs[j] = trObj;
			}
		}
		for(var j=0; j<trObjs.length; j++){
			var trObj = trObjs[j];
			if(trObj.id.match(/^delsubstatic_/)){
				delTrObjs[j] = trObj;
			}
		}
		//*****************
		for(var j in atrObjs){
			if(column>-1){
				atrObjs[j].deleteCell(column);
			}
		}
		for(var j in delTrObjs){
			if(column>-1){
				delTrObjs[j].deleteCell(column);
			}
		}
		//*****************
	}
}
//*********************************************************
function addNewCell(){
	var trObjs = document.getElementsByTagName("tr");
	var atrObjs = {};
	var delTrObjs = {};
	for(var j=0; j<trObjs.length; j++){
		var trObj = trObjs[j];
		if(trObj.id.match(/^substatic_/)){
			atrObjs[j] = trObj;
		}
	}
	for(var j=0; j<trObjs.length; j++){
		var trObj = trObjs[j];
		if(trObj.id.match(/^delsubstatic_/)){
			delTrObjs[j] = trObj;
		}
	}
	//console.log(atrObjs);
	for(var j in atrObjs){
		newCell = atrObjs[j].insertCell(atrObjs[j].cells.length-1);
		newCell.style.width = "90px";
		newCell.innerHTML = "<input type=\"text\" style=\"width:85px;height:25px;padding-left:3px;\" />";
	}
	for(var j in delTrObjs){
		newCell = delTrObjs[j].insertCell(delTrObjs[j].cells.length-1);
		newCell.style.width = "90px";
		newCell.style.textAlign = "center";
		newCell.innerHTML = "<img src=\"<?=$GLOBALS['adminBase']?>/template/images/green/icons/delete.gif\" style=\"cursor:pointer;\" onclick=\"deleteCell(this)\" class=\"delimg_intable\">";
	}
}
//*********************************************************
function changeTitlesType(ttype){
	if(ttype=='single'){
		document.getElementById('single_0').style.display = "";
		document.getElementById('single_1').style.display = "";
		document.getElementById('single_2').style.display = "";
		document.getElementById('single_3').style.display = "";
		//**********
		document.getElementById('catalog_0').style.display = "none";
		document.getElementById('catalog_1').style.display = "none";
		document.getElementById('catalog_2').style.display = "none";
		document.getElementById('catalog_3').style.display = "none";
		//**********
		document.getElementById('static_0').style.display = "none";
		document.getElementById('static_1').style.display = "none";
		document.getElementById('static_2').style.display = "none";
		document.getElementById('static_3').style.display = "none";
		document.getElementById('static_4').style.display = "none";
	}else if(ttype=='catalog'){
		document.getElementById('single_0').style.display = "none";
		document.getElementById('single_1').style.display = "none";
		document.getElementById('single_2').style.display = "none";
		document.getElementById('single_3').style.display = "none";
		//**********
		document.getElementById('catalog_0').style.display = "";
		document.getElementById('catalog_1').style.display = "";
		document.getElementById('catalog_2').style.display = "";
		document.getElementById('catalog_3').style.display = "";
		//**********
		document.getElementById('static_0').style.display = "none";
		document.getElementById('static_1').style.display = "none";
		document.getElementById('static_2').style.display = "none";
		document.getElementById('static_3').style.display = "none";
		document.getElementById('static_4').style.display = "none";
	}else if(ttype=='static'){
		document.getElementById('single_0').style.display = "none";
		document.getElementById('single_1').style.display = "none";
		document.getElementById('single_2').style.display = "none";
		document.getElementById('single_3').style.display = "none";
		//**********
		document.getElementById('catalog_0').style.display = "none";
		document.getElementById('catalog_1').style.display = "none";
		document.getElementById('catalog_2').style.display = "none";
		document.getElementById('catalog_3').style.display = "none";
		//**********
		document.getElementById('static_0').style.display = "";
		document.getElementById('static_1').style.display = "";
		document.getElementById('static_2').style.display = "";
		document.getElementById('static_3').style.display = "";
		document.getElementById('static_4').style.display = "";
	}
}
//*********************************************************
inputPreloader(document.getElementById("addNewTable"), 'testUseTable');
//*********************************************************
function addNewTable(){
	var obj = document.getElementById("addNewTable");
	if(obj.className.match(/ ?inputok ?/gi)){
		var paction =  "ajax=addNewTable";
		paction += "&tableName="+obj.value;
		//console.log(paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//console.log(html);
				html = (html=='')?'{}':html;
				var data = eval("("+html+")");
				if(data.table!='error'){
					var inner = "";
					for(var j in data.data){
						inner += "<option value=\""+data.data[j]+"\" ";
						if(data.data[j]==data.table){
							inner += "selected";
						}
						inner += " >"+data.data[j]+"</option>";
					}
					document.getElementById("internalTableSelect").innerHTML = inner;
					var object = document.getElementById("addNewTable");
					object.className = object.className.replace(/( ?inputpreloader ?| ?inputok ?| ?inputfalse ?)/gi, '');
					object.value = "";
				}else{
					alert("Произошла ошибка");
				}
				//getData('<?=$GLOBALS['adminBase']?>/');
				//window.location.href = window.location.pathname;
			}
		});
	}else{
		obj.style.backgroundColor = '#FDDDD9';
	}
}
//*********************************************************
</script>

<? }else{ ?>

<div class="admintitle" style="padding:0px; margin:0px;" >
	<a href="javascript:" id="add_item_to_cat_button" style="width:85px;" onclick="addNewOption()">Добавить панель</a>
	<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
	<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	<?  //echo $__page_title; ?>
</div>
<div style="float:none; clear:both;"></div>


<div style="line-height:25px; margin-top:5px;margin-right:15px;float:left;">

	<b style="text-transform:uppercase;">Настройки панелей в системе управления сайтом</b>
	<div id="adminGlobalSettings" class="adminGlobalSettings" style="display:;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<th class="tdGlobalSettings" width="20" align="left">&nbsp;</th>
			<th class="tdGlobalSettings" width="150" align="left">Название</th>
			<th class="tdGlobalSettings" width="70" align="center">Таблица</th>
			<th class="tdGlobalSettings" width="100" align="center">Ресурс</th>
			<th class="tdGlobalSettings" width="150" align="center">Шаблон</th>
			<!--<th class="tdGlobalSettings" width="70" align="center">Заголовки</th>-->
			<th class="tdGlobalSettings">&nbsp;</th>
			<th class="tdGlobalSettings" width="24">&nbsp;</th>
		</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody id="globalMenus">
		<? foreach($menus as $k=>$menu){ ?>
		<tr bgcolor="#FFFFFF" id="menus_<?=$menu['id']?>" class="trGlobalSettings" <? if($menu['link']=='filters'){ ?>noclick="1" <? } ?>>
			<td class="tdGlobalSettings" height="34" width="20"><a href="javascript:" title="Отображение в меню слева"><img
			src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/glaz<? if($menu['active']=='0'){ ?>_no<? } ?>.gif"
			id="glaz_<?=$menu['id']?>" width="16" height="16" border="0"
			onclick="toggleVisible('menusettings','<?=$menu['id']?>', 'active')"></a></td>
			<td class="tdGlobalSettings" width="150"><?=$menu['name']?></td>
			<td class="tdGlobalSettings" width="70" align="center"><?=$menu['link']?></td>
			<td class="tdGlobalSettings" width="100" align="center"><?=$menu['external']?></td>
			<td class="tdGlobalSettings" width="150" align="center"><?=$menu['filterName']?></td>
			<!--<td class="tdGlobalSettings" width="70" align="center"><a href="javascript:">Редактор</a></td>-->
			<td class="tdGlobalSettings">&nbsp;</td>
			<td class="tdGlobalSettings" width="24" align="center"><? if($menu['link']!='filters'){ ?><a href="javascript:" title="Изменить группу">
			<img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" border="0"
			onclick="getData('<?=$GLOBALS['adminBase']?>/?action=editMenus,menuId=<?=$menu['id']?>')"></a><? } ?></td>
			
		</tr>
		<? } ?>
	</tbody></table>
	</div>
</div>
<script>
//*********************************************************
function addNewOption(){
	getData('<?=$GLOBALS['adminBase']?>/?action=editMenus,menuId=0');
}
//*********************************************************
$( "#globalMenus" ).sortable({
	update: function() {
		var priors = $(this).sortable('toArray');
		startPreloader();
		var paction =  "ajax=setMenusPriors";
		paction += "&ids="+(( priors instanceof Array )?priors.join(','):priors);
		//console.log(paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				console.log(html);
				//getData('<?=$GLOBALS['adminBase']?>/');
				window.location.href = window.location.pathname;
			}
		});
	}
});
//*********************************************************
$( ".trGlobalSettings" ).dblclick(function () {
	if(this.getAttribute("noclick")=="1"){
		return false;
	}
	var menuId = this.id.replace(/menus_/gi, '');
	getData('<?=$GLOBALS['adminBase']?>/?action=editMenus,menuId='+menuId)
});
//*********************************************************

</script>

<div style="line-height:25px; margin-top:15px;margin-right:15px;float:left;">
	<b style="text-transform:uppercase;">Основные настройки</b>
	<div id="adminGlobalSettings" class="adminGlobalSettings" style="display:;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody><tr>
						<td class="tdGlobalSettings" width="300">Включить/выключить учет остатков на складе</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="restsOnOff_id" onclick="restsOnOff()"></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Ваш е-mail для уведомлений</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="0066aa@mail.ru, lev-arsenal@mail.ru" id="updateSiteSettingsEmail"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsEmail()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Ваш контактный телефон</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="(050)304-60-82" id="updateSiteSettingsPhone" placeholder="+38(0__) ___-__-__" required="required" pattern="^\+38\(0\d\d\) \d\d\d\-\d\d\-\d\d$"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsPhone()">ok</a></td>
		</tr>
				<tr>
						<td class="tdGlobalSettings" width="300"><b>Уведомлять меня о покупке по SMS</b></td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="sendGoodInfo_id" onclick="sendGoodInfo()" checked  /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
				<tr>
						<td class="tdGlobalSettings" width="300">Тело счета</td>
			<td class="tdGlobalSettings" width=""><a href="javascript:get_fast_order_cont()">Изменить</a></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Автоматически отправлять счет клиенту после покупки</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="sendGoodOrder_id" onclick="sendGoodOrder()" checked  /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Активировать «Тип платежа»</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="sendBasketPayType_id" onclick="sendBasketPayType()" checked  /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Активировать пользовательское соглашение</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="offertOnOff_id" onclick="offertOnOff()"> <a href="javascript:get_fast_offert_cont()">Изменить</a></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Активировать комментарии к товарам</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="reviewsOnOff_id" onclick="reviewsOnOff()" checked=""></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Хранение заказов в корзине</td>
			<td class="tdGlobalSettings" width=""><input type="number" style="width:45px;height:24px;" value="12" id="updateSiteSettingsOrdersKeep"> часов</td>
			<td class="tdGlobalSettings"><a href="javascript:__updateSiteSettingsOrdersKeep()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">META TITLE по умолчанию</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="Мототехника в Полтаве" id="updateSiteSettingsMetaTitleCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsMetaTitle()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">META DESCRIPTION по умолчанию</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="Мототехника в Полтаве" id="updateSiteSettingsMetaDescriptionCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsMetaDescription()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">META KEYWORDS по умолчанию</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="Мототехника в Полтаве" id="updateSiteSettingsMetaKeywordsCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsMetaKeywords()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Банковский процент</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="0.5" id="updateBankRentCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateBankRent()">ok</a></td>
		</tr>
		
		<!--<tr>
			<td class="tdGlobalSettings" width="300">Мультивалютность</td>
			<td class="tdGlobalSettings" width="" style="padding-top:5px;"><div id="currencySortable">
				<span class="consolCurrency"><img src="images/green/icons/galochka.gif" width="11" height="11" border="0" align="absmiddle"
						style="margin-right:3px;" />грн &nbsp;&nbsp; &nbsp;<b>1:1</b><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_гривна" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span><span class="consolCurrency"><img src="images/green/myitemname_popup/glaz.gif" id="glaz_рубль" 
						width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;cursor:pointer;"
						onClick="toggleCurrencyShow(this, '1')" />RUR &nbsp;<input type="number" style="width:53px;" onChange="changeCurrency(this, '1')" value="0.35" ><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_рубль" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span><span class="consolCurrency"><img src="images/green/myitemname_popup/glaz.gif" id="glaz_доллар" 
						width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;cursor:pointer;"
						onClick="toggleCurrencyShow(this, '2')" />USD &nbsp;<input type="number" style="width:53px;" onChange="changeCurrency(this, '2')" value="21" ><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_доллар" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span><span class="consolCurrency"><img src="images/green/myitemname_popup/glaz.gif" id="glaz_евро" 
						width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;cursor:pointer;"
						onClick="toggleCurrencyShow(this, '3')" />EUR &nbsp;<input type="number" style="width:53px;" onChange="changeCurrency(this, '3')" value="23" ><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_евро" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span>			</div></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>-->
		
		<!--<tr>
			<td class="tdGlobalSettings" width="300">Мультиязычность</td>
			<td class="tdGlobalSettings" width="" style="padding-top:5px;"><div id="langsSortable">
				<span class="consolLangs"><img src="images/green/icons/galochka.gif" width="11" height="11" border="0" align="absmiddle"
						style="margin-right:3px;" />рус &nbsp;&nbsp;
					<img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_rus" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span>			</div></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>-->
		
		<tr>
						<td class="tdGlobalSettings" width="300">Курс доллара</td>
			<td class="tdGlobalSettings" width=""><input type="number" style="width: 75px;height:24px;" value="25" id="updateSiteSettingsDollarCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsDollar()">ok</a></td>
		</tr>
	</tbody></table></div>
	</div>
<? } ?>