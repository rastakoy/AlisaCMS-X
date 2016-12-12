<?
$field['config'] = $admin->iconvArray($field['config']);
$field = $classFilters->makeConnectors($field);
//echo "<pre>"; print_r($field); echo "</pre>";
//******************************************
$count = 0;
$start = -1;
foreach($field['config']['connector']['data'] as $key=>$selector){
	$defaults[$key]['fieldName'] = $selector['fieldName'];
	$defaults[$key]['field'] = $selector['field'];
	$defaults[$key]['default'] = $selector['default'];
	$defaults[$key]['name'] = $selector['values'][$selector['default']]['name'];
	if(!preg_match("/^[0-9]*$/", $selector['default']) || $selector['default']==''){
		if($start==-1){ $start=$key; }
		$count++;
	}
	$vars .= "\"$key\":\"$selector[field]\",";
	$indexes[$key] = $item[$selector['field']];
}
$vars = preg_replace("/,$/", '', $vars);
//echo "<pre>"; print_r($defaults); echo "</pre>";
//******************************************
$data = $field['config']['connector']['data'];
//echo "<pre>"; print_r($indexes); echo "</pre>";
foreach($indexes as $key=>$index){
	$data[$key]['default'] = $index;
}
$array['table'] = $field['config']['connector']['table'];
$connector = $classFilters->changeConnectorTable($array, false, $data);
//echo "<pre>"; print_r($connector); echo "</pre>";
//******************************************
$field['config']['connector'] = $connector;
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td><? foreach($defaults as $key=>$defaultItem){ if($key>=$start){ ?>
	<select id="<?=$defaultItem['field']?>" style="width:140px;height:25px;" class="connectorPositionIndex_<?=$field['id']?>"
	onchange="changeConnectorFields(this, '<?=$field['id']?>')">
	<option value=""><? if($count!='1'){ ?>--<?=$defaultItem['fieldName']?>--<? } ?></option>
	<? foreach($field['config']['connector']['data'][$key]['values'] as $k=>$value){ ?>
		<option value="<?=$value['id']?>" <? if($value['id']==$item[$defaultItem['field']]) { echo "selected"; } ?> ><?=$value['name']?></option>
	<? } ?>
	</select> <? if($key < count($defaults)-1){ ?> -› <? } ?>
	<? }else{ ?>
	<input id="<?=$defaultItem['field']?>" type="hidden" value="<?=$defaultItem['default']?>" class="connectorPositionIndex_<?=$field['id']?>" />
	<? }} ?></td>
</tr></table>

<script>
//************************************************
var connector_<?=$field['id']?> = {<?=$vars?>};
//console.log(connector_<?=$field['id']?>);
//************************************************
</script>