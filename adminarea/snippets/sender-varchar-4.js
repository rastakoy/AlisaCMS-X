if(document.getElementById("<?=$field['link']?>")){
    if(document.getElementById("<?=$field['link']?>").value!=''){
        var linkVal = document.getElementById("<?=$field['link']?>").value;
        paction += "&<?=$field['link']?>="+encodeURIComponent(linkVal);
    }else{
        document.getElementById("<?=$field['link']?>").style.backgroundColor = '#FDDDD9';
		return false;
    }
}