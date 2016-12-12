		<div class="admintitle" style="padding:0px; margin:0px;" >
		<? if(count($url)=='1'){ ?>
		<a onclick="addNewPage()" href="javascript:" id="add_item_to_cat_button">Добавить страницу</a>
		<a href="javascript:show_ritems('help');" id="outerhelp">?</a>
		<? }else{ ?>
		<a onclick="addFilterOption()" href="javascript:" id="add_item_to_cat_button">Добавить опцию</a>
		<a onclick="getPage('/adminarea/filters/editfilter/<?=$filterParent['id']?>/')"
		href="javascript:" id="edit_folder_cat_button">Свойства фильтра</a>
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
			<h1 id="folders_title">Текстовые страницы <? if(count($url)>='2'){ ?>
			-› <?=$filterParent['name']?>
			<? } ?></h1>
			<div id="folders_count_items">Элементов: <?=count($pages)?></div>
			<div id="all_show_items" style="margin-top:20px;"></div>
		</div>


<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($pages); echo "</pre>"; ?>
<? if(is_array($pages)){ foreach($pages as $page){
if($page['folder']=='1') {
 ?>
	<div class="ui-state-default-2 connectedSortable" id="prm_<?=$page['link']?>">
	<div id="div_myitemname_1" class="div_myitemname" style="padding-top: 0px;">
		<table id="folder_1" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_1" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(1)"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show(1)" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_1" width="16" height="16" border="0"></a></td>
			<td height="34" width="20"><img src="/adminarea/template/images/itemFolder.jpg" width="44" height="33" border="1" class="imggal" align="absmiddle" style="margin-right:5px;"></td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_1"><?=$filter['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="getPage('/adminarea/<?=$url['0']?>/editfilter/<?=$filter['id']?>/')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="delete_item('1')"></a></td>
		</tr></table>
	</div>
</div>
<? }else{ ?>
<div class="ui-state-default-2 connectedSortable" id="prm_<?=$page['link']?>">
	<div id="div_myitemname_1" class="div_myitemname" style="padding-top: 0px;">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_105" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(105)"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show(105)" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_105" width="16" height="16" border="0"></a></td>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/no_img.gif" width="44" height="33" border="1" class="imggal" align="absmiddle" style="margin-right:5px;"></td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_105"><?=$page['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<td height="34" width="20"><a href="javascript:" title="Клонировать запись"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deletePage('<?=$page['id']?>')"></a></td>
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

<script>
//******************************
function addFilterClass(){
	paction =  "ajax=addFilterClass&parent=<?=$filterParent['id']?>";
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			alert(html);
			//getPage('<?=$url['0']?>/<?=$url['1']?>/');
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
function saveFiltersPrior(){
	var priors = $('#myitems_sortable').sortable('toArray');
	//alert(priors);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "ajax=saveFiltersPrior&parent=<?=$filterParent['id']?>&ids="+priors,
		success: function(html) {
			//alert(html);
		}
	});
}
//******************************
function addNewPage(){
	paction =  "ajax=addNewPage";
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			getPage('pages');
		}
	});
}
//******************************
function deletePage(pageId){
	paction =  "ajax=addNewPage";
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//getPage('pages');
		}
	});
}
//******************************

//******************************
</script>