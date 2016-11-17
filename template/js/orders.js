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
			__popup();
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