<?php
//////////////////////////////////
//// Initialize empty string  ////
//////////////////////////////////
function initstr (&$string) {
    settype($string, "string");
    $string = "";
}

///////////////////////////////////////////////
//// Short string by cutting in the middle ////
///////////////////////////////////////////////
function cut_in_string ($string, $maxlength, $replacement)
{
	if (strlen($string) > $maxlength) {
		$part_lenght = ceil($maxlength/2)-ceil(strlen($replacement)/2);
		$string_start = substr($string, 0, $part_lenght);
		$string_end = substr($string, -1*$part_lenght);
		$string = $string_start . $replacement . $string_end;
	}
	return $string;
}

///////////////////////////////////////////////
//// Short string by cutting in the middle ////
///////////////////////////////////////////////
function cut_string ($string, $maxlength, $replacement)
{
	if (strlen($string) > $maxlength) {
		$string = substr($string, 0, ($maxlength-$replacement)) . $replacement;
	}
	return $string;
}


///////////////////////
//// Localize Date ////
///////////////////////
function date_loc ($DATE_STRING, $TIMESTAMP)
{
    global $TEXT;

    $week_en = array ( "Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday" );
    $month_en = array ( "January","February","March","April","May","June","July","August","September","October","November","December" );
    
    $week_loc = explode(",", $TEXT['frontend']->get("week_days_array"));
    $month_loc = explode(",", $TEXT['frontend']->get("month_names_array"));
    
    $localized_date = str_replace($week_en, $week_loc, date($DATE_STRING, $TIMESTAMP));
    $localized_date = str_replace($month_en,$month_loc, $localized_date);

    return $localized_date;
}

////////////////////////////////////////
//// Kill Replacments-Codes in Text ////
////////////////////////////////////////
function kill_replacements ($TEXT, $KILLHTML = FALSE, $STRIPSLASHES = FALSE)
{
    $a = array('{..', '..}', '[%', '%]', '$NAV(', '$APP(', '$VAR(');
    $b = array('&#x7B;&#x2E;&#x2E;', '&#x2E;&#x2E;&#x7D;',  '&#x5B;&#x25;', '&#x25;&#x5D;', '&#x24;NAV&#x28;', '&#x24;APP&#x28;', '&#x24;APP&#x28;', '&#x24;VAR&#x28;');
    
    $TEXT = str_replace($a, $b, $TEXT);

    if ($KILLHTML === true) {
        return killhtml($TEXT);
    } elseif ($STRIPSLASHES === TRUE) {
        return stripslashes($TEXT);
    }
    return $TEXT;
}




/////////////////////////////////////
//// Check for User Permissions  ////
/////////////////////////////////////
function has_perm ($perm) {
    return (isset($_SESSION[$perm]) && $_SESSION[$perm] === 1);
}
function is_authorized () {
    return ($_SESSION['user_level'] === "authorized");
}

/////////////////////////////////////////
//// Generate random password string ////
/////////////////////////////////////////
function generate_pwd ($LENGHT = 10)
{
    $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $real_strlen = strlen($charset) - 1;
    mt_srand((double)microtime() * 1001000);

    while(strlen($code) < $LENGHT) {
        $code .= $charset[mt_rand (0,$real_strlen)];
    }
    return $code;
}
?>
