<?
/**

������� �� ������

������ ������������ ��� ����������� ���������� ���������� ������ ����. 
� ����� ��� ����������/��������/�������������� ������, ��������� ��� ��������


���������� ����� / ��� ������ / ��������
��� ��������� ���������� ���������� � ����� �/�����������/classes/class.Core.php�
����� ����������� �������: ������ �n �������� �������, ��������, ���� ��� ����� ����� ������� �createImageLink�,
�� �� ������� � ������ ������ �����, �������� � ������ ������������ �� ����� �n createImageLink�, ������� � ���� ���� � ���������� ���������� ������ ���������-������� ��-������.

//*****************************************************
�������:

$GLOBALS / array() / ������ ���������� ���������� � ��������

$GLOBALS['languages'] / array() / ������ ������, $GLOBALS['language'] / string/ ��������� ����

$params / array() / ������ ������ �� get-�������, ���� http://mysite.com/adminarea/?option=items,parents=0->1->2,editItem=3
��������, ��� � ������� `items` ������ ���� ������� �������, ������������� ���������� (�������� �������������\�������) �������� ��������: 
��������� ������� � id=2, ������� ������ � ������� � id=1, ������� �������� �������� ��������� ������-������� `items`.
echo "<pre>"; print_r($params); echo "</pre>";

$parents / array() / ������ ������������ ���������

$option / array() / ������ �������� ������-������� $params[option] � ������� `menusettings` (������������ �� ������� `link`)

$fields / array() / ������ ������������ ��� ������� ������� ����� �� ������� `filters`

$filter / array() / ������������ ������� ������� $fields �� ������� `filters`

$items / array() / ������ ������������ � ������ ��������

$item / array() / ������ �������� ������� $params['option'] � ������� folder=0

$folder / array() / ������ �������� ������� $params['option'] � ������� folder=1

$titles / array() / ������ � ����������� (��������, ��������� ������). ��������� ���������� �������� � ������� menusettings
������ �� ���������� �������� �� �������: 
$query = $this->query("SELECT `title` FROM `menusettings` WHERE `link`='$params[option]' ";
�� ��������� ��������� ��� ������-������� `items` ����� ���
catalog:������->�����
������->�������
������->�������

//*****************************************************
����������:

$optionName == $params['option'] == $option['link'] / string / �������� ������������ ������-�������

$GLOBALS['language'] / string / ��������� ����

$paramsString / string / ������ � get-��������



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
	$addItemTitle = "��������<br/>".$titles['1']['2']['1'];
	$addFolderTitle = "��������<br/>".$titles['1']['2']['0'];
	$editFolderTitle = "��������<br/>".$titles['1']['2']['0'];
	$deleteFolderTitle = "�������<br/>".$titles['1']['2']['0'];
}elseif($titles['0']=='static'){
	//echo count($parents)."::".count($titles['1']['0']);
	if(count($parents)==count($titles['1']['0'])-1){
		$addItem = true;
		$addItemTitle = "��������<br/>".$titles['1']['2'][count($parents)];
	}
	//*****
	if(count($parents)<=count($titles['1']) && count($parents)>0){
		$editFolder = true;
		$editFolderTitle = "�������������<br/>".$titles['1']['2'][count($parents)-1];
	}
	//*****
	if(count($parents)<count($titles['1']['0'])-1){
		$addFolder = true;
		$addFolderTitle = "��������<br/>".$titles['1']['2'][count($parents)];
	}
	//*****
	if(count($parents)<=count($titles['1']) && count($parents)>0){
		$deleteFolder = true;
		$deleteFolderTitle = "�������<br/>".$titles['1']['2'][count($parents)-1];
	}
}elseif($titles['0']=='single'){
	$addItem = true;
	$addItemTitle = "��������<br/>".$titles['1']['2'][count($parents)];
}
?>
		<div class="admintitle" style="padding:0px; margin:0px;" >
		
		<? if($addItem){ ?>
		<a href="javascript:" id="add_item_to_cat_button" onclick="getAdminOrder()"
		style="width:85px;">�������� �����<? //echo $addItemTitle?></a>
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
<div class="folders_all"><? if($params['action']=='addNewFolder'){ ?><b>�������� <?=$titles['2'][count($url)-1]?></b><?
}elseif($params['action']=='editFolder'){ ?><b>������������� <?=$titles['2'][count($url)-1]?></b><?
}elseif($params['action']=='addNewItem'){ ?><b>�������� <?=$titles['2'][count($url)-1]?></b><?
}else{ ?>�������� <?=$titles['1']['1'][count($url)-1]?><? } ?>
			<h1 id="folders_title"><?=$option['name']?> <? if(count($parents)>='1'){ ?>
			<? if(is_array($parents)){ foreach($parents as $key=>$parentItem){
				if($params['action']!='editFolder'){
					echo " -� $parentItem[name]";
				}elseif($params['action']=='editFolder' && $key!=count($parents)-1){
					echo " -� $parentItem[name]";
				}elseif($params['action']=='editFolder' && $key==count($parents)-1){
					echo " -� ";
				}
			}}} if($params['action']=='addNewFolder'){ echo " -� "; } ?></h1>
			<? if(!$params['action']) { ?><div id="folders_count_items">���������: <?=count($items)?></div><? } ?>
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
		mass = obj.innerHTML.split('-�');
		//console.log(mass);
		var inner = "... ";
		inner += " -� " + mass[mass.length-2];
		inner += " -� " + mass[mass.length-1];
		obj.innerHTML = inner;
	}
</script>



<? //**********************  ���������� ������
if($params['action']=='addNewFolder') { ?>

<? //**********************  //���������� ������ 

}else{ //**********************  �������� ������ ?>

<div class="rightPanelBorder">&nbsp;</div>

<div class="languagesTabs">
	<span <?
	if($params['orderStatus']=='all'){
		echo "class=\"active\"";
	}else{?>onclick="getData(window.location.pathname+'/<?=$paramsString?>', <?
	?>'orderStatus', 'all')"<? } ?> >���</span>
			<? foreach($orderStatuses['data'] as $oStatus){ if($oStatus['visible']=='1'){ ?>
			<span <?
			if($params['orderStatus']==$oStatus['id']){
				echo "class=\"active\"";
			}else{?>onclick="getData(window.location.pathname+'/<?=$paramsString?>', <?
			?>'orderStatus', '<?=$oStatus['id']?>')"<? } ?> ><?=$oStatus['name']?></span>
<? }} ?></div>
<div style="float:none;clear:both;"></div>

<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($items); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? //echo "<pre>orderStatuses:"; print_r($orderStatuses); echo "</pre>"; ?>
<? if(is_array($items)){ foreach($items as $item){
$lnk = false;
if($item['folder']=='1' && $titles['0']!='static') { //���������� �����������
	if($item['tumb']['0']['name']){
		$lnk = $classImages->createImageLink("../loadimages", "44x33", $item['tumb']['0']['name']);
	}
?>

<? }else{ //���������� �������
if($item['tumb']['0']['name']){
	$lnk = $classImages->createImageLink("../loadimages", "44x33", $item['tumb']['0']['name']);
}

//echo "OS=".$orderStatuses[$item['orderStatus']]['color'];
//echo "<pre>"; print_r($orderStatuses['12']); echo "</pre>";
?>
<div class="ui-state-default-2 connectedSortable"
id="prm_<?=$item['name']?>">
	<div class="div_myitemname" style="padding-top: 0px;<?
	if($orderStatuses['data'][$item['orderStatus']]){ 
		?>background-color:<?=$orderStatuses['data'][$item['orderStatus']]['color']?>;<?
	}elseif($item['tmp']=='1'){ 
		?>background-color:#CCCCCC;<?
	} ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="25" align="center" style="font-weight:bold;"><? if($item['isAdmin']=='1'){ ?>
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/admin-icon.gif" width="16" height="16" border="0" />
			<? }else{ ?>
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/user-icon.gif" width="16" height="16" border="0" />
			<? } ?></td>
			<td height="34" width="90" style="font-weight:bold;" align="center">
			<span id="itemName_<?=$item['id']?>"><?=$item['name']?></span></td>
			<td height="34" width="150"><select style="width:140px;height:26px;" onchange="__ao_cangeOrderStatus(9, this.value, 'take', '1')">
			<? foreach($orderStatuses['data'] as $oStatus){ if($oStatus['visible']=='1'){ ?>
				<option value="<?=$oStatus['id']?>" <? if($oStatus['id']==$item['orderStatus']) { echo "selected"; } ?> ><?=$oStatus['name']?></option>
			<? }} ?></select></td>
			<td height="34" width="200"><?=$item['user']['fio']?><br/><?=$item['user']['email']?></td>
			<td height="34" width="">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="��������: ������������� ����">&nbsp;</a></td>
			<!--<td height="34" width="20"><a href="javascript:" title="����������� ������"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>-->
			<td height="34" width="20"><? if($item['includeComments']=='1'){ ?>
				<img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/comments.gif"
				id="imgcomments_<?=$item['id']?>" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"><? } ?>
			</td>
			<td height="34" width="20"><a href="javascript:" title="������������� ������"><img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"></a></td>
			<td height="34" width="20"><a href="javascript:" title="������� ������"><img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="addToTrash('<?=$item['id']?>')"></a></td>
		</tr></table>
	</div>
</div>
<? }}} ?>
</div>
<script>
//*********************************************************
var stusesColors = { <? foreach($orderStatuses as $key=>$oStatus){ $str .= "\"$key\":\"oStatus[color]\","; } echo preg_replace("/,$/", '', $str); ?> };
//*********************************************************
</script>
<? } //**********************  //�������� ������ ?>
<!--  ------------------------------------------------------------- -->
		  
		  
		</div>
		<div class="manageadminforms" id="lookContent" style="display:none;">
		  � ��� ���� ���������� ������ �������������� �����
		</div>
		<div class="manageadminforms" id="help_content" style="display:none;">
		  ������� ����� ���
		</div>
		
	  <div id="nztime"></div>

