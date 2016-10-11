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
function changeConnectorFields(selObj, fieldId){
	//console.log(selObj);
	var paction = "ajax=changeConnectorFields";
	paction += "&fieldId="+fieldId;
	paction += "&objectId="+selObj.id;
	if(selObj.className=="connectorPositionIndex_"+fieldId){
		var objs = document.getElementsByClassName("connectorPositionIndex_"+fieldId);
		var indexes = "{";
		for(var j=0; j<objs.length; j++){
			var obj = objs[j];
			indexes += "\""+j+"\":\""+obj.value+"\",";
			if(obj==selObj) break;
		}
		indexes = indexes.replace(/,$/gi, '')+"}";
		paction += "&indexes="+indexes;
	}else{
		var indexes = "{";
		for(var j=0; j<selObj.id.replace(/intConnector_/gi, '')*1+1; j++){
			//console.log("intConnector_"+j);
			indexes += "\""+j+"\":\""+document.getElementById("intConnector_"+j).value+"\",";
		}
		indexes = indexes.replace(/,$/gi, '')+"}";
		paction += "&indexes="+indexes;
	}
	//paction += "&indexValue="+selObj.value;
	//console.log(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			var data = eval("("+html+")");
			//console.log(data);
			for(var j in data.data){
				if(j>data.index){
					if(document.getElementById(data.data[j].field)){
						var inner = "<option value=\"\">--"+data.data[j].fieldName+"--</option>";
					}else{
						var inner = "<option value=\"\">Не выбрано</option>";
					}
					for(var jj in data.data[j].values){
						inner += "<option value=\""+(data.data[j].values[jj].id)+"\">"+(data.data[j].values[jj].name)+"</option>";
					}
					//console.log(data.data[j].field);
					//console.log(inner);
					if(document.getElementById(data.data[j].field)){
						document.getElementById(data.data[j].field).innerHTML = inner;
						blinkObject(document.getElementById(data.data[j].field));
					}else{
						document.getElementById("intConnector_"+j).innerHTML = inner;
						blinkObject(document.getElementById("intConnector_"+j));
					}
				}
			}
		}
	});
}
//************************************************
var blinkObjects = {};
var blinkInterval = 300;
var blinkCount = 3;
var blinkColor = "#F99488";
function blinkObject(obj, count){
	if(!count) count = 0;
	obj.style.backgroundColor = ((obj.style.backgroundColor!='')?"":blinkColor);
	if(count<blinkCount) setTimeout("blinkObject(document.getElementById('"+(obj.id)+"'), "+(count+1)+")", blinkInterval);
}
//************************************************
function toggleSelectorDisable(checkObj){
	var id = checkObj.id.replace(/^.*_/gi, '');
	document.getElementById("intConnector_"+id).disabled = ((checkObj.checked)?true:false);
}
//************************************************


















