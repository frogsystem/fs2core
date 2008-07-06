<?php
include ( "../login.inc.php" );

session_start();
unset($_SESSION['rechen_captcha_spam']);
$zahl1 = rand(1,5); //Erste Zahl 1-5
$zahl2 = rand(1,5);  //Zweite Zahl 1-5
$operator = rand(1,3); // + oder - oder *

if ( $operator == 2 && $zahl2 > $zahl1 ) {
	$temp = $zahl1;
	$zahl1 = $zahl2;
	$zahl2 = $temp;
}

if ( $operator == 2 && $zahl1 == $zahl2) {
	$zahl1 = $zahl1 + 1;
}

switch ($operator) {
	case 3:
		$operatorzeichen = " * ";
		$ergebnis = $zahl1 * $zahl2;
		break;
	case 2:
		$operatorzeichen = " - ";
		$ergebnis = $zahl1 - $zahl2;
		break;
	default:
		$operatorzeichen = " + ";
		$ergebnis = $zahl1 + $zahl2;
		break;
}


function encrypt($string, $key) {
$result = '';
for($i=0; $i<strlen($string); $i++) {
   $char = substr($string, $i, 1);
   $keychar = substr($key, ($i % strlen($key))-1, 1);
   $char = chr(ord($char)+ord($keychar));
   $result.=$char;
}
return base64_encode($result);
}

$_SESSION['rechen_captcha_spam'] = encrypt( $ergebnis, $global_config_arr['spam'] ); //Key
$_SESSION['rechen_captcha_spam'] = str_replace("=", "", $_SESSION['rechen_captcha_spam']);

$rechnung = $zahl1.$operatorzeichen.$zahl2." = ?";
$img = imagecreatetruecolor(80,15);
$schriftfarbe = imagecolorallocate($img,13,28,91);
$hintergrund = imagecolorallocate($img,162,162,162);
imagefill($img,0,0,$hintergrund);
imagestring($img, 3, 2, 0, $rechnung, $schriftfarbe);
header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
?>