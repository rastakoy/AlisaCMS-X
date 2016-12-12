var rootPreloaderShow = false;
var myRootPreloader = "/adminarea/template/images/green/preloader-01.gif";
var myRootPreloaderTimeout = 400;
//**********************************************************
//alert(ifBrowser("chrome"));
var agent = detect.parse(navigator.userAgent);
//alert(JSON.stringify(agent));
if(agent.browser.family=='Firefox'){
	myRootPreloaderTimeout = myRootPreloaderTimeout * 5;
}
//**********************************************************
function startPreloader(){
	rootPreloaderShow = true;
	if(!document.getElementById("rootPreloader")){
		var preloader = document.createElement('div');
		preloader.id = "rootPreloader";
		document.body.appendChild(preloader);
	}
	//*****************
	document.getElementById("rootPreloader").style.display = "";
	var css = {
		"position":"fixed",
		"background-color":"#CCCCCC",
		"width":"100%",
		"height":"100%",
		"dispay":"block",
		"z-index":"5000",
		"left":"0px",
		"top":"0px",
		"-moz-opacity":"0.0",
		"opacity":".00",
		"filter":"alpha(opacity=00)",
		"background-image":"url("+myRootPreloader+")",
		"background-repeat":"no-repeat",
		"background-position":"center center"
	}
	$(preloader).css(css);
	//*****************
	setTimeout("preloaderPause()", myRootPreloaderTimeout);
}
//**********************************************************
function preloaderPause(){
	if(rootPreloaderShow){
		preloader = document.getElementById("rootPreloader");
		var css = {
			"position":"fixed",
			"background-color":"#CCCCCC",
			"width":"100%",
			"height":"100%",
			"dispay":"block",
			"z-index":"5000",
			"left":"0px",
			"top":"0px",
			"-moz-opacity":"0.8",
			"opacity":".80",
			"filter":"alpha(opacity=80)",
			"background-image":"url("+myRootPreloader+")",
			"background-repeat":"no-repeat",
			"background-position":"center center"
		}
		$(preloader).css(css);
	}
}
//**********************************************************
function stopPreloader(){
	rootPreloaderShow = false;
	if(document.getElementById("rootPreloader")){
		document.getElementById("rootPreloader").style.display = "none";
	}
}