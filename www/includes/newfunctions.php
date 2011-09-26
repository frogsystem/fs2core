<?php
/////////////////////////////////
//// Initialize empty string ////
/////////////////////////////////
function initstr (&$string) {
    settype($string, "string");
    $string = "";
}

//////////////////////////////////////////////
//// Enclose any string into any html tag ////
//////////////////////////////////////////////
function htmlenclose ($TEXT, $TAG) {
    return "<".$TAG.">".$TEXT."</".$TAG.">";
}

/////////////////////////////////////
//// empty with trim for strings ////
/////////////////////////////////////
function emptystr ($text) {
    $text = trim($text);
    return empty($text);
}

///////////////////////////////////////////////////////////////////
//// Kill HTML for output in textareas and inputs empty string ////
///////////////////////////////////////////////////////////////////
function killhtml ($VAL, $ARR = true) {
    // save data
    if (is_array($VAL)) {
        if ($ARR)
            $VAL = array_map("killhtml", $VAL);
    } elseif (is_hexcolor($VAL)) {
    }
    elseif (is_numeric($VAL)) {
        if (floatval($VAL) == intval($VAL)) {
            $VAL = intval($VAL);
            settype($VAL, "integer");
        } else {
            $VAL = floatval($VAL);
            settype($VAL, "float");
        }
    } else {
        $VAL = htmlspecialchars(strval($VAL), ENT_COMPAT);
        settype($VAL, "string");
    }
    
    return $VAL;
}


///////////////////////////////
//// Make User String safe ////
///////////////////////////////
function usersave ($string, $HTMLOK = false) {
	$string = kill_replacements($string);
	return $HTMLOK ? $string : htmlspecialchars($string, ENT_QUOTES);
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



/////////////////////////////////
//// validation of lang dirs ////
/////////////////////////////////
function is_language_text ($TEXT) {
    if (preg_match("/[a-z]{2}_[A-Z]{2}/", $TEXT ) === 1) {
        return true;
    } else {
        return false;
    }
}

//////////////////////////////////
//// validation of a hexcolor ////
//////////////////////////////////
function is_hexcolor ($COLOR) {
    return (preg_match ('/\#([a-fA-F0-9]{6})$/', $COLOR) > 0);
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



//////////////////////////////////
//// convert hex to rgb color ////
//////////////////////////////////
function hex2dec_color ($COLOR) {
    if (is_hexcolor($COLOR)) {
        $return['r'] = hexdec(substr($COLOR, 0, 2));
        $return['g'] = hexdec(substr($COLOR, 2, 2));
        $return['b'] = hexdec(substr($COLOR, 4, 2));
        return $return;
    } else {
        return false;
    }
}

///////////////////////////
//// recursic in_array ////
///////////////////////////
function in_arrayr ($value, $array) {
    foreach($array as $item) {
        if(!is_array($item)) {
            if ($item == $value) return true;
            else continue;
        }
       
        if(in_array($value, $item)) return true;
        else if(in_arrayr($value, $item)) return true;
    }
    return false;
}  


///////////////
//// oneof ////
///////////////
function oneof () {
	$numargs = func_num_args();
	if ($numargs >= 2) {
		$comp = func_get_arg(0);
		for ($i=1; $i<$numargs; $i++) {
			if ($comp == func_get_arg($i))
				return true;
		}
	}
	return false;
}

//////////////////////////////////////////////
//// make cross product of array elements ////
//////////////////////////////////////////////
function array_values_by_keys ($arr, $keys) {
    $new = array();
	foreach ($arr as $key => $ele) {
        if (in_array($key, $keys))
            $new[] = $ele;
    }    
    return $new;
}

//////////////////////////////////////////////
//// make cross product of array elements ////
//////////////////////////////////////////////
function array_cross ($arr1, $arr2, $func) {
    $new = array();
	foreach ($arr1 as $ele1) {
        foreach ($arr2 as $ele2) {
            $result = $func($ele1, $ele2);
            if ($result > 0)
                continue 2;
            if ($result < 0)
                continue;

            $new[] = $ele1;    
        }
    }
    return $new;
}

////////////////////////////////////////////////////////
//// make sym diff of two arrays with user callback ////
////////////////////////////////////////////////////////
function array_symdiff ($arr1, $arr2, $func) {
    return array_udiff(
        array_merge($arr1, $arr2),
        array_uintersect($arr1, $arr2, $func),
        $func
    );
}

/////////////////////////////////////////////////////////////
//// merge two arrays with real union and user-callbacks ////
//// it merges the intersection with the sym diff, so    ////
//// each element is unique                              ////
//// first callback is used for the intersection         ////
//// second callback is used for the sym diff            ////
/////////////////////////////////////////////////////////////
function array_real_merge ($arr1, $arr2, $intersect, $symdiff) {
    return array_merge(
        array_cross($arr1, $arr2, $intersect),
        array_symdiff($arr1, $arr2, $symdiff)
    );
}



///////////////////////
//// debug print_r ////
///////////////////////
function print_d ($text, $return = false) {    
    if ($return) {
        $string = "<pre>";
        $string .= print_r($text, true);
        $string .= "</pre>";
        return $string;
    } else {
        echo "<pre>";
        print_r($text);
        echo "</pre>";   
    }
}


?>
