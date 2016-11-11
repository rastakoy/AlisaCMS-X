//************************************************
function constructBranch(option, data, parent){
	//alert("filters");
	//console.log(JSON.stringify(data));
	var inner = "<ul>";
	for(var j in data){
		if(data[j].children>0){
			inner += "<li id=\"left_"+option+"_"+data[j].id+"\">";
			inner += "<a onclick=\"openLeftBranch('"+option+"', '"+data[j].id+"')\" href=\"javascript:\">";
			//alert(JSON.stringify(data[j].openBranch));
			if(data[j].openBranch){
				inner += "<img src=\"/adminarea/template/tree/minus.jpg\" align=\"absmiddle\"></a>";
			}else{
				inner += "<img src=\"/adminarea/template/tree/plus.jpg\" align=\"absmiddle\"></a>";
			}
			if(data[j].includeComments=='1'){
				inner += "<img src=\"/adminarea/template/tree/hascomment.gif\" align=\"absmiddle\">";
			}
			inner += "<a onclick=\"getData('/adminarea/?option="+option+",parents="+data[j].parents+"');addLeftBranchRed(this);return false;\" ";
			inner += "href=\"/adminarea/?option="+option+",parents="+data[j].parents+"\">"+data[j].name+"</a>";
			if(data[j].openBranch){
				var subData = data[j].openBranch.data;
				var subInner = constructBranch(option, subData, data[j].id);
				//alert(subInner);
				inner += subInner;
			}
			inner += "</li>";
		}else{
			inner += "<li><img src=\"/adminarea/template/tree/4x4_";
			//alert("/adminarea/notices/"+data[j].href+" ::: "+gurl);
			//if(RegExp)
			prega = "/adminarea/?option="+option+",parents="+data[j].parents;
			//if(gurl == "/adminarea/notices/"+data[j].href){
			if(gurl.match(RegExp(prega, 'gi'))){
				inner += "red.gif";
			}else{
				inner += "blue.gif";
			}
			inner += "\" align=\"absmiddle\">";
			if(data[j].includeComments=='1'){
				inner += "<img src=\"/adminarea/template/tree/hascomment.gif\" align=\"absmiddle\">";
			}
			inner += "<a onclick=\"getData('/adminarea/?option="+option+",parents="+data[j].parents+"');addLeftBranchRed(this);return false;\" ";
			inner += "href=\"/adminarea/?option="+option+",parents="+data[j].parents+"\">"+data[j].name+"</a></li>";
		}
	}
	inner += "</ul>";
	return inner;
}
//************************************************
function testForConformance(table, filter){
	var paction = "ajax=testForConformance";
	if(!table && document.getElementById("internalTableSelect")){
		paction += "&table="+document.getElementById("internalTableSelect").value;
	}else{
		paction += "&table="+table;
	}
	if(!filter && document.getElementById("filterSelect")){
		paction += "&filter="+document.getElementById("filterSelect").value;
	}else{
		paction += "&filter="+filter;
	}
	//console.log(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			//document.getElementById("popup_cont").innerHTML = html;
			//__popup({"width":"500","height":"auto"});
			//return false;
			html = (html=='')?'{}':html;
			var data = eval("("+html+")");
			//constructConformanceTable(data);
			document.getElementById("popup_cont").innerHTML = constructConformanceTable(data);
			//$("#popup_cont").empty();
			//$("#popup_cont").append(html);
			__popup({"width":"500","height":"auto"});
			$("#popup_cont").css("font-size", "12px");
			stopPreloader();
		}
	});
}
//************************************************
function constructConformanceTable(data){
	var inner = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
	var repare = false;
	var surroundings = false;
	for(var j in data.data){
		var tr = data.data[j];
		inner += "<tr>";
			inner += "<td height=\"30\" width=\"150\"><b>"+tr['name']+"</b></td>";
			inner += "<td height=\"30px;\">";
			if(tr.conformance=='1'){
				inner += "<img src=\"/adminarea/template/images/green/input_false.gif\" align=\"absmiddle\" style=\"margin-right:3px;\">";
				inner += "отсутствие поля";
				inner += "</td><td>";
				inner += "<img src=\"/adminarea/template/images/green/repare.gif\" ";
				inner += "style=\"cursor:pointer;\"";
				
				inner += " >";
				inner += "</td>";
				repare = true;
			}else if(tr.conformance=='2'){
				inner += "<img src=\"/adminarea/template/images/green/input_false.gif\" align=\"absmiddle\" style=\"margin-right:3px;\">";
				inner += "несоответствие типа данных";
				inner += "</td><td>";
				inner += "<img src=\"/adminarea/template/images/green/repare.gif\" ";
				inner += "style=\"cursor:pointer;\"";
				
				inner += " >";
				inner += "</td>";
				repare = true;
				surroundings = true;
			}else if(tr.conformance=='3'){
				inner += "<img src=\"/adminarea/template/images/green/input_false.gif\" align=\"absmiddle\" style=\"margin-right:3px;\">";
				inner += "В указанной таблице не найдено поле порта";
				inner += "</td><td>";
				inner += "<img src=\"/adminarea/template/images/green/repare.gif\" ";
				inner += "style=\"cursor:pointer;\"";
				
				inner += " >";
				inner += "</td>";
				repare = true;
				surroundings = true;
			}else if(tr.conformance=='4'){
				inner += "<img src=\"/adminarea/template/images/green/input_false.gif\" align=\"absmiddle\" style=\"margin-right:3px;\">";
				inner += "В указанной таблице не найдено конфигуратора коннектора";
				inner += "</td><td>";
				inner += "<img src=\"/adminarea/template/images/green/repare.gif\" ";
				inner += "style=\"cursor:pointer;\"";
				
				inner += " >";
				inner += "</td>";
				repare = true;
				surroundings = true;
			}else if(tr.conformance=='5'){
				inner += "<img src=\"/adminarea/template/images/green/input_false.gif\" align=\"absmiddle\" style=\"margin-right:3px;\">";
				inner += "В указанном конфигураторе не найден коннектор";
				inner += "</td><td>";
				inner += "<img src=\"/adminarea/template/images/green/repare.gif\" ";
				inner += "style=\"cursor:pointer;\"";
				
				inner += " >";
				inner += "</td>";
				repare = true;
				surroundings = true;
			}else if(tr.conformance=='6'){
				inner += "<img src=\"/adminarea/template/images/green/input_false.gif\" align=\"absmiddle\" style=\"margin-right:3px;\">";
				inner += "Не хватает полей для связи с коннектором";
				inner += "</td><td>";
				inner += "<img src=\"/adminarea/template/images/green/repare.gif\" ";
				inner += "style=\"cursor:pointer;\"";
				
				inner += " >";
				inner += "</td>";
				repare = true;
				surroundings = true;
			}else{
				inner += "<img src=\"/adminarea/template/images/green/input_ok.gif\" align=\"absmiddle\" style=\"margin-right:3px;\">";
				inner += "</td><td>";
				inner += "</td>";
			}
		inner += "</tr>";
	}
	if(repare){
		if(surroundings){
			inner += "<tr><td height=\"45\">&nbsp;</td><td>";
			inner += "<font color=red>Убедитесь, что вы решили изменить параметры среды!</font>";
			inner += "</td>";
		}
		
		inner += "<tr><td height=\"45\">&nbsp;</td><td>";
		inner += "<button onclick=\"repareTableFields('"+data.table+"', '"+data.filter+"')\">Исправить всё</button> ";
		inner += "<button onclick=\"__popup_close()\">Отмена</button>";
		inner += "</td>";
	}else{
		inner += "<tr><td>&nbsp;</td><td>";
		inner += "<button onclick=\"__popup_close()\">ОК</button> ";
		inner += "</td>";
	}
	inner += "</table>";
	return inner;
}
//************************************************
function repareTableFields(table, filter){
	//console.log(table+":"+filter);
	var paction = "ajax=repareTableFields";
	paction += "&table="+table;
	paction += "&filter="+filter;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
		}
	});
}
//************************************************

//************************************************









