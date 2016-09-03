//************************************************
var myLeftBranch = false;
function openLeftBranch(option, parent){
	myLeftBranch = parent;
	if(!parent || parent=='0'){
		parent = '0';
		var img = document.getElementById("root"+option+"menu").getElementsByTagName("img")[0];
	}else if(document.getElementById("left_"+option+"_"+parent)){
		var img = document.getElementById("left_"+option+"_"+parent).getElementsByTagName("img")[0];
	}else{
		var img={"src":""};
	}
	if(img.src.match(/minus\.jpg$/)){
		img.src = img.src.replace(/minus\.jpg$/gi, 'plus.jpg');
		if(parent=='0'){
			element = document.getElementById("left_"+option+"_0").innerHTML = '';
			element = document.getElementById("left_"+option+"_0").style.display = 'none';
		}else{
			element = document.getElementById("left_"+option+"_"+parent).getElementsByTagName("ul")[0];
			element.parentNode.removeChild(element);
		}
	}else{
		paction =  "ajax=openLeftBranch&parent="+parent+"&option="+option;
		//console.log(paction);
		startPreloader();
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//console.log(html);
				var allData = eval("("+html+")");
				var data = allData['data'];
				var option = allData['option'];
				var parent = allData.parent;
				//var obj = document.getElementById("notItem_"+option+"_"+myLeftBranch);
				var obj = document.getElementById("left_"+allData.option+"_"+parent);
				if(obj){
					//console.log(constructBranch(option, data, allData.parent));
					$(obj).append(constructBranch(option, data, parent));
					if(allData.parent=='0'){
						var img = document.getElementById("root"+option+"menu").getElementsByTagName("img")[0];
						document.getElementById("left_"+option+"_0").style.display = '';
					}else{
						var img = document.getElementById("left_"+option+"_"+parent).getElementsByTagName("img")[0];
					}
					img.src = img.src.replace(/plus\.jpg$/gi, 'minus.jpg');
				}else{
					console.log("Не найден родительский элемент для вставки данных\n"+"left_"+allData.option+"_"+parent);
				}
				//*******************
				//console.log(__PARAMS.parents);
				if(__PARAMS.parents){
					var mass = __PARAMS.parents.split("->");
					for(var j=1; j<mass.length; j++){
						for(var jj=0; jj<data.length; jj++){
							//console.log(data[jj].id +"::"+ data[jj].children +"::"+ __PARAMS.option);
							if(data[jj].id==mass[j] && data[jj].children>0 && __PARAMS.option==option){
								//console.log("opening");
								openLeftBranch(option, mass[j]);
							}
						}
					}
				}
				//*******************
				stopPreloader();
			}
		});
	}
}
//************************************************
function constructBranch(option, data, parent){
	//console.log(JSON.stringify(data));
	var inner = "<ul>";
	for(var j in data){
		if(data[j].children>0){
			inner += "<li id=\"left_"+option+"_"+data[j].id+"\">";
			inner += "<a onclick=\"openLeftBranch('"+option+"', '"+data[j].id+"')\" href=\"javascript:\">";
			//alert(JSON.stringify(data[j].openBranch));
			if(data[j].openBranch){
				inner += "<img src=\"/adminarea/template/tree/minus.jpg\" align=\"absmiddle\"></a>";
			}else{
				inner += "<img src=\"/adminarea/template/tree/plus.jpg\" align=\"absmiddle\"></a>";
			}
			inner += "<a onclick=\"getData('/adminarea/?option="+option+",parents="+data[j].parents+"');addLeftBranchRed(this);return false;\" ";
			inner += "href=\"/adminarea/?option="+option+",parents="+data[j].parents+"\">"+data[j].name+"</a>";
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
			prega = "/adminarea/?option="+option+",parents="+data[j].parents;
			//if(gurl == "/adminarea/notices/"+data[j].href){
			if(gurl.match(RegExp(prega, 'gi'))){
				inner += "red.gif";
			}else{
				inner += "blue.gif";
			}
			inner += "\" align=\"absmiddle\">";
			inner += "<a onclick=\"getData('/adminarea/?option="+option+",parents="+data[j].parents+"');addLeftBranchRed(this);return false;\" ";
			inner += "href=\"/adminarea/?option="+option+",parents="+data[j].parents+"\">"+data[j].name+"</a></li>";
		}
	}
	inner += "</ul>";
	return inner;
}
//************************************************

//************************************************

//************************************************

//************************************************

//************************************************









