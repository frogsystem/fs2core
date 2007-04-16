<?php
include_once 'stringparser_bbcode.class.php';

function convertlinebreaks ($text) {
    return preg_replace ("/\015\012|\015|\012/", "\n", $text);
}

function bbcode_stripcontents ($text) {
    return preg_replace ("/[^\n]/", '', $text);
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

function do_bbcode_quote ($action, $attributes, $content, $params, $node_object) {
	global $global_config_arr;
	global $db;
	
	if ($action == 'validate') {
		return true;
	}
	
	if (!isset ($attributes['default'])) {
		$index = mysql_query("SELECT quote_tag FROM fs_template WHERE id = '$global_config_arr[design]'", $db);
		$quote_tag = stripslashes(mysql_result($index, 0, "quote_tag"));
		
		$parsed = str_replace('{text}', $content, $quote_tag);
	} else {
		$index = mysql_query("SELECT quote_tag_name FROM fs_template WHERE id = '$global_config_arr[design]'", $db);
		$quote_tag_name = stripslashes(mysql_result($index, 0, "quote_tag_name"));
		
		$parsed = $quote_tag_name;
		$parsed = str_replace('{author}', $attributes['default'], $parsed);
		$parsed = str_replace('{text}', $content, $parsed);
	}
	
	return $parsed;
}

function do_bbcode_img ($action, $attributes, $content, $params, $node_object) {
    if ($action == 'validate') {
        return true;
    }
    
    if (!isset ($attributes['default'])) {
	    return '<img src="'.htmlspecialchars($content).'" alt="">';
    }
    
    return '<img src="'.htmlspecialchars($content).'" align="'.htmlspecialchars($attributes['default']).'" float="'.htmlspecialchars($attributes['default']).'" alt="">';
}

?>