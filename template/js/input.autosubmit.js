function inputPreloader(object, ajax, preloaderParams){
	if(!object){
		console.log("���������� ������ �� ������");
		return false;
	}
	if(object.tagName.toLowerCase()=='input'){
		object.oldValue = object.value;
		
	}
}