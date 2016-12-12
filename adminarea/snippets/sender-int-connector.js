if(connector_<?=$field['id']?>){
	for(var j in connector_<?=$field['id']?>){
		paction += "&"+connector_<?=$field['id']?>[j]+"="+document.getElementById(connector_<?=$field['id']?>[j]).value;
	}
}