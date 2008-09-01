<?php

//////////////////////////
//// Video einstellen ////
//////////////////////////

if (
		$_POST['video_url'] && $_POST['video_url'] != ""
		&& $_POST['video_title'] && $_POST['video_title'] != ""
	)
{
    $_POST['video_url'] = savesql ( $_POST['video_url'] );
	$_POST['video_title'] = savesql ( $_POST['video_title'] );
    $_POST['video_desc'] = savesql ( $_POST['video_desc'] );
    settype ( $_POST['dl_id'], "integer" );
    
    mysql_query ( "
					INSERT INTO
						".$global_config_arr['pref']."player
						( video_url, video_title, video_desc, dl_id )
					VALUES (
						'".$_POST['video_url']."',
						'".$_POST['video_title']."',
						'".$_POST['video_desc']."',
						'".$_POST['dl_id']."'
					 )
	", $db );

	$id = mysql_insert_id();
	
    systext( "Video eingetragen!" );

}

//////////////////////////
///// Video Formular /////
//////////////////////////

else
{
	// Display Error Messages
	if ( isset ( $_POST['sended'] ) ) {
		  systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
	}

    $_POST['video_url'] = killhtml ( $_POST['video_url'] );
	$_POST['video_title'] = killhtml ( $_POST['video_title'] );
    $_POST['video_desc'] = killhtml ( $_POST['video_desc'] );
    settype ( $_POST['dl_id'], "integer" );

    echo'
                    <form action="" method="post">
						<input type="hidden" value="playeradd" name="go">
                        <input type="hidden" name="sended" value="1">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">Neues Video eintragen</td></tr>
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
                                    URL:<br>
                                    <span class="small">URL zur Video-Datei (FLV-Format).</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="45" maxlength="255" name="video_url" value="'.$_POST['video_url'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Beschreibung: <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">Text, der das Video beschreibt.</span>
                                </td>
                                <td class="config" valign="top">
                                    <textarea class="text" name="video_desc" rows="5" cols="50" wrap="virtual">'.$_POST['video_desc'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Download:<br>
                                    <span class="small">Soll das Video mit einem DL verknüpft werden?</span>
                                </td>
                                <td class="config">
                                    <select name="dl_id">
                                        <option value="0" '.getselected(0, $_POST['dl_id']).'>keine Verknüpfung</option>
	';
										// DL auflisten
										$index = mysql_query ( "
																SELECT
																	D.dl_id, D.dl_name, C.cat_name
																FROM
																	".$global_config_arr['pref']."dl D, ".$global_config_arr['pref']."dl_cat AS C
																WHERE
																    D.cat_id = C.cat_id
																ORDER BY
																    D.dl_name ASC
										", $db );

										while ( $dl_arr = mysql_fetch_assoc ( $index ) )
										{
											echo '<option value="'.$dl_arr['dl_id'].'" '.getselected($dl_arr['dl_id'], $_POST['dl_id']).'>'.$dl_arr['dl_name'].' ('.$dl_arr['cat_name'].')</option>';
										}
	echo'
                                    </select>
                                </td>
                            </tr>
							<tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' Video hinzufügen
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>