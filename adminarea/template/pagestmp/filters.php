		<div class="admintitle" style="padding:0px; margin:0px;" >
		<? if(count($url)=='1'){ ?>
		<a onclick="addFilterClass()" href="javascript:" id="add_item_to_cat_button">Добавить шаблон</a>
		<!--<a href="javascript:addItemToCatalog(1)" id="add_folder_to_cat_button">Просмотр фильтра</a>
		<a href="javascript:editItemToCatalog('1');" id="edit_folder_cat_button">Свойства фильтра</a>
		<a href="javascript:" id="deletefolderbutton">Удалить фильтр</a>-->
		<a href="javascript:show_ritems('help');" id="outerhelp">?</a>
		<? }else{ ?>
		<a onclick="addFilterOption()" href="javascript:" id="add_item_to_cat_button">Добавить опцию</a>
		<a onclick="getPage('/adminarea/filters/editfilter/<?=$filterParent['id']?>/')"
		href="javascript:" id="edit_folder_cat_button">Свойства шаблона</a>
		<a onclick="getPage('/adminarea/filters/')" href="javascript:" id="add_folder_to_cat_button">Просмотр фильтров</a>
		<!--<a href="javascript:" id="deletefolderbutton">Удалить группу</a>-->
		<a href="javascript:show_ritems('help');" id="outerhelp">?</a>
		<? } ?>
		<span style="padding-top:5px; display:block;">&nbsp;<? if(isset($version)) echo $version; ?></span>
	    <?  //echo $__page_title; ?>
		</div>
		<div style="float:none; clear:both;"></div>
		<div class="manageadminforms" id="edit_content" style="display:;">
<!--  ------------------------------------------------------------- -->
<div class="folders_all">Просмотр группы
			<h1 id="folders_title">Шаблоны <? if(count($url)>='2'){ ?>
			-› <?=$filterParent['name']?>
			<? } ?></h1>
			<div id="folders_count_items">Элементов: <?=count($filters)?></div>
			<div id="all_show_items" style="margin-top:20px;"></div>
		</div>


<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($filters); echo "</pre>"; ?>
<? if(is_array($filters)){ foreach($filters as $filter){
if($filter['folder']=='1') {
 ?>
	<div class="ui-state-default-2 connectedSortable" id="prm_<?=$filter['link']?>">
	<div id="div_myitemname_1" class="div_myitemname" style="padding-top: 0px;">
		<table id="folder_1" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_1" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(1)"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show(1)" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_1" width="16" height="16" border="0"></a></td>
			<td height="34" width="20"><img src="/adminarea/template/images/itemFolder.jpg" width="44" height="33" border="1" class="imggal" align="absmiddle" style="margin-right:5px;"></td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_1"><?=$filter['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Клонировать шаблон"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="cloneTemplate('<?=$filter['id']?>')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Редактировать шаблон"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="getPage('/adminarea/<?=$url['0']?>/editfilter/<?=$filter['id']?>/')"></a></td>
			<td height="34" width="20"><? if($filter['default'] != '1'){ ?><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteFilterFolder(<?=$filter['id']?>)"></a><? } ?></td>
		</tr></table>
	</div>
</div>
<? }else{ ?>
<div class="ui-state-default-2 connectedSortable" id="prm_<?=$filter['link']?>">
	<div id="div_myitemname_1" class="div_myitemname" style="padding-top: 0px;">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_105" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(105)"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show(105)" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_105" width="16" height="16" border="0"></a></td>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/no_img.gif" width="44" height="33" border="1" class="imggal" align="absmiddle" style="margin-right:5px;"></td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_105"><?=$filter['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><? if($filter['default'] != '1'){ ?><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"></a><? } ?></td>
			<td height="34" width="20"><? if($filter['default'] != '1'){ ?><a href="javascript:" title="Удалить опцию"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteFilterOption('<?=$filter['id']?>')"></a><? } ?></td>
		</tr></table>
	</div>
</div>
<? }}} ?>
</div>

<!--  ------------------------------------------------------------- -->
</div>


		<div class="manageadminforms" id="lookContent" style="display:none;">
		  А вот сюда загрузится модуль редактирования папки
		</div>
		<div class="manageadminforms" id="help_content" style="display:none;">
		  Справка будет тут
		</div>
		
	  <div id="nztime"></div>
<? //echo "<pre>"; print_r($options); echo "</pre>"; ?>
<script>
//******************************
var tables = new Array();
var tablesNames = new Array();
<? if(is_array($options)){ foreach($options as $key=>$option){
	echo "tables[$key] = '$option[link]';\n";
	echo "tablesNames[$key] = '$option[name]';\n";
} } ?>
//alert(tables);
//******************************
function addFilterClass(){
	__css_itemShowCSS({"width":300,"height":250});
	document.getElementById("show_cssblock_close").onclick = function(){
		document.getElementById("show_cssblock_bg").style.display = "none";
		document.getElementById("show_cssblock_cont").style.display = "none";
		document.getElementById("show_cssblock_cont").innerHTML = "";
		document.getElementById("show_cssblock_close").style.display = "none";
		return false;
	}
	obj_m = document.getElementById("show_cssblock_bg").onclick = function(){
		document.getElementById("show_cssblock_bg").style.display = "none";
		document.getElementById("show_cssblock_cont").style.display = "none";
		document.getElementById("show_cssblock_cont").innerHTML = "";
		document.getElementById("show_cssblock_close").style.display = "none";
		return false;
	}
	var inner = "<h2>Добавление шаблона</h2>";
	inner += "<input type=\"text\" id=\"newFilterName\" style=\"width:100%;margin-bottom:10px;\" ";
	inner += "onkeyup=\"this.style.backgroundColor=''\" placeholder=\"Название шаблона\" value=\"test\" >";
	inner += "<select id=\"typeSelector\" onchange=\"isExternal(this);this.style.backgroundColor=''\" style=\"width:100%;margin-bottom:10px;\">";
	inner += "		<option value=\"1\">Таблица</option>";
	inner += "		<option value=\"2\">Внешний источник</option>";
	inner += "</select>";
	inner += "<select id=\"tableSelector\" onchange=\"this.style.backgroundColor=''\" style=\"width:100%;margin-bottom:10px;\">";
	inner += "<option value='0'>-Выберите таблицу-</option>";
	if(tables.length>0 && tablesNames.length>0){
		for(var j=0; j<tables.length; j++){
			inner += "<option value='"+tables[j]+"'>"+tablesNames[j]+" ("+tables[j]+")"+"</option>";
		}
	}
	inner += "</select>";
	inner += "<div id=\"div_chIsPrice\"><input type=\"checkbox\" id=\"chIsPrice\" checked > Поле цены</div>";
	inner += "<div id=\"div_chIsContent\"><input type=\"checkbox\" id=\"chIsContent\" checked > Поле описания</div>";
	inner += "<div id=\"div_chIsImages\"><input type=\"checkbox\" id=\"chIsImages\" checked > Поле изображений</div>";
	inner += "<div align=\"center\" style=\"margin-top:10px;\" id=\"sendButtons\">";
	inner += "<button onclick=\"addFilterClassAjax()\">Добавить шаблон</button>&nbsp;&nbsp;";
	inner += "<button onclick=\"document.getElementById('show_cssblock_close').onclick()\">Отмена</button>";
	inner += "</div>";
	document.getElementById("show_cssblock_cont").innerHTML = inner;
	return false;
}
//******************************
function addFilterClassAjax(){
	if(document.getElementById("typeSelector").value=='2'){
		alert("Извините, программа не дописана");
		return false;
	}
	var oTable = document.getElementById("newFilterName");
	var foo = false;
	if(oTable.value==''){
		oTable.style.backgroundColor = "#FFD7D7";
		foo = true;
	}else{
		oTable.style.backgroundColor = "#E7FFD7";
	}
	var oSelect = document.getElementById("tableSelector");
	if(oSelect.value=='0'){
		oSelect.style.backgroundColor = "#FFD7D7";
		foo = true;
	}else{
		oSelect.style.backgroundColor = "#E7FFD7";
	}
	if(foo){
		return false;
	}
	var paction =  "ajax=addFilterClass&parent=0&table="+oSelect.value+"&name="+encodeURIComponent(oTable.value);
	if(document.getElementById("chIsPrice").checked){
		paction += "&isPrice=1";
	}
	if(document.getElementById("chIsContent").checked){
		paction += "&isContent=1";
	}
	if(document.getElementById("chIsImages").checked){
		paction += "&isImages=1";
	}
	document.getElementById("show_cssblock_close").onclick();
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			getPage('<?=$url['0']?>/<?=$url['1']?>/');
			getLeftBranch('filters');
		}
	});
}
//******************************
function addFilterOption(){
	paction =  "ajax=addFilterOption&parent=<?=$filterParent['id']?>";
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			getPage('<?=$url['0']?>/<?=$url['1']?>/');
		}
	});
}
//******************************
function deleteFilterFolder(folderId){
	if(confirm("Желаете удалить этот фильтр")){
		paction =  "ajax=deleteFilterFolder&folderId="+folderId;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				getPage(window.location.pathname);
			}
		});
	}
}
//******************************
function deleteFilterOption(id){
	if(confirm("Желаете удалить выбранную опцию?")){
		paction =  "ajax=deleteFilterOption&id="+id;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				getPage(window.location.pathname);
			}
		});
	}
}
//******************************
function isExternal(obj){
	//alert(obj.parentNode.id);
	if(obj.value=='2'){
		obj.parentNode.style.height = "150px";
		document.getElementById("tableSelector").style.display = "none";
		document.getElementById("div_chIsPrice").style.display = "none";
		document.getElementById("div_chIsContent").style.display = "none";
		document.getElementById("div_chIsImages").style.display = "none";
	}else{
		obj.parentNode.style.height = "250px";
		document.getElementById("tableSelector").style.display = "";
		document.getElementById("div_chIsPrice").style.display = "";
		document.getElementById("div_chIsContent").style.display = "";
		document.getElementById("div_chIsImages").style.display = "";
	}
}
//******************************
function cloneTemplate(id){
	if(confirm("Желаете клонировать выбранный шаблон?")){
		paction =  "ajax=cloneTemplate&id="+id;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				alert(html);
				getPage(window.location.pathname);
			}
		});
	}
}
//******************************
</script>