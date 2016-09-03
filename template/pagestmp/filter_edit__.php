<h2>Управление фильтром</h2>
<? //echo "<pre>"; print_r($filter); echo "</pre>"; ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="150" height="30">Название</td>
    <td><input type="text" id="filterName" value="<?=$filter['name']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">Название украинское</td>
    <td><input type="text" id="filterNameUkr" value="<?=$filter['name_ukr']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">Путь</td>
    <td><input type="text" id="filterLink" value="<?=$filter['link']?>" /></td>
  </tr>
  <tr>
    <td height="30">Тип фильтра</td>
    <td><select id="filterType">
		<option value="1" <? if($filter['filtertype']=='1'){ ?>selected<? } ?>>Двойной бегунок</option>
		<option value="2" <? if($filter['filtertype']=='2'){ ?>selected<? } ?>>Селектор с добавлением данных</option>
		<option value="3" <? if($filter['datatype']=='3'){ ?>selected<? } ?>>Выпадающее меню</option>
		<option value="4" <? if($filter['datatype']=='4'){ ?>selected<? } ?>>Флажок</option>
		<option value="5" <? if($filter['datatype']=='5'){ ?>selected<? } ?>>Группа флажков</option>
	</select></td>
  </tr>
  <tr>
    <td height="30">Тип данных</td>
    <td><select onchange="getFilterFieldType(this.value)" id="filterDatatype">
		<option value="1" <? if($filter['datatype']=='1'){ ?>selected<? } ?>>Целое число</option>
		<option value="2" <? if($filter['datatype']=='2'){ ?>selected<? } ?>>Дробное число</option>
		<option value="3" <? if($filter['datatype']=='3'){ ?>selected<? } ?>>Строка</option>
	</select></td>
  </tr>
  <tr>
    <td height="30">Поле в базе данных</td>
    <td><select id="sel_fieldname"><? foreach($filter['fields'] as $field) { ?>
		<option value="<?=$field?>" <? if($field==$filter['fieldname']){ ?>selected<? } ?>><?=$field?></option>
	<? } ?></select></td>
  </tr>
  <tr>
    <td height="30">Использовать в предпоказе</td>
    <td><select id="sel_isprev">
		<option value="0" <? if($filter['isprev']=='0'){ ?>selected<? } ?>>Не использовать</option>
		<option value="1" <? if($filter['isprev']=='1'){ ?>selected<? } ?>>Использовать</option>
	</select></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><button onclick="saveFilterField()">Сохранить</button>&nbsp;&nbsp;
	<button onclick="__css_itemShowCSS_close()">Отменить</button></td>
  </tr>
</table>
<script>
function getFilterFieldType(type){
	paction =  "ajax=getFilterFieldType&type="+type+"&parent=<?=$filter['parent']?>&id=<?=$filter['id']?>";
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			document.getElementById("sel_fieldname").innerHTML = "";
			var inner = "";
			for(var j in data){
				inner += "<option value=\""+data[j]+"\">"+data[j]+"</option>";
			}
			document.getElementById("sel_fieldname").innerHTML = inner;
		}
	});
}
//*********************************
function saveFilterField(){
	var paction =  "ajax=saveFilterField";
	paction += "&filterId=<?=$filter['id']?>";
	paction += "&filterName="+encodeURIComponent(document.getElementById("filterName").value);
	paction += "&filterNameUkr="+encodeURIComponent(document.getElementById("filterNameUkr").value);
	paction += "&filterLink="+document.getElementById("filterLink").value;;
	paction += "&filterType="+document.getElementById("filterType").value;
	paction += "&filterDatatype="+document.getElementById("filterDatatype").value;
	paction += "&filterFieldName="+document.getElementById("sel_fieldname").value;
	paction += "&filterIsprev="+document.getElementById("sel_isprev").value;
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
			}else{
				alert("Ошибка редактирования");
			}
		}
	});
}
//*********************************

//*********************************

//*********************************
</script>