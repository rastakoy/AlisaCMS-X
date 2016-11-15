//*********************************************************
function showAssembly(orderId){
	//__popup({"onclose":false});
	var paction = "ajax=showAssembly";
	paction += "&orderId="+orderId.replace(/№/gi, '');
	console.log(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//html = (html=='')?'{}':html;
			//var data = eval("("+html+")");
			//console.log(html);
			$("#popup_cont").empty();
			$("#popup_cont").append(html);
			document.getElementById("popup_title").innerHTML = "Сборка заказа "+orderId;
			__popup({"onclose":false});
		}
	});
}
//*********************************************************