<?
//��������� �������� ������ � ������� JPG !!!
//� ���������������, �. �������. mailto: intert@rambler.ru
//��� ������ ���������� � ������� RRR:GGG:BBB  � ���������� $bgcolor=255:255:255 (����� ���)
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
if(!$link) exit(); //���� �� ����� ���� � ��������� �����, �� �����
if(!isset($resize) && !isset($resize_x)) exit(); // ���� �� ����� ������ - ���� �����

$image = $link; //���������� $image �������� ���� � ��������� �����

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
//���������� �������� ������ �����������:
//$new_w = ������ ������������ �����������
//$new_h = ������ ������������ �����������
//---------------------------------------------------------
if(preg_match("/(\.gif$|\.GIF$)/", $image)){
	$image_in = imagecreatefromgif($image);
}elseif(preg_match("/(\.png$|\.PNG$)/", $image)){
	$image_in = imagecreatefrompng($image);
}else{
	$image_in=imagecreatefromjpeg($image);
}
//---------------------------------------------------------
//����������� ������ � ������ ����������� ������������ � ����� $new_w(������);$new_h(������) - ��. ����.
//		$image_in=imagecreatefromjpeg($image); //������� ������ $image_in, � ������� ����� �������� ��������� �����������
//************************
$img_w = imagesx($image_in);  //������ �����������
$img_h = imagesy($image_in); //������ �����������
//---------------------------------------------------------
$coef = $img_w / $img_h;
//echo "coef = $coef<br/>\n";
if(isset($resize)){
	$new_w = $resize; // ����������� ������
	$new_h = $new_w / $coef; // ����������� ������
	//echo $new_w."x".$new_h."<br/>\n";
}else{ //����� ��� ����� ������ ���������� $resize_x � $resize_y
	$new_w = $resize_x; // ����������� ������
	$new_h = $resize_y; // ����������� ������
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
$max_w = $new_w; //����������� ���������� ������ �� ��� �
$max_h = $new_h; //����������� ���������� ������ �� ��� �
	//������� ����������� ������� ������� (� www.frukt-studio.biz)  �� ����������� ���� ������� {--
	if ($max_h<imagesy($image_in) || $max_w<imagesx($image_in)) {
		//*************************
		if ($max_w/imagesx($image_in)>=$max_h/imagesy($image_in)) {
			$img_w = imagesx($image_in)*$max_h/imagesy($image_in);  //������ ����������� (� ������������ � ������)
			$img_h = $max_h;  //������ ����������� (� ������������ � �������������� ������)
		} else {
			$img_w = $max_w;  //������ ����������� (� ������������ � �������������� ������)
			$img_h = imagesy($image_in)*$max_w/imagesx($image_in);  //������ ����������� (� ������������ c ������)
		}
	}
	//     --}
	// ��������������� ����������� �� ���� � � �
	if($flex=='1'){
		$img_w = $new_w;
		$img_h = $new_h;
		$center_x = $max_w/2-$new_w/2;
		$center_y = $max_h/2-$new_h/2;
	}else{
		$center_x = $max_w/2-$img_w/2;
		$center_y = $max_h/2-$img_h/2;
	}
	
$image_out=imagecreatetruecolor($new_w,$new_h); //������� ������ ��������� �����������
if(!isset($bgcolor)){
	$bgcolor = false;
}
if(!$bgcolor){
	$bg = imagecolorallocate($image_out, 255,255,255); //���������� ��� �����������:
}  else  {
	$bgcolor =  explode(":", $bgcolor);
	$bg = imagecolorallocate($image_out, $bgcolor[0],$bgcolor[1],$bgcolor[2]); //������ ��� �����������:
}

//�������� ������������� ��������� ����������� �����:
imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
//���������� � ������������� ��������� �����������, ������� ������, �������� �����������:
imagecopyresampled($image_out,$image_in,$center_x,$center_y,0,0, $img_w,$img_h,imagesx($image_in),imagesy($image_in));


if(!isset($subtitr)){
	$subtitr = false;
}
if($subtitr){
	$img_logo=imagecreatefrompng($subtitr); //������� ������ ����������� ��������
	//��������� ��������� �������� �������� ��������, ����� ���������� ������ �����������
	if($new_w>=600 && $new_h>=600) 
		$logo_w = 600;
	elseif($new_w>=600 && $new_h<600) 
		$logo_w = $new_h;
	else
		if($new_h>=$new_w) $logo_w = $new_w;
		else $logo_w = $new_h;
	//��������������� ����������� ��������
	$center_x = 10; //$new_w/2 - $logo_w/2;
	$center_y = $new_h/2 - $logo_w/2;
	// ��������� �������� �� �����������:
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
	//imagejpeg($image_out, '', 90); //�������� ����������� � ��������� 75% (���� �� ����������� ��������)
	imagejpeg($image_out, NULL, 90); //�������� ����������� � ��������� 75% (���� �� ����������� ��������)
}
?>