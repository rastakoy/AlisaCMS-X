//********************************
function getOrderStatuses(){
	var paction = "ajax=getOrderStatuses";
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			var allData = eval("("+html+")");
			var data = allData['data'];
			var inner = "";
			inner += "<div style=\"padding:10px;\" id=\"\">";
			inner += "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"  width=\"100%\" >";
			inner += "<tr style=\"background-color:#FFF;\">";
				inner += "<td width=\"20\">&nbsp;</td>";
				inner += "<td style=\"padding-left:5px;\" width=\"150\"><b>Название</b></td>";
				inner += "<td width=\"250\"><b>Убрать из временного хранилища</b></td>";
				inner += "<td width=\"100\"><b>&nbsp;&nbsp;Цвет</b></td>";
				
				inner += "<td>&nbsp;</td>";
				inner += "<td>&nbsp;</td>";
			
			inner += "</tr></table></div>";
			inner += "<div style=\"padding:10px;\" id=\"divGetOrderStatuses\">";
			for(var j in data){
				//console.log(data[j]);
				inner += "<div style=\"height:32px;\" id=\"subOS_"+data[j].id+"\">";
				inner += "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"  width=\"100%\" >";
				inner += "<tr style=\"background-color:#FFF;\">";
					inner += "<td class=\"tdGlobalSettings\" width=\"20\">";
					if(data[j].link!='new' && data[j].link!='cancel' && data[j].link!='adding'){
						inner += "<img src=\"/adminarea/template/images/green/myitemname_popup/glaz";
						if(data[j].visible=='0'){
							inner += "_no";
						}
						inner += ".gif\" ";
						inner += "id=\"glaz_"+data[j].id+"\" width=\"16\" height=\"16\" border=\"0\" style=\"curdor:pointer;\" ";
						inner += "onclick=\"toggleVisible('orderstatuses','"+data[j].id+"', 'visible');\">";
					}
					inner += "</td>";
					inner += "<td class=\"tdGlobalSettings\" width=\"150\">"+data[j].name+"</td>";
					//**********************
					inner += "<td class=\"tdGlobalSettings\" width=\"250\">";
					if(data[j].link!='new' && data[j].link!='cancel' && data[j].link!='adding'){
						inner += "<img onclick=\"setGoodFromTMPToClient(this)\" id=\"sgfTMPtc_"+data[j].id+"\" ";
						inner += " src=\""+__GLOBALS['adminBase']+"/template/images/green/myitemname_popup/checkbox";
						if(data[j].tmpStore=='1'){
							inner += "_checked";
						}
						inner += ".gif\" align=\"absmiddle\" />";
					}
					inner += "&nbsp;</td>";
					//**********************
					inner += "<td class=\"tdGlobalSettings\"><input type=\"color\" value=\""+data[j].color+"\" ";
					inner += "id=\"sosc_"+data[j].id+"\" onchange=\"setOrderStatusColor(this)\"></td>";
					//**********************
					inner += "<td class=\"tdGlobalSettings\" width=\"30\">";
					if(!data[j].exception){
						inner += "<img src=\""+__GLOBALS['adminBase']+"/template/images/green/myitemname_popup/edit_item.gif\" align=\"absmiddle\" ";
						inner += "style=\"cursor:pointer;\" onclick=\"editOrderStatus('"+(data[j].id)+"')\" />";
					}
					inner += "&nbsp;</td>";
					//**********************
					inner += "<td class=\"tdGlobalSettings\" width=\"30\">";
					if(!data[j].exception){
						inner += "<img src=\""+__GLOBALS['adminBase']+"/template/images/green/myitemname_popup/delete_item.gif\" align=\"absmiddle\" />";
					}
					inner += "&nbsp;</td>";
					//**********************
				inner += "</tr></table></div>";
			}
			inner += "</div>";
			inner += "<div style=\"padding:10px;\" id=\"\">";
			inner += "<input type=\"hidden\" id=\"newOrderStatusId\" />";
			inner += "<input type=\"text\" style=\"width:150px;height:25px;\" placeholder=\"Название\" id=\"newOrderStatusName\" />&nbsp;&nbsp;";
			inner += "<input type=\"text\" style=\"width:150px;height:25px;\" placeholder=\"Идентификатор\" id=\"newOrderStatusLink\" />&nbsp;&nbsp;";
			inner += "<input type=\"button\" style=\"width:150px;height:25px;\" id=\"newOrderStatusButton\" onclick=\"saveOrderStatus()\"";
			inner += "value=\"Добавить состояние\" />";
			inner += "</div>";
			document.getElementById("popup_cont").innerHTML = inner;
			document.getElementById("popup_title").innerHTML = "Управление статусами заказов";
			
			var preloaderParams = false;
			preloaderParams = {
				'callback':function(){
					//alert("Тестирование");
				}
			}
			inputPreloader(document.getElementById("newOrderStatusName"), 'testNewOrderStatusName', preloaderParams);
			
			var preloaderParams = false;
			preloaderParams = {
				'callback':function(){
					//alert("Тестирование");
				}
			}
			inputPreloader(document.getElementById("newOrderStatusLink"), 'testNewOrderStatusLink', preloaderParams);
			
			stopPreloader();
			__popup({"width":"600","onclose":function(){if(__PARAMS.option=='orders'){getData("?option=orders");}}});
			
			$( "#divGetOrderStatuses" ).sortable({
				//cursorAt: { left: -20 },
				//items: "div:not(.dmulti2)",
				//cancel: ".dmulti2",
				start: function(){
					
				},
				update: function() {
					saveOrderStatusesPriors();
				},
				sort: function() {
					
				},
				stop: function( event, ui ) {
					
				}
			});
		}
	});
}
//********************************
function setGoodFromTMPToClient(obj){
	var idPrefix = obj.id.replace(/_[0-9]*$/gi, '_');
	var id = obj.id.replace(/^.*_/gi, '');
	var aobjs = document.querySelectorAll( 'img[id^="' + idPrefix );
	for(var j=0; j<aobjs.length; j++){
		var aobj = aobjs[j];
		if(aobj!=obj){
			aobj.src = aobj.src.replace(/_checked\.gif$/gi, '.gif');
		}
	}
	//console.log(aobjs);
	var paction = "ajax=setGoodFromTMPToClient";
	paction += "&id="+id;
	if(obj.src.match(/_checked\.gif$/)){
		obj.src = obj.src.replace(/_checked\.gif$/gi, '.gif');
		paction += "&value=0";
	}else{
		obj.src = obj.src.replace(/\.gif$/gi, '_checked.gif');
		paction += "&value=1";
	}
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			//getOrderStatuses();
		}
	});
}
//********************************
function setOrderStatusColor(obj){
	var id = obj.id.replace(/^.*_/gi, '');
	var paction = "ajax=setOrderStatusColor";
	paction += "&color="+obj.value;
	paction += "&id="+id;
	//console.log(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
		}
	});
}
//********************************
function saveOrderStatus(){
	var paction = "ajax=saveOrderStatus";
	paction += "&id="+document.getElementById("newOrderStatusId").value;
	if(document.getElementById("newOrderStatusName").value=='' ||
	!document.getElementById("newOrderStatusName").className.match(/ ?inputok ?/gi)){
		document.getElementById("newOrderStatusName").style.backgroundColor = '#FDDDD9';
		return false;
	}
	paction += "&name="+encodeURIComponent(document.getElementById("newOrderStatusName").value);
	if(document.getElementById("newOrderStatusLink").value=='' ||
	!document.getElementById("newOrderStatusLink").className.match(/ ?inputok ?/gi)){
		document.getElementById("newOrderStatusLink").style.backgroundColor = '#FDDDD9';
		return false;
	}
	paction += "&link="+encodeURIComponent(document.getElementById("newOrderStatusLink").value);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			document.getElementById("newOrderStatusId").value = '';
			document.getElementById("newOrderStatusName").className = '';
			document.getElementById("newOrderStatusName").value = '';
			document.getElementById("newOrderStatusLink").className = '';
			document.getElementById("newOrderStatusLink").value = '';
			getOrderStatuses();
		}
	});
}
//********************************
function editOrderStatus(statusId){
	var paction = "ajax=editOrderStatus";
	paction += "&id="+statusId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			var data = eval("("+html+")");
			
			document.getElementById("newOrderStatusButton").value = 'Изменить состояние';
			document.getElementById("newOrderStatusId").value = data['id'];
			
			var nameObj = document.getElementById("newOrderStatusName");
			nameObj.className = (nameObj.className=='')?'inputpreloader inputok':' inputpreloader inputok';
			nameObj.value = data['name'];
			
			var linkObj = document.getElementById("newOrderStatusLink");
			linkObj.className = (linkObj.className=='')?'inputpreloader inputok':' inputpreloader inputok';
			linkObj.value = data['link'];
			
			//document.getElementById("newOrderStatusName").value = '';
			//document.getElementById("newOrderStatusLink").className = '';
			//document.getElementById("newOrderStatusLink").value = '';
			//getOrderStatuses();
		}
	});
}
//********************************
function saveOrderStatusesPriors(){
	var priors = $('#divGetOrderStatuses').sortable('toArray');
	priors = priors.join(',').replace(/subOS_/gi, '');
	var paction = "ajax=saveOrderStatusesPriors";
	paction += "&priors="+priors;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			getOrderStatuses();
		}
	});
}
//********************************
function setGoodFromStoreToTMP(obj){
	var idPrefix = obj.id.replace(/_[0-9]*$/gi, '_');
	var aobjs = document.querySelectorAll( 'img[id^="' + idPrefix );
	for(var j=0; j<aobjs.length; j++){
		var aobj = aobjs[j];
		if(aobj!=obj){
			aobj.src = aobj.src.replace(/_checked\.gif$/gi, '.gif');
		}
	}
	//console.log(aobjs);
	if(obj.src.match(/_checked\.gif$/)){
		obj.src = obj.src.replace(/_checked\.gif$/gi, '.gif');
	}else{
		obj.src = obj.src.replace(/\.gif$/gi, '_checked.gif');
	}
}
//********************************
function setGoodFromClientToStore(obj){
	var idPrefix = obj.id.replace(/_[0-9]*$/gi, '_');
	var aobjs = document.querySelectorAll( 'img[id^="' + idPrefix );
	for(var j=0; j<aobjs.length; j++){
		var aobj = aobjs[j];
		if(aobj!=obj){
			aobj.src = aobj.src.replace(/_checked\.gif$/gi, '.gif');
		}
	}
	//console.log(aobjs);
	if(obj.src.match(/_checked\.gif$/)){
		obj.src = obj.src.replace(/_checked\.gif$/gi, '.gif');
	}else{
		obj.src = obj.src.replace(/\.gif$/gi, '_checked.gif');
	}
}