<?php

/////////////////////////
//// Profil anzeigen ////
/////////////////////////

settype($_GET[userid], "integer");
$index = mysql_query("select * from fs_user where user_id = $_GET[userid]", $db);

if (mysql_num_rows($index) > 0)
{
    $user_arr = mysql_fetch_assoc($index);

    if ($user_arr[show_mail] != 1)
    {
        $user_arr[user_mail] = "-";
    }

    // Geschriebene Kommentare
    $index = mysql_query("select comment_id from fs_news_comments where comment_poster_id = $_GET[userid]", $db);
    $user_arr[user_comments] = mysql_num_rows($index);

    // Geschriebene Artikel
    $index = mysql_query("select artikel_url from fs_artikel where artikel_user = $_GET[userid]", $db);
    $user_arr[user_artikel] = mysql_num_rows($index);

    // Geschriebene News
    $index = mysql_query("select news_id from fs_news where user_id = $_GET[userid]", $db);
    $user_arr[user_news] = mysql_num_rows($index);

    if (image_exists("images/avatare/",$_GET[userid]))
    {
        $user_arr[user_avatar] = '<img src="'.image_url("images/avatare/",$_GET[userid]).'" />';
    }
    else
    {
        $user_arr[user_avatar] = $phrases[no_avatar];
    }

    // Template aufbauen
    $index = mysql_query("select user_profil from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "user_profil"));
    $template = str_replace("{username}", killhtml($user_arr[user_name]), $template); 
    $template = str_replace("{avatar}", $user_arr[user_avatar], $template); 
    $template = str_replace("{email}", $user_arr[user_mail], $template); 
    $template = str_replace("{reg_datum}", date("d.m.Y", $user_arr[reg_date]), $template); 
    $template = str_replace("{news}", $user_arr[user_news], $template); 
    $template = str_replace("{artikel}", $user_arr[user_artikel], $template); 
    $template = str_replace("{kommentare}", $user_arr[user_comments], $template);

}

/////////////////////////
//// Falsche User ID ////
/////////////////////////

else
{
    $template = sys_message($phrases[sysmessage], $phrases[user_not_exist]);
}
?>