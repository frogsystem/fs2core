<?php
/////////////////////////////
//// DB: Update Snippets ////
/////////////////////////////

if (
        isset ( $_POST['sended'] ) && $_POST['sended'] == 'edit'
        && isset ( $_POST['snippet_action'] ) && $_POST['snippet_action'] == 'edit'
        && isset ( $_POST['snippet_id'] )
    )
{
    // Security-Functions
    $_POST['snippet_text'] = savesql ( $_POST['snippet_text'] );

    settype ( $_POST['snippet_id'], 'integer' );
    settype ( $_POST['snippet_active'], 'integer' );

    // MySQL-Queries
    mysql_query ( '
                    UPDATE `'.$global_config_arr['pref']."snippets`
                    SET
                        `snippet_text` = '".$_POST['snippet_text']."',
                        `snippet_active` = '".$_POST['snippet_active']."'
                    WHERE `snippet_id` = '".$_POST['snippet_id']."'
    ", $FD->sql()->conn() );

    // Display Message
    systext ( $TEXT['admin']->get('changes_saved'),
        $TEXT['admin']->get('info'), FALSE, $TEXT['admin']->get('icon_save_ok') );

    // Unset Vars
    unset ( $_POST );
}

/////////////////////////////
//// DB: Delete Snippets ////
/////////////////////////////
elseif (
        $_SESSION['snippets_delete']
        && isset ( $_POST['sended'] ) && $_POST['sended'] == 'delete'
        && isset ( $_POST['snippet_action'] ) && $_POST['snippet_action'] == 'delete'
        && isset ( $_POST['snippet_id'] )
        && isset ( $_POST['snippet_delete'] )
    )
{
    if ( $_POST['snippet_delete'] == 1 ) {
    
        // Security-Functions
        $_POST['snippet_id'] = array_map ( 'intval', explode ( ',', $_POST['snippet_id'] ) );

        // MySQL-Delete-Query
        mysql_query ('
                        DELETE
                        FROM `'.$global_config_arr['pref'].'snippets`
                        WHERE `snippet_id` IN ('.implode ( ',', $_POST['snippet_id'] ).')
        ', $FD->sql()->conn() );

        systext ( $TEXT['admin']->get('snippets_deleted'),
            $TEXT['admin']->get('info'), FALSE, $TEXT['admin']->get('icon_trash_ok') );

    } else {
        systext ( $TEXT['admin']->get('snippets_not_deleted'),
            $TEXT['admin']->get('info'), FALSE, $TEXT['admin']->get('icon_trash_error') );
    }

    // Unset Vars
    unset ( $_POST );
}

///////////////////////
//// Display Forms ////
///////////////////////
if (  isset ( $_POST['snippet_id'] ) && is_array ( $_POST['snippet_id'] ) && $_POST['snippet_action'] )
{
    // Security Function
    $_POST['snippet_id'] = array_map ( 'intval', $_POST['snippet_id'] );
    
    //////////////////////////
    //// Edit Applet Form ////
    //////////////////////////
    if ( $_POST['snippet_action'] == 'edit' && count ( $_POST['snippet_id'] ) == 1 )
    {
        $_POST['snippet_id'] = $_POST['snippet_id'][0];

        // Display Error Messages
        if ( $_POST['sended'] == 'edit' ) {

            // Shouldn't happen

        // Get Data from DB
        } else {
            $index = mysql_query ( '
                                    SELECT *
                                    FROM `'.$global_config_arr['pref']."snippets`
                                    WHERE `snippet_id` = '".$_POST['snippet_id']."'
                                    LIMIT 0,1
            ", $FD->sql()->conn() );
            $data_arr = mysql_fetch_assoc ( $index );
            putintopost ( $data_arr );
        }

        // Security Functions
        $_POST['snippet_tag'] = killhtml ( $_POST['snippet_tag'] );
        $_POST['snippet_text'] = killhtml ( $_POST['snippet_text'] );

        settype ( $_POST['snippet_id'], 'integer' );
        settype ( $_POST['snippet_active'], 'integer' );

        // Display Form
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="snippets_edit">
                        <input type="hidden" name="snippet_action" value="edit">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" name="snippet_id" value="'.$_POST['snippet_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT['admin']->get('snippet_edit_title').'</td></tr>
                            <tr>
                                <td class="config" width="50%">
                                    '.$TEXT['admin']->get('snippet_tag_title').':<br>
                                    <span class="small">'.$TEXT['admin']->get('snippet_tag_desc').'</span>
                                </td>
                                <td class="config" width="50%">
                                    '.$_POST['snippet_tag'].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT['admin']->get('snippet_active_title').':<br>
                                    <span class="small">'.$TEXT['admin']->get('snippet_active_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="snippet_active" value="1" '.getchecked ( 1, $_POST['snippet_active'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT['admin']->get('snippet_text_title').':<br>
                                    <span class="small">'.$TEXT['admin']->get('snippet_text_desc').'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <textarea style="width:100%;" name="snippet_text" rows="20" wrap="virtual">'.$_POST['snippet_text'].'</textarea>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$TEXT['admin']->get('button_arrow').' '.$TEXT['admin']->get('save_changes_button').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }

    //////////////////////////////////////////////////////////////
    //// Show to much selected Error & Go back to Select Form ////
    //////////////////////////////////////////////////////////////
    elseif ( $_POST['snippet_action'] == 'edit' && count ( $_POST['snippet_id'] ) > 1 ) {
        // Display Error
        systext ( $TEXT['admin']->get('select_only_one_to_edit'),
            $TEXT['admin']->get('error'), TRUE, $TEXT['admin']->get('icon_error') );
        unset ( $_POST['snippet_id'] );
    }

    ////////////////////////////
    //// Delete Applet Form ////
    ////////////////////////////
    elseif ( $_SESSION['snippets_delete'] && $_POST['snippet_action'] == 'delete' && count ( $_POST['snippet_id'] ) >= 1 )
    {
        // Display Head of Table
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="snippets_edit">
                        <input type="hidden" name="snippet_action" value="delete">
                        <input type="hidden" name="sended" value="delete">
                        <input type="hidden" name="snippet_id" value="'.implode ( ',', $_POST['snippet_id'] ).'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT['admin']->get('snippets_delete_title').'</td></tr>
                            <tr>
                                <td class="configthin">
                                    '.$TEXT['admin']->get('snippets_delete_question').'
                                    <br><br>
        ';

        // get applets from db
        $index = mysql_query ( '
                                SELECT *
                                FROM `'.$global_config_arr['pref'].'snippets`
                                WHERE `snippet_id` IN ('.implode ( ',', $_POST['snippet_id'] ).')
                                ORDER BY `snippet_tag`
        ', $FD->sql()->conn() );
        // applets found
        if ( mysql_num_rows ( $index ) > 0 ) {
        
            // display applets
            while ( $data_arr = mysql_fetch_assoc ( $index ) ) {

                // get other data
                $data_arr['active_text'] = ( $data_arr['snippet_active'] == 1 ) ? $TEXT['admin']->get('snippet_active') : $TEXT['admin']->get('snippet_not_active');

                echo '
                                    <b>'.killhtml ( $data_arr['snippet_tag'] ).'</b> ('.$data_arr['active_text'].')<br>
                ';
            }
        }

        // Display End of Table
        echo '
                                </td>
                                <td class="config right top" style="padding: 0px;">
                                    '.get_yesno_table ( 'snippet_delete' ).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$TEXT['admin']->get('button_arrow').' '.$TEXT['admin']->get('do_action_button_long').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
}
/////////////////////////////
//// Select Snippet Form ////
/////////////////////////////
if ( !isset ( $_POST['snippet_id'] ) )
{

    // start display
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="snippets_edit">
                        <table class="configtable select_list" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="3">'.$TEXT['admin']->get('snippet_select_title').'</td></tr>
    ';

    // get snippets from db
    $index = mysql_query ( '
                            SELECT *
                            FROM `'.$global_config_arr['pref'].'snippets`
                            ORDER BY `snippet_tag`
    ', $FD->sql()->conn() );

    // snippets found
    if ( mysql_num_rows ( $index ) > 0 ) {

        // display table head
        echo '
                            <tr>
                                <td class="config">'.$TEXT['admin']->get('snippet_tag_title').'</td>
                                <td class="config" width="20">&nbsp;&nbsp;'.$TEXT['admin']->get('active').'&nbsp;&nbsp;</td>
                                <td class="config" width="20"></td>
                            </tr>
        ';

        // display Snippets
        while ( $data_arr = mysql_fetch_assoc ( $index ) ) {

            // get other data
            $data_arr['active_text'] = ( $data_arr['snippet_active'] == 1 ) ? $TEXT['admin']->get('yes') : $TEXT['admin']->get('no');

            echo '

                            <tr class="select_entry">
                                <td class="configthin middle">'.killhtml ( $data_arr['snippet_tag'] ).'</td>
                                <td class="configthin middle center">'.$data_arr['active_text'].'</td>
                                <td class="config top center">
                                    <input class="pointer select_box" type="checkbox" name="snippet_id[]" value="'.$data_arr['snippet_id'].'">
                                </td>
                            </tr>
            ';
        }

        // display footer with button
        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="right" colspan="4">
                                    <select class="select_type" name="snippet_action" size="1">
                                        <option class="select_one" value="edit" '.getselected( 'edit', $_POST['snippet_action'] ).'>'.$TEXT['admin']->get('selection_edit').'</option>
        ';
        echo ( $_SESSION['snippets_delete'] ) ? '<option class="select_red" value="delete" '.getselected ( 'delete', $_POST['snippet_action'] ).'>'.$TEXT['admin']->get('selection_delete').'</option>' : '';
        echo'
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="4">
                                    <button class="button_new" type="submit">
                                        '.$TEXT['admin']->get('button_arrow').' '.$TEXT['admin']->get('do_action_button_long').'
                                    </button>
                                </td>
                            </tr>
        ';

    // no Snippets found
    } else {

           echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config center" colspan="4">'.$TEXT['admin']->get('snippets_not_found').'</td>
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
