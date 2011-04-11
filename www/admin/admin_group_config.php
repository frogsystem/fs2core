<?php
///////////////////////
//// Update Config ////
///////////////////////

if (
		$_POST['group_pic_x'] && $_POST['group_pic_x'] > 0
		&& $_POST['group_pic_y'] && $_POST['group_pic_y'] > 0
		&& $_POST['group_pic_size'] && $_POST['group_pic_size'] > 0
	)
{
	// security functions
    settype ( $_POST['group_pic_x'], "integer" );
    settype ( $_POST['group_pic_y'], "integer" );
    settype ( $_POST['group_pic_size'], "integer" );

	// MySQL-Queries
    mysql_query ( "
					UPDATE `".$global_config_arr['pref']."user_config`
					SET
						`group_pic_x` = '".$_POST['group_pic_x']."',
						`group_pic_y` = '".$_POST['group_pic_y']."',
						`group_pic_size` = '".$_POST['group_pic_size']."'
					WHERE `id` = '1'
	", $db );
	
	// system messages
    systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);

    // Unset Vars
    unset ( $_POST );
}

/////////////////////
//// Config Form ////
/////////////////////

if ( TRUE )
{
	// Display Error Messages
	if ( isset ( $_POST['sended'] ) ) {
		systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );

	// Load Data from DB into Post
	} else {
	    $index = mysql_query ( "
								SELECT *
								FROM ".$global_config_arr['pref']."user_config
								WHERE `id` = '1'
		", $db);
	    $config_arr = mysql_fetch_assoc($index);
	    putintopost ( $config_arr );
	}
	
	// security functions
    settype ( $_POST['group_pic_x'], "integer" );
    settype ( $_POST['group_pic_y'], "integer" );
    settype ( $_POST['group_pic_size'], "integer" );

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
                                    <input class="text center" size="3" maxlength="3" name="group_pic_y" value="'.$_POST['group_pic_y'].'"> '.$admin_phrases[common][pixel].'<br>
                                    <span class="small">(Breite x Höhe; '.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '."Gruppen-Symbol - max. Dateigröße".':<br>
                                    <span class="small">'."Die max. Dateigröße eines Gruppen-Symbols.".'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="4" maxlength="4" name="group_pic_size" value="'.$_POST['group_pic_size'].'"> KiB<br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>