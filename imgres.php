<?
//ПРОГРАММА РАБОТАЕТ ТОЛЬКО С ФАЙЛАМИ JPG !!!
//© Интертехнология, г. Полтава. mailto: intert@rambler.ru
//Фон должен задаваться в формате RRR:GGG:BBB  в переменную $bgcolor=255:255:255 (белый фон)
if(isset($_GET["link"])){
	$link = $_GET["link"];
}
if(isset($_GET["resize"])){
	$resize = $_GET["resize"];
}
if(isset($_GET["resize_x"])){
	$resize_x = $_GET["resize_x"];
	$resize_y = $_GET["resize_y"];
}
if(isset($_GET["flex"])=='1'){
	$flex = '1';
}
if(isset($_GET["wrapper"])){
	if(preg_match("/(^[0-9]*$|^[0-9]*(x|:|,|-|;)[0-9]*$)/", $_GET["wrapper"])){
		//echo "wrapper=".$_GET["wrapper"]."<br/>\n";
		if(preg_match("/(x|:|,|-|;)/", $_GET['wrapper'], $matches)){
			//print_r($matches);
			//echo "matches = $matches[0] <br/>\n";
			$mass = explode($matches['0'], $_GET['wrapper']);
			$wrapper = array($mass['0'], $mass['1']);
			//echo "wrapper=".$wrapper[0].":".$wrapper['1']."<br/>\n";
		}else{
			$wrapper = array($_GET['wrapper'], $_GET['wrapper']);
			//echo "wrapper=".$wrapper."<br/>\n";
		}
	}
}
//echo "<pre>"; print_r($wrapper); echo "</pre>";
if(!$link) exit(); //Если не задан путь к исходному файлу, то выход
if(!isset($resize) && !isset($resize_x)) exit(); // Усли не задан размер - тоже выход

$image = $link; //Переменная $image получает путь к исходному файлу

//if(!preg_match('/^models_images/', $image) && !preg_match('/^loadimages/', $image) && !preg_match('/^sp_images/', $image) && !preg_match('/^marks/', $image))
//$image = "loadimages/".$link;


//if($type == "limages")
//        $image = "limages/".$link;
//if($type == "nimages")
//        $image = "nimages/".$link;
//if($type == "cont_images")
//        $image = "cont_images/".$link;

//$subtitr = "images/gym_sn.png";
//if(eregi("marks/", $link)) $subtitr=false;

//---------------------------------------------------------
//Подготовка размеров нового изображения:
//$new_w = Ширина формируемого изображения
//$new_h = Высота формируемого изображения
//---------------------------------------------------------
if(preg_match("/(\.gif$|\.GIF$)/", $image)){
	$image_in = imagecreatefromgif($image);
}elseif(preg_match("/(\.png$|\.PNG$)/", $image)){
	$image_in = imagecreatefrompng($image);
}else{
	$image_in=imagecreatefromjpeg($image);
}
//---------------------------------------------------------
//Определение высоты и ширины изображения вставленного в рамку $new_w(ширина);$new_h(высота) - см. выше.
//		$image_in=imagecreatefromjpeg($image); //Создаем объект $image_in, в который будет помещено исходящее изображение
//************************
$img_w = imagesx($image_in);  //Ширина изображения
$img_h = imagesy($image_in); //Высота изображения
//---------------------------------------------------------
$coef = $img_w / $img_h;
//echo "coef = $coef<br/>\n";
if(isset($resize)){
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
	//Формула разработана Оксаной Кочубей (© www.frukt-studio.biz)  по определению всех величин {--
	if ($max_h<imagesy($image_in) || $max_w<imagesx($image_in)) {
		//*************************
		if ($max_w/imagesx($image_in)>=$max_h/imagesy($image_in)) {
			$img_w = imagesx($image_in)*$max_h/imagesy($image_in);  //Ширина изображения (в соответствии с рамкой)
			$img_h = $max_h;  //Высота изображения (в соответствии с ограничивающей рамкой)
		} else {
			$img_w = $max_w;  //Ширина изображения (в соответствии с ограничивающей рамкой)
			$img_h = imagesy($image_in)*$max_w/imagesx($image_in);  //Высота изображения (в соответствии c рамкой)
		}
	}
	//     --}
	// Отцентровывание изображения по осям Х и У
	if($flex=='1'){
		$img_w = $new_w;
		$img_h = $new_h;
		$center_x = $max_w/2-$new_w/2;
		$center_y = $max_h/2-$new_h/2;
	}else{
		$center_x = $max_w/2-$img_w/2;
		$center_y = $max_h/2-$img_h/2;
	}
	
$image_out=imagecreatetruecolor($new_w,$new_h); //Создаем объект выходного изображения
if(!isset($bgcolor)){
	$bgcolor = false;
}
if(!$bgcolor){
	$bg = imagecolorallocate($image_out, 255,255,255); //Определяем фон изображения:
}  else  {
	$bgcolor =  explode(":", $bgcolor);
	$bg = imagecolorallocate($image_out, $bgcolor[0],$bgcolor[1],$bgcolor[2]); //Задаем фон изображения:
}

//Заливаем прямоугольник выходного изображения фоном:
imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
//Перемещаем в прямоугольник выходного изображения, изменяя размер, исходное изображение:
imagecopyresampled($image_out,$image_in,$center_x,$center_y,0,0, $img_w,$img_h,imagesx($image_in),imagesy($image_in));


if(!isset($subtitr)){
	$subtitr = false;
}
if($subtitr){
	$img_logo=imagecreatefrompng($subtitr); //Создаем объект изображения логотипа
	//Банальная процедура просчета размеров логотипа, перед наложением поверх изображения
	if($new_w>=600 && $new_h>=600) 
		$logo_w = 600;
	elseif($new_w>=600 && $new_h<600) 
		$logo_w = $new_h;
	else
		if($new_h>=$new_w) $logo_w = $new_w;
		else $logo_w = $new_h;
	//Отцентрирование изображения логотипа
	$center_x = 10; //$new_w/2 - $logo_w/2;
	$center_y = $new_h/2 - $logo_w/2;
	// Наложение логотипа на изображение:
	imagecopyresampled($image_out,$img_logo,$center_x,$center_y,0,0, $logo_w,$logo_w,imagesx($img_logo),imagesy($img_logo));
}

header("Content-type: image/jpeg");
if(isset($_GET["saver"])){
	if($_GET["saver"]){
		$saver = $_GET["saver"];
		$perc = $_GET["perc"];
		if(file_exists($saver)){
			unlink($saver);
		}
		imagejpeg($image_out, $saver, $perc);
	}
} else {
	//imagejpeg($image_out, '', 90); //Выходное изображение с качеством 75% (дабы не перегружать объемами)
	imagejpeg($image_out, NULL, 90); //Выходное изображение с качеством 75% (дабы не перегружать объемами)
}
?>