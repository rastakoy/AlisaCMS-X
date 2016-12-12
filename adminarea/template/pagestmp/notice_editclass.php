<h2>Управление группой</h2>
<? //echo "<pre>"; print_r($notice); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($filters); echo "</pre>"; ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="150" height="30">Название</td>
    <td><input type="text" id="noticeName" value="<?=$notice['name']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">Путь</td>
    <td><input type="text" id="noticeLink" value="<?=$notice['link']?>" /></td>
  </tr>
  <? if($notice['parent']=='0'){ ?>
  <tr>
    <td width="150" height="30">Класс</td>
    <td><input type="text" id="noticeClass" value="<?=$notice['css']?>" /></td>
  </tr>
  <? } ?>
  <tr>
    <td width="150" height="30">Тип фильтра</td>
    <td><select id="noticeFilter"><option value=""></option><?
	foreach($filters as $filter){ ?>
		<option value="<?=$filter['id']?>" <? if($filter['id']==$notice['filter']){ ?>selected<? } ?> ><?=$filter['name']?></option>
	<? } ?></select></td>
  </tr>
  
  <tr>
    <td height="30">&nbsp;</td>
    <td><button onclick="saveNoticeFolder()">Сохранить</button>&nbsp;&nbsp;
	<button onclick="__css_itemShowCSS_close()">Отменить</button></td>
  </tr>
</table>
<script>
function saveNoticeFolder(){
	var paction =  "ajax=saveNoticeFolder";
	paction += "&noticeId=<?=$notice['id']?>";
	paction += "&noticeName="+encodeURIComponent(document.getElementById("noticeName").value);
	paction += "&noticeLink="+document.getElementById("noticeLink").value;
	paction += "&noticeFilter="+document.getElementById("noticeFilter").value;
	if(document.getElementById("noticeClass")){
		paction += "&noticeClass="+document.getElementById("noticeClass").value;
	}
	//alert(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			if(data.return=='ok'){
				__css_itemShowCSS_close();
				getLeftBranch('notices');
			}else{
				alert("Ошибка редактирования");
			}
		}
	});
}
</script>