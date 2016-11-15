var fastOrderString = "";
function initScaner(){
	document.body.onkeypress = false;
	document.body.onkeypress = function(event){
		if(event.keyCode=="13"){
			//fastOrderString += "—";
			var price = fastOrderString.replace(/^.*-/gi, '');
			var code = fastOrderString.replace(RegExp("-"+price+"$", "gi"), '');
			//code = "1234567890";
			if(code.match(/[0-9]{6}$/gi)){
				code = code.substring(code.length-6, code.length);
			}
			console.log("price="+price+":");
			console.log("code="+code+":");
			//console.log(fastOrderString);
			fastOrderString = "";
			
			if(code.match(/^[0-9]{1,6}$/gi) && price.match(/^[0-9]*$/gi)){
				//alert("YES");
				getData('/adminarea/?action=editItem,option=orders,parents=,isAdmin=1');
			}else{
				//alert("FUCK");
			}
		}else{
			fastOrderString += String.fromCharCode(event.keyCode || event.charCode);
		}
	}
}
$(document).ready(function(){
	initScaner();
});
