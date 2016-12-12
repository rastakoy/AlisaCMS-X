<? //echo "<pre>"; print_r($settings); echo "</pre>"; ?>
<style>
div.divAdmin{
	background-color: #EEEEEE;
	padding: 4px;
	padding-left: 10px;
	margin-bottom: 3px;
	margin-right: 3px;
	border-radius: 6px;
	border: 1px solid #999999;	
	width:150px;
	float:left;
}
div.divAdminButton{
	padding: 4px;
	padding-left: 10px;
	margin-bottom: 3px;
	margin-right: 3px;
	border-radius: 6px;
	border: 1px solid #999999;	
	width:150px;
	cursor:pointer;
	background-color: #DBE9D1;
	font-weight: bold;
	color:#009900;
	float:none;
	clear:both;
}
div.divAdminButton:hover{
	background-color: #EDF4E8;
}
/****************************/
img.imgAdmin{
	float:right;
	margin-top:-2px;
	border-radius:6px;
	margin-right: 2px;
	cursor:pointer;
}
</style>
<h2>Настройка сайта</h2>
<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DADADA">
  <tr>
    <th height="35" width="200" align="left">Название</th>
    <th width="100">Значение</th>
	<th width="40">&nbsp;</th>
	<th width="100">Индекс</th>
    <th>Комментарий</th>
  </tr>
  <? foreach($settings as $setting){ if($setting['arrayName']=='admins'){ ?>
  <tr>
  	<td width="200" height="35" bgcolor="#FFFFFF" style="padding-top:10px;" valign="top"><b><?=$setting['name']?></b></td>
    <td width="100" bgcolor="#FFFFFF" colspan="4"><? foreach($admins as $admin){ ?>
		<div class="divAdmin"><?=$admin['login']?>
		<img src="/adminarea/template/images/green/myitemname_popup/delete_item.gif" class="imgAdmin"
		onclick="deleteAdmin('<?=$admin['id']?>')" />
		<!--<img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" class="imgAdmin"
		onclick="editAdmin('<?=$admin['id']?>')" />-->
		</div>
	<? } ?>
	<div class="divAdminButton" onclick="showAddAdmin()">Добавить админа</div>
	<div id="addAdmin" style="display:none;">
		<table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="100" height="30">Логин</td>
              <td><input type="text" id="newLogin" placeholder="Login" style="width:150px;"></td>
            </tr>
            <tr>
              <td width="100" height="30">Пароль</td>
              <td><input type="password" id="newPassword" placeholder="Password" style="width:150px;"></td>
            </tr>
            <tr>
              <td colspan="2" height="30"><button onclick="addAdmin()">Добавить</button>
			  <button onclick="showAddAdmin()">Отменить</button></td>
			</tr>
          </table>
      </div>
  <? }else{  ?>
  <tr>
    <td width="200" height="35" bgcolor="#FFFFFF"><b><?=$setting['name']?></b></td>
    <td width="100" bgcolor="#FFFFFF" <? if($setting['arrayName']=="languages"){ ?> colspan="4"<? } ?>>
	<? if($setting['value']=='Да'){ ?>
		<input type="checkbox" id="setting_<?=$setting['id']?>" checked="checked" >
	<? }elseif($setting['value']=="Нет"){ ?>
		<input type="checkbox" id="setting_<?=$setting['id']?>" >
	<? }elseif($setting['arrayName']=="languages"){
		echo "<div class=\"ui-state-default-3 ui-sortable\" id=\"myitems_sortable\" style=\"padding:3px;border:0;\">";
		foreach($GLOBALS['languages'] as $key=>$lang){
			echo "<div id=\"divLang_$key\" class=\"divLang\" onclick=\"if(!dellang){getPage('languages/$key');}\">$lang[1] ";
			echo "<img src=\"/adminarea/template/images/green/icons/mtm_delete_small.gif\" ";
			echo "style=\"float:right;\" onclick=\"deleteLanguage('$key')\" />";
			echo "</div>";
		}
		echo "</div>";
		echo "<div class=\"divLang_addLanguage\" onclick=\"addNewLanguage()\">+ Добавить</div>";
	?>
	<input type="text" id="setting_<?=$setting['id']?>" style="display:none;" value="<?=$setting['value']?>">
	<? }else{ ?>
		<input type="text" id="setting_<?=$setting['id']?>" style="width:100%;padding:3px;" value="<?=$setting['value']?>">
	<? } } ?>
	</td>
	<? if($setting['arrayName']!='admins' && $setting['arrayName']!='languages'){ ?>
		<td width="40" bgcolor="#FFFFFF" align="center"><?=$setting['unit']?></td><? } ?>
	<td width="100" bgcolor="#FFFFFF" <? if($setting['arrayName']=='admins' || $setting['arrayName']=='languages'){ ?>style="display:none;"<? } ?> >
		<input type="text" id="index_<?=$setting['id']?>" style="width:100%;padding:3px;"
		
		value="<?=$setting['arrayName']?>">
	</td>
	<td bgcolor="#FFFFFF" <? if($setting['arrayName']=='admins' || $setting['arrayName']=='languages'){ ?>style="display:none;"<? } ?> >
	<?=$setting['comment']?></td>
  </tr>
  <? } ?>
</table>
<div align="center" style="margin-top:10px;">
<button style="padding:5px;" onclick="saveSettings()">Сохранить</button>&nbsp;&nbsp;
<button style="padding:5px;" onclick="__css_itemShowCSS_close()">Отменить</button></div>
<script>
var ids = new Array();
<? foreach($settings as $key=>$setting){ echo "ids[$key]='$setting[id]';\n"; } ?>
//***********************
$( "#myitems_sortable" ).sortable({
	update: function() {
		var priors = $('#myitems_sortable').sortable('toArray');
		//alert(priors);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "ajax=saveLanguagesPrior&parent=<?=$filterParent['id']?>&ids="+priors,
			success: function(html) {
				//alert(html);
				getPage('settings/');
			}
		});
	}
});
//***********************
var dellang = false;
function deleteLanguage(lang){
	dellang = true;
	var conf = "Вы действительно желаете удалить этот язык из списка?\n";
	conf += "ВНИМАНИЕ, все поля, содержащие данные, введенные на данном языке будут удалены безвозвратно!";
	if(confirm(conf)){
		var paction = "ajax=deleteLanguage&language="+lang;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				dellang = false;
				getPage("settings/");
				//__css_itemShowCSS_close();
			}
		});
	}
	return false;
}
//***********************
function addNewLanguage(){
	var paction = "ajax=addNewLanguage";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			getPage("settings/");
			//__css_itemShowCSS_close();
		}
	});
}
//***********************
function saveSettings(){
	var paction = "ajax=saveSettings";
	for(var j=0; j<ids.length; j++){
		var id = ids[j];
		if(document.getElementById("index_"+id).value=="admins"){
			//alert("test");
		}else if(document.getElementById("setting_"+id).type=="checkbox"){
			if(document.getElementById("setting_"+id).checked){
				paction += "&param_"+id+"=Да";
			}else{
				paction += "&param_"+id+"=Нет";
			}
		}else{
			paction += "&param_"+id+"="+encodeURIComponent(document.getElementById("setting_"+id).value);
		}
		paction += "&index_"+id+"="+document.getElementById("index_"+id).value;
	}
	//alert(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			__css_itemShowCSS_close();
		}
	});
}
//***********************
function showAddAdmin(){
	var obj = document.getElementById('addAdmin');
	if(obj.style.display=="none"){
		obj.style.display="";
	}else{
		obj.style.display="none";
	}
}
//***********************
function addAdmin(){
	var paction = "ajax=addAdmin";
	var login = document.getElementById("newLogin").value;
	var pass = document.getElementById("newPassword").value;
	if(login==''){
		 document.getElementById("newLogin").style.backgroundColor = "#FFD7D7";
		return false;
	}else{
		 document.getElementById("newLogin").style.backgroundColor = "#E7FFD7";
	}
	if(pass==''){
		 document.getElementById("newPassword").style.backgroundColor = "#FFD7D7";
		return false;
	}else{
		 document.getElementById("newPassword").style.backgroundColor = "#E7FFD7";
	}
	paction += "&login="+encodeURIComponent(login);
	paction += "&pass="+encodeURIComponent(pass);
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			var data = eval("("+html+")");
			if(data.return=='ok'){
				getPage('/adminarea/settings');
			}else if(data.return=='used'){
				alert('Такой администратор есть в системе');
				document.getElementById("newLogin").style.backgroundColor = "#FFD7D7";
			}else if(data.return=='superadmin'){
				alert('Такой администратор есть в системе');
				document.getElementById("newLogin").style.backgroundColor = "#FFD7D7";
			}else if(data.return=='error'){
				alert('Неизвестная ошибка');
				document.getElementById("newLogin").style.backgroundColor = "#FFD7D7";
			}
		}
	});
}
//***********************
function deleteAdmin(adminId){
	if(confirm('ВАы действительно желаете удалить этого администратора?')){
		var paction = "ajax=deleteAdmin&adminId="+adminId;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				getPage('/adminarea/settings');
			}
		});
	}
	//alert("delete");
}
//***********************
function editAdmin(){
	//alert("edit");
}
//***********************
</script>