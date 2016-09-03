//************************************************
function showHelp(value){
	startPreloader();
	paction =  "ajax=getHelp&action="+value;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			openHelpWindow();
			document.getElementById("help_cont").innerHTML = html;
			stopPreloader();
		}
	});
}
//************************************************
function openHelpWindow(){
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	//*******************************
	obj_m = document.getElementById("help_bg");
	obj_m.style.width = wwidth+"px";
	obj_m.style.height = wheight+"px";
	//obj_m.style.display="";
	obj_m.style.cursor="pointer";
	obj_m.onclick = function(){
		closeHelpWindow();
	}
	//*******************************
	obj_w = document.getElementById("help_cont");
	//obj_w.style.width = (wwidth/2-100)+"px";
	//obj_w.style.height = (wwheight - 100)+"px";
	$(obj_w).css("max-height", (wwheight - 100)+"px");
	obj_w.style.top = (20+document.body.scrollTop)+"px";
	obj_w.style.left = (wwidth-500)+"px";
	obj_w.style.display="";
	//*******************************
	//obj_w = document.getElementById("show_cssblock_cont");
	//obj_w.style.width = (400)+"px";
	//obj_w.style.height = (wwheight - 100)+"px";
	//obj_w.style.top = (20+document.body.scrollTop)+"px";
	//obj_w.style.left = (wwwidth/2-(wwidth-100)/2)+"px";
	//obj_w.style.display="";
	//*******************************
	obj_c = document.getElementById("help_close");
	obj_c.style.top = (25+document.body.scrollTop)+"px";
	obj_c.style.left = (wwidth-40)+"px";
	obj_c.style.display="";
	obj_c.onclick = function(){
		closeHelpWindow();
	}
	//*******************************
	//__css_showImages(itemId);
	//alert("itemId="+itemId);
	//__css_getSitemStyle(itemId);
}
//************************************************
function closeHelpWindow(){
	document.getElementById("help_bg").style.display = "none";
	document.getElementById("help_cont").style.display = "none";
	document.getElementById("help_cont").innerHTML = "";
	document.getElementById("help_close").style.display = "none";
	//if(gurl!='/adminarea/filters/'){
	//	window.history.back();
	//}
}
//************************************************