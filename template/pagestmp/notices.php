<?
$addNotice = true;
$addFolder = true;
if(is_array($notices)){
	foreach($notices as $notice){
		if($notice['folder']=='1'){
			$addNotice = false;
		}elseif($notice['folder']=='0'){
			$addFolder = false;
		}
	}
}
?>
		<div class="admintitle" style="padding:0px; margin:0px;" >
		<? if($addNotice){ ?><a href="javascript:addItemToCatalog(0)" id="add_item_to_cat_button"
		style="width:85px;">Добавить объявление</a><? } ?>
		<? if($addFolder){ ?><a href="javascript:addNoticeFolder('<?=$parentNotice['id']?>')"
		id="add_folder_to_cat_button">Добавить группу</a><? } ?>
		<? if($parentNotice){ ?><a href="javascript:" id="edit_folder_cat_button"
		onclick="getPage('/adminarea/notices/<?=$parentNotice['href']?>editFolder/<?=$parentNotice['id']?>/')">Свойства группы</a><? } ?>
		<? if($parentNotice){ ?><a 
		onclick="deleteOptionFolder('<?=$loadPage?>', '<?=$parentNotice['id']?>', '<?=str_replace("'", "\\'", $parentNotice['name'])?>', 'back')"
		href="javascript:" id="deletefolderbutton">Удалить группу</a><? } ?>
		<a href="javascript:show_ritems('help');" id="outerhelp">?</a>
		<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	    <?  //echo $__page_title; ?>
		</div>
		<div style="float:none; clear:both;"></div>
		<div class="manageadminforms" id="edit_content" style="display:;">
		  
<? //echo "<pre>"; print_r($notices); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<!--  ------------------------------------------------------------- -->
<div class="folders_all">Просмотр группы
			<h1 id="folders_title">Объявления <? if(count($url)>='2'){ ?>
			<? foreach($url as $key=>$value){
				if($key>0){
					echo " -› $value";
				}
			}} ?></h1>
			<div id="folders_count_items">Элементов: <?=count($notices)?></div>
			<div id="folders_count_items" style="padding-top:10px;"><input type="checkbox" onchange="changeShowTemp(this)" style="float:left;"
			<? if($GLOBALS['showTempNotice']=="Да"){ echo "checked"; } ?> />Отображать временные объявления</div>
			<div id="all_show_items" style="margin-top:20px;"></div>
		</div>


<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($notices); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? if(is_array($notices)){ foreach($notices as $notice){
if($notice['folder']=='1') {
 ?>
	<div class="ui-state-default-2 connectedSortable" id="prm_<?=$notice['link']?>">
	<div id="div_myitemname_1" class="div_myitemname" style="padding-top: 0px;">
		<table id="folder_1" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_1" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(1)"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show(1)" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_1" width="16" height="16" border="0"></a></td>
			<td height="34" width="20"><img src="/adminarea/template/images/itemFolder.jpg" width="44" height="33" border="1" class="imggal" align="absmiddle" style="margin-right:5px;"></td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_1"><?=$notice['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="getPage('/adminarea/notices/<?=$notice['href']?>editFolder/<?=$notice['id']?>/')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteOptionFolder('<?=$loadPage?>', '<?=$notice['id']?>', '<?=str_replace("'", "\\'", $notice['name'])?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }else{ ?>
<div class="ui-state-default-2 connectedSortable" id="prm_editItem/<?=$notice['link']?>">
	<div id="div_myitemname_1" class="div_myitemname" style="padding-top: 0px;<? if($notice['tmp']=='1'){ 
	?>background-color:#CCCCCC;<? } ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_105" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(105)"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show(105)" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_105" width="16" height="16" border="0"></a></td>
			<td height="34" width="20">
			<? if($notice['tumb']){ ?>
			<img src="/imgres.php?link=loadimages/<?=$notice['tumb']['0']['name']?>&resize=44" width="44" height="33"
			border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
			<? }else{ ?>
			<img src="/adminarea/template/images/green/myitemname_popup/no_img.gif" width="44" height="33"
			border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
			<? } ?>
			</td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_105"><?=$notice['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<? if(count($notice['comments'])>0){ ?>
			<td height="34" width="20"><a href="javascript:" title="Комментарии"><img src="/adminarea/template/images/green/myitemname_popup/comments.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="getPage('noticeComments/<?=$notice['id']?>/')"></a></td><? } ?>
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteNotice('<?=$notice['id']?>')"></a></td>
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

