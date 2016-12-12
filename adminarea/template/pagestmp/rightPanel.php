<?
//echo "<pre>"; print_r($item); echo "</pre>";
//echo "<pre>"; print_r($parents); echo "</pre>";
$addNotice = false;
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
if(count($url)>count($titles['0'])-1){
	$addFolder = false;
}
if(count($url)>count($titles['0'])-1){
	$addNotice = true;
}
//echo "<pre>"; print_r($titles); echo "</pre>";
$showAsCatalog = false;
if($titles['0']=='catalog'){
	$addFolder = true;
	$addNotice = true;
	$showAsCatalog = true;
	$titles = $titles['1'];
}
?>
		<div class="admintitle" style="padding:0px; margin:0px;" >
		<? if($addNotice){ ?><a href="javascript:getPage('<?=$optionName?>/<?=$folder['fullLink']?>?action=editItem,parent=<?=$folder['id']
		?><?  if($option['external']=='1'){ ?>,optionExternal=1<? } ?>')" id="add_item_to_cat_button"
		style="width:85px;">Добавить <?=$titles['2'][count($url)-1]?></a><? } ?>
		<? if($addFolder){ ?><a href="javascript:getPage('false', 'action', 'addNewFolder')"
		id="add_folder_to_cat_button">Добавить <?=$titles['2'][count($url)-1]?></a><? } ?>
		<? if(count($parents)>0 && !is_array($params)){ ?><a href="javascript:" id="edit_folder_cat_button"
		onclick="getPage('/adminarea/<?=$optionName?>/<?=$folder['fullLink']?>?action=editFolder,folderId=<?=$parents[count($parents)-1]['id']
		?>/')">Свойства <?=$titles['3'][count($url)-2]?></a><? } ?>
		<? if(count($parents)>0){ ?><a 
		onclick="deleteOptionFolder('<?=$loadPage?>', '<?=$parentNotice['id']?>', '<?=str_replace("'", "\\'", $parentNotice['name'])?>', 'back')"
		href="javascript:" id="deletefolderbutton">Удалить <?=$titles['2'][count($url)-2]?></a><? } ?>
		<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
		<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	    <?  //echo $__page_title; ?>
		</div>
		<div style="float:none; clear:both;"></div>
		<div class="manageadminforms" id="edit_content" style="display:;">
		  
<? //echo "<pre>"; print_r($folder); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($params); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($titles); echo "</pre>"; ?>
<!--  ------------------------------------------------------------- -->
<div class="folders_all"><? if($params['action']=='addNewFolder'){ ?><b>Добавить <?=$titles['2'][count($url)-1]?></b><?
}elseif($params['action']=='editFolder'){ ?><b>Редактировать <?=$titles['2'][count($url)-1]?></b><?
}elseif($params['action']=='addNewItem'){ ?><b>Добавить <?=$titles['2'][count($url)-1]?></b><?
}else{ ?>Просмотр <?=$titles['1'][count($url)-1]?><? } ?>
			<h1 id="folders_title">Каталог <? if(count($url)>='2'){ ?>
			<? if(is_array($parents)){ foreach($parents as $key=>$parentItem){
				if($params['action']!='editFolder'){
					echo " -› $parentItem[name]";
				}elseif($params['action']=='editFolder' && $key!=count($parents)-1){
					echo " -› $parentItem[name]";
				}elseif($params['action']=='editFolder' && $key==count($parents)-1){
					echo " -› ";
				}
			}}} if($params['action']=='addNewFolder'){ echo " -› "; } ?></h1>
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
//echo "<pre>"; print_r($parents[count($parents)-1]); echo "</pre>";
//echo "<pre>"; print_r($filters); echo "</pre>";
//echo "<pre>"; print_r($GLOBALS); echo "</pre>";
//echo "<pre>"; print_r($fields); echo "</pre>";
if(count($GLOBALS['languages'])>1){ ?>
<div class="languagesTabs" style="padding-bottom:10px;font-weight:bold;color:#990000;">
Переключение языков станет доступным после сохранения группы</div>
<div style="background-color:#A9C9A7; padding:15px;"><?
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
		case 'link': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">HTML-путь</td>
				<td><input type="text" id="link" style="width:100%" onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? } break;
		case 'content': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Описание</td>
				<td><textarea id="content" style="width:100%; height:300px;"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"></textarea></td>
			</tr></table>
			<? } break;
		case 'visible': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Отображение в сайте</td>
				<td><input type="checkbox" id="visible" checked="checked" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? } break;
		case 'letters': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Символьный	код</td>
				<td><input type="text" id="letters" onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? } break;
	}
}
?>
<? if($option['external']!='1'){ ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">Используемый шаблон</td>
	<td><select id="currentTemplate" onkeyup="globalEdit=true;" onchange="globalEdit=true;">
	<option value="0">-Выберите шаблон-</option><?
	if(is_array($filters)){ foreach($filters as $filter){
		echo "<option value=\"filter[id]\">$filter[name]</option>";
	} } ?></select></td>
</tr></table><? } ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">&nbsp;</td>
	<td><button onclick="saveNewLeftMenuFolder()">Сохранить</button>  <button onclick="getPage(window.location.pathname)">Отменить</button></td>
</tr></table></div>
<script>
function saveNewLeftMenuFolder(){
	var paction = "ajax=saveNewLeftMenuFolder";
	paction += "&option=<?=$optionName?>";
	<?  if($option['external']=='1'){ ?>paction += "&optionExternal=1";<? } ?>
	paction += "&name="+encodeURIComponent(document.getElementById("name").value);
	paction += "&parent=<?=$parents[count($parents)-1]['id']?>";
	<?  if($option['external']!='1'){ ?>paction += "&content="+encodeURIComponent(document.getElementById("content").value);<? } ?>
	<?  if($option['external']!='1'){ ?>paction += "&visible=1";<? } ?>
	<?  if($option['external']!='1'){ ?>paction += "&link="+document.getElementById("link").value;<? } ?>
	<?  if($option['external']!='1'){ ?>paction += "&filter="+document.getElementById("currentTemplate").value;<? } ?>
	//alert(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			globalEdit=false;
			getPage(window.location.pathname);
			//__css_itemShowCSS();
			//var obj = document.getElementById("show_cssblock_cont");
			//$(obj).empty();
			//$(obj).append(html);	
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
//echo "<pre>"; print_r($folder); echo "</pre>";
//echo "<pre>"; print_r($parents); echo "</pre>";
//echo "<pre>"; print_r($fields); echo "</pre>";
if(count($GLOBALS['languages'])>1){ ?>
<div class="languagesTabs"><? foreach($GLOBALS['languages'] as $key=>$lang){ ?>
	<span <?
	if((!$params['lang'] && $key==$GLOBALS['language']) || $params['lang']==$key){
		echo "class=\"active\"";
	}else{?>onclick="getPage(window.location.pathname+'<?=$paramsString?>', 'lang', '<?=$key?>')"<? } ?> ><?=$lang['0']?></span>
<? } ?></div><div style="float:none;clear:both;"></div>
<div style="background-color:#A9C9A7; padding:15px;"><?
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
		case 'parent': ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Родитель</td>
				<td><?=$parents[count($parents)-2]['name']?></td>
			</tr></table>
			<? break;
		case 'link': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">HTML-путь</td>
				<td><input type="text" id="link" style="width:100%" value="<?=$folder['link']?>"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? } break;
		case 'content': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Описание</td>
				<td><textarea id="content" style="width:100%; height:300px;"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"><?=$folder['content'.$langPrefix]?></textarea></td>
			</tr></table>
			<? } break;
		case 'visible': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Отображение в сайте</td>
				<td><input type="checkbox" id="visible" onchange="globalEdit=true;" <? if($folder['visible']=='1'){
					echo "checked";
				} ?> /></td>
			</tr></table>
			<? } break;
		case 'letters': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Символьный	код</td>
				<td><input type="text" id="letters" value="<?=$folder['letters']?>"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? } break;
	}
} }
?>
<? if($option['external']!='1'){ ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">Используемый шаблон</td>
	<td><select id="currentTemplate" onkeyup="globalEdit=true;" onchange="globalEdit=true;">
	<option value="0">-Выберите шаблон-</option><?
	if(is_array($filters)){ foreach($filters as $filter){
		echo "<option value=\"$filter[id]\" ";
		if($folder['filter']==$filter['id']){ echo "selected"; }
		echo " >$filter[name]</option>";
	} } ?></select></td>
</tr></table><? } ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">&nbsp;</td>
	<td><button onclick="saveNewLeftMenuFolder()">Сохранить</button>  <button onclick="getPage(window.location.pathname)">Отменить</button></td>
</tr></table></div>
<? if($parents[count($parents)-2]['id']){
	$myParent = $parents[count($parents)-2]['id'];
}else{
	$myParent = '0';
} ?>
<script>
function saveNewLeftMenuFolder(){
	var paction = "ajax=saveNewLeftMenuFolder";
	paction += "&option=<?=$optionName?>";
	<?  if($option['external']=='1'){ ?>paction += "&optionExternal=1";<? } ?>
	paction += "&id=<?=$folder['id']?>";
	paction += "&lang=<?=$langPrefix?>";
	paction += "&name="+encodeURIComponent(document.getElementById("name").value);
	paction += "&parent=<?=$myParent?>";
	<?  if($option['external']!='1'){ ?>paction += "&content="+encodeURIComponent(document.getElementById("content").value);<? } ?>
	<?  if($option['external']!='1'){ ?>paction += "&visible=1";<? } ?>
	<?  if($option['external']!='1'){ ?>paction += "&link="+document.getElementById("link").value;<? } ?>
	<?  if($option['external']!='1'){ ?>paction += "&filter="+document.getElementById("currentTemplate").value;<? } ?>
	//alert(paction);
	//return false;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			globalEdit=false;
			getPage(window.location.pathname);
			//__css_itemShowCSS();
	//		var obj = document.getElementById("show_cssblock_cont");
	//		$(obj).empty();
	//		$(obj).append(html);
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
if(is_array($item['0'])){   $item = $item['0'];   }
//echo "<pre>"; print_r($item); echo "</pre>";
//echo "<pre>"; print_r($filters); echo "</pre>";
//echo "<pre>"; print_r($fields); echo "</pre>";
//echo "<pre>"; print_r($titles); echo "</pre>";
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
//echo "<pre>"; print_r($fileld); echo "</pre>";
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
		case 'parent': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Родитель</td>
				<td><?=$parents[count($parents)-1]['name']?></td>
			</tr></table>
			<? } break;
		case 'link': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">HTML-путь</td>
				<td><input type="text" id="link" style="width:100%" value="<?=$item['link']?>"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? } break;
		case 'content': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Описание</td>
				<td><textarea id="content" style="width:100%; height:300px;"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;"><?=$item['content'.$langPrefix]?></textarea></td>
			</tr></table>
			<? } break;
		case 'visible': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Отображение в сайте</td>
				<td><input type="checkbox" id="visible" onchange="globalEdit=true;" <? if($item['visible']=='1'){
					echo "checked";
				} ?> /></td>
			</tr></table>
			<? } break;
		case 'letters': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Символьный	код</td>
				<td><input type="text" id="letters" value="<?=$item['letters']?>"
				onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
			</tr></table>
			<? } break;
		case 'images': if($option['external']!='1'){ $initImages=true; ?>
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
			<? } break;
	}
} } }
//*********************************************
if(is_array($fields) && $option['external']!='1'){ foreach($fields as $field){ if($field['default']=='0'){ ?>
<? //echo "<pre>"; print_r($field); echo "</pre>"; ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td><input type="<? if($field['config']['datatype']=='1' || $field['config']['datatype']=='2'){ ?>number<? }else{ ?>text<? } ?>" id="<?=$field['link']?>"
	value="<?=$item[$field['link']]?>" onkeyup="globalEdit=true;" onchange="globalEdit=true;" /></td>
</tr></table>
<? }}} ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">&nbsp;</td>
	<td><button onclick="saveNewLeftMenuItem()">Сохранить</button>  <button onclick="getPage(window.location.pathname)">Отменить</button></td>
</tr></table></div>
<? if($parents[count($parents)-1]['id']){
	$myParent = $parents[count($parents)-1]['id'];
}else{
	$myParent = '0';
} ?>
<script>
var currentItem = <?=json_encode($item)?>;
//alert(JSON.stringify(currentItem));
function saveNewLeftMenuItem(){
	var paction = "ajax=saveNewLeftMenuItem";
	paction += "&option=<?=$optionName?>";
	<?  if($option['external']=='1'){ ?>paction += "&optionExternal=1";<? } ?>
	paction += "&id=<?=$item['id']?>";
	paction += "&lang=<?=$langPrefix?>";
	paction += "&parent=<?=$myParent?>";
	for(var jj in currentItem){
		if(document.getElementById(jj)){
			var obj = document.getElementById(jj);
			if(obj.tagName.toLowerCase()=='input'){
				if(obj.getAttribute('type')=='checkbox'){
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
			}else if(obj.tagName.toLowerCase()=='textarea'){
				paction += "&"+jj+"="+encodeURIComponent(document.getElementById(jj).value);
			}
		}else if(jj=='tmp'){
			paction += "&tmp=0";
		}
	}
	//alert(paction);
	//return false;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			globalEdit=false;
			getPage(window.location.pathname);
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
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="getPage('<?=$optionName?>/<?=$item['fullLink']?>?action=editFolder,folderId=<?=$item['id']?>')"></a></td>
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
			<td height="34" width="20"><img src="/adminarea/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_105" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(105)"></td>
			<td height="34" width="20"><a href="javascript:toggle_page_show(105)" title="Отображение страницы в сайте"><img src="/adminarea/template/images/green/myitemname_popup/glaz.gif" id="glaz_105" width="16" height="16" border="0"></a></td>
			<td height="34" width="20">
			<? if($item['tumb']){ ?>
			<img src="/imgres.php?link=loadimages/<?=$item['tumb']['0']['name']?>&resize=44" width="44" height="33"
			border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
			<? }else{ ?>
			<img src="/adminarea/template/images/green/myitemname_popup/no_img.gif" width="44" height="33"
			border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
			<? } ?>
			</td>
			<td height="34" width="" style="font-weight:bold;"><span id="span_myitemname_105"><?=$item['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<!--<td height="34" width="20"><a href="javascript:" title="Клонировать запись"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>-->
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="deleteNotice('<?=$item['id']?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }}} ?>
</div>
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

