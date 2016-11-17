//************************************************
function __popup(myStyle){
	//console.log(myStyle);
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	var winWidth = false;
	var winLeft = false;
	//*******************************
	obj_m = document.getElementById("popup_bg");
	obj_m.style.width = wwidth+"px";
	obj_m.style.height = wheight+"px";
	obj_m.style.display="";
	obj_m.style.cursor="pointer";
	obj_m.onclose = false;
	obj_m.noclose = false;
	if(myStyle && myStyle.onclose){
		obj_m.onclose = myStyle.onclose;
		obj_m.noclose = myStyle.noclose;
	}
	obj_m.onclick = function(){
		__popup_close(this.onclose, this.noclose);
	}
	//*******************************
	obj_w = document.getElementById("popup_cont");
	//alert(JSON.stringify(myStyle));
	if(myStyle && myStyle.width){
		myStyle.width.replace(/(px)/gi, '');
		//console.log((myStyle.width)+(myStyle.width.match(/%$/))?'':"px");
		obj_w.style.width = myStyle.width;
		winWidth = myStyle.width;
		if(myStyle.height){
			obj_w.style.height = myStyle.height;
			if($(obj_w).height()>wwheight - 100){
				obj_w.style.height = (wwheight - 100)+"px";
			}
		}else{
			obj_w.style.height = (wwheight - 100)+"px";
		}
		obj_w.style.top = (20+document.body.scrollTop)+"px";
		obj_w.style.left = (wwwidth/2-myStyle.width.replace(/px/gi,'')/2)+"px";
		winLeft = wwwidth/2-myStyle.width.replace(/px/gi,'')/2;
		winTop = 20+document.body.scrollTop;
	}else if(myStyle && myStyle.width){
		obj_w.style.height = myStyle.height;
		if($(obj_w).height()>wwheight - 100){
			obj_w.style.height = (wwheight - 100)+"px";
		}
	}else{
		//console.log((myStyle.width)+(myStyle.width.match(/%$/))?'':"px");
		obj_w.style.width = (wwidth-100)+"px";
		obj_w.style.height = (wwheight - 100)+"px";
		obj_w.style.top = (20+document.body.scrollTop)+"px";
		obj_w.style.left = (wwwidth/2-(wwidth-100)/2)+"px";
		winWidth = wwidth-100;
		winLeft = wwwidth/2-(wwidth-100)/2;
		winTop = 20+document.body.scrollTop;
	}
	obj_w.style.display="";
	//*******************************
	obj_c = document.getElementById("popup_close");
	obj_c.style.top = (15+document.body.scrollTop)+"px";
	if(myStyle && myStyle.width){
		obj_c.style.left = (wwidth-(wwwidth/2-myStyle.width.replace(/px/gi,'')/2)+10)+"px";
	}else{
		obj_c.style.left = (wwidth-40)+"px";
	}
	obj_c.style.display="";
	obj_c.onclose = false;
	obj_c.noclose = false;
	if(myStyle && myStyle.onclose){
		obj_c.onclose = myStyle.onclose;
		obj_c.noclose = myStyle.noclose;
	}
	obj_c.onclick = function(){
		__popup_close(this.onclose, this.noclose);
	}
	//*******************************
	obj_t = document.getElementById("popup_title");
	if(obj_t.innerHTML!=''){
		obj_w.style.paddingTop = "30px";
		winWidth = winWidth - 50;
		winLeft = winLeft;
		winTop = winTop - 10;
		obj_t.style.width = winWidth+"px";
		obj_t.style.left = winLeft+"px";
		obj_t.style.top = winTop+"px";
		obj_t.style.display="";
		//obj_t.style.left = (winLeft+20)+"px";
	}
}
//************************************************
function __popup_close(data, noclose){
	if(data){
		data();
	}
	if(!noclose){
		document.getElementById("popup_bg").style.display = "none";
		document.getElementById("popup_cont").style.height = "10px";
		document.getElementById("popup_cont").style.display = "none";
		document.getElementById("popup_cont").innerHTML = "";
		document.getElementById("popup_close").style.display = "none";
		document.getElementById("popup_title").style.display = "none";
		document.getElementById("popup_title").innerHTML = "";
	}
}
//************************************************