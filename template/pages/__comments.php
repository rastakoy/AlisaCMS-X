<div class="ui-state-default-3 ui-sortable" id="myitems_sortable">
<? //echo "<pre>"; print_r($option); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($items); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($parentNotice); echo "</pre>"; ?>
<? //echo "<pre>comments:"; print_r($comments); echo "</pre>"; ?>
<?
$thumbWidth = '44';
$thumbHeight = '33';
$divHeight = "36";
$tdHeight = "34";
?>
<? if(is_array($comments)){ foreach($comments as $comment){
if($item['tumb']['0']['name']){
	$lnk = $classImages->createImageLink("../loadimages", $thumbWidth."x".$thumbHeight, $item['tumb']['0']['name']);
}
?>
<div class="ui-state-default-2 connectedSortable"
id="prm_<?=$params['orderId']?>,<?=$user['id']?>">
	<div class="div_myitemname" style="padding-top: 0px;height:auto;"
	onclick="">
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<td height="34" width="" style="padding:5px;">
			<div style="border-bottom:solid 1px #CCCCCC;width:250px;padding-bottom:5px;margin-bottom:5px;
			font-weight:bold;"><?=$comment['name']?></div>
			<div id="comment_<?=$comment['id']?>"><?=$comment['comment']?></div>
			<div style="border-bottom:solid 1px #CCCCCC;width:250px;padding-bottom:5px;margin-bottom:5px;">
			</div>
			<a href="javascript:" onclick="replyComment('<?=$comment['id']?>')">Ответить</a> &nbsp;
			<a href="javascript:" onclick="prepareEditComment('<?=$comment['id']?>')">Редактировать</a> &nbsp;
			<a href="javascript:" onclick="removeComment('<?=$comment['id']?>')" style="color:red;">Удалить</a></td>
			<td height="34" width="20">&nbsp;</td>
		</tr></table>
	</div>
</div>
<? }} ?>
</div>
<? //echo "<pre>"; print_r($params); echo "</pre>"; ?>
<script>
//*********************************************************
function prepareEditComment(cId){
	var txt = document.getElementById("comment_"+cId).innerHTML;
	var inner = "<textarea style=\"width:100%;height:100px;margin-bottom:10px;\">"+txt+"</textarea>";
	inner += "<button onclick=\"editComment('"+cId+"')\">Редактировать</button>"
	document.getElementById("comment_"+cId).innerHTML = inner;
}
//*********************************************************
function editComment(cId){
	var txt = document.getElementById("comment_"+cId).getElementsByTagName("textarea")[0].value;
	//console.log(txt);
	var paction =  "ajax=editComment";
	paction += "&commentId="+cId;
	paction += "&reply="+encodeURIComponent(txt);
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			stopPreloader();
		}
	});
}
//*********************************************************
</script>