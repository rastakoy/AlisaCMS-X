<?
$online=true;
$table = $_GET['table'];
$id = $_GET['id'];

if($online){
	$host="localhost";
	$dbname="alisa_x";
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

$query = "SELECT * FROM `$table` WHERE `id`='$id' ";
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
         padding: 2mm;
       }
       .b-sticker tr:first-child td {
         border-bottom: 1mm solid #000;
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
         font-size: 6mm;
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
     </style>    
  </head>
  
  <body>
    
<?php
$pkgs = array(
  array('shop' => 'ООО "Могута"', 'sku' => 'PHP', 'price' => '1000', 'buyer_fio' => 'Авдеев Марк', 'buyer_phone' => '+7921424078'),
);
?>


<?php foreach ($pkgs as $item): ?>
      <div class="b-sticker">
        <table>
          <colgroup>
            <col width="40%">
            <col width="10%">
            <col width="60%">
          </colgroup>
          <tr>
            <td class="customer-info" colspan="2">
              <div class="seller"><?php echo $item['shop'] ?></div>
              <div class="number"><?php echo $item['sku'] ?></div>
              <div class="date">25 мая 2013</div>
              <div class="price"><?php echo $item['price'] ?></div>
              <div class="name"><?php echo $item['buyer_fio'] ?></div>
              <div class="phone"><?php echo $item['buyer_phone'] ?></div>
              </p>
            </td>
            <td>

              <div class="barcode" ><?php echo barcode::code39($item['sku']); ?></div>
            </td>
          </tr>
          <tr>
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
          </tr>
        </table>
      </div>

<?php endforeach; ?>

<script>
window.print();
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
        $html.='<SPAN style="BORDER-LEFT: 0.02in solid; DISPLAY: inline-block; HEIGHT: 1in;"></SPAN>';
      } else {
        $html.='<SPAN style="BORDER-LEFT: white 0.02in solid; DISPLAY: inline-block; HEIGHT: 1in;"></SPAN>';
      }
    }

    $html.='</div>
            <div style="float:left; width:100%;" align=center >'.$text.'</div></div>';
    //echo htmlspecialchars($html);
    echo $html;
  }

}
?>