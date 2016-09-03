<? if($params['action']=='editMenus'){ ?>
<div class="admintitle" style="padding:0px; margin:0px;" >
	<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
	<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	<?  //echo $__page_title; ?>
</div>
<b style="text-transform:uppercase;" id="titlePanel">Редактирование панели «<?=$panel['name']?>»</b>
<div style="height:20px;"></div>
<div class="languagesTabs"><? foreach($GLOBALS['languages'] as $key=>$lang){ ?>
	<span <?
	if((!$params['lang'] && $key==$GLOBALS['language']) || $params['lang']==$key){
		echo "class=\"active\"";
	}else{?>onclick="getData(window.location.pathname+'/<?=$paramsString?>', 'lang', '<?=$key?>')"<? } ?> ><?=$lang['0']?></span>
<? } ?></div><div style="float:none;clear:both;"></div>
<div style="background-color:#A9C9A7; padding:15px;">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Название</td>
		<td><input type="text" id="name" style="width:100%;height:25px;" value="<?=$panel['name']?>"
		onkeyup="addNameToTitle();__GLOBALS.editing=true;" onchange="addNameToTitle();__GLOBALS.editing=true;"></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Ресурс</td>
	  <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25"><input type="checkbox" id="intCheck" onchange="__GLOBALS.editing=true;" 
			<? if($panel['external']=='0'){ echo "checked"; } ?> ></td>
            <td width="110">Внутренний</td>
            <td width="25"><input type="checkbox" id="extCheck" onchange="__GLOBALS.editing=true;" 
			<? if($panel['external']=='1'){ echo "checked"; } ?> ></td>
            <td>Внешний</td>
          </tr>
        </table></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" id="internalTable"
style="display:<? if($panel['external']=='1'){ echo "none"; } ?>" >
	<tr>
		<td width="150" height="30">Таблица</td>
		<td><select id="internalTableSelect" style="width:150px;height:25px;"><? foreach($freeTables as $ftable){ ?>
		<option value="<?=$ftable?>" <? if($ftable==$panel['link']){ echo "selected"; } ?> ><?=$ftable?></option>
		<? } ?></select>
		<button style="width:150px;height:25px;">Удалить таблицу</button>
		</td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="internalTable2"
style="display:<? if($panel['external']=='1'){ echo "none"; } ?>" >
	<tr>
		<td width="150" height="30">&nbsp;</td>
		<td><input type="text" id="addNewTable" style="width:150px;height:25px;" >
		<button style="width:150px;height:25px;">Добавить таблицу</button>
		</td>
	</tr>
</table>


<table width="100%" cellpadding="0" cellspacing="0" border="0" id="externalTable"
style="display:<? if($panel['external']=='0'){ echo "none"; } ?>" >
	<tr>
		<td width="150" height="30">Внешний источник</td>
		<td><input type="checkbox" id="visible" onchange="__GLOBALS.editing=true;" checked=""></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Отображать в меню</td>
		<td><input type="checkbox" id="visible" onchange="__GLOBALS.editing=true;" checked=""></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Древовидность</td>
		<td><input type="checkbox" id="visible" onchange="__GLOBALS.editing=true;" checked=""></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Заголовки</td>
		<td></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Внешний источник</td>
		<td><input type="checkbox" id="visible" onchange="__GLOBALS.editing=true;" checked=""></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">Конструктор блока</td>
		<td><select id="internalTableSelect" style="width:150px;height:25px;"><? foreach($freeTables as $ftable){ ?>
		<option value="<?=$ftable?>" <? if($ftable==$panel['link']){ echo "selected"; } ?> ><?=$ftable?></option>
		<? } ?></select></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" height="30">&nbsp;</td>
		<td><button onclick="saveNewLeftMenuItem()">Сохранить</button>  <button onclick="getPage(window.location.pathname)">Отменить</button></td>
	</tr>
</table>
</div>

<? }else{ ?>

<div class="admintitle" style="padding:0px; margin:0px;" >
	<a href="javascript:" id="add_item_to_cat_button" style="width:85px;" onclick="addNewOption()">Добавить панель</a>
	<a href="javascript:showHelp('catalog');" id="outerhelp">?</a>
	<span style="padding-top:5px; display:block;">&nbsp;<?=$version?></span>
	<?  //echo $__page_title; ?>
</div>
<div style="float:none; clear:both;"></div>


<div style="line-height:25px; margin-top:5px;margin-right:15px;float:left;">

	<b style="text-transform:uppercase;">Настройки панелей в системе управления сайтом</b>
	<div id="adminGlobalSettings" class="adminGlobalSettings" style="display:;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<th class="tdGlobalSettings" width="150" align="left">Название</th>
			<th class="tdGlobalSettings" width="70" align="center">Таблица</th>
			<th class="tdGlobalSettings" width="100" align="center">Ресурс</th>
			<th class="tdGlobalSettings" width="150" align="center">Шаблон</th>
			<!--<th class="tdGlobalSettings" width="70" align="center">Заголовки</th>-->
			<th class="tdGlobalSettings">&nbsp;</th>
			<th class="tdGlobalSettings" width="24">&nbsp;</th>
		</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody id="globalMenus">
		<? foreach($menus as $k=>$menu){ ?>
		<tr bgcolor="#FFFFFF" id="menus_<?=$menu['id']?>" class="trGlobalSettings">
			<td class="tdGlobalSettings" width="150"><?=$menu['name']?></td>
			<td class="tdGlobalSettings" width="70" align="center"><?=$menu['link']?></td>
			<td class="tdGlobalSettings" width="100" align="center"><?=$menu['external']?></td>
			<td class="tdGlobalSettings" width="150" align="center"><?=$menu['filterName']?></td>
			<!--<td class="tdGlobalSettings" width="70" align="center"><a href="javascript:">Редактор</a></td>-->
			<td class="tdGlobalSettings">&nbsp;</td>
			<td class="tdGlobalSettings" width="24" align="center"><a href="javascript:" title="Изменить группу">
			<img src="/adminarea/template/images/green/myitemname_popup/edit_item.gif" border="0"
			onclick="getData('<?=$GLOBALS['adminBase']?>/?action=editMenus,menuId=<?=$menu['id']?>')"></a></td>
			
		</tr>
		<? } ?>
	</tbody></table>
	</div>
</div>
<script>
//*********************************************************
function addNewOption(){
	getData('<?=$GLOBALS['adminBase']?>/?action=editMenus,menuId=0');
}
//*********************************************************
$( "#globalMenus" ).sortable({
	update: function() {
		var priors = $(this).sortable('toArray');
		startPreloader();
		//console.log(priors);
		//return false;
		var paction =  "ajax=setMenusPriors";
		paction += "&ids="+(( priors instanceof Array ) ? priors.join ( ',' ) : priors);
		//console.log(paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				console.log(html);
				//getData('<?=$GLOBALS['adminBase']?>/');
				window.location.href = window.location.pathname;
			}
		});
	}
});
//*********************************************************
$( ".trGlobalSettings" ).dblclick(function () {
	var menuId = this.id.replace(/menus_/gi, '');
	getData('<?=$GLOBALS['adminBase']?>/?action=editMenus,menuId='+menuId)
});
//*********************************************************
</script>

<div style="line-height:25px; margin-top:15px;margin-right:15px;float:left;">
	<b style="text-transform:uppercase;">Основные настройки</b>
	<div id="adminGlobalSettings" class="adminGlobalSettings" style="display:;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody><tr>
						<td class="tdGlobalSettings" width="300">Включить/выключить учет остатков на складе</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="restsOnOff_id" onclick="restsOnOff()"></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Ваш е-mail для уведомлений</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="0066aa@mail.ru, lev-arsenal@mail.ru" id="updateSiteSettingsEmail"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsEmail()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Ваш контактный телефон</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="(050)304-60-82" id="updateSiteSettingsPhone" placeholder="+38(0__) ___-__-__" required="required" pattern="^\+38\(0\d\d\) \d\d\d\-\d\d\-\d\d$"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsPhone()">ok</a></td>
		</tr>
				<tr>
						<td class="tdGlobalSettings" width="300"><b>Уведомлять меня о покупке по SMS</b></td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="sendGoodInfo_id" onclick="sendGoodInfo()" checked  /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
				<tr>
						<td class="tdGlobalSettings" width="300">Тело счета</td>
			<td class="tdGlobalSettings" width=""><a href="javascript:get_fast_order_cont()">Изменить</a></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Автоматически отправлять счет клиенту после покупки</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="sendGoodOrder_id" onclick="sendGoodOrder()" checked  /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Активировать «Тип платежа»</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="sendBasketPayType_id" onclick="sendBasketPayType()" checked  /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Активировать пользовательское соглашение</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="offertOnOff_id" onclick="offertOnOff()"> <a href="javascript:get_fast_offert_cont()">Изменить</a></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Активировать комментарии к товарам</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="reviewsOnOff_id" onclick="reviewsOnOff()" checked=""></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Хранение заказов в корзине</td>
			<td class="tdGlobalSettings" width=""><input type="number" style="width:45px;height:24px;" value="12" id="updateSiteSettingsOrdersKeep"> часов</td>
			<td class="tdGlobalSettings"><a href="javascript:__updateSiteSettingsOrdersKeep()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">META TITLE по умолчанию</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="Мототехника в Полтаве" id="updateSiteSettingsMetaTitleCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsMetaTitle()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">META DESCRIPTION по умолчанию</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="Мототехника в Полтаве" id="updateSiteSettingsMetaDescriptionCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsMetaDescription()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">META KEYWORDS по умолчанию</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="Мототехника в Полтаве" id="updateSiteSettingsMetaKeywordsCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsMetaKeywords()">ok</a></td>
		</tr>
		<tr>
						<td class="tdGlobalSettings" width="300">Банковский процент</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;height:24px;" value="0.5" id="updateBankRentCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateBankRent()">ok</a></td>
		</tr>
		
		<!--<tr>
			<td class="tdGlobalSettings" width="300">Мультивалютность</td>
			<td class="tdGlobalSettings" width="" style="padding-top:5px;"><div id="currencySortable">
				<span class="consolCurrency"><img src="images/green/icons/galochka.gif" width="11" height="11" border="0" align="absmiddle"
						style="margin-right:3px;" />грн &nbsp;&nbsp; &nbsp;<b>1:1</b><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_гривна" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span><span class="consolCurrency"><img src="images/green/myitemname_popup/glaz.gif" id="glaz_рубль" 
						width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;cursor:pointer;"
						onClick="toggleCurrencyShow(this, '1')" />RUR &nbsp;<input type="number" style="width:53px;" onChange="changeCurrency(this, '1')" value="0.35" ><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_рубль" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span><span class="consolCurrency"><img src="images/green/myitemname_popup/glaz.gif" id="glaz_доллар" 
						width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;cursor:pointer;"
						onClick="toggleCurrencyShow(this, '2')" />USD &nbsp;<input type="number" style="width:53px;" onChange="changeCurrency(this, '2')" value="21" ><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_доллар" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span><span class="consolCurrency"><img src="images/green/myitemname_popup/glaz.gif" id="glaz_евро" 
						width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;cursor:pointer;"
						onClick="toggleCurrencyShow(this, '3')" />EUR &nbsp;<input type="number" style="width:53px;" onChange="changeCurrency(this, '3')" value="23" ><img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_евро" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span>			</div></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>-->
		
		<!--<tr>
			<td class="tdGlobalSettings" width="300">Мультиязычность</td>
			<td class="tdGlobalSettings" width="" style="padding-top:5px;"><div id="langsSortable">
				<span class="consolLangs"><img src="images/green/icons/galochka.gif" width="11" height="11" border="0" align="absmiddle"
						style="margin-right:3px;" />рус &nbsp;&nbsp;
					<img src="images/green/myitemname_popup/delete_item.gif" id="imgoptions_rus" 
					width="16" height="16" border="0" align="right" 
					onclick="" />
					</span>			</div></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>-->
		
		<tr>
						<td class="tdGlobalSettings" width="300">Курс доллара</td>
			<td class="tdGlobalSettings" width=""><input type="number" style="width: 75px;height:24px;" value="25" id="updateSiteSettingsDollarCont"></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsDollar()">ok</a></td>
		</tr>
	</tbody></table></div>
	</div>
<? } ?>