<?php if (!defined('ACP_GO')) die('Unauthorized access!');

///////////////////////////////////
//// Get some Data when sended ////
///////////////////////////////////

// Check if Snippet exists
if ( isset ( $_POST['sended'] ) ) {
    $stmt = $FD->db()->conn()->prepare('SELECT COUNT(`snippet_id`) FROM `'.$FD->config('pref')."snippets` WHERE `snippet_tag` = ?");
    $stmt->execute(array('[%'. $_POST['snippet_tag'] .'%]'));
    $snippet_exists = ( $stmt->fetchColumn() != 0 );
} else {
    $snippet_exists = TRUE;
}

/////////////////////////
//// Save Data to DB ////
/////////////////////////
if (
    isset ( $_POST['snippet_tag'] )
    && $_POST['snippet_tag'] != ''
    && !$snippet_exists
   )
{
    // Security Functions
    settype ( $_POST['snippet_active'], 'integer' );

    // New Snippet
    if ( !$snippet_exists ) {

        // SQL-Queries
        $stmt = $FD->db()->conn()->prepare('
                        INSERT INTO `'.$FD->config('pref')."snippets` (
                                `snippet_tag`,
                                `snippet_text`,
                                `snippet_active`)
                        VALUES (
                                ?,
                                ?,
                                '".$_POST['snippet_active']."')");
        $stmt->execute(array('[%'.$_POST['snippet_tag'].'%]', $_POST['snippet_text']));

        systext ( $FD->text('admin', 'snippet_added'),
            $FD->text('admin', 'info'), FALSE, $FD->text('admin', 'icon_save_add') );
        unset ( $_POST );
    }
}

/////////////////////////
//// New Snippet Form ////
/////////////////////////

// Security Functions
$_POST['snippet_tag'] = isset($_POST['snippet_tag']) ? killhtml ( $_POST['snippet_tag'] ) : '';
$_POST['snippet_text'] = isset($_POST['snippet_text']) ? killhtml ( $_POST['snippet_text'] ) : '';

settype ( $_POST['snippet_active'], 'integer' );

// Check for Errors
if ( isset ( $_POST['sended'] ) ) {

    if ( $snippet_exists ) {
        $error_message = $FD->text("admin", "snippet_exists");
    } else {
        $error_message = $FD->text("admin", "form_not_filled");
    }

    // Display Error
    systext ( $FD->text("admin", "snippet_not_added").'<br>'.$error_message,
        $FD->text("admin", "error"), TRUE, $FD->text("admin", "icon_save_error") );

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
                            <tr><td class="line" colspan="2">'.$FD->text("admin", "snippet_add_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "snippet_tag_title").':<br>
                                    <span class="small">'.$FD->text("admin", "snippet_tag_desc").'</span>
                                </td>
                                <td class="config">
                                    [%&nbsp;<input class="text input_width" name="snippet_tag" maxlength="100" value="'.$_POST['snippet_tag'].'">&nbsp;%]
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "snippet_active_title").':<br>
                                    <span class="small">'.$FD->text("admin", "snippet_active_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="snippet_active" value="1" '.getchecked ( 1, $_POST['snippet_active'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$FD->text("admin", "snippet_text_title").':<br>
                                    <span class="small">'.$FD->text("admin", "snippet_text_desc").'</span>
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
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "snippet_add_title").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>
