<h2>���������� ��������</h2>
<? //echo "<pre>"; print_r($filter); echo "</pre>"; ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="150" height="30">��������</td>
    <td><input type="text" id="filterName" value="<?=$filter['name']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">�������� ����������</td>
    <td><input type="text" id="filterNameUkr" value="<?=$filter['name_ukr']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">����</td>
    <td><input type="text" id="filterLink" value="<?=$filter['link']?>" /></td>
  </tr>
  <tr>
    <td height="30">��� �������</td>
    <td><select id="filterType">
		<option value="1" <? if($filter['filtertype']=='1'){ ?>selected<? } ?>>������� �������</option>
		<option value="2" <? if($filter['filtertype']=='2'){ ?>selected<? } ?>>�������� � ����������� ������</option>
		<option value="3" <? if($filter['datatype']=='3'){ ?>selected<? } ?>>���������� ����</option>
		<option value="4" <? if($filter['datatype']=='4'){ ?>selected<? } ?>>������</option>
		<option value="5" <? if($filter['datatype']=='5'){ ?>selected<? } ?>>������ �������</option>
	</select></td>
  </tr>
  <tr>
    <td height="30">��� ������</td>
    <td><select onchange="getFilterFieldType(this.value)" id="filterDatatype">
		<option value="1" <? if($filter['datatype']=='1'){ ?>selected<? } ?>>����� �����</option>
		<option value="2" <? if($filter['datatype']=='2'){ ?>selected<? } ?>>������� �����</option>
		<option value="3" <? if($filter['datatype']=='3'){ ?>selected<? } ?>>������</option>
	</select></td>
  </tr>
  <tr>
    <td height="30">���� � ���� ������</td>
    <td><select id="sel_fieldname"><? foreach($filter['fields'] as $field) { ?>
		<option value="<?=$field?>" <? if($field==$filter['fieldname']){ ?>selected<? } ?>><?=$field?></option>
	<? } ?></select></td>
  </tr>
  <tr>
    <td height="30">������������ � ����������</td>
    <td><select id="sel_isprev">
		<option value="0" <? if($filter['isprev']=='0'){ ?>selected<? } ?>>�� ������������</option>
		<option value="1" <? if($filter['isprev']=='1'){ ?>selected<? } ?>>������������</option>
	</select></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><button onclick="saveFilterField()">���������</button>&nbsp;&nbsp;
	<button onclick="__css_itemShowCSS_close()">��������</button></td>
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
				alert("������ ��������������");
			}
		}
	});
}
//*********************************

//*********************************

//*********************************
</script>