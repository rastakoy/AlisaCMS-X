//*************************************
function __fb_show_basket(){  //require modal.js
	getBasket();
	__modal("vpcontainer_cont", {
		"width":"90%",
		"height":"90%",
		"clickableBg":true,
		"effect":"fade",
		"onClose":(function(){
			__fb_getBasketInfo();
		}),
		"closeButton":true,
		"className":" wmbasket"
	});
	//inner = "<div class=\"vipimg\"  id=\"vpcontainer_cont\" ";
	//inner += " style=\"background-color:#EBEBEB;overflow:auto;\" ></div>";
	//document.getElementById("modalObject").innerHTML = inner;
}
//*************************************
function __fb_backToOrder(){
	$("#bascketOrder").css("display","");
	$("#basckerUser").css("display","none");
}
//*************************************
function __fb_getBasketInfo(){
	var paction = "ajax=__fb_getBasketInfo";
	$.ajax({
		type: "POST",
		url: "__ajax.php",
		data: paction,
		success: function(html) {
			//alert(html);
			var obj = eval("("+html+")");
			inner = "<a href=\"javascript:__fb_show_basket()\">Товаров: "+obj.qtty+"&nbsp;&nbsp;("+obj.sum+" грн.)</a>";
			document.getElementById("basketInfo").innerHTML = inner;
		}
	});
}