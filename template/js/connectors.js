//************************************************
function changeConnectorTable(obj, fieldId){
	var table = obj.parentNode.parentNode.parentNode.parentNode;
	for(var j=table.rows.length-1; j>0; j--){
		table.rows[j].parentNode.removeChild(table.rows[j]);
	}
	if(obj.value==''){
		return false;
	}
	var paction = "ajax=changeConnectorTable";
	paction += "&table="+obj.value;
	paction += "&fieldId="+fieldId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			var data = eval("("+html+")");
			//console.log(data);
			var table = document.getElementById("fieldDataSubtype_int_connector").parentNode.parentNode.parentNode.parentNode;
			if(data=="error"){
				var row = table.insertRow();
				var inner = "<td colspan=\"2\" align=\"center\" height=\"30\">";
				inner += "<b>Внимание! К этой таблице нельзя подсоединить выбранный тип коннектора</b></td>";
				row.innerHTML = inner;
				return false;
			}
			for(var j in data){
				var row = table.insertRow();
				var inner = "<td height=\"30\" width=\"187\" valign=\"top\" style=\"padding-top:10px;\">";
				inner += data[j].name;
				inner += "</td><td valign=\"top\" style=\"padding-top:5px;\">";
				inner += "<select onchange=\"changeConnectorFields(this)\" id=\"intConnector_"+j+"\" ";
				inner += "style=\"width:180px;height:25px;\" ><option value=\"\" >Не выбрано</option>";
				for(var jj in data[j].values){
					inner += "<option value=\""+(data[j].values[jj].id)+"\">"+(data[j].values[jj].name)+"</option>";
				}
				inner += "</select> <input type=\"checkbox\"> сделать условием";
				inner += "</td>";
				row.innerHTML = inner;
			}
		}
	});
}
//************************************************
function changeConnectorFields(selObj){
	console.log("changeConnectorFields");
}
//************************************************
function toggleSelectorDisable(checkObj){
	var id = checkObj.id.replace(/^.*_/gi, '');
	document.getElementById("intConnector_"+id).disabled = ((checkObj.checked)?true:false);
}
//************************************************


















