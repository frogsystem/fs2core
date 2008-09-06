<?php
/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ( isset ( $_POST['sended'] ) )
{
	// security functions
	settype ( $_POST['show_announcement'], "integer" );
	settype ( $_POST['activate_announcement'], "integer" );
	settype ( $_POST['ann_html'], "integer" );
	settype ( $_POST['ann_fscode'], "integer" );
	settype ( $_POST['ann_para'], "integer" );
	$_POST['announcement_text'] = savesql ( $_POST['announcement_text'] );

	// MySQL-Queries
    mysql_query ( "
					UPDATE `".$global_config_arr['pref']."announcement`
					SET
                        `announcement_text` = '".$_POST['announcement_text']."',
						`show_announcement` = '".$_POST['show_announcement']."',
						`activate_announcement` = '".$_POST['activate_announcement']."',
						`ann_html` = '".$_POST['ann_html']."',
						`ann_fscode` = '".$_POST['ann_fscode']."',
						`ann_para` = '".$_POST['ann_para']."'
					WHERE `id` = '1'
	", $db);

	// system messages
    systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);

    // Unset Vars
    unset ( $_POST );
}

//////////////////////////////////////
//// Announcement Form & Settings ////
//////////////////////////////////////

if ( TRUE )
{
	// Display Error Messages
	if ( isset ( $_POST['sended'] ) ) {
		systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );

	// Load Data from DB into Post
	} else {
	    $index = mysql_query ( "
								SELECT *
								FROM `".$global_config_arr['pref']."announcement`
								WHERE `id` = '1'
		", $db);
	    $config_arr = mysql_fetch_assoc($index);
	    putintopost ( $config_arr );
	}

	// security functions
	settype ( $_POST['show_announcement'], "integer" );
	settype ( $_POST['activate_announcement'], "integer" );
	settype ( $_POST['ann_html'], "integer" );
	settype ( $_POST['ann_fscode'], "integer" );
	settype ( $_POST['ann_para'], "integer" );
	$_POST['announcement_text'] = killhtml ( $_POST['announcement_text'] );

	// Display Form
    echo'
                    <form action="" method="post">
                        <input type="hidden" name="go" value="gen_announcement">
   						<input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][ann_settings_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][show_announcement].':<br>
                                    <span class="small">'.$admin_phrases[general][show_announcement_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="show_announcement">
                                        <option value="1" '.getselected( $_POST['show_announcement'], 1 ).'>'.$admin_phrases[general][show_ann_always].'</option>
                                        <option value="2" '.getselected( $_POST['show_announcement'], 2 ).'>'.$admin_phrases[general][show_ann_home].'</option>
                                        <option value="0" '.getselected( $_POST['show_announcement'], 0 ).'>'.$admin_phrases[general][show_ann_never].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][activate_ann].':<br>
                                    <span class="small">'.$admin_phrases[general][activate_ann_desc].'</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="activate_announcement" value="1" '.getchecked( $_POST['activate_announcement'], 1 ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][ann_title].'</td></tr>
                            <tr>
                                <td class="config right" colspan="2">
								    <input class="pointer middle" type="checkbox" name="ann_html" value="1" '.getchecked ( $_POST['ann_html'], 1 ).'>
								    <span class="small middle">'.$admin_phrases[articles][articles_use_html].'</span>&nbsp;&nbsp;
								    <input class="pointer middle" type="checkbox" name="ann_fscode" value="1" '.getchecked ( $_POST['ann_fscode'], 1 ).'>
								    <span class="small middle">'.$admin_phrases[articles][articles_use_fscode].'</span>&nbsp;&nbsp;
								    <input class="pointer middle" type="checkbox" name="ann_para" value="1" '.getchecked ( $_POST['ann_para'], 1 ).'>
								    <span class="small middle">'.$admin_phrases[articles][articles_use_para].'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.create_editor ( "announcement_text", $_POST['announcement_text'], "100%", "250px", "", FALSE ).'
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