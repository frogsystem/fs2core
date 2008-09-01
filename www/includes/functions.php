<?php
/////////////////////////////////////////
//// Pagenav Array with Start Number ////
/////////////////////////////////////////
function get_pagenav_start ( $NUM_OF_ENTRIES, $ENTRIES_PER_PAGE, $START )
{
	if ( ! isset ( $START ) ) { $START = 0; }
	if ( ! is_int ( $START ) ) { $START = 0; }
	if ( $START < 0 ) { $START = 0; }
	if ( $START > $NUM_OF_ENTRIES ) { $START = $NUM_OF_ENTRIES - $ENTRIES_PER_PAGE; }

    $OLDSTART = $START - $ENTRIES_PER_PAGE;
	if ( $OLDSTART < 0 ) { $OLDSTART = 0; }
    $NEWSTART = $START + $ENTRIES_PER_PAGE;
	if ( $NEWSTART > $NUM_OF_ENTRIES ) { $NEWSTART = $NUM_OF_ENTRIES - $ENTRIES_PER_PAGE; }

    $PAGENAV_DATA['total_entries'] = $NUM_OF_ENTRIES;
    $PAGENAV_DATA['entries_per_page'] = $ENTRIES_PER_PAGE;
    $PAGENAV_DATA['old_start'] = $OLDSTART;
    $PAGENAV_DATA['cur_start'] = $START;
    $PAGENAV_DATA['new_start'] = $NEWSTART;
    
    if ( $START > 1 ) { $PAGENAV_DATA['old_start_exists'] = TRUE; }
    else { $PAGENAV_DATA['old_start_exists'] = FALSE; }
    if ( ( $START + $ENTRIES_PER_PAGE ) < $NUM_OF_ENTRIES ) { $PAGENAV_DATA['newpage_exists'] = TRUE; }
    else { $PAGENAV_DATA['newpage_exists'] = FALSE; }
    
    return $PAGENAV_DATA;
}

//////////////////////////////////////
//// Where Clause for Text-Filter ////
//////////////////////////////////////
function get_filter_where ( $FILTER, $SEARCH_FIELD )
{
	$filterarray = explode ( ",", $FILTER );
	$filterarray = array_map ( "trim", $filterarray );
    unset ( $query );
    unset ( $and_query );
    unset ( $or_query );

    $first_and = true;
    $first_or = true;

    foreach ( $filterarray as $string )
    {
        if ( substr ( $string, 0, 1 ) == "!" && substr ( $string, 1 ) != "" )
        {
            $like = $SEARCH_FIELD." NOT LIKE";
            $string = substr ( $string, 1 );
            if ( !$first_and )
            {
                $and_query .= " AND ";
            }
            $and_query .= $like . " '%" . $string . "%'";
            $first_and = false;
        }
        elseif ( substr ( $string, 0, 1 ) != "!" && $string != "" )
        {
            $like = $SEARCH_FIELD." LIKE";
            if ( !$first_or )
            {
                $or_query .= " OR ";
            }
            $or_query .= $like . " '%" . $string . "%'";
            $first_or = false;
        }
        $i++;
    }

    if ( $or_query != "" )
	{
        $or_query = "(".$or_query.")";
        if ( $and_query != "" )
		{
            $and_query = " AND ".$and_query;
        }
    }

    if ( $or_query != "" || $and_query != "" )
	{
        $query = "WHERE ";
    }
    $query .= $or_query . $and_query;
    
    return $query;
}

///////////////////////////
//// Passwort erzeugen ////
///////////////////////////

function generate_pwd ( $LENGHT = 10 )
{
    $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $real_strlen = strlen ( $charset ) - 1;
    mt_srand ( (double)microtime () * 1001000 );

    while ( strlen ( $code ) < $LENGHT ) {
    	$code .= $charset[mt_rand ( 0,$real_strlen ) ];
    }
    return $code;
}

/////////////////////////////////
//// Check Anti-Spam Captcha ////
/////////////////////////////////

function check_captcha ( $SOLUTION, $ACTIVATION )
{
    global $global_config_arr;
    global $db;

	session_start();

	function encrypt_captcha ( $STRING, $KEY ) {
		$result = '';
		for ( $i = 0; $i < strlen ( $STRING ); $i++ ) {
			$char = substr ( $STRING, $i, 1 );
   			$keychar = substr ( $KEY, ( $i % strlen ( $KEY ) ) -1, 1 );
   			$char = chr ( ord ( $char ) + ord ( $keychar ) );
			$result .= $char;
		}
		return base64_encode($result);
	}

	$sicherheits_eingabe = encrypt_captcha ( $SOLUTION, $global_config_arr['spam'] );
	$sicherheits_eingabe = str_replace ("=", "", $sicherheits_eingabe );

	if ( $ACTIVATION == 0 ) {
		return TRUE;
	} elseif ( $ACTIVATION == 1 && $_SESSION['user_id'] ) {
		return TRUE;
	} elseif ( $ACTIVATION == 3 && $_SESSION['user_id'] && is_in_staff ( $_SESSION['user_id'] ) ) {
		return TRUE;
	} elseif ( $sicherheits_eingabe == $_SESSION['rechen_captcha_spam'] && $sicherheits_eingabe == TRUE && is_numeric( $SOLUTION ) == TRUE ) {
		return TRUE;
	} else {
		return FALSE;
	}
}

//////////////////////////
//// User is in Staff ////
//////////////////////////

function is_in_staff ( $USER_ID )
{
    global $global_config_arr;
    global $db;
    
    settype ( $USER_ID, "integer" );
    
	if ( $USER_ID ) {
	    $index = mysql_query ( " SELECT is_admin FROM ".$global_config_arr['pref']."user WHERE user_id = '".$USER_ID."'", $db );
		if ( mysql_num_rows ( $index ) > 0 ) {
			if ( mysql_result ( $index, 0, "is_admin" ) == 1 ) {
				 return TRUE;
		    }
	    }
	}
	
	return FALSE;
}

//////////////////////
//// Get Template ////
//////////////////////

function get_template ( $TEMPLATE_NAME )
{
    global $global_config_arr;
    global $db;
    
	$index = mysql_query ( "SELECT `".$TEMPLATE_NAME."` FROM ".$global_config_arr['pref']."template WHERE id = '".$global_config_arr['design']."'", $db );
	return stripslashes ( mysql_result ( $index, 0, $TEMPLATE_NAME ) );
}


////////////////////////////////
//// Create textarea        ////
////////////////////////////////

function create_textarea($name, $text="", $width="", $height="", $class="", $all=true, $fs_smilies=0, $fs_b=0, $fs_i=0, $fs_u=0, $fs_s=0, $fs_center=0, $fs_font=0, $fs_color=0, $fs_size=0, $fs_img=0, $fs_cimg=0, $fs_url=0, $fs_home=0, $fs_email=0, $fs_code=0, $fs_quote=0, $fs_noparse=0)
{
    global $global_config_arr;
    global $db;

    if ($name != "") {
        $name2 = 'name="'.$name.'" id="'.$name.'"';
    } else {
        return false;
    }
    
    if ($width != "") {
        $width2 = 'width:'.$width.'px;';
    }
    
    if ($height != "") {
        $height2 = 'height:'.$height.'px';
    }
    
    if ($class != "") {
        $class2 = 'class="'.$class.'"';
    }

    $style = $name2.' '.$class2.' style="'.$width2.' '.$height2.'"';

  if ($all==true OR $fs_smilies==1) {
    $smilies = '
      <fieldset>
        <legend class="small" align="left"><font class="small">Smilies</font></legend>
          <table cellpadding="2" cellspacing="0" border="0">';

    $index = mysql_query("select * from ".$global_config_arr[pref]."editor_config", $db);
    $config_arr = mysql_fetch_assoc($index);
    $config_arr[num_smilies] = $config_arr[smilies_rows]*$config_arr[smilies_cols];
            
    $zaehler = 0;
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."smilies ORDER by `order` ASC LIMIT 0, $config_arr[num_smilies]", $db);
    while ($smilie_arr = mysql_fetch_assoc($index))
    {
        $smilie_arr[url] = image_url("images/smilies/", $smilie_arr[id]);

        $smilie_template = '<td><img src="'.$smilie_arr[url].'" alt="'.$smilie_arr[replace_string].'" onClick="insert(\''.$name.'\', \''.$smilie_arr[replace_string].'\', \'\')" class="editor_smilies" /></td>';

        $zaehler += 1;
        switch ($zaehler)
        {
            case $config_arr[smilies_cols] == 1:
                $zaehler = 0;
                $smilies .= "<tr align=\"center\">\n\r";
                $smilies .= $smilie_template;
                $smilies .= "</tr>\n\r";
                break;
            case $config_arr[smilies_cols]:
                $zaehler = 0;
                $smilies .= $smilie_template;
                $smilies .= "</tr>\n\r";
                break;
            case 1:
                $smilies .= "<tr align=\"center\">\n\r";
                $smilies .= $smilie_template;
                break;
            default:
                $smilies .= $smilie_template;
                break;
        }
    }
    unset($smilie_arr);
    unset($smilie_template);
    unset($config_arr);
    
    $smilies .= '</table></fieldset>';

  } else {
    $smilies = "";
  }

$buttons = "";
  
if ($all==true OR $fs_b==1) {
  $buttons .= create_textarea_button('images/icons/bold.gif', "B", "fett", "insert('$name', '[b]', '[/b]')");
}
if ($all==true OR $fs_i==1) {
  $buttons .= create_textarea_button('images/icons/italic.gif', "I", "kursiv", "insert('$name', '[i]', '[/i]')");
}
if ($all==true OR $fs_u==1) {
  $buttons .= create_textarea_button('images/icons/underline.gif', "U", "unterstrichen", "insert('$name','[u]','[/u]')");
}
if ($all==true OR $fs_s==1) {
  $buttons .= create_textarea_button('images/icons/strike.gif', "S", "durgestrichen", "insert('$name', '[s]', '[/s]')");
}


if ($all==true OR $fs_b==1 OR $fs_i==1 OR $fs_u==1 OR $fs_s==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_center==1) {
  $buttons .= create_textarea_button('images/icons/center.gif', "CENTER", "zentriert", "insert('$name', '[center]', '[/center]')");
}


if ($all==true OR $fs_center==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_font==1) {
  $buttons .= create_textarea_button('images/icons/font.gif', "FONT", "Schriftart", "insert_com('$name', 'font', 'Bitte gib die gewünschte Schriftart ein:', '')");
}
if ($all==true OR $fs_color==1) {
  $buttons .= create_textarea_button('images/icons/color.gif', "COLOR", "Schriftfarbe", "insert_com('$name', 'color', 'Bitte gib die gewünschte Schriftfarbe (englisches Wort) ein:', '')");
}
if ($all==true OR $fs_size==1) {
  $buttons .= create_textarea_button('images/icons/size.gif', "SIZE", "Schriftgröße", "insert_com('$name', 'size', 'Bitte gib die gewünschte Schriftgröße (Zahl von 0-7) ein:', '')");
}


if ($all==true OR $fs_font==1 OR $fs_color==1 OR $fs_size==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_img==1) {
  $buttons .= create_textarea_button('images/icons/img.gif', "IMG", "Bild einfügen", "insert_mcom('$name', '[img]', '[/img]', 'Bitte gib die URL zu der Grafik ein:', 'http://')");
}
if ($all==true OR $fs_cimg==1) {
  $buttons .= create_textarea_button('images/icons/cimg.gif', "CIMG", "Content-Image einfügen", "insert_mcom('$name', '[cimg]', '[/cimg]', 'Bitte gib den Namen des Content-Images (mit Endung) ein:', '')");
}


if ($all==true OR $fs_img==1 OR $fs_cimg==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_url==1) {
  $buttons .= create_textarea_button('images/icons/url.gif', "URL", "Link einfügen", "insert_com('$name', 'url', 'Bitte gib die URL ein:', 'http://')");
}
if ($all==true OR $fs_home==1) {
  $buttons .= create_textarea_button('images/icons/home.gif', "HOME", "Projektinternen Link einfügen", "insert_com('$name', 'home', 'Bitte gib den projektinternen Verweisnamen ein:', '')");
}
if ($all==true OR $fs_email==1) {
  $buttons .= create_textarea_button('images/icons/email.gif', "@", "Email-Link einfügen", "insert_com('$name', 'email', 'Bitte gib die Email-Adresse ein:', '')");
}


if ($all==true OR $fs_url==1 OR $fs_home==1 OR $fs_email==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_code==1) {
  $buttons .= create_textarea_button('images/icons/code.gif', "C", "Code-Bereich einfügen", "insert('$name', '[code]', '[/code]')");
}
if ($all==true OR $fs_quote==1) {
  $buttons .= create_textarea_button('images/icons/quote.gif', "Q", "Zitat einfügen", "insert('$name', '[quote]', '[/quote]')");
}
if ($all==true OR $fs_noparse==1) {
  $buttons .= create_textarea_button('images/icons/noparse.gif', "N", "Nicht umzuwandelnden Bereich einfügen", "insert('$name', '[noparse]', '[/noparse]')");
}

    $index = mysql_query("SELECT editor_design FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'");
    $textarea = stripslashes(mysql_result($index, 0, "editor_design"));
    $textarea = str_replace("{style}", $style, $textarea);
    $textarea = str_replace("{text}", $text, $textarea);
    $textarea = str_replace("{buttons}", $buttons, $textarea);
    $textarea = str_replace("{smilies}", $smilies, $textarea);

    return $textarea;
}


////////////////////////////////
//// Create textarea Button ////
////////////////////////////////

function create_textarea_button($img_url, $alt, $title, $insert)
{
    global $global_config_arr;
    $javascript = 'onClick="'.$insert.'"';

    $index = mysql_query("SELECT editor_button FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'");
    $button = stripslashes(mysql_result($index, 0, "editor_button"));
    $button = str_replace("{img_url}", $global_config_arr[virtualhost].$img_url, $button);
    $button = str_replace("{alt}", $alt, $button);
    $button = str_replace("{title}", $title, $button);
    $button = str_replace("{javascript}", $javascript, $button);
    
    return $button;

}


////////////////////////////////////
//// Create textarea  Seperator ////
////////////////////////////////////

function create_textarea_seperator()
{
    global $global_config_arr;
    unset($seperator);

    $index = mysql_query("SELECT editor_seperator FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'");
    $seperator = stripslashes(mysql_result($index, 0, "editor_seperator"));

    return $seperator;

}


////////////////////////////////
/////// System Message /////////
////////////////////////////////

function sys_message ($title, $message)
{
    global $db;
    global $global_config_arr;

    $index = mysql_query("select error from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "error"));
    $template = str_replace("{titel}", $title, $template);
    $template = str_replace("{meldung}", $message, $template);
    return $template;
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

/////////////////////////////////////////
// String kürzen ohne Wort zuzerstören //  <= BAD FUNCTION HAS TO BE IMPROVED
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

/////////////////////////////////////////
// String innerhalb sich selbst kürzen //
/////////////////////////////////////////
function cut_in_string ($string, $maxlength, $replacement)
{
   if (strlen($string) > $maxlength) {
       $part_lenght = ceil($maxlength/2)-ceil(strlen($extension)/2);
       $string_start = substr($string, 0, $part_lenght);
       $string_end = substr($string, -1*$part_lenght);
       $string = $string_start . $replacement . $string_end;
   }
   return $string;
}

////////////////////////////////
///// Download Categories //////
////////////////////////////////

function get_dl_categories (&$ids, $cat_id, $id=0, $ebene=-1)
{
    global $global_config_arr;
    global $db;

    $index = mysql_query("select * from ".$global_config_arr[pref]."dl_cat where subcat_id = '$id' ORDER BY cat_name", $db);
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

function display_news ($news_arr, $html_code, $fs_code, $para_handling)
{
    global $db, $global_config_arr;

    $news_arr[news_date] = date("d.m.Y" , $news_arr[news_date]) . " um " . date("H:i" , $news_arr[news_date]);
    $news_arr[comment_url] = "?go=comments&amp;id=$news_arr[news_id]";

    // Kategorie lesen
    $index2 = mysql_query("select cat_name from ".$global_config_arr[pref]."news_cat where cat_id = '".$news_arr['cat_id']."'", $db);
    $news_arr[cat_name] = mysql_result($index2, 0, "cat_name");
    $news_arr[cat_pic] = image_url("images/cat/", "news_".$news_arr[cat_id]);

    // Text formatieren
    switch ($html_code)
    {
        case 1:
            $html = false;
            break;
        case 2:
            $html = true;
            break;
        case 3:
            $html = false;
            break;
        case 4:
            $html = true;
            break;
    }
    switch ($fs_code)
    {
        case 1:
            $fs = false;
            break;
        case 2:
            $fs = true;
            break;
        case 3:
            $fs = false;
            break;
        case 4:
            $fs = true;
            break;
    }
    switch ($para_handling)
    {
        case 1:
            $para = false;
            break;
        case 2:
            $para = true;
            break;
        case 3:
            $para = false;
            break;
        case 4:
            $para = true;
            break;
    }

    $news_arr[news_text] = fscode ( $news_arr[news_text], $fs, $html, $para );
    $news_arr[news_title] = killhtml ( $news_arr[news_title] );

    // User auslesen
    $index2 = mysql_query("select user_name from ".$global_config_arr[pref]."user where user_id = $news_arr[user_id]", $db);
    $news_arr[user_name] = mysql_result($index2, 0, "user_name");
    $news_arr[user_url] = "?go=profil&amp;userid=$news_arr[user_id]";

    // Kommentare lesen
    $index2 = mysql_query("select comment_id from ".$global_config_arr[pref]."news_comments where news_id = $news_arr[news_id]", $db);
    $news_arr[kommentare] = mysql_num_rows($index2);

    // Template lesen und füllen
    $index2 = mysql_query("select news_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
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
    $index2 = mysql_query("select * from ".$global_config_arr[pref]."news_links where news_id = $news_arr[news_id] order by link_id", $db);
    while ($link_arr = mysql_fetch_assoc($index2))
    {
        $link_arr[link_name] = killhtml ( $link_arr[link_name] );
        $link_arr[link_url] = killhtml ( $link_arr[link_url] );
		$index3 = mysql_query("select news_link from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
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
        $index2 = mysql_query("select news_related_links from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
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
            $SIZE = round ( $SIZE, 1 ) . " KB";
            break;
        case ($SIZE < $gb):
            $SIZE = round ( $SIZE/$mb, 1 ). " MB";
            break;
        case ($SIZE < $tb):
            $SIZE = round ( $SIZE/$gb, 1 ). " GB";
            break;
        case ($SIZE > $tb):
            $SIZE = round ( $SIZE/$tb, 1 ). " TB";
            break;
    }
    return $SIZE;
}

/////////////////////////
// mark word in a text //  <=== BAD FUNCTION *HAS TO BE IMPROVED*
/////////////////////////

function markword($text, $word)
{
    $text = preg_replace("=(.*?)$word(.*?)=i", 
                         "\\1<font color=\"red\"><b>$word</b></font>\\2",$text);
    return $text;
}

/////////////////////////////////
// create save strings for sql //
/////////////////////////////////

function savesql ( $TEXT )
{
    $TEXT = trim ( $TEXT );
    $TEXT = mysql_real_escape_string ( $TEXT );
    return $TEXT;
}

//////////////////////////////////
// kill html in textareas, etc. //
//////////////////////////////////

function killhtml ( $TEXT )
{
    $TEXT = trim ( $TEXT );
    $TEXT = stripslashes ( $TEXT );
    $TEXT = htmlspecialchars ( $TEXT );
    return $TEXT;
}

//////////////////////////////////
// kill sv whre not allowed     //
//////////////////////////////////

function killsv ( $TEXT )
{
    $TEXT = str_replace ( "[", "&#x5B;", $TEXT );
    $TEXT = str_replace ( "]", "&#x5D;", $TEXT );
    $TEXT = str_replace ( "%", "&#x25;", $TEXT );
    return $TEXT;
}

//////////////////////////////////
// kill {} whre not allowed     //
//////////////////////////////////

function killbraces ( $TEXT )
{
    global $global_config_arr;

    $TEXT = str_replace ( "{virtualhost}", $global_config_arr['virtualhost'], $TEXT );
    $TEXT = str_replace ( "{", "&#123;", $TEXT );
    $TEXT = str_replace ( "}", "&#125;", $TEXT );
    return $TEXT;
}

//////////////////////////////
// Format text with FS Code //
//////////////////////////////

function fscode($text, $all=true, $html=false, $para=false, $do_b=0, $do_i=0, $do_u=0, $do_s=0, $do_center=0, $do_url=0, $do_homelink = 0, $do_email=0, $do_img=0, $do_cimg=0, $do_list=0, $do_numlist=0, $do_font=0, $do_color=0, $do_size=0, $do_code=0, $do_quote=0, $do_noparse=0, $do_smilies=0)
{
        include_once 'bbcodefunctions.php';
        $bbcode = new StringParser_BBCode ();

        $bbcode->addFilter (STRINGPARSER_FILTER_PRE, 'convertlinebreaks');

        if ($html==false) {
            #$bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'strip_tags');
            $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'killhtml');
        }


        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'stripslashes');
        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'nl2br');
        $bbcode->addParser ('list', 'bbcode_stripcontents');

        if ($all==true OR $do_smilies==1)
        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'do_bbcode_smilies');

        if ($all==true OR $do_b==1)
        $bbcode->addCode ('b', 'simple_replace', null, array ('start_tag' => '<b>', 'end_tag' => '</b>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_i==1)
        $bbcode->addCode ('i', 'simple_replace', null, array ('start_tag' => '<i>', 'end_tag' => '</i>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_u==1)
        $bbcode->addCode ('u', 'simple_replace', null, array ('start_tag' => '<span style="text-decoration:underline">', 'end_tag' => '</span>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_s==1)
        $bbcode->addCode ('s', 'simple_replace', null, array ('start_tag' => '<span style="text-decoration:line-through">', 'end_tag' => '</span>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_center==1)
        $bbcode->addCode ('center', 'simple_replace', null, array ('start_tag' => '<center>', 'end_tag' => '</center>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_url==1)
        $bbcode->addCode ('url', 'usecontent?', 'do_bbcode_url', array ('usecontent_param' => 'default'),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));

        if ($all==true OR $do_homelink==1)
        $bbcode->addCode ('home', 'usecontent?', 'do_bbcode_homelink', array ('usecontent_param' => 'default'),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));

        if ($all==true OR $do_email==1)
        $bbcode->addCode ('email', 'usecontent?', 'do_bbcode_email', array ('usecontent_param' => 'default'),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));

        if ($all==true OR $do_img==1)
        $bbcode->addCode ('img', 'usecontent?', 'do_bbcode_img', array (),
                          'image', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_cimg==1)
        $bbcode->addCode ('cimg', 'usecontent?', 'do_bbcode_cimg', array (),
                          'image', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_list==1)
        $bbcode->addCode ('list', 'simple_replace', null, array ('start_tag' => '<ul>', 'end_tag' => '</ul>'),
                          'list', array ('block', 'listitem'), array ('link'));

        if ($all==true OR $do_numlist==1)
        $bbcode->addCode ('numlist', 'simple_replace', null, array ('start_tag' => '<ol>', 'end_tag' => '</ol>'),
                          'list', array ('block', 'listitem'), array ('link'));

        if ($all==true OR $do_list==1 OR $do_numlist==1) {
        $bbcode->addCode ('*', 'simple_replace', null, array ('start_tag' => '<li>', 'end_tag' => '</li>'),
                          'listitem', array ('list'), array ());
        $bbcode->setCodeFlag ('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
        $bbcode->setCodeFlag ('*', 'paragraphs', false);
        $bbcode->setCodeFlag ('list', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
        $bbcode->setCodeFlag ('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
        $bbcode->setCodeFlag ('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP); }


        if ($all==true OR $do_font==1)
        $bbcode->addCode ('font', 'callback_replace', 'do_bbcode_font', array (),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_color==1)
        $bbcode->addCode ('color', 'callback_replace', 'do_bbcode_color', array (),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_size==1)
        $bbcode->addCode ('size', 'callback_replace', 'do_bbcode_size', array (),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_code==1)
        $bbcode->addCode ('code', 'callback_replace', 'do_bbcode_code', array (),
                          'block', array ('listitem', 'block', 'inline'), array ('link'));
        if ($all==true OR $do_code==1)
        $bbcode->setCodeFlag ('code', 'paragraph_type', BBCODE_PARAGRAPH_ALLOW_INSIDE);
        
        if ($all==true OR $do_quote==1)
        $bbcode->addCode ('quote', 'callback_replace', 'do_bbcode_quote', array (),
                          'block', array ('listitem', 'block', 'inline'), array ('link'));
        if ($all==true OR $do_quote==1)
        $bbcode->setCodeFlag ('quote', 'paragraph_type', BBCODE_PARAGRAPH_ALLOW_INSIDE);

        if ($all==true OR $do_noparse==1)
        $bbcode->addCode ('noparse', 'usecontent', 'do_bbcode_noparse', array (),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($para==true)
        $bbcode->setRootParagraphHandling (true);

        $bbcode->setGlobalCaseSensitive (false);
        $parsedtext = $bbcode->parse ($text);
        unset($bbcode);

        return $parsedtext;
}

//////////////////////////
// kill FS Code in text //
//////////////////////////

function killfs($text)
{
    $text = fscode($text);
    $text = strip_tags($text);
    return $text;
}

///////////////////////////////////////////////////////////////
// Check if the visitor has already voted in the given poll  //
///////////////////////////////////////////////////////////////
function checkVotedPoll($pollid) {

    global $global_config_arr;
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
        mysql_query("DELETE FROM ".$global_config_arr[pref]."poll_voters WHERE time <= '".$one_day_ago."'", $db); //Delete old IPs
        $query_id = mysql_query("SELECT voter_id FROM ".$global_config_arr[pref]."poll_voters WHERE poll_id = $pollid AND ip_address = '".$_SERVER['REMOTE_ADDR']."' AND time > '".$one_day_ago."'", $db); //Save IP for 1 Day
        if (mysql_num_rows($query_id) > 0) {
                return true;
        }

        return false;
}

///////////////////////////////////////////////////////////////
//// Register the voter in the db to avoid multiple votes  ////
///////////////////////////////////////////////////////////////
function registerVoter($pollid, $voter_ip) {

        global $global_config_arr;

        settype($pollid, 'integer');

        mysql_query("INSERT INTO ".$global_config_arr[pref]."poll_voters VALUES ('', '$pollid', '$voter_ip', '".time()."')");
        if (!isset($_COOKIE['polls_voted'])) {
                setcookie('polls_voted', $pollid, time()+60*60*24*60); //2 months
        } else {
                setcookie('polls_voted', $_COOKIE['polls_voted'].','.$pollid, time()+60*60*24*60);
        }
}
?>