<?php
////////////////////////////
//// DB: Update Aliases ////
////////////////////////////

if (
        isset ( $_POST['sended'] ) && $_POST['sended'] == "edit"
        && isset ( $_POST['alias_action'] ) && $_POST['alias_action'] == "edit"
        && isset ( $_POST['alias_id'] )
        && $_POST['alias_go'] && $_POST['alias_go'] != ""
        && $_POST['alias_forward_to'] && $_POST['alias_forward_to'] != ""
    )
{
    // Security-Functions
    $_POST['alias_go'] = savesql ( $_POST['alias_go'] );
    $_POST['alias_forward_to'] = savesql ( $_POST['alias_forward_to'] );

    settype ( $_POST['alias_active'], "integer" );
    settype ( $_POST['alias_id'], "integer" );

    // MySQL-Queries
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."aliases`
                    SET
                        `alias_go` = '".$_POST['alias_go']."',
                        `alias_forward_to` = '".$_POST['alias_forward_to']."',
                        `alias_active` = '".$_POST['alias_active']."'
                    WHERE `alias_id` = '".$_POST['alias_id']."'
    ", $db );

    // Display Message
    systext ( $TEXT["admin"]->get("changes_saved"),
        $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_ok") );

    // Unset Vars
    unset ( $_POST );
}

////////////////////////////
//// DB: Delete Aliases ////
////////////////////////////
elseif (
        $_SESSION['aliases_delete']
        && isset ( $_POST['sended'] ) && $_POST['sended'] == "delete"
        && isset ( $_POST['alias_action'] ) && $_POST['alias_action'] == "delete"
        && isset ( $_POST['alias_id'] )
        && isset ( $_POST['alias_delete'] )
    )
{
    if ( $_POST['alias_delete'] == 1 ) {
    
        // Security-Functions
        $_POST['alias_id'] = array_map ( "intval", explode ( ",", $_POST['alias_id'] ) );

        // MySQL-Delete-Query
        mysql_query ("
                        DELETE
                        FROM `".$global_config_arr['pref']."aliases`
                        WHERE `alias_id` IN (".implode ( ",", $_POST['alias_id'] ).")
        ", $db );
        
        systext ( $TEXT["admin"]->get("aliases_deleted"),
            $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_trash_ok") );

    } else {
        systext ( $TEXT["admin"]->get("aliases_not_deleted"),
            $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_trash_error") );
    }

    // Unset Vars
    unset ( $_POST );
}

///////////////////////
//// Display Forms ////
///////////////////////
if ( isset ( $_POST['alias_id'] ) && $_POST['alias_action'] )
{
    // Security Function
    $_POST['alias_id'] = ( is_array ( $_POST['alias_id'] ) ) ? $_POST['alias_id'] : array ( $_POST['alias_id'] );
    $_POST['alias_id'] = array_map ( "intval", $_POST['alias_id'] );
    
    //////////////////////////
    //// Edit Alias Form ////
    //////////////////////////
    if ( $_POST['alias_action'] == "edit" && count ( $_POST['alias_id'] ) == 1 )
    {
        $_POST['alias_id'] = $_POST['alias_id'][0];

        // Display Error Messages
        if ( $_POST['sended'] == "edit" ) {

            $error_message = $TEXT["admin"]->get("form_not_filled");
            systext ( $TEXT["admin"]->get("alias_not_edited")."<br>".$error_message,
                $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );

        // Get Data from DB
        } else {
            $index = mysql_query ( "
                                    SELECT *
                                    FROM `".$global_config_arr['pref']."aliases`
                                    WHERE `alias_id` = '".$_POST['alias_id']."'
                                    LIMIT 0,1
            ", $db );
            $data_arr = mysql_fetch_assoc ( $index );
            putintopost ( $data_arr );
        }

        // Security Functions
        $_POST['alias_go'] = killhtml ( $_POST['alias_go'] );
        $_POST['alias_forward_to'] = killhtml ( $_POST['alias_forward_to'] );

        settype ( $_POST['alias_active'], "integer" );

        // Display Form
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="aliases_edit">
                        <input type="hidden" name="alias_action" value="edit">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" name="alias_id" value="'.$_POST['alias_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("alias_edit_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("alias_go_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("alias_go_desc").'</span>
                                </td>
                                <td class="config">
                                    ?go = <input class="text input_width" name="alias_go" maxlength="100" value="'.$_POST['alias_go'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("alias_forward_to_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("alias_forward_to_desc").'</span>
                                </td>
                                <td class="config">
                                    ?go = <input class="text input_width" name="alias_forward_to" maxlength="100" value="'.$_POST['alias_forward_to'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("alias_active_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("alias_active_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="alias_active" value="1" '.getchecked ( 1, $_POST['alias_active'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("save_changes_button").'
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
    elseif ( $_POST['alias_action'] == "edit" && count ( $_POST['alias_id'] ) > 1 ) {
        // Display Error
        systext ( $TEXT["admin"]->get("select_only_one_to_edit"),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
        unset ( $_POST['alias_id'] );
    }
    
    ///////////////////////////
    //// Delete Alias Form ////
    ///////////////////////////
    elseif ( $_SESSION['aliases_delete'] && $_POST['alias_action'] == "delete" && count ( $_POST['alias_id'] ) >= 1 )
    {
        // Display Head of Table
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="aliases_edit">
                        <input type="hidden" name="alias_action" value="delete">
                        <input type="hidden" name="sended" value="delete">
                        <input type="hidden" name="alias_id" value="'.implode ( ",", $_POST['alias_id'] ).'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("aliases_delete_title").'</td></tr>
                            <tr>
                                <td class="configthin">
                                    '.$TEXT["admin"]->get("aliases_delete_question").'
                                    <br><br>
        ';
        
        // get aliases from db
        $index = mysql_query ( "
                                SELECT *
                                FROM `".$global_config_arr['pref']."aliases`
                                WHERE `alias_id` IN (".implode ( ",", $_POST['alias_id'] ).")
                                ORDER BY `alias_go` ASC, `alias_forward_to` ASC
        ", $db );
        // aliases found
        if ( mysql_num_rows ( $index ) > 0 ) {
        
            // display aliases
            while ( $data_arr = mysql_fetch_assoc ( $index ) ) {

                // get other data
                $data_arr['active_text'] = ( $data_arr['alias_active'] == 1 ) ? $TEXT["admin"]->get("alias_active") : $TEXT["admin"]->get("alias_not_active");

                echo '
                                    <b>?go='.killhtml ( $data_arr['alias_go'] ).'</b> =>  <b>?go='.killhtml ( $data_arr['alias_forward_to'] ).'</b> ('.$data_arr['active_text'].')<br>
                ';
            }
        }

        // Display End of Table
        echo '
                                </td>
                                <td class="config right top" style="padding: 0px;">
                                    '.get_yesno_table ( "alias_delete" ).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("do_action_button_long").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
}
/////////////////////////////
//// Select Aliases Form ////
/////////////////////////////
if ( !isset ( $_POST['alias_id'] ) )
{

    // start display
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="aliases_edit">
                        <table class="configtable select_list" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="4">'.$TEXT["admin"]->get("alias_select_title").'</td></tr>
    ';

    // get Aliases from db
    $index = mysql_query ( "
                            SELECT *
                            FROM `".$global_config_arr['pref']."aliases`
                            ORDER BY `alias_go` ASC, `alias_forward_to` ASC
    ", $db );

    // Aliases found
    if ( mysql_num_rows ( $index ) > 0 ) {

        // display table head
        echo '
                            <tr>
                                <td class="config">'.$TEXT["admin"]->get("alias_go_title").'</td>
                                <td class="config">'.$TEXT["admin"]->get("alias_forward_to_title").'</td>
                                <td class="config" width="20">&nbsp;&nbsp;'.$TEXT["admin"]->get("active").'&nbsp;&nbsp;</td>
                                <td class="config" width="20"></td>
                            </tr>
        ';

        // display Aliases
        while ( $data_arr = mysql_fetch_assoc ( $index ) ) {

            // get other data
            $data_arr['active_text'] = ( $data_arr['alias_active'] == 1 ) ? $TEXT["admin"]->get("yes") : $TEXT["admin"]->get("no");

            echo '

                            <tr class="select_entry">
                                <td class="configthin middle">?go='.killhtml ( $data_arr['alias_go'] ).'</td>
                                <td class="configthin middle">?go='.killhtml ( $data_arr['alias_forward_to'] ).'</td>
                                <td class="configthin middle center">'.$data_arr['active_text'].'</td>
                                <td class="config top center">
                                    <input class="pointer select_box" type="checkbox" name="alias_id[]" value="'.$data_arr['alias_id'].'">
                                </td>
                            </tr>
            ';
        }

        // display footer with button
        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="right" colspan="4">
                                    <select class="select_type" name="alias_action" size="1">
                                        <option class="select_one" value="edit" '.getselected( "edit", $_POST['alias_action'] ).'>'.$TEXT["admin"]->get("selection_edit").'</option>
        ';
        echo ( $_SESSION['aliases_delete'] ) ? '<option class="select_red" value="delete" '.getselected ( "delete", $_POST['alias_action'] ).'>'.$TEXT["admin"]->get("selection_delete").'</option>' : "";
        echo'
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="4">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("do_action_button_long").'
                                    </button>
                                </td>
                            </tr>
        ';

    // no Aliases found
    } else {

           echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config center" colspan="4">'.$TEXT["admin"]->get("aliases_not_found").'</td>
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