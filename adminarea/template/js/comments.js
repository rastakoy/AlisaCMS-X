//************************************************
function showComments(itemId){
	var paction =  "ajax=showComments";
	paction += "&itemId="+itemId;
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
			var title = document.getElementById("itemName_"+itemId).innerHTML;
			document.getElementById("popup_title").innerHTML = "Комментарии к «"+title+"»";
			//__popup({"background-image":"url("+__GLOBALS.adminBase+"/template/images/green/test_background.png)"});
			__popup({"width":"600","onclose":function(){}});
		}
	});
}
//************************************************

//************************************************

//************************************************









