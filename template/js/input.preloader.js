function inputPreloader(object, ajax, preloaderParams){
	if(!object){
		console.log("Вызываемый объект не найден");
		return false;
	}
	if(object.tagName.toLowerCase()=='input'){
		object.oldValue = object.value;
		object.preloading = function(){
			if(this.className.match(/( ?inputpreloader ?| ?inputok ?| ?inputfalse ?)/)){
				this.className.replace(/( ?inputpreloader ?| ?inputok ?| ?inputfalse ?)/gi, '');
			}
			if(this.value=='') { return false; }
			this.className = (this.className=='')?'inputpreloader':' inputpreloader';
			var paction =  "ajax="+ajax;
			paction += "&index="+encodeURIComponent(this.id)
			paction += "&"+this.id+"="+encodeURIComponent(this.value);
			if(this.pattern){
				paction += "&pattern="+encodeURIComponent(this.pattern);
			}
			paction += "&elementId="+this.id;
			if(typeof preloaderParams=='object'){
				for(var j in preloaderParams){
					paction += "&"+j+"="+preloaderParams[j];
				}
			}
			//console.log(paction);
			object.oldValue = this.value;
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: paction,
				success: function(html) {
					//console.log(html);
					html = (html=='')?'{}':html;
					var data = eval("("+html+")");
					var object = document.getElementById(data.elementId);
					object.className.replace(/( ?inputpreloader ?| ?inputok ?| ?inputfalse ?)/gi, '');
					if(data.return=='1'){
						object.className += (object.className=='')?'inputok':' inputok';
					}else{
						object.className += (object.className=='')?'inputfalse':' inputfalse';
					}
				}
			});
		}
		object.onkeyup = function(){
			this.className = this.className.replace(/( ?inputpreloader ?| ?inputok ?| ?inputfalse ?)/gi, '');
			if(this.timeout){
				clearInterval(this.timeout);
			}
			this.timeout = false;
			this.timeout = setTimeout(function(){object.preloading()}, 650);
		}
		object.onchange = function(){
			if(this.value!=this.oldValue){
				object.preloading();
			}
		}
		object.onfocus = function(){
			this.style.backgroundColor = '';
		}
	}
}



