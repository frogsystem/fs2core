<?php

////////////////////////////
//// Kategorie anzeigen ////
////////////////////////////

if (isset($_GET[catid]))
{
    settype($_GET[catid], 'integer');

    //config_arr
    $index = mysql_query("SELECT * FROM fs_screen_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    //Wieviele Screenshots
    $index = mysql_query("SELECT COUNT(*) AS number FROM fs_screen WHERE cat_id = $_GET[catid]", $db);
    $config_arr[number_of_screens] = mysql_result($index, 0, "number");
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

    // Kategorie Namen lesen
    $index = mysql_query("SELECT cat_name FROM fs_screen_cat WHERE cat_id = $_GET[catid]", $db);
    $cat_name = mysql_result($index, 0, "cat_name");

    // Screenshots lesen
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
        }
    }
    unset($screen_arr);

    //Seitennavigation
    $pagenav = $global_config_arr[page];
    $pagenav = str_replace("{page_number}", $_GET[page], $pagenav );
    $pagenav = str_replace("{total_pages}", $config_arr[number_of_pages], $pagenav );
    //Zurück-Schaltfläche
    if ($_GET['page'] > 1) {
      $pagenav = str_replace("{prev}", "<a href='?go=screenshots&catid=$_GET[catid]&page=$config_arr[oldpage]'><< </a>", $pagenav);
    } else {
      $pagenav = str_replace("{prev}", "", $pagenav);
    }
    //Weiter-Schaltfläche
    if (($_GET['page']*$config_arr[pics_per_page]) < $config_arr[number_of_screens]) {
      $pagenav = str_replace("{next}", "<a href='?go=screenshots&catid=$_GET[catid]&page=$config_arr[newpage]'> >></a>", $pagenav);
    } else {
      $pagenav = str_replace("{next}", "", $pagenav);;
    }

    //Ausgabe der Seite
    $index = mysql_query("select screenshot_cat_body from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "screenshot_cat_body"));
    $template = str_replace("{title}", $cat_name, $template);
    $template = str_replace("{screenshots}", $pics, $template);
    $template = str_replace("{page}", $pagenav, $template);

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