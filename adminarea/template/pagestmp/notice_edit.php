<style>
ul.qq-upload-list{
	margin: 0px;
	padding: 0px;
}
ul.qq-upload-list li{
	list-style-type: none;
}
div.qq-upload-button{
	height: 30px;
	background-color:#FFFFD9;
}
div.qq-upload-button:hover{
	background-color:#FFFFBF;
}
div.qq-upload-drop-area{
	height: 30px;
	background-color:#D8FE89;
}
div.qq-upload-drop-area-active{
	height: 30px;
	background-color:#8AFE52;
}
span.qq-uploader-progress{
	display:block;
	height:10px;
	width: 200px;
	border: 1px solid #CCCCCC;
	background-color: #C4F3FF;
	text-align:left;
	margin: 5px;
}
span.qq-uploader-progress span{
	display:block;
	height:10px;
	width: 20px;
	background-color: #8EADFD;
}
span.qq-uploader-progress-active{
	display:block;
	height:10px;
	width: 200px;
	border: 1px solid #CCCCCC;
	background-color: #8EADFD;
	margin: 5px;
}
#popup{
    position: absolute;
    border: 1px solid;
    width: 200px;
    background-color: antiquewhite;    
}

img.loadimg{
	background-color: #E6E6E6;
	padding: 2px;
	border: 2px solid #CCCCCC;	
}
ul#usercabinetprofile{
	margin:0;
	padding:0;
	width: 360px;
	background-color:#33FF66;
}
ul#usercabinetprofile li{
	list-style-type:none;
	float:left;
	width:115px;
	height: 110px;
}
a.deleteloadimg{
	position:relative;
	margin: 0px;
	display:block;
	top: -106px;
	left: 95px;
	width:20px;
}
</style>
<h2>Редактирование объявления</h2>
<? //echo "<pre>"; print_r($notice); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($filters); echo "</pre>"; ?>
<? //echo "<pre>"; print_r($images); echo "</pre>"; ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="340" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td width="" valign="top"  bgcolor="#66CCCC"><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="150" height="30">Название</td>
              <td><input name="text" type="text" id="noticeName" value="<?=$notice['name']?>" /></td>
            </tr>
            <tr>
              <td width="150" height="30">Путь</td>
              <td><input name="text2" type="text" id="noticeLink" value="<?=$notice['link']?>" />
			  <? //echo "<pre>"; print_r($filters); echo "</pre>"; ?></td>
            </tr>
            <? if(is_array($filters)){ foreach($filters as $filter){ ?>
            <tr>
              <td width="150" height="30"><?=$filter['name']?></td>
              <td><input name="text2" type="text" id="filter_<?=$filter['fieldname']?>" value="<?=$notice[$filter['fieldname']]?>" /></td>
            </tr>
            <? } } ?>
            <tr>
              <td height="30">&nbsp;</td>
              <td><button onclick="saveNotice()">Сохранить</button>
                  
                <button onclick="__css_itemShowCSS_close()">Отменить</button></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td style="padding-bottom:5px;padding-top:5px;"><div id="file-uploader">
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
        <td><ul id="usercabinetprofile">
            <?
			if(is_array($images)){
				foreach($images as $image){
					echo "<li id=\"imgId_$image[id]\"><img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
					echo "resize_x=100&resize_y=100&link=loadimages/".$image['name']."\" width=\"100\" height=\"100\" class=\"loadimg\" />";
					echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteImage('".$image['id']."')\" ";
					echo "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
					echo "</li>";
				}
			}
			?>
        </ul></td>
      </tr>
    </table></td>
    <td valign="top"><textarea style="width:100%;height:100%;" id="myPageContent"><?=$notice['content']?></textarea></td>
  </tr>
</table>
<script>
filters = new Array();
<?  foreach ($filters as $key=>$filter){
	echo "filters[$key]='$filter[fieldname]'\n";
}
?>
//*********************************
function saveNotice(){
	var paction =  "ajax=saveNotice";
	paction += "&noticeId=<?=$notice['id']?>";
	paction += "&noticeName="+encodeURIComponent(document.getElementById("noticeName").value);
	paction += "&noticeLink="+document.getElementById("noticeLink").value;
	paction += "&noticeContent="+encodeURIComponent(document.getElementById("myPageContent").value);
	//paction += "&filterType="+document.getElementById("filterType").value;
	//paction += "&filterDatatype="+document.getElementById("filterDatatype").value;
	//paction += "&filterFieldName="+document.getElementById("sel_fieldname").value;
	if(filters){
		for(var j=0; j<filters.length; j++){
			//alert("filter_"+filters[j]);
			paction += "&filter_"+filters[j]+"="+encodeURIComponent(document.getElementById("filter_"+filters[j]).value);
		}
	}
	//alert(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			if(data.return=='ok'){
				__css_itemShowCSS_close();
			}else{
				alert("Ошибка редактирования");
			}
		}
	});
}
//*********************************
function insertImgModule(fileId){
    //alert(fileId);
	var id = fileId;
    id = id.split(".")[0];
	var innerObj = document.getElementById("usercabinetprofile");
	var inner = "<li id=\"imgId_"+fileId.replace(/\.[a-zA-Z]*$/, '');
	inner += "\"><img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
	inner += "resize_x=100&resize_y=100&link=loadimages/"+fileId+"\" width=\"100\" height=\"100\" class=\"loadimg\" />";
	inner += "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteImage('"+fileId.replace(/\.[a-zA-Z]*$/, '')+"')\" ";
	inner += "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
	inner += "</li>";
	innerObj.innerHTML += inner;    
}
//*********************************
var TinyActive = false;
function initTinyMCE(){
    var language = 'rus';
    tinymce.init({
        language: language,
        selector: 'textarea',
		height: 500,
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code'
		],
		toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		content_css: [
			'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
			'//www.tinymce.com/css/codepen.min.css'
		],
        setup: function (ed) {
            ed.on('init', function(args) {
                TinyActive = true;
            });
        },
    });
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
				//alert(html);
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
var currentNoticeId = '<?=$notice['id']?>';
initTinyMCE();
startFileUploader();
</script>

