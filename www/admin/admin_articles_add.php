<?php
// Load existing "article_url"s in Array
$url_arr = get_article_urls ();

/////////////////////
//// Add Article ////
/////////////////////

if (
                isset ( $_POST['sended'] ) &&
                isset ( $_POST['article_cat_id'] ) &&
                $_POST['article_title'] && $_POST['article_title'] != "" &&
                (empty($url_arr) || !in_array ( savesql ( $_POST['article_url'] ), $url_arr )) &&

                ( ( $_POST['d'] && $_POST['d'] > 0 && $_POST['d'] <= 31 ) || ( $_POST['d'] == "" && $_POST['m'] == "" && $_POST['y'] == "" ) ) &&
                ( ( $_POST['m'] && $_POST['m'] > 0 && $_POST['m'] <= 12 ) || ( $_POST['d'] == "" && $_POST['m'] == "" && $_POST['y'] == "" ) ) &&
                ( ( $_POST['y'] && $_POST['y'] > 0 ) || ( $_POST['d'] == "" && $_POST['m'] == "" && $_POST['y'] == "" ) )
        )
{
        // No User
        if ( !isset ( $_POST['article_user'] ) ) {
            $_POST['article_user'] = 0;
        }

        // Security Functions
        $_POST['article_url'] = savesql ( trim ( $_POST['article_url'] ) );
    $_POST['article_title'] = savesql ( $_POST['article_title'] );
    $_POST['article_text'] = savesql ( $_POST['article_text'] );

    settype ( $_POST['article_cat_id'], "integer" );
    settype ( $_POST['article_html'], "integer" );
    settype ( $_POST['article_user'], "integer" );
    settype ( $_POST['article_fscode'], "integer" );
    settype ( $_POST['article_para'], "integer" );

    // Create Date
    if ( $_POST['d'] != "" && $_POST['m'] != "" && $_POST['y'] != "" ) {
            $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
            $articledate = mktime ( 0, 0, 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );
    } else {
            $articledate = 0;
    }

    // MySQL-Insert-Query
    mysql_query ("
                                        INSERT INTO
                                                ".$global_config_arr['pref']."articles
                                                (article_url, article_title, article_date, article_user, article_text, article_html, article_fscode, article_para, article_cat_id, article_search_update)
                                        VALUES (
                                                '".$_POST['article_url']."',
                                                '".$_POST['article_title']."',
                                                '".$articledate."',
                                                '".$_POST['article_user']."',
                                                '".$_POST['article_text']."',
                                                '".$_POST['article_html']."',
                                                '".$_POST['article_fscode']."',
                                                '".$_POST['article_para']."',
                                                '".$_POST['article_cat_id']."',
                                                '".time()."'
                                        )
    ", $db );
    
    // Update Search Index (or not)
    if ( $global_config_arr['search_index_update'] === 1 ) {
        // Include searchfunctions.php
        require ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
        update_search_index ( "articles" );
    }
    
    mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET artikel = artikel + 1", $db );
    systext( $admin_phrases[articles][articles_added], $admin_phrases[common][info]);
}

//////////////////////////////
//// Display Articel Form ////
//////////////////////////////

else
{
        // Display Error Messages
        if ( isset ( $_POST['sended'] ) ) {
                if ( in_array ( savesql ( $_POST['article_url'] ), $url_arr ) ) {
                  systext ( $admin_phrases[articles][existing_url], $admin_phrases[common][error], TRUE );
                } else {
                  systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
                }
        } else {
                $_POST['article_html'] = 1;
                $_POST['article_fscode'] = 1;
                $_POST['article_para'] = 1;
        }

    // Load Article Config
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_config", $db );
    $config_arr = mysql_fetch_assoc ( $index );

        // Create HTML, FSCode & Para-Handling Vars
    $config_arr[html_code_bool] = ($config_arr[html_code] == 2 || $config_arr[html_code] == 4);
    $config_arr[fs_code_bool] = ($config_arr[fs_code] == 2 || $config_arr[fs_code] == 4);
    $config_arr[para_handling_bool] = ($config_arr[para_handling] == 2 || $config_arr[para_handling] == 4);
    
    $config_arr[html_code_text] = ( $config_arr[html_code_bool] ) ? $admin_phrases[common][on] : $admin_phrases[common][off];
    $config_arr[fs_code_text] = ( $config_arr[fs_code_bool] ) ? $admin_phrases[common][on] : $admin_phrases[common][off];
    $config_arr[para_handling_text] = ( $config_arr[para_handling_bool] ) ? $admin_phrases[common][on] : $admin_phrases[common][off];

        // Get User ID
        if ( !isset ( $_POST['article_user'] ) ) {
                $_POST['article_user'] = $_SESSION['user_id'];
    }

        // Security-Functions
    $_POST['article_url'] = killhtml ( $_POST['article_url'] );
    $_POST['article_title'] = killhtml ( $_POST['article_title'] );
        $_POST['article_text'] = killhtml ( $_POST['article_text'] );
        settype ( $_POST['article_user'], "integer" );
    settype ( $_POST['article_html'], "integer" );
        settype ( $_POST['article_fscode'], "integer" );
    settype ( $_POST['article_para'], "integer" );
        settype ( $_POST['article_cat_id'], "integer" );

    // Get User
        if ( $_POST['article_user'] != 0 ) {
                $index = mysql_query ( "SELECT user_name, user_id FROM ".$global_config_arr['pref']."user WHERE user_id = '".$_POST['article_user']."'", $db );
            $_POST['article_user_name'] = killhtml ( mysql_result ( $index, 0, "user_name" ) );
        } else {
            $_POST['article_user_name'] = "";
        }


        // Create Date-Arrays
    if ( !isset ( $_POST['sended'] ) )
    {
            $_POST['d'] = date ( "d" );
            $_POST['m'] = date ( "m" );
            $_POST['y'] = date ( "Y" );
        }
        $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'], 0, 0, 0, TRUE );
        $nowbutton_array = array( "d", "m", "y" );

    // Display Page
    echo'
                                        <form action="" method="post">
                                                <input type="hidden" name="go" value="articles_add">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="2">'.$admin_phrases[articles][articles_info_title].'</td></tr>
                            <tr>
                                <td class="config" width="250">
                                    '.$admin_phrases[articles][articles_url].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[articles][articles_url_desc].'</span>
                                </td>
                                <td class="config" width="350">
                                    ?go = <input class="text" size="45" maxlength="100" name="article_url" value="'.$_POST['article_url'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_cat].':<br>
                                    <span class="small">'.$admin_phrases[articles][articles_cat_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="article_cat_id">
        ';
                                                                            // Kategorien auflisten
                                                                            $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_cat", $db );
                                                                            while ( $cat_arr = mysql_fetch_assoc ( $index ) )
                                                                            {
                                                                                        settype ( $cat_arr['cat_id'], "integer" );
                                                                                        echo '<option value="'.$cat_arr['cat_id'].'" '.getselected($cat_arr['cat_id'], $_POST['article_cat_id']).'>'.$cat_arr['cat_name'].'</option>';
                                                                            }
        echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_date].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[articles][articles_date_desc].'</span>
                                </td>
                                <td class="config">
                                                                        <span class="small">
                                                                                <input class="text" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                            <input class="text" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                            <input class="text" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'">&nbsp;
                                                                        </span>
                                                                        '.js_nowbutton ( $nowbutton_array, $admin_phrases[common][today] ).'
                                    <input onClick=\'document.getElementById("d").value="";
                                                     document.getElementById("m").value="";
                                                     document.getElementById("y").value="";\' class="button" type="button" value="'.$admin_phrases[common][delete_button].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_poster].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[articles][articles_poster_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="30" maxlength="100" readonly="readonly" id="username" name="article_user_name" value="'.$_POST['article_user_name'].'">
                                    <input type="hidden" id="userid" name="article_user" value="'.$_POST['article_user'].'">
                                    <input class="button" type="button" onClick=\''.openpopup ( "admin_finduser.php", 400, 400 ).'\' value="'.$admin_phrases[common][change_button].'">
                                    <input onClick=\'document.getElementById("username").value="";
                                                     document.getElementById("userid").value="0";\' class="button" type="button" value="'.$admin_phrases[common][delete_button].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                                                        <tr><td class="line" colspan="2">'.$admin_phrases[articles][articles_new_title].'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[articles][articles_title].':
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <input class="text" size="75" maxlength="255" name="article_title" id="article_title" value="'.$_POST['article_title'].'"><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                                                                        <td class="config">
                                                                                                '.$admin_phrases[articles][articles_text].':
                                                                                        </td>
                                                                                        <td class="config" style="text-align:right;">
        ';

        if ( $config_arr[html_code_bool] ) {
            echo '<input class="pointer middle" type="checkbox" name="article_html" id="article_html" value="1" '.getchecked ( 1, $_POST['article_html'] ).'>
                <span class="small middle">'.$admin_phrases[articles][articles_use_html].'</span>&nbsp;&nbsp;';
        } else {
            echo '<input class="middle" type="checkbox" name="article_html" id="article_html" value="0" disabled="disabled">
                <span class="small middle">'.$admin_phrases[common][html].' '.$config_arr[html_code_text].'</span>&nbsp;&nbsp;';
        }
        if ( $config_arr[fs_code_bool] ) {
            echo '<input class="pointer middle" type="checkbox" name="article_fscode" id="article_fscode" value="1" '.getchecked ( 1, $_POST['article_fscode'] ).'>
                <span class="small middle">'.$admin_phrases[articles][articles_use_fscode].'</span>&nbsp;&nbsp;';
        } else {
            echo '<input class="middle" type="checkbox" name="article_fscode" id="article_fscode" value="0" disabled="disabled">
                <span class="small middle">'.$admin_phrases[common][fscode].' '.$config_arr[fs_code_text].'</span>&nbsp;&nbsp;';
        }
        if ( $config_arr[para_handling_bool] ) {
            echo '<input class="pointer middle" type="checkbox" name="article_para" id="article_para" value="1" '.getchecked ( 1, $_POST['article_para'] ).'>
                <span class="small middle">'.$admin_phrases[articles][articles_use_para].'</span>';
        } else {
            echo '<input class="middle" type="checkbox" name="article_para" id="article_para" value="0" disabled="disabled">
                <span class="small middle">'.$admin_phrases[common][para].' '.$config_arr[para_handling_text].'</span>';
        }

        echo '
                                                                                        </td>
                                                                                </tr>
                                                                        </table>

                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.create_editor ( "article_text", $_POST['article_text'], "100%", "500px", "", FALSE).'
                                </td>
                            </tr>
                            <tr>
                                                                <td class="config" colspan="2">
                                    <input class="button" type="button" onClick=\''.open_fullscreenpopup ( "admin_articles_prev.php" ).'\' value="'.$admin_phrases[common][preview_button].'">
                                                                </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[articles][articles_add_button].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>

<?php

/////////////////////////////////////
//// Artikel in die DB schreiben ////
/////////////////////////////////////

if ($_POST[url] && $_POST[title] && $_POST[text] && $_POST[cat_id])
{
    if ($_POST[tag] && $_POST[monat] && $_POST[jahr])  // Datum überprüfen
    {
       $date = mktime(0, 0, 0, $_POST[monat], $_POST[tag], $_POST[jahr]);
    }
    else
    {
        $date = 0;
    }

    $_POST[url] = savesql($_POST[url]);
    $index = mysql_query("SELECT artikel_url FROM ".$global_config_arr[pref]."artikel WHERE artikel_url = '$_POST[url]'");
    if (mysql_num_rows($index) == 0)
    {
        $_POST[title] = savesql($_POST[title]);
        $_POST[text] = savesql($_POST[text]);
        settype($_POST[cat_id], 'integer');
        settype($_POST[posterid], 'integer');
        $_POST[search] = isset($_POST[search]) ? 1 : 0;
        $_POST[fscode] = isset($_POST[fscode]) ? 1 : 0;

        mysql_query("INSERT INTO ".$global_config_arr[pref]."artikel
                     VALUES (NULL,
                             '$_POST[url]',
                             '$_POST[title]',
                             '$date',
                             '$_POST[posterid]',
                             '$_POST[text]',
                             '$_POST[search]',
                             '$_POST[fscode]',
                             '$_POST[cat_id]');", $db);
        mysql_query("UPDATE ".$global_config_arr[pref]."counter SET artikel = artikel + 1", $db);
        systext("Artikel wurde gespeichert");
    }
    else
    {
        systext("Diese Artikel URL exitiert bereits");
    }
}
?>
