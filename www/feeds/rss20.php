<?php
###################
## Feed Settings ##
###################

/* FSCode Replacement
 * 
 * Put FSCodes which should be converted to html into $to_html
 * Put FSCodes which should be converted to text into $to_text
 * All the other FSCodes won't be touched at all
 * 
 * List of possible FSCodes:
 * 
 * b, i, u, s, center, url, home, email, img, cimg, list, numlist,
 * font, color, size, code, quote, video, noparse, smilies
 * 
 * */
$to_html = array('b', 'i', 'u', 's', 'center', 'url', 'home', 'email', 'list', 'numlist');
$to_text = array('img', 'cimg', 'font', 'color', 'size', 'code', 'quote', 'video', 'noparse');


/* Shortening Feed Content
 * 
 * Set $shortening = x to cut the News after x chars (including html and fscode).
 * $extension will be added at the end of the content.
 * 
 * Set $shortening = false if you don't want to cut the content. 
 * $extensiion will be ignored.
 * 
 * */ 
$shortening = false;
$extension = "...";


/* Use HTML
 * 
 * Set $use_html = true or false, wheter you want to use HTML in your feed or not.
 * Using HTML is slightly against the RSS-Standard, but mostly all
 * Feed-Readers will show it nevertheless.
 * 
 * Note: If you convert some FSCodes to HTML, this HTML will be also removed.
 * 
 * */ 
$use_html = true;

/* Template Functions
 * 
 * Allowed values: preserve, remove, softpreserve, softremove
 * 
 * Most template functions can't be used within feeds (e.g. applets).
 * So they won't be converted and should be removed.
 * 
 * preserve = don' convert, don't remove text representation
 * remove   = don' convert, remove text representation
 * soft*    = convert if possible, preserve or remove others
 * 
 * */ 
$tpl_functions = "softremove";
 
 
##################
## Settings End ##
##################
 

// Set header
header("Content-type: application/xml");

// Disable magic_quotes_runtime
ini_set('magic_quotes_runtime', 0);

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

// Inlcude DB Connection File
require( FS2_ROOT_PATH . "login.inc.php");
 

//////////////////////////////////
//// DB Connection etablished ////
//////////////////////////////////
if (isset($sql) && $sql->conn() !== false) {
    
    //Include Functions-Files
    include( FS2_ROOT_PATH . "includes/fscode.php");
    include( FS2_ROOT_PATH . "includes/imagefunctions.php");
    include( FS2_ROOT_PATH . "includes/indexfunctions.php");

    //Include Library-Classes
    require ( FS2_ROOT_PATH . "libs/class_template.php" );
    require ( FS2_ROOT_PATH . "libs/class_fileaccess.php" );
    
    // Load virtualhost
    if (is_empty($virtualhost = $FD->cfg('virtualhost'))) {
        $virtualhost = "http://".$_SERVER['HTTP_HOST'];
    }

    // News Config + Infos
    $config_arr = $FD->sql()->getById("news_config", "*", 1);
    
    // Display Feed Header
    echo'<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
    <channel>
        <language>'.$FD->cfg('language').'</language>
        <description>'.utf8_encode(htmlspecialchars($FD->cfg('description'))).'</description>
        <link>'.utf8_encode($virtualhost).'</link>
        <title>'.utf8_encode(htmlspecialchars($FD->cfg('title'))).'</title>';

    // Get News from DB
    $news_arr = $FD->sql()->getData("news", array("news_id", "news_text", "news_title", "news_date"), array(
        'W' => "`news_date` <= ".$FD->env('time')." AND `news_active` = 1",
        'O' => "`news_date` DESC",
        'L' => $config_arr['num_news'],
    ));
    
    
    // Display News items
    foreach ($news_arr as $news) {
        
        // parse fscode in news
        $flags = array(
            'html' => $use_html,
            'paragraph' => true,
            'paragraph_to_text' => !$use_html,
            'tab' => "nbsp",
            'tabsize' => 8,
        );
        $parsed_text = parse_fscode($news['news_text'], $flags, $to_html, $to_text); 
        
        // tpl_funcions
        switch ($tpl_functions) {
            case "remove":
                $parsed_text = remove_tpl_functions($parsed_text, get_all_tpl_functions());
                break;
            case "softremove":
                $parsed_text = tpl_functions ($parsed_text, $FD->cfg('system', 'var_loop'), array("DATE", "VAR", "URL"), false);
                $parsed_text = remove_tpl_functions($parsed_text, get_all_tpl_functions());
                break;
            case "softpreserve":
                $parsed_text = tpl_functions ($parsed_text, $FD->cfg('system', 'var_loop'), array("DATE", "VAR", "URL"));
                break;
            default: // preserve
                break;
        }
        
        // remove any html?
        if (!$use_html)
            $parsed_text = strip_tags($parsed_text);
            
            
        // Cut Text
        
        
        echo '
        <item>
            <title>'.utf8_encode(htmlspecialchars($news['news_title'])).'</title>
            <link>'.utf8_encode(url("comments", array('id' => $news['news_id']), true)).'</link>
            <pubDate>'.utf8_encode(date("r", $news['news_date'])).'</pubDate>
            <description><![CDATA['.utf8_encode($parsed_text).']]></description>
            <guid>'.utf8_encode(url("comments", array('id' => $news['news_id']), true)).'</guid>
        </item>';
    }
    
    // Display Footer
    echo '
    </channel>
</rss>';

}

// Close Connection
unset($sql);
?>
