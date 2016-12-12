//*********************************************************
var lookNewOrders = false;
var newOrdersCount = 0;
function __lookNewOrders(){
	if(lookNewOrders){
			clearInterval(lookNewOrders);
	}
	lookNewOrders = false;
	var paction =  "ajax=lookNewOrders";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			html = (html=='')?'{}':html;
			var data = eval("("+html+")");
			lookNewOrders = setTimeout("__lookNewOrders()", 60000);
			var inner = document.getElementById("rootordersmenu").innerHTML;
			inner = inner.replace(/\([0-9]{1,4}\)/gi, "");
			if(data.count>0 && data.count>newOrdersCount){
				inner = inner.replace(/<\/strong/gi, " ("+data.count+")</strong");
				//console.log(inner);
				document.getElementById("rootordersmenu").innerHTML = inner;
				if(data.sound=='1'){
					inner = "<audio id=\"audio\"><source src=\"";
					inner += __GLOBALS.adminBase+"/template/sounds/money.mp3"
					inner += "\"></audio>";
					document.getElementById("divAudio").innerHTML = inner;
					document.getElementById('audio').play();
				}
			}
			var a = document.getElementById("rootordersmenu").getElementsByTagName("a")[0];
			a.onclick = function(){
				var id = this.getAttribute("href").replace(/\/adminarea\//gi, '');
				id = id.replace(/\/$/gi, '');
				getData(this.getAttribute("href"));
				$(this).blur();
				return false;
			}
			newOrdersCount = data.count;
		}
	});
}
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
			document.getElementById("popup_title").innerHTML = "Выбор товара для добавления в заказ";
			$("#popup_cont").empty();
			$("#popup_cont").append(html);
			__popup({"width":"500","height":"auto","onclose":function(){showAssembly(orderId)},"noclose":true});
		}
	});
}
//*********************************************************
function showAssembly(orderId){
	//__popup({"onclose":false});
	var paction = "ajax=showAssembly";
	paction += "&orderId="+orderId.replace(/№/gi, '');
	//if(goodId){
	//	paction += "&goodId="+goodId;
	//}
	console.log(paction);
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//html = (html=='')?'{}':html;
			//var data = eval("("+html+")");
			//console.log(html);
			stopPreloader();
			$("#popup_cont").empty();
			$("#popup_cont").append(html);
			document.getElementById("popup_title").innerHTML = "Сборка заказа №"+orderId.replace(/№/gi, '');
			__popup({"background-image":"url("+__GLOBALS.adminBase+"/template/images/green/test_background.png)"});
		}
	});
}
//*********************************************************
function addNewGoodIntoOrder(orderId, goodId){
	//console.log("addNewGoodIntoOrder:"+ordrId+":"+itemId);
	var paction = "ajax=addNewGoodIntoOrder";
	if(orderId){
		paction += "&orderId="+orderId.replace(/№/gi, '');
	}
	paction += "&goodId="+goodId;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			data = eval("("+html+")");
			showAssembly(data.orderId);
		}
	});
}
//*********************************************************
function deleteItemFromOrder(orderId, itemId){
	if(confirm("Удалить товар из заказа?")){
		var paction = "ajax=deleteItemFromOrder";
		paction += "&orderId="+orderId.replace(/№/gi, '');
		paction += "&itemId="+itemId;
		startPreloader();
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				console.log(html);
				data = eval("("+html+")");
				showAssembly(data.orderId);
			}
		});
	}
}
//*********************************************************
function changeOrderQtty(obj){
	var arr = obj.id.split("_");
	var paction =  "ajax=changeOrderQtty";
	paction += "&orderId="+arr[2];
	paction += "&itemId="+arr[1];
	paction += "&qtty="+obj.value;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			data = eval("("+html+")");
			showAssembly(data.orderId);
		}
	});
}
//*********************************************************
function getAdminOrder(){
	var paction =  "ajax=getAdminOrder";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			data = eval("("+html+")");
			showAssembly(data.orderId);
		}
	});
}
//*********************************************************
function confirmOrder(orderId){
	var paction =  "ajax=confirmOrder";
	paction += "&orderId="+orderId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			data = eval("("+html+")");
			if(data.errors){
				for(var j in data.errors){
					//console.log("qtty_"+data.errors[j].id+"_"+orderId);
					document.getElementById("qtty_"+data.errors[j].id+"_"+data.orderId).style.backgroundColor = "#fdddd9";
					document.getElementById("qtty_"+data.errors[j].id+"_"+data.orderId).value = data.errors[j].qtty;
					changeOrderQtty(document.getElementById("qtty_"+data.errors[j].id+"_"+data.orderId));
				}
			}else{
				__popup_close();
				getData(window.location.pathname+'/?option=orders,orderStatus='+data.orderStatus);
			}
		}
	});
}
//*********************************************************
function prepareAssociateClientWithOrder(orderId){
	var paction =  "ajax=prepareAssociateClientWithOrder";
	paction += "&orderId="+orderId;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			stopPreloader();
			$("#popup_cont").empty();
			$("#popup_cont").append(html);
			document.getElementById("popup_title").innerHTML = "Выбор пользователя";
			//__popup({"background-image":"url("+__GLOBALS.adminBase+"/template/images/green/test_background.png)"});
			__popup({"width":"500","onclose":function(){showAssembly(orderId)},"noclose":true});
		}
	});
}
//*********************************************************
function associateClientWithOrder(orderId, userId){
	var paction =  "ajax=associateClientWithOrder";
	paction += "&orderId="+orderId;
	paction += "&userId="+userId;
	startPreloader();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			console.log(html);
			data = eval("("+html+")");
			showAssembly(data.orderId);
		}
	});
}
//*********************************************************




