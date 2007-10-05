<?php
////////////////////////////
/// Konfiguration laden ////
////////////////////////////
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_config", $db);
$config_arr = mysql_fetch_assoc($index);


/////////////////////////////
/// Navigation erzeugen /////
/////////////////////////////
if (!($config_arr[game_navi] == 0 && $config_arr[cat_navi] == 0 && $config_arr[lang_navi] == 0))
{
    unset($navi_arr);
    unset($last_arr);
    
    if ($config_arr[game_navi] != 0)
    { //Spiele anzeigen
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 1 ORDER BY title ASC", $db);
        while ($game_arr = mysql_fetch_assoc($index))
        {
            $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_game = $game_arr[id]", $db);
            if (mysql_result($select, 0, "number") > 0)
            { //Es existieren Presseberichte
                $navi_arr[] = $game_arr[id];
            
                if ($config_arr[cat_navi] != 0)
                { //Kategorien & Spiele anzeigen
                    $index2 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 2 ORDER BY title ASC", $db);
                    while ($cat_arr = mysql_fetch_assoc($index2))
                    {
                        $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_game = $game_arr[id] AND press_cat = $cat_arr[id]", $db);
                        if (mysql_result($select, 0, "number") > 0)
                        { //Es existieren Presseberichte
                            $navi_arr[][] = $cat_arr[id];

                            if ($config_arr[lang_navi] != 0)
                            { //Sprachen & Kategorien & Spiele anzeigen
                                $index3 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 3 ORDER BY title ASC", $db);
                                while ($lang_arr = mysql_fetch_assoc($index3))
                                {
                                    $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_game = $game_arr[id] AND press_cat = $cat_arr[id] AND press_lang = $lang_arr[id]", $db);
                                    if (mysql_result($select, 0, "number") > 0)
                                    { //Es existieren Presseberichte
                                        $navi_arr[][][] = $lang_arr[id];
                                        $last_arr[] = $lang_arr[id];
                                    }
                                }
                            }
                            else
                            {
                                $last_arr[] = $cat_arr[id];
                            }
                        }
                    }

                }
                elseif ($config_arr[lang_navi] != 0)
                { //Sprachen & Spiele anzeigen
                    $index1 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 3 ORDER BY title ASC", $db);
                    while ($lang_arr = mysql_fetch_assoc($index1))
                    {
                        $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_game = $game_arr[id] AND press_lang = $lang_arr[id]", $db);
                        if (mysql_result($select, 0, "number") > 0)
                        {
                            $navi_arr[][] = $lang_arr[id];
                            $last_arr[] = $lang_arr[id];
                        }
                    }
                }
                else
                {
                    $last_arr[] = $game_arr[id];
                }
                
            }
        }
    }

    elseif ($config_arr[cat_navi] != 0)
    { //Kategorien anzeigen
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 2 ORDER BY title ASC", $db);
        while ($cat_arr = mysql_fetch_assoc($index))
        {
            $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_cat = $cat_arr[id]", $db);
            if (mysql_result($select, 0, "number") > 0)
            { //Es existieren Presseberichte
                $navi_arr[] = $cat_arr[id];

                if ($config_arr[lang_navi] != 0)
                { //Sprachen & Kategorien anzeigen
                    $index2 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 3 ORDER BY title ASC", $db);
                    while ($lang_arr = mysql_fetch_assoc($index2))
                    {
                        $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_cat = $cat_arr[id] AND press_lang = $lang_arr[id]", $db);
                        if (mysql_result($select, 0, "number") > 0)
                        { //Es existieren Presseberichte
                            $navi_arr[][] = $lang_arr[id];
                            $last_arr[] = $lang_arr[id];
                        }
                    }
                }
                else
                {
                    $last_arr[] = $cat_arr[id];
                }
            }
        }
    }

    elseif ($config_arr[lang_navi] != 0)
    { //Sprachen anzeigen
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 3 ORDER BY title ASC", $db);
        while ($lang_arr = mysql_fetch_assoc($index))
        {
            $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_lang = $lang_arr[id]", $db);
            if (mysql_result($select, 0, "number") > 0)
            { //Es existieren Presseberichte
                $navi_arr[] = $lang_arr[id];
                $last_arr[] = $lang_arr[id];
            }
        }
    }
    
    unset($lines);



    //Navigation ausgeben
    foreach ($navi_arr as $value)
    {
        if (is_array($value) AND $open == true)
        {
            foreach ($value as $value2)
            {
                if (is_array($value2) AND $open2 == true)
                {
                    foreach ($value2 as $value3)
                    {
                        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE id = $value3", $db);
                        $entry_arr = mysql_fetch_assoc($index);

                        //Navi URL erstellen
                        $navi_url = $navi_url2;
                        switch ($entry_arr[type]) {
                            case 3: $navi_url3 = $navi_url . "&lang=".$entry_arr[id]; break;
                            case 2: $navi_url3 = $navi_url . "&cat=".$entry_arr[id]; break;
                            default: $navi_url3 = $navi_url . "&game=".$entry_arr[id]; break;
                        }
                        
                        //Icon URL erstellen
                        $entry_arr[icon_url] = "images/icons/folder.gif";
                        switch ($entry_arr[type]) {
                            case 3:
                                if ($_GET['lang']==$entry_arr[id])
                                {$entry_arr[icon_url] = "images/icons/folder_open.gif";}
                                break;
                            case 2:
                                if ($_GET['cat']==$entry_arr[id])
                                {$entry_arr[icon_url] = "images/icons/folder_open.gif";}
                                break;
                            default:
                                if ($_GET['game']==$entry_arr[id])
                                {$entry_arr[icon_url] = "images/icons/folder_open.gif";}
                                break;
                        }

                        $index = mysql_query("SELECT press_navi_line FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
                        $template = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".stripslashes(mysql_result($index, 0, "press_navi_line"));
                        $template = str_replace("{navi_url}", $navi_url3, $template);
                        $template = str_replace("{title}", $entry_arr[title], $template);
                        $template = str_replace("{img_url}", image_url("images/press/", $entry_arr[type]."_".$entry_arr[id]), $template);
                        $template = str_replace("{icon_url}", $entry_arr[icon_url], $template);
                        $lines .= $template;
                    }
                }
                elseif (!is_array($value2))
                {
                    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE id = $value2", $db);
                    $entry_arr = mysql_fetch_assoc($index);

                    //Navi URL erstellen
                    $navi_url = $navi_url1;
                    switch ($entry_arr[type]) {
                        case 3: $navi_url2 = $navi_url . "&lang=".$entry_arr[id]; break;
                        case 2: $navi_url2 = $navi_url . "&cat=".$entry_arr[id]; break;
                        default: $navi_url2 = $navi_url . "&game=".$entry_arr[id]; break;
                    }

                    //Icon URL erstellen, nur Unterordner von geöffneten Ordner anzeigen
                    $entry_arr[icon_url] = "images/icons/folder.gif";
                    $open2 = false;
                    switch ($entry_arr[type]) {
                        case 3:
                            if ($_GET['lang']==$entry_arr[id])
                            {$entry_arr[icon_url] = "images/icons/folder_open.gif";$open2=true;}
                            break;
                        case 2:
                            if ($_GET['cat']==$entry_arr[id])
                            {$entry_arr[icon_url] = "images/icons/folder_open.gif";$open2=true;}
                            break;
                        default:
                            if ($_GET['game']==$entry_arr[id])
                            {$entry_arr[icon_url] = "images/icons/folder_open.gif";$open2=true;}
                            break;
                    }

                    $index = mysql_query("SELECT press_navi_line FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
                    $template = "&nbsp;&nbsp;&nbsp;&nbsp;".stripslashes(mysql_result($index, 0, "press_navi_line"));
                    $template = str_replace("{navi_url}", $navi_url2, $template);
                    $template = str_replace("{title}", $entry_arr[title], $template);
                    $template = str_replace("{img_url}", image_url("images/press/", $entry_arr[type]."_".$entry_arr[id]), $template);
                    $template = str_replace("{icon_url}", $entry_arr[icon_url], $template);
                    $lines .= $template;
                }
            }
        }
        elseif (!is_array($value))
        {
            $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE id = $value", $db);
            $entry_arr = mysql_fetch_assoc($index);
            
            //Navi URL erstellen
            $navi_url = "?go=press";
            switch ($entry_arr[type]) {
                case 3: $navi_url1 = $navi_url . "&lang=".$entry_arr[id]; break;
                case 2: $navi_url1 = $navi_url . "&cat=".$entry_arr[id]; break;
                default: $navi_url1 = $navi_url . "&game=".$entry_arr[id]; break;
            }
            
            //Icon URL erstellen
            $entry_arr[icon_url] = "images/icons/folder.gif";
            $open = false;
            switch ($entry_arr[type]) {
                case 3:
                    if ($_GET['lang']==$entry_arr[id])
                    {$entry_arr[icon_url] = "images/icons/folder_open.gif"; $open=true;}
                    break;
                case 2:
                    if ($_GET['cat']==$entry_arr[id])
                    {$entry_arr[icon_url] = "images/icons/folder_open.gif"; $open=true;}
                    break;
                default:
                    if ($_GET['game']==$entry_arr[id])
                    {$entry_arr[icon_url] = "images/icons/folder_open.gif"; $open=true;}
                    break;
            }
            
            $index = mysql_query("SELECT press_navi_line FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
            $template = stripslashes(mysql_result($index, 0, "press_navi_line"));
            $template = str_replace("{navi_url}", $navi_url1, $template);
            $template = str_replace("{title}", $entry_arr[title], $template);
            $template = str_replace("{img_url}", image_url("images/press/", $entry_arr[type]."_".$entry_arr[id]), $template);
            $template = str_replace("{icon_url}", $entry_arr[icon_url], $template);
            $lines .= $template;
        }
    }

    $index = mysql_query("SELECT press_navi_main FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "press_navi_main"));
    $template = str_replace("{lines}", "",$lines);
    $navigation = $template;
}
else
{
    $index = mysql_query("SELECT press_navi_main FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "press_navi_main"));
    $template = str_replace("{lines}", "", $template);
    $navigation = $template;
}

unset($lines);
unset($template);


////////////////////////////
/// WHEREs erzeugen ////////
////////////////////////////

unset($where);
$config_arr[show_press_sql] = true;
$number_of_layers = $config_arr[game_navi] + $config_arr[cat_navi] + $config_arr[lang_navi];

//Nur unterste Ebene
if ($config_arr[show_press] == 0)
{
    if (!isset($_GET[game]) && !isset($_GET[cat]) && !isset($_GET[lang]) && $config_arr[show_root] == 0)
    {
        $config_arr[show_press_sql] = false;
    }
    elseif (!isset($_GET[game]) && !isset($_GET[cat]) && !isset($_GET[lang]) && $number_of_layers == 0)
    {
        $config_arr[show_press] = 1;
    }
    elseif (in_array($_GET[game], $last_arr) || in_array($_GET[cat], $last_arr) || in_array($_GET[lang], $last_arr))
    {
        $config_arr[show_press] = 1;
    }
    else
    {
        $config_arr[show_press_sql] = false;
    }
    
}
//Immer
if ($config_arr[show_press] == 1)
{
    if (!isset($_GET[game]) && !isset($_GET[cat]) && !isset($_GET[lang]) && $config_arr[show_root] == 0)
    {
        $config_arr[show_press_sql] = false;
    }

    if (isset($_GET[game])) {
        settype($_GET[game], 'integer');
        $where[] = "press_game = $_GET[game]";
    }
    if (isset($_GET[cat])) {
        settype($_GET[cat], 'integer');
        $where[] = "press_cat = $_GET[cat]";
    }
    if (isset($_GET[lang])) {
        settype($_GET[lang], 'integer');
        $where[] = "press_lang = $_GET[lang]";
    }

    if (count($where) > 0) {
        $where_clause = "WHERE";
        $first = true;
        foreach($where as $value) {
            if ($first == true) {
                $where_clause .= " " . $value;
                $first = false;
            } else {
                $where_clause .= " AND " . $value;
            }
        }
    }
}


/////////////////////////////
/// Presseberichte laden ////
/////////////////////////////
if ($config_arr[show_press_sql] == true)
{
    $sql_query = "SELECT * FROM ".$global_config_arr[pref]."press $where_clause ORDER BY $config_arr[order_by] $config_arr[order_type]";
    $index = mysql_query($sql_query, $db);

    unset($press_releases);
    
    while ($press_arr = mysql_fetch_assoc($index))
    {
        $index2 = mysql_query("SELECT press_intro FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
        $press_arr[press_intro_formated] = stripslashes(mysql_result($index2, 0, "press_intro"));
        $press_arr[press_intro_formated] = str_replace("{intro_text}", fscode($press_arr[press_intro]), $press_arr[press_intro_formated]);
        $index2 = mysql_query("SELECT press_note FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
        $press_arr[press_note_formated] = stripslashes(mysql_result($index2, 0, "press_note"));
        $press_arr[press_note_formated] = str_replace("{note_text}", fscode($press_arr[press_note]), $press_arr[press_note_formated]);

        $index2 = mysql_query("SELECT title FROM ".$global_config_arr[pref]."press_admin WHERE id = '$press_arr[press_game]'", $db);
        $press_arr[press_game_title] = stripslashes(mysql_result($index2, 0, "title"));
        $index2 = mysql_query("SELECT title FROM ".$global_config_arr[pref]."press_admin WHERE id = '$press_arr[press_cat]'", $db);
        $press_arr[press_cat_title] = stripslashes(mysql_result($index2, 0, "title"));
        $index2 = mysql_query("SELECT title FROM ".$global_config_arr[pref]."press_admin WHERE id = '$press_arr[press_lang]'", $db);
        $press_arr[press_lang_title] = stripslashes(mysql_result($index2, 0, "title"));

        $index2 = mysql_query("SELECT press_body FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index2, 0, "press_body"));
        $template = str_replace("{title}", $press_arr[press_title], $template);
        $template = str_replace("{url}", $press_arr[press_url], $template);
        $template = str_replace("{date}", date($global_config_arr[date], $press_arr[press_date]), $template);
        $template = str_replace("{text}", fscode($press_arr[press_text]), $template);
        if ($press_arr[press_intro] != "") {
            $template = str_replace("{intro}", $press_arr[press_intro_formated], $template);
        } else {
            $template = str_replace("{intro}", "", $template);
            }
        if ($press_arr[press_note] != "") {
            $template = str_replace("{note}", $press_arr[press_note_formated], $template);
        } else {
            $template = str_replace("{note}", "", $template);
        }    //$template = str_replace("{note}", $press_arr[press_note_formated], $template);
        $template = str_replace("{game_title}", $press_arr[press_game_title], $template);
        $template = str_replace("{game_img_url}", image_url("images/press/", "1_".$press_arr[press_game]), $template);
        $template = str_replace("{cat_title}", $press_arr[press_cat_title], $template);
        $template = str_replace("{cat_img_url}", image_url("images/press/", "2_".$press_arr[press_cat]), $template);
        $template = str_replace("{lang_title}", $press_arr[press_lang_title], $template);
        $template = str_replace("{lang_img_url}", image_url("images/press/", "3_".$press_arr[press_lang]), $template);

        $press_releases .= $template;
    }
    unset($press_arr);
    unset($template);
}


/////////////////////////////
/// Template aufbauen ///////
/////////////////////////////
$index = mysql_query("SELECT press_container FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
$press_container = stripslashes(mysql_result($index, 0, "press_container"));
$press_container = str_replace("{press_releases}", $press_releases, $press_container);

$index = mysql_query("SELECT press_main_body FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "press_main_body"));
$template = str_replace("{navigation}", $navigation, $template);
if ($config_arr[show_press_sql] == true) {
    $template = str_replace("{press_container}", $press_container, $template);
} else {
    $template = str_replace("{press_container}", "", $template);
}

unset($navigation);
unset($press_releases);

?>