<?php

settype($_GET[fileid], 'integer');
$index = mysql_query("select * from fs_dl where dl_id = $_GET[fileid] and dl_open = 1", $db);
if (mysql_num_rows($index) > 0)
{
    $file_arr = mysql_fetch_assoc($index);

    //Config einlesen
    $index = mysql_query("select * from fs_dl_config", $db);
    $dl_config_arr = mysql_fetch_assoc($index);

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
    if (image_exists("images/downloads/", "$file_arr[dl_id]_s"))
    {
        $file_arr[dl_bild] = image_url("images/downloads/", $file_arr[dl_id]);
        $file_arr[dl_thumb] = image_url("images/downloads/", "$file_arr[dl_id]_s");
    }
    else
    {
        $file_arr[dl_bild] = "images/design/nopic120.gif";
        $file_arr[dl_thumb] = "images/design/nopic120.gif";
    }

    // Sonstige Daten ermitteln
    $file_arr[dl_date] = date("d.m.Y" , $file_arr[dl_date]);
    $file_arr[dl_text] = fscode($file_arr[dl_text], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
    $index3 = mysql_query("select cat_name from fs_dl_cat where cat_id = '$file_arr[cat_id]'", $db);
    $file_arr[cat_name] = stripslashes(mysql_result($index3, 0, "cat_name"));



    if ($dl_config_arr[dl_rights]==2)
    {
      $dl_use = "";
    }
    elseif ($dl_config_arr[dl_rights]==1 AND $_SESSION[user_level] == "loggedin")
    {
      $dl_use = "";
    }
    else
    {
      $dl_use = "AND file_is_mirror = '1'";
    }

    //Messages generieren
    if ($dl_config_arr[dl_rights]==0)
    {
      if ($messages_template != "")
        $messages_template .= "<br />";
      $messages_template .= $phrases[dl_not_allowed];
    }

    if ($dl_config_arr[dl_rights]==1 AND $_SESSION[user_level] != "loggedin")
    {
      if ($messages_template != "")
        $messages_template .= "<br />";
      $messages_template .= $phrases[dl_not_logged_in];
    }

    if ($messages_template != "")
      $messages_template .= "<br />";
    $messages_template .= $phrases[dl_not_save_as];

      
    // User eingeloggt?
//    if ($_SESSION[user_level] == "loggedin")
//    {
//        $file_arr[dl_link] = '<a target="_blank" href="?go=dl&amp;fileid='.$file_arr[dl_id].'&amp;dl=true"><b>Download</b></a><br><font color="red">Hinweis:</font> "Ziel speichern unter" ist nicht möglich.';
//    }
//    else
//    {
//        $file_arr[dl_link] = $phrases[dl_not_logged_in];
//    }

    // Files auslesen
    if ($index = mysql_query("select * from fs_dl_files where dl_id = $file_arr[dl_id] $dl_use", $db))
    {
        $stats_arr[number] = mysql_num_rows($index);

        while ($mirror_arr = mysql_fetch_assoc($index))
        {
            $index2 = mysql_query("select dl_file from fs_template where id = '$global_config_arr[design]'", $db);
            $template = stripslashes(mysql_result($index2, 0, "dl_file"));
            
            $stats_arr[size] = $stats_arr[size] + $mirror_arr[file_size];
            $stats_arr[hits] = $stats_arr[hits] + $mirror_arr[file_count];
            $stats_arr[traffic] = $stats_arr[traffic] + ($mirror_arr[file_count]*$mirror_arr[file_size]);
            
            $index2 = mysql_query("select dl_file_is_mirror from fs_template where id = '$global_config_arr[design]'", $db);
            $mirror_arr[template] = stripslashes(mysql_result($index2, 0, "dl_file_is_mirror"));
            
            $template = str_replace("{name}", $mirror_arr[file_name], $template);
            $template = str_replace("{url}", "?go=dl&amp;fileid=".$mirror_arr[file_id]."&amp;dl=true", $template);
            $template = str_replace("{hits}", $mirror_arr[file_count], $template);
            $mirror_arr[file_traffic] = getsize($mirror_arr[file_size]*$mirror_arr[file_count]);
            $template = str_replace("{traffic}", $mirror_arr[file_traffic], $template);
            $mirror_arr[file_size] = getsize($mirror_arr[file_size]);
            $template = str_replace("{size}", $mirror_arr[file_size], $template);

            if ($mirror_arr[file_is_mirror] == 1) {
               $template = str_replace("{mirror_col}", "", $template);
               $template = str_replace("{mirror_ext}", $mirror_arr[template], $template); }
            else {
               $template = str_replace("{mirror_col}", " colspan='2'", $template);
               $template = str_replace("{mirror_ext}", "", $template); }

            $mirrors .= $template;
        }
        unset($mirror_arr);
    }

    // Stats erstellen
    $index = mysql_query("select dl_stats from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "dl_stats"));
    if ($stats_arr[number] == 1)
       $template = str_replace("{number}", "$stats_arr[number] Datei", $template);
    $template = str_replace("{number}", "$stats_arr[number] Dateien", $template);
    $template = str_replace("{hits}", $stats_arr[hits], $template);
    $stats_arr[traffic] = getsize($stats_arr[traffic]);
    $template = str_replace("{traffic}", $stats_arr[traffic], $template);
    $stats_arr[size] = getsize($stats_arr[size]);
    $template = str_replace("{size}", $stats_arr[size], $template);

    $stats = $template;


    // Suchfeld auslesen
    $index = mysql_query("select dl_search_field from fs_template where id = '$global_config_arr[design]'", $db);
    $suchfeld = stripslashes(mysql_result($index, 0, "dl_search_field"));

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
        $index = mysql_query("select dl_navigation from fs_template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index, 0, "dl_navigation"));
        $template = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $cat[ebene]) . $template;
        $template = str_replace("{kategorie_url}", "?go=download&amp;catid=".$cat[cat_id], $template);
        $template = str_replace("{icon}", $icon, $template);
        $template = str_replace("{kategorie_name}", $cat[cat_name], $template);
        $navi .= $template;
    }
    unset($valid_ids);

    $index = mysql_query("select dl_file_body from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "dl_file_body"));
    $template = str_replace("{navigation}", $navi, $template); 
    $template = str_replace("{suchfeld}", $suchfeld, $template); 
    $template = str_replace("{titel}", $file_arr[dl_name], $template); 
    $template = str_replace("{bild}", $file_arr[dl_bild], $template); 
    $template = str_replace("{thumbnail}", $file_arr[dl_thumb], $template); 
    $template = str_replace("{datum}", $file_arr[dl_date], $template); 
    $template = str_replace("{uploader}", $file_arr[user_name], $template); 
    $template = str_replace("{uploader_url}", $file_arr[user_url], $template); 
    $template = str_replace("{autor_link}", $file_arr[dl_autor_link], $template); 
    $template = str_replace("{text}", $file_arr[dl_text], $template); 
    $template = str_replace("{files}", $mirrors, $template);
    $template = str_replace("{stats}", $stats, $template);
    $template = str_replace("{cat}", $file_arr[cat_name], $template);
    $template = str_replace("{messages}", $messages_template, $template);
    
}
else
{
    $template = sys_message($phrases[sysmessage], $phrases[dl_not_exist]);
}
?>