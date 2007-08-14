<?php
/////////////////////////////
//// Kategorie existiert  ///
/////////////////////////////
if (isset($_GET[catid]))
{
    $index = mysql_query("SELECT cat_name, cat_visibility FROM fs_screen_cat WHERE cat_id = $_GET[catid]", $db);
    if (mysql_num_rows($index) <= 0) {
        unset($_GET[catid]);
    } elseif (mysql_result($index,0,cat_visibility)==0) {
        unset($_GET[catid]);
    }
}

////////////////////////////
//// Kategorie anzeigen ////
////////////////////////////

if (isset($_GET[catid]))
{
    settype($_GET[catid], 'integer');

    //config_arr
    $index = mysql_query("SELECT * FROM fs_screen_config", $db);
    $config_arr = mysql_fetch_assoc($index);
    
    //cat_arr
    $index = mysql_query("SELECT * FROM fs_screen_cat WHERE cat_id = $_GET[catid]", $db);
    $cat_arr = mysql_fetch_assoc($index);

    //Wieviele Screenshots
    if ($cat_arr[cat_type]==2) {
        $index = mysql_query("SELECT COUNT(wallpaper_id) AS number FROM fs_wallpaper WHERE cat_id = $_GET[catid]", $db);
    } else {
        $index = mysql_query("SELECT COUNT(screen_id) AS number FROM fs_screen WHERE cat_id = $_GET[catid]", $db);
    }

    $config_arr[number_of_screens] = mysql_result($index, 0, "number");
    if ($config_arr[pics_per_page]==-1) {
        $config_arr[pics_per_page] = $config_arr[number_of_screens];
    }
    $config_arr[number_of_pages] = ceil($config_arr[number_of_screens]/$config_arr[pics_per_page]);

    if (!isset($_GET['page']))
    {$_GET['page']=1;}
    if ($_GET['page']<1)
    {$_GET['page']=1;}
    if ($_GET['page']>$config_arr[number_of_pages])
    {$_GET['page']=$config_arr[number_of_pages];}
    
    $config_arr[oldpage] = $_GET['page']-1;
    $config_arr[newpage] = $_GET['page']+1;
    $config_arr[page_start] = ($_GET['page']-1)*$config_arr[pics_per_page];

    // Screenshots lesen
    if ($config_arr[number_of_screens]>0)
    {
        //Wallpaper Kategorie
        if ($cat_arr[cat_type]==2)
        {
            $zaehler = 0;
            $index = mysql_query("SELECT * FROM fs_wallpaper WHERE cat_id = $_GET[catid] ORDER BY wallpaper_id $config_arr[sort] LIMIT $config_arr[page_start],$config_arr[pics_per_page]", $db);
            while ($wp_arr = mysql_fetch_assoc($index))
            {
                $wp_arr[thumb_url] = image_url("images/wallpaper/", $wp_arr[wallpaper_name]."_s");

                $index2 = mysql_query("SELECT * FROM fs_wallpaper_sizes WHERE wallpaper_id = $wp_arr[wallpaper_id] ORDER BY size_id ASC", $db);
                $sizes = "";
                while ($sizes_arr = mysql_fetch_assoc($index2))
                {
                    $sizes_arr[url] = image_url("images/wallpaper/", $wp_arr[wallpaper_name]."_".$sizes_arr[size]);

                    $index3 = mysql_query("select wallpaper_sizes from fs_template where id = '$global_config_arr[design]'", $db);
                    $sizes_arr[template] = stripslashes(mysql_result($index3, 0, "wallpaper_sizes"));
                    $sizes_arr[template] = str_replace("{url}", $sizes_arr[url], $sizes_arr[template]);
                    $sizes_arr[template]= str_replace("{size}", $sizes_arr[size], $sizes_arr[template]);
                    
                    $sizes .= $sizes_arr[template];
                }
                
                $index2 = mysql_query("select wallpaper_pic from fs_template where id = '$global_config_arr[design]'", $db);
                $template = stripslashes(mysql_result($index2, 0, "wallpaper_pic"));
                $template = str_replace("{thumb_url}", $wp_arr[thumb_url], $template);
                $template = str_replace("{text}", $wp_arr[wallpaper_title], $template);
                $template = str_replace("{sizes}", $sizes, $template);

                $zaehler += 1;
                switch ($zaehler)
                {
                    case $config_arr[pics_per_row] == 1:
                        $zaehler = 0;
                        $pics .= "<tr>\n\r";
                        $pics .= $template;
                        $pics .= "</tr>\n\r";
                        break;
                    case $config_arr[pics_per_row]:
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
                } // Switch ende
            } // While Ende
        }
        //Screenshot Kategorie
        else
        {
            $zaehler = 0;
            $index = mysql_query("SELECT * FROM fs_screen WHERE cat_id = $_GET[catid] ORDER by screen_id $config_arr[sort] LIMIT $config_arr[page_start],$config_arr[pics_per_page]", $db);

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
                    case $config_arr[pics_per_row] == 1:
                        $zaehler = 0;
                        $pics .= "<tr>\n\r";
                        $pics .= $template;
                        $pics .= "</tr>\n\r";
                        break;
                    case $config_arr[pics_per_row]:
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
                } // Switch ende
            } // While Ende
        } // WP/Screen Ende
    } // Bilder > 0 Ende
    unset($sizes_arr);
    unset($wp_arr);
    unset($screen_arr);

    //Seitennavigation
    $pagenav = stripslashes($global_config_arr[page]);
    $prev = stripslashes($global_config_arr[page_prev]);
    $next = stripslashes($global_config_arr[page_next]);
    $pagenav = str_replace("{page_number}", $_GET[page], $pagenav );
    $pagenav = str_replace("{total_pages}", $config_arr[number_of_pages], $pagenav );
    //Zurück-Schaltfläche
    if ($_GET['page'] > 1) {
      $prev = str_replace("{url}", "?go=$_GET[go]&catid=$_GET[catid]&page=$config_arr[oldpage]", $prev);
      $pagenav = str_replace("{prev}", $prev , $pagenav);
    } else {
      $pagenav = str_replace("{prev}", "", $pagenav);
    }
    //Weiter-Schaltfläche
    if (($_GET['page']*$config_arr[pics_per_page]) < $config_arr[number_of_screens]) {
      $next = str_replace("{url}", "?go=$_GET[go]&catid=$_GET[catid]&page=$config_arr[newpage]", $next);
      $pagenav = str_replace("{next}", "$next", $pagenav);
    } else {
      $pagenav = str_replace("{next}", "", $pagenav);;
    }
    
    //Keine Screenshots
    if ($config_arr[number_of_screens] <= 0) {
        $pics = sys_message($phrases[sysmessage], $phrases[no_pics]);
        $pagenav = "";
    }
    //Ausgabe der Seite
    $index = mysql_query("select screenshot_cat_body from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "screenshot_cat_body"));
    $template = str_replace("{title}", $cat_arr[cat_name], $template);
    $template = str_replace("{screenshots}", $pics, $template);
    $template = str_replace("{page}", $pagenav, $template);

    unset($pics);
}

////////////////////////////
//// Kategorien listen /////
////////////////////////////

else
{
    $index = mysql_query("SELECT * FROM fs_screen_cat WHERE cat_visibility = 1 ORDER BY cat_date DESC", $db);
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        if ($cat_arr[cat_type]==2) {
            $index2 = mysql_query("SELECT COUNT(wallpaper_id) AS number FROM fs_wallpaper WHERE cat_id = $cat_arr[cat_id]", $db);
        } else {
            $index2 = mysql_query("SELECT COUNT(screen_id) AS number FROM fs_screen WHERE cat_id = $cat_arr[cat_id]", $db);
        }
        $cat_arr[cat_menge] = mysql_result($index2,0,"number");

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
    $template = str_replace("{cats}", $cats, $template);

    unset($cats);
}
?>