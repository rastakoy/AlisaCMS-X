<h2>Управление страницей</h2>
<? //echo "<pre>"; print_r($filter); echo "</pre>"; ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="150" height="30">Название</td>
    <td><input type="text" id="pageName" value="<?=$page['name']?>" /></td>
    <td rowspan="11" valign="top"><textarea name="textarea" style="width:100%;" id="pageCont"><?=$page['cont']?></textarea>
    <!--<div style="padding-top:10px;margin-bottom:10px; border-bottom: solid 1px #666666;"></div>
	<label>Текст укр.</br>
      <textarea name="textarea" style="width:100%;" id="pageText_ukr"><?=$page['cont_ukr']?></textarea>
    </label>-->
	</td>
  </tr>
  <tr>
    <td width="150" height="30">Название короткое</td>
    <td><input type="text" id="pageShortName" value="<?=$page['shortName']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">Путь</td>
    <td><input type="text" id="pageLink" value="<?=$page['link']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">Ссылка</td>
    <td><input type="text" id="pageSite" value="<?=$page['site']?>" /></td>
  </tr>
  <tr>
    <td width="150" height="30">Нижнее меню слева</td>
    <td><select id="pageMenu1" value="<?=$page['menu1']?>"><option value="0" >Отключено</option>
	<option value="1" <? if($page['menu1']=='1'){ echo "selected"; } ?> >Включено</option></select></td>
  </tr>
  <tr>
    <td width="150" height="30">Нижнее меню центр</td>
    <td><select id="pageMenu2" value="<?=$page['menu2']?>"><option value="0" >Отключено</option>
	<option value="1" <? if($page['menu2']=='1'){ echo "selected"; } ?> >Включено</option></select></td>
  </tr>
  <tr>
    <td width="150" height="30">Нижнее меню справа</td>
    <td><select id="pageMenu3" value="<?=$page['menu3']?>"><option value="0" >Отключено</option>
	<option value="1" <? if($page['menu3']=='1'){ echo "selected"; } ?> >Включено</option></select></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><div id="file-uploader">
            <div class="qq-uploader">
              <div class="qq-upload-drop-area" style="display: none;"> <span>Перетащите файлы на этот блок</span> </div>
              <div class="qq-upload-button" style="position: relative; overflow: hidden; direction: ltr;"> Загрузить изображения
                <input multiple="multiple" type="file" value="" name="file" style="position: absolute; right: 0px; 
							top: 0px; z-index: 1; font-size: 460px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;" />
              </div>
              <ul class="qq-upload-list" style="display:none;">
              </ul>
            </div>
        </div></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><ul id="usercabinetprofile">
            <?
			//print_r($images);
			if(is_array($images)){
				foreach($images as $image){
					echo "<li id=\"imgId_$image[id]\"><img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
					echo "resize_x=100&resize_y=100&link=loadimages/".$image['name']."\" width=\"100\" height=\"100\" class=\"loadimg\" />";
					echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteImage('".$image['id']."')\" ";
					echo "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
					echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"imageToText('".$image['name']."')\" ";
					echo "style=\"text-decoration:none;\"><font color=red><b>T</b></font></a>";
					echo "</li>";
				}
			}
			?>
        </ul></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><button onclick="savePage()">Сохранить</button>  
	<button onclick="__css_itemShowCSS_close()">Отменить</button></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
</table>
<script>
//*********************************
function savePage(){
	//alert("tiny_init="+tiny_init);
	if(tiny_init){
		fc_togtiny();
	}
	var paction =  "ajax=savePage";
	paction += "&pageId=<?=$page['id']?>";
	paction += "&pageName="+encodeURIComponent(document.getElementById("pageName").value);
	paction += "&pageShortName="+encodeURIComponent(document.getElementById("pageShortName").value);
	paction += "&pageCont="+encodeURIComponent(document.getElementById("pageCont").value);
	paction += "&pageLink="+document.getElementById("pageLink").value;
	paction += "&pageSite="+encodeURIComponent(document.getElementById("pageSite").value);
	paction += "&pageMenu1="+document.getElementById("pageMenu1").value;
	paction += "&pageMenu2="+document.getElementById("pageMenu2").value;
	paction += "&pageMenu3="+document.getElementById("pageMenu3").value;
	//alert(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			//var data = eval("("+html+")");
			//if(data.return=='ok'){
				__css_itemShowCSS_close();
			//}else{
			//	alert("Ошибка редактирования");
			//}
		}
	});
}
//*********************************
function imageToText(image){
	if(!tiny_init){
		//alert("Текстовый редактор выключен\nНажмите «Редактировать текстовый блок»");
		return false;
	}
	var inner = "<img src=\"/loadimages/"+image+"\" />"
	tinyMCE.get("pageCont").selection.setContent(inner);
}
//*********************************
//var textareaTiny = false;
function fc_togtiny(){
	if(tiny_init){
		tinyMCE.execCommand('mceToggleEditor',false,'pageCont');
		fcont = tinyMCE.get('pageCont').getContent();
		//alert(fcont);
		tinyMCE.execCommand('mceRemoveControl',true,'pageCont');
		tiny_init = false;
		//$("#folder_cont_leg").empty();
		//$("#folder_cont_leg").append("<b>Описание</b> — <a href=\"javascript:fc_togtiny()\">Включить редактор HTML</a>");
		document.getElementById("pageCont").value = fcont;
	} else {
		$("#folder_cont_fl").css("background-color", "#FFFFFF");
		tinymce_init();
		tiny_init = true;
		$("#folder_cont_leg").empty();
		$("#folder_cont_leg").append("<b>Описание</b> — <a href=\"javascript:fc_togtiny()\">Отключить редактор HTML</a>");
	}
}
//*********************************
function insertImgModule(fileId){
    //alert(fileId);
	var id = fileId;
    id = id.split(".")[0];
	var innerObj = document.getElementById("usercabinetprofile");
	var inner = "<li><img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
	inner += "resize_x=100&resize_y=100&link=loadimages/"+fileId+"\" width=\"100\" height=\"100\" class=\"loadimg\" />";
	inner += "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteProfileImg('"+fileId+"')\" ";
	inner += "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
	inner += "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"imageToText('"+fileId+"')\" ";
	inner += "style=\"text-decoration:none;\"><font color=red><b>T</b></font></a>";
	inner += "</li>";
	innerObj.innerHTML += inner;    
}
//*********************************
function deleteImage(imageId){
	if(confirm("Удалить изображение?")){
		var paction =  "ajax=deleteImage";
		paction += "&imageId="+imageId;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				var data = eval("("+html+")");
				if(data.return=='ok'){
					var obj = document.getElementById("imgId_"+data.imgid);
					if(obj){
						obj.parentNode.removeChild(obj);
					}
				}else{
					alert("Ошибка редактирования");
				}
			}
		});
	}
}
//*********************************
currentPageId = '<?=$page['id']?>';
//*********************************

//*********************************
</script>