//*************************************
function showBasket(object){
	var preloaderParams = {
		"ajax":"prepareShowBasket",
		"callback":function(){
			__callback_showBasket(data);
		}
	}
	inputPreloader(object, preloaderParams);
	/*document.getElementById("popup_title").innerHTML = "���� �������";
	__popup();
	var paction = "ajax=showBasket";
	//console.log(paction);
	$.ajax({
		type: "POST",
		url: __GLOBALS.ajax,
		data: paction,
		success: function(html) {
			//console.log(html);
			document.getElementById("popup_cont").innerHTML = html;
		}
	});*/
}
//*************************************
function __callback_showBasket(data){
	var obj = document.getElementsByClassName(data.preloaderClas)[0];
	obj.className = obj.className.replace(RegExp(" ?"+data.preloaderClas, "gi"), '');
	obj.onclick = function(){showBasket()};
	obj.innerHTML = "� �������";
}
//*************************************
function addItemIntoOrder(object, itemId){
	var preloaderParams = {
		"ajax":"addItemIntoOrder",
		"qtty":document.getElementById("qttyItem_"+itemId).value,
		"goodId":itemId,
		"callback":function(){
			__callback_addItemIntoOrder(data);
		}
	}
	inputPreloader(object, preloaderParams);
	//console.log(paction);
	//$.ajax({
	//	type: "POST",
	//	url: __GLOBALS.ajax,
	//	data: paction,
	//	success: function(html) {
	//		console.log(html);
	//		//document.getElementById("popup_cont").innerHTML = html;
	//	}
	//});
}
//*************************************
function __callback_addItemIntoOrder(data){
	console.log(data);
	var obj = document.getElementsByClassName(data.preloaderClas)[0];
	obj.className = obj.className.replace(RegExp(" ?"+data.preloaderClas, "gi"), '');
	//obj.onclick = obj.oldClick;
	//obj.innerHTML = obj.oldInner;
	obj.onclick = function(){showBasket()};
	obj.innerHTML = "� �������";
}
//*************************************
function changeOrderQtty(obj){
	var arr = obj.id.split("_");
	var paction =  "ajax=changeOrderQtty";
	paction += "&orderId="+arr[2];
	paction += "&itemId="+arr[1];
	paction += "&qtty="+obj.value;
	console.log(paction);
	$.ajax({
		type: "POST",
		url: __GLOBALS.ajax,
		data: paction,
		success: function(html) {
			console.log(html);
			data = eval("("+html+")");
			if(document.getElementById("popup_title") && document.getElementById("popup_title").style.display!="none"){
				showBasket(data.orderId);
				if(document.getElementById("qttyItem_"+data.assemblyId+"_"+data.orderId)){
					document.getElementById("qttyItem_"+data.assemblyId+"_"+data.orderId).value = data.qtty;
				}
			}
		}
	});
}
//*************************************
function confirmOrder(){
	var paction =  "ajax=confirmOrder";
	$.ajax({
		type: "POST",
		url: __GLOBALS.ajax,
		data: paction,
		success: function(html) {
			console.log(html);
		}
	});
}
//*************************************