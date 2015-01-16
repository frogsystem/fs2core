<?php
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

/////////////////////////////////
//// Initialize empty string ////
/////////////////////////////////
function initstr (&$string) {
    settype($string, 'string');
    $string = '';
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

////////////////////////////////////////////////////////////
//// wrapper for  empty(func($value))                   ////
//// e.g. empty(trim($var))    => error                 ////
////      is_empty(trim($var)) => ok                    ////
//// see http://de.php.net/manual/de/function.empty.php ////
////////////////////////////////////////////////////////////
function is_empty ($var) {
    return empty($var);
}






//////////////////////////////////
//// validation of a hexcolor ////
//////////////////////////////////
function is_hexcolor ($COLOR) {
    return (preg_match ('/\#([a-fA-F0-9]{6})$/', $COLOR) > 0);
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


////////////////////////////////////////
//// Decode JSON to Array with UTF8 ////
////////////////////////////////////////
function json_array_decode ($string) {
    
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
    return json_encode(array_map('utf8_encode', $array), JSON_FORCE_OBJECT);
}






/////////////////////////////
//// scandir with filter ////
/////////////////////////////

function scandir_filter ( $FOLDER, $EXTRA = array(), $BAD = array ( '.', '..', '.DS_Store', '_notes', 'Thumbs.db', '.svn' ) )
{
    if ( !is_dir ( $FOLDER ) ) {
        return FALSE;
    }

    $bad = array_merge ( $EXTRA, $BAD );
    $contents = @scandir ( $FOLDER );
    if ( is_array ( $contents ) ) {
        $contents = array_diff ( $contents, $bad );
        natcasesort ( $contents );
    } else {
        $contents = array();
    }
    return $contents;
}


//////////////////////////////////////////////////
//// scandir for files with certain extention ////
//////////////////////////////////////////////////

function scandir_ext ( $FOLDER, $FILE_EXT, $EXTRA = array(), $BAD = array ( '.', '..', '.DS_Store', '_notes', 'Thumbs.db', '.svn' ) )
{
    if ( $files = scandir_filter ( $FOLDER, $EXTRA, $BAD ) ) {
        $file_names = array();
        foreach ( $files as $file ) {
            if ( pathinfo ( $file, PATHINFO_EXTENSION ) == $FILE_EXT ) {
                $file_names[] = pathinfo ( $file, PATHINFO_BASENAME );
            }
        }
        return $file_names;
    }
    return FALSE;
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




///////////////////////
//// debug print_r ////
///////////////////////
function print_d ($text, $return = false) {
    if (!FS2_DEBUG) {
        return '';
    }
    
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
