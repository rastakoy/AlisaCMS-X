function inputPreloader(object, preloaderParams){
	if(!object){
		console.log("Вызываемый объект не найден");
		return false;
	}
	if(object.tagName.toLowerCase()=='a'){
		if(!object.preloaderClassId){
			object.preloaderClassId = 0;
		}
		var tcname = object.tagName.toLowerCase()+"_preloaderClassId_" + object.preloaderClassId;
		object.className += (object.className=='')?tcname:' '+tcname;
		object.oldInner = object.innerHTML;
		object.oldClick = object.onclick;
		object.preloading = function(){
			this.innerHTML = "<img src=\"/template/images/bpreloader.gif\" align=\"absmiddle\">";
			var paction = '';
			if(typeof preloaderParams=='object'){
				for(var j in preloaderParams){
					paction += "&"+j+"="+encodeURIComponent(preloaderParams[j]);
				}
			}
			paction = paction.replace(/^&/gi, '');
			paction += "&preloaderClassId="+this.preloaderClassId;
			paction += "&preloaderClassPrefix=_preloaderClassId_";
			paction += "&preloaderTagName="+this.tagName.toLowerCase();
			//console.log(paction);
			$.ajax({
				type: "POST",
				url: __GLOBALS.ajax,
				data: paction,
				success: function(html) {
					//console.log(html);
					html = (html=='')?'{}':html;
					var data = eval("("+html+")");
					//console.log(data);
					//var object = document.getElementById(data.elementId);
					
					if(data.callback){
						data.callback();
					}
				}
			});
		}
		object.onclick = function(){ return false; };
		object.preloading();
	}
}