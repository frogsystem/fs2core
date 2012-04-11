<?php
///////////////////////////////////
//// Get some Data when sended ////
///////////////////////////////////

// Check if Snippet exists
if ( isset ( $_POST['sended'] ) ) {
    $index = mysql_query ( "SELECT `snippet_id` FROM `".$global_config_arr['pref']."snippets` WHERE `snippet_tag` = '[%".savesql ( $_POST['snippet_tag'] )."%]'", $FD->sql()->conn() );
    $snippet_exists = ( mysql_num_rows ( $index ) == 0 ) ? FALSE : TRUE;
} else {
    $snippet_exists = TRUE;
}

/////////////////////////
//// Save Data to DB ////
/////////////////////////
if (
        isset ( $_POST['snippet_tag'] )
        && $_POST['snippet_tag'] != ""
        && !$snippet_exists
    )
{
    // Security Functions
    $_POST['snippet_tag'] = savesql ( $_POST['snippet_tag'] );
    $_POST['snippet_text'] = savesql ( $_POST['snippet_text'] );
    
    settype ( $_POST['snippet_active'], "integer" );

    // New Snippet
    if ( !$snippet_exists ) {

        // MySQL-Queries
        mysql_query ( "
                                        INSERT INTO `".$global_config_arr['pref']."snippets` (
                                                `snippet_tag`,
                                                `snippet_text`,
                                                `snippet_active`
                                        )
                                        VALUES (
                                                '[%".$_POST['snippet_tag']."%]',
                                                '".$_POST['snippet_text']."',
                                                '".$_POST['snippet_active']."'
                                        )
        ", $FD->sql()->conn() );
        
        systext ( $TEXT["admin"]->get("snippet_added"),
            $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add") );
        unset ( $_POST );
    }
}

/////////////////////////
//// New Snippet Form ////
/////////////////////////

// Security Functions
$_POST['snippet_tag'] = killhtml ( $_POST['snippet_tag'] );
$_POST['snippet_text'] = killhtml ( $_POST['snippet_text'] );

settype ( $_POST['snippet_active'], "integer" );

// Check for Errors
if ( isset ( $_POST['sended'] ) ) {

    if ( $snippet_exists ) {
        $error_message = $TEXT["admin"]->get("snippet_exists");
    } else {
        $error_message = $TEXT["admin"]->get("form_not_filled");
    }
    
    // Display Error
    systext ( $TEXT["admin"]->get("snippet_not_added")."<br>".$error_message,
        $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );

// Set Data
} else {
    $_POST['snippet_active'] = 1;
}


// Display Form
echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="snippets_add">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("snippet_add_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("snippet_tag_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("snippet_tag_desc").'</span>
                                </td>
                                <td class="config">
                                    [%&nbsp;<input class="text input_width" name="snippet_tag" maxlength="100" value="'.$_POST['snippet_tag'].'">&nbsp;%]
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("snippet_active_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("snippet_active_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="snippet_active" value="1" '.getchecked ( 1, $_POST['snippet_active'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$TEXT["admin"]->get("snippet_text_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("snippet_text_desc").'</span>
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
                                        '.$admin_phrases['common']['arrow'].' '.$TEXT['admin']->get('snippet_add_title').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>
