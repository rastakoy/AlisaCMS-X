function inputPreloader(object, ajax, preloaderParams){
	if(!object){
		console.log("Вызываемый объект не найден");
		return false;
	}
	if(object.tagName.toLowerCase()=='input'){
		object.oldValue = object.value;
		
	}
}