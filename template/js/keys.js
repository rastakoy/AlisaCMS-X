var fastOrderString = "";
function initScaner(){
	document.body.onkeypress = false;
	document.body.onkeypress = function(event){
		if(event.keyCode=="13"){
			if(fastOrderString.match(/~~$/gi)){
				fastOrderString = "testtest;+000018";
			}
			if(fastOrderString.match(/(\$|;)\+[0-9]{6}$/gi)){
				code = fastOrderString.substring(fastOrderString.length-8, fastOrderString.length);
			}else{
				code = "";
			}
			console.log("code="+code+":");
			console.log(fastOrderString);
			fastOrderString = "";
			
			if(code.match(/^(\$|;)\+[0-9]{1,6}$/gi)){
				addNewGoodIntoOrder(false, code.replace(/^(\$|;)\+/gi, ''));
				//getData('/adminarea/?action=editItem,option=orders,parents=,isAdmin=1');
			}else{
				//console.log("findnt data");
			}
		}else{
			fastOrderString += String.fromCharCode(event.keyCode || event.charCode);
		}
	}
}
$(document).ready(function(){
	initScaner();
});
