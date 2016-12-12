//*************************************
function showBasket(){
	document.getElementById("popup_title").innerHTML = "Ваша корзина";
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
	});
}
//*************************************
function addGoodToBasket(){
	
}
//*************************************

//*************************************