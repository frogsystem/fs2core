<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('lang', 'cat', 'game'));

// Get Config
$index = mysql_query ( "SELECT * FROM `".$global_config_arr['pref']."press_config`", $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc ( $index );


// Local Functions
function get_num_of_levels ( $GAME, $CAT, $LANG ) {
    $num = 0;
    $num += ( isset ( $GAME ) ) ? 1 : 0;
    $num += ( isset ( $CAT ) ) ? 1 : 0;
    $num += ( isset ( $LANG ) ) ? 1 : 0;
    return $num;
}

/////////////////////////////
/// Navigation erzeugen /////
/////////////////////////////
if (!($config_arr[game_navi] == 0 && $config_arr[cat_navi] == 0 && $config_arr[lang_navi] == 0))
{
    unset($navi_arr);
    unset($last_arr);
    
    if ($config_arr[game_navi] != 0)
    { //Spiele anzeigen
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 1 ORDER BY title ASC", $FD->sql()->conn() );
        while ($game_arr = mysql_fetch_assoc($index))
        {
            $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_game = $game_arr[id]", $FD->sql()->conn() );
            if (mysql_result($select, 0, "number") > 0)
            { //Es existieren Presseberichte
                $navi_arr[] = $game_arr[id];
            
                if ($config_arr[cat_navi] != 0)
                { //Kategorien & Spiele anzeigen
                    $index2 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 2 ORDER BY title ASC", $FD->sql()->conn() );
                    while ($cat_arr = mysql_fetch_assoc($index2))
                    {
                        $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_game = $game_arr[id] AND press_cat = $cat_arr[id]", $FD->sql()->conn() );
                        if (mysql_result($select, 0, "number") > 0)
                        { //Es existieren Presseberichte
                            $navi_arr[][] = $cat_arr[id];

                            if ($config_arr[lang_navi] != 0)
                            { //Sprachen & Kategorien & Spiele anzeigen
                                $index3 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 3 ORDER BY title ASC", $FD->sql()->conn() );
                                while ($lang_arr = mysql_fetch_assoc($index3))
                                {
                                    $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_game = $game_arr[id] AND press_cat = $cat_arr[id] AND press_lang = $lang_arr[id]", $FD->sql()->conn() );
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
                    $index1 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 3 ORDER BY title ASC", $FD->sql()->conn() );
                    while ($lang_arr = mysql_fetch_assoc($index1))
                    {
                        $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_game = $game_arr[id] AND press_lang = $lang_arr[id]", $FD->sql()->conn() );
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
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 2 ORDER BY title ASC", $FD->sql()->conn() );
        while ($cat_arr = mysql_fetch_assoc($index))
        {
            $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_cat = $cat_arr[id]", $FD->sql()->conn() );
            if (mysql_result($select, 0, "number") > 0)
            { //Es existieren Presseberichte
                $navi_arr[] = $cat_arr[id];

                if ($config_arr[lang_navi] != 0)
                { //Sprachen & Kategorien anzeigen
                    $index2 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 3 ORDER BY title ASC", $FD->sql()->conn() );
                    while ($lang_arr = mysql_fetch_assoc($index2))
                    {
                        $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_cat = $cat_arr[id] AND press_lang = $lang_arr[id]", $FD->sql()->conn() );
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
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type = 3 ORDER BY title ASC", $FD->sql()->conn() );
        while ($lang_arr = mysql_fetch_assoc($index))
        {
            $select = mysql_query("SELECT COUNT(press_id) AS number FROM ".$global_config_arr[pref]."press WHERE press_lang = $lang_arr[id]", $FD->sql()->conn() );
            if (mysql_result($select, 0, "number") > 0)
            { //Es existieren Presseberichte
                $navi_arr[] = $lang_arr[id];
                $last_arr[] = $lang_arr[id];
            }
        }
    }
    
    $lines = "";



    //Navigation ausgeben
    if ( count ( $navi_arr ) > 0 )
    {
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
                            $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE id = $value3", $FD->sql()->conn() );
                            $entry_arr = mysql_fetch_assoc($index);

                            //Navi URL erstellen
                            switch ($entry_arr[type]) {
                                case 3: $navi_url3 = $navi_url2 + array('lang' => $entry_arr[id]); break;
                                case 2: $navi_url3 = $navi_url2 + array('cat' => $entry_arr[id]); break;
                                default: $navi_url3 = $navi_url2 + array('game' => $entry_arr[id]); break;
                            }

                            /*
                            $entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder.gif";
                            switch ($entry_arr[type]) {
                                case 3:
                                    if ($_GET['lang']==$entry_arr[id])
                                    {$entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif";$open3=true;}
                                    break;
                                case 2:
                                    if ($_GET['cat']==$entry_arr[id])
                                    {$entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif";$open3=true;}
                                    break;
                                default:
                                    if ($_GET['game']==$entry_arr[id])
                                    {$entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif";$open3=true;}
                                    break;
                            }
                            */
                            
                            //Icon URL erstellen, nur Unterordner von geöffneten Ordner anzeigen
                            $entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder.gif";
                            if ( $_GET['game']==$entry_arr[id] || $_GET['cat']==$entry_arr[id] || $_GET['lang']==$entry_arr[id] ) {
                                if ( get_num_of_levels ( $_GET['game'], $_GET['cat'], $_GET['lang'] ) == 3 ) {
                                    $entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif";
                                }
                            }

                            // Get Template
                            $template = new template();
                            $template->setFile("0_press.tpl");
                            $template->load("NAVIGATION_LINE");
                            
                            $template->tag("navi_url", url($navi_url ,$navi_url3));
                            $template->tag("title", $entry_arr['title'] );
                            $template->tag("img_url", image_url ( "images/press/", $entry_arr['type']."_".$entry_arr['id'] ) );
                            $template->tag("icon_url", $entry_arr['icon_url'] );
                            
                            $template = $template->display ();
                            $lines .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$template;
                        }
                    }
                    elseif (!is_array($value2))
                    {
                        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE id = $value2", $FD->sql()->conn() );
                        $entry_arr = mysql_fetch_assoc($index);

                        //Navi URL erstellen
                        switch ($entry_arr[type]) {
                            case 3: $navi_url2 = $navi_url1 + array('lang' => $entry_arr[id]); break;
                            case 2: $navi_url2 = $navi_url1 + array('cat' => $entry_arr[id]); break;
                            default: $navi_url2 = $navi_url1 + array('game' => $entry_arr[id]); break;
                        }

                        /*
                        switch ($entry_arr[type]) {
                            case 3:
                                if ($_GET['lang']==$entry_arr[id])
                                {$entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif";$open2=true;}
                                break;
                            case 2:
                                if ($_GET['cat']==$entry_arr[id])
                                {$entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif";$open2=true;}
                                break;
                            default:
                                if ($_GET['game']==$entry_arr[id])
                                {$entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif";$open2=true;}
                                break;
                        }
                        */
                        
                        //Icon URL erstellen, nur Unterordner von geöffneten Ordner anzeigen
                        $entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder.gif";
                        $open2 = FALSE;
                        if ( $_GET['game']==$entry_arr[id] || $_GET['cat']==$entry_arr[id] || $_GET['lang']==$entry_arr[id] ) {
                            $open2 = TRUE;
                            if ( get_num_of_levels ( $_GET['game'], $_GET['cat'], $_GET['lang'] ) == 2 ) {
                                $entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif";
                            }
                        }
                        
                        // Get Template
                        $template = new template();
                        $template->setFile("0_press.tpl");
                        $template->load("NAVIGATION_LINE");

                        $template->tag("navi_url", url($navi_url ,$navi_url2));
                        $template->tag("title", $entry_arr['title'] );
                        $template->tag("img_url", image_url ( "images/press/", $entry_arr['type']."_".$entry_arr['id'] ) );
                        $template->tag("icon_url", $entry_arr['icon_url'] );

                        $template = $template->display ();
                        $lines .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$template;
                    }
                }
            }
            elseif (!is_array($value))
            {
                $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE id = $value", $FD->sql()->conn() );
                $entry_arr = mysql_fetch_assoc($index);

                //Navi URL erstellen
                $navi_url = "press";
                switch ($entry_arr[type]) {
                    case 3: $navi_url1 = array('lang' => $entry_arr[id]); break;
                    case 2: $navi_url1 = array('cat' => $entry_arr[id]); break;
                    default: $navi_url1 = array('game' => $entry_arr[id]); break;
                }
                
                /*
                switch ($entry_arr[type]) {
                    case 3:
                        if ($_GET['lang']==$entry_arr[id])
                        {$entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif"; $open=true;}
                        break;
                    case 2:
                        if ($_GET['cat']==$entry_arr[id])
                        {$entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif"; $open=true;}
                        break;
                    default:
                        if ($_GET['game']==$entry_arr[id])
                        {$entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif"; $open=true;}
                        break;
                }
                */

                //Icon URL erstellen
                $entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder.gif";
                $open = FALSE;
                if ( $_GET['game'] == $entry_arr[id] || $_GET['cat'] == $entry_arr[id] || $_GET['lang'] == $entry_arr[id] ) {
                    $open = TRUE;
                    if ( get_num_of_levels ( $_GET['game'], $_GET['cat'], $_GET['lang'] ) == 1 ) {
                        $entry_arr[icon_url] = $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/folder_open.gif";
                    }
                }
                
                // Get Template
                $template = new template();
                $template->setFile("0_press.tpl");
                $template->load("NAVIGATION_LINE");

                $template->tag("navi_url", url($navi_url, $navi_url1));
                $template->tag("title", $entry_arr['title'] );
                $template->tag("img_url", image_url ( "images/press/", $entry_arr['type']."_".$entry_arr['id'] ) );
                $template->tag("icon_url", $entry_arr['icon_url'] );

                $template = $template->display ();
                $lines .= $template;
            }
        }
    }

    // Get Template
    $template = new template();
    $template->setFile("0_press.tpl");
    $template->load("NAVIGATION");
    $template->tag("lines", $lines );
    $navigation = $template->display ();
}
else
{
    // Get Template
    $template = new template();
    $template->setFile("0_press.tpl");
    $template->load("NAVIGATION");
    $template->tag("lines", "" );
    $navigation = $template->display ();
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
if ($config_arr['show_press'] == 0)
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
    $index = mysql_query($sql_query, $FD->sql()->conn() );

    unset($press_releases);
    
    while ($press_arr = mysql_fetch_assoc($index))
    {
        // Get Intro Template
        $template = new template();
        $template->setFile("0_press.tpl");
        $template->load("ENTRY_INTRO");
        $template->tag("intro_text", fscode ( $press_arr['press_intro'] ) );
        $press_arr['press_intro_formated'] = $template->display ();
        
        // Get Note Template
        $template = new template();
        $template->setFile("0_press.tpl");
        $template->load("ENTRY_NOTE");
        $template->tag("note_text", fscode ( $press_arr['press_note'] ) );
        $press_arr['press_note_formated'] = $template->display ();

        $index2 = mysql_query("SELECT title FROM ".$global_config_arr[pref]."press_admin WHERE id = '$press_arr[press_game]'", $FD->sql()->conn() );
        $press_arr[press_game_title] = stripslashes(mysql_result($index2, 0, "title"));
        $index2 = mysql_query("SELECT title FROM ".$global_config_arr[pref]."press_admin WHERE id = '$press_arr[press_cat]'", $FD->sql()->conn() );
        $press_arr[press_cat_title] = stripslashes(mysql_result($index2, 0, "title"));
        $index2 = mysql_query("SELECT title FROM ".$global_config_arr[pref]."press_admin WHERE id = '$press_arr[press_lang]'", $FD->sql()->conn() );
        $press_arr[press_lang_title] = stripslashes(mysql_result($index2, 0, "title"));


        // Get Note Template
        $template = new template();
        $template->setFile("0_press.tpl");
        $template->load("ENTRY_BODY");
        
        $template->tag("title", stripslashes ( $press_arr['press_title'] ) );
        $template->tag("url", stripslashes ( $press_arr['press_url'] ) );
        $template->tag("date", date_loc ( $global_config_arr['date'], $press_arr['press_date'] ) );
        $template->tag("text", fscode ( $press_arr['press_text'] ) );
        $template->tag("intro", ( $press_arr['press_intro'] != "" ) ? $press_arr['press_intro_formated'] : "" );
        $template->tag("note", ( $press_arr['press_note'] != "" ) ? $press_arr['press_note_formated'] : "" );
        $template->tag("game_title", $press_arr['press_game_title'] );
        $template->tag("game_img_url", image_url ( "images/press/", "1_" . $press_arr['press_game'] ) );
        $template->tag("cat_title", $press_arr['press_cat_title'] );
        $template->tag("cat_img_url", image_url ( "images/press/", "2_" . $press_arr['press_cat'] ) );
        $template->tag("lang_title", $press_arr['press_lang_title'] );
        $template->tag("lang_img_url", image_url ( "images/press/", "3_" . $press_arr['press_lang'] ) );
        
        $press_releases .= $template->display ();
    }
    unset($press_arr);
    unset($template);
}


/////////////////////////////
/// Template aufbauen ///////
/////////////////////////////

// Get Container Template
$template = new template();
$template->setFile("0_press.tpl");
$template->load("ENTRY_CONTAINER");
$template->tag("press_releases", $press_releases );
$press_container = $template->display ();

// Get Main Template
$template = new template();
$template->setFile("0_press.tpl");
$template->load("BODY");
$template->tag("navigation", $navigation );
$template->tag("press_container", ( ( $config_arr['show_press_sql'] == TRUE ) ? $press_container : "" ) );
$template = $template->display ();
?>
