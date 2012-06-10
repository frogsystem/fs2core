<?php
/////////////////////////
//// Save Data to DB ////
/////////////////////////

if (
        $_POST['alias_go'] && $_POST['alias_go'] != ""
        && $_POST['alias_forward_to'] && $_POST['alias_forward_to'] != ""
    )
{
    // Security Functions
    $_POST['alias_go'] = savesql ( $_POST['alias_go'] );
    $_POST['alias_forward_to'] = savesql ( $_POST['alias_forward_to'] );

    settype ( $_POST['alias_active'], 'integer' );
    
    // MySQL-Queries
    mysql_query ( ' INSERT INTO `'.$global_config_arr['pref']."aliases` (
                            `alias_go`,
                            `alias_forward_to`,
                            `alias_active`
                    )
                    VALUES (
                            '".$_POST['alias_go']."',
                            '".$_POST['alias_forward_to']."',
                            '".$_POST['alias_active']."'
                    )
    ", $sql->conn() );
    
    systext ( $TEXT['admin']->get('alias_added'),
        $TEXT['admin']->get('info'), FALSE, $TEXT['admin']->get('icon_save_add') );
    unset ( $_POST );
}

////////////////////////
//// New Alias Form ////
////////////////////////

// Security Functions
$_POST['alias_go'] = killhtml ( $_POST['alias_go'] );
$_POST['alias_forward_to'] = killhtml ( $_POST['alias_forward_to'] );

settype ( $_POST['alias_active'], "integer" );


// Check for Errors
if ( isset ( $_POST['sended'] ) ) {

    $error_message = $TEXT['admin']->get('form_not_filled');
    systext ( $TEXT['admin']->get('alias_not_added').'<br>'.$error_message,
        $TEXT['admin']->get('error'), TRUE, $TEXT['admin']->get('icon_save_error') );

// Set Data
} else {
    $_POST['alias_active'] = 1;
}


// Display Form
echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="aliases_add">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT['admin']->get('alias_add_title').'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT['admin']->get('alias_go_title').':<br>
                                    <span class="small">'.$TEXT['admin']->get('alias_go_desc').'</span>
                                </td>
                                <td class="config">
                                    ?go = <input class="text input_width" name="alias_go" maxlength="100" value="'.$_POST['alias_go'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT['admin']->get('alias_forward_to_title').':<br>
                                    <span class="small">'.$TEXT['admin']->get('alias_forward_to_desc').'</span>
                                </td>
                                <td class="config">
                                    ?go = <input class="text input_width" name="alias_forward_to" maxlength="100" value="'.$_POST['alias_forward_to'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT['admin']->get('alias_active_title').':<br>
                                    <span class="small">'.$TEXT['admin']->get('alias_active_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="alias_active" value="1" '.getchecked ( 1, $_POST['alias_active'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$TEXT['admin']->get('button_arrow').' '.$TEXT['admin']->get('alias_add_title').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>
