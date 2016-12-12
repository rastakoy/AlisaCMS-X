<? $initImages=true; ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<td width="150" height="30">Изображения</td>
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
					</div>
				</td>
			</tr>
			<tr>
				<td height="30" style="padding-bottom:10px;">&nbsp;</td>
				<td><ul id="usercabinetprofile">
						<?
						//echo "<pre>Images:"; print_r($item['tumb']); echo "</pre>";
						if(is_array($item['tumb'])){
							foreach($item['tumb'] as $image){
								$lnk = $classImages->createImageLink("../loadimages", "100x100", $image['name'], true);
								echo "<li id=\"imgId_$image[id]\" class=\"loadimg_li\" style=\" ";
								echo "background-image:url(".preg_replace("/^\.\./", "", $lnk).");\">";
								//echo "<img oncontextmenu=\"ShowPopup(this);return false;\" src=\"/imgres.php?";
								//echo "resize_x=160&resize_y=160&wrapper=1&link=loadimages/".$image['name']."\" class=\"loadimg\" />";
								echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"deleteImage('".$image['id']."')\" ";
								echo "style=\"text-decoration:none;\"><font color=red><b>x</b></font></a>";
								echo "<a class=\"deleteloadimg\" href=\"javascript:\" onclick=\"imageToText('".$image['name']."')\" ";
								echo "style=\"text-decoration:none;\"><font color=red><b>T</b></font></a>";
								echo "</li>";
							}
						}
						?>
					</ul>
					<div style="float:none;clear:both;height:10px;"></div></td>
			  </tr>
			</table>