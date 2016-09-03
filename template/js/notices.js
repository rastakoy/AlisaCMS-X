//************************************************
function getRootNotices(){
	paction =  "ajax=getRootNotices&url="+encodeURIComponent(window.location.pathname);
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			alert(html);
			var data = eval("("+html+")");
			var inner = "<ul class=\"top_ul\">";
			for(var j in data){
				if(data[j].children>0){
					inner += "<li id=\"notItem_"+data[j].id+"\">";
					inner += "<a onclick=\"openNoticeBranch('"+data[j].id+"')\" href=\"javascript:\">";
					if(data[j].openBranch){
						inner += "<img src=\"/adminarea/template/tree/minus.jpg\" align=\"absmiddle\"></a>";
					}else{
						inner += "<img src=\"/adminarea/template/tree/plus.jpg\" align=\"absmiddle\"></a>";
					}
					inner += "<a onclick=\"getPage('/adminarea/notices/"+data[j].href+"/');addNoticeRed(this);\" ";
					inner += "href=\"javascript:\">"+data[j].name+"</a>";
					if(data[j].openBranch){
						var subInner = constructBranch(data[j].openBranch, data[j].id);
						//alert(subInner);
						inner += subInner;
					}
					inner += "</li>";
				}else{
					inner += "<li><img src=\"/adminarea/template/tree/4x4_";
					//alert("/adminarea/notices/"+data[j].href+" ::: "+gurl);
					if(gurl == "/adminarea/notices/"+data[j].href){
						inner += "red.gif";
					}else{
						inner += "blue.gif";
					}
					inner += "\" align=\"absmiddle\">";
					inner += "<a onclick=\"getPage('/adminarea/notices/"+data[j].href+"/');addNoticeRed(this);\" ";
					inner += "href=\"javascript:\">"+data[j].name+"</a></li>";
				}
			}
			inner += "</ul>";
			document.getElementById("notices_left_menu").innerHTML = inner;
		}
	});
}
//************************************************
var myNoticeBranch = false;
function openNoticeBranch(parent){
	myNoticeBranch = parent;
	paction =  "ajax=openNoticeBranch&parent="+parent;
	var img = document.getElementById("notItem_"+parent).getElementsByTagName("img")[0];
	if(img.src.match(/minus\.jpg$/)){
		img.src = img.src.replace(/minus\.jpg$/gi, 'plus.jpg');
		element = document.getElementById("notItem_"+parent).getElementsByTagName("ul")[0];
		element.parentNode.removeChild(element);
	}else{
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				var data = eval("("+html+")");
				constructBranch(data, myNoticeBranch);
			}
		});
	}
}
//************************************************
function addNoticeFolder(parent){
	var paction =  "ajax=addNoticeFolder&parent="+parent;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			if(data.return){
				getPage(data.return);
				//getLeftBranch('notice');
			}else{
				alert("Error!");
			}
			//var obj = document.getElementById("show_cssblock_cont");
			//$(obj).empty();
			//$(obj).append(html);
		}
	});
}
//************************************************
function addNoticeRed(obj){
	var objs = document.getElementById("notices_left_menu").getElementsByTagName("img");
	for(var j=0; j<objs.length; j++){
		var img = objs[j];
		if(img.src.match(/red\.gif$/)){
			img.src = img.src.replace(/red\.gif$/, 'blue.gif');
		}
	}
	//alert(obj.previousSibling.tagName);
	if(obj.previousSibling.tagName == "img" || obj.previousSibling.tagName == "IMG"){
		obj.previousSibling.src = obj.previousSibling.src.replace(/blue\.gif$/, 'red.gif');
	}
}
//************************************************
function getEditNotice(id){
	paction =  "ajax=getEditNotice&id="+id;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var obj = document.getElementById("show_cssblock_cont");
			$(obj).empty();
			$(obj).append(html);
		}
	});
}
//************************************************
function getEditNoticeFolder(id){
	paction =  "ajax=getEditNoticeFolder&id="+id;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var obj = document.getElementById("show_cssblock_cont");
			$(obj).empty();
			$(obj).append(html);
		}
	});
}
//************************************************
function deleteNotice(noticeId){
	if(confirm("Удалить данное объявление?")){
		paction =  "ajax=deleteNotice&noticeId="+noticeId;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				alert(html);
				var data = eval("("+html+")");
				if(data.return=='ok'){
					getPage(window.location.pathname);
				}else{
					alert("Произошла ошибка");
				}
				//var obj = document.getElementById("show_cssblock_cont");
				//$(obj).empty();
				//$(obj).append(html);
			}
		});
	}
}
//************************************************
function changeShowTemp(obj){
	if(obj.checked){
		var chk = 'Да';
	}else{
		var chk = 'Нет';
	}
	paction =  "ajax=changeShowTemp&checked="+chk;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			getPage(window.location.pathname);
		}
	});
}
//************************************************
















