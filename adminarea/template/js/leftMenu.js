//************************************************
function getLeftBranch(option){
	//paction =  "ajax=openLeftBranch&url="+encodeURIComponent(window.location.pathname);
	var paction =  "ajax=getLeftBranch&link="+option+"&url="+encodeURIComponent(window.location.pathname);
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var allData = eval("("+html+")");
			var data = allData['data'];
			var option = allData['option'];
			var inner = "<ul class=\"top_ul\">";
			for(var j in data){
				if(data[j].children>0){
					inner += "<li id=\"notItem_"+option+"_"+data[j].id+"\">";
					inner += "<a onclick=\"openLeftBranch('"+option+"', '"+data[j].id+"')\" href=\"javascript:\">";
					if(data[j].openBranch){
						inner += "<img src=\"/adminarea/template/tree/minus.jpg\" align=\"absmiddle\"></a>";
					}else{
						inner += "<img src=\"/adminarea/template/tree/plus.jpg\" align=\"absmiddle\"></a>";
					}
					inner += "<a onclick=\"getPage('/adminarea/"+option+"/"+data[j].href+"/');addLeftBranchRed(this);return false;\" ";
					inner += "href=\"/adminarea/"+option+"/"+data[j].href+"\">"+data[j].name+"</a>";
					//alert(data[j].openBranch);
					if(data[j].openBranch){
						var subData = data[j].openBranch.data;
						var subInner = constructBranch(option, subData, data[j].id);
						//alert(subInner);
						inner += subInner;
					}
					inner += "</li>";
				}else{
					inner += "<li><img src=\"/adminarea/template/tree/4x4_";
					//alert("/adminarea/"+option+"/"+data[j].href+" ::: "+gurl);
					if(gurl == "/adminarea/"+option+"/"+data[j].href){
						inner += "red.gif";
					}else{
						inner += "blue.gif";
					}
					inner += "\" align=\"absmiddle\">";
					inner += "<a onclick=\"getPage('/adminarea/"+option+"/"+data[j].href+"/');addLeftBranchRed(this);return false;\" ";
					inner += "href=\"/adminarea/"+option+"/"+data[j].href+"\">"+data[j].name+"</a></li>";
				}
			}
			inner += "</ul>";
			//alert(option+"_left_menu");
			document.getElementById(option+"_left_menu").innerHTML = inner;
		}
	});
}
//************************************************
var myLeftBranch = false;
function openLeftBranch(option, parent){
	myLeftBranch = parent;
	paction =  "ajax=openLeftBranch&parent="+parent+"&option="+option;
	if(document.getElementById("notItem_"+option+"_"+parent)){
		var img = document.getElementById("notItem_"+option+"_"+parent).getElementsByTagName("img")[0];
	}else{
		var img={"src":""};
	}
	if(img.src.match(/minus\.jpg$/)){
		img.src = img.src.replace(/minus\.jpg$/gi, 'plus.jpg');
		element = document.getElementById("notItem_"+option+"_"+parent).getElementsByTagName("ul")[0];
		element.parentNode.removeChild(element);
	}else{
		startPreloader();
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				alert(html);
				var allData = eval("("+html+")");
				var data = allData['data'];
				var option = allData['option'];
				var obj = document.getElementById("notItem_"+option+"_"+myLeftBranch);
				if(obj){
					$(obj).append(constructBranch(option, data, myLeftBranch));
					var img = document.getElementById("notItem_"+option+"_"+parent).getElementsByTagName("img")[0];
					img.src = img.src.replace(/plus\.jpg$/gi, 'minus.jpg');
				}
				stopPreloader();
			}
		});
	}
}
//************************************************
function constructBranch(option, data, parent){
	alert(option);
	//alert(JSON.stringify(data));
	var inner = "<ul>";
	for(var j in data){
		if(data[j].children>0){
			inner += "<li id=\"notItem_"+option+"_"+data[j].id+"\">";
			inner += "<a onclick=\"openLeftBranch('"+option+"', '"+data[j].id+"')\" href=\"javascript:\">";
			//alert(JSON.stringify(data[j].openBranch));
			if(data[j].openBranch){
				inner += "<img src=\"/adminarea/template/tree/minus.jpg\" align=\"absmiddle\"></a>";
			}else{
				inner += "<img src=\"/adminarea/template/tree/plus.jpg\" align=\"absmiddle\"></a>";
			}
			inner += "<a onclick=\"getPage('/adminarea/"+option+"/"+data[j].href+"');addLeftBranchRed(this);return false;\" ";
			inner += "href=\"/adminarea/"+option+"/"+data[j].href+"\">"+data[j].name+"</a>";
			if(data[j].openBranch){
				var subData = data[j].openBranch.data;
				var subInner = constructBranch(option, subData, data[j].id);
				//alert(subInner);
				inner += subInner;
			}
			inner += "</li>";
		}else{
			inner += "<li><img src=\"/adminarea/template/tree/4x4_";
			//alert("/adminarea/notices/"+data[j].href+" ::: "+gurl);
			//if(RegExp)
			prega = "/adminarea/"+option+"/"+data[j].href;
			//if(gurl == "/adminarea/notices/"+data[j].href){
			if(gurl.match(RegExp(prega, 'gi'))){
				inner += "red.gif";
			}else{
				inner += "blue.gif";
			}
			inner += "\" align=\"absmiddle\">";
			inner += "<a onclick=\"getPage('/adminarea/"+option+"/"+data[j].href+"');addLeftBranchRed(this);return false;\" ";
			inner += "href=\"/adminarea/"+option+"/"+data[j].href+"\">"+data[j].name+"</a></li>";
		}
	}
	inner += "</ul>";
//	var obj = document.getElementById("notItem_"+option+"_"+parent);
//	if(obj){
//		$(obj).append(inner);
//		var img = document.getElementById("notItem_"+option+"_"+parent).getElementsByTagName("img")[0];
//		img.src = img.src.replace(/plus\.jpg$/gi, 'minus.jpg');
//	}else{
		//alert(inner);
		return inner;
//	}
}
//************************************************
function addLeftBranchRed(obj){
	var objs = document.getElementById("inleftmenu").getElementsByTagName("img");
	for(var j=0; j<objs.length; j++){
		var img = objs[j];
		if(img.src.match(/red\.gif$/)){
			img.src = img.src.replace(/red\.gif$/, 'blue.gif');
		}
	}
	//alert(obj.previousSibling.tagName);
	if(obj && obj.previousSibling){
		if(obj.previousSibling.tagName == "img" || obj.previousSibling.tagName == "IMG"){
			obj.previousSibling.src = obj.previousSibling.src.replace(/blue\.gif$/, 'red.gif');
		}
	}
}
//************************************************
function addLeftBranchRedForRightPanel(obj){
	//alert("ok");
	var objs = document.getElementById("inleftmenu").getElementsByTagName("img");
	for(var j=0; j<objs.length; j++){
		var img = objs[j];
		if(img.src.match(/red\.gif$/)){
			img.src = img.src.replace(/red\.gif$/, 'blue.gif');
		}
	}
	//var objs = document.getElementById("inleftmenu").getElementsByTagName("img");
	for(var j=0; j<objs.length; j++){
		var img = objs[j];
		if(img.src.match(/(red|blue)\.gif$/)){
			var a =img.parentNode.getElementsByTagName("a")[0].toString();
			//alert(typeof a);
			if(a.match(RegExp(window.location.pathname+"$", "gi"))){
				img.src = img.src.replace(/blue\.gif$/, 'red.gif');
			}
		}
		//alert(a);
		//alert(img.nextSibling);
	}
}
//************************************************
function deleteOptionFolder(option, folderId, folderName, isback){
	if(confirm('Вы действительно желаете произвести удаление каталога «'+folderName+'»\nи все содержащиеся в ней подкаталоги и объявления?')){
		var paction =  "ajax=deleteOptionFolder&folderId="+folderId+"&optionName="+option;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				if(isback=="back"){
					window.histore.back();
				}else{
					getPage(window.location.pathname);
					//getLeftBranch('notices');
				}
			}
		});
	}
}
//************************************************

//************************************************

//************************************************

//************************************************

//************************************************

//************************************************

//************************************************

//************************************************