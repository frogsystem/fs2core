<?php

echo noscript_nohidden ();

//////////////////////
// Update Database  //
//////////////////////

// Update Video
if (
                isset ( $_POST['video_id'] )
                && $_POST['sended'] && $_POST['sended'] == 'edit'
                && $_POST['video_action'] && $_POST['video_action'] == 'edit'
                && $_POST['video_title'] && $_POST['video_title'] != '' &&
                (
                        ( $_POST['video_type'] == 1 && $_POST['video_url'] && $_POST['video_url'] != '' ) ||
                        ( $_POST['video_type'] == 2 && $_POST['video_youtube'] && $_POST['video_youtube'] != '' ) ||
                        ( $_POST['video_type'] == 3 && $_POST['video_myvideo'] && $_POST['video_myvideo'] != '' ) ||
                        ( $_POST['video_type'] == -1 && $_POST['video_other'] && $_POST['video_other'] != "" )
                )
        )
{
    $_POST['video_title'] = savesql ( $_POST['video_title'] );
    $_POST['video_desc'] = savesql ( $_POST['video_desc'] );
    settype ( $_POST['video_type'], 'integer' );
    settype ( $_POST['dl_id'], 'integer' );

    settype ( $_POST['video_h'], 'integer' );
    settype ( $_POST['video_m'], 'integer' );
    settype ( $_POST['video_s'], 'integer' );

    $_POST['video_lenght'] = $_POST['video_h']*60*60 + $_POST['video_m']*60 +$_POST['video_s'];

        switch ( $_POST['video_type'] ) {
            case 3:
            $_POST['video_x'] = savesql ( $_POST['video_myvideo'] );
                break;
            case 2:
            $_POST['video_x'] = savesql ( $_POST['video_youtube'] );
                break;
            case -1:
            $_POST['video_x'] = savesql ( $_POST['video_other'] );
                break;
                default:
            $_POST['video_x'] = savesql ( $_POST['video_url'] );
                break;
        }

    mysql_query ( '
                                        UPDATE
                                                '.$global_config_arr['pref']."player
                                        SET
                                            video_type = '".$_POST['video_type']."',
                                            video_x = '".$_POST['video_x']."',
                                            video_title = '".$_POST['video_title']."',
                                            video_lenght = '".$_POST['video_lenght']."',
                                            video_desc = '".$_POST['video_desc']."',
                                            dl_id = '".$_POST['dl_id']."'
                         WHERE
                                                 video_id = '".$_POST['video_id']."'
        ", $FD->sql()->conn() );

    $message = 'Video bearbeitet';

    // Display Message
    systext ( $message, $admin_phrases['common']['info'] );

    // Unset Vars
    unset ( $_POST );
}

// Delete Video
elseif (
                $_POST['video_id']
                && $_POST['sended'] && $_POST['sended'] == 'delete'
                && $_POST['video_action'] && $_POST['video_action'] == 'delete'
        )
{
        if ( $_POST['video_delete'] == 1 ) {

                // Security-Functions
                settype ( $_POST['video_id'], 'integer' );

                // MySQL-Delete-Query
            mysql_query ('
                                                DELETE FROM
                                                        '.$global_config_arr['pref']."player
                                 WHERE
                                                         video_id = '".$_POST['video_id']."'
                                                LIMIT
                                                    1
                ", $FD->sql()->conn() );

                $message = 'Video wurde gel&ouml;scht';

        } else {
                $message = 'Video wurde nicht gel&ouml;scht';
        }

    // Display Message
    systext ( $message, $admin_phrases['common']['info'] );

    // Unset Vars
    unset ( $_POST );
}

///////////////////////////
// Display Action-Pages  //
///////////////////////////

if ( $_POST['video_id'] && $_POST['video_action'] )
{
        // Edit Video
        if ( $_POST['video_action'] == 'edit' )
        {
            settype ( $_POST['video_id'], 'integer');

                // Display Error Messages
                if ( isset ( $_POST['sended'] ) ) {
                        systext ( $admin_phrases['common']['note_notfilled'], $admin_phrases['common']['error'], TRUE );

                // Load Data drom DB into Post
                } else {
                    $index = mysql_query ( '
                                                                        SELECT *
                                                                        FROM '.$global_config_arr['pref']."player
                                                                        WHERE video_id = '".$_POST['video_id']."'
                        ", $FD->sql()->conn() );
                    $video_arr = mysql_fetch_assoc ( $index );
                        putintopost ( $video_arr );
                        switch ( $_POST['video_type'] ) {
                            case 3:
                            $_POST['video_myvideo'] = $_POST['video_x'];
                                break;
                            case 2:
                            $_POST['video_youtube'] = $_POST['video_x'];
                                break;
                            case -1:
                            $_POST['video_other'] = $_POST['video_x'];
                                break;
                                default:
                            $_POST['video_url'] = $_POST['video_x'];
                                break;
                        }
                        if ( $_POST['video_lenght'] > 0 ) {
                $_POST['video_h'] = floor ( $_POST['video_lenght'] / (60*60) );
                $_POST['video_lenght'] = $_POST['video_lenght'] % (60*60);
                $_POST['video_m'] = floor ( $_POST['video_lenght'] / (60) );
                $_POST['video_s'] = $_POST['video_lenght'] % (60);
                        } else {
                $_POST['video_h'] = 0;
                $_POST['video_m'] = 0;
                $_POST['video_s'] = 0;
                        }
            unset ( $_POST['video_x'] );
            unset ( $_POST['video_lenght'] );
                }

                $_POST['video_title'] = killhtml ( $_POST['video_title'] );
                $_POST['video_desc'] = killhtml ( $_POST['video_desc'] );
                settype ( $_POST['video_type'], 'integer' );
                settype ( $_POST['dl_id'], 'integer' );

                $_POST['video_url'] = killhtml ( $_POST['video_url'] );
                $_POST['video_youtube'] = killhtml ( $_POST['video_youtube'] );
                $_POST['video_myvideo'] = killhtml ( $_POST['video_myvideo'] );
                $_POST['video_other'] = killhtml ( $_POST['video_other'] );

            $_POST['video_h'] = add_zero ( $_POST['video_h'] );
            $_POST['video_m'] = add_zero ( $_POST['video_m'] );
            $_POST['video_s'] = add_zero ( $_POST['video_s'] );

                $display_arr['tr_1'] = 'hidden';
                $display_arr['tr_2'] = 'hidden';
                $display_arr['tr_3'] = 'hidden';
                $display_arr['tr_-1'] = 'hidden';

                switch ( $_POST['video_type'] ) {
                    case 3:
                    $display_arr['tr_3'] = 'default';
                        break;
                    case 2:
                    $display_arr['tr_2'] = 'default';
                        break;
                    case -1:
                    $display_arr['tr_-1'] = 'default';
                        break;
                        default:
                    $display_arr['tr_1'] = 'default';
                        break;
                }

            echo'
                    <form action="" method="post">
                                                <input type="hidden" name="go" value="player_edit">
                                            <input type="hidden" name="video_action" value="edit">
                                                <input type="hidden" name="sended" value="edit">
                                                <input type="hidden" name="video_id" value="'.$_POST['video_id'].'">
                                                <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="2">Video hinzuf&uuml;gen</td></tr>
                            <tr>
                                <td class="config">
                                    Titel:<br>
                                    <span class="small">Der Titel des Videos</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="45" maxlength="100" name="video_title" value="'.$_POST['video_title'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Quelle:<br>
                                    <span class="small">Quelle aus der das Video stammt.</span>
                                </td>
                                <td class="config" valign="top">
                                    <select name="video_type" size="1"
                                         onChange="show_one(\'tr_1|tr_2|tr_3|tr_-1\', \'1|2|3|-1\', this)"
                                                                        >
                                            <option value="1" '.getselected( $_POST['video_type'], 1 ).'>eigenes Video</option>
                                            <option value="2" '.getselected( $_POST['video_type'], 2 ).'>YouTube</option>
                                            <option value="3" '.getselected( $_POST['video_type'], 3 ).'>MyVideo</option>
                                            <option value="-1" '.getselected( $_POST['video_type'], -1 ).'>andere Quelle</option>
                                                                        </select>
                                </td>
                            </tr>
                            <tr class="'.$display_arr['tr_1'].'" id="tr_1">
                                <td class="config">
                                    URL:<br>
                                    <span class="small">URL zur Video-Datei (FLV-Format).</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="45" maxlength="255" name="video_url" value="'.$_POST['video_url'].'">
                                </td>
                            </tr>
                            <tr class="'.$display_arr['tr_2'].'" id="tr_2">
                                <td class="config">
                                    YouTube-ID:<br>
                                    <span class="small">http://youtube.com/watch?v=<b>YouTube-ID</b></span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="25" maxlength="20" name="video_youtube" value="'.$_POST['video_youtube'].'">
                                </td>
                            </tr>
                            <tr class="'.$display_arr['tr_3'].'" id="tr_3">
                                <td class="config">
                                    MyVideo-ID:<br>
                                    <span class="small">http://myvideo.de/watch/<b>MyVideo-ID</b>/</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="25" maxlength="20" name="video_myvideo" value="'.$_POST['video_myvideo'].'">
                                </td>
                            </tr>
                            <tr class="'.$display_arr['tr_-1'].'" id="tr_-1">
                                <td class="config">
                                    HTML-Code:<br>
                                    <span class="small">HTML-Code um das Video einzubinden.<br><br>
                                    <span class="small">Damit das Video in unterschiedlichen Gr&ouml;&szlig;en dargstellt werden kann, bitte alle Breitenangaben durch <b>{width}</b> und alle H&ouml;henangaben durch <b>{height}</b> ersetzen.<br><br>
                                    Angaben innerhalb von »style« m&uuml;ssen durch <b>{width_css}</b> bzw. <b>{height_css}</b> ersetzt werden.</span>

                                </td>
                                <td class="config" valign="top">
                                    <textarea class="text" name="video_other" rows="10" cols="50" wrap="virtual">'.$_POST['video_other'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    L&auml;nge: <span class="small">'.$admin_phrases['common']['optional'].'</span><br>
                                    <span class="small">Die Laufzeit des Videos.</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text center" size="2" maxlength="2" name="video_h" value="'.$_POST['video_h'].'"> :
                                    <input class="text center" size="2" maxlength="2" name="video_m" value="'.$_POST['video_m'].'"> :
                                    <input class="text center" size="2" maxlength="2" name="video_s" value="'.$_POST['video_s'].'">&nbsp;&nbsp;&nbsp;Stunden : Minuten : Sekunden
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Beschreibung: <span class="small">'.$admin_phrases['common']['optional'].'</span><br>
                                    <span class="small">Text, der das Video beschreibt.</span>
                                </td>
                                <td class="config" valign="top">
                                    <textarea class="text" name="video_desc" rows="5" cols="50" wrap="virtual">'.$_POST['video_desc'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Download:<br>
                                    <span class="small">Verkn&uuml;pft das Video mit einem Download.</span>
                                </td>
                                <td class="config">
                                    <select name="dl_id">
                                        <option value="0" '.getselected(0, $_POST['dl_id']).'>keine Verkn&uuml;pfung</option>
                ';
                // DL auflisten
                $index = mysql_query ( '
                                                                SELECT D.dl_id, D.dl_name, C.cat_name
                                                                FROM '.$global_config_arr['pref'].'dl D, '.$global_config_arr['pref'].'dl_cat AS C
                                                                WHERE D.cat_id = C.cat_id
                                                                ORDER BY D.dl_name ASC
                ', $FD->sql()->conn() );
                while ( $dl_arr = mysql_fetch_assoc ( $index ) )
                {
                        settype ( $dl_arr['dl_id'], 'integer' );
                        echo '<option value="'.$dl_arr['dl_id'].'" '.getselected($dl_arr['dl_id'], $_POST['dl_id']).'>'.$dl_arr['dl_name'].' ('.$dl_arr['cat_name'].')</option>';
                }
                echo'
                                    </select><br>
                                    <span class="small"><b>Hinweis:</b> Funktion noch nicht implementiert!</span>
                                </td>
                            </tr>
                                                        <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases['common']['arrow'].' '.$admin_phrases['common']['save_long'].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
            ';
        }

        // Delete Video
        elseif ( $_POST['video_action'] == 'delete' )
        {
                $index = mysql_query ( '
                                                                SELECT *
                                                                FROM '.$global_config_arr['pref']."player
                                                                WHERE video_id = '".$_POST['video_id']."'
                                                                LIMIT 0,1
                ", $FD->sql()->conn() );
                $video_arr = mysql_fetch_assoc ( $index );

                        // Create Link and Source
                        switch ( $video_arr['video_type'] ) {
                            case 3:
                            $video_arr['video_source'] = 'MyVideo';
                            $video_arr['video_link'] = '<br><span class="small"><a href="http://myvideo.de/watch/'.$video_arr['video_x'].'/" target="_blank">http://myvideo.de/watch/'.$video_arr['video_x'].'/</a></span>';
                                break;
                            case 2:
                            $video_arr['video_source'] = 'YouTube';
                            $video_arr['video_link'] = '<br><span class="small"><a href="http://youtube.com/watch?v='.$video_arr['video_x'].'" target="_blank">http://youtube.com/watch?v='.$video_arr['video_x'].'</a></span>';
                                break;
                            case -1:
                            $video_arr['video_source'] = 'externe Quelle';
                            $video_arr['video_link'] = '';
                                break;
                                default:
                            $video_arr['video_source'] = 'eigenes Video';
                            $video_arr['video_link'] = '<br><span class="small"><a href="'.$video_arr['video_x'].'" target="_blank">'.$video_arr['video_x'].'</a></span>';
                                break;
                        }

                echo '
                                        <form action="" method="post">
                                                <input type="hidden" name="go" value="player_edit">
                                            <input type="hidden" name="video_action" value="delete">
                                                <input type="hidden" name="sended" value="delete">
                                                <input type="hidden" name="video_id" value="'.$_POST['video_id'].'">
                                                <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="2">Video l&ouml;schen</td></tr>
                                                        <tr>
                                <td class="configthin" colspan="2">
                                    <b>'.$video_arr['video_title'].'</b> ('.$video_arr['video_source'].')
                                                                        '.$video_arr['video_link'].'
                                </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                                                        <tr>
                                                                <td class="configthin">
                                                                    Soll das Video wirklich gel&ouml;scht werden?
                                                                </td>
                                                                <td class="config right top" style="padding: 0px;">
                                                                '.get_yesno_table ( "video_delete" ).'
                                                                </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                                                        <tr>
                                                                <td class="buttontd" colspan="2">
                                                                        <button class="button_new" type="submit">
                                                                                '.$admin_phrases['common']['arrow'].' '.$admin_phrases['common']['do_button_long'].'
                                                                        </button>
                                                                </td>
                                                        </tr>
                                                </table>
                                        </form>
                ';
        }
}

//////////////////////////
// Display Default-Page //
//////////////////////////

else
{
        // Video Listing
        echo '
                                        <form action="" method="post">
                                                <input type="hidden" name="go" value="player_edit">
                                                <table class="configtable" cellpadding="4" cellspacing="0">
                                                    <tr><td class="line" colspan="4">Video ausw&auml;hlen</td></tr>
        ';

        // Get Videos from DB
        $index = mysql_query ( 'SELECT * FROM '.$global_config_arr['pref'].'player ORDER BY video_title', $FD->sql()->conn() );

        if ( mysql_num_rows ( $index ) > 0 ) {
                // display table head
                echo '
                                                        <tr>
                                <td class="config" width="10">ID</td>
                                                                <td class="config">Titel</td>
                                                            <td class="config">Quelle</td>
                                                            <td class="config" width="20"></td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                ';

                // Display each Video
                while ( $video_arr = mysql_fetch_assoc ( $index ) ) {
                        // Create Link and Source
                        switch ( $video_arr['video_type'] ) {
                            case 3:
                            $video_arr['video_source'] = 'MyVideo';
                            $video_arr['video_link'] = '<br><span class="small"><a href="http://myvideo.de/watch/'.$video_arr['video_x'].'/" target="_blank">http://myvideo.de/watch/'.$video_arr['video_x'].'/</a></span>';
                                break;
                            case 2:
                            $video_arr['video_source'] = 'YouTube';
                            $video_arr['video_link'] = '<br><span class="small"><a href="http://youtube.com/watch?v='.$video_arr['video_x'].'" target="_blank">http://youtube.com/watch?v='.$video_arr['video_x'].'</a></span>';
                                break;
                            case -1:
                            $video_arr['video_source'] = 'externe Quelle';
                            $video_arr['video_link'] = '';
                                break;
                                default:
                            $video_arr['video_source'] = 'eigenes Video';
                            $video_arr['video_link'] = '<br><span class="small"><a href="'.$video_arr['video_x'].'" target="_blank">'.$video_arr['video_x'].'</a></span>';
                                break;
                        }

                        echo '
                                                        <tr class="pointer" id="tr_'.$video_arr['video_id'].'"
                                                                onmouseover="'.color_list_entry ( "input_".$video_arr['video_id'], "#EEEEEE", "#64DC6A", "this" ).'"
                                                                onmouseout="'.color_list_entry ( "input_".$video_arr['video_id'], "transparent", "#49c24f", "this" ).'"
                                onclick="'.color_click_entry ( "input_".$video_arr['video_id'], "#EEEEEE", "#64DC6A", "this", TRUE ).'"
                                                        >
                                                                <td class="configthin">
                                    <b>#'.$video_arr['video_id'].'</b>
                                                                </td>
                                                                <td class="configthin middle">
                                    <b>'.$video_arr['video_title'].'</b>'.$video_arr['video_link'].'
                                                                </td>
                                                                <td class="configthin middle">
                                    '.$video_arr['video_source'].'
                                                                </td>
                                                                <td class="configthin middle" style="text-align: center; vertical-align: middle;">
                                    <input class="pointer" type="radio" name="video_id" id="input_'.$video_arr['video_id'].'" value="'.$video_arr['video_id'].'"
                                                                                onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$video_arr['video_id'], TRUE ).'"
                                                                        >
                                                                </td>
                                                        </tr>
                        ';
                }

                // End of Form & Table incl. Submit-Button
                 echo '
                                                        <tr><td class="space"></td></tr>
                                                        <tr>
                                                                <td style="text-align:right;" colspan="3">
                                                                        <select name="video_action" size="1">
                                                                                <option value="edit">'.$admin_phrases['common']['selection_edit'].'</option>
                                                                                <option value="delete">'.$admin_phrases['common']['selection_del'].'</option>
                                                                        </select>
                                                                </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                                                        <tr>
                                                                <td class="buttontd" colspan="4">
                                                                        <button class="button_new" type="submit">
                                                                                '.$admin_phrases['common']['arrow'].' '.$admin_phrases['common']['do_button_long'].'
                                                                        </button>
                                                                </td>
                                                        </tr>
                ';

        // No Videos
        } else {
                echo '
                            <tr><td class="space"></td></tr>
                                                        <tr>
                                                                <td class="config center" colspan="4">Keine Videos gefunden!</td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                ';
        }
                echo '
                                                </table>
                                        </form>
                ';
}
?>
