<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('group_pic_x', 'group_pic_y', 'group_pic_size');

///////////////////////
//// Update Config ////
///////////////////////

if (
		isset($_POST['group_pic_x']) && $_POST['group_pic_x'] > 0
		&& isset($_POST['group_pic_y']) && $_POST['group_pic_y'] > 0
		&& isset($_POST['group_pic_size']) && $_POST['group_pic_size'] > 0
	)
{
    // prepare data
    $data = frompost($used_cols);
      
    // save config
    try {
        $FD->saveConfig('groups', $data);
        systext($FD->text('admin', 'config_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
    } catch (Exception $e) {
        systext(
            $FD->text('admin', 'config_not_saved').'<br>'.
            (DEBUG ? $e->getMessage() : $FD->text('admin', 'unknown_error')),
            $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error')
        );        
    }

    // Unset Vars
    unset($_POST);
}

/////////////////////
//// Config Form ////
/////////////////////

if ( TRUE )
{
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    // Load Data from DB into Post
    } else {
        $data = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'groups'"));
        $data = json_array_decode($data['config_data']);
        putintopost($data);
    }    
    
    // security functions
    $_POST = array_map('killhtml', $_POST);

	// Display Form
    echo'
                    <form action="" method="post">
                        <input type="hidden" name="go" value="group_config">
						<input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="4">Gruppen</td></tr>
                            <tr>
                                <td class="config">
                                    '."Gruppen-Symbol - max. Abmessungen".':<br>
                                    <span class="small">'."Die max. Abmessungen eines Gruppen-Symbols.".'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="3" maxlength="3" name="group_pic_x" value="'.$_POST['group_pic_x'].'">
                                    x
                                    <input class="text center" size="3" maxlength="3" name="group_pic_y" value="'.$_POST['group_pic_y'].'"> '.$FD->text('admin', 'pixel').'<br>
                                    <span class="small">(Breite x H&ouml;he; '.$FD->text('admin', 'zero_not_allowed').')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '."Gruppen-Symbol - max. Dateigr&ouml;&szlig;e".':<br>
                                    <span class="small">'."Die max. Dateigr&ouml;&szlig;e eines Gruppen-Symbols.".'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="4" maxlength="4" name="group_pic_size" value="'.$_POST['group_pic_size'].'"> KiB<br>
                                    <span class="small">('.$FD->text('admin', 'zero_not_allowed').')</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'save_long').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
