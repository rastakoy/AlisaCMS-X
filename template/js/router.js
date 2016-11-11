//************************************************
$(document).ready(function(){
	var objs = document.getElementsByClassName("amenu");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		obj.onclick = function(){
			var id = this.getAttribute("href").replace(/\/adminarea\//gi, '');
			id = id.replace(/\/$/gi, '');
			//console.log('click');
			getData(this.getAttribute("href"));
			return false;
		}
	}
});
//************************************************
var toHistory = true;
var url = false;
var gurl = false;
var loading = false;
var __ajax_url = "/adminarea/index.php";
if ( window.addEventListener ) {
	window.addEventListener('popstate', function( e ) {
		var loc = e.location || document.location;
		toHistory = false;
		//alert(JSON.stringify(window.history.state));
		if(gurl){
			getData(window.history.state.url);
		}
	}, false);
}
//************************************************
function constructParams(str, newParam, newValue){
	var ret = {};
	if(str){ var mass = str.split(','); }else{ 	mass = new Array(); }
	for(var j=0; j<mass.length; j++){
		var foo = mass[j].split('='); var value = "";
		for(var jj=1; jj<foo.length; jj++){ value += (jj==1)?foo[1]:"="+foo[jj]; }
		ret[foo[0]] = value;
	}
	if(newParam){ ret[newParam] = newValue; }
	//alert(JSON.stringify(ret));
	return ret;
}
//************************************************
function constructURLParams(params){
	var ret = "";
	for(var j in params){
		ret += j+"="+params[j]+",";
	}
	return ret.replace(/,$/, '');
}
//************************************************
var oldParamsURL = "";
var globalEdit = false;
var itemReload = false;
function getData(url, newParam, newValue){
	//alert(url);
	if(__GLOBALS.editing){
		if(confirm("Внимание! Обнаружены не сохраненные изменения!\nВернуться и сохраниться?")){
			return false;
		}
	}
	closeHelpWindow();
	destructTiny();
	if(!url || url=='false'){ url=window.location.pathname; }
	var test = url.split('?');
	var params = false;
	var paramsURL = "";
	url = test[0];
	if(test[1] || newParam){
		params = constructParams(test[1], newParam, newValue);
		paramsURL = "?"+constructURLParams(params);
	}
	//alert(params+"::"+paramsURL);
	//**************************
	if(params['action']=='editItem' && !params['itemId']){
		var paction = "ajax=addNewItem&parents="+__PARAMS['parents']+"&option="+__PARAMS['option'];
		if(params['optionExternal']=='1'){ paction += "&optionExternal=1"; }
		//console.log(paction);
		//return false;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				html = (html=='')?'{}':html;
				//console.log(html);
				var data = eval("("+html+")");
				if(data['data']){ data = data['data']['0']; }
				getData(window.location.pathname+"?action=editItem,option="+data.option+",parents="+data.parents+",itemId="+data.itemId);
			}
		});
		return false;
	}
	//**************************
	if(!loading){
		loading = true;
		gurl = url;
		url = url.replace(/\/\//, '/');
		if(!url){
			url = "/adminarea/";
		}
		if(!url.match(/^\/?adminarea\//)){
			url = "/adminarea/"+url;
		}
		//alert(window.location.pathname+paramsURL+" ::: "+url+paramsURL);
		//alert(oldParamsURL);
		var txt = "OLD: "+oldParamsURL+"\n";//+JSON.stringify();
		txt += "CUR: _"+paramsURL+"_\n";
		if(window.history.state){
			txt += "STATE: "+window.history.state.myParams;
		}
		//alert(txt);
		if(itemReload){
			itemReload = false;
		}else{
			//alert(typeof window.history.state);
			if(paramsURL!='' && window.history.state){
				if(window.location.pathname+oldParamsURL != url+paramsURL && paramsURL!=window.history.state.myParams){
					//alert("pushState="+url+paramsURL);
					var data = { "url":url+paramsURL,"myParams":paramsURL  };
					window.history.pushState(data, document.title , url+paramsURL);
				}else if(oldParamsURL==''){
					//alert("pushState="+url+paramsURL);
					var data = { "url":url+paramsURL,"myParams":paramsURL  };
					window.history.pushState(data, document.title , url+paramsURL);
				}
			}else{
				if(window.location.pathname != url+oldParamsURL){
					//alert("pushState="+url+paramsURL);
					var data = { "url":url,"myParams":''  };
					window.history.pushState(data, document.title , url+paramsURL);
				}
			}
		}
		if(url.match(/^\/adminarea\/filters\//)){
			var mURL = gurl.replace(/\/{1,10}$/, "");
			mURL = mURL.replace(/^\/adminarea\//, "");
			//alert(mURL);
			mURL = explode("/", mURL);
			if(mURL['0']=='filters' && mURL.length>2){
				url = "/adminarea/";
				for(var j=0; j<mURL.length-1; j++){
					url += mURL[j]+"/";
				}
			}
			//getRootFilters();
		}
		//*******************
		if(url.match(/^\/adminarea\/pages\//)){
			var mURL = gurl.replace(/\/{1,10}$/, "");
			mURL = mURL.replace(/^\/adminarea\//, "");
			//alert(mURL);
			mURL = explode("/", mURL);
			if(mURL['0']=='pages' && mURL.length>=2){
				url = "/adminarea/";
				for(var j=0; j<mURL.length-1; j++){
					url += mURL[j]+"/";
				}
			}
			//getRootFilters();
		}
		//*******************
		oldParamsURL = paramsURL;
		startPreloader();
		__PARAMS = params;
		//*******************
		paction =  "ajax=getPage&url="+url+paramsURL;
		//console.log(paction);
		$.ajax({
			type: "POST",
			url: __GLOBALS.ajax,
			data: paction,
			success: function(html) {
				//html = (html=='')?'{}':html;
				//alert(html);
				//console.log(html);
				loading = false;
				obj = document.getElementById("adminarearight");
				obj.style.display = "";
				$(obj).empty();
				$(obj).append(html);
				initItems();
				//alert(gurl);
				var mURL = gurl.replace(/\/{1,30}$/, "");
				mURL = mURL.replace(/^\/adminarea\//, "");
				mURL = explode("/", mURL);
				//alert(mURL+"  ("+mURL.length+")");
				//*****************
				if(mURL['0']=='exit'){
					document.location.href = '/adminarea/';
				}
				//*****************
				if(mURL['0']=='filters' && mURL.length>2 && mURL['1']!='editfilter'){
					//alert("editFilter1");
					__css_itemShowCSS('1');
					getEditFilter(mURL);
				}
				if(mURL['0']=='filters' && mURL.length>2 && mURL['1']=='editfilter'){
					//alert("editFilter2");
					editFilterClass(mURL['2']);
				}
				//*****************
				//if(mURL[mURL.length-2]=="editItem"){
				//	//alert(mURL[mURL.length-1]);
				//	__css_itemShowCSS('1');
				//	getEditNotice(mURL[mURL.length-1]);
				//}
				//if(mURL[mURL.length-2]=="editFolder"){
				//	__css_itemShowCSS('1');
				//	getEditNoticeFolder(mURL[mURL.length-1]);
				//}
				//*****************
				if(mURL['0']=='pages' && mURL.length>=2 && mURL['1']!='editpage'){
					__css_itemShowCSS('1');
					getEditPage(mURL);
				}
				if(mURL['0']=='pages' && mURL.length>=2 && mURL['1']=='editpage'){
					//editPage(mURL['2']);
				}
				//*****************
				if(mURL['0']=='settings'){
					__css_itemShowCSS('1');
					getSettings();
				}
				//*****************
				if(mURL['0']=='languages'){
					__css_itemShowCSS('1');
					getLanguage(mURL);
				}
				//*****************
				if(mURL['0']=='noticeComments'){
					__css_itemShowCSS('1');
					showNoticeComments(mURL['1']);
				}
				//*****************
				controlLeftMenu(params.option);
				stopPreloader();
				__GLOBALS.editing = false;
			}
		});
	}else{
		
	}
}
//************************************************
function controlLeftMenu(option){
	//console.log(JSON.stringify(__PARAMS));
	if(__PARAMS.parents){
		var mass = __PARAMS.parents.split("->");
		//console.log(mass);
		for(var j in mass){
			if(document.getElementById("left_"+option+"_"+mass[j])){
				if(!document.getElementById("left_"+option+"_"+mass[j]) || document.getElementById("left_"+option+"_"+mass[j]).style.display=='none'){
					console.log("Элемент "+mass[j]+" закрыт");
					console.log("Элемент "+mass[j]+" подлежит открытию. Открываем");
					openLeftBranch(option, mass[j]);
				}
			}
		}
	}
}
//************************************************
function showNoticeComments(noticeId){
	var paction = "ajax=showNoticeComments";
	paction += "&noticeId="+noticeId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			var data = eval("("+html+")");
			//alert(JSON.stringify(data));
			var inner = "";
			for(var j in data){
				var com = data[j];
				inner += "<div>";
				inner += "<img src=\"/adminarea/template/images/green/myitemname_popup/delete_item.gif\" ";
				inner += "style=\"float:right;cursor:pointer;\" ";
				inner += "onclick=\"deleteNoticeComment('"+com['id']+"', '"+noticeId+"')\"/><b>";
				inner += com['name']+"</b><br/>"+com['addDate']+"<br/>"+com['content']+"<hr size=1>";
				inner += "</div>";
			}
			document.getElementById("show_cssblock_cont").innerHTML = inner;
			//__css_itemShowCSS();
			//getPage(window.location.pathname);
		}
	});
}
//************************************************
function deleteNoticeComment(commentId, noticeId){
	if(confirm("Удалить комментарий?")){
		var paction = "ajax=deleteNoticeComment&commentId="+commentId;
		$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			getPage("noticeComments/"+noticeId+"/");
		}
	});
	}
}
//************************************************
function getLanguage(mURL){
	paction =  "ajax=getLanguage&language="+mURL[1];
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
function getSettings(){
	paction =  "ajax=getSettings";
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
function getEditPage(array){
	paction =  "ajax=getEditPage&link="+array;
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
			tinymce_init();
			startFileUploader();
		}
	});
}
//************************************************
function getEditFilter(array){
	var lnk = "";
	for(var j=0; j<array.length; j++){
		lnk += array[j];
		if(j!=array.length-1){ lnk+=","; }
	}
	paction =  "ajax=getFilterOption&link="+array;
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
function editFilterClass(itemId){
	paction =  "ajax=editFilterClass&itemId="+itemId;
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
			__css_itemShowCSS('1');
		}
	});
}
//************************************************
function getLogin(){
	var login = document.getElementById("login").value;
	var password = document.getElementById("password").value;
	var loginRemember = document.getElementById("loginRemember").checked;
	document.getElementById("login").style.backgroundColor = "";
	document.getElementById("password").style.backgroundColor = "";
	paction =  "ajax=getLogin&login="+login+"&password="+password+"&loginRemember="+loginRemember;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			getPage();
			//obj = document.body;
			//$(obj).empty();
			//$(obj).append(html);
		}
	});
}
//************************************************
function getExit(){
	paction =  "ajax=getExit";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			obj = document.body;
			$(obj).empty();
			$(obj).append(html);
		}
	});
}
//************************************************
function initPagination(){
	var objs = document.getElementsByClassName("paginationItem");
	for(var j in objs){
		objs[j].onclick = function(){
			//alert(this.getAttribute('href'));
			 getPage(this.getAttribute('href'));
			return false;
		}
	}
}
//************************************************
function initItems(){
	$(".div_myitemname").hover(function() {
		if(this.className != "div_myitemname dmnoover"){
			if(!this.getAttribute("myBgColor")){
				this.setAttribute("myBgColor", this.style.backgroundColor);
			}
			$(this).css('background-color', '#D5F4D7');
		}
	}, function() {
		if(this.className != "div_myitemname dmnoover"){
			if(this.getAttribute("myBgColor")){
				$(this).css('background-color', this.getAttribute("myBgColor"));
			}else{
				$(this).css('background-color', '');
			}
		}
	});
	$( ".div_myitemname" ).dblclick(function () {
		//alert(this.parentNode.id.replace(/prm_/, ""));
		if(gurl.match(/\/\/$/)){
			gurl = gurl.replace(/\/$/, '');
		}
		//console.log(__GLOBALS.adminBase+"/"+this.parentNode.id.replace(/prm_/, ""));
		//alert(this.id);
		getData(__GLOBALS.adminBase+"/"+this.parentNode.id.replace(/prm_/, ""));
		addLeftBranchRedForRightPanel();
		//__css_itemShowCSS();
	});
	
	if(init_dop_popup_v_01_var && __PARAMS['option']!='trash' && __PARAMS['option']!='orders' ){
	$( "#myitems_sortable" ).sortable({
			cursorAt: { left: -20 },
			//items: "div:not(.dmulti2)",
			//cancel: ".dmulti2",
			start: function(){
				$(".dmulti2").css("display","none");
				$(".dmulti").css("border-bottom-left-radius","15px");
				$(".dmulti").css("border-bottom-right-radius","15px");
				//alert(this.firstChild.firstChild.className);
			},
			update: function() {
				testChanger();
				var mURL = gurl.replace(/\/{1,10}$/, "");
				mURL = mURL.replace(/^\/adminarea\//, "");
				//mURL = explode("/", mURL);
				savePriors(mURL);
				//save_myitems_prior();
				//$("#items_left_menu a").hover("destroy");
				//$("#rootfoldermenu a").hover("destroy");
				$("#items_left_menu a").off( "mouseenter mouseleave" );
				$("#rootfoldermenu a").off( "mouseenter mouseleave" );
				$("#rootfoldermenu a").css("background-color", "");
				rowToFolderDragNDrop = false;
				itemToFolderDragNDrop = false;
				//document.querySelector("#prm_*");
			},
			sort: function() {
				//alert(this.items);
				$("#items_left_menu a").hover(function() {
					$(this).css("background-color", "#FF0000");
					rowToFolderDragNDrop = this;
				}, function() {
					this.style.backgroundColor = "";
					rowToFolderDragNDrop = false;
				});
				$("#rootfoldermenu a").hover(function() {
					$(this).css("background-color", "#FF0000");
					rowToFolderDragNDrop = {"href":"javascript:show_ritems(0"};
				}, function() {
					$(this).css("background-color", "");
					rowToFolderDragNDrop = false;
				});
			},
			stop: function( event, ui ) {
				//$(".dmulti2").css("display","");
				$(".dmulti2").css("display","");
				$(".dmulti").css("height","");
				$(".dmulti").css("border-bottom-left-radius","0");
				$(".dmulti").css("border-bottom-right-radius","0");
				if(rowToFolderDragNDrop){
					hpp = itemToFolderDragNDrop.id.replace(/^div_myitemname_/, "");
					hrr = rowToFolderDragNDrop.href.replace(/^javascript:show_ritems\(/, "");
					hrr = hrr.replace(/\)$/, "");
					change_item_parent_dnd(hpp, hrr);
					//$("#items_left_menu a").hover("destroy");
					//$("#rootfoldermenu a").hover("destroy");
					$("#items_left_menu a").off( "mouseenter mouseleave" );
					$("#rootfoldermenu a").off( "mouseenter mouseleave" );
					$("#rootfoldermenu a").css("background-color", "");
					rowToFolderDragNDrop = false;
					itemToFolderDragNDrop = false;
				}
			}
		});
	//$( "#myitems_sortable" ).disableSelection();
	}
}
//************************************************
function savePriors(url){
	var priors = $('#myitems_sortable').sortable('toArray');
	for(var j=0; j<priors.length;j++){
		if(priors[j].match(/\?/gi)){
			var foo = priors[j].replace(/prm_\?/, '');
			myMatch = foo.match(/(itemId=[0-9]{1,11}|folderId=[0-9]{1,11})/);
			//console.log(myMatch);
			priors[j] = "prm_"+myMatch[0].replace(/(itemId=|folderId=)/gi, '');
		}
	}
	//console.log(priors);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "ajax=savePriors&parents="+((typeof __PARAMS['parents']!='undefined')?__PARAMS['parents']:'0')+"&table="+__PARAMS['option']+"&ids="+priors,
		success: function(html) {
			//console.log(html);
			var data = eval("("+html+")");
			if(!document.getElementById("left_"+data.option+"_0").getElementsByTagName("ul")[0]){
				openLeftBranch(data.option);
			}else{
				openLeftBranch(data.option);
				openLeftBranch(data.option);
			}
		}
	});
}
//************************************************
function __css_itemShowCSS(myStyle){
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	//*******************************
	obj_m = document.getElementById("show_cssblock_bg");
	obj_m.style.width = wwidth+"px";
	obj_m.style.height = wheight+"px";
	obj_m.style.display="";
	obj_m.style.cursor="pointer";
	obj_m.onclick = function(){
		__css_itemShowCSS_close();
	}
	//*******************************
	obj_w = document.getElementById("show_cssblock_cont");
	//alert(JSON.stringify(myStyle));
	if(myStyle.width){
		obj_w.style.width = (myStyle.width)+"px";
		obj_w.style.height = (myStyle.height)+"px";
		obj_w.style.top = (20+document.body.scrollTop)+"px";
		obj_w.style.left = (wwwidth/2-myStyle.width/2)+"px";
	}else{
		obj_w.style.width = (wwidth-100)+"px";
		obj_w.style.height = (wwheight - 100)+"px";
		obj_w.style.top = (20+document.body.scrollTop)+"px";
		obj_w.style.left = (wwwidth/2-(wwidth-100)/2)+"px";
	}
	obj_w.style.display="";
	//*******************************
	obj_c = document.getElementById("show_cssblock_close");
	obj_c.style.top = (15+document.body.scrollTop)+"px";
	if(myStyle.width){
		obj_c.style.left = (wwidth-(wwwidth/2-myStyle.width/2)+10)+"px";
	}else{
		obj_c.style.left = (wwidth-40)+"px";
	}
	obj_c.style.display="";
	obj_c.onclick = function(){
		__css_itemShowCSS_close();
	}
	//*******************************
	//__css_showImages(itemId);
	//alert("itemId="+itemId);
	//__css_getSitemStyle(itemId);
}
//************************************************
function __css_itemShowCSS_close(){
	document.getElementById("show_cssblock_bg").style.display = "none";
	document.getElementById("show_cssblock_cont").style.display = "none";
	document.getElementById("show_cssblock_cont").innerHTML = "";
	document.getElementById("show_cssblock_close").style.display = "none";
	if(gurl!='/adminarea/filters/'){
		window.history.back();
	}
}
//************************************************
function explode( delimiter, string ) { // Split a string by string
    var emptyArray = { 0: '' };
    if ( arguments.length != 2
        || typeof arguments[0] == 'undefined'
        || typeof arguments[1] == 'undefined' )
    {
        return null;
    }
    if ( delimiter === ''
        || delimiter === false
        || delimiter === null )
    {
        return false;
    }
    if ( typeof delimiter == 'function'
        || typeof delimiter == 'object'
        || typeof string == 'function'
        || typeof string == 'object' )
    {
        return emptyArray;
    }
    if ( delimiter === true ) {
        delimiter = '1';
    }
    return string.toString().split ( delimiter.toString() );
}
//************************************************
function getRootFilters(){
	paction =  "ajax=getRootFilters";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			var inner = "<ul class=\"top_ul\">";
			for(var j in data){
				inner += "<li><img src=\"/adminarea/template/tree/4x4_";
				if(gurl == "/adminarea/filters/"+data[j].link+"/"){
					inner += "red.gif";
				}else{
					inner += "blue.gif";
				}
				inner += "\" align=\"absmiddle\">";
				inner += "<a onclick=\"getPage('/adminarea/filters/"+data[j].link+"/');getRootFilters();\" ";
				inner += "href=\"javascript:\">"+data[j].name+"</a></li>";
			}
			inner += "</ul>";
			document.getElementById("filters_left_menu").innerHTML = inner;
		}
	});
}
//************************************************
function destructTiny(){
	var objs = document.getElementsByTagName("textarea");
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		if(obj.id!=''){
			tinyMCE.execCommand('mceRemoveControl',true, obj.id);
			//console.log("Текстовый блок "+obj.id+" отключен");
		}
	}
}
//************************************************
