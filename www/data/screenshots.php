<?php

////////////////////////////
//// Kategorie anzeigen ////
////////////////////////////

if (isset($_GET[catid]))
{
    settype($_GET[catid], 'integer');

    // Kategorie Namen lesen
    $index = mysql_query("select cat_name from fs_screen_cat where cat_id = $_GET[catid]", $db);
    $cat_name = mysql_result($index, 0, "cat_name");

    // Screenshots lesen
    $zaehler = 0;
    $index = mysql_query("select * from fs_screen where cat_id = $_GET[catid] order by screen_id", $db);
    while ($screen_arr = mysql_fetch_assoc($index))
    {
        $screen_arr[screen_thumb] = "images/screenshots/$screen_arr[screen_id]_s.jpg";
        $screen_arr[screen_url] = "showimg.php?screen=1&amp;catid=$_GET[catid]&amp;screenid=$screen_arr[screen_id]";

        $index2 = mysql_query("select screenshot_pic from fs_template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index2, 0, "screenshot_pic"));
        $template = str_replace("{url}", $screen_arr[screen_url], $template); 
        $template = str_replace("{text}", $screen_arr[screen_name], $template); 
        $template = str_replace("{thumbnail}", $screen_arr[screen_thumb], $template); 

        $zaehler += 1;
        switch ($zaehler)
        {
            case 3:
                $zaehler = 0;
                $pics .= $template;
                $pics .= "</tr>\n\r";
                break;
            case 1:
                $pics .= "<tr>\n\r";
                $pics .= $template;
                break;
            default:
                $pics .= $template;
                break;
        }
    }
    unset($screen_arr);

    $index = mysql_query("select screenshot_cat_body from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "screenshot_cat_body"));
    $template = str_replace("{titel}", $cat_name, $template); 
    $template = str_replace("{screenshots}", $pics, $template); 

    unset($pics);
}

////////////////////////////
//// Kategorien listen /////
////////////////////////////

else
{
    $index = mysql_query("select * from fs_screen_cat order by cat_date desc", $db);
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        $index2 = mysql_query("select screen_id from fs_screen where cat_id = $cat_arr[cat_id]", $db);
        $cat_arr[cat_menge] = mysql_num_rows($index2);

        $cat_arr[cat_date] = date("d.m.Y", $cat_arr[cat_date]);
        $index2 = mysql_query("select screenshot_cat from fs_template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index2, 0, "screenshot_cat"));
        $template = str_replace("{url}", "?go=screenshots&amp;catid=$cat_arr[cat_id]", $template); 
        $template = str_replace("{datum}", $cat_arr[cat_date], $template); 
        $template = str_replace("{name}", $cat_arr[cat_name], $template); 
        $template = str_replace("{menge}", $cat_arr[cat_menge], $template); 
        $cats .= $template;
    }
    unset($cat_arr);

    $index = mysql_query("select screenshot_body from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "screenshot_body"));
    $template = str_replace("{kategorien}", $cats, $template); 

    unset($cats);
}
?>