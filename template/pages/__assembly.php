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
//echo "<pre>orderStatuses:"; print_r($orderStatuses); echo "</pre>";
//echo "<pre>order:"; print_r($order); echo "</pre>";

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
		?><?  if($option['external']=='1'){ ?>,optionExternal=1<? } ?>,isAdmin=1')" id="add_item_to_cat_button"
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
		
		<a href="javascript:getData('/adminarea/?ajax=addGoodIntoOrder,orderId=<?=$params['orderId']?>')" id="add_item_to_cat_button"
		style="width:130px; margin-right:150px;">Добавить товар</a>
		<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
		<a href="javascript:getOrderStatuses();" id="fastSettings">&nbsp;</a>
		<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
		
		
		<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	    <?  //echo $__page_title; ?>
		</div>
		<div style="float:none; clear:both;"></div>
		<div class="manageadminforms" id="edit_content" style="display:;">
		
<? //echo "<pre>"; print_r($folder); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($params); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($titles); echo "</pre>"; ?>
<!--  ------------------------------------------------------------- -->
<script>
	globalEdit = false;
</script>



<? //**********************  ДОБАВЛЕНИЕ ГРУППЫ
if($params['action']=='addNewFolder') { ?>

<? //**********************  //ДОБАВЛЕНИЕ ГРУППЫ 

}else{ //**********************  ПРОСМОТР ГРУППЫ ?>

<div class="rightPanelBorder">&nbsp;</div>

<div class="languagesTabs">
	<span <?
	if($order['manual']=='0'){
		echo "class=\"active\"";
	}else{?>onclick="getData(window.location.pathname+'/<?=$paramsString?>', <?
	?>'orderStatus', 'all')"<? } ?> >Режим автоматический</span>
	<span <?
	if($order['manual']=='1'){
		echo "class=\"active\"";
	}else{?>onclick="getData(window.location.pathname+'/<?=$paramsString?>', <?
	?>'orderStatus', 'all')"<? } ?> >Режим ручной</span>
</div>
<div style="float:none;clear:both;"></div>

<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">

	<div class="ui-state-default-2 connectedSortable" id="">
	<div class="div_myitemname" style="padding-top: 0px;">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20" style="font-weight:bold;">№</td>
			<td height="34" width="50">&nbsp;</td>
			<td height="34" width="180" style="font-weight:bold;">Название</td>
			<td height="34" width="100" style="font-weight:bold;" align="center">
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/price.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="50" style="font-weight:bold;" align="center">
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/inbasket.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="70" style="font-weight:bold;" align="center">%</td>
			<td height="34" width="100" style="font-weight:bold;" align="center">
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/price-discount.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="100" align="center">
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/sum.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<!--<td height="34" width="20"><a href="javascript:" title="Клонировать запись"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>-->
			<td height="34" width="20"><? if($item['includeComments']=='1'){ ?>
				<img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/comments.gif"
				id="imgcomments_<?=$item['id']?>" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"><? } ?>
			</td>
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="addToTrash('<?=$item['id']?>')"></a></td>
		</tr></table>
	</div></div>
<? //echo "<pre>"; print_r($items); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? //echo "<pre>orderStatuses:"; print_r($orderStatuses); echo "</pre>"; ?>
<? if(is_array($items)){ $count=0; foreach($items as $item){
$lnk = false;
if($item['folder']=='1' && $titles['0']!='static') { //Выписываем дирректорию  ?>

<? }else{ //Выписываем элемент
if($item['item']['tumb']['0']['name']){
	$lnk = $classImages->createImageLink("../loadimages", "44x33", $item['item']['tumb']['0']['name']);
}
?>
<div class="ui-state-default-2 connectedSortable"
id="prm_?action=editItem,option=<?=$params['option']?>,parents=<?=$params['parents']?>,itemId=<?=$item['id']?>">
	<div class="div_myitemname" style="padding-top: 0px;height:56px;<? if($item['tmp']=='1'){ 
	?>background-color:#CCCCCC;<? } ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="54" width="20"><?=$count?></td>
			<? if($option['useimg']=='1'){ ?>
				<td height="34" width="50">
				<? if($lnk){ ?>
				<img src="/loadimages/<?=$lnk?>" width="44" height="33"
				border="1" class="imggal" align="absmiddle" style="">
				<? }else{ ?>
				<img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/no_img.gif" width="44" height="33"
				border="1" class="imggal" align="absmiddle" style="">
				<? } ?>
				</td>
			<? } ?>
			<td height="34" width="180" style="font-weight:bold;"><span
			id="itemName_<?=$item['id']?>"><?=$item['item']['name']?></span></td>
			<td height="34" width="100" align="center"><?=$item['item']['price']?></td>
			<td height="34" width="50" align="center"><input type="number" style="width:45px;height:30px;" min="1" step="1"
			max="1000" id="qtty_<?=$item['id']?>" value="<?=$item['qtty']?>" onchange="__ao_changeQtty(this)"></td>
			<td height="34" width="70" style="font-weight:bold;" align="center">---</td>
			<td height="34" width="100" style="font-weight:bold;" align="center"><?=$item['item']['priceDiscount']?></td>
			<td height="34" width="100" style="font-weight:bold;" align="center"><?=$item['item']['sum']?></td>
			<td height="34" width="">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="Внимание: незаполненные поля">&nbsp;</a></td>
			<!--<td height="34" width="20"><a href="javascript:" title="Клонировать запись"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>-->
			<td height="34" width="20"><? if($item['includeComments']=='1'){ ?>
				<img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/comments.gif"
				id="imgcomments_<?=$item['id']?>" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"><? } ?>
			</td>
			<td height="34" width="20"><a href="javascript:" title="Редактировать запись"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="Удалить запись"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="addToTrash('<?=$item['id']?>')"></a></td>
		</tr></table>
	</div>
</div>
<? $count++; }}} ?>
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
//*********************************************************
var stusesColors = { <? foreach($orderStatuses as $key=>$oStatus){ $str .= "\"$key\":\"oStatus[color]\","; } echo preg_replace("/,$/", '', $str); ?> };
//*********************************************************
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

