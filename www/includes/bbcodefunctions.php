<?php
include_once 'stringparser_bbcode.class.php';

function convertlinebreaks ($text) {
    return preg_replace ("/\015\012|\015|\012/", "\n", $text);
}

function bbcode_stripcontents ($text) {
    return preg_replace ("/[^\n]/", '', $text);
}

function do_bbcode_smilies ($text) {

    global $global_config_arr;
    global $db;

    $index = mysql_query("SELECT virtualhost FROM ".$global_config_arr[pref]."global_config WHERE id = 1", $db);
    $page_url = stripslashes(mysql_result($index, 0, "virtualhost"));
    
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."smilies", $db);
    while ($smilie_arr = mysql_fetch_assoc($index))
    {
        $url = image_url("images/smilies/", $smilie_arr['id']);
        $text = str_replace ($smilie_arr['replace_string'], '<img src="'.$page_url.$url.'" alt="'.$smilie_arr['replace_string'].'" />', $text);
    }
    return $text;
}

function do_bbcode_url ($action, $attributes, $content, $params, $node_object) {
    if ($action == 'validate') {
        return true;
    }
    if (!isset ($attributes['default'])) {
        return '<a href="'.htmlspecialchars ($content).'" target="_blank">'.htmlspecialchars ($content).'</a>';
    }
    return '<a href="'.htmlspecialchars ($attributes['default']).'" target="_blank">'.$content.'</a>';
}

function do_bbcode_homelink ($action, $attributes, $content, $params, $node_object) {

    global $global_config_arr;
    global $db;

    if ($action == 'validate') {
        return true;
    }
    if (!isset ($attributes['default'])) {
        $index = mysql_query("SELECT virtualhost FROM ".$global_config_arr[pref]."global_config WHERE id = 1", $db);
        $page_url = stripslashes(mysql_result($index, 0, "virtualhost"));
        return '<a href="'.$page_url."?go=".htmlspecialchars ($content).'" target="_self">'.$page_url."?go=".htmlspecialchars ($content).'</a>';
    }
        
    $index = mysql_query("SELECT virtualhost FROM ".$global_config_arr[pref]."global_config WHERE id = 1", $db);
    $page_url = stripslashes(mysql_result($index, 0, "virtualhost"));
    return '<a href="'.$page_url."?go=".htmlspecialchars ($attributes['default']).'" target="_self">'.$content.'</a>';
}

function do_bbcode_email ($action, $attributes, $content, $params, $node_object) {
    if ($action == 'validate') {
        return true;
    }
    if (!isset ($attributes['default'])) {
        return '<a href="mailto:'.htmlspecialchars ($content).'">'.htmlspecialchars ($content).'</a>';
    }
    return '<a href="mailto:'.htmlspecialchars ($attributes['default']).'">'.$content.'</a>';
}


function do_bbcode_img ($action, $attributes, $content, $params, $node_object) {
    if ($action == 'validate') {
        return true;
    }

    if (!isset ($attributes['default'])) {
            return '<img src="'.htmlspecialchars($content).'" alt="">';
    }

    return '<img src="'.htmlspecialchars($content).'" align="'.htmlspecialchars($attributes['default']).'" alt="">';
}

function do_bbcode_cimg ($action, $attributes, $content, $params, $node_object) {

    global $global_config_arr;
    global $db;

    if ($action == 'validate') {
        return true;
    }

    if (!isset ($attributes['default'])) {
        $index = mysql_query("SELECT virtualhost FROM ".$global_config_arr[pref]."global_config WHERE id = 1", $db);
        $page_url = stripslashes(mysql_result($index, 0, "virtualhost"));
        return '<img src="'.$page_url."images/content/".htmlspecialchars($content).'" alt="">';
    }
    $index = mysql_query("SELECT virtualhost FROM ".$global_config_arr[pref]."global_config WHERE id = 1", $db);
    $page_url = stripslashes(mysql_result($index, 0, "virtualhost"));
    return '<img src="'.$page_url."images/content/".htmlspecialchars($content).'" align="'.htmlspecialchars($attributes['default']).'" alt="">';
}

function do_bbcode_font ($action, $attributes, $content, $params, $node_object) {

    if ($action == 'validate') {
        if (!isset ($attributes['default'])) { return false; }
        else { return true; }
    }

    if (isset ($attributes['default'])) {
        return '<font face="'.$attributes['default'].'">'.$content.'</font>';
    }
}

function do_bbcode_color ($action, $attributes, $content, $params, $node_object) {

    if ($action == 'validate') {
        if (!isset ($attributes['default'])) { return false; }
        else { return true; }
    }

    if (isset ($attributes['default'])) {
        return '<font color="'.$attributes['default'].'">'.$content.'</font>';
    }
}

function do_bbcode_size ($action, $attributes, $content, $params, $node_object) {

    if ($action == 'validate') {
        if (!isset ($attributes['default'])) { return false; }
        else {
            $font_sizes = array(0,1,2,3,4,5,6,7);
            if (!in_array($attributes['default'], $font_sizes)) { return false; }
            else { return true; }
        }
    }

    if (isset ($attributes['default'])) {
        $arr_num = $attributes['default'];
        $font_sizes_values = array("6pt","7pt","8pt","10pt","12pt","14pt","18pt","24pt");
        return '<span style="font-size:'.$font_sizes_values[$arr_num].';">'.$content.'</span>';
    }
}

function do_bbcode_code ($action, $attributes, $content, $params, $node_object) {

        global $global_config_arr;
        global $db;

        if ($action == 'validate') {
                return true;
        }

        $index = mysql_query("SELECT code_tag FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
        $code_tag = stripslashes(mysql_result($index, 0, "code_tag"));

        $parsed = str_replace('{text}', $content, $code_tag);
        
        return $parsed;
}

function do_bbcode_quote ($action, $attributes, $content, $params, $node_object) {
        global $global_config_arr;
        global $db;
        
        if ($action == 'validate') {
                return true;
        }
        
        if (!isset ($attributes['default'])) {
            $index = mysql_query("SELECT quote_tag FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
            $quote_tag = stripslashes(mysql_result($index, 0, "quote_tag"));
            $parsed = str_replace('{text}', $content, $quote_tag);
        } else {
            $index = mysql_query("SELECT quote_tag_name FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
            $quote_tag_name = stripslashes(mysql_result($index, 0, "quote_tag_name"));
            $parsed = $quote_tag_name;
            $parsed = str_replace('{author}', $attributes['default'], $parsed);
            $parsed = str_replace('{text}', $content, $parsed);
        }
        
        return $parsed;
}

function do_bbcode_noparse ($action, $attributes, $content, $params, $node_object) {
    if ($action == 'validate') {
        return true;
    }
    return $content;
}

?>