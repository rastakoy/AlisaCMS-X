<? if($params['action']=='editMenus'){ ?>
<div class="admintitle" style="padding:0px; margin:0px;" >
	<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
	<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	<?  //echo $__page_title; ?>
</div>
<b style="text-transform:uppercase;" id="titlePanel">�������������� ������ �<?=$panel['name']?>�</b>
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
		<td width="150" height="30">��������</td>
		<td><input type="text" id="name" style="width:100%;height:25px;" value="<?=$panel['name']?>"
		onkeyup="addNameToTitle();__GLOBALS.editing=true;" onchange="addNameToTitle();__GLOBALS.editing=true;"></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">������</td>
	  <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25"><input type="checkbox" id="intCheck" onchange="__GLOBALS.editing=true;" 
			<? if($panel['external']=='0'){ echo "checked"; } ?> onclick="showInternalSettings(this)" ></td>
            <td width="110">����������</td>
            <td width="25"><input type="checkbox" id="extCheck" onchange="__GLOBALS.editing=true;" 
			<? if($panel['external']=='1'){ echo "checked"; } ?> onclick="showExternalSettings(this)" ></td>
            <td>�������</td>
          </tr>
        </table></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" id="internalTable"
style="display:<? if($panel['external']=='1'){ echo "none"; } ?>" >
	<tr>
		<td width="150" height="30">�������</td>
		<td><select id="internalTableSelect" style="width:150px;height:25px;"><? foreach($freeTables as $ftable){ ?>
		<option value="<?=$ftable?>" <? if($ftable==$panel['link']){ echo "selected"; } ?> ><?=$ftable?></option>
		<? } ?></select>
		<button style="width:160px;height:25px;">���������� ���������</button>
		</td>
	</tr>
	<tr>
		<td width="150" height="30">&nbsp;</td>
		<td><input type="text" id="addNewTable" style="width:150px;height:25px;padding-right:20px;padding-left:3px;"
		placeholder="table name" pattern="^[a-z]{1}[a-z0-9_]{2,19}$" maxlength="20">
		<button style="width:160px;height:25px;" onclick="addNewTable()">�������� �������</button>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" id="externalTable"
style="display:<? if($panel['external']=='0'){ echo "none"; } ?>" >
	<tr>
		<td width="150" height="30">������� �������</td>
		<td><input type="text" id="externalTableName" style="width:150px;height:25px;padding-right:20px;padding-left:3px;"
		placeholder="������� �������" value="<?=$panel['link']?>" ></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">����������� �����</td>
		<td><select id="filterSelect" style="width:150px;height:25px;"><? foreach($filters as $filter){ ?>
		<option value="<?=$filter['id']?>" <? if($panel['filter']==$filter['id']){ echo "selected"; } ?> ><?=$filter['name']?></option>
		<? } ?></select>
		<button style="width:160px;height:25px;" onclick="testForConformance()">��������� �������</button>
		</td>
	</tr>
</table>

<!--<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">�������������</td>
		<td><input type="checkbox" id="visible" onchange="__GLOBALS.editing=true;" checked=""></td>
	</tr>
</table>-->

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">���������</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"><select style="width:115px;height:25px;" onchange="changeTitlesType(this.value)" id="titleType">
				<option value="single" <? if($titles['0']=='single'){ echo "selected"; } ?> >���������</option>
				<option value="catalog" <? if($titles['0']=='catalog'){ echo "selected"; } ?> >�������</option>
				<option value="static" <? if($titles['0']=='static'){ echo "selected"; } ?> >���������</option>
			</select></td>
            <td width=""> � ��� ����������� ����������</td>
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
		<td width="150" height="30">���������� � ����</td>
		<td><input id="panelActive" type="checkbox" id="visible" onchange="__GLOBALS.editing=true;"  <? if($panel['active']=='1') echo "checked"; ?> ></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">�����������</td>
		<td><input id="commentsActive" type="checkbox" id="comments" onchange="__GLOBALS.editing=true;"  <? if($panel['comments']=='1') echo "checked"; ?> ></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">&nbsp;</td>
		<td><button onclick="savePanel()">���������</button>  <button onclick="getData(window.location.pathname)">��������</button></td>
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
	paction += "&comments="+((document.getElementById("commentsActive").checked)?"1":"0");
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
	if(confirm("������� �������?")){
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
					alert("��������� ������");
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
	<a href="javascript:" id="add_item_to_cat_button" style="width:85px;" onclick="addNewOption()">�������� ������</a>
	<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
	<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	<?  //echo $__page_title; ?>
</div>
<div style="float:none; clear:both;"></div>


<div style="line-height:25px; margin-top:5px;margin-right:15px;float:left;">

	<b style="text-transform:uppercase;">��������� ������� � ������� ���������� ������</b>
	<div id="adminGlobalSettings" class="adminGlobalSettings" style="display:;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<th class="tdGlobalSettings" width="20" align="left">&nbsp;</th>
			<th class="tdGlobalSettings" width="150" align="left">��������</th>
			<th class="tdGlobalSettings" width="70" align="center">�������</th>
			<th class="tdGlobalSettings" width="100" align="center">������</th>
			<th class="tdGlobalSettings" width="150" align="center">������</th>
			<!--<th class="tdGlobalSettings" width="70" align="center">���������</th>-->
			<th class="tdGlobalSettings">&nbsp;</th>
			<th class="tdGlobalSettings" width="24">&nbsp;</th>
		</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody id="globalMenus">
		<? foreach($menus as $k=>$menu){ ?>
		<tr bgcolor="#FFFFFF" id="menus_<?=$menu['id']?>" class="trGlobalSettings" <? if($menu['link']=='filters'){ ?>noclick="1" <? } ?>>
			<td class="tdGlobalSettings" height="34" width="20"><a href="javascript:" title="����������� � ���� �����"><img
			src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/glaz<? if($menu['active']=='0'){ ?>_no<? } ?>.gif"
			id="glaz_<?=$menu['id']?>" width="16" height="16" border="0"
			onclick="toggleVisible('menusettings','<?=$menu['id']?>', 'active');document.location.href=document.location.href;"></a></td>
			<td class="tdGlobalSettings" width="150"><?=$menu['name']?></td>
			<td class="tdGlobalSettings" width="70" align="center"><?=$menu['link']?></td>
			<td class="tdGlobalSettings" width="100" align="center"><?=$menu['external']?></td>
			<td class="tdGlobalSettings" width="150" align="center"><?=$menu['filterName']?></td>
			<!--<td class="tdGlobalSettings" width="70" align="center"><a href="javascript:">��������</a></td>-->
			<td class="tdGlobalSettings">&nbsp;</td>
			<td class="tdGlobalSettings" width="24" align="center"><? if($menu['link']!='filters'){ ?><a href="javascript:" title="�������� ������">
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
	getData('<?=$GLOBALS['adminBase']?>/?action=editMenus,menuId='+menuId);
});
//*********************************************************

</script>


<!-- =============================== -->
<div style="line-height:25px; margin-top:15px;margin-right:15px;float:left;" id="">
<fieldset style="background-color:#A9C9A7; padding-top:0px;">
	<legend style="background-color:#A9C9A7;">
	<b style="text-transform:uppercase;padding-left:5px;padding-right:5px;">��������� ������ �����</b></legend>
	<div id="" class="adminGlobalSettings" style="">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<? if(is_array($siteBlocks)){ foreach ($siteBlocks as $block){ ?>
		<tr>
			<td class="tdGlobalSettings" width=""><?=$block['name']?></td>
			<td class="tdGlobalSettings" width="100" bgcolor="" align="center">
			<button onclick="importExternalData()">���������</button></td>
		</tr>
		<? }} ?>
		<tr>
			<td height="30" width="" style="padding-top:5px;"><button onclick="addSiteBlock()">�������� ����</button></td>
			<td class="" width="30">&nbsp;</td>
		</tr>
	</table>
	</div>
</fieldset>
</div>

<script>
function addSiteBlock(){
	document.getElementById("popup_title").innerHTML = "�������� ������ ��� ����������";
	__popup({"width":"500"});
}
</script>
<!-- =============================== -->


<!-- =============================== -->
<div style="line-height:25px; margin-top:15px;margin-right:15px;float:left;" id="">
	<b style="text-transform:uppercase;">��������� ����</b>
	<div id="" class="adminGlobalSettings" style="display:;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<? if(is_array($siteMenus)){ foreach ($siteMenus as $menu){ ?>
		<tr>
			<td class="tdGlobalSettings" width=""><?=$menu['name']?></td>
			<td class="tdGlobalSettings" width="100" bgcolor="" align="center">
			<button onclick="importExternalData()">���������</button></td>
		</tr>
		<? }} ?>
		<tr>
			<td height="30" width="" style="padding-top:5px;"><button>�������� ����</button></td>
			<td class="" width="30">&nbsp;</td>
		</tr>
	</table>
	</div>
</div>

<script>

</script>
<!-- =============================== -->



<div style="line-height:25px; margin-top:15px;margin-right:15px;float:left;" id="gsAll">
	<b style="text-transform:uppercase;">�������� ���������</b>
		<div class="languagesTabs" id="languagesTabs">
			<span class="active">��������</span>
			<span>�������</span>
			<span>�����������</span>
			<span>�������� �����</span>
			<span>������������</span>
			
		</div>
	<!--<div id="myitems_sortable" class="" style="display:;">-->
	<div id="gs-0" class="adminGlobalSettings" style="display:;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
						<td class="tdGlobalSettings" width="300">��� �-mail ��� �����������</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="0066aa@mail.ru, lev-arsenal@mail.ru" id="updateSiteSettingsEmail"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsEmail()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">��� ���������� �������</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="(050)304-60-82" id="updateSiteSettingsPhone" placeholder="+38(0__) ___-__-__" required="required" pattern="^\+38\(0\d\d\) \d\d\d\-\d\d\-\d\d$"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsPhone()">ok</a></td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">META TITLE �� ���������</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="����������� � �������" id="updateSiteSettingsMetaTitleCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsMetaTitle()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">META DESCRIPTION �� ���������</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="����������� � �������" id="updateSiteSettingsMetaDescriptionCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsMetaDescription()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">META KEYWORDS �� ���������</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="����������� � �������" id="updateSiteSettingsMetaKeywordsCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsMetaKeywords()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">���������� �������</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="0.5" id="updateBankRentCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateBankRent()">ok</a></td>
		</tr>
		
		<!--<tr>
			<td class="tdGlobalSettings" width="300">����������������</td>
			<td class="tdGlobalSettings" width="" style="padding-top:5px;"><div id="currencySortable">
				<span class="consolCurrency"><img src="images/green/icons/galochka.gif" width="11" height="11" border="0" align="absmiddle"
						style="margin-right:3px;" />��� &nbsp;&nbsp; &nbsp;<b>1:1</b><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_������" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span><span class="consolCurrency"><img src="images/green/myitemname_popup/glaz.gif" id="glaz_�����" 
						width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;cursor:pointer;"
						onClick="toggleCurrencyShow(this, '1')" />RUR &nbsp;<input type="number" style="width:53px;" onChange="changeCurrency(this, '1')" value="0.35" ><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_�����" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span><span class="consolCurrency"><img src="images/green/myitemname_popup/glaz.gif" id="glaz_������" 
						width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;cursor:pointer;"
						onClick="toggleCurrencyShow(this, '2')" />USD &nbsp;<input type="number" style="width:53px;" onChange="changeCurrency(this, '2')" value="21" ><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_������" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span><span class="consolCurrency"><img src="images/green/myitemname_popup/glaz.gif" id="glaz_����" 
						width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;cursor:pointer;"
						onClick="toggleCurrencyShow(this, '3')" />EUR &nbsp;<input type="number" style="width:53px;" onChange="changeCurrency(this, '3')" value="23" ><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_����" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span>			</div></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>-->
		
		<!--<tr>
			<td class="tdGlobalSettings" width="300">���������������</td>
			<td class="tdGlobalSettings" width="" style="padding-top:5px;"><div id="langsSortable">
				<span class="consolLangs"><img src="images/green/icons/galochka.gif" width="11" height="11" border="0" align="absmiddle"
						style="margin-right:3px;" />��� &nbsp;&nbsp;
					<img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_rus" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span>			</div></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>-->
		
		<tr>
						<td class="tdGlobalSettings" width="300">���� �������</td>
			<td class="tdGlobalSettings" width=""><input type="number" style="width: 75px;height:24px;" value="25" id="updateSiteSettingsDollarCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsDollar()">ok</a></td>
		</tr>
	</table></div>
	
	<div id="gs-1" class="adminGlobalSettings" style="display:none;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="tdGlobalSettings" width="300">��������/��������� ���� �������� �� ������</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="restsOnOff_id" onclick="restsOnOff()"></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">�������� ����������� � �������</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="toggleSalesSound_id"
			onclick="toggleSiteSetting('salesSound')" <? if($siteSettings['salesSound']=='1') echo "checked"; ?> ></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">���������� ��������� �������</td>
			<td class="tdGlobalSettings" width=""><button onclick="getOrderStatuses()" style="width:150px;">���������</button></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">������������ ���������� �����������</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="imagesVerticalOrientation_id"
			onclick="toggleSiteSetting('photoVerticalOrientation')" <? if($siteSettings['photoVerticalOrientation']=='1') echo "checked"; ?> ></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300"><b>���������� ���� � ������� �� SMS</b></td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="sendGoodInfo_id" onclick="sendGoodInfo()" checked  /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">���� �����</td>
			<td class="tdGlobalSettings" width=""><a href="javascript:get_fast_order_cont()">��������</a></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">������������� ���������� ���� ������� ����� �������</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="sendGoodOrder_id" onclick="sendGoodOrder()" checked  /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">������������ ���� �������</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="sendBasketPayType_id" onclick="sendBasketPayType()" checked  /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">������������ ���������������� ����������</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="offertOnOff_id" onclick="offertOnOff()"> <a href="javascript:get_fast_offert_cont()">��������</a></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">������������ ����������� � �������</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="reviewsOnOff_id" onclick="reviewsOnOff()" checked=""></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		
		<!-- 00000000000000000000  -->
		<tr>
			<td class="tdGlobalSettings" width="300">������������ ����������� � �������</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="reviewsOnOff_id" onclick="reviewsOnOff()" checked=""></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">�������� ������� � �������</td>
			<td class="tdGlobalSettings" width=""><input type="number" style="width:45px;height:24px;" value="12" id="updateSiteSettingsOrdersKeep"> �����</td>
			<td class="tdGlobalSettings"><a href="javascript:__updateSiteSettingsOrdersKeep()">ok</a></td>
		</tr>
		</table>
	</div>
	
	<div id="gs-2" class="adminGlobalSettings" style="display:none;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="tdGlobalSettings" width="300">��� �-mail ��� �����������</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="0066aa@mail.ru, lev-arsenal@mail.ru" id="updateSiteSettingsEmail"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsEmail()">ok</a></td>
		</tr>
		<tr>
			<td class="tdGlobalSettings" width="300">��� �-mail ��� �����������</td>
			<td class="tdGlobalSettings" width=""><button>�������� ����</button></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsEmail()">ok</a></td>
		</tr>
	</table>
	</div>
	
	
</div>

<script>
//********************************

//********************************
function toggleSiteSetting(fieldKey){
	var paction = "ajax=toggle";
	paction += "&option=settings";
	paction += "&keyField=arrayName";
	paction += "&keyValue="+fieldKey;
	paction += "&field=value";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
		}
	});
}
//********************************
function setOrderStatusColor(obj){
	var id = obj.id.replace(/^.*_/gi, '');
	var paction = "ajax=setOrderStatusColor";
	paction += "&color="+obj.value;
	paction += "&id="+id;
	//console.log(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
		}
	});
}
//********************************
function saveOrderStatus(){
	var paction = "ajax=saveOrderStatus";
	paction += "&id="+document.getElementById("newOrderStatusId").value;
	if(document.getElementById("newOrderStatusName").value=='' ||
	!document.getElementById("newOrderStatusName").className.match(/ ?inputok ?/gi)){
		document.getElementById("newOrderStatusName").style.backgroundColor = '#FDDDD9';
		return false;
	}
	paction += "&name="+encodeURIComponent(document.getElementById("newOrderStatusName").value);
	if(document.getElementById("newOrderStatusLink").value=='' ||
	!document.getElementById("newOrderStatusLink").className.match(/ ?inputok ?/gi)){
		document.getElementById("newOrderStatusLink").style.backgroundColor = '#FDDDD9';
		return false;
	}
	paction += "&link="+encodeURIComponent(document.getElementById("newOrderStatusLink").value);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			document.getElementById("newOrderStatusId").value = '';
			document.getElementById("newOrderStatusName").className = '';
			document.getElementById("newOrderStatusName").value = '';
			document.getElementById("newOrderStatusLink").className = '';
			document.getElementById("newOrderStatusLink").value = '';
			getOrderStatuses();
		}
	});
}
//********************************
function editOrderStatus(statusId){
	var paction = "ajax=editOrderStatus";
	paction += "&id="+statusId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			var data = eval("("+html+")");
			
			document.getElementById("newOrderStatusButton").value = '�������� ���������';
			document.getElementById("newOrderStatusId").value = data['id'];
			
			var nameObj = document.getElementById("newOrderStatusName");
			nameObj.className = (nameObj.className=='')?'inputpreloader inputok':' inputpreloader inputok';
			nameObj.value = data['name'];
			
			var linkObj = document.getElementById("newOrderStatusLink");
			linkObj.className = (linkObj.className=='')?'inputpreloader inputok':' inputpreloader inputok';
			linkObj.value = data['link'];
			
			//document.getElementById("newOrderStatusName").value = '';
			//document.getElementById("newOrderStatusLink").className = '';
			//document.getElementById("newOrderStatusLink").value = '';
			//getOrderStatuses();
		}
	});
}
//********************************
function saveOrderStatusesPriors(){
	var priors = $('#divGetOrderStatuses').sortable('toArray');
	priors = priors.join(',').replace(/subOS_/gi, '');
	var paction = "ajax=saveOrderStatusesPriors";
	paction += "&priors="+priors;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			getOrderStatuses();
		}
	});
}
//********************************
function setGoodFromStoreToTMP(obj){
	var idPrefix = obj.id.replace(/_[0-9]*$/gi, '_');
	var aobjs = document.querySelectorAll( 'img[id^="' + idPrefix );
	for(var j=0; j<aobjs.length; j++){
		var aobj = aobjs[j];
		if(aobj!=obj){
			aobj.src = aobj.src.replace(/_checked\.gif$/gi, '.gif');
		}
	}
	//console.log(aobjs);
	if(obj.src.match(/_checked\.gif$/)){
		obj.src = obj.src.replace(/_checked\.gif$/gi, '.gif');
	}else{
		obj.src = obj.src.replace(/\.gif$/gi, '_checked.gif');
	}
}
//********************************
function setGoodFromClientToStore(obj){
	var idPrefix = obj.id.replace(/_[0-9]*$/gi, '_');
	var aobjs = document.querySelectorAll( 'img[id^="' + idPrefix );
	for(var j=0; j<aobjs.length; j++){
		var aobj = aobjs[j];
		if(aobj!=obj){
			aobj.src = aobj.src.replace(/_checked\.gif$/gi, '.gif');
		}
	}
	//console.log(aobjs);
	if(obj.src.match(/_checked\.gif$/)){
		obj.src = obj.src.replace(/_checked\.gif$/gi, '.gif');
	}else{
		obj.src = obj.src.replace(/\.gif$/gi, '_checked.gif');
	}
}
//********************************
var objs = document.getElementById("languagesTabs").getElementsByTagName("span");
for(var j=0; j<objs.length; j++){
	var obj = objs[j];
	obj.onclick = function(){
		var objs = document.getElementById("gsAll").getElementsByClassName("adminGlobalSettings");
		var sobjs = document.getElementById("languagesTabs").getElementsByTagName("span");
		for(var j=0; j<objs.length; j++){
			var obj = document.getElementById("gs-"+j);
			if(obj){
				obj.style.display = "none";
				sobjs[j].className = "";
				if(sobjs[j]==this){
					obj.style.display = "";
					sobjs[j].className = "active";
				}
			}
		}
	}
}
//********************************
var objs = document.getElementById("languagesTabs").getElementsByTagName("span");
for(var j=0; j<objs.length; j++){
	var obj = objs[j];
	obj.onclick = function(){
		var objs = document.getElementById("gsAll").getElementsByClassName("adminGlobalSettings");
		var sobjs = document.getElementById("languagesTabs").getElementsByTagName("span");
		for(var j=0; j<objs.length; j++){
			var obj = document.getElementById("gs-"+j);
			if(obj){
				obj.style.display = "none";
				sobjs[j].className = "";
				if(sobjs[j]==this){
					obj.style.display = "";
					sobjs[j].className = "active";
				}
			}
		}
	}
}
//********************************

//********************************
</script>

<? } ?>