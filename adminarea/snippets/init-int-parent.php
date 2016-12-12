<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td><b id="parentName"><?=$parents[count($parents)-1]['name']?></b> &nbsp;&nbsp;&nbsp;
	<a href="javascript:" onclick="changeItemParent()">Изменить</a>
	<input type="hidden" id="<?=$field['link']?>" value="<?=$item[$field['link']]?>" />
	</td>
</tr></table>
<script>
function changeItemParent(){
	paction =  "ajax=getAllFoldersTree&parent=0&table=<?=$params['option']?>&folderId=<?=$item['parent']?>";
	paction += "&elId=<?=$field['link']?>";
	console.log(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//console.log(html);
			document.getElementById("popup_title").innerHTML = "Выбор родительской группы";
			var data = eval("("+html+")");
			console.log(data);
			var inner = constructFoldersHTML(data);
			inner = inner.replace(/^<ul class="ulChangeParent"><li/, '<ul class="ulChangeParent"><li style="padding-top:0px"');
			document.getElementById("popup_cont").innerHTML = inner+"<div style=\"height:10px;\"></div>";
			var settings = {
				"width":"400",
				"height":"auto"
			}
			__popup(settings);
		}
	});
}
//***********************************
var elId = false;
function constructFoldersHTML(data){
	var inner = "<ul class=\"ulChangeParent\">";
	if(data.data){
		elId = data.elId;
		data = data.data;
	}
	for(var j in data){
		inner += "<li>";
		if(data[j].selected){
			inner += "<b>"+data[j].name+"</b>";
		}else{
			inner += "<a id=\"parBlock_"+data[j].id+"\" href=\"javascript:\" onclick=\"setNewItemParent('"+data[j].id+"')\">"+data[j].name+"</a>";
		}
		if(data[j].children){
			inner += constructFoldersHTML(data[j].children);
		}
		inner +="</li>";
	}
	inner += "</ul>";
	return inner;
}

function setNewItemParent(parent){
	document.getElementById(elId).value=parent;
	console.log("parBlock_"+parent+"__ "+document.getElementById("parBlock_"+parent).innerHTML);
	document.getElementById("parentName").innerHTML = document.getElementById("parBlock_"+parent).innerHTML;
	__popup_close();
}
</script>