<?php
///////////////////////
//// Update Config ////
///////////////////////

if (
		$_POST['cfg_videobgcolor'] && $_POST['cfg_videobgcolor'] != ""
		&& $_POST['cfg_bgcolor2'] && $_POST['cfg_bgcolor2'] != ""
		&& $_POST['cfg_bgcolor'] && $_POST['cfg_bgcolor'] != ""
		&& $_POST['cfg_showplayer'] && $_POST['cfg_showplayer'] != ""
		&& $_POST['cfg_showloading'] && $_POST['cfg_showloading'] != ""
		&& $_POST['cfg_playercolor'] && $_POST['cfg_playercolor'] != ""
		&& $_POST['cfg_loadingcolor'] && $_POST['cfg_loadingcolor'] != ""
		&& $_POST['cfg_buttoncolor'] && $_POST['cfg_buttoncolor'] != ""
		&& $_POST['cfg_buttonovercolor'] && $_POST['cfg_buttonovercolor'] != ""
		&& $_POST['cfg_slidercolor1'] && $_POST['cfg_slidercolor1'] != ""
		&& $_POST['cfg_slidercolor2'] && $_POST['cfg_slidercolor2'] != ""
		&& $_POST['cfg_sliderovercolor'] && $_POST['cfg_sliderovercolor'] != ""
		&& $_POST['cfg_buffercolor'] && $_POST['cfg_buffercolor'] != ""
		&& $_POST['cfg_bufferbgcolor'] && $_POST['cfg_bufferbgcolor'] != ""
		&& $_POST['cfg_titlecolor'] && $_POST['cfg_titlecolor'] != ""
		&& $_POST['cfg_onclick'] && $_POST['cfg_onclick'] != ""
		&& $_POST['cfg_ondoubleclick'] && $_POST['cfg_ondoubleclick'] != ""
		&& $_POST['cfg_showmouse'] && $_POST['cfg_showmouse'] != ""
		&& $_POST['cfg_iconplaycolor'] && $_POST['cfg_iconplaycolor'] != ""
		&& $_POST['cfg_iconplaybgcolor'] && $_POST['cfg_iconplaybgcolor'] != ""
		
		&& isset ( $_POST['cfg_margin'] ) && $_POST['cfg_margin'] >= 0
		&& isset ( $_POST['cfg_playertimeout'] ) && $_POST['cfg_playertimeout'] >= 0
		&& isset ( $_POST['cfg_playeralpha'] ) && $_POST['cfg_playeralpha'] >= 0 && $_POST['cfg_playeralpha'] <= 100
		&& isset ( $_POST['cfg_buffer'] ) && $_POST['cfg_buffer'] >= 0
		&& isset ( $_POST['cfg_titlesize'] ) && $_POST['cfg_titlesize'] >= 0
		&& isset ( $_POST['cfg_iconplaybgalpha'] ) && $_POST['cfg_iconplaybgalpha'] >= 0 && $_POST['cfg_iconplaybgalpha'] <= 100
		&& isset ( $_POST['cfg_top1_x'] )
		&& isset ( $_POST['cfg_top1_y'] )
	)
{
	// security functions
	settype ( $_POST['cfg_loop'], "integer" );
	settype ( $_POST['cfg_autoplay'], "integer" );
	settype ( $_POST['cfg_autoload'], "integer" );
	settype ( $_POST['cfg_volume'], "integer" );
	settype ( $_POST['cfg_margin'], "integer" );
	settype ( $_POST['cfg_showstop'], "integer" );
	settype ( $_POST['cfg_showvolume'], "integer" );
	settype ( $_POST['cfg_showtime'], "integer" );
	settype ( $_POST['cfg_playertimeout'], "integer" );
	settype ( $_POST['cfg_showfullscreen'], "integer" );
	settype ( $_POST['cfg_playeralpha'], "integer" );
	settype ( $_POST['cfg_buffer'], "integer" );
	settype ( $_POST['cfg_buffershowbg'], "integer" );
	settype ( $_POST['cfg_titlesize'], "integer" );
	settype ( $_POST['cfg_shortcut'], "integer" );
	settype ( $_POST['cfg_showiconplay'], "integer" );
	settype ( $_POST['cfg_showtitleandstartimage'], "integer" );
	settype ( $_POST['cfg_iconplaybgalpha'], "integer" );
	settype ( $_POST['cfg_top1_x'], "integer" );
	settype ( $_POST['cfg_top1_y'], "integer" );
	settype ( $_POST['cfg_loadonstop'], "integer" );

	$_POST['cfg_videobgcolor'] = savesql ( $_POST['cfg_videobgcolor'] );
	$_POST['cfg_bgcolor1'] = savesql ( $_POST['cfg_bgcolor1'] );
	$_POST['cfg_bgcolor2'] = savesql ( $_POST['cfg_bgcolor2'] );
	$_POST['cfg_bgcolor'] = savesql ( $_POST['cfg_bgcolor'] );
	$_POST['cfg_showplayer'] = savesql ( $_POST['cfg_showplayer'] );
	$_POST['cfg_showloading'] = savesql ( $_POST['cfg_showloading'] );
	$_POST['cfg_playercolor'] = savesql ( $_POST['cfg_playercolor'] );
	$_POST['cfg_loadingcolor'] = savesql ( $_POST['cfg_loadingcolor'] );
	$_POST['cfg_buttoncolor'] = savesql ( $_POST['cfg_buttoncolor'] );
	$_POST['cfg_buttonovercolor'] = savesql ( $_POST['cfg_buttonovercolor'] );
	$_POST['cfg_slidercolor1'] = savesql ( $_POST['cfg_slidercolor1'] );
	$_POST['cfg_slidercolor2'] = savesql ( $_POST['cfg_slidercolor2'] );
	$_POST['cfg_sliderovercolor'] = savesql ( $_POST['cfg_sliderovercolor'] );
	$_POST['cfg_buffermessage'] = savesql ( $_POST['cfg_buffermessage'] );
	$_POST['cfg_buffercolor'] = savesql ( $_POST['cfg_buffercolor'] );
	$_POST['cfg_bufferbgcolor'] = savesql ( $_POST['cfg_bufferbgcolor'] );
	$_POST['cfg_titlecolor'] = savesql ( $_POST['cfg_titlecolor'] );
	$_POST['cfg_onclick'] = savesql ( $_POST['cfg_onclick'] );
	$_POST['cfg_ondoubleclick'] = savesql ( $_POST['cfg_ondoubleclick'] );
	$_POST['cfg_showmouse'] = savesql ( $_POST['cfg_showmouse'] );
	$_POST['cfg_iconplaycolor'] = savesql ( $_POST['cfg_iconplaycolor'] );
	$_POST['cfg_iconplaybgcolor'] = savesql ( $_POST['cfg_iconplaybgcolor'] );
	$_POST['cfg_top1_url'] = savesql ( $_POST['cfg_top1_url'] );

	// MySQL-Queries
    mysql_query ( "
					UPDATE `".$global_config_arr['pref']."player_config`
					SET
						`cfg_loop` = '".$_POST['cfg_loop']."',
						`cfg_autoplay` = '".$_POST['cfg_autoplay']."',
						`cfg_autoload` = '".$_POST['cfg_autoload']."',
						`cfg_volume` = '".$_POST['cfg_volume']."',
						`cfg_margin` = '".$_POST['cfg_margin']."',
						`cfg_showstop` = '".$_POST['cfg_showstop']."',
						`cfg_showvolume` = '".$_POST['cfg_showvolume']."',
						`cfg_showtime` = '".$_POST['cfg_showtime']."',
						`cfg_playertimeout` = '".$_POST['cfg_playertimeout']."',
						`cfg_showfullscreen` = '".$_POST['cfg_showfullscreen']."',
						`cfg_playeralpha` = '".$_POST['cfg_playeralpha']."',
						`cfg_buffer` = '".$_POST['cfg_buffer']."',
						`cfg_buffershowbg` = '".$_POST['cfg_buffershowbg']."',
						`cfg_titlesize` = '".$_POST['cfg_titlesize']."',
						`cfg_shortcut` = '".$_POST['cfg_shortcut']."',
						`cfg_showiconplay` = '".$_POST['cfg_showiconplay']."',
						`cfg_showtitleandstartimage` = '".$_POST['cfg_showtitleandstartimage']."',
						`cfg_iconplaybgalpha` = '".$_POST['cfg_iconplaybgalpha']."',
						`cfg_top1_x` = '".$_POST['cfg_top1_x']."',
						`cfg_top1_y` = '".$_POST['cfg_top1_y']."',
						`cfg_loadonstop` = '".$_POST['cfg_loadonstop']."',
						
						`cfg_videobgcolor` = '".$_POST['cfg_videobgcolor']."',
						`cfg_bgcolor1` = '".$_POST['cfg_bgcolor1']."',
						`cfg_bgcolor2` = '".$_POST['cfg_bgcolor2']."',
						`cfg_bgcolor` = '".$_POST['cfg_bgcolor']."',
						`cfg_showplayer` = '".$_POST['cfg_showplayer']."',
						`cfg_showloading` = '".$_POST['cfg_showloading']."',
						`cfg_playercolor` = '".$_POST['cfg_playercolor']."',
						`cfg_loadingcolor` = '".$_POST['cfg_loadingcolor']."',
						`cfg_buttoncolor` = '".$_POST['cfg_buttoncolor']."',
						`cfg_buttonovercolor` = '".$_POST['cfg_buttonovercolor']."',
						`cfg_slidercolor1` = '".$_POST['cfg_slidercolor1']."',
						`cfg_slidercolor2` = '".$_POST['cfg_slidercolor2']."',
						`cfg_sliderovercolor` = '".$_POST['cfg_sliderovercolor']."',
						`cfg_buffermessage` = '".$_POST['cfg_buffermessage']."',
						`cfg_buffercolor` = '".$_POST['cfg_buffercolor']."',
						`cfg_bufferbgcolor` = '".$_POST['cfg_bufferbgcolor']."',
						`cfg_titlecolor` = '".$_POST['cfg_titlecolor']."',
						`cfg_onclick` = '".$_POST['cfg_onclick']."',
						`cfg_ondoubleclick` = '".$_POST['cfg_ondoubleclick']."',
						`cfg_showmouse` = '".$_POST['cfg_showmouse']."',
						`cfg_iconplaycolor` = '".$_POST['cfg_iconplaycolor']."',
						`cfg_iconplaybgcolor` = '".$_POST['cfg_iconplaybgcolor']."',
						`cfg_top1_url` = '".$_POST['cfg_top1_url']."'
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
								FROM ".$global_config_arr['pref']."player_config
								WHERE `id` = '1'
		", $db);
	    $config_arr = mysql_fetch_assoc($index);
	    putintopost ( $config_arr );
	}
	
	// security functions
	settype ( $_POST['cfg_loop'], "integer" );
	settype ( $_POST['cfg_autoplay'], "integer" );
	settype ( $_POST['cfg_autoload'], "integer" );
	settype ( $_POST['cfg_volume'], "integer" );
	settype ( $_POST['cfg_margin'], "integer" );
	settype ( $_POST['cfg_showstop'], "integer" );
	settype ( $_POST['cfg_showvolume'], "integer" );
	settype ( $_POST['cfg_showtime'], "integer" );
	settype ( $_POST['cfg_playertimeout'], "integer" );
	settype ( $_POST['cfg_showfullscreen'], "integer" );
	settype ( $_POST['cfg_playeralpha'], "integer" );
	settype ( $_POST['cfg_buffer'], "integer" );
	settype ( $_POST['cfg_buffershowbg'], "integer" );
	settype ( $_POST['cfg_titlesize'], "integer" );
	settype ( $_POST['cfg_shortcut'], "integer" );
	settype ( $_POST['cfg_showiconplay'], "integer" );
	settype ( $_POST['cfg_showtitleandstartimage'], "integer" );
	settype ( $_POST['cfg_iconplaybgalpha'], "integer" );
	settype ( $_POST['cfg_top1_x'], "integer" );
	settype ( $_POST['cfg_top1_y'], "integer" );
	settype ( $_POST['cfg_loadonstop'], "integer" );
	
	$_POST['cfg_videobgcolor'] = killhtml ( $_POST['cfg_videobgcolor'] );
	$_POST['cfg_bgcolor1'] = killhtml ( $_POST['cfg_bgcolor1'] );
	$_POST['cfg_bgcolor2'] = killhtml ( $_POST['cfg_bgcolor2'] );
	$_POST['cfg_bgcolor'] = killhtml ( $_POST['cfg_bgcolor'] );
	$_POST['cfg_showplayer'] = killhtml ( $_POST['cfg_showplayer'] );
	$_POST['cfg_showloading'] = killhtml ( $_POST['cfg_showloading'] );
	$_POST['cfg_playercolor'] = killhtml ( $_POST['cfg_playercolor'] );
	$_POST['cfg_loadingcolor'] = killhtml ( $_POST['cfg_loadingcolor'] );
	$_POST['cfg_buttoncolor'] = killhtml ( $_POST['cfg_buttoncolor'] );
	$_POST['cfg_buttonovercolor'] = killhtml ( $_POST['cfg_buttonovercolor'] );
	$_POST['cfg_slidercolor1'] = killhtml ( $_POST['cfg_slidercolor1'] );
	$_POST['cfg_slidercolor2'] = killhtml ( $_POST['cfg_slidercolor2'] );
	$_POST['cfg_sliderovercolor'] = killhtml ( $_POST['cfg_sliderovercolor'] );
	$_POST['cfg_buffermessage'] = killhtml ( $_POST['cfg_buffermessage'] );
	$_POST['cfg_buffercolor'] = killhtml ( $_POST['cfg_buffercolor'] );
	$_POST['cfg_bufferbgcolor'] = killhtml ( $_POST['cfg_bufferbgcolor'] );
	$_POST['cfg_titlecolor'] = killhtml ( $_POST['cfg_titlecolor'] );
	$_POST['cfg_onclick'] = killhtml ( $_POST['cfg_onclick'] );
	$_POST['cfg_ondoubleclick'] = killhtml ( $_POST['cfg_ondoubleclick'] );
	$_POST['cfg_showmouse'] = killhtml ( $_POST['cfg_showmouse'] );
	$_POST['cfg_iconplaycolor'] = killhtml ( $_POST['cfg_iconplaycolor'] );
	$_POST['cfg_iconplaybgcolor'] = killhtml ( $_POST['cfg_iconplaybgcolor'] );
	$_POST['cfg_top1_url'] = killhtml ( $_POST['cfg_top1_url'] );

	// Display Form
    echo'
                    <form action="" method="post">
                        <input type="hidden" name="go" value="player_config">
						<input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="4">Allgemeine Einstellungen</td></tr>
                            <tr>
                                <td class="config">
                                    Dauerschleife:<br>
                                    <span class="small">Spielt das Video in einer Dauerschleife ab.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_loop" value="1" '.getchecked ( 1, $_POST['cfg_loop'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    automatisch Abspielen:<br>
                                    <span class="small">Spielt das Video automatisch ab.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_autoplay" value="1" '.getchecked ( 1, $_POST['cfg_autoplay'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    automatisch Laden:<br>
                                    <span class="small">Lädt das Video automatisch in den Speicher.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_autoload" value="1" '.getchecked ( 1, $_POST['cfg_autoload'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Standard Lautstärke:<br>
                                    <span class="small">Die voreingestellte Lautstärke des Players.</span>
                                </td>
                                <td class="config">
                                    <select name="cfg_volume" size="1">
                                        <option value="0" '.getselected( 0, $_POST['cfg_volume'] ).'>0%</option>
                                        <option value="20" '.getselected( 20, $_POST['cfg_volume'] ).'>10%</option>
                                        <option value="40" '.getselected( 40, $_POST['cfg_volume'] ).'>20%</option>
                                        <option value="60" '.getselected( 60, $_POST['cfg_volume'] ).'>30%</option>
                                        <option value="80" '.getselected( 80, $_POST['cfg_volume'] ).'>40%</option>
                                        <option value="100" '.getselected( 100, $_POST['cfg_volume'] ).'>50%</option>
                                        <option value="120" '.getselected( 120, $_POST['cfg_volume'] ).'>60%</option>
                                        <option value="140" '.getselected( 140, $_POST['cfg_volume'] ).'>70%</option>
                                        <option value="160" '.getselected( 160, $_POST['cfg_volume'] ).'>80%</option>
                                        <option value="180" '.getselected( 180, $_POST['cfg_volume'] ).'>90%</option>
                                        <option value="200" '.getselected( 200, $_POST['cfg_volume'] ).'>100%</option>
									</select>
                                </td>
                            </tr>
       						<tr>
           						<td class="config">
               						Video-Hintergundfarbe:<br>
               						<span class="small">Die Hintergundfarbe, des Videofensters.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_videobgcolor" size="6" maxlength="6" value="'.$_POST['cfg_videobgcolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="4">Rahmen</td></tr>
                            <tr>
                                <td class="config">
                                    Rahmenbreite:<br>
                                    <span class="small">Die breite des generierten Rahmens.</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="2" maxlength="2" name="cfg_margin" value="'.$_POST['cfg_margin'].'"> Pixel<br>
                                    <span class="small">[0 um keinen Rahmen zu verwenden]</span>
                                </td>
                            </tr>
       						<tr>
           						<td class="config">
               						Rahmenfarbe 1 (oben):<br>
               						<span class="small">Obere Farbe des Rahmen-Farbverlaufs.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_bgcolor1" size="6" maxlength="6" value="'.$_POST['cfg_bgcolor1'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Rahmenfarbe 2 (unten):<br>
               						<span class="small">Untere Farbe des Rahmen-Farbverlaufs.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_bgcolor2" size="6" maxlength="6" value="'.$_POST['cfg_bgcolor2'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Hintergrundfarbe:<br>
               						<span class="small">Farbe des Hintergrunds; nötig um Ecken abzurunden.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_bgcolor" size="6" maxlength="6" value="'.$_POST['cfg_bgcolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="4">Elemente der Steuerungsleiste</td></tr>
                            <tr>
                                <td class="config">
                                    Stop-Button anzeigen:<br>
                                    <span class="small">Zeigt den Stop-Button auf der Steuerungsleiste an.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_showstop" value="1" '.getchecked ( 1, $_POST['cfg_showstop'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Bei Stop weiterladen:<br>
                                    <span class="small">Lädt das Video weiter, auch wenn es gestoppt wurde.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_loadonstop" value="1" '.getchecked ( 1, $_POST['cfg_loadonstop'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Lautstärkeregler anzeigen:<br>
                                    <span class="small">Zeigt den Lautstärkeregler auf der Steuerungsleiste an.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_showvolume" value="1" '.getchecked ( 1, $_POST['cfg_showvolume'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Zeit anzeigen:<br>
                                    <span class="small">Zeigt die aktuelle Zeit des Videos an.</span>
                                </td>
                                <td class="config">
                                    <select name="cfg_showtime" size="1">
                                        <option value="0" '.getselected( 0, $_POST['cfg_showtime'] ).'>nicht anzeigen</option>
                                        <option value="1" '.getselected( 1, $_POST['cfg_showtime'] ).'>vorwärts laufend</option>
                                        <option value="2" '.getselected( 2, $_POST['cfg_showtime'] ).'>rückwärts laufend</option>
									</select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Steuerungsleiste anzeigen:<br>
                                    <span class="small">Stellt den Anzeige Modus der Steuerungsleiste ein.</span>
                                </td>
                                <td class="config">
                                    <select name="cfg_showplayer" size="1">
                                        <option value="autohide" '.getselected( "autohide", $_POST['cfg_showplayer'] ).'>automatisch ausblenden</option>
                                        <option value="always" '.getselected( "always", $_POST['cfg_showplayer'] ).'>immer anzeigen</option>
                                        <option value="never" '.getselected( "never", $_POST['cfg_showplayer'] ).'>nicht anzeigen</option>
									</select>
                                </td>
                            </tr>
       						<tr>
           						<td class="config">
               						Ausblend-Zeit:<br>
               						<span class="small">Zeit in Millisekunden bevor die Steuerungsleiste ausgeblendet wird.</span>
           						</td>
           						<td class="config">
             						<input class="text" name="cfg_playertimeout" size="6" maxlength="6" value="'.$_POST['cfg_playertimeout'].'"> Millisekunden
           						</td>
       						</tr>
                            <tr>
                                <td class="config">
                                    Ladebalken anzeigen:<br>
                                    <span class="small">Stellt den Anzeige Modus des Ladebalkens ein.</span>
                                </td>
                                <td class="config">
                                    <select name="cfg_showloading" size="1">
                                        <option value="autohide" '.getselected( "autohide", $_POST['cfg_showloading'] ).'>automatisch ausblenden</option>
                                        <option value="always" '.getselected( "always", $_POST['cfg_showloading'] ).'>immer anzeigen</option>
                                        <option value="never" '.getselected( "never", $_POST['cfg_showloading'] ).'>nicht anzeigen</option>
									</select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Vollbild-Button anzeigen:<br>
                                    <span class="small">Zeigt den Vollbild-Button auf der Steuerungsleiste an.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_showfullscreen" value="1" '.getchecked ( 1, $_POST['cfg_showfullscreen'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="4">Farben der Steuerungsleiste</td></tr>
       						<tr>
           						<td class="config">
               						Farbe der Steuerungsleiste:<br>
               						<span class="small">Die Hintergundfarbe der Steuerungsleiste.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_playercolor" size="6" maxlength="6" value="'.$_POST['cfg_playercolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Deckkraft der Steuerungsleiste:<br>
               						<span class="small">Die Deckkraft der Steuerungsleiste in Prozent.</span>
           						</td>
           						<td class="config">
             						<input class="text" name="cfg_playeralpha" size="3" maxlength="3" value="'.$_POST['cfg_playeralpha'].'"> %
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Farbe des Ladebalkens:<br>
               						<span class="small">Die Farbe des Ladebalkens.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_loadingcolor" size="6" maxlength="6" value="'.$_POST['cfg_loadingcolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Farbe der Steuerungselemente:<br>
               						<span class="small">Die Farbe der angezeigten Steuerungselemente (Play, Stop, etc.).</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_buttoncolor" size="6" maxlength="6" value="'.$_POST['cfg_buttoncolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Hover-Farbe der Steuerungselemente:<br>
               						<span class="small">Die Farbe der Steuerungselemente, wenn die Maus darauf zeigt.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_buttonovercolor" size="6" maxlength="6" value="'.$_POST['cfg_buttonovercolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Schiebregler-Farbe 1 (oben):<br>
               						<span class="small">Obere Farbe des Schiebregler-Farbverlaufs.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_slidercolor1" size="6" maxlength="6" value="'.$_POST['cfg_slidercolor1'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Schiebregler-Farbe 2 (unten):<br>
               						<span class="small">Untere Farbe des Schiebregler-Farbverlaufs.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_slidercolor2" size="6" maxlength="6" value="'.$_POST['cfg_slidercolor2'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Schiebregler-Hover-Farbe:<br>
               						<span class="small">Die Farbe des Schiebreglers, wenn die Maus darauf zeigt.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_sliderovercolor" size="6" maxlength="6" value="'.$_POST['cfg_sliderovercolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="4">Vorausspeicher</td></tr>
       						<tr>
           						<td class="config">
               						Länge des Vorausspeichers:<br>
               						<span class="small">Vorausspeicher des angezeigten Videos in Sekunden.</span>
           						</td>
           						<td class="config">
             						<input class="text" name="cfg_buffer" size="2" maxlength="2" value="'.$_POST['cfg_buffer'].'"> Sekunden<br>
             						<span class="small">[0 wird nicht empfohlen]</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Vorausspeicher-Nachricht: <span class="small">'.$admin_phrases[common][optional].'</span><br>
               						<span class="small">Nachricht, die während des Vorausspeicherns angezeigt wird.</span>
           						</td>
           						<td class="config">
             						<input class="text" name="cfg_buffermessage" size="40" maxlength="100" value="'.$_POST['cfg_buffermessage'].'"><br>
             						<span class="small">[<b>_n_</b> zeigt den Fortschritt in Prozent an]</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Farbe der Nachricht:<br>
               						<span class="small">Die Farbe, in der die Vorausspeicher-Nachricht angezeigt wird.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_buffercolor" size="6" maxlength="6" value="'.$_POST['cfg_buffercolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Hintergrundfarbe der Nachricht:<br>
               						<span class="small">Die Hintergrundfarbe, mit der die Vorausspeicher-Nachricht hinterlegt wird.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_bufferbgcolor" size="6" maxlength="6" value="'.$_POST['cfg_bufferbgcolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
                            <tr>
                                <td class="config">
                                    Hintergrundfarbe anzeigen:<br>
                                    <span class="small">Zeigt die Hintergrundfarbe der Vorausspeicher-Nachricht an.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_buffershowbg" value="1" '.getchecked ( 1, $_POST['cfg_buffershowbg'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="4">Video-Titel</td></tr>
       						<tr>
           						<td class="config">
               						Farbe des Titels:<br>
               						<span class="small">Die Farbe, in der der Video-Titel angezeigt wird.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_titlecolor" size="6" maxlength="6" value="'.$_POST['cfg_titlecolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Schriftgröße des Titels:<br>
               						<span class="small">Die Schriftgröße, in der der Video-Titel angezeigt wird.</span>
           						</td>
           						<td class="config">
             						<input class="text" name="cfg_titlesize" size="2" maxlength="2" value="'.$_POST['cfg_titlesize'].'"> pt<br>
             						<span class="small">[Empfohlener Wert zwischen 8pt und 26pt]</span>
           						</td>
       						</tr>
                            <tr>
                                <td class="config">
                                    Titel trotz Vorschaubild:<br>
                                    <span class="small">Zeigt den Video-Titel trotz eines Vorschaubildes an.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_showtitleandstartimage" value="1" '.getchecked ( 1, $_POST['cfg_showtitleandstartimage'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="4">Steuerung</td></tr>
							<tr>
                                <td class="config">
                                    Einfacher Mausklick:<br>
                                    <span class="small">Aktion die bei einem einfachen Mausklick durchgeführt wird.</span>
                                </td>
                                <td class="config">
                                    <select name="cfg_onclick" size="1">
                                        <option value="none" '.getselected( "none", $_POST['cfg_onclick'] ).'>keine Aktion</option>
                                        <option value="playpause" '.getselected( "playpause", $_POST['cfg_onclick'] ).'>Video anhalten/fortsetzen</option>
									</select>
                                </td>
                            </tr>
							<tr>
                                <td class="config">
                                    Doppelter Mausklick:<br>
                                    <span class="small">Aktion die bei einem doppeltem Mausklick durchgeführt wird.</span>
                                </td>
                                <td class="config">
                                    <select name="cfg_ondoubleclick" size="1">
                                        <option value="none" '.getselected( "none", $_POST['cfg_ondoubleclick'] ).'>keine Aktion</option>
                                        <option value="playpause" '.getselected( "playpause", $_POST['cfg_ondoubleclick'] ).'>Video anhalten/fortsetzen</option>
                                        <option value="fullscreen" '.getselected( "fullscreen", $_POST['cfg_ondoubleclick'] ).'>in den Vollbild-Modus wechseln</option>
									</select>
                                </td>
                            </tr>
							<tr>
                                <td class="config">
                                    Mauszeiger anzeigen:<br>
                                    <span class="small">Stellt den Anzeige Modus des Mauszeigers ein.</span>
                                </td>
                                <td class="config">
                                    <select name="cfg_showmouse" size="1">
                                        <option value="autohide" '.getselected( "autohide", $_POST['cfg_showmouse'] ).'>automatisch ausblenden</option>
                                        <option value="always" '.getselected( "always", $_POST['cfg_showmouse'] ).'>immer anzeigen</option>
                                        <option value="never" '.getselected( "never", $_POST['cfg_showmouse'] ).'>nicht anzeigen</option>
									</select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Tastaturbefehle verwenden:<br>
                                    <span class="small">Schaltet die Tastaturbefehle zur Verwendung frei.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_shortcut" value="1" '.getchecked ( 1, $_POST['cfg_shortcut'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="4">Abspiel-Symbol</td></tr>
                            <tr>
                                <td class="config">
                                    Abspiel-Symbol anzeigen:<br>
                                    <span class="small">Zeigt das Abspiel-Symbol im Player an.</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="cfg_showiconplay" value="1" '.getchecked ( 1, $_POST['cfg_showiconplay'] ).'>
                                </td>
                            </tr>
       						<tr>
           						<td class="config">
               						Farbe des Abspiel-Symbols:<br>
               						<span class="small">Die Farbe, in der das Abspiel-Symbol angezeigt wird.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_iconplaycolor" size="6" maxlength="6" value="'.$_POST['cfg_iconplaycolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Hintergundfarbe des Abspiel-Symbols:<br>
               						<span class="small">Die Hintergundfarbe, mit der das Abspiel-Symbol hinterlegt wird.</span>
           						</td>
           						<td class="configbig">
             						<b>#</b> <input class="text" name="cfg_iconplaybgcolor" size="6" maxlength="6" value="'.$_POST['cfg_iconplaybgcolor'].'"><br>
             						<span class="small">'."[Hexadezimal-Farbcode]".'</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Deckkraft des Abspiel-Symbols:<br>
               						<span class="small">Die Deckkraft des Abspiel-Symbols in Prozent.</span>
           						</td>
           						<td class="config">
             						<input class="text" name="cfg_iconplaybgalpha" size="3" maxlength="3" value="'.$_POST['cfg_iconplaybgalpha'].'"> %
           						</td>
       						</tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="4">Bild-Überlagerung</td></tr>
       						<tr>
           						<td class="config">
               						Bild-URL: <span class="small">'.$admin_phrases[common][optional].'</span><br>
               						<span class="small">URL eines Bildes, das über das Video gelegt werden soll.</span>
           						</td>
           						<td class="config">
             						<input class="text" name="cfg_top1_url" size="40" maxlength="100" value="'.$_POST['cfg_top1_url'].'">
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Horizontaler Abstand:<br>
               						<span class="small">Horizontaler Abstand (oben/unten) des Bildes zum Rahmen.</span>
           						</td>
           						<td class="config">
             						<input class="text center" name="cfg_top1_y" size="4" maxlength="4" value="'.$_POST['cfg_top1_y'].'"> Pixel<br>
             						<span class="small">[positiv: von oben; negativ: von unten]</span>
           						</td>
       						</tr>
       						<tr>
           						<td class="config">
               						Vertikaler Abstand:<br>
               						<span class="small">Vertikaler Abstand (links/rechts) des Bildes zum Rahmen.</span>
           						</td>
           						<td class="config">
             						<input class="text center" name="cfg_top1_x" size="4" maxlength="4" value="'.$_POST['cfg_top1_x'].'"> Pixel<br>
             						<span class="small">[positiv: von links; negativ: von rechts]</span>
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