<?php
class Images extends DatabaseInterface{

	/**
	
	*/
	function convertToJpeg($folder, $file, $source){
		$source = strtolower($source);
		if(preg_match("/\.jpg$/", $source) || preg_match("/\.jpeg$/", $source)){
			return false;
		}elseif(preg_match("/\.png$/", $source)){
			$image_in = imagecreatefrompng($folder.$file);
		}elseif(preg_match("/\.gif$/", $source)){
			$image_in = imagecreatefromgif($folder.$file);
		}
		$img_w = imagesx($image_in);  //Ширина изображения
		$img_h = imagesy($image_in); //Высота изображения
		//$max_w = $new_w; //Максимально допустимая ширина по оси Х
		//$max_h = $new_h; //Максимально допустимая высота по оси У
		$max_w = $img_w; //Максимально допустимая ширина по оси Х
		$max_h = $img_h; //Максимально допустимая высота по оси У
		$new_w = $img_w; // Определение ширины
		$new_h = $img_h; // Определение высоты
		$center_x = $max_w/2-$img_w/2;
		$center_y = $max_h/2-$img_h/2;
		$image_out=imagecreatetruecolor($new_w,$new_h); //Создаем объект выходного изображения
		$bg = imagecolorallocate($image_out, 255,255,255);
		imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
		imagecopyresampled($image_out,$image_in,$center_x,$center_y,0,0, $img_w,$img_h,imagesx($image_in),imagesy($image_in));
		if(file_exists($folder.$file)){
			unlink($folder.$file);
		}
		imagejpeg($image_out, $folder.$file, 85);
	}
	
	/**
	
	*/
	function showItemImageProperties($id){
		echo "{";
		$query = $this->query("SELECT * FROM `images` WHERE `id`='$id' ");
		$image = $query->fetch_assoc();
		$lnk = $this->createImageLink("../loadimages", "250x250", $image['name'], "250x250");
		$lnk = preg_replace("/^.*\.\.\/loadimages\//", '', $lnk);
		echo "\"image\":\"$lnk\"";
		echo ",\"alt\":\"$image[alt]\"";
		echo ",\"title\":\"$image[title]\"";
		echo "}";
	}
	
	/**
	
	*/
	function createImageLink($folder, $tumbs, $name, $wrapper=false){
		if(!is_dir($folder."/".$tumbs)){
			$structure = $folder."/".$tumbs."/";
			mkdir($structure, 0, true);
			chmod($structure, 0777);
		}
		if(file_exists("$folder/$tumbs/$name")){
			return "$folder/$tumbs/$name";
		} else {
			$ress = explode("x", $tumbs);
			$saver = "$folder/$tumbs/$name";
			$this->createImageTumb("$folder/$name", false, $ress[0], $ress[1], $saver, $perc=80, ($wrapper)?($ress[0]+5)."x".($ress[1]+5):false);
			return "$folder/$tumbs/$name";
		}
	}
	
	/**
	
	*/
	function createImageTumb($link, $resize, $resize_x=false, $resize_y=false, $saver=false, $perc=false, $wrapper=false){
		if(!$link) return false;
		$mass = explode("=", $link);
		$link = $mass[0];
		if(!$resize && !$resize_x) return false;
		$image = $link;
		if(!preg_match('/^models_images/', $image) && !preg_match('/(^|^\.\.\/)loadimages/', $image) && !preg_match('/^sp_images/', $image) && !preg_match('/^marks/', $image))
		$image = "loadimages/".$link;
		//echo "image = $image<br/>\n";
		//if(  preg_match(  '/(^\.\.\/)loadimages/', $link  )  )  $image .=  "../".$image;
		
		if($wrapper){
			if(preg_match("/(^[0-9]*$|^[0-9]*(x|:|,|-|;)[0-9]*$)/", $wrapper)){
				//echo "wrapper=".$_GET["wrapper"]."<br/>\n";
				if(preg_match("/(x|:|,|-|;)/", $wrapper, $matches)){
					//print_r($matches);
					//echo "matches = $matches[0] <br/>\n";
					$massoo22 = explode($matches['0'], $wrapper);
					$wrapper = array($massoo22['0'], $massoo22['1']);
					//echo "wrapper=".$wrapper[0].":".$wrapper['1']."<br/>\n";
				}else{
					$wrapper = array($_GET['wrapper'], $wrapper);
					//echo "wrapper=".$wrapper."<br/>\n";
				}
			}
		}
		//---------------------------------------------------------
		if($mass[1]){
			$image = preg_replace("/jpg$/", $mass[1], $link);
		}
		if(preg_match("/(\.gif$|\.GIF$)/", $image)){
			$image_in = imagecreatefromgif($image);
		}elseif(preg_match("/(\.png$|\.PNG$)/", $image)){
			$image_in = imagecreatefrompng($image);
		}else{
			$image_in=imagecreatefromjpeg($image);
		}
		//---------------------------------------------------------
		//$image_in=imagecreatefromjpeg($image); //Создаем объект $image_in, в который будет помещено исходящее изображение
		$img_w = imagesx($image_in);  //Ширина изображения
		$img_h = imagesy($image_in); //Высота изображения
		//---------------------------------------------------------
		$coef = $img_w / $img_h;
		//echo "coef = $coef<br/>\n";
		if($resize){
			$new_w = $resize; // Определение ширины
			$new_h = $new_w / $coef; // Определение высоты
			//echo $new_w."x".$new_h."<br/>\n";
		}else{ //Иначе так будет заданы переменные $resize_x и $resize_y
			$new_w = $resize_x; // Определение ширины
			$new_h = $resize_y; // Определение высоты
		}
		//echo $new_w."x".$new_h."<br/>\n";
		if(is_array($wrapper)){
			if($img_w>=$img_h){
				$new_h = $wrapper['0'];
				$new_w = $wrapper['0'] * $coef;
			}else{
				$new_w = $wrapper['1'];
				$new_h = $wrapper['1'] / $coef;
				//echo "test";
			}
		}
		//echo $new_w."x".$new_h."<br/>\n";
		//---------------------------------------------------------
		$max_w = $new_w; //Максимально допустимая ширина по оси Х
		$max_h = $new_h; //Максимально допустимая высота по оси У
		//---------------------------------------------------------
		//Формула разработанная Оксаной Кочубей (© Интертехнология)  по определению всех величин {--
		if ($max_h<imagesy($image_in) || $max_w<imagesx($image_in)) {
			if ($max_w/imagesx($image_in)>=$max_h/imagesy($image_in)) {
				$img_w = imagesx($image_in)*$max_h/imagesy($image_in);  //Ширина изображения (в соответствии с рамкой)
				$img_h = $max_h;  //Высота изображения (в соответствии с ограничивающей рамкой)
			} else {
				$img_h = imagesy($image_in)*$max_w/imagesx($image_in);  //Высота изображения (в соответствии c рамкой)
				$img_w = $max_w;  //Ширина изображения (в соответствии с ограничивающей рамкой)
			}
		}
		//     --}
		// Отцентровывание изображения по осям Х и У
		$center_x = $max_w/2-$img_w/2;
		$center_y = $max_h/2-$img_h/2;
	
		$image_out=imagecreatetruecolor($new_w,$new_h); //Создаем объект выходного изображения
		if(!$bgcolor){
			$bg = imagecolorallocate($image_out, 255,255,255); //Определяем фон изображения:
		}  else  {
			$bgcolor =  explode(":", $bgcolor);
			$bg = imagecolorallocate($image_out, $bgcolor[0],$bgcolor[1],$bgcolor[2]); //Задаем фон изображения:
		}
		imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
		imagecopyresampled($image_out,$image_in,$center_x,$center_y,0,0, $img_w,$img_h,imagesx($image_in),imagesy($image_in));
	
		if($subtitr){
			$img_logo=imagecreatefrompng($subtitr); //Создаем объект изображения логотипа
			if($new_w>=600 && $new_h>=600) 
				$logo_w = 600;
			elseif($new_w>=600 && $new_h<600) 
				$logo_w = $new_h;
			else
				if($new_h>=$new_w) $logo_w = $new_w;
				else $logo_w = $new_h;
			$center_x = 10; //$new_w/2 - $logo_w/2;
			$center_y = $new_h/2 - $logo_w/2;
			imagecopyresampled($image_out,$img_logo,$center_x,$center_y,0,0, $logo_w,$logo_w,imagesx($img_logo),imagesy($img_logo));
		}
		if($saver){
			if(!$perc) $perc = 90;
			if(file_exists($saver)){
				unlink($saver);
			}
			imagejpeg($image_out, $saver, $perc);
		}
	}
	
	/**
	
	*/
	function setImagesPriors($pid){
		$sprior = 10;
		$mass = explode(",", $pid);
		$pid = false;
		//print_r($mass);
		foreach($mass as $k=>$v){
			$v =  preg_replace("/imgId_/", "", $v);
			//echo "$v\n";
			if($v!="ok"){
				if($sprior==10){
					$qu = "SELECT * FROM `images` WHERE `id`='$v' ";
					$query = $this->query($qu);
					$row = $query->fetch_assoc();
					$pid = $row["parent"];
				}
				$query = $this->query("UPDATE `images` SET `prior`='$sprior' WHERE `id`='$v' ");
				$sprior += 10;
			}
		}
	}
	
	/**
	
	*/
	function removeImage($option, $itemId){
		$q = "SELECT * FROM `images` WHERE `table`='$option' AND `externalId`='$itemId' ";
		echo $q."\n----\n";
		$query = $this->query($q);
		if($query && $query->num_rows > 0){
			while($image=$query->fetch_assoc()){
				print_r($image);
				if(file_exists($GLOBALS['imagesDirectory']."/".$image['name'])){
					unlink($GLOBALS['imagesDirectory']."/".$image['name']);
					echo "unlink ".$GLOBALS['imagesDirectory']."/".$image['name']."\n";
				}
				if($handle = opendir($GLOBALS['imagesDirectory'])) {
					while (false !== ($entry = readdir($handle))) {
						if($entry!="." && $entry!=".." && !preg_match("/\b.jpg\b/i", $entry)){
							echo $entry."\n";
							if(file_exists($GLOBALS['imagesDirectory']."/".$entry."/".$image['name'])){
								unlink($GLOBALS['imagesDirectory']."/".$entry."/".$image['name']);
								echo "unlink ".$GLOBALS['imagesDirectory']."/".$entry."/".$image['name']."\n";
							}
						}
					}
				}
				$delQuery = $this->query("DELETE FROM `images` WHERE `id`='$image[id]' ");
			}
		}
	}
	
	/**
	
	*/
	function imageDegrees($folder, $file, $source){
		
	}
	
}
?>