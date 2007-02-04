<?php
/*
    Frogsystem Download comments script
    Copyright (C) 2006-2007  Stefan Bollmann

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

    Additional permission under GNU GPL version 3 section 7

    If you modify this Program, or any covered work, by linking or combining it
    with Frogsystem 2 (or a modified version of Frogsystem 2), containing parts
    covered by the terms of Creative Commons Attribution-ShareAlike 3.0, the
    licensors of this Program grant you additional permission to convey the
    resulting work. Corresponding Source for a non-source form of such a
    combination shall include the source code for the parts of Frogsystem used
    as well as that of the covered work.
*/


///////////////////
//// Anti-Spam ////
///////////////////
session_start();
function encrypt($string, $key) {
  $result = '';
  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)+ord($keychar));
    $result.=$char;
  }
  return base64_encode($result);
}
$sicherheits_eingabe = encrypt($_POST['spam'], '3g7fg6hr59');
$sicherheits_eingabe = str_replace('=', '', $sicherheits_eingabe);

//////////////////////////////
//// Kommentar hinzufügen ////
//////////////////////////////

if (isset($_POST[addcomment]))
{

    if ($fileid && ($_POST[name] != "" || $_SESSION["user_id"]) && $_POST[title] != "" && $_POST[text] != ""
        && (($sicherheits_eingabe == $_SESSION['rechen_captcha_spam'] AND is_numeric($_POST["spam"]) == true AND $sicherheits_eingabe == true) OR $_SESSION["user_id"]))
    {

        settype($_POST[fileid], 'integer');
        $_POST[name] = savesql($_POST[name]);
        $_POST[title] = savesql($_POST[title]);
        $_POST[text] = savesql($_POST[text]);
        $commentdate = date("U");

        if ($_SESSION["user_id"])
        {
            $userid = $_SESSION["user_id"];
            $name = "";
        }
        else
        {
            $userid = 0;
        }

        mysql_query("INSERT INTO fsplus_dl_comments (dl_id, comment_poster, comment_poster_id, comment_date, comment_title, comment_text)
                     VALUES ('$fileid',
                             '".$_POST[name]."',
                             '$userid',
                             '$commentdate',
                             '".$_POST[title]."',
                             '".$_POST[text]."');", $db);
        mysql_query("update fs_counter set comments=comments+1", $db);
    }
    else
    {
        $reason = "";
        if ( !($_POST[name] != "" || $_SESSION["user_id"])
            || $_POST[title] == ""
            || $_POST[text] == "")
        {
            $reason = $phrases[comment_empty];
        }
        if ((!($sicherheits_eingabe == $_SESSION['rechen_captcha_spam'] AND is_numeric($_POST["spam"]) == true AND $sicherheits_eingabe == true)) AND !($_SESSION["user_id"]))
        {
            $reason .= $phrases[comment_spam];
        }
        sys_message($phrases[comment_not_added], $reason);

    }
}

//////////////////////////////
//// Kommentare ausgeben /////
//////////////////////////////

settype($_GET[fileid], 'integer');
$index = mysql_query("select * from fs_news_config", $db);
$config_arr = mysql_fetch_assoc($index);
$time = time();

// Download anzeigen
settype($_GET[fileid], 'integer');
$index = mysql_query("select * from fs_dl where dl_id = $_GET[fileid] and dl_open = 1", $db);
if (mysql_num_rows($index) > 0)
{
    $file_arr = mysql_fetch_assoc($index);

    // Username auslesen
    $index = mysql_query("select user_name from fs_user where user_id = $file_arr[user_id]", $db);
    $file_arr[user_name] = mysql_result($index, 0, "user_name");
    $file_arr[user_url] = "?go=profil&userid=" . $file_arr[user_id];

    // Link zum Autor generieren
    if (!isset($file_arr[dl_autor]))
    {
        $file_arr[dl_autor_link] = "-";
    }
    else
    {
        $file_arr[dl_autor_link] = '<a href="'.$file_arr[dl_autor_url].'" target="_blank">'.$file_arr[dl_autor].'</a>';
    }

    // Thumbnail vorhanden?
    if (file_exists("images/dl/".$file_arr[dl_id]."_s.jpg"))
    {
        $file_arr[dl_bild] = "images/dl/" . $file_arr[dl_id] . ".jpg";
        $file_arr[dl_thumb] = "images/dl/" . $file_arr[dl_id] . "_s.jpg";
    }
    else
    {
        $file_arr[dl_bild] = "images/design/nopic120.gif";
        $file_arr[dl_thumb] = "images/design/nopic120.gif";
    }

    // Sonstige Daten ermitteln
    $file_arr[dl_size_berechnet] = getsize($file_arr[dl_size]);
    $file_arr[dl_date] = date("d.m.Y" , $file_arr[dl_date]) . " ".$phrases[time_at]." " . date("H:i" , $file_arr[dl_date]);
    $file_arr[dl_traffic] = getsize($file_arr[dl_size]*$file_arr[dl_loads]);
    $file_arr[dl_text] = fscode($file_arr[dl_text], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

/////   NEU ANFANG   /////

	// Kommentare
	$file_arr[comment_url] = "nwn/?go=dlcomments2&amp;fileid=$_GET[fileid]";

	// Kommentare lesen
    $index_dlcomms = mysql_query("select dl_comment_id from fsplus_dl_comments where dl_id = $_GET[fileid]", $db);
	$file_arr[kommentare] = mysql_num_rows($index_dlcomms);

/////   NEU ENDE   /////

    // User eingeloggt?
    if ($_SESSION[user_level] == "loggedin")
    {
        $file_arr[dl_link] = '<a target="_blank" href="?go=dl&amp;fileid='.$file_arr[dl_id].'&amp;dl=true"><b>Download</b></a><br><font color="red">Hinweis:</font> "Ziel speichern unter" ist nicht möglich.';
    }
    else
    {
        $file_arr[dl_link] = $phrases[dl_not_logged_in];
    }

    // Mirrors auslesen
    if ($index = mysql_query("select * from fs_dl_mirrors where dl_id = $file_arr[dl_id]", $db))
    {
        $counter = 0;
        while ($mirror_arr = mysql_fetch_assoc($index))
        {
            $counter += 1;
            $index2 = mysql_query("select template_code from fs_template where template_name = 'dl_mirror'", $db);
            $template = stripslashes(mysql_result($index2, 0, "template_code"));
            $template = str_replace("{nummer}", $counter, $template);
            $template = str_replace("{name}", $mirror_arr[mirror_name], $template);
            $template = str_replace("{url}", "nwn/?go=dl&amp;mirrorid=".$mirror_arr[mirror_id]."&amp;dl=true", $template);
            $template = str_replace("{hits}", $mirror_arr[mirror_count], $template);
            $mirrors .= $template;
        }
        unset($mirror_arr);
    }


    // Suchfeld auslesen
    $index = mysql_query("select template_code from fs_template where template_name = 'dl_search_field'", $db);
    $suchfeld = stripslashes(mysql_result($index, 0, "template_code"));

    // Navigation erzeugen
    $valid_ids = array();
    get_dl_categories (&$valid_ids, -1);

    foreach ($valid_ids as $cat)
    {
        if ($cat[cat_id] == $file_arr[cat_id])
        {
            $icon = "dl_ordner_offen.gif";
        }
        else
        {
            $icon = "dl_ordner.gif";
        }
        $index = mysql_query("select template_code from fs_template where template_name = 'dl_navigation'", $db);
        $template = stripslashes(mysql_result($index, 0, "template_code"));
        $template = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $cat[ebene]) . $template;
        $template = str_replace("{kategorie_url}", "nwn2/?go=download3&amp;catid=".$cat[cat_id], $template);
        $template = str_replace("{icon}", $icon, $template);
        $template = str_replace("{kategorie_name}", $cat[cat_name], $template);
        $navi .= $template;
    }
    unset($valid_ids);

    $index = mysql_query("select template_code from fs_template where template_name = 'dl_file_body'", $db);
    $template = stripslashes(mysql_result($index, 0, "template_code"));
    $template = str_replace("{navigation}", $navi, $template);
    $template = str_replace("{suchfeld}", $suchfeld, $template);
    $template = str_replace("{titel}", $file_arr[dl_name], $template);
    $template = str_replace("{größe}", $file_arr[dl_size_berechnet], $template);
    $template = str_replace("{bild}", $file_arr[dl_bild], $template);
    $template = str_replace("{thumbnail}", $file_arr[dl_thumb], $template);
    $template = str_replace("{datum}", $file_arr[dl_date], $template);
    $template = str_replace("{uploader}", $file_arr[user_name], $template);
    $template = str_replace("{uploader_url}", $file_arr[user_url], $template);
    $template = str_replace("{autor_link}", $file_arr[dl_autor_link], $template);
    $template = str_replace("{traffic}", $file_arr[dl_traffic], $template);
    $template = str_replace("{hits}", $file_arr[dl_loads], $template);
    $template = str_replace("{text}", $file_arr[dl_text], $template);
    $template = str_replace("{link}", $file_arr[dl_link], $template);
    $template = str_replace("{mirrors}", $mirrors, $template);
    $template = str_replace("{kommentar_url}", $file_arr[comment_url], $template);
    $template = str_replace("{kommentar_anzahl}", $file_arr[kommentare], $template);

    echo $template;

    unset($template);

}
else
{
    sys_message($phrases[sysmessage], $phrases[dl_not_exist]);
}

// Kommentare erzeugen
$index = mysql_query("select * from fsplus_dl_comments where dl_id = $_GET[fileid] order by comment_date asc", $db);
while ($comment_arr = mysql_fetch_assoc($index))
{
    // User auslesen
    if ($comment_arr[comment_poster_id] != 0)
    {
        $index2 = mysql_query("select user_name, is_admin from fs_user where user_id = $comment_arr[comment_poster_id]", $db);
        $comment_arr[comment_poster] = killhtml(mysql_result($index2, 0, "user_name"));
        $comment_arr[is_admin] = mysql_result($index2, 0, "is_admin");
        if (file_exists("images/avatare/".$comment_arr[comment_poster_id].".gif"))
        {
            $comment_arr[comment_avatar] = '<div style="width:120px;"><img align="left" src="images/avatare/'.$comment_arr[comment_poster_id].'.gif" alt="'.$comment_arr[comment_poster].'"></div>';
        }
        if ($comment_arr[is_admin] == 1)
        {
            $comment_arr[comment_poster] = "<b>" . $comment_arr[comment_poster] . "</b>";
        }
        $index2 = mysql_query("select template_code from fs_template where template_name = 'news_comment_autor'", $db);
        $comment_autor = stripslashes(mysql_result($index2, 0, "template_code"));
        $comment_autor = str_replace("{url}", "?go=profil&amp;userid=".$comment_arr[comment_poster_id], $comment_autor);
        $comment_autor = str_replace("{name}", $comment_arr[comment_poster], $comment_autor);
        $comment_arr[comment_poster] = $comment_autor;
    }
    else
    {
        $comment_arr[comment_avatar] = "";
        $comment_arr[comment_poster] = killhtml($comment_arr[comment_poster]);
    }

    // Text formatieren
    if ($config_arr[html_code] < 3)
    {
        $comment_arr[comment_text] = killhtml($comment_arr[comment_text]);
    }
    if ($config_arr[fs_code] == 3)
    {
        $comment_arr[comment_text] = fscode($comment_arr[comment_text], 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, 0);
    }
    else
    {
        $comment_arr[comment_text] = fscode($comment_arr[comment_text], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    }

    $comment_arr[comment_date] = date("d.m.Y" , $comment_arr[comment_date]) . " um " . date("H:i" , $comment_arr[comment_date]);

    // Template auslesen und füllen
    $index2 = mysql_query("select template_code from fs_template where template_name = 'news_comment_body'", $db);
    $template = stripslashes(mysql_result($index2, 0, "template_code"));
    $template = str_replace("{titel}", killhtml($comment_arr[comment_title]), $template);
    $template = str_replace("{datum}", $comment_arr[comment_date], $template);
    $template = str_replace("{text}", $comment_arr[comment_text], $template);
    $template = str_replace("{autor}", $comment_arr[comment_poster], $template);
    $template = str_replace("{autor_avatar}", $comment_arr[comment_avatar], $template);

    echo $template;
}
unset($comment_arr);

// Eingabeformular generieren
$index = mysql_query("select template_code from fs_template where template_name = 'news_comment_form_name'", $db);
$form_name = stripslashes(mysql_result($index, 0, "template_code"));

$index = mysql_query("select template_code from fs_template where template_name = 'news_comment_form_spam'", $db);
$form_spam = stripslashes(mysql_result($index, 0, "template_code"));

$form_spam_text ='<br /><br />
 <table border="0" cellspacing="5" cellpadding="0" width="100%">
  <tr>
   <td valign="top" align="left">
<div id="antispam"><font size="1">* Auf dieser Seite kann jeder einen Kommentar zu einer News abgeben. Leider ist sie dadurch ein beliebtes Ziel von sog. Spam-Bots - speziellen Programmen, die automatisiert und zum Teil massenhaft Links zu anderen Internetseiten platzieren. Um das zu verhindern, müssen nicht registrierte User eine einfache Rechenaufgabe lösen, die für die meisten Spam-Bots aber nicht lösbar ist. Wenn du nicht jedesmal eine solche Aufgabe lösen möchtest, kannst du dich einfach bei uns <a href="?go=register">registrieren</a>.</font></div>
   </td>
  </tr>
 </table>';

if (isset($_SESSION[user_name]))
{
    $form_name = $_SESSION[user_name];
    $form_name .= '<input type="hidden" name="name" id="name" value="1">';
    $form_spam = "";
    $form_spam_text ="";
}

$index = mysql_query("select template_code from fs_template where template_name = 'news_comment_form'", $db);
$template = stripslashes(mysql_result($index, 0, "template_code"));
$template = str_replace("{newsid}", $_GET[fileid], $template);
$template = str_replace("{name_input}", $form_name, $template);
$template = str_replace("{antispam}", $form_spam, $template);
$template = str_replace("{antispamtext}", $form_spam_text, $template);

echo $template;
unset($template);

$fileid = $_GET[fileid];

?>