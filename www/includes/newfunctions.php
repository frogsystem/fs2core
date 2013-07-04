<?php

////////////////////////////////////////////////////
//// returns string representation of           ////
//// any http statuscode for use in http header ////
////////////////////////////////////////////////////
function sp_string($number, $singular, $plural) {
    if ($number == 1)
        return $singular;

    return $plural;
}


////////////////////////////////////////////////////
//// returns string representation of           ////
//// any http statuscode for use in http header ////
////////////////////////////////////////////////////
function http_response_text($code) {

    $status = array(
        '100' => 'Continue',
        '101' => 'Switching Protocols',
        '102' => 'Processing',
        '118' => 'Connection timed out',

        '200' => 'OK',
        '201' => 'Created',
        '202' => 'Accepted',
        '203' => 'Non-Authoritative Information',
        '204' => 'No Content',
        '205' => 'Reset Content',
        '206' => 'Partial Content',
        '207' => 'Multi-Status',

        '300' => 'Multiple Choices',
        '301' => 'Moved Permanently',
        '302' => 'Found',
        '303' => 'See Other',
        '304' => 'Not Modified',
        '305' => 'Use Proxy',
        '307' => 'Temporary Redirect',

        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '402' => 'Payment Required',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '405' => 'Method Not Allowed',
        '406' => 'Not Acceptable',
        '407' => 'Proxy Authentication Required',
        '408' => 'Request Time-out',
        '409' => 'Conflict',
        '410' => 'Gone',
        '411' => 'Length Required',
        '412' => 'Precondition Failed',
        '413' => 'Request Entity Too Large',
        '414' => 'Request-URI Too Long',
        '415' => 'Unsupported Media Type',
        '416' => 'Requested range not satisfiable',
        '417' => 'Expectation Failed',
        '418' => "I'm a Teapot",
        '421' => 'There are too many connections from your internet address',
        '422' => 'Unprocessable Entity',
        '423' => 'Locked',
        '424' => 'Failed Dependency',
        '425' => 'Unordered Collection',
        '426' => 'Upgrade Required',

        '500' => 'Internal Server Error',
        '501' => 'Not Implemented',
        '502' => 'Bad Gateway',
        '503' => 'Service Unavailable',
        '504' => 'Gateway Time-out',
        '505' => 'HTTP Version not supported',
        '506' => 'Variant Also Negotiates',
        '507' => 'Insufficient Storage',
        '509' => 'Bandwidth Limit Exceeded',
        '510' => 'Not Extended',
    );

    if (isset($status[$code]))
        return sprintf('Status: %d %s', $code, $status[$code]);

    return false;
}




////////////////////////////////////////
//// Decode JSON to Array with UTF8 ////
////////////////////////////////////////
function json_array_decode ($string) {
    // JSON for PHP <= 5.2
    require_once(FS2_ROOT_PATH . 'resources/jsonwrapper/jsonwrapper_helper.php');
    
    $data = json_decode($string, true);
    // empty json creates null not emtpy array => error
    if (empty($data)) // prevent this
        $data = array();
    return array_map('utf8_decode', $data);
}
///////////////////////////////////////
//// Encode Array from JSON & UTF8 ////
///////////////////////////////////////
function json_array_encode ($array) {
    // JSON for PHP <= 5.2
    require_once(FS2_ROOT_PATH . 'resources/jsonwrapper/jsonwrapper_helper.php');
    return json_encode(array_map('utf8_encode', $array), JSON_FORCE_OBJECT);
}



/////////////////////////////////
//// Initialize empty string ////
/////////////////////////////////
function initstr (&$string) {
    settype($string, 'string');
    $string = '';
}

//////////////////////////////////////////////
//// Enclose any string into any html tag ////
//////////////////////////////////////////////
function htmlenclose ($TEXT, $TAG) {
    return '<'.$TAG.'>'.$TEXT.'</'.$TAG.'>';
}

/////////////////////////////////////
//// empty with trim for strings ////
/////////////////////////////////////
function emptystr ($text) {
    if (!isset($text))
        return true;

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
            $VAL = array_map('killhtml', $VAL);
    } elseif (is_hexcolor($VAL)) {
    }
    elseif (is_numeric($VAL)) {
        if (floatval($VAL) == intval($VAL)) {
            $VAL = intval($VAL);
            settype($VAL, 'integer');
        } else {
            $VAL = floatval($VAL);
            settype($VAL, 'float');
        }
    } else {
        $VAL = htmlspecialchars(strval($VAL), ENT_QUOTES, 'ISO-8859-1', true);
        settype($VAL, 'string');
    }

    return $VAL;
}


///////////////////////////////
//// Make User String safe ////
///////////////////////////////
function usersave ($string, $HTMLOK = false) {
	$string = tpl_functions($string, 0);
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

//////////////////////////
//// highlight a word ////
//////////////////////////
function highlight ($word, $text, $class = 'red', $style = '')
{
    $style = empty($style) ? '' : "style=\"$style\"";
    $class = empty($class) ? '' : "class=\"$class\"";

    $text = preg_replace("=(.*?)($word)(.*?)=i",
                         "\\1<span $class $style>\\2</span>\\3", $text);
    return $text;
}


////////////////////////
//// create SEO URL ////
////////////////////////
function url_seo ($go, $args, $go_in_args = false) {

	$urlencodeext = create_function ('$url', '
		// Folge von Bindestriche um zwei Striche erweitern
		return urlencode(preg_replace(\'/-+/\', \'$0--\', $url));');

    if ($go_in_args) {
        unset($args['go']);
    }

	$seourl = $urlencodeext($go);

	if (count($args) > 0)
	{
		$seourl .= '--';

		ksort($args);

		foreach ($args as $key => $val)
			$seourl .= $urlencodeext($key) . '-' . $urlencodeext($val) . '-';

		$seourl = substr($seourl, 0, strlen($seourl) - 1);
	}

	if (!empty($seourl))
		$seourl .= '.html';

    return $seourl;
}

////////////////////////////////////
//// parse query part of an url ////
////////////////////////////////////
function parse_url_query($query) {
    $query = explode('&', $query);

    $params = array();
    foreach ($query as $param) {
        $pair = explode('=', $param);
        $params[$pair[0]] = $pair[1];
    }

    return $params;
}




///////////////////////
//// Localize Date ////
///////////////////////
function date_loc ($DATE_STRING, $TIMESTAMP)
{
    global $FD;

    $week_en = array ( 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday' );
    $month_en = array ( 'January','February','March','April','May','June','July','August','September','October','November','December' );

    $week_loc = explode(',', $FD->text('frontend', 'week_days_array'));
    $month_loc = explode(',', $FD->text('frontend', 'month_names_array'));

    $localized_date = str_replace($week_en, $week_loc, date($DATE_STRING, $TIMESTAMP));
    $localized_date = str_replace($month_en,$month_loc, $localized_date);

    return $localized_date;
}

////////////////////////////////////////
//// Kill Replacments-Codes in Text ////
////////////////////////////////////////
function kill_replacements ($TEXT, $KILLHTML = FALSE)
{
    $a = array('{..', '..}', '[%', '%]', '$NAV(', '$APP(', '$VAR(');
    $b = array('&#x7B;&#x2E;&#x2E;', '&#x2E;&#x2E;&#x7D;',  '&#x5B;&#x25;', '&#x25;&#x5D;', '&#x24;NAV&#x28;', '&#x24;APP&#x28;', '&#x24;APP&#x28;', '&#x24;VAR&#x28;');

    $TEXT = str_replace($a, $b, $TEXT);

    if ($KILLHTML === true) {
        return killhtml($TEXT);
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

////////////////////////////////////////////////////////////
//// wrapper for  empty(func($value))                   ////
//// e.g. empty(trim($var))    => error                 ////
////      is_empty(trim($var)) => ok                    ////
//// see http://de.php.net/manual/de/function.empty.php ////
////////////////////////////////////////////////////////////
function is_empty ($var) {
    return empty($var);
}



/////////////////////////////////////
//// Check for User Permissions  ////
/////////////////////////////////////
function has_perm ($perm) {
    return (isset($_SESSION[$perm]) && $_SESSION[$perm] === 1);
}
function is_authorized () {
    return (isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'authorized');
}
function is_loggedin () {
    return ($_SESSION['user_level'] === 'loggedin' || is_authorized ());
}

/////////////////////////////////////////
//// Generate random password string ////
/////////////////////////////////////////
function generate_pwd ($LENGHT = 10)
{
    $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
    $code = '';
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
        $return['r'] = hexdec(substr($COLOR, 1, 2));
        $return['g'] = hexdec(substr($COLOR, 3, 2));
        $return['b'] = hexdec(substr($COLOR, 5, 2));
        return $return;
    } else {
        return false;
    }
}

////////////////////////////////////////////////////////////
//// filter array by given list of keys                 ////
//// all entries with keys not in $keys will be removed ////
////////////////////////////////////////////////////////////
function array_filter_keys ($input, $keys) {
    return array_intersect_key($input, array_flip($keys));
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
	} else {
        return true;
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
        $string = '<pre>';
        $string .= print_r($text, true);
        $string .= '</pre>';
        return $string;
    } else {
        echo '<pre>';
        print_r($text);
        echo '</pre>';
    }
}


?>
