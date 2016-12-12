<? //print_r($GLOBALS); ?>
<? //echo "<pre>"; print_r($options); echo "</pre>"; ?>
<div style="font-size: 12px;">
	<h2>Настройка языка</h2>
	Выбранный язык: <b><?=$GLOBALS['languages'][$selLang]['1']?></b>
	<? if($GLOBALS['language']==$selLang){ ?>(по умолчанию)<? } ?>
	<? if($selLang!=$GLOBALS['language']){ ?><img src="/adminarea/template/images/green/icons/mtm_edit_small.gif" style="cursor:pointer;"
	onclick="openLanguageEdit()" /><? } ?>
	<div style="float:none;clear:both;"></div>
	<div id="langProp" style="background-color:#F0F0F0;padding-top:10px;margin-top:20px;padding-left:10px;width:600px;display:none;">
		<table width="100%" border="0" cellpadding="1" cellspacing="1" style="">
		  <tr>
			<td width="100">Название полное </td>
			<td width="100">Краткое (лат.) </td>
			<td>Краткое (местн.) </td>
			 <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td height="30" width="100"><input type="text" id="lang_2" value="<?=$GLOBALS['languages'][$selLang]['1']?>" /></td>
			<td width="100"><input type="text" id="lang_0" value="<?=$selLang?>" /></td>
			<td><input type="text" id="lang_1" value="<?=$GLOBALS['languages'][$selLang]['0']?>" /></td>
			 <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td height="30" width="100" colspan="2" align=""><button onclick="saveLanguageField()">Сохранить</button>
			<button onclick="openLanguageEdit()">Отменить</button></td>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</div>
	<ul id="ul_langDB">
	<? foreach($dataBases as $table=>$db){ ?>
		<li class="li_langRoot">Таблица <?=$table?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
		  <tr>
			<td width="110" bgcolor="" height="30">Поле</td>
			<? $lango = $GLOBALS['languages'][$selLang];
			if($selLang!=$GLOBALS['language']){ ?>
			<td bgcolor="" align="center" width="100"><?=$lango['1']?></td>
			<? } ?>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<ul class="ul_langDBSub">
		<? foreach($db as $field){ ?>
			<li class="li_langDBSub">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="">
				  <tr>
					<td width="110" bgcolor="" height="30"><?=$field['Field']?></td>
					<? $lango = $GLOBALS['languages'][$selLang];
					if($selLang!=$GLOBALS['language']){ ?>
					<td bgcolor="" align="center" width="100"><? if($field['hasLang']=='1'){ ?><span id="langField_<?=$field['Field']?>"
						onclick="toggleLanguage(this, '<?=$selLang?>', '<?=$field['Field']?>', '<?=$table?>')"
						class="active" >Отключить</span><?
						}else{ ?><span id="langField_<?=$field['Field']?>"
						onclick="toggleLanguage(this, '<?=$selLang?>', '<?=$field['Field']?>', '<?=$table?>')"
						class="notactive">Включить</span><? } ?></td>
					<? }else{ ?>
					<td bgcolor="" align="center" width="100"><span id="langField_<?=$field['Field']?>"
						onclick="" class="active" >Отключить</span></td>
					<? } ?>
					<td>&nbsp;</td>
				  </tr>
				</table>
			</li>
		<? } ?>
		</ul></li>
	<? } ?>
	</ul>
</div>
<script>
var globalEditLang = false;
function saveLanguageField(){
	globalEditLang = document.getElementById("lang_0").value;
	var paction = "ajax=saveLanguageField";
	paction += "&myLanguage=<?=$selLang?>";
	paction += "&language[]="+encodeURIComponent(document.getElementById("lang_0").value);
	paction += "&language[]="+encodeURIComponent(document.getElementById("lang_1").value);
	paction += "&language[]="+encodeURIComponent(document.getElementById("lang_2").value);
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			getPage("languages/"+globalEditLang);
			globalEditLang = false;
		}
	});
}
//***********************
function openLanguageEdit(){
	obj = document.getElementById("langProp");
	if(obj.style.display=="none"){
		obj.style.display = "";
	}else{
		obj.style.display = "none";
	}
}
//***********************
function toggleLanguage(obj, lang, field, table){
	if(obj.className == "notactive"){
		var conf = "Для данного поля будут созданы мультиязычные поля.\n";
		conf += "Продолжить?";
		if(confirm(conf)){
			obj.className = "active";
			obj.innerHTML = "Отключить";
			paction =  "ajax=addLanguageField&language="+lang+"&field="+field+"&table="+table;
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: paction,
				success: function(html) {
					//alert(html);
				}
			});
		}
	}else{
		var conf = "Желаете отключить мультиязычность для данного поля?\n";
		conf += "Данные мультиязычности будут удалены безвозвратно!!!";
		if(confirm(conf)){
			obj.className = "notactive";
			obj.innerHTML = "Включить";
			paction =  "ajax=deleteLanguageField&language="+lang+"&field="+field+"&table="+table;
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: paction,
				success: function(html) {
					//alert(html);
				}
			});
		}
	}
}
</script>
