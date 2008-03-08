<?php

/////////////////////////
//// News hinzufügen ////
/////////////////////////

if (
		isset ( $_POST['addnews'] ) &&
		$_POST['title'] && $_POST['title'] != "" &&
		$_POST['text'] && $_POST['text'] != "" &&
		
		$_POST['d'] && $_POST['d'] != "" && $_POST['d'] > 0 &&
		$_POST['m'] && $_POST['m'] != "" && $_POST['m'] > 0 &&
		$_POST['y'] && $_POST['y'] != "" && $_POST['y'] > 0 &&
		$_POST['h'] && $_POST['h'] != "" && $_POST['h'] >= 0 &&
		$_POST['i'] && $_POST['i'] != "" && $_POST['i'] >= 0 &&
		
		isset ( $_POST['catid'] ) &&
		isset ( $_POST['posterid'] )
	)
{
	$_POST['text'] = savesql ( $_POST['text'] );
    $_POST['title'] = savesql ( $_POST['title'] );
    
    settype ( $_POST['catid'], "integer" );
    settype ( $_POST['posterod'], "integer" );

	settype ( $_POST['d'], "integer" );
    settype ( $_POST['m'], "integer" );
    settype ( $_POST['y'], "integer" );
    settype ( $_POST['h'], "integer" );
    settype ( $_POST['i'], "integer" );
	$newsdate = mktime ( $_POST['h'], $_POST['i'], 0, $_POST['m'], $_POST['d'], $_POST['y'] );


	// News in die DB eintragen
    mysql_query("INSERT INTO ".$global_config_arr['pref']."news (cat_id, user_id, news_date, news_title, news_text)
				 VALUES ('".$_POST['catid']."',
						 '".$_POST['posterid']."',
       		             '".$newsdate."',
                         '".$_POST['title']."',
                         '".$_POST['text']."')", $db);

    // Links in die DB eintragen
    $newsid = mysql_insert_id ();
    foreach ( $_POST['linkname'] as $key => $value )
    {
        if ( $_POST['linkname'][$key] != "" && $_POST['linkurl'][$key] != "" )
        {
            $_POST['linkname'][$key] = savesql ( $_POST['linkname'][$key] );
            $_POST['linkurl'][$key] = savesql ( $_POST['linkurl'][$key] );
			switch ( $_POST['linktarget'][$key] )
    		{
        		case 1: settype ( $$_POST['linktarget'][$key], "integer" ); break;
        		default: $_POST['linktarget'][$key] = 0; break;
    		}

            mysql_query("INSERT INTO ".$global_config_arr['pref']."news_links (news_id, link_name, link_url, link_target)
                         VALUES ('".$newsid."',
                                 '".$_POST['linkname'][$key]."',
                                 '".$_POST['linkurl'][$key]."',
                                 '".$_POST['linktarget'][$key]."')", $db);
		}
    }

    mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET news = news + 1", $db );
    systext( "News wurde hinzugefügt", $admin_phrases[common][info]);
}

/////////////////////////
///// News Formular /////
/////////////////////////

else
{
    if ( isset ( $_POST['sended'] ) &&  isset ( $_POST['addnews'] ) )
    {
        systext($admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE);
    }

    // News Konfiguration lesen
    $index = mysql_query ( "SELECT html_code, fs_code FROM ".$global_config_arr['pref']."news_config", $db );
    $config_arr = mysql_fetch_assoc ( $index );
    $config_arr[html_code] = ($config_arr[html_code] == 2 OR $config_arr[html_code] == 4) ? "an" : "aus";
    $config_arr[fs_code] = ($config_arr[fs_code] == 2 OR $config_arr[fs_code] == 4) ? "an" : "aus";

	// User ID ermittlen
	if ( !isset ( $_POST['posterid'] ) )
    {
        $_POST['posterid'] = $_SESSION['user_id'];
    }

	// Sicherheitsumwandlungen
	$_POST['text'] = killhtml ( $_POST['text'] );
    $_POST['title'] = killhtml ( $_POST['title'] );
	settype ( $_POST['catid'], "integer" );
    settype ( $_POST['posterid'], "integer" );

	
    // User auslesen
    $index = mysql_query ( "SELECT user_name, user_id FROM ".$global_config_arr['pref']."user WHERE user_id = '".$_POST['posterid']."'", $db );
    $_POST['poster'] = killhtml ( mysql_result ( $index, 0, "user_name" ) );

	// Datum füllen
    if ( !isset ( $_POST['d'] ) )
    {
    	$_POST['d'] = date ( "d" );
    	$_POST['m'] = date ( "m" );
    	$_POST['y'] = date ( "Y" );
    	$_POST['h'] = date ( "H" );
    	$_POST['i'] = date ( "i" );
	} else {
		settype ( $_POST['d'], "integer" );
    	settype ( $_POST['m'], "integer" );
    	settype ( $_POST['y'], "integer" );
    	settype ( $_POST['h'], "integer" );
    	settype ( $_POST['i'], "integer" );
	}
	
    $nowbutton_array['d'] = date ( "d" );
    $nowbutton_array['m'] = date ( "m" );
    $nowbutton_array['y'] = date ( "Y" );
    $nowbutton_array['h'] = date ( "H" );
    $nowbutton_array['i'] = date ( "i" );

    echo'
					<form id="form" action="" method="post">
						<input type="hidden" value="newsadd" name="go">
                        <input type="hidden" name="sended" value="1">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$admin_phrases[news][news_information_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    Kategorie:<br>
                                    <span class="small">Die News gehört zur Kategorie</span>
                                </td>
                                <td class="config">
                                    <select name="catid">
	';
    									// Kategorien auflisten
    									$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat", $db );
    									while ( $cat_arr = mysql_fetch_assoc ( $index ) )
    									{
       										echo '<option value="'.$cat_arr['cat_id'].'"';
											if ( $_POST['catid'] == $cat_arr['cat_id'] )
        									{
            									echo ' selected="selected"';
											}
        									echo '>'.$cat_arr['cat_name'].'</option>';
    									}
	echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Datum:<br>
                                    <span class="small">Die News erscheint am</span>
                                </td>
                                <td class="config" valign="top">
									<span class="small">
										<input class="text" size="2" maxlength="2" id="d" name="d" value="'.$_POST['d'].'"> .
                                    	<input class="text" size="2" maxlength="2" id="m" name="m" value="'.$_POST['m'].'"> .
                                    	<input class="text" size="4" maxlength="4" id="y" name="y" value="'.$_POST['y'].'"> um
                                    	<input class="text" size="2" maxlength="2" id="h" name="h" value="'.$_POST['h'].'"> :
                                    	<input class="text" size="2" maxlength="2" id="i" name="i" value="'.$_POST['i'].'"> Uhr&nbsp;
									</span>
									'.js_timebutton ( $nowbutton_array, "Jetzt" ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    News Poster:<br>
                                    <span class="small">Verfasser der News</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" maxlength="100" readonly="readonly" id="username" name="poster" value="'.$_POST['poster'].'">
                                    <input type="hidden" id="userid" name="posterid" value="'.$_POST['posterid'].'">
                                    <input class="button" type="button" onClick=\'open("admin_finduser.php","Poster","width=400,height=400,screenX=50,screenY=50,scrollbars=YES")\' value="Ändern">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="2">'.$admin_phrases[news][news_new_title].'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    Titel:
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <input class="text" size="75" maxlength="255" name="title" value="'.$_POST['title'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    Text:<br>
									<span class="small">HTML ist '.$config_arr[html_code].'. FSCode ist '.$config_arr[fs_code].'.</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.create_editor ( "text", $_POST['text'], "100%", "250px", "", FALSE).'
                                </td>
                            </tr>
    ';

	// Erstellte Linkfelder ausgeben
	if ( !isset ($_POST['linkname']) )
 	{
        $_POST['linkname'][0] = "";
	}
	$linkid = 0;
	
    foreach ( $_POST['linkname'] as $key => $value )
    {
        if ( $_POST['linkname'][$key] != "" && $_POST['linkurl'][$key] != "" )
        {
			$linkid++;
			
            $link_name = killhtml ( $_POST['linkname'][$key] );

			$link_maxlenght = 60;
            $_POST['linkurl'][$key] = killhtml ( $_POST['linkurl'][$key] );
			$link_fullurl = $_POST['linkurl'][$key];
			if ( strlen ( $_POST['linkurl'][$key] ) > $link_maxlenght )
        	{
            	$_POST['linkurl'][$key] = substr ( $link_fullurl, 0, $link_maxlenght ) . "...";
        	}

			switch ( $_POST['linktarget'][$key] )
    		{
        		case 1: $link_target = "neues Fenster"; break;
        		default:
					$_POST['linktarget'][$key] = 0;
					$link_target = "gleiches Fenster";
					break;
    		}

            echo'
                            <tr>
                                <td class="config" style="padding-left: 50px;" colspan="2">
                                    <table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td class="config" style="padding-right: 4px;">
												<span class="small">&bull;</span>
											</td>
											<td class="config" width="100%">
                                     			'.$link_name.' <span class="small">('.$link_target.')</span><br>
                                    			<a href="'.$link_fullurl.'" target="_blank" title="'.$link_fullurl.'">'.$_POST['linkurl'][$key].'</a>
                                    			<input type="hidden" name="linkname['.$key.']" value="'.$link_name.'">
                                    			<input type="hidden" name="linkurl['.$key.']" value="'.$link_fullurl.'">
                                    			<input type="hidden" name="linktarget['.$key.']" value="'.$_POST['linktarget'][$key].'">
											</td>
										</tr>
									</table>
                                </td>
                            </tr>
            ';
        }
	}

    
	echo'
                            <tr><td class="space"></td></tr>
							<tr>
                                <td class="config" colspan="2">
                                    Link hinzufügen:
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td class="config" style="padding-right: 5px;">
                                                Titel:
											</td>
											<td class="config" style="padding-bottom: 4px;" width="100%">
                                                <input class="text" style="width: 100%;" maxlength="100" name="linkname['.$linkid.']">
											</td>
											<td class="config"style="padding-left: 5px;">
                                                Link öffnen in:
											</td>
										</tr>
										<tr>
											<td class="config">
                                                URL:
											</td>
											<td class="config" style="padding-bottom: 4px;">
                                                <input class="text" style="width: 100%;" maxlength="255" name="linkurl['.$linkid.']" value="http://">
											</td>
											<td class="config" style="padding-left: 5px;">
												<select name="linktarget['.$linkid.']" size="1">
                                                    <option value="0">gleiches Fenster</option>
                                                    <option value="1">neues Fenster</option>
												</select>
											</td>
											<td align="right" valign="top" style="padding-left: 10px;">
                                                <input class="button" type="submit" name="addlink" value="Hinzufügen">
											</td>
										</tr>
									</table>
								</td>
                            </tr>
 	';
            
	echo'
							<tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit" name="addnews">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>