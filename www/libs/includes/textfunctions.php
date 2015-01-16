<?php
////////////////////////////////
//// string numurs function ////
////////////////////////////////
function sp_string($number, $singular, $plural) {
    if ($number == 1)
        return $singular;

    return $plural;
}


//////////////////////////////////////////////
//// Enclose any string into any html tag ////
//////////////////////////////////////////////
function htmlenclose ($TEXT, $TAG) {
    return '<'.$TAG.'>'.$TEXT.'</'.$TAG.'>';
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



////////////////////////////////
/////// Number Format   ////////
////////////////////////////////

function point_number ($zahl)
{
    $zahl = number_format($zahl, 0, ',', '.');
    return $zahl;
}



//////////////////////
// convert filesize //
//////////////////////

function getsize ( $SIZE )
{
    $mb = 1024;
    $gb = 1024 * $mb;
    $tb = 1024 * $gb;

    switch (TRUE)
    {
        case ($SIZE < $mb):
            $SIZE = round ( $SIZE, 1 ) . ' KB';
            break;
        case ($SIZE < $gb):
            $SIZE = round ( $SIZE/$mb, 1 ). ' MB';
            break;
        case ($SIZE < $tb):
            $SIZE = round ( $SIZE/$gb, 1 ). ' GB';
            break;
        case ($SIZE > $tb):
            $SIZE = round ( $SIZE/$tb, 1 ). ' TB';
            break;
    }
    return $SIZE;
}





/////////////////////////
// mark word in a text //  <=== DEPRECATED use highlight
/////////////////////////

function markword($text, $word)
{
    return highlight($word, $text, '', 'color:#FF0000; font-weight:bold;');
}

//////////////////////////////////////////////////////////////
// Inserts HTML line breaks before all newlines in a string //
//////////////////////////////////////////////////////////////

function html_nl2br($TEXT, $is_xhtml = false)
{
    $TEXT = nl2br(convertlinebreaks($TEXT), $is_xhtml);
    return $TEXT;
}
function convertlinebreaks ($text) {
    return preg_replace ("/\015\012|\015|\012/", "\n", $text);
}

//////////////////////////////
// Convert tab \t to &nbsp; //
//////////////////////////////

function tab2space($TEXT, $tabsize = 4, $space = '&nbsp;')
{
    $TEXT = preg_replace("/\t/", str_repeat($space, $tabsize), $TEXT);
    return $TEXT;
}

/////////////////////////////////////////
// String kürzen ohne Wort zuzerstören //  <= BAD FUNCTION HAS TO BE IMPROVED TODO
/////////////////////////////////////////
function truncate_string ($string, $maxlength, $extension)
{

   $cutmarker = "**F3rVRB,YQFrK6qpE**cut_here**cc3Z,7L,jVy9bDWY**";

   if (strlen($string) > $maxlength) {
       $string = wordwrap($string, $maxlength-strlen($extension), $cutmarker);
       $string = explode($cutmarker, $string);
       $string = $string[0] . $extension;
   }
   return $string;
}



///////////////////////////////
//// Make User String safe ////
///////////////////////////////
function usersave ($string, $HTMLOK = false) {
	$string = tpl_functions($string, 0);
	return $HTMLOK ? $string : htmlspecialchars($string, ENT_QUOTES);
}

////////////////////////////////////////
//// Kill Replacments-Codes in Text ////
////////////////////////////////////////
function kill_replacements ($TEXT, $KILLHTML = FALSE)
{
    /* @experiment 
     * This should do the exact same thing as the code below, 
     * except for escaping all tpl-functions (e.g. DATE URL)
     * Testing required!
     * */
	$string = tpl_functions($TEXT, 0);
    if ($KILLHTML === true) {
        $string = killhtml($string);
    }
    return $string;
    
/*
    $a = array('{..', '..}', '[%', '%]', '$NAV(', '$APP(', '$VAR(');
    $b = array('&#x7B;&#x2E;&#x2E;', '&#x2E;&#x2E;&#x7D;',  '&#x5B;&#x25;', '&#x25;&#x5D;', '&#x24;NAV&#x28;', '&#x24;APP&#x28;', '&#x24;APP&#x28;', '&#x24;VAR&#x28;');

    $TEXT = str_replace($a, $b, $TEXT);

    if ($KILLHTML === true) {
        return killhtml($TEXT);
    }
    return $TEXT;
*/
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



?>
