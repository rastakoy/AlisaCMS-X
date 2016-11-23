<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="150" height="30"><?=$field["name$langPrefix"]?></td>
	<td>
		На складе <b id="goodsOnStore"><?=$item['onStore']?></b> &nbsp;&nbsp;
		Временно <b><?=$item['tmpStore']?></b> &nbsp;&nbsp;
		Продано <b><?=$item['soldStore']?></b> &nbsp;&nbsp;
		Всего <b id="goodsAll"><?=$item['store']?></b> &nbsp;&nbsp;
		<button onclick="showStoreWindow('<?=$item['id']?>', '<?=$params['option']?>')">Управление</button>
	</td>
</tr></table>
<div id="barcodeContainer"></div>
<script>
function showStoreWindow(id, table){
	startPreloader();
	var paction = "ajax=showStoreWindow";
	paction += "&id="+id;
	paction += "&table="+table;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			html = (html=='')?'{}':html;
			var data = eval("("+html+")");
			//console.log(html);
			stopPreloader();
			var inner = "<div align=\"\" style=\"padding-left:50px;\">";
			inner += "<input type=\"number\" id=\"addToStore\" style=\"width:50px;height:25px;\" />&nbsp;&nbsp;&nbsp;";
			inner += "<button onclick=\"addGoodToStore('"+data.id+"', '"+data.table+"')\">Добавить</button><br/><br/>";
			inner += "<input type=\"number\" id=\"removeFromStore\" style=\"width:50px;height:25px;\" />&nbsp;&nbsp;&nbsp;";
			inner += "<button onclick=\"removeGoodFromStore('"+data.id+"', '"+data.table+"')\">Списать</button><br/><br/>";
			inner += "Всего таваров: <b>"+data.store+"</b>";
			inner += "</div>";
			document.getElementById("popup_title").innerHTML = "Управление товаром на складе";
			document.getElementById("popup_cont").innerHTML = inner;
			__popup({"width":"300","height":"100"});
		}
	});
}
//******************************************
function addGoodToStore(id, table){
	startPreloader();
	var paction = "ajax=addGoodToStore";
	paction += "&id="+id;
	paction += "&table="+table;
	paction += "&qtty="+document.getElementById("addToStore").value;
	console.log(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			html = (html=='')?'{}':html;
			var data = eval("("+html+")");
			//console.log(html);
			showStoreWindow(id, table);
			document.getElementById("goodsAll").innerHTML = data.store;
			document.getElementById("goodsOnStore").innerHTML = data.onStore;
		}
	});
}
//******************************************
function removeGoodFromStore(id, table){
	startPreloader();
	var paction = "ajax=removeGoodFromStore";
	paction += "&id="+id;
	paction += "&table="+table;
	paction += "&qtty="+document.getElementById("removeFromStore").value;
	console.log(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			html = (html=='')?'{}':html;
			var data = eval("("+html+")");
			//console.log(html);
			showStoreWindow(id, table);
			document.getElementById("goodsAll").innerHTML = data.store;
			document.getElementById("goodsOnStore").innerHTML = data.onStore;
		}
	});
}
//******************************************
</script>