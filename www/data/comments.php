<?php
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
$sicherheits_eingabe = encrypt($_POST["spam"], "3g9sp3hr45");
$sicherheits_eingabe = str_replace("=", "", $sicherheits_eingabe);

//////////////////////////////
//// Configs laden         ////
//////////////////////////////

//Kommentar-Config
$index = mysql_query("select * from ".$global_config_arr[pref]."news_config", $db);
$config_arr = mysql_fetch_assoc($index);
//Editor config
$index = mysql_query("select * from ".$global_config_arr[pref]."editor_config", $db);
$editor_config = mysql_fetch_assoc($index);

//////////////////////////////
//// Kommentar hinzufügen ////
//////////////////////////////

if (isset($_POST[addcomment]))
{
    if ($config_arr[com_antispam]==0) {
      $anti_spam = true;
    } elseif ($config_arr[com_antispam]==1 AND $_SESSION["user_id"]) {
      $anti_spam = true;
    } elseif ($sicherheits_eingabe == $_SESSION['rechen_captcha_spam'] AND is_numeric($_POST["spam"]) == true AND $sicherheits_eingabe == true) {
      $anti_spam = true;
    } else {
      $anti_spam = false;
    }

    if ($_POST[id]
         && ($_POST[name] != "" || $_SESSION["user_id"])
         && $_POST[title] != ""
         && $_POST[text] != ""
         && $anti_spam == true)
    {
        settype($_POST[id], 'integer');
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

        mysql_query("INSERT INTO ".$global_config_arr[pref]."news_comments (news_id, comment_poster, comment_poster_id, comment_date, comment_title, comment_text)
                     VALUES ('".$_POST[id]."',
                             '".$_POST[name]."',
                             '$userid',
                             '$commentdate',
                             '".$_POST[title]."',
                             '".$_POST[text]."');", $db);
        mysql_query("update ".$global_config_arr[pref]."counter set comments=comments+1", $db);
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
        if (!($anti_spam == true))
        {
            $reason .= $phrases[comment_spam];
        }
        $template .= sys_message($phrases[comment_not_added], $reason);
    }
}

//////////////////////////////
//// Kommentare ausgeben /////
//////////////////////////////

settype($_GET[id], 'integer');
$time = time();

// News anzeigen
$index = mysql_query("select * from ".$global_config_arr[pref]."news where news_date <= $time and news_id = $_GET[id]", $db);

$news_rows = mysql_num_rows($index);

if ($news_rows > 0) {
    $news_arr = mysql_fetch_assoc($index);
    $news_template .= display_news($news_arr, $config_arr[html_code], $config_arr[fs_code], $config_arr[para_handling]);
} else {
    $news_template = sys_message($phrases[sysmessage], $phrases[news_not_exist]);
}

unset($news_arr);


// Text formatieren
switch ($config_arr[html_code])
{
    case 1: $html = false; break;
    case 2: $html = false; break;
    case 3: $html = true; break;
    case 4: $html = true; break;
}
switch ($config_arr[fs_code])
{
    case 1: $fs = false; break;
    case 2: $fs = false; break;
    case 3: $fs = true; break;
    case 4: $fs = true; break;
}
switch ($config_arr[para_handling])
{
    case 1: $para = false; break;
    case 2: $para = false; break;
    case 3: $para = true; break;
    case 4: $para = true; break;
}
    
//FScode-Html Anzeige
$fs_active = ($fs) ? "an" : "aus";
$html_active = ($html) ? "an" : "aus";
    
// Kommentare erzeugen
$index = mysql_query("select * from ".$global_config_arr[pref]."news_comments where news_id = $_GET[id] order by comment_date $config_arr[com_sort]", $db);
while ($comment_arr = mysql_fetch_assoc($index))
{
    // User auslesen
    if ($comment_arr[comment_poster_id] != 0)
    {
        $index2 = mysql_query("select user_name, is_admin from ".$global_config_arr[pref]."user where user_id = $comment_arr[comment_poster_id]", $db);
        $comment_arr[comment_poster] = killhtml(mysql_result($index2, 0, "user_name"));
        $comment_arr[is_admin] = mysql_result($index2, 0, "is_admin");
        if (image_exists("images/avatare/",$comment_arr[comment_poster_id]))
        {
            $comment_arr[comment_avatar] = '<img align="left" src="'.image_url("images/avatare/",$comment_arr[comment_poster_id]).'" alt="'.$comment_arr[comment_poster].'">';
        }
        if ($comment_arr[is_admin] == 1)
        {
            $comment_arr[comment_poster] = "<b>" . $comment_arr[comment_poster] . "</b>";
        }
        $index2 = mysql_query("select news_comment_autor from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
        $comment_autor = stripslashes(mysql_result($index2, 0, "news_comment_autor"));
        $comment_autor = str_replace("{url}", "?go=profil&amp;userid=".$comment_arr[comment_poster_id], $comment_autor); 
        $comment_autor = str_replace("{name}", $comment_arr[comment_poster], $comment_autor); 
        $comment_arr[comment_poster] = $comment_autor;
    }
    else
    {
        $comment_arr[comment_avatar] = "";
        $comment_arr[comment_poster] = killhtml($comment_arr[comment_poster]);
    }

    if ($fs == true) {
        $comment_arr[comment_text] = fscode($comment_arr[comment_text],$fs,$html,$para, $editor_config[do_bold], $editor_config[do_italic], $editor_config[do_underline], $editor_config[do_strike], $editor_config[do_center], $editor_config[do_url], $editor_config[do_home], $editor_config[do_email], $editor_config[do_img], $editor_config[do_cimg], $editor_config[do_list], $editor_config[do_numlist], $editor_config[do_font], $editor_config[do_color], $editor_config[do_size], $editor_config[do_code], $editor_config[do_quote], $editor_config[do_noparse], $editor_config[do_smilies]);
    } else {
        $comment_arr[comment_text] = fscode($comment_arr[comment_text],$fs,$html,$para);
    }

    $comment_arr[comment_text] = killsv($comment_arr[comment_text]);
    $comment_arr[comment_date] = date("d.m.Y" , $comment_arr[comment_date]) . " um " . date("H:i" , $comment_arr[comment_date]);
    
    $comment_arr[comment_title] =   killhtml($comment_arr[comment_title]);
    $comment_arr[comment_title] =   killsv($comment_arr[comment_title]);

    // Template auslesen und füllen
    $index2 = mysql_query("select news_comment_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index2, 0, "news_comment_body"));
    $template = str_replace("{titel}", $comment_arr[comment_title], $template);
    $template = str_replace("{datum}", $comment_arr[comment_date], $template); 
    $template = str_replace("{text}", $comment_arr[comment_text], $template); 
    $template = str_replace("{autor}", $comment_arr[comment_poster], $template); 
    $template = str_replace("{autor_avatar}", $comment_arr[comment_avatar], $template); 

    $comments_template .= $template;
}
unset($comment_arr);
if (mysql_num_rows($index) <= 0)
{
    $comments_template = "Es wurden keine Kommentare gefunden!";
}


// Eingabeformular generieren
$index = mysql_query("select news_comment_form_name from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$form_name = stripslashes(mysql_result($index, 0, "news_comment_form_name"));

$index = mysql_query("select news_comment_form_spam from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$form_spam = stripslashes(mysql_result($index, 0, "news_comment_form_spam"));
$form_spam = str_replace("{captcha_url}", "res/rechen-captcha.inc.php", $form_spam);
$form_spam = str_replace("{newsid}", $_GET[id], $form_spam);

$index = mysql_query("select news_comment_form_spamtext from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$form_spam_text = stripslashes(mysql_result($index, 0, "news_comment_form_spamtext"));

if (isset($_SESSION[user_name]))
{
    $form_name = $_SESSION[user_name]; 
    $form_name .= '<input type="hidden" name="name" id="name" value="1">';
}

if ($config_arr[com_antispam]==0 OR ($config_arr[com_antispam]==1 AND $_SESSION["user_id"]))
{
    $form_spam = "";
    $form_spam_text ="";
}

//Textarea
$template_textarea = create_textarea("text", "", $editor_config[textarea_width], $editor_config[textarea_height], "text", false, $editor_config[smilies],$editor_config[bold],$editor_config[italic],$editor_config[underline],$editor_config[strike],$editor_config[center],$editor_config[font],$editor_config[color],$editor_config[size],$editor_config[img],$editor_config[cimg],$editor_config[url],$editor_config[home],$editor_config[email],$editor_config[code],$editor_config[quote],$editor_config[noparse]);


$index = mysql_query("select news_comment_form from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "news_comment_form"));
$template = str_replace("{newsid}", $_GET[id], $template); 
$template = str_replace("{name_input}", $form_name, $template); 
$template = str_replace("{textarea}", $template_textarea, $template);
$template = str_replace("{fs_code}", $fs_active, $template);
$template = str_replace("{html}", $html_active, $template);
$template = str_replace("{antispam}", $form_spam, $template);
$template = str_replace("{antispamtext}", $form_spam_text, $template);

$formular_template = $template;

if ($news_rows>0 AND $news_arr[news_date]<=time())
{
    $index = mysql_query("SELECT news_comment_container FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "news_comment_container"));
    $template = str_replace("{news}", $news_template, $template);
    $template = str_replace("{comments}", $comments_template, $template);
    $template = str_replace("{comment_form}", $formular_template, $template);
}
else
{
    $template = $news_template;
}
?>