<?
$online=true;
$table = $_GET['table'];
$id = $_GET['id'];

if($online){
	$host="localhost";
	$dbname="alisa-x";
	$dbusername="root"; 
	$dbpassword=""; 
}

function dbgo(){
	global $host, $dbusername, $dbpassword, $dbname;
	$link=mysql_connect($host,$dbusername,$dbpassword) or die ("ERROR 1 - Can't connect to database");
	$s=mysql_select_db($dbname, $link) or die("ERROR 2 - DB selection failure");
	$resp = mysql_query("SET NAMES cp1251");
	return true;
} // end of function dbgo()
dbgo();
header('Content-Type: text/html; charset=CP1251');

//$query = "SELECT * FROM `$table` WHERE `id`='$id' ";
$query = "SELECT * FROM `items` WHERE `id`='18' ";
//echo $query."<br/>";
$resp = mysql_query($query);
//echo $resp;
$item = mysql_fetch_assoc($resp);

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Штрих код PHP</title>
    <style>
       body {
         padding: 0;
       }
       /*
         Наклейка
       */
       .b-sticker {
         width: 45%;
         padding: 3mm;
         float: left;
         font-family: Arial;
         border: 1px dashed black;
         page-break-inside: avoid;
       }
       .b-sticker table {
         width: 99%;
         border-collapse: collapse;
       }
       .b-sticker tr td {
         /*padding: 2mm;*/
       }
       .b-sticker tr:first-child td {
         /*border-bottom: 1mm solid #000;*/
       }
       .b-sticker tr td p {
         margin: 0;
         padding-bottom: 1mm;
       }

       /* Штрихкод код PHP*/
       .barcode {
         width: 100%;
       }

       /* Размеры шрифтов */
       .b-sticker .seller {
         font-size: 4mm;
       }
       .b-sticker .number {
			 font-size: 20px;
       }
       .b-sticker .customer-info {
         font-size: 3.8mm;
       }
       .b-sticker .customer-info .date,
       .b-sticker .customer-info .price,
       .b-sticker .customer-info .name,
       .b-sticker .customer-info .phone {
       }
       .b-sticker .punkt-info {
         font-size: 3.5mm;
       }
	   .phone{
	   	margin-top:20px;
	   }
     </style>    
  </head>
  
  <body>
    
<?php
$pkgs = array(
  array('shop' => 'Магазин "Великан"', 'sku' => '000019', 'skuu' => '000020', 'skuuu' => '000021', 'skuuuu' => '000022', 'skuuuuu' => '000023', 'skuuuuuu' => '000024',  'skuuuuuuu' => '000025','price' => '1000', 'name_item' => 'Курточка темно синяя размер 60/62', 'buyer_fio' => 'ИП Пригоренко М.А.', 'buyer_phone' => '+7(952) 185-12-82'),
);
?>


<?php foreach ($pkgs as $item): ?>
      <div class="b-sticker" style="width:380px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="customer-info" colspan="2">
				<table height="160" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" height="100">
						  <div class="number">Куртка осеняя красная 60<?php //echo $item['name_item'] ?></div>
						  <!--<div class="number"><?php //echo $item['sku'] ?></div>
						  <div class="date">25 мая 2013</div>-->
					  </td>
					</tr>
					<tr>
						<td valign="bottom">
						  <div class="price">Цена: <span style="font-size:20px;"><B>2400<?php //echo $item['price'] ?></B></span> р.</div>
						  <div class="phone"><?php echo $item['buyer_phone'] ?></div>
						</td>
					</tr>
			  </table>
            </td>
            <td width="160" align="right" style="padding-left:5px" valign="top">
              <div class="name"><?php echo $item['buyer_fio'] ?></div>
              <div class="seller"><?php echo $item['shop'] ?></div>
<br />
              <div style="float:right;"><div class="barcode" ><?php echo barcode::code39($item['sku']); ?></div></div>
			  <div style="font-size:12px; padding-top:20px; margin-top:55px;">ул. Металлургов 94<br />(ост. Машколледж)</div>
            </td>
          </tr>
         <!-- <tr>
            <td><img src="logo.png" alt=""></td>
            <td class="punkt-info" colspan="2">
              <p>
                Центр выдачи интернет-товаров
                10.00 - 21.00, без обеда
              </p>
              <p>
                Санкт-Петербург, пр-кт Народного ополчения 10
          <shy/>(812) 000-11-22
          </p>
          </td>
          </tr>-->
        </table>
      </div>

      <div class="b-sticker" style="width:380px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="customer-info" colspan="2">
				<table height="160" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" height="100">
						  <div class="number">Курточка темно синяя размер 60/62<?php //echo $item['name_item'] ?></div>
						  <!--<div class="number"><?php //echo $item['sku'] ?></div>
						  <div class="date">25 мая 2013</div>-->
					  </td>
					</tr>
					<tr>
						<td valign="bottom">
						  <div class="price">Цена: <span style="font-size:20px;"><B>8600<?php //echo $item['price'] ?></B></span> р.</div>
						  <div class="phone"><?php echo $item['buyer_phone'] ?></div>
						</td>
					</tr>
			  </table>
            </td>
            <td width="160" align="right" style="padding-left:5px" valign="top">
              <div class="name"><?php echo $item['buyer_fio'] ?></div>
              <div class="seller"><?php echo $item['shop'] ?></div>
<br />
              <div style="float:right;"><div class="barcode" ><?php echo barcode::code39($item['skuu']); ?></div></div>
			  <div style="font-size:12px; padding-top:20px; margin-top:55px;">ул. Металлургов 94<br />(ост. Машколледж)</div>
            </td>
          </tr>
         <!-- <tr>
            <td><img src="logo.png" alt=""></td>
            <td class="punkt-info" colspan="2">
              <p>
                Центр выдачи интернет-товаров
                10.00 - 21.00, без обеда
              </p>
              <p>
                Санкт-Петербург, пр-кт Народного ополчения 10
          <shy/>(812) 000-11-22
          </p>
          </td>
          </tr>-->
        </table>
      </div>

      <div class="b-sticker" style="width:380px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="customer-info" colspan="2">
				<table height="160" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" height="100">
						  <div class="number">Курточка темно синяя размер 62/64<?php //echo $item['name_item'] ?></div>
						  <!--<div class="number"><?php //echo $item['sku'] ?></div>
						  <div class="date">25 мая 2013</div>-->
					  </td>
					</tr>
					<tr>
						<td valign="bottom">
						  <div class="price">Цена: <span style="font-size:20px;"><B>8600<?php //echo $item['price'] ?></B></span> р.</div>
						  <div class="phone"><?php echo $item['buyer_phone'] ?></div>
						</td>
					</tr>
			  </table>
            </td>
            <td width="160" align="right" style="padding-left:5px" valign="top">
              <div class="name"><?php echo $item['buyer_fio'] ?></div>
              <div class="seller"><?php echo $item['shop'] ?></div>
<br />
              <div style="float:right;"><div class="barcode" ><?php echo barcode::code39($item['skuuu']); ?></div></div>
			  <div style="font-size:12px; padding-top:20px; margin-top:55px;">ул. Металлургов 94<br />(ост. Машколледж)</div>
            </td>
          </tr>
         <!-- <tr>
            <td><img src="logo.png" alt=""></td>
            <td class="punkt-info" colspan="2">
              <p>
                Центр выдачи интернет-товаров
                10.00 - 21.00, без обеда
              </p>
              <p>
                Санкт-Петербург, пр-кт Народного ополчения 10
          <shy/>(812) 000-11-22
          </p>
          </td>
          </tr>-->
        </table>
      </div>

      <div class="b-sticker" style="width:380px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="customer-info" colspan="2">
				<table height="160" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" height="100">
						  <div class="number">Курточка темно синяя размер 64/66<?php //echo $item['name_item'] ?></div>
						  <!--<div class="number"><?php //echo $item['sku'] ?></div>
						  <div class="date">25 мая 2013</div>-->
					  </td>
					</tr>
					<tr>
						<td valign="bottom">
						  <div class="price">Цена: <span style="font-size:20px;"><B>8600<?php //echo $item['price'] ?></B></span> р.</div>
						  <div class="phone"><?php echo $item['buyer_phone'] ?></div>
						</td>
					</tr>
			  </table>
            </td>
            <td width="160" align="right" style="padding-left:5px" valign="top">
              <div class="name"><?php echo $item['buyer_fio'] ?></div>
              <div class="seller"><?php echo $item['shop'] ?></div>
<br />
              <div style="float:right;"><div class="barcode" ><?php echo barcode::code39($item['skuuuu']); ?></div></div>
			  <div style="font-size:12px; padding-top:20px; margin-top:55px;">ул. Металлургов 94<br />(ост. Машколледж)</div>
            </td>
          </tr>
         <!-- <tr>
            <td><img src="logo.png" alt=""></td>
            <td class="punkt-info" colspan="2">
              <p>
                Центр выдачи интернет-товаров
                10.00 - 21.00, без обеда
              </p>
              <p>
                Санкт-Петербург, пр-кт Народного ополчения 10
          <shy/>(812) 000-11-22
          </p>
          </td>
          </tr>-->
        </table>
      </div>

      <div class="b-sticker" style="width:380px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="customer-info" colspan="2">
				<table height="160" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" height="100">
						  <div class="number">Курточка темно синяя размер 66/68<?php //echo $item['name_item'] ?></div>
						  <!--<div class="number"><?php //echo $item['sku'] ?></div>
						  <div class="date">25 мая 2013</div>-->
					  </td>
					</tr>
					<tr>
						<td valign="bottom">
						  <div class="price">Цена: <span style="font-size:20px;"><B>8600<?php //echo $item['price'] ?></B></span> р.</div>
						  <div class="phone"><?php echo $item['buyer_phone'] ?></div>
						</td>
					</tr>
			  </table>
            </td>
            <td width="160" align="right" style="padding-left:5px" valign="top">
              <div class="name"><?php echo $item['buyer_fio'] ?></div>
              <div class="seller"><?php echo $item['shop'] ?></div>
<br />
              <div style="float:right;"><div class="barcode" ><?php echo barcode::code39($item['skuuuuu']); ?></div></div>
			  <div style="font-size:12px; padding-top:20px; margin-top:55px;">ул. Металлургов 94<br />(ост. Машколледж)</div>
            </td>
          </tr>
         <!-- <tr>
            <td><img src="logo.png" alt=""></td>
            <td class="punkt-info" colspan="2">
              <p>
                Центр выдачи интернет-товаров
                10.00 - 21.00, без обеда
              </p>
              <p>
                Санкт-Петербург, пр-кт Народного ополчения 10
          <shy/>(812) 000-11-22
          </p>
          </td>
          </tr>-->
        </table>
      </div>

      <div class="b-sticker" style="width:380px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="customer-info" colspan="2">
				<table height="160" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" height="100">
						  <div class="number">Пальто светло фиолетовое 64<?php //echo $item['name_item'] ?></div>
						  <!--<div class="number"><?php //echo $item['sku'] ?></div>
						  <div class="date">25 мая 2013</div>-->
					  </td>
					</tr>
					<tr>
						<td valign="bottom">
						  <div class="price">Цена: <span style="font-size:20px;"><B>6500<?php //echo $item['price'] ?></B></span> р.</div>
						  <div class="phone"><?php echo $item['buyer_phone'] ?></div>
						</td>
					</tr>
			  </table>
            </td>
            <td width="160" align="right" style="padding-left:5px" valign="top">
              <div class="name"><?php echo $item['buyer_fio'] ?></div>
              <div class="seller"><?php echo $item['shop'] ?></div>
<br />
              <div style="float:right;"><div class="barcode" ><?php echo barcode::code39($item['skuuuuuu']); ?></div></div>
			  <div style="font-size:12px; padding-top:20px; margin-top:55px;">ул. Металлургов 94<br />(ост. Машколледж)</div>
            </td>
          </tr>
         <!-- <tr>
            <td><img src="logo.png" alt=""></td>
            <td class="punkt-info" colspan="2">
              <p>
                Центр выдачи интернет-товаров
                10.00 - 21.00, без обеда
              </p>
              <p>
                Санкт-Петербург, пр-кт Народного ополчения 10
          <shy/>(812) 000-11-22
          </p>
          </td>
          </tr>-->
        </table>
      </div>

      <div class="b-sticker" style="width:380px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="customer-info" colspan="2">
				<table height="160" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" height="100">
						  <div class="number">Пальто светло фиолетовое 66<?php //echo $item['name_item'] ?></div>
						  <!--<div class="number"><?php //echo $item['sku'] ?></div>
						  <div class="date">25 мая 2013</div>-->
					  </td>
					</tr>
					<tr>
						<td valign="bottom">
						  <div class="price">Цена: <span style="font-size:20px;"><B>6500<?php //echo $item['price'] ?></B></span> р.</div>
						  <div class="phone"><?php echo $item['buyer_phone'] ?></div>
						</td>
					</tr>
			  </table>
            </td>
            <td width="160" align="right" style="padding-left:5px" valign="top">
              <div class="name"><?php echo $item['buyer_fio'] ?></div>
              <div class="seller"><?php echo $item['shop'] ?></div>
<br />
              <div style="float:right;"><div class="barcode" ><?php echo barcode::code39($item['skuuuuuuu']); ?></div></div>
			  <div style="font-size:12px; padding-top:20px; margin-top:55px;">ул. Металлургов 94<br />(ост. Машколледж)</div>
            </td>
          </tr>
         <!-- <tr>
            <td><img src="logo.png" alt=""></td>
            <td class="punkt-info" colspan="2">
              <p>
                Центр выдачи интернет-товаров
                10.00 - 21.00, без обеда
              </p>
              <p>
                Санкт-Петербург, пр-кт Народного ополчения 10
          <shy/>(812) 000-11-22
          </p>
          </td>
          </tr>-->
        </table>
      </div>

<?php endforeach; ?>

<script>
//window.print();
</script>

  </body>
</html>

<?php
class barcode {

  protected static $code39 = array(
    '0' => 'bwbwwwbbbwbbbwbw', '1' => 'bbbwbwwwbwbwbbbw',
    '2' => 'bwbbbwwwbwbwbbbw', '3' => 'bbbwbbbwwwbwbwbw',
    '4' => 'bwbwwwbbbwbwbbbw', '5' => 'bbbwbwwwbbbwbwbw',
    '6' => 'bwbbbwwwbbbwbwbw', '7' => 'bwbwwwbwbbbwbbbw',
    '8' => 'bbbwbwwwbwbbbwbw', '9' => 'bwbbbwwwbwbbbwbw',
    'A' => 'bbbwbwbwwwbwbbbw', 'B' => 'bwbbbwbwwwbwbbbw',
    'C' => 'bbbwbbbwbwwwbwbw', 'D' => 'bwbwbbbwwwbwbbbw',
    'E' => 'bbbwbwbbbwwwbwbw', 'F' => 'bwbbbwbbbwwwbwbw',
    'G' => 'bwbwbwwwbbbwbbbw', 'H' => 'bbbwbwbwwwbbbwbw',
    'I' => 'bwbbbwbwwwbbbwbw', 'J' => 'bwbwbbbwwwbbbwbw',
    'K' => 'bbbwbwbwbwwwbbbw', 'L' => 'bwbbbwbwbwwwbbbw',
    'M' => 'bbbwbbbwbwbwwwbw', 'N' => 'bwbwbbbwbwwwbbbw',
    'O' => 'bbbwbwbbbwbwwwbw', 'P' => 'bwbbbwbbbwbwwwbw',
    'Q' => 'bwbwbwbbbwwwbbbw', 'R' => 'bbbwbwbwbbbwwwbw',
    'S' => 'bwbbbwbwbbbwwwbw', 'T' => 'bwbwbbbwbbbwwwbw',
    'U' => 'bbbwwwbwbwbwbbbw', 'V' => 'bwwwbbbwbwbwbbbw',
    'W' => 'bbbwwwbbbwbwbwbw', 'X' => 'bwwwbwbbbwbwbbbw',
    'Y' => 'bbbwwwbwbbbwbwbw', 'Z' => 'bwwwbbbwbbbwbwbw',
    '-' => 'bwwwbwbwbbbwbbbw', '.' => 'bbbwwwbwbwbbbwbw',
    ' ' => 'bwwwbbbwbwbbbwbw', '*' => 'bwwwbwbbbwbbbwbw',
    '$' => 'bwwwbwwwbwwwbwbw', '/' => 'bwwwbwwwbwbwwwbw',
    '+' => 'bwwwbwbwwwbwwwbw', '%' => 'bwbwwwbwwwbwwwbw'
  );

  public static function code39($text) {
    if (!preg_match('/^[A-Z0-9-. $+\/%]+$/i', $text)) {
      throw new Exception('Ошибка ввода');
    }

    $text = '*'.strtoupper($text).'*'; 
    $length = strlen($text);
    $chars = str_split($text);
    $colors = '';

    foreach ($chars as $char) {
      $colors .= self::$code39[$char];
    }

    $html = '
            <div style=" float:left;">
            <div>';

    foreach (str_split($colors) as $i => $color) {
      if ($color=='b') {
        $html.='<SPAN style="BORDER-LEFT: 0.02in solid; DISPLAY: inline-block; HEIGHT: 0.4in;"></SPAN>';
      } else {
        $html.='<SPAN style="BORDER-LEFT: white 0.02in solid; DISPLAY: inline-block; HEIGHT: 0.4in;"></SPAN>';
      }
    }

    $html.='</div>
            <div style="float:left; width:100%;" align=center >'.$text.'</div></div>';
    //echo htmlspecialchars($html);
    echo $html;
  }

}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
