<?
/**

Справка по модулю

Модуль предназначен для отображения информации выбранного пункта меню. 
А также для добавления/удаления/редактирования группы, подгруппы или элемента


Переменные среды / Тип данных / Описание
все доступные переменные собираются в файле «/вашаАдминка/classes/class.Core.php»
Поиск необходимой функции: вводим «n название функции», например, если нам напдо найти функцию «createImageLink»,
то мы заходим в корень нашего сайта, включаем в поиске соответствие на фразу «n createImageLink», заходим в этот файл и поправляем функционал данной процедуры-функции по-своему.

//*****************************************************
МАССИВЫ:

$GLOBALS / array() / список глобальных переменных и настроек

$GLOBALS['languages'] / array() / массив языков, $GLOBALS['language'] / string/ выбранный язык

$params / array() / массив данных из get-запроса, типа http://mysite.com/adminarea/?option=items,parents=0->1->2,editItem=3
Означает, что в таблице `items` должен быть изменен элемент, родительскими элементами (возможно дирректориями\папками) которого являются: 
вложенный элемент с id=2, который вложен в элемент с id=1, который является корневым элементом группы-таблицы `items`.
echo "<pre>"; print_r($params); echo "</pre>";

$parents / array() / массив родительских элементов

$option / array() / массив настроек группы-таблицы $params[option] в таблице `menusettings` (определяется по столбцу `link`)

$fields / array() / массив используемых для данного шаблона полей из таблицы `filters`

$filter / array() / родительский элемент массива $fields из таблицы `filters`

$items / array() / массив отображаемых в списке объектов

$item / array() / массив элемента таблицы $params['option'] с индесом folder=0

$folder / array() / массив элемента таблицы $params['option'] с индесом folder=1

$titles / array() / массив с заголовками (например, «Добавить группу»). Настройки заголовков хранятся в таблице menusettings
данные по заголовкам доступны по запросу: 
$query = $this->query("SELECT `title` FROM `menusettings` WHERE `link`='$params[option]' ";
по умолчанию заголовки для группы-таблицы `items` имеют вид
catalog:группа->товар
группы->позиции
группу->позицию

//*****************************************************
ПЕРЕМЕННЫЕ:

$optionName == $params['option'] == $option['link'] / string / Название используемой группы-таблицы

$GLOBALS['language'] / string / выбранный язык

$paramsString / string / строка с get-запросом



END OF MANUAL
//*****************************************************
*/
//*****************************************************
//echo "<pre>"; print_r($administrator); echo "</pre>";
//echo "<pre>fields:"; print_r($fields); echo "</pre>";
//echo "<pre>filter:"; print_r($filter); echo "</pre>";
//echo "<pre>option:"; print_r($option); echo "</pre>";
//echo "<pre>titles:"; print_r($titles); echo "</pre>";
//echo "<pre>item:"; print_r($item); echo "</pre>";
//echo "<pre>parents:"; print_r($parents); echo "</pre>";

//echo "<pre>paramsString = '$paramsString'</pre>";
//echo "<pre>optionName = '$optionName'</pre>";
//echo "<pre>GLOBALS['language'] = '$GLOBALS[language]'</pre>";


$addItem = false;
$addFolder = false;
$deleteFolder = false;
$editFolder = false;

if($titles['0']=='catalog'){
	$addFolder = true;
	$addItem = true;
	if(preg_match("/->/", $params['parents'])){
		$editFolder = true;
		$deleteFolder = true;
	}
	//*****************************
	$addItemTitle = "Добавить<br/>".$titles['1']['2']['1'];
	$addFolderTitle = "Добавить<br/>".$titles['1']['2']['0'];
	$editFolderTitle = "Изменить<br/>".$titles['1']['2']['0'];
	$deleteFolderTitle = "Удалить<br/>".$titles['1']['2']['0'];
}elseif($titles['0']=='static'){
	//echo count($parents)."::".count($titles['1']['0']);
	if(count($parents)==count($titles['1']['0'])-1){
		$addItem = true;
		$addItemTitle = "Добавить<br/>".$titles['1']['2'][count($parents)];
	}
	//*****
	if(count($parents)<=count($titles['1']) && count($parents)>0){
		$editFolder = true;
		$editFolderTitle = "Редактировать<br/>".$titles['1']['2'][count($parents)-1];
	}
	//*****
	if(count($parents)<count($titles['1']['0'])-1){
		$addFolder = true;
		$addFolderTitle = "Добавить<br/>".$titles['1']['2'][count($parents)];
	}
	//*****
	if(count($parents)<=count($titles['1']) && count($parents)>0){
		$deleteFolder = true;
		$deleteFolderTitle = "Удалить<br/>".$titles['1']['2'][count($parents)-1];
	}
}elseif($titles['0']=='single'){
	$addItem = true;
	$addItemTitle = "Добавить<br/>".$titles['1']['2'][count($parents)];
}
?>
		<div class="admintitle" style="padding:0px; margin:0px;" >
		
		<? if($addItem){ ?>
		<a href="javascript:getData('<?=$GLOBALS['adminBase']?>/?action=editItem,option=<?=$params['option']?>,parents=<?=$params['parents']
		?><?  if($option['external']=='1'){ ?>,optionExternal=1<? } ?>')" id="add_item_to_cat_button"
		style="width:85px;"><?=$addItemTitle?></a>
		<? } ?>
		
		<? if($addFolder){ ?>
		<a href="javascript:getData('<?=$GLOBALS['adminBase']?>/?option=<?=$params['option']?>,parents=<?=$params['parents']?>,action=addNewFolder')"
		id="add_folder_to_cat_button"><?=$addFolderTitle?></a>
		<? } ?>
		
		<? if($editFolder){ ?><a href="javascript:" id="edit_folder_cat_button"
		onclick="getData('<?=$GLOBALS['adminBase']?>/?option=<?=$optionName?>,action=editFolder,folderId=<?=$parents[count($parents)-1]['id']
		?>,parents=<?=$params['parents']?>')"><?=$editFolderTitle?></a>
		<? } ?>
		
		<? if($deleteFolder){ ?>
		<a onclick="deleteOptionFolder('<?=$loadPage?>', '<?=$parentNotice['id']?>', '<?=str_replace("'", "\\'", $parentNotice['name'])?>', 'back')"
		href="javascript:" id="deletefolderbutton"><?=$deleteFolderTitle?></a>
		<? } ?>
		
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
}else{ ?>Просмотр <?=$titles['1']['1'][count($url)-1]?><? } ?>
			<h1 id="folders_title"><?=$option['name']?> <? if(count($parents)>='1'){ ?>
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
	if($("#folders_title").height()>40){
		var obj = document.getElementById("folders_title");
		var mass = obj.innerHTML.trim();
		mass = obj.innerHTML.split('-›');
		//console.log(mass);
		var inner = "... ";
		inner += " -› " + mass[mass.length-2];
		inner += " -› " + mass[mass.length-1];
		obj.innerHTML = inner;
	}
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
	var paction = "ajax=saveNewFolder";
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
			console.log(html);
			globalEdit=false;
			getData('<?=$GLOBALS['adminBase']?>/?option=<?=$params['option']?>,parents=<?=$params['parents']?>');
			openLeftBranch('<?=$optionName?>', '<?=$parents[count($parents)-1]['id']?>');
			openLeftBranch('<?=$optionName?>', '<?=$parents[count($parents)-1]['id']?>');
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
//*********************************************************
document.getElementById('adminarearight').onkeyup = function(event){
	if(event.keyCode==13 && document.getElementById('addNewFolderTester')){
		saveNewLeftMenuFolder();
	}
	return false;
}
</script>
<div id="addNewFolderTester" style="display:none;"></div>
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
	}else{?>onclick="getData(window.location.pathname+'<?=$paramsString?>', 'lang', '<?=$key?>')"<? } ?> ><?=$lang['0']?></span>
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
				?>onkeyup="addNameToTitle();__GLOBALS.editing=true;" onchange="addNameToTitle();__GLOBALS.editing=true;"<? }else{ ?>
				onkeyup="__GLOBALS.editing=true;" onchange="__GLOBALS.editing=true;"
				<? } ?> /></td>
			</tr></table>
			<? break;
		case 'parent': if($option['useimg']=='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Родитель</td>
				<td><?=$parents[count($parents)-2]['name']?></td>
			</tr></table>
			<? } break;
		case 'link': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">HTML-путь</td>
				<td><input type="text" id="link" style="width:100%" value="<?=$folder['link']?>"
				onkeyup="__GLOBALS.editing=true;" onchange="__GLOBALS.editing=true;" /></td>
			</tr></table>
			<? } break;
		case 'images': if($option['external']!='1' && $option['useimg']=='1'){ $initImages=true; ?>
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
				<td height="30" style="padding-bottom:10px;">&nbsp;</td>
				<td><ul id="usercabinetprofile">
						<?
						//echo "<pre>Images:"; print_r($item['tumb']); echo "</pre>";
						if(is_array($folder['tumb'])){
							foreach($folder['tumb'] as $image){
								$lnk = $classImages->createImageLink("../loadimages", "100x100", $image['name'], true);
								echo "<li id=\"imgId_$image[id]\" class=\"loadimg_li\" style=\" ";
								echo "background-image:url(".preg_replace("/^\.\./", "", $lnk).");\">";
								//echo "<img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
								//echo "resize_x=160&resize_y=160&wrapper=1&link=loadimages/".$image['name']."\" class=\"loadimg\" />";
								echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteImage('".$image['id']."')\" ";
								echo "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
								echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"imageToText('".$image['name']."')\" ";
								echo "style=\"text-decoration:none;\"><font color=red><b>T</b></font></a>";
								echo "</li>";
							}
						}
						?>
					</ul>
					<div style="float:none;clear:both;height:10px;"></div></td>
			  </tr>
			</table>
			<? } break;
		case 'content': if($option['external']!='1' && $option['useimg']=='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Описание</td>
				<td><textarea id="content" style="width:100%; height:300px;"
				onkeyup="__GLOBALS.editing=true;" onchange="__GLOBALS.editing=true;"><?=$folder['content'.$langPrefix]?></textarea></td>
			</tr></table>
			<? } break;
		case 'visible': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Отображение в сайте</td>
				<td><input type="checkbox" id="visible" onchange="__GLOBALS.editing=true;" <? if($folder['visible']=='1'){
					echo "checked";
				} ?> /></td>
			</tr></table>
			<? } break;
		case 'letters': if($option['external']!='1' && $option['useletters']=='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Символьный	код</td>
				<td><input type="text" id="letters" value="<?=$folder['letters']?>"
				onkeyup="__GLOBALS.editing=true;" onchange="__GLOBALS.editing=true;" /></td>
			</tr></table>
			<? } break;
	}
} }
?>
<? if($option['external']!='1' && $option['usetemplate']=='1'){ ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30">Используемый шаблон</td>
	<td><select id="currentTemplate" onkeyup="__GLOBALS.editing=true;" onchange="__GLOBALS.editing=true;">
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
	var paction = "ajax=saveFolder";
	paction += "&option=<?=$optionName?>";
	<?  if($option['external']=='1'){ ?>paction += "&optionExternal=1";<? } ?>
	paction += "&id=<?=$folder['id']?>";
	paction += "&lang=<?=$langPrefix?>";
	<?  if($option['useletters']=='1'){ ?>paction += "&letters="+document.getElementById("letters").value;<? } ?>
	paction += "&name="+encodeURIComponent(document.getElementById("name").value);
	paction += "&parent=<?=$myParent?>";
	<?  if($option['external']!='1'){ ?>paction += "&visible=1";<? } ?>
	<?  if($option['external']!='1'){ ?>paction += "&link="+document.getElementById("link").value;<? } ?>
	<?  if($option['external']!='1' && $option['usetemplate']=='1'){ ?>paction += "&filter="+document.getElementById("currentTemplate").value;<? } ?>
	<?  if($option['external']!='1' && $option['usetext']=='1'){ ?>
		tinyMCE.execCommand('mceRemoveControl',true, "content");
		if(document.getElementById("content")){
			paction += "&content="+encodeURIComponent(document.getElementById("content").value);
		}
	<? } ?>
	console.log(paction);
	//return false;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			__GLOBALS.editing = false;
			//getData('<?=$GLOBALS['adminBase']?>/?option=<?=$params['option']?>,parents=<?=$params['parents']?>');
			getData('<?=$GLOBALS['adminBase']?>/?option=<?=$params['option']?>,parents=<?=$params['parents']?>');
			openLeftBranch('<?=$optionName?>', '<?=$parents[count($parents)-1]['id']?>');
			openLeftBranch('<?=$optionName?>', '<?=$parents[count($parents)-1]['id']?>');
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
//*********************************************************
function insertImgModule(fileId){
    //alert(fileId);
	var id = fileId;
    id = id.split(".")[0];
	var innerObj = document.getElementById("usercabinetprofile");
	var inner = "<li id=\"imgId_"+id+"\" style=\"background-image:url(/imgres.php?resize=100&wrapper=105&link=loadimages/"+fileId+");\">";
	//inner += "<img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
	//inner += "resize_x=100&resize_y=100&link=loadimages/"+fileId+"\" width=\"100\" height=\"100\" class=\"loadimg\" />";
	inner += "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteProfileImg('"+fileId+"')\" ";
	inner += "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
	inner += "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"imageToText('"+fileId+"')\" ";
	inner += "style=\"text-decoration:none;\"><font color=red><b>T</b></font></a>";
	inner += "</li>";
	innerObj.innerHTML += inner;    
}
//*********************************************************
function initImages(){
	var objs = document.getElementsByClassName("loadimg_li");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		obj.onclick = function(){
			__popup({"width":"400px","height":"auto"});
			var paction =  "ajax=showItemImageProperties";
			paction += "&imageId="+this.id.replace(/imgId_/gi, '');
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: paction,
				success: function(html) {
					//console.log("html: "+html);
					html = (html=='')?'{}':html;
					var data = eval("("+html+")");
					
					var inner = "<h2 id=\"h2_imgeProperties\">Описание изображения</h2>";
					inner += "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" ><tr>";
					inner += "<tr><td width=\"25\" align=\"left\" id=\"tdPrev\" onClick=\"prevImg()\">";
					inner += "<img src=\"/adminarea/template/images/green/icons/imrproperties_left.png\" border\"0\" />";
					inner += "</td><td>";
					inner += "<img style=\"\" border=\"0\" id=\"img_imageProperties\" ";
					inner += "src=\"/loadimages/"+data.image+"\" />";
					inner += "</td><td width=\"25\" align=\"right\" id=\"tdNext\" onClick=\"nextImg()\">";
					inner += "<img src=\"/adminarea/template/images/green/icons/imrproperties_right.png\" border\"0\" />";
					inner += "</td></tr>";
					inner += "<tr><td colspan=\"3\" align=\"center\" height=\"35\" style=\"padding-top:10px;\">";
					inner += "<input type=\"text\" style=\"width:350px;height:30px;\" title=\"ALT\" placeholder=\"ALT\" id=\"input_alt\" />";
					inner += "</td></tr>";
					inner += "<tr><td colspan=\"3\" align=\"center\" height=\"35\">";
					inner += "<input type=\"text\" style=\"width:350px;height:30px;\" title=\"TITLE\" placeholder=\"TITLE\" id=\"input_title\" />";
					inner += "</td></tr>";
					inner += "<tr><td colspan=\"3\" align=\"center\" height=\"35\">";
					inner += "<button>Сохранить</button>&nbsp;&nbsp;";
					inner += "<button onclick=\"__popup_close()\">Отменить</button>";
					inner += "</td></tr></table>";
					//console.log(inner);
					document.querySelector("#popup_cont").innerHTML = inner;
					document.querySelector("#input_alt").value = data.alt;
					document.querySelector("#input_title").value = data.title;
				}
			});
		}
	}
}
initImages();
//*********************************************************
$( "#usercabinetprofile" ).sortable({
	update: function() {
		var priors = $(this).sortable('toArray');
		//console.log(priors);
		var paction =  "ajax=setImagesPriors";
		paction += "&ids="+priors;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//console.log(html);
			}
		});
	}
});
//*********************************************************
function nextImg(){
	var src = document.querySelector("#img_imageProperties").getAttribute("src").replace(/^.*\//gi, '');
	var objs = document.querySelector("#usercabinetprofile").getElementsByTagName("li");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		image = obj.style.backgroundImage.replace(/^.*\//gi, '');
		image = image.replace(/".*$/gi, '');
		if(image==src && objs[j+1]){
			objs[j+1].onclick();
		}
	}
}
//*********************************************************
function prevImg(){
	var src = document.querySelector("#img_imageProperties").getAttribute("src").replace(/^.*\//gi, '');
	var objs = document.querySelector("#usercabinetprofile").getElementsByTagName("li");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		image = obj.style.backgroundImage.replace(/^.*\//gi, '');
		image = image.replace(/".*$/gi, '');
		if(image==src && j!=0){
			objs[j-1].onclick();
		}
	}
}
//*********************************************************
var currentOptionName = '<?=$params['option']?>';
var currentItemId = '<?=$folder['id']?>';
<? if($initImages){ ?>startFileUploader();<? } //Инициализация загрузчика изображений ?> 
tinymce_init();
//*********************************************************
document.getElementById('adminarearight').onkeyup = function(event){
	if(event.keyCode==13 && document.getElementById('editFolderTester')){
		saveNewLeftMenuFolder();
	}
	return false;
}
</script>
<div id="editFolderTester" style="display:none;"></div>
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
<script>var fieldsObject = <?=$fieldsJSON?>;console.log(fieldsObject);</script>
<div class="languagesTabs"><? foreach($GLOBALS['languages'] as $key=>$lang){ ?>
	<span <?
	if((!$params['lang'] && $key==$GLOBALS['language']) || $params['lang']==$key){
		echo "class=\"active\"";
	}else{?>onclick="getData(window.location.pathname+'/<?=$paramsString?>', 'lang', '<?=$key?>')"<? } ?> ><?=$lang['0']?></span>
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
				?>onkeyup="addNameToTitle();__GLOBALS.editing=true;" onchange="addNameToTitle();__GLOBALS.editing=true;"<? }else{ ?>
				onkeyup="__GLOBALS.editing=true;" onchange="__GLOBALS.editing=true;"
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
				onkeyup="__GLOBALS.editing=true;" onchange="__GLOBALS.editing=true;" /></td>
			</tr></table>
			<? } break;
		case 'content': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Описание</td>
				<td><textarea id="content" style="width:100%; height:300px;"
				onkeyup="__GLOBALS.editing=true;" onchange="__GLOBALS.editing=true;"><?=$item['content'.$langPrefix]?></textarea></td>
			</tr></table>
			<? } break;
		case 'visible': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Отображение в сайте</td>
				<td><input type="checkbox" id="visible" onchange="__GLOBALS.editing=true;" <? if($item['visible']=='1'){
					echo "checked";
				} ?> /></td>
			</tr></table>
			<? } break;
		/*case 'letters': if($option['external']!='1'){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Символьный	код</td>
				<td><input type="text" id="letters" value="<?=$item['letters']?>"
				onkeyup="__GLOBALS.editing=true;" onchange="__GLOBALS.editing=true;" /></td>
			</tr></table>
			<? } break; */
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
				<td height="30" style="padding-bottom:10px;">&nbsp;</td>
				<td><ul id="usercabinetprofile">
						<?
						//echo "<pre>Images:"; print_r($item['tumb']); echo "</pre>";
						if(is_array($item['tumb'])){
							foreach($item['tumb'] as $image){
								$lnk = $classImages->createImageLink("../loadimages", "100x100", $image['name'], true);
								echo "<li id=\"imgId_$image[id]\" class=\"loadimg_li\" style=\" ";
								echo "background-image:url(".preg_replace("/^\.\./", "", $lnk).");\">";
								//echo "<img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
								//echo "resize_x=160&resize_y=160&wrapper=1&link=loadimages/".$image['name']."\" class=\"loadimg\" />";
								echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteImage('".$image['id']."')\" ";
								echo "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
								echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"imageToText('".$image['name']."')\" ";
								echo "style=\"text-decoration:none;\"><font color=red><b>T</b></font></a>";
								echo "</li>";
							}
						}
						?>
					</ul>
					<div style="float:none;clear:both;height:10px;"></div></td>
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
	var paction = "ajax=saveItem";
	paction += "&option=<?=$params['option']?>";
	<?  if($option['external']=='1'){ ?>paction += "&optionExternal=1";<? } ?>
	paction += "&id=<?=$item['id']?>";
	paction += "&lang=<?=$langPrefix?>";
	paction += "&parents=<?=$params['parents']?>";
	//console.log(currentItem);
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
				tinyMCE.execCommand('mceRemoveControl',true, jj);
				paction += "&"+jj+"="+encodeURIComponent(document.getElementById(jj).value);
				//alert(jj+":::"+document.getElementById(jj).value);
				//test += "&" + post_object[i][0] + "=" + replace_spec_simbols(tinyMCE.get(post_object[i][0]).getContent());
				//alert(tinyMCE.get(jj).getContent());
				//alert(tinyMCE.get('content').getContent());
			}
		}else if(jj=='tmp'){
			paction += "&tmp=0";
		}
	}
	//console.log(__PARAMS);
	console.log(paction);
	//return false;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			__GLOBALS.editing = false;
			getData('<?=$GLOBALS['adminBase']?>/?option=<?=$params['option']?>,parents=<?=$params['parents']?>');
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
	var inner = "<li id=\"imgId_"+id+"\" style=\"background-image:url(/imgres.php?resize=100&wrapper=105&link=loadimages/"+fileId+");\">";
	//inner += "<img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
	//inner += "resize_x=100&resize_y=100&link=loadimages/"+fileId+"\" width=\"100\" height=\"100\" class=\"loadimg\" />";
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
$( "#usercabinetprofile" ).sortable({
	update: function() {
		var priors = $(this).sortable('toArray');
		//console.log(priors);
		var paction =  "ajax=setImagesPriors";
		paction += "&ids="+priors;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//console.log(html);
			}
		});
	}
});
//*********************************************************
function initImages(){
	var objs = document.getElementsByClassName("loadimg_li");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		obj.onclick = function(){
			__popup({"width":"400px","height":"auto"});
			var paction =  "ajax=showItemImageProperties";
			paction += "&imageId="+this.id.replace(/imgId_/gi, '');
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: paction,
				success: function(html) {
					//console.log("html: "+html);
					html = (html=='')?'{}':html;
					var data = eval("("+html+")");
					
					var inner = "<h2 id=\"h2_imgeProperties\">Описание изображения</h2>";
					inner += "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" ><tr>";
					inner += "<tr><td width=\"25\" align=\"left\" id=\"tdPrev\" onClick=\"prevImg()\">";
					inner += "<img src=\"/adminarea/template/images/green/icons/imrproperties_left.png\" border\"0\" />";
					inner += "</td><td>";
					inner += "<img style=\"\" border=\"0\" id=\"img_imageProperties\" ";
					inner += "src=\"/loadimages/"+data.image+"\" />";
					inner += "</td><td width=\"25\" align=\"right\" id=\"tdNext\" onClick=\"nextImg()\">";
					inner += "<img src=\"/adminarea/template/images/green/icons/imrproperties_right.png\" border\"0\" />";
					inner += "</td></tr>";
					inner += "<tr><td colspan=\"3\" align=\"center\" height=\"35\" style=\"padding-top:10px;\">";
					inner += "<input type=\"text\" style=\"width:350px;height:30px;\" title=\"ALT\" placeholder=\"ALT\" id=\"input_alt\" />";
					inner += "</td></tr>";
					inner += "<tr><td colspan=\"3\" align=\"center\" height=\"35\">";
					inner += "<input type=\"text\" style=\"width:350px;height:30px;\" title=\"TITLE\" placeholder=\"TITLE\" id=\"input_title\" />";
					inner += "</td></tr>";
					inner += "<tr><td colspan=\"3\" align=\"center\" height=\"35\">";
					inner += "<button>Сохранить</button>&nbsp;&nbsp;";
					inner += "<button onclick=\"__popup_close()\">Отменить</button>";
					inner += "</td></tr></table>";
					//console.log(inner);
					document.querySelector("#popup_cont").innerHTML = inner;
					document.querySelector("#input_alt").value = data.alt;
					document.querySelector("#input_title").value = data.title;
				}
			});
		}
	}
}
initImages();
//*********************************************************
function nextImg(){
	var src = document.querySelector("#img_imageProperties").getAttribute("src").replace(/^.*\//gi, '');
	var objs = document.querySelector("#usercabinetprofile").getElementsByTagName("li");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		image = obj.style.backgroundImage.replace(/^.*\//gi, '');
		image = image.replace(/".*$/gi, '');
		if(image==src && objs[j+1]){
			objs[j+1].onclick();
		}
	}
}
//*********************************************************
function prevImg(){
	var src = document.querySelector("#img_imageProperties").getAttribute("src").replace(/^.*\//gi, '');
	var objs = document.querySelector("#usercabinetprofile").getElementsByTagName("li");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		image = obj.style.backgroundImage.replace(/^.*\//gi, '');
		image = image.replace(/".*$/gi, '');
		if(image==src && j!=0){
			objs[j-1].onclick();
		}
	}
}
//*********************************************************
var currentOptionName = '<?=$params['option']?>';
var currentItemId = '<?=$item['id']?>';
<? if($initImages){ ?>startFileUploader();<? } //Инициализация загрузчика изображений ?> 
tinymce_init();
//*********************************************************
document.getElementById('adminarearight').onkeyup = function(event){
	if(event.keyCode==13 && document.getElementById('editRecordTester')){
		saveNewLeftMenuItem();
	}
	return false;
}
</script>
<div id="editRecordTester" style="display:none;"></div>
<? } ?>
<?  //**********************  //ДОБАВЛЕНИЕ/РЕДАКТИРОВАНИЕ ОБЪЕКТА



}else{ //**********************  ПРОСМОТР ГРУППЫ ?>
<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($items); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? if(is_array($items)){ foreach($items as $item){
$lnk = false;
if($item['folder']=='1' && $titles['0']!='static') { //Выписываем дирректорию
	if($item['tumb']['0']['name']){
		$lnk = $classImages->createImageLink("../loadimages", "44x33", $item['tumb']['0']['name']);
	}
?>
	<div class="ui-state-default-2 connectedSortable" id="prm_?option=<?=$params['option']?>,parents=<?=$item['parents']?>,folderId=<?=$item['id']?>">
	<div class="div_myitemname" style="padding-top: 0px;">
		<table id="folder_1" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_1" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(1)"></td>
			<td height="34" width="20"><a href="javascript:" title="Отображение группы"><img
			src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/glaz<? if($item['visible']=='0'){ ?>_no<? } ?>.gif"
			id="glaz_<?=$item['id']?>" width="16" height="16" border="0"
			onclick="toggleVisible('<?=$params['option']?>','<?=$item['id']?>')"></a></td>
			<? if($option['useimg']=='1'){ ?>
				<? if($lnk){ ?><td height="34" width="50" align="center" style="background-image:url(<?=$GLOBALS['adminBase']?>/template/images/itemFolder.jpg);background-repeat:no-repeat;">
					<img src="/loadimages/<?=$lnk?>" width="24" height="18" border="1" class="imggal" align="absmiddle" style="margin-right:5px;margin-top:3px;">
				<? }else{ ?><td height="34" width="50" align="center" style="background-image:url(<?=$GLOBALS['adminBase']?>/template/images/itemFolder.jpg);background-repeat:no-repeat;">
				<? } ?></td>
			<? } ?>
			<td height="34" width="" style="font-weight:bold;"><span id="itemName_<?=$item['id']?>"><?=$item['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="<?=strip_tags($editFolderTitle)?>"><img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="getData('<?=$GLOBALS['adminBase']?>/?option=<?=$params['option']?>,action=editFolder,folderId=<?=$item['id']?>,parents=<?=$params['parents']."->".$item['id']?>')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_1" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="addToTrash('<?=$item['id']?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }else{ //Выписываем элемент
if($item['tumb']['0']['name']){
	$lnk = $classImages->createImageLink("../loadimages", "44x33", $item['tumb']['0']['name']);
}
?>
<div class="ui-state-default-2 connectedSortable"
id="prm_?action=editItem,option=<?=$params['option']?>,parents=<?=$params['parents']?>,itemId=<?=$item['id']?>">
	<div class="div_myitemname" style="padding-top: 0px;<? if($item['tmp']=='1'){ 
	?>background-color:#CCCCCC;<? } ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20"><img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/checkbox.gif" id="imgcheck_105" width="16" height="16" border="0" class="items_select_all" style="cursor:pointer" onclick="toggle_item_check(105)"></td>
			<td height="34" width="20"><a href="javascript:" title="Отображение страницы в сайте"><img
			src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/glaz<? if($item['visible']=='0'){ ?>_no<? } ?>.gif"
			id="glaz_<?=$item['id']?>" width="16" height="16" border="0"
			onclick="toggleVisible('<?=$params['option']?>','<?=$item['id']?>')"></a></td>
			<? if($option['useimg']=='1'){ ?>
				<td height="34" width="20">
				<? if($lnk){ ?>
				<img src="/loadimages/<?=$lnk?>" width="44" height="33"
				border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
				<? }else{ ?>
				<img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/no_img.gif" width="44" height="33"
				border="1" class="imggal" align="absmiddle" style="margin-right:5px;">
				<? } ?>
				</td>
			<? } ?>
			<td height="34" width="" style="font-weight:bold;"><span id="itemName_<?=$item['id']?>"><?=$item['name']?></span></td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<!--<td height="34" width="20"><a href="javascript:" title="Клонировать запись"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>-->
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="addToTrash('<?=$item['id']?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }}} ?>
</div>
<script>
var restoreObject = {};
function addToTrash(itemId){
	var name = document.getElementById("itemName_"+itemId).innerText;
	var obj = document.getElementById("itemName_"+itemId).parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
	//console.log(obj.id);
	bgObj = obj.getElementsByClassName("div_myitemname")[0];
	if(bgObj.getAttribute("myBgColor")){
		$(bgObj).css('background-color', bgObj.getAttribute("myBgColor"));
	}else{
		$(bgObj).css('background-color', '');
	}
	var oinner = obj.innerHTML;
	oinner = oinner.replace(/<tbody>/gi, '');
	oinner = oinner.replace(/<\/tbody>/gi, '');
	//console.log(oinner);
	restoreObject[itemId] = oinner;
	obj.innerHTML = "<div class=\"trashPreloader\" id=\"itemName_"+itemId+"\"></div>";
	var paction =  "ajax=addToTrash";
	paction += "&itemId="+itemId;
	paction += "&option=<?=$params['option']?>";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			var data = eval("("+html+")");
			if(data.itemId){
				var obj = document.getElementById("itemName_"+data.itemId).parentNode;
				var inner = "<div class=\"trashPreloader\" style=\"background-image:none;\" id=\"itemName_"+data.itemId+"\">";
				inner += "<br/><a href=\"javascript:\" ";
				inner += " onclick=\"restoreFromTrash('<?=$params['option']?>', '"+data.itemId+"')\">Восстановить</a></div>";
				obj.innerHTML = inner;
			}else{
				console.log("Ошибка");
			}
		}
	});
}
//*********************************************************
function restoreFromTrash(option, itemId){
	var obj = document.getElementById("itemName_"+itemId).parentNode;
	obj.innerHTML = "<div class=\"trashPreloader\" id=\"itemName_"+itemId+"\"></div>";
	var paction =  "ajax=restoreFromTrash";
	paction += "&itemId="+itemId;
	paction += "&option="+option;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			var data = eval("("+html+")");
			if(data.itemId){
				var obj = document.getElementById("itemName_"+data.itemId);
				//obj.parentNode.removeChild(obj);
				obj.parentNode.innerHTML = restoreObject[data.itemId];
			}else{
				console.log("Ошибка");
			}
			//initItems();
		}
	});
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

