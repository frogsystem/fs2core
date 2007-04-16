<?php
////////////////////////////////
//// Image exists           ////
////////////////////////////////

function image_exists($path, $name)
{
  if ( file_exists("$path"."$name.jpg") OR file_exists("$path"."$name.gif") OR file_exists("$path"."$name.png") )
  {
    return true;
  }
  else
  {
    return false;
  }
}

////////////////////////////////
//// Create Image URL       ////
////////////////////////////////

function image_url($path, $name, $error=true)
{
  if (file_exists("$path"."$name.jpg"))
    $url = $path."$name.jpg";
  elseif (file_exists("$path"."$name.gif"))
    $url = $path."$name.gif";
  elseif (file_exists("$path"."$name.png"))
    $url = $path."$name.png";
  elseif ($error==true)
    $url = "../images/icons/nopic.gif";
  else
    $url = "";

  return $url;
}

////////////////////////////////
//// Delete Image           ////
////////////////////////////////

function image_delete($path, $name)
{
  if ( image_exists($path, $name) )
  {
    unlink(image_url($path, $name, false));
    return true;
  }
  else
  {
    return false;
  }
}

////////////////////////////////
/////// System Message /////////
////////////////////////////////

function sys_message ($title, $message)
{
    global $db;

    $index = mysql_query("select error from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "error"));
    $template = str_replace("{titel}", $title, $template); 
    $template = str_replace("{meldung}", $message, $template);
    echo $template;
    unset($template);
}

////////////////////////////////
/////// Number Format   ////////
////////////////////////////////

function point_number ($zahl)
{
    $zahl = number_format($zahl, 0, ',', '.');
    return $zahl;
}

////////////////////////////////
///// Download Categories //////
////////////////////////////////

function get_dl_categories (&$ids, $cat_id, $id=0, $ebene=-1)
{
    global $db;

    $index = mysql_query("select * from fs_dl_cat where subcat_id = '$id' ORDER BY cat_name", $db);
    while ($zeile = mysql_fetch_assoc($index))
    {
        if ($zeile[cat_id] != $cat_id)
        {
            $zeile[ebene] = $ebene + 1;
            $ids[] = $zeile;
            get_dl_categories ($ids, $cat_id, $zeile[cat_id], $zeile[ebene]);
        }
    }
}

////////////////////////////////
//////// Display News //////////
////////////////////////////////

function display_news ($news_arr, $html_code, $fs_code)
{
    global $db, $global_config_arr;

    $news_arr[news_date] = date("d.m.Y" , $news_arr[news_date]) . " um " . date("H:i" , $news_arr[news_date]);
    $news_arr[comment_url] = "?go=comments&amp;id=$news_arr[news_id]";

    // Kategorie lesen
    $index2 = mysql_query("select cat_name from fs_news_cat where cat_id = $news_arr[cat_id]", $db);
    $news_arr[cat_name] = mysql_result($index2, 0, "cat_name");
    $news_arr[cat_pic] = $news_arr[cat_id] . ".gif";

    // Text formatieren
    $news_arr[news_text] = stripslashes($news_arr[news_text]);
    if ($html_code == 1)
    {
        $news_arr[news_text] = killhtml($news_arr[news_text]);
    }
    if ($fs_code > 1)
    {
        //$news_arr[news_text] = fscode($news_arr[news_text], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
        $news_arr[news_text] = bb2html($news_arr[news_text]);
    }
    else
    {
        $news_arr[news_text] = fscode($news_arr[news_text], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    }

    // User auslesen
    $index2 = mysql_query("select user_name from fs_user where user_id = $news_arr[user_id]", $db);
    $news_arr[user_name] = mysql_result($index2, 0, "user_name");
    $news_arr[user_url] = "?go=profil&amp;userid=$news_arr[user_id]";

    // Kommentare lesen
    $index2 = mysql_query("select comment_id from fs_news_comments where news_id = $news_arr[news_id]", $db);
    $news_arr[kommentare] = mysql_num_rows($index2);

    // Template lesen und füllen
    $index2 = mysql_query("select news_body from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index2, 0, "news_body"));
    $template = str_replace("{newsid}", $news_arr[news_id], $template); 
    $template = str_replace("{titel}", $news_arr[news_title], $template); 
    $template = str_replace("{datum}", $news_arr[news_date], $template); 
    $template = str_replace("{text}", $news_arr[news_text], $template); 
    $template = str_replace("{autor}", $news_arr[user_name], $template); 
    $template = str_replace("{autor_profilurl}", $news_arr[user_url], $template); 
    $template = str_replace("{kategorie_bildname}", $news_arr[cat_pic], $template); 
    $template = str_replace("{kategorie_name}", $news_arr[cat_name], $template); 
    $template = str_replace("{kommentar_url}", $news_arr[comment_url], $template); 
    $template = str_replace("{kommentar_anzahl}", $news_arr[kommentare], $template); 

    $link_tpl = "";
    $index2 = mysql_query("select * from fs_news_links where news_id = $news_arr[news_id] order by link_id", $db);
    while ($link_arr = mysql_fetch_assoc($index2))
    {
        $index3 = mysql_query("select news_link from fs_template where id = '$global_config_arr[design]'", $db);
        $link = stripslashes(mysql_result($index3, 0, "news_link"));
        $link = str_replace("{name}", $link_arr[link_name], $link); 
        $link_arr[link_url] = str_replace("&","&amp;",$link_arr[link_url]);
        $link = str_replace("{url}", $link_arr[link_url], $link); 
        if ($link_arr[link_target] == 1)
        {
            $link_arr[link_target] = "_blank";
        }
        else
        {
            $link_arr[link_target] = "_self";
        }
        $link = str_replace("{target}", $link_arr[link_target], $link); 
        $link_tpl .= $link;
    }
    unset($link_arr);

    if (mysql_num_rows($index2) > 0)
    {
        $index2 = mysql_query("select news_related_links from fs_template where id = '$global_config_arr[design]'", $db);
        $related_links = stripslashes(mysql_result($index2, 0, "news_related_links"));
        $related_links = str_replace("{links}", $link_tpl, $related_links); 

        $template = str_replace("{related_links}", $related_links, $template); 
    }
    else
    {
        $template = str_replace("{related_links}", "", $template); 
    }

    $news_template = $template;

    unset ($template);
    return $news_template;
}

////////////////////////////////
///// Dateigröße umrechnen /////
////////////////////////////////

function getsize($size)
{
    $mb = 1024; 
    $gb = 1024 * $mb; 
    $tb = 1024 * $gb;

    switch (TRUE)
    {
        case ($size < $mb):
            $size = round($size, 1) . " KB";
            break;
        case ($size < $gb):
            $size = round($size/$mb, 1)." MB";
            break;
        case ($size < $tb):
            $size = round($size/$gb, 1)." GB";
            break;
        case ($size > $tb):
            $size = round($size/$tb, 1)." TB";
            break;
    }
    return $size;
}

///////////////////////////////////
// Worte in einem text markieren //
///////////////////////////////////

function markword($text, $word)
{
    $text = preg_replace("=(.*?)$word(.*?)=i", 
                         "\\1<font color=\"red\"><b>$word</b></font>\\2",$text); 
    return $text;
}

////////////////////////////////
// ' aus einem String löschen //
////////////////////////////////

function savesql($text)
{
    $text = trim($text);
    //$text = str_replace ("'","&#039;",$text);
    //$text = str_replace ('"',"&quot;",$text);
    $text = mysql_real_escape_string($text);
    return $text;
}

//////////////////////////////////
// HTML Tags unschädlich machen //
//////////////////////////////////

function killhtml($text)
{
    $text = trim($text);
    $text = str_replace ("'","&#039;","$text");
    $text = str_replace ('"',"&quot;","$text");
    $text = str_replace("<", "&lt;", "$text");
    $text = str_replace(">", "&gt;", "$text");
    return $text;
}

///////////////////////////////////
// Text nach FS Code formatieren //
///////////////////////////////////

function fscode($text, $do_b, $do_i, $do_u, $do_center, $do_url, $do_img, $do_list, $do_color, $do_table, $do_size, $do_code, $do_quote)
{
    $text = str_replace("\r\n","<br>\r",$text);
  
    if ($do_b == 1)
    {
        // [b]...[/b]
        $text=preg_replace("=(.*?)\[b\](.*?)\[/b\]=i", 
                           "\\1<b>\\2</b>",$text); 
    }
    if ($do_i == 1)
    {
        // [i]...[/i]
        $text=preg_replace("=(.*?)\[i\](.*?)\[/i\]=i", 
                           "\\1<i>\\2</i>",$text); 
    }
    if ($do_u == 1)
    {
        // [u]...[/u]
        $text=preg_replace("=(.*?)\[u\](.*?)\[/u\]=i", 
                           "\\1<u>\\2</u>",$text); 
    }
    if ($do_center == 1)
    {
        // [center]...[/center]
        $text=preg_replace("=(.*?)\[center\](.*?)\[/center\]=i", 
                           "\\1<center>\\2</center>",$text); 
    }
    if ($do_list == 1)
    {
        // [list]...[/list]
        $text=preg_replace("=(.*?)\[list\](.*?)\[/list\]=i", 
                           "\\1<ul>\\2</ul>",$text); 
       // [numlist]...[/numlist]
       $text=preg_replace("=(.*?)\[numlist\](.*?)\[/numlist\]=i", 
                          "\\1<ol>\\2</ol>",$text); 
       $text = str_replace("[*]", "<li>", $text);  
    }
    if ($do_img == 1)
    {
        // [img]http://[/img]
        $text=preg_replace("=(.*?)\[img\](http:\/\/|http:\/\/www\.)([^ \"\n\r\t<]*?)\[/img\]=i", 
                           "\\1<img border=\"0\" src=\"\\2\\3\" alt=\"\">",$text); 
        // [img]www.[/img]
        $text=preg_replace("=(.*?)\[img\](www\.)([^ \"\n\r\t<]*?)\[/img\]=i", 
                           "\\1<img border=\"0\" src=\"http://\\2\\3\" alt=\"\">",$text); 
        // [img=right]http://[/img]
        $text=preg_replace("=(.*?)\[img\=right\](http:\/\/|http:\/\/www\.)([^ \"\n\r\t<]*?)\[/img\]=i", 
                           "\\1<img border=\"0\"  src=\"\\2\\3\" align=\"right\" style\=\"float\: right\" alt=\"\">",$text); 
        // [img=left]http://[/img]
        $text=preg_replace("=(.*?)\[img\=left\](http:\/\/|http:\/\/www\.)([^ \"\n\r\t<]*?)\[/img\]=i", 
                           "\\1<img border=\"0\"  src=\"\\2\\3\" align=\"left\" style\=\"float\: left\" alt=\"\">",$text); 
        // [img=right]www.[/img]
        $text=preg_replace("=(.*?)\[img\=right\](www\.)([^ \"\n\r\t<]*?)\[/img\]=i", 
                           "\\1<img border=\"0\"  src=\"http://\\2\\3\" align=\"right\" style\=\"float\: right\" alt=\"\">",$text); 
        // [img=left]www.[/img]
        $text=preg_replace("=(.*?)\[img\=left\](www\.)([^ \"\n\r\t<]*?)\[/img\]=i", 
                           "\\1<img border=\"0\"  src=\"http://\\2\\3\" align=\"left\" style\=\"float\: left\" alt=\"\">",$text); 
    }
    if ($do_url == 1)
    {
        // http://
        $text=preg_replace("=(^|\ |\n)(http:\/\/|http:\/\/www\.)([a-zA-Z0-9\.\/\-\_]{1,})=i", 
                           "\\1<a href=\"\\2\\3\" target=\"_blank\">\\2\\3</a>",$text); 
        // www.
        $text=preg_replace("=(^|\ |\n)(www\.)([a-zA-Z0-9\.\/\-\_]{1,})=i", 
                           "\\1<a href=\"http://\\2\\3\" target=\"_blank\">\\2\\3</a>",$text); 
        // [url]http://[/url]
        $text=preg_replace("=(.*?)\[url\](http:\/\/|http:\/\/www\.)([^ \"\n\r\t<]*?)\[/url\]=i", 
                           "\\1<a href=\"\\2\\3\" target=\"_blank\">\\2\\3</a>",$text); 
        // [url=http://]text[/url]
        $text=preg_replace("=(.*?)\[url\=(http:\/\/|http:\/\/www\.)([^ \"\n\r\t<]*?)\](.*?)\[/url\]=i", 
                           "\\1<a href=\"\\2\\3\" target=\"_blank\">\\4</a>",$text); 
        // [url]www.[/url]
        $text=preg_replace("=(.*?)\[url\](www\.)([^ \"\n\r\t<]*?)\[/url\]=i", 
                           "\\1<a href=\"http://\\2\\3\" target=\"_blank\">\\2\\3</a>",$text); 
        // [url=www.]text[/url]
        $text=preg_replace("=(.*?)\[url\=(|www\.)([^ \"\n\r\t<]*?)\](.*?)\[/url\]=i", 
                           "\\1<a href=\"http://\\2\\3\" target=\"_blank\">\\4</a>",$text); 
        // mail@
        $text=preg_replace("=(^|\ |\n)([a-zA-Z0-9\.\/\-\_]{1,})@([a-zA-Z0-9\.\/\-\_]{1,})=i", 
                           "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>",$text); 
        // [email]
        $text=preg_replace("=(.*?)\[email\]([a-zA-Z0-9\.\/\-\_]{1,})@([a-zA-Z0-9\.\/\-\_]{1,})\[\/email\]=i", 
                           "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>",$text); 
        // [email=]
        $text=preg_replace("=(.*?)\[email\=([a-zA-Z0-9\.\/\-\_]{1,})@([a-zA-Z0-9\.\/\-\_]{1,})\](.*?)\[\/email\]=i", 
                           "\\1<a href=\"mailto:\\2@\\3\">\\4</a>",$text); 
    }
    if ($do_color == 1)
    {
        // [color=...]text[/color]
        $text=preg_replace("=(.*?)\[color\=([a-zA-Z0-9]{1,8})\](.*?)\[/color\]=i", 
                           "\\1<font color=\"\\2\">\\3</font> ",$text); 
        // [color=#...]text[/color]
        $text=preg_replace("=(.*?)\[color\=\#([a-zA-Z0-9]{1,8})\](.*?)\[/color\]=i", 
                           "\\1<font color=\"\\2\">\\3</font> ",$text); 
    }
    if ($do_size == 1)
    {
        // [size=...]text[/size]
        $text=preg_replace("=(.*?)\[size\=([1-8]{1,1})\](.*?)\[/size\]=i", 
                           "\\1<font size=\"\\2\">\\3</font> ",$text); 
    }
    if ($do_table == 1)
    {
        // [table]...[/table]
        $text=preg_replace("=(.*?)\[table\](.*?)\[/table\]=i", 
                           "\\1<table border=\"0\" width=\"100%\">\\2</table>",$text); 
        // [row=...*...]
        $text=preg_replace("=(.*?)\[row\=(.*?)\*(.*?)\]=i", 
                           "\\1<tr><td>\\2</td><td>\\3</td></tr>",$text); 
    }
    if ($do_quote == 1)
    {
        // [quote]...[/quote]
        $text=preg_replace("=(.*?)\[quote\](.*?)\[/quote\]=i", 
                           "\\1<table cellpadding=\"5\" align=\"center\" border=\"0\" width=\"98%\"><tr><td><b><font face=\"verdana\" size=\"2\">Zitat:</font></b></td></tr><tr><td style=\"border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1\">\\2</td></tr></table>",$text); 
        // [quote=...]...[/quote]
        $text=preg_replace("=(.*?)\[quote\=(.*?)\](.*?)\[/quote\]=i", 
                           "\\1<table cellpadding=\"5\" align=\"center\" border=\"0\" width=\"98%\"><tr><td><b><font face=\"verdana\" size=\"2\">Zitat von \\2:</font></b></td></tr><tr><td style=\"border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1\">\\3</td></tr></table>",$text); 
    }
    if ($do_code == 1)
    {
        // [code]...[/code]
        $text=preg_replace("=(.*?)\[code\](.*?)\[/code\]=i", 
                           "\\1<table cellpadding=\"5\" align=\"center\" border=\"0\" width=\"98%\"><tr><td><b><font face=\"verdana\" size=\"2\">Code:</font></b></td></tr><tr><td style=\"border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1\"><span class=\"code\"><code>\\2</code></span></td></tr></table>",$text); 
    }
    return $text;
}

///////////////////////////////////
// Text nach BB Code formatieren //
///////////////////////////////////

function bb2html($text)
{
        include_once 'bbcodefunctions.php';
        
        $bbcode = new StringParser_BBCode ();
        $bbcode->addFilter (STRINGPARSER_FILTER_PRE, 'convertlinebreaks');
        
        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'htmlspecialchars');
        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'nl2br');
        $bbcode->addParser ('list', 'bbcode_stripcontents');
        
        $bbcode->addCode ('b', 'simple_replace', null, array ('start_tag' => '<b>', 'end_tag' => '</b>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());
        $bbcode->addCode ('i', 'simple_replace', null, array ('start_tag' => '<i>', 'end_tag' => '</i>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());
        $bbcode->addCode ('url', 'usecontent?', 'do_bbcode_url', array ('usecontent_param' => 'default'),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));
        $bbcode->addCode ('link', 'callback_replace_single', 'do_bbcode_url', array (),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));
        $bbcode->addCode ('img', 'usecontent?', 'do_bbcode_img', array (),
                          'image', array ('listitem', 'block', 'inline', 'link'), array ());
        $bbcode->addCode ('bild', 'usecontent?', 'do_bbcode_img', array (),
                          'image', array ('listitem', 'block', 'inline', 'link'), array ());
        $bbcode->addCode ('quote', 'usecontent?', 'do_bbcode_quote', array ('usecontent_param' => 'default'),
                                          'block', array ('listitem', 'block', 'inline'), array ('link'));
        $bbcode->setOccurrenceType ('img', 'image');
        $bbcode->setOccurrenceType ('bild', 'image');
        $bbcode->setMaxOccurrences ('image', 2);
        $bbcode->addCode ('list', 'simple_replace', null, array ('start_tag' => '<ul>', 'end_tag' => '</ul>'),
                          'list', array ('block', 'listitem'), array ());
        $bbcode->addCode ('*', 'simple_replace', null, array ('start_tag' => '<li>', 'end_tag' => '</li>'),
                          'listitem', array ('list'), array ());
        $bbcode->setCodeFlag ('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
        $bbcode->setCodeFlag ('*', 'paragraphs', true);
        $bbcode->setCodeFlag ('list', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
        $bbcode->setCodeFlag ('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
        $bbcode->setCodeFlag ('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
        $bbcode->setRootParagraphHandling (true);
        
        $parsedtext = $bbcode->parse ($text);
        unset($bbcode);
        
        return $parsedtext;
}

///////////////////////////////////////////////////////////////
// Check if the visitor has already voted in the given poll  //
///////////////////////////////////////////////////////////////
function checkVotedPoll($pollid) {

        global $db;

        settype($pollid, 'integer');

        if (isset($_COOKIE['polls_voted'])) {
            $polls_voted = savesql($_COOKIE['polls_voted']);
            $votes = explode(',', $polls_voted);
            if (in_array($pollid, $votes )) {
                return true;
            }
        }
        $one_day_ago = time()-60*60*24;
        mysql_query("DELETE FROM fs_poll_voters WHERE time <= '".$one_day_ago."'", $db); //Delete old IPs
        $query_id = mysql_query("SELECT voter_id FROM fs_poll_voters WHERE poll_id = $pollid AND ip_address = '".$_SERVER['REMOTE_ADDR']."' AND time > '".$one_day_ago."'", $db); //Save IP for 1 Day
        if (mysql_num_rows($query_id) > 0) {
                return true;
        }

        return false;
}

///////////////////////////////////////////////////////////////
//// Register the voter in the db to avoid multiple votes  ////
///////////////////////////////////////////////////////////////
function registerVoter($pollid, $voter_ip) {
        settype($pollid, 'integer');

        mysql_query("INSERT INTO fs_poll_voters VALUES ('', '$pollid', '$voter_ip', '".time()."')");
        if (!isset($_COOKIE['polls_voted'])) {
                setcookie('polls_voted', $pollid, time()+60*60*24*60); //2 months
        } else {
                setcookie('polls_voted', $_COOKIE['polls_voted'].','.$pollid, time()+60*60*24*60);
        }
}
?>