<?php
////////////////////////////////
//// del old timed randoms  ////
////////////////////////////////
function delete_old_randoms()
{
  global $db;
  global $global_config_arr;

  if ($global_config_arr[random_timed_deltime] != -1) {
    // Alte Zufallsbild-Einträge aus der Datenbank entfernen
    mysql_query("DELETE a
                FROM fs_screen_random a, fs_global_config b
                WHERE a.end < UNIX_TIMESTAMP()-b.random_timed_deltime", $db);
  }
}


////////////////////////////////
//// Create textarea        ////
////////////////////////////////

function code_textarea($name, $text="", $width="", $height="", $class="", $all=true, $fs_smilies=0, $fs_b=0, $fs_i=0, $fs_u=0, $fs_s=0, $fs_center=0, $fs_font=0, $fs_color=0, $fs_size=0, $fs_img=0, $fs_cimg=0, $fs_url=0, $fs_home=0, $fs_email=0, $fs_code=0, $fs_quote=0, $fs_noparse=0)
{
    global $global_config_arr;

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

    $textarea = "";
    $textarea .= '
    
<table cellpadding="0" cellspacing="0" border="0">
  <tr valign="top">
    <td>
      <textarea '.$name2.' '.$class2.' style="'.$width2.' '.$height2.'">'.$text.'</textarea>
    </td>
';
if ($all==true OR $fs_smilies==1) {
  $textarea .= '
    <td style="width:4px; empty-cells:show;">
    </td>
    <td>
      <fieldset style="width:46px;">
        <legend class="small" align="left"><font class="small">Smilies</font></legend>
          <table cellpadding="2" cellspacing="0" border="0" width="100%">
            <tr align="center">
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/happy.gif" alt="" onClick="insert(\''.$name.'\', \':-)\', \'\')" class="editor_smilies" /></td>
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/sad.gif" alt="" onClick="insert(\''.$name.'\', \':-(\', \'\')" class="editor_smilies" /></td>
            </tr>
            <tr align="center">
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/wink.gif" alt="" onClick="insert(\''.$name.'\', \';-)\', \'\')" class="editor_smilies" /></td>
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/tongue.gif" alt="" onClick="insert(\''.$name.'\', \':-P\', \'\')" class="editor_smilies" /></td>
            </tr>
            <tr align="center">
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/grin.gif" alt="" onClick="insert(\''.$name.'\', \'xD\', \'\')" class="editor_smilies" /></td>
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/shocked.gif" alt="" onClick="insert(\''.$name.'\', \':-o\', \'\')" class="editor_smilies" /></td>
            </tr>
            <tr align="center">
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/sweet.gif" alt="" onClick="insert(\''.$name.'\', \'^_^\', \'\')" class="editor_smilies" /></td>
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/neutral.gif" alt="" onClick="insert(\''.$name.'\', \':-/\', \'\')" class="editor_smilies" /></td>
            </tr>
            <tr align="center">
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/satisfied.gif" alt="" onClick="insert(\''.$name.'\', \':-]\', \'\')" class="editor_smilies" /></td>
              <td><img src="'.$global_config_arr[virtualhost].'images/smilies/angry.gif" alt="" onClick="insert(\''.$name.'\', \'>-(\', \'\')" class="editor_smilies" /></td>
            </tr>
         </table>
      </fieldset>
    </td>
  ';
}
$textarea .= '
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0">
  <tr valign="bottom">';
  
if ($all==true OR $fs_b==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert(\''.$name.'\', \'[b]\', \'[/b]\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/bold.gif" alt="B" title="fett" />
    </div>
  </td>';
}
if ($all==true OR $fs_i==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert(\''.$name.'\', \'[i]\', \'[/i]\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/italic.gif" alt="I" title="kursiv" />
    </div>
  </td>';
}
if ($all==true OR $fs_u==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert(\''.$name.'\', \'[u]\', \'[/u]\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/underline.gif" alt="U" title="unterstrichen" />
    </div>
  </td>';
}
if ($all==true OR $fs_s==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert(\''.$name.'\', \'[s]\', \'[/s]\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/strike.gif" alt="S" title="durgestrichen" />
    </div>
  </td>';
}
if ($all==true OR $fs_b==1 OR $fs_i==1 OR $fs_u==1 OR $fs_s==1) {
  $textarea .= '<td class="editor_td_seperator">
  </td>';
}
if ($all==true OR $fs_center==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert(\''.$name.'\', \'[center]\', \'[/center]\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/center.gif" alt="CENTER" title="zentriert" />
    </div>
  </td>';
}
if ($all==true OR $fs_center==1) {
  $textarea .= '<td class="editor_td_seperator">
  </td>';
}
if ($all==true OR $fs_font==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert_com(\''.$name.'\', \'font\', \'Bitte gib die gewünschte Schriftart ein: \', \'\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/font.gif" alt="FONT" title="Schriftart" />
    </div>
  </td>';
}
if ($all==true OR $fs_color==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert_com(\''.$name.'\', \'color\', \'Bitte gib die gewünschte Schriftfarbe (englisches Wort) ein: \', \'\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/color.gif" alt="COLOR" title="Schriftfarbe" />
    </div>
  </td>';
}
if ($all==true OR $fs_size==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert_com(\''.$name.'\', \'size\', \'Bitte gib die gewünschte Schriftgröße (Zahl von 1-7) ein: \', \'\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/size.gif" alt="SIZE" title="Schriftgröße" />
    </div>
  </td>';
}
if ($all==true OR $fs_font==1 OR $fs_color==1 OR $fs_size==1) {
  $textarea .= '<td class="editor_td_seperator">
  </td>';
}
if ($all==true OR $fs_img==1) {
  $textarea .= '<td class="editor_td">
        <div class="editor_button" onClick="insert_mcom(\''.$name.'\', \'[img]\', \'[/img]\', \'Bitte gib die URL zu deiner Grafik ein:\', \'http://\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/img.gif" alt="IMG" title="Bild einfügen" />
        </div>
  </td>';
}
if ($all==true OR $fs_cimg==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert_mcom(\''.$name.'\', \'[cimg]\', \'[/cimg]\', \'Bitte gib den Namen des Content-Images (mit Endung) ein:\', \'\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/cimg.gif" alt="CIMG" title="Content-Image einfügen" />
    </div>
  </td>';
}
if ($all==true OR $fs_img==1 OR $fs_cimg==1) {
  $textarea .= '<td class="editor_td_seperator">
  </td>';
}
if ($all==true OR $fs_url==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert_com(\''.$name.'\', \'url\', \'Bitte gib die URL ein: \', \'http://\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/url.gif" alt="URL" title="Link einfügen" />
        </div>
  </td>';
}
if ($all==true OR $fs_home==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert_com(\''.$name.'\', \'home\', \'Bitte gib den projektinternen Verweisnamen ein: \', \'\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/home.gif" alt="HOME" title="Projektinternen Link einfügen" />
    </div>
  </td>';
}
if ($all==true OR $fs_email==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert_com(\''.$name.'\', \'email\', \'Bitte gib die Email-Adresse ein: \', \'\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/email.gif" alt="EMAIL" title="Email-Link einfügen" />
    </div>
  </td>';
}
if ($all==true OR $fs_url==1 OR $fs_home==1 OR $fs_email==1) {
  $textarea .= '<td class="editor_td_seperator">
  </td>';
}
if ($all==true OR $fs_code==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert(\''.$name.'\', \'[code]\', \'[/code]\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/code.gif" alt="C" title="Code-Bereich einfügen" />
        </div>
  </td>';
}
if ($all==true OR $fs_quote==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert(\''.$name.'\', \'[quote]\', \'[/quote]\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/quote.gif" alt="Q" title="Zitat einfügen" />
    </div>
  </td>';
}
if ($all==true OR $fs_noparse==1) {
  $textarea .= '<td class="editor_td">
    <div class="editor_button" onClick="insert(\''.$name.'\', \'[noparse]\', \'[/noparse]\')">
      <img src="'.$global_config_arr[virtualhost].'images/icons/noparse.gif" alt="N" title="Nicht umzuwandelnden Bereich einfügen" />
    </div>
  </td>';
}
$textarea .= '</tr>
</table><br />';

    return $textarea;
}


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
  global $global_config_arr;

  if (file_exists("$path"."$name.jpg"))
    $url = $path."$name.jpg";
  elseif (file_exists("$path"."$name.gif"))
    $url = $path."$name.gif";
  elseif (file_exists("$path"."$name.png"))
    $url = $path."$name.png";
  elseif ($error==true)
    $url = $global_config_arr[virtualhost]."images/icons/nopic.gif";
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

function display_news ($news_arr, $html_code, $fs_code, $para_handling)
{
    global $db, $global_config_arr;

    $news_arr[news_date] = date("d.m.Y" , $news_arr[news_date]) . " um " . date("H:i" , $news_arr[news_date]);
    $news_arr[comment_url] = "?go=comments&amp;id=$news_arr[news_id]";

    // Kategorie lesen
    $index2 = mysql_query("select cat_name from fs_news_cat where cat_id = $news_arr[cat_id]", $db);
    $news_arr[cat_name] = mysql_result($index2, 0, "cat_name");
    $news_arr[cat_pic] = image_url("images/news_cat/", $news_arr[cat_id]);

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

    $news_arr[news_text] = fscode($news_arr[news_text],$fs,$html,$para);

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

//////////////////////
// convert filesize //
//////////////////////

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

function savesql($text)
{
    $text = trim($text);
    $text = mysql_real_escape_string($text);
    return $text;
}

//////////////////////////////////
// kill html in textareas, etc. //
//////////////////////////////////

function killhtml($text)
{
    $text = trim($text);
    $text = stripslashes($text);
    $text = htmlspecialchars ($text);
    return $text;
}


//////////////////////////////
// Format text with FS Code //
//////////////////////////////

function fscode($text, $all=true, $html=false, $para=false, $do_b=0, $do_i=0, $do_u=0, $do_s=0, $do_center=0, $do_url=0, $do_homelink = 0, $do_email=0, $do_img=0, $do_cimg=0, $do_list=0, $do_numlist=0, $do_font=0, $do_color=0, $do_size=0, $do_code=0, $do_quote=0, $do_noparse=0, $do_smilies=0)
{
        include_once 'bbcodefunctions.php';
        $bbcode = new StringParser_BBCode ();

        $bbcode->addFilter (STRINGPARSER_FILTER_PRE, 'convertlinebreaks');

        if ($html==false)
        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'htmlspecialchars');

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

        if ($all==true OR $do_quote==1)
        $bbcode->addCode ('quote', 'callback_replace', 'do_bbcode_quote', array (),
                          'block', array ('listitem', 'block', 'inline'), array ('link'));

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