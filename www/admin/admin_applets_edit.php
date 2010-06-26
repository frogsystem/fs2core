<?php
////////////////////////////
//// DB: Update Applets ////
////////////////////////////

if (
        isset ( $_POST['sended'] ) && $_POST['sended'] == "edit"
        && isset ( $_POST['applet_action'] ) && $_POST['applet_action'] == "edit"
        && isset ( $_POST['applet_id'] )
    )
{
    // Security-Functions
    settype ( $_POST['applet_id'], "integer" );
    settype ( $_POST['applet_active'], "integer" );
    settype ( $_POST['applet_output'], "integer" );

    // MySQL-Queries
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."applets`
                    SET
                        `applet_active` = '".$_POST['applet_active']."',
                        `applet_output` = '".$_POST['applet_output']."'
                    WHERE `applet_id` = '".$_POST['applet_id']."'
    ", $db );

    // Display Message
    systext ( $TEXT["admin"]->get("changes_saved"),
        $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_ok") );

    // Unset Vars
    unset ( $_POST );
}

////////////////////////////
//// DB: Delete Applets ////
////////////////////////////
elseif (
        $_SESSION['applets_delete']
        && isset ( $_POST['sended'] ) && $_POST['sended'] == "delete"
        && isset ( $_POST['applet_action'] ) && $_POST['applet_action'] == "delete"
        && isset ( $_POST['applet_id'] )
        && isset ( $_POST['applet_delete'] )
    )
{
    if ( $_POST['applet_delete'] == 1 ) {
    
        // Security-Functions
        $_POST['applet_id'] = array_map ( "intval", explode ( ",", $_POST['applet_id'] ) );

        // MySQL-Delete-Query
        mysql_query ("
                        DELETE
                        FROM ".$global_config_arr['pref']."applets
                        WHERE `applet_id` IN (".implode ( ",", $_POST['applet_id'] ).")
        ", $db );
        
        systext ( $TEXT["admin"]->get("applets_deleted"),
            $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_trash_ok") );

    } else {
        systext ( $TEXT["admin"]->get("applets_not_deleted"),
            $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_trash_error") );
    }

    // Unset Vars
    unset ( $_POST );
}

///////////////////////
//// Display Forms ////
///////////////////////
if (  isset ( $_POST['applet_id'] ) && is_array ( $_POST['applet_id'] ) && $_POST['applet_action'] )
{
    // Security Function
    $_POST['applet_id'] = array_map ( "intval", $_POST['applet_id'] );
    
    //////////////////////////
    //// Edit Applet Form ////
    //////////////////////////
    if ( $_POST['applet_action'] == "edit" && count ( $_POST['applet_id'] ) == 1 )
    {
        $_POST['applet_id'] = $_POST['applet_id'][0];

        // Display Error Messages
        if ( $_POST['sended'] == "edit" ) {
        
            // Shouldn't happen

        // Get Data from DB
        } else {
            $index = mysql_query ( "
                                    SELECT *
                                    FROM `".$global_config_arr['pref']."applets`
                                    WHERE `applet_id` = '".$_POST['applet_id']."'
                                    LIMIT 0,1
            ", $db );
            $data_arr = mysql_fetch_assoc ( $index );
            putintopost ( $data_arr );
        }

        // Security Functions
        $_POST['applet_file'] = killhtml ( $_POST['applet_file'] );

        settype ( $_POST['applet_id'], "integer" );
        settype ( $_POST['applet_active'], "integer" );
        settype ( $_POST['applet_output'], "integer" );
        

        // Display Form
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="applets_edit">
                        <input type="hidden" name="applet_action" value="edit">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" name="applet_id" value="'.$_POST['applet_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("applet_edit_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("applets_file_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("applets_file_desc").'</span>
                                </td>
                                <td class="config">
                                    '.$_POST['applet_file'].'.php
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("applets_active_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("applets_active_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="applet_active" value="1" '.getchecked ( 1, $_POST['applet_active'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("applets_output_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("applets_output_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="applet_output" value="1" '.getchecked ( 1, $_POST['applet_output'] ).'>
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
    elseif ( $_POST['applet_action'] == "edit" && count ( $_POST['applet_id'] ) > 1 ) {
        // Display Error
        systext ( $TEXT["admin"]->get("select_only_one_to_edit"),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
        unset ( $_POST['applet_id'] );
    }
    
    ////////////////////////////
    //// Delete Applet Form ////
    ////////////////////////////
    elseif ( $_SESSION['applets_delete'] && $_POST['applet_action'] == "delete" && count ( $_POST['applet_id'] ) >= 1 )
    {
        // Display Head of Table
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="applets_edit">
                        <input type="hidden" name="applet_action" value="delete">
                        <input type="hidden" name="sended" value="delete">
                        <input type="hidden" name="applet_id" value="'.implode ( ",", $_POST['applet_id'] ).'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("applets_delete_title").'</td></tr>
                            <tr>
                                <td class="configthin">
                                    '.$TEXT["admin"]->get("applets_delete_question").'
                                    <br><br>
        ';
        
        // get applets from db
        $index = mysql_query ( "
                                SELECT *
                                FROM ".$global_config_arr['pref']."applets
                                WHERE `applet_id` IN (".implode ( ",", $_POST['applet_id'] ).")
                                ORDER BY `applet_file`
        ", $db );
        // applets found
        if ( mysql_num_rows ( $index ) > 0 ) {
        
            // display applets
            while ( $data_arr = mysql_fetch_assoc ( $index ) ) {

                // get other data
                $data_arr['active_text'] = ( $data_arr['applet_active'] == 1 ) ? $TEXT["admin"]->get("applet_active") : $TEXT["admin"]->get("applet_not_active");
                $data_arr['output_text'] = ( $data_arr['applet_output'] == 1 ) ? $TEXT["admin"]->get("applet_output_enabled") : $TEXT["admin"]->get("applet_output_disabled");

                echo '
                                    <b>'.killhtml ( $data_arr['applet_file'] ).'.php</b> ('.$data_arr['active_text'].' / '.$data_arr['output_text'].')<br>
                ';
            }
        }

        // Display End of Table
        echo '
                                </td>
                                <td class="config right top" style="padding: 0px;">
                                    '.get_yesno_table ( "applet_delete" ).'
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
////////////////////////////
//// Select Applet Form ////
////////////////////////////
if ( !isset ( $_POST['applet_id'] ) )
{
    // get applets from db
    $applets = $sql->query ( "SELECT * FROM `{..pref..}applets` ORDER BY `applet_file`" );

    // generate list
    $theList = new SelectList ( "applet", $TEXT["admin"]->get("applet_select_title"), "applets_edit", 4 );
    $theList->setColumns ( array (
        array ( $TEXT["admin"]->get("filename") ),
        array ( '&nbsp;&nbsp;'.$TEXT["admin"]->get("active").'&nbsp;&nbsp;', array(), 20 ),
        array ( '&nbsp;&nbsp;'.$TEXT["admin"]->get("output").'&nbsp;&nbsp;', array(), 20 ),
        array ( "", array(), 20 )
    ) );
    $theList->setNoLinesText ( $TEXT["admin"]->get("applets_not_found") );
    $theList->addAction ( "edit", $TEXT["admin"]->get("selection_edit"), array ( "select_one" ), TRUE, TRUE );
    $theList->addAction ( "delete", $TEXT["admin"]->get("selection_delete"), array ( "select_red" ), $_SESSION['applets_delete'] );
    $theList->addButton();

    // applets found
    if ( $applets !== FALSE && mysql_num_rows ( $applets ) > 0 ) {
        while ( $data_arr = mysql_fetch_assoc ( $applets ) ) {
            $theList->addLine ( array (
                array ( killhtml ( $data_arr['applet_file'] ).'.php', array ( "middle" ) ),
                array ( ( $data_arr['applet_active'] == 1 ) ? $TEXT["admin"]->get("yes") : $TEXT["admin"]->get("no"), array ( "middle", "center" ) ),
                array ( ( $data_arr['applet_output'] == 1 ) ? $TEXT["admin"]->get("yes") : $TEXT["admin"]->get("no"), array ( "middle", "center" ) ),
                array ( TRUE, $data_arr['applet_id'] )
            ) );
        }
    }
    // Output
    echo $theList;
}
?>