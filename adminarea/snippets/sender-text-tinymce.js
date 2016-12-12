tinyMCE.execCommand('mceRemoveControl',true, "<?=$field['link'].$langPrefix?>");
if(document.getElementById("<?=$field['link'].$langPrefix?>")){
	paction += "&<?=$field['link'].$langPrefix?>="+encodeURIComponent(document.getElementById("<?=$field['link'].$langPrefix?>").value);
}else{
	console.log("Сбой сохранения текстового поля");
}