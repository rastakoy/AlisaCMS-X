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
		
		<a href="javascript:" id="add_item_to_cat_button" onclick="prepareAddNewGoodIntoOrder('<?=$params['orderId']?>')"
		style="width:180px; margin-right:150px;" >�������� ����� � �����</a>
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



<? //**********************  ���������� ������
if($params['action']=='addNewFolder') { ?>

<? //**********************  //���������� ������ 

}else{ //**********************  �������� ������ ?>

<div class="rightPanelBorder">&nbsp;</div>

<? /*
<div class="languagesTabs">
	<span <?
	if($order['manual']=='0'){
		echo "class=\"active\"";
	}else{?>onclick="getData(window.location.pathname+'/<?=$paramsString?>', <?
	?>'orderStatus', 'all')"<? } ?> >����� ��������������</span>
	<span <?
	if($order['manual']=='1'){
		echo "class=\"active\"";
	}else{?>onclick="getData(window.location.pathname+'/<?=$paramsString?>', <?
	?>'orderStatus', 'all')"<? } ?> >����� ������</span>
</div>
<div style="float:none;clear:both;"></div>
*/ ?>

<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">

	<div class="ui-state-default-2 connectedSortable" id="">
	<div class="div_myitemname" style="padding-top: 0px;">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="20" style="font-weight:bold;">�</td>
			<td height="34" width="50">&nbsp;</td>
			<td height="34" width="180" style="font-weight:bold;">��������</td>
			<td height="34" width="100" style="font-weight:bold;" align="center">
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/price.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="50" style="font-weight:bold;" align="center">
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/inbasket.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="70" style="font-weight:bold;" align="center">%</td>
			<td height="34" width="120" style="font-weight:bold;" align="center">
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/price-discount.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="100" align="">
			<img src="<?=$GLOBALS['adminBase']?>/template/images/green/icons/sum.gif"
			width="16" height="16" border="0" align="center" style="margin-right:5px;cursor:pointer;margin-top:5px;" />
			</td>
			<td height="34" width="">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20"><a href="javascript:" title="��������: ������������� ����">&nbsp;</a></td>
			<!--<td height="34" width="20"><a href="javascript:" title="����������� ������"><img src="/adminarea/template/images/green/icons/copy.gif" id="imgoptions_105" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="clone_myitemblock('105')"></a></td>-->
			<td height="34" width="20"><? if($item['includeComments']=='1'){ ?>
				<img src="<?=$GLOBALS['adminBase']?>/template/images/green/myitemname_popup/comments.gif"
				id="imgcomments_<?=$item['id']?>" width="16" height="16" border="0" align="right" style="margin-right:5px;cursor:pointer;margin-top:5px;" onclick="show_myitemblock('div_myitemname_105');hide_idc('105')"><? } ?>
			</td>
			<td height="34" width="20">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
		</tr></table>
	</div></div>
<? //echo "<pre>"; print_r($items); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? //echo "<pre>orderStatuses:"; print_r($orderStatuses); echo "</pre>"; ?>
<? if(is_array($items)){ $count=1; foreach($items as $item){
$lnk = false;
if($item['folder']=='1' && $titles['0']!='static') { //���������� �����������  ?>

<? }else{ //���������� �������
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
			<td height="34" width="100" align="center"><?=$item['price']?></td>
			<td height="34" width="50" align="center"><input type="number" style="width:45px;height:30px;" min="1" step="1"
			max="1000" id="qtty_<?=$item['id']?>" value="<?=$item['qtty']?>" onchange="__ao_changeQtty(this)"></td>
			<td height="34" width="70" style="font-weight:bold;" align="center">---</td>
			<td height="34" width="120" style="font-weight:bold;" align="center">---<?=$item['item']['priceDiscount']?></td>
			
			<?  // ����� ����� ������� �������
			$sum = $item['price'] * $item['qtty'];
			?>
			<td height="34" width="100" style="font-weight:bold;" align=""><?=$sum?></td>
			
			<td height="34" width="">&nbsp;</td>
			<td height="34" width="20">&nbsp;</td>
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
<? $count++; }}} ?>
</div>
<script>
//*********************************************************
function prepareAddNewGoodIntoOrder(orderId, parents){
	//var paction =  "ajax=addNewGoodIntoOrder";
	var paction =  "ajax=prepareAddNewGoodIntoOrder";
	paction += "&orderId="+orderId;
	paction += "&parents="+parents;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			stopPreloader();
			document.getElementById("popup_title").innerHTML = "����� ������ ��� ���������� � �����";
			$("#popup_cont").empty();
			$("#popup_cont").append(html);
			__popup({"width":"500","height":"auto","onclose":function(){showAssembly(orderId)},"noclose":true});
		}
	});
}
//ajax=addNewGoodIntoOrder,orderId=<?=$params['orderId']?>
//*********************************************************

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

