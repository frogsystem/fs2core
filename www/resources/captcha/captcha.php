<?php
// Start Session
session_start();

// fs2 include path
set_include_path ( '.' );
define ( 'FS2_ROOT_PATH', './../../', TRUE );

// include db-data
require ( FS2_ROOT_PATH . 'login.inc.php' );

/////////////////////
//// Load Config ////
/////////////////////
$index = mysql_query ( 'SELECT * FROM '.$FD->config('pref').'captcha_config', $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc($index);


////////////////////////
//// Create Captcha ////
////////////////////////
unset( $_SESSION['captcha'] );

//Get Numbers
$n1 = rand ( $config_arr['captcha_first_lower'], $config_arr['captcha_first_upper'] );
$n2 = rand ( $config_arr['captcha_second_lower'], $config_arr['captcha_second_upper'] );

//Get Operator
$operator_array = array();
if ( $config_arr['captcha_use_addition'] == 1 ) {
    $operator_array[] = 1;
}
if ( $config_arr['captcha_use_subtraction'] == 1 ) {
    $operator_array[] = 2;
}
if ( $config_arr['captcha_use_multiplication'] == 1 ) {
    $operator_array[] = 3;
}
$operator_key = array_rand ( $operator_array );
$operator = $operator_array[$operator_key];

//Do some Stuff to create easy arithmetics for subtractions
if ( $config_arr['captcha_create_easy_arithmetics'] == 1 ) {
    if ( $operator == 1 && $n2 > $n1 ) {
        list($n1, $n2) = array($n2, $n1);
    }
    if ( $operator == 1 && $n2 < 0 ) {
        $n2 = abs( $n2 );
        $operator = 2;
    }

    if ( $operator == 2 && $n2 > $n1 ) {
        list($n1, $n2) = array($n2, $n1);
    }
    if ( $operator == 2 && $n2 < 0 ) {
        $n2 = abs( $n2 );
        $operator = 1;
    }
    if ( $operator == 1 && $n1 < 0 ) {
        $n1 = abs( $n1 );
        list($n1, $n2) = array($n2, $n1);
        $operator == 2;
    }
    if ( $operator == 2 && $n1 == $n2 ) {
        if ( ($n1 + 1) <= $config_arr['captcha_first_upper'] ) {
            $n1++;
        } elseif ( ($n2 - 1) >= $config_arr['captcha_second_lower'] ) {
            $n2--;
        }
    }

    if ( $operator == 3 && $n1 < 0 && $n2 <0 ) {
        $n1 = abs( $n1 );
        $n2 = abs( $n2 );
    }
    if ( $operator == 3 && $n2 < 0 && $n1 >=0 ) {
        list($n1, $n2) = array($n2, $n1);
    }
}




//Do Operations
switch ($operator) {
    case 3:
        if ( $config_arr['captcha_show_multiplication_as_x'] == 1 ) {
            $sign = ' x ';
        } else {
            $sign = ' * ';
        }
        $result = $n1 * $n2;
        break;
    case 2:
        $sign = ' - ';
        $result = $n1 - $n2;
        break;
    default:
        $sign = ' + ';
        $result = $n1 + $n2;
        break;
}

//Encrypt Data
function encrypt ( $STRING, $KEY ) {
    $result = '';
    for ( $i = 0; $i < strlen ( $STRING ); $i++ ) {
        $char = substr ( $STRING, $i, 1 );
        $keychar = substr ( $KEY, ( $i % strlen ( $KEY ) ) -1, 1 );
        $char = chr ( ord ( $char )+ord ( $keychar ) );
        $result .= $char;
    }
    return base64_encode ( $result );
}
$_SESSION['captcha'] = encrypt ( $result, $FD->config('spam') ); //Key
$_SESSION['captcha'] = str_replace ( '=', '', $_SESSION['captcha'] );

//Create String
if ( $n2 < 0 ) {
    $n2 = '( '.$n2.' )';
}
$string = $n1.$sign.$n2.' = ?';
if ( $config_arr['captcha_show_questionmark'] == 0 ) {
    $string = str_replace ( ' ?', '', $string );
}
if ( $config_arr['captcha_use_spaces'] == 0 ) {
    $string = str_replace ( ' ', '', $string );
}

//Create Image
$img = imagecreatetruecolor ( $config_arr['captcha_x'], $config_arr['captcha_y'] ) ;

//Colorize Image
$bg_color_value = hex2dec_color ( '#'.$config_arr['captcha_bg_color'] );
$text_color_value = hex2dec_color ( '#'.$config_arr['captcha_text_color'] );

$color_bg = imagecolorallocate ( $img, $bg_color_value['r'], $bg_color_value['g'], $bg_color_value['b'] );
$color_text = imagecolorallocate ( $img, $text_color_value['r'], $text_color_value['g'], $text_color_value['b'] );

//Get Font
if ( $config_arr['captcha_font_size'] == 0 ) {
     $config_arr['captcha_font'] = imageloadfont ( FS2_ROOT_PATH . 'media/php-fonts/'.stripslashes ( $config_arr['captcha_font_file'] ) );
} else {
    $config_arr['captcha_font'] = $config_arr['captcha_font_size'];
}

//Transparent BG?
if ( $config_arr['captcha_bg_transparent'] == 1 ) {
    $color_trans = ImageColorAllocate ( $img, 255-$text_color_value['r'], 255-$text_color_value['g'], 255-$text_color_value['b'] );
    imagefill ( $img, 0, 0, $color_trans);
    imagestring ( $img, $config_arr['captcha_font'], $config_arr['captcha_start_text_x'], $config_arr['captcha_start_text_y'], $string, $color_text );
    ImageColorTransparent ( $img, $color_trans );
} else {
    imagefill ( $img, 0, 0, $color_bg);
    imagestring ( $img, $config_arr['captcha_font'], $config_arr['captcha_start_text_x'], $config_arr['captcha_start_text_y'], $string, $color_text );
}

//Output Image
header('Content-type: image/gif');
imagegif ( $img );
imagedestroy( $img );
?>
