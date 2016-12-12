<?
//print_r($parents);
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
		<? if($addNotice){ ?><a href="javascript:getPage('catalog/<?=$folder['fullLink']?>?action=editItem,parent=<?=$folder['id']?>')" id="add_item_to_cat_button"
		style="width:85px;">Добавить объект</a><? } ?>
		<? if($addFolder){ ?><a href="javascript:getPage('false', 'action', 'addNewFolder')"
		id="add_folder_to_cat_button">Добавить группу</a><? } ?>
		<? if(count($parents)>0 && !is_array($params)){ ?><a href="javascript:" id="edit_folder_cat_button"
		onclick="getPage('/adminarea/catalog/<?=$folder['fullLink']?>?action=editFolder,folderId=<?=$parents[count($parents)-1]['id']?>/')">Свойства группы</a><? } ?>
		<? if(count($parents)>0){ ?><a 
		onclick="deleteOptionFolder('<?=$loadPage?>', '<?=$parentNotice['id']?>', '<?=str_replace("'", "\\'", $parentNotice['name'])?>', 'back')"
		href="javascript:" id="deletefolderbutton">Удалить группу</a><? } ?>
		<a href="javascript:showHelp('addobject');" id="outerhelp">?</a>
		<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	    <?  //echo $__page_title; ?>
		</div>
		<div style="float:none; clear:both;"></div>
		<div class="manageadminforms" id="edit_content" style="display:;">
		  
<? //echo "<pre>"; print_r($folder); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($params); echo "</pre>"; ?>
<!--  ------------------------------------------------------------- -->
<div class="folders_all"><? if($params['action']=='addNewFolder'){ ?><b>Добавление группы</b><?
}elseif($params['action']=='editFolder'){ ?><b>Редактирование группы</b><?
}elseif($params['action']=='addNewItem'){ ?><b>Добавление объекта</b><?
}else{ ?>Просмотр группы<? } ?>
			<h1 id="folders_title">Каталог <? if(count($url)>='2'){ ?>
			<? foreach($parents as $key=>$parentItem){
				if($params['action']!='editFolder'){
					echo " -› $parentItem[name]";
				}elseif($params['action']=='editFolder' && $key!=count($parents)-1){
					echo " -› $parentItem[name]";
				}elseif($params['action']=='editFolder' && $key==count($parents)-1){
					echo " -› ";
				}
			}} if($params['action']=='addNewFolder'){ echo " -› "; } ?></h1>
			<? if(!$params['action']) { ?><div id="folders_count_items">Элементов: <?=count($items)?></div><? } ?>
			<div id="all_show_items" style="margin-top:20px;"></div>
		</div>
<script>
	var defaultFolderTitle = document.getElementById("folders_title").innerHTML;
	<? if($params['action']=='editFolder'){ ?>
	document.getElementById("folders_title").innerHTML += "<font style=\"color:#CCCCCC;\"><?=$parents[count($parents)-1]['name']?></font>";
	<? } ?>
	globalEdit = false;
</script>



<? //**********************  ДОБАВЛЕНИЕ ГРУППЫ
if($params['action']=='addNewFolder') {
//echo "<pre>"; print_r($filters); echo "</pre>";
//echo "<pre>"; print_r($GLOBALS); echo "</pre>";
if(count($GLOBALS['languages'])>1){ ?>
<div class="languagesTabs" style="padding-bottom:10px;font-weight:bold;color:#990000;">
Переключение языков станет доступным после сохранения группы</div>
<div style="background-color:#A9C9A7; padding:15px;"><?
//echo "<pre>"; print_r($fields); echo "</pre>";
foreach($fields as $fileld){
	switch($fileld['0']){
		case 'name': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Название</td>
				<td><input type="text" id="name" style="width:100%"
				<? if($GLOBALS['language']==$params['lang'] || $params['lang']==''){
				?>onkeyup="addNameToTitle();globalEdit=true;" onchange="addNameToTitle();globalEdit=true;"<? }else{ ?>
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"
				<? } ?> /></td>
			</tr></table>
			<? break;
		case 'parent': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Родитель</td>
				<td><?=$parents[count($parents)-1]['name']?></td>
			</tr></table>
			<? break;
		case 'link': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">HTML-путь</td>
				<td><input type="text" id="link" style="width:100%" onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? break;
		case 'content': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Описание</td>
				<td><textarea id="content" style="width:100%; height:300px;"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"></textarea></td>
			</tr></table>
			<? break;
		case 'visible': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Отображение в сайте</td>
				<td><input type="checkbox" id="visible" checked="checked" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? break;
		case 'letters': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Символьный	код</td>
				<td><input type="text" id="letters" onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? break;
	}
}
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">Используемый шаблон</td>
	<td><select id="currentTemplate" onkeyup="globalEdit=true;" onchange="globalEdit=true;">
	<option value="0">-Выберите шаблон-</option><?
	if(is_array($filters)){ foreach($filters as $filter){
		echo "<option value=\"filter[id]\">$filter[name]</option>";
	} } ?></select></td>
</tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">&nbsp;</td>
	<td><button onclick="saveNewCatalogFolder()">Сохранить</button>  <button onclick="getPage(window.location.pathname)">Отменить</button></td>
</tr></table></div>
<script>
function saveNewCatalogFolder(){
	var paction = "ajax=saveNewCatalogFolder";
	paction += "&name="+encodeURIComponent(document.getElementById("name").value);
	paction += "&parent=<?=$parents[count($parents)-1]['id']?>";
	paction += "&content="+encodeURIComponent(document.getElementById("content").value);
	paction += "&visible=1";
	paction += "&link="+document.getElementById("link").value;
	paction += "&filter="+document.getElementById("currentTemplate").value;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			globalEdit=false;
			getPage(window.location.pathname);
			//__css_itemShowCSS();
			var obj = document.getElementById("show_cssblock_cont");
			$(obj).empty();
			$(obj).append(html);
			
		}
	});
}
//*********************************************************
function addNameToTitle(){
	var nameValue = document.getElementById("name").value;
	var inner = defaultFolderTitle + "<font style=\"color:#CCCCCC;\">" + nameValue + "</font>";
	document.getElementById("folders_title").innerHTML = inner;
	var paction = "ajax=transliteral&value="+encodeURIComponent(nameValue);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			document.getElementById("link").value = html;
		}
	});
}
</script>
<? } ?>
<? //**********************  //ДОБАВЛЕНИЕ ГРУППЫ 



}elseif($params['action']=='editFolder') { //**********************  РЕДАКТИРОВАНИЕ ГРУППЫ
//echo "<pre>"; print_r($filters); echo "</pre>";
//echo "<pre>"; print_r($GLOBALS); echo "</pre>";
if(count($GLOBALS['languages'])>1){ ?>
<div class="languagesTabs"><? foreach($GLOBALS['languages'] as $key=>$lang){ ?>
	<span <?
	if((!$params['lang'] && $key==$GLOBALS['language']) || $params['lang']==$key){
		echo "class=\"active\"";
	}else{?>onclick="getPage(window.location.pathname+'<?=$paramsString?>', 'lang', '<?=$key?>')"<? } ?> ><?=$lang['0']?></span>
<? } ?></div><div style="float:none;clear:both;"></div>
<div style="background-color:#A9C9A7; padding:15px;"><?
//echo "<pre>"; print_r($folder); echo "</pre>";
//echo "<pre>"; print_r($fields); echo "</pre>";
if($params['lang']!='' && $params['lang']!=$GLOBALS['language']){
	$langPrefix = "_".$params['lang'];
}
if(is_array($fields)){ foreach($fields as $fileld){
	switch($fileld['0']){
		case 'name': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Название</td>
				<td><input type="text" id="name" style="width:100%" value="<?=$folder['name'.$langPrefix]?>"
				<? if($GLOBALS['language']==$params['lang'] || $params['lang']==''){
				?>onkeyup="addNameToTitle();globalEdit=true;" onchange="addNameToTitle();globalEdit=true;"<? }else{ ?>
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"
				<? } ?> /></td>
			</tr></table>
			<? break;
		case 'mini': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Мининазвание</td>
				<td><input type="text" id="mini" style="width:100%" value="<?=$folder['mini'.$langPrefix]?>"
				<? if($GLOBALS['language']==$params['lang'] || $params['lang']==''){
				?>onkeyup="addNameToTitle();globalEdit=true;" onchange="addNameToTitle();globalEdit=true;"<? }else{ ?>
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"
				<? } ?> /></td>
			</tr></table>
			<? break;
		case 'parent': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Родитель</td>
				<td><?=$parents[count($parents)-1]['name']?></td>
			</tr></table>
			<? break;
		case 'link': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">HTML-путь</td>
				<td><input type="text" id="link" style="width:100%" value="<?=$folder['link']?>"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? break;
		case 'content': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Описание</td>
				<td><textarea id="content" style="width:100%; height:300px;"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"><?=$folder['content'.$langPrefix]?></textarea></td>
			</tr></table>
			<? break;
		case 'visible': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Отображение в сайте</td>
				<td><input type="checkbox" id="visible" onchange="globalEdit=true;" <? if($folder['visible']=='1'){
					echo "checked";
				} ?> /></td>
			</tr></table>
			<? break;
		case 'letters': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Символьный	код</td>
				<td><input type="text" id="letters" value="<?=$folder['letters']?>"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? break;
	}
} }
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">Используемый шаблон</td>
	<td><select id="currentTemplate" onkeyup="globalEdit=true;" onchange="globalEdit=true;">
	<option value="0">-Выберите шаблон-</option><?
	if(is_array($filters)){ foreach($filters as $filter){
		echo "<option value=\"$filter[id]\" ";
		if($folder['filter']==$filter['id']){ echo "selected"; }
		echo " >$filter[name]</option>";
	} } ?></select></td>
</tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">&nbsp;</td>
	<td><button onclick="saveCatalogFolder()">Сохранить</button>  <button onclick="getPage(window.location.pathname)">Отменить</button></td>
</tr></table></div>
<? if($parents[count($parents)-2]['id']){
	$myParent = $parents[count($parents)-2]['id'];
}else{
	$myParent = '0';
} ?>
<script>
function saveCatalogFolder(){
	var paction = "ajax=saveCatalogFolder";
	paction += "&id=<?=$folder['id']?>";
	paction += "&lang=<?=$langPrefix?>";
	paction += "&name="+encodeURIComponent(document.getElementById("name").value);
	paction += "&mini="+encodeURIComponent(document.getElementById("mini").value);
	paction += "&parent=<?=$myParent?>";
	paction += "&content="+encodeURIComponent(document.getElementById("content").value);
	paction += "&visible=1";
	paction += "&link="+document.getElementById("link").value;
	paction += "&filter="+document.getElementById("currentTemplate").value;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			globalEdit=false;
			getPage(window.location.pathname);
			//__css_itemShowCSS();
			var obj = document.getElementById("show_cssblock_cont");
			$(obj).empty();
			$(obj).append(html);
			
		}
	});
}
//*********************************************************
function addNameToTitle(){
	var nameValue = document.getElementById("name").value;
	var inner = defaultFolderTitle + "<font style=\"color:#CCCCCC;\">" + nameValue + "</font>";
	document.getElementById("folders_title").innerHTML = inner;
}
</script>
<? } ?>
<?  //**********************  //РЕДАКТИРОВАНИЕ ГРУППЫ


}elseif($params['action']=='editItem') {
//**********************  ДОБАВЛЕНИЕ/РЕДАКТИРОВАНИЕ ОБЪЕКТА
//echo "<pre>"; print_r($item); echo "</pre>";
//echo "<pre>"; print_r($filters); echo "</pre>";
//echo "<pre>"; print_r($fields); echo "</pre>";
if(count($GLOBALS['languages'])>1){ ?>
<div class="languagesTabs"><? foreach($GLOBALS['languages'] as $key=>$lang){ ?>
	<span <?
	if((!$params['lang'] && $key==$GLOBALS['language']) || $params['lang']==$key){
		echo "class=\"active\"";
	}else{?>onclick="getPage(window.location.pathname+'<?=$paramsString?>', 'lang', '<?=$key?>')"<? } ?> ><?=$lang['0']?></span>
<? } ?></div><div style="float:none;clear:both;"></div>
<div style="background-color:#A9C9A7; padding:15px;"><?
//echo "<pre>"; print_r($folder); echo "</pre>";
//echo "<pre>"; print_r($fields); echo "</pre>";
if($params['lang']!='' && $params['lang']!=$GLOBALS['language']){
	$langPrefix = "_".$params['lang'];
}
if(is_array($fields)){ foreach($fields as $fileld){ if($fileld['default']=='1'){
//echo "<pre>"; print_r($field); echo "</pre>";
	switch($fileld['config']['fieldname']){
		case 'name': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30"><?=$fileld["name$langPrefix"]?></td>
				<td><input type="text" id="name" style="width:100%" value="<?=$item['name'.$langPrefix]?>"
				<? if($GLOBALS['language']==$params['lang'] || $params['lang']==''){
				?>onkeyup="addNameToTitle();globalEdit=true;" onchange="addNameToTitle();globalEdit=true;"<? }else{ ?>
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"
				<? } ?> /></td>
			</tr></table>
			<? break;
		case 'parent': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Родитель</td>
				<td><?=$parents[count($parents)-1]['name']?></td>
			</tr></table>
			<? break;
		case 'link': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">HTML-путь</td>
				<td><input type="text" id="link" style="width:100%" value="<?=$item['link']?>"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? break;
		case 'content': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Описание</td>
				<td><textarea id="content" style="width:100%; height:300px;"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"><?=$item['content'.$langPrefix]?></textarea></td>
			</tr></table>
			<? break;
		case 'visible': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Отображение в сайте</td>
				<td><input type="checkbox" id="visible" onchange="globalEdit=true;" <? if($item['visible']=='1'){
					echo "checked";
				} ?> /></td>
			</tr></table>
			<? break;
		case 'letters': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Символьный	код</td>
				<td><input type="text" id="letters" value="<?=$item['letters']?>"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? break;
		case 'mini': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Краткое описание</td>
				<td><input type="text" id="mini" value="<?=$item['mini'.$langPrefix]?>" style="width:100%;"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? break;
		case 'images': $initImages=true; ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Изображения</td>
				<td><div id="file-uploader">
						<div class="qq-uploader">
						  <div class="qq-upload-drop-area" style="display: none;"> <span>Перетащите файлы на этот блок</span> </div>
						  <div class="qq-upload-button" style="position: relative; overflow: hidden; direction: ltr;"> Загрузить изображения
							<input multiple="multiple" type="file" value="" name="file" style="position: absolute; right: 0px; 
										top: 0px; z-index: 1; font-size: 460px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;" />
						  </div>
						  <ul class="qq-upload-list" style="display:none;">
						  </ul>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td height="30">&nbsp;</td>
				<td><ul id="usercabinetprofile">
						<?
						//echo "<pre>"; print_r($item['images']); echo "</pre>";
						if(is_array($item['images'])){
							foreach($item['images'] as $image){
								echo "<li id=\"imgId_$image[id]\"><img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
								echo "resize_x=100&resize_y=100&link=loadimages/".$image['name']."\" width=\"100\" height=\"100\" class=\"loadimg\" />";
								echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteImage('".$image['id']."')\" ";
								echo "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
								echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"imageToText('".$image['name']."')\" ";
								echo "style=\"text-decoration:none;\"><font color=red><b>T</b></font></a>";
								echo "</li>";
							}
						}
						?>
					</ul></td>
			  </tr>
			</table>
			<? break;
		case 'price': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Стоимость</td>
				<td><input type="number" id="price" onkeyup="globalEdit=true;" onchange="globalEdit=true;" value="<?=$item['price']?>" /></td>
			</tr></table>
			<? break;
	}
} } }
//*********************************************
//echo "<pre>"; print_r($fields); echo "</pre>";
if(is_array($fields)){ foreach($fields as $field){ if($field['default']=='0'){ ?>
<? //echo "<pre>"; print_r($field); echo "</pre>"; ?>
<? if($field['config']['filtertype']=='8'){ $has=false; ?>
<? //echo "<pre>"; print_r($field); echo "</pre>"; ?>
<? //echo "test<pre>"; print_r($oldValue); echo "</pre>"; ?>
<? //$oldValue[$field['config']['externalSettings']['option']][] = $item[$field['link']]; ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="externalTable_<?=$field['id']?>"
<? if(count($oldValue[$field['config']['externalSettings']['option']])>0){ ?>style="display:none"<? } ?>><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td><select id="<?=$field['link']?>"
	value="<?=$item[$field['link']]?>" onchange="saveCatalogItem(true);"><option value="0"></option><? foreach($field['config']['externals'] as $selItem){ ?>
		<option value="<?=$selItem['id']?>" <? if($selItem['id']==$item[$field['link']]){ $has=true; ?>selected<? } ?> ><?=$selItem["name$langPrefix"]?></option>
	<? } if(!$has){ $oldValue[$field['config']['externalSettings']['option']][]='0'; } ?></select></td>
</tr></table>
<? }elseif($field['config']['filtertype']=='7'){ ?>
<? //echo "<pre>"; print_r($field); echo "</pre>"; ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td><select id="<?=$field['link']?>"
	value="<?=$item[$field['link']]?>"><option value="0"></option><? foreach($field['config']['items'] as $selItem){ ?>
		<option value="<?=$selItem['id']?>" <? if($selItem['id']==$item[$field['link']]){ ?>selected<? } ?> ><?=$selItem["name$langPrefix"]?></option>
	<? } ?></select></td>
</tr></table>
<? }elseif($field['config']['filtertype']=='9'){ ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td><input type="text" id="<?=$field['link']?>"  value="<?=$item[$field['link'].$langPrefix]?>" /></td>
</tr></table>
<? }elseif($field['config']['filtertype']=='4'){ ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td><input type="checkbox" id="<?=$field['link']?>" <? if($item[$field['link']]=='1'){ echo "checked"; } ?> /></td>
</tr></table>
<? }else{ ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td><input type="<? if($field['config']['datatype']=='1' || $field['config']['datatype']=='2'){ ?>number<? }else{ ?>text<? } ?>" id="<?=$field['link']?>"
	value="<?=$item[$field['link']]?>" onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
</tr></table>
<? } ?>
<? }}} ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">&nbsp;</td>
	<td><button onclick="saveCatalogItem()">Сохранить</button>  <button onclick="getPage(window.location.pathname)">Отменить</button></td>
</tr></table></div>
<? if($parents[count($parents)-2]['id']){
	$myParent = $parents[count($parents)-2]['id'];
}else{
	$myParent = '0';
} ?>
<script>
var currentItem = <?=json_encode($item)?>;
//alert(JSON.stringify(currentItem));
function saveCatalogItem(aReload){
	if(aReload){ itemReload=true; }
	var paction = "ajax=saveCatalogItem";
	paction += "&itemId=<?=$item['id']?>"
	paction += "&lang=<?=$langPrefix?>";
	//alert(JSON.stringify(currentItem));
	for(var jj in currentItem){
		//alert(jj);
		if(document.getElementById(jj)){
			var obj = document.getElementById(jj);
			if(obj.tagName.toLowerCase()=='input'){
				if(obj.getAttribute('type')=='checkbox'){
					//alert("checkbox "+obj.id);
					if(obj.checked){
						paction += "&"+jj+"=1";
					}else{
						paction += "&"+jj+"=0";
					}
				}else if(obj.getAttribute('type')=='text'){
					paction += "&"+jj+"="+encodeURIComponent(document.getElementById(jj).value);
				}else if(obj.getAttribute('type')=='number'){
					paction += "&"+jj+"="+document.getElementById(jj).value;
				}
				//if(obj.)
			}else if(obj.tagName.toLowerCase()=='select'){
				paction += "&"+jj+"="+document.getElementById(jj).value;
			}else if(obj.tagName.toLowerCase()=='textarea'){
				//alert(tiny_init);
				if(tiny_init){
					paction += "&"+jj+"="+encodeURIComponent(tinyMCE.get(jj).getContent());
					tinyMCE.execCommand('mceToggleEditor',false,jj);
					tinyMCE.execCommand('mceRemoveControl',true,jj);
					tiny_init = false;
					paction += "&"+jj+"="+encodeURIComponent(document.getElementById(jj).value);
				}else{
					paction += "&"+jj+"="+encodeURIComponent(document.getElementById(jj).value);
				}
			}
		}
	}
	//alert(paction);
	//return false;
	//paction += "&id=<?=$folder['id']?>"
	//paction += "&name="+encodeURIComponent(document.getElementById("name").value);
	//paction += "&parent=<?=$myParent?>";
	//paction += "&content="+encodeURIComponent(document.getElementById("content").value);
	//paction += "&visible=1";
	//paction += "&link="+document.getElementById("link").value;
	//paction += "&filter="+document.getElementById("currentTemplate").value;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			globalEdit=false;
			if(itemReload){
				//alert(oldParamsURL);
				getPage(window.location.pathname+oldParamsURL);
				//itemReload = false;
			}else{
				getPage(window.location.pathname);
			}
			//__css_itemShowCSS();
			//var obj = document.getElementById("show_cssblock_cont");
			//$(obj).empty();
			//$(obj).append(html);
			
		}
	});
}
//*********************************************************
function addNameToTitle(){
	if(currentItem.tmp=='1'){
		var nameValue = document.getElementById("name").value;
		var paction = "ajax=transliteral&value="+encodeURIComponent(nameValue);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				document.getElementById("link").value = html;
			}
		});
	}
}
//*********************************************************
function insertImgModule(fileId){
    //alert(fileId);
	var id = fileId;
    id = id.split(".")[0];
	var innerObj = document.getElementById("usercabinetprofile");
	var inner = "<li><img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
	inner += "resize_x=100&resize_y=100&link=loadimages/"+fileId+"\" width=\"100\" height=\"100\" class=\"loadimg\" />";
	inner += "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteProfileImg('"+fileId+"')\" ";
	inner += "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
	inner += "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"imageToText('"+fileId+"')\" ";
	inner += "style=\"text-decoration:none;\"><font color=red><b>T</b></font></a>";
	inner += "</li>";
	innerObj.innerHTML += inner;    
}
//*********************************************************
function deleteImage(imageId){
	if(confirm("Удалить изображение?")){
		var paction =  "ajax=deleteImage";
		paction += "&imageId="+imageId;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				var data = eval("("+html+")");
				if(data.return=='ok'){
					var obj = document.getElementById("imgId_"+data.imgid);
					if(obj){
						obj.parentNode.removeChild(obj);
					}
				}else{
					alert("Ошибка редактирования");
				}
			}
		});
	}
}
//*********************************************************
currentCatalogItemId = '<?=$item['id']?>';
tinymce_init();
<? if($initImages){ ?>startFileUploader();<? } ?>
</script>
<? } ?>
<?  //**********************  //ДОБАВЛЕНИЕ/РЕДАКТИРОВАНИЕ ОБЪЕКТА



}else{ //**********************  ПРОСМОТР ГРУППЫ ?>
<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($items); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? if(is_array($items)){ foreach($items as $item){
if($item['folder']=='1') {
 ?>
	<div class="ui-state-default-2 connectedSortable" id="prm_<?=$item['link']?>">
	<div id="div_myitemname_1" class="div_myitemname" style="padding-top: 0px;">
		<table id="folder_1" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_1" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(1)"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show(1)" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_1" width="16" height="16" border="0"></a></td>
			<td height="34" width="20"><img src="/adminarea/template/images/itemFolder.jpg" width="44" height="33" border="1" class="imggal" align="absmiddle" style="margin-right:5px;"></td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_1"><?=$item['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="getPage('catalog/<?=$item['fullLink']?>?action=editFolder,folderId=<?=$item['id']?>')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteOptionFolder('<?=$loadPage?>', '<?=$item['id']?>', '<?=str_replace("'", "\\'", $item['name'])?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }else{ ?>
<div class="ui-state-default-2 connectedSortable"
id="prm_?action=editItem,parent=<?=$item['parent']?>,itemId=<?=$item['id']?>">
	<div id="div_myitemname_1" class="div_myitemname" style="padding-top: 0px;<? if($item['tmp']=='1'){ 
	?>background-color:#CCCCCC;<? } ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_<?=$item['id']?>" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check('<?=$item['id']?>')"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show('<?=$item['id']?>')" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_<?=$item['id']?>" width="16" height="16" border="0"></a></td>
			<td height="34" width="20">
			<? if($item['tumb']){ ?>
			<img src="/imgres.php?link=loadimages/<?=$item['tumb']['0']['name']?>&resize=44" width="44" height="33"
			border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
			<? }else{ ?>
			<img src="/adminarea/template/images/green/myitemname_popup/no_img.gif" width="44" height="33"
			border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
			<? } ?>
			</td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_<?=$item['id']?>"><?=$item['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<!--<td height="34" width="20"><a href="javascript:" title="Клонировать запись"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>-->
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_<?=$item['id']?>');hide_idc('<?=$item['id']?>')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteObjectFromCatalog('<?=$item['id']?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }}} ?>
</div>
<script>
function deleteObjectFromCatalog(objId){
	var delName = document.getElementById('span_myitemname_'+objId).innerHTML;
	if(confirm("Удалить объект\n«"+delName+"»?")){
		var paction =  "ajax=deleteObjectFromCatalog";
		paction += "&id="+objId;
		paction += "&option=catalog";
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
</script>
<? } //**********************  //ПРОСМОТР ГРУППЫ ?>
<!--  ------------------------------------------------------------- -->
		  
		  
		</div>
		<div class="manageadminforms" id="lookContent" style="display:none;">
		  А вот сюда загрузится модуль редактирования папки
		</div>
		<div class="manageadminforms" id="help_content" style="display:none;">
		  Справка будет тут
		</div>
		
	  <div id="nztime"></div>

