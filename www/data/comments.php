<?php
//////////////////////////////
//// Kommentar hinzufügen ////
//////////////////////////////

if (isset($_POST[addcomment]))
{
    if ($_POST[id] && ($_POST[name] != "" || $_SESSION["user_id"]) && $_POST[title] != "" && $_POST[text] != "")
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

        mysql_query("INSERT INTO fs_news_comments (news_id, comment_poster, comment_poster_id, comment_date, comment_title, comment_text)
                     VALUES ('".$_POST[id]."',
                             '".$_POST[name]."',
                             '$userid',
                             '$commentdate',
                             '".$_POST[title]."',
                             '".$_POST[text]."');", $db);
        mysql_query("update fs_counter set comments=comments+1", $db);
    }
    else
    {
        sys_message($phrases[add_comment], $phrases[comment_not_added]);
    }
}

//////////////////////////////
//// Kommentare ausgeben /////
//////////////////////////////

settype($_GET[id], 'integer');
$index = mysql_query("select * from fs_news_config", $db);
$config_arr = mysql_fetch_assoc($index);
$time = time();

// News anzeigen
$index = mysql_query("select * from fs_news where news_date <= $time and news_id = $_GET[id]", $db);
while ($news_arr = mysql_fetch_assoc($index))
{
   $news_template .= display_news($news_arr, $config_arr[html_code], $config_arr[fs_code], $config_arr[para_handling]);
}
unset($news_arr);

// Kommentare erzeugen
$index = mysql_query("select * from fs_news_comments where news_id = $_GET[id] order by comment_date desc", $db);
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
        $index2 = mysql_query("select news_comment_autor from fs_template where id = '$global_config_arr[design]'", $db);
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

    // Text formatieren
    switch ($config_arr[html_code])
    {
        case 1:
            $html = false;
            break;
        case 2:
            $html = false;
            break;
        case 3:
            $html = true;
            break;
        case 4:
            $html = true;
            break;
    }
    switch ($config_arr[fs_code])
    {
        case 1:
            $fs = false;
            break;
        case 2:
            $fs = false;
            break;
        case 3:
            $fs = true;
            break;
        case 4:
            $fs = true;
            break;
    }
    switch ($config_arr[para_handling])
    {
        case 1:
            $para = false;
            break;
        case 2:
            $para = false;
            break;
        case 3:
            $para = true;
            break;
        case 4:
            $para = true;
            break;
    }

    $comment_arr[comment_text] = fscode($comment_arr[comment_text],$fs,$html,$para);
    $comment_arr[comment_date] = date("d.m.Y" , $comment_arr[comment_date]) . " um " . date("H:i" , $comment_arr[comment_date]);

    //FScode-Html Anzeige
    $fs_active = ($fs) ? "an" : "aus";
    $html_active = ($html) ? "an" : "aus";

    // Template auslesen und füllen
    $index2 = mysql_query("select news_comment_body from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index2, 0, "news_comment_body"));
    $template = str_replace("{titel}", killhtml($comment_arr[comment_title]), $template); 
    $template = str_replace("{datum}", $comment_arr[comment_date], $template); 
    $template = str_replace("{text}", $comment_arr[comment_text], $template); 
    $template = str_replace("{autor}", $comment_arr[comment_poster], $template); 
    $template = str_replace("{autor_avatar}", $comment_arr[comment_avatar], $template); 

    $comments_template .= $template;
}
unset($comment_arr);

// Eingabeformular generieren
$index = mysql_query("select news_comment_form_name from fs_template where id = '$global_config_arr[design]'", $db);
$form_name = stripslashes(mysql_result($index, 0, "news_comment_form_name"));

if (isset($_SESSION[user_name]))
{
    $form_name = $_SESSION[user_name]; 
    $form_name .= '<input type="hidden" name="name" id="name" value="1">';; 
}

$index = mysql_query("select news_comment_form from fs_template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "news_comment_form"));
$template = str_replace("{newsid}", $_GET[id], $template); 
$template = str_replace("{name_input}", $form_name, $template); 
$template = str_replace("{textarea}", code_textarea("text", "", 357, 120, "text", false, 1,1,1,1,1,1,1,1,1,1,0,1,0,1,1,1,1), $template);
$template = str_replace("{fs_code}", $fs_active, $template);
$template = str_replace("{html}", $html_active, $template);

$formular_template = $template;

$template = $news_template.$comments_template.$formular_template;
?>