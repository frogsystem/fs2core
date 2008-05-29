<?php

////////////////////////////
//// News aktualisieren ////
////////////////////////////

if ($_POST[newsedit]
    && ($_POST[title]!="")
    && ($_POST[text]!="")

    && ($_POST[stunde]!="")
    && ($_POST[min]!="")
    && ($_POST[monat]!="" AND $_POST[monat]!=0)
    && ($_POST[tag]!="" AND $_POST[tag]!=0)
    && ($_POST[jahr]!="" AND $_POST[jahr]!=0)
   )
{
    settype($_POST[enewsid], 'integer');

    if (isset($_POST[delnews]))
    {
        mysql_query("DELETE FROM ".$global_config_arr[pref]."news WHERE news_id = '$_POST[enewsid]'", $db);
        mysql_query("DELETE FROM ".$global_config_arr[pref]."news_comments WHERE news_id = '$_POST[enewsid]'", $db);
        $numcomments = mysql_affected_rows();
        mysql_query("DELETE FROM ".$global_config_arr[pref]."news_links WHERE news_id = '$_POST[enewsid]'", $db);
        mysql_query("UPDATE ".$global_config_arr[pref]."counter SET news = news - 1", $db);
        mysql_query("UPDATE ".$global_config_arr[pref]."counter SET comments = comments - $numcomments", $db);
        systext("Die News wurde gelöscht");
    }
    else
    {
        settype($_POST[cat_id], 'integer');
        settype($_POST[posterid], 'integer');
        $_POST[title] = savesql($_POST[title]);
        $_POST[text] = addslashes($_POST[text]);

        $newsdate = mktime($_POST[stunde], $_POST[min], 0, $_POST[monat], $_POST[tag], $_POST[jahr]);

        // News in der DB aktualisieren
        $update = "UPDATE ".$global_config_arr[pref]."news
                   SET cat_id       = '$_POST[cat_id]',
                       user_id      = '$_POST[posterid]',
                       news_date    = '$newsdate',
                       news_title   = '$_POST[title]',
                       news_text    = '$_POST[text]'
                   WHERE news_id = $_POST[enewsid]";
        mysql_query($update, $db);

        // Links in der DB aktualisieren
        for ($i=0; $i<count($_POST[linkname]); $i++)
        {
            $_POST[linktarget][$i] = isset($_POST[linktarget][$i]) ? 1 : 0;

            // Link löschen
            if (isset($_POST[dellink][$i]))
            {
                settype($_POST[dellink][$i], 'integer');
                mysql_query("DELETE FROM ".$global_config_arr[pref]."news_links WHERE link_id = " . $_POST[dellink][$i], $db);
            }
            else
            {
                $_POST[linkname][$i] = savesql($_POST[linkname][$i]);
                $_POST[linkurl][$i] = savesql($_POST[linkurl][$i]);
                settype($_POST[linkid][$i], "integer");

                // Link erzeugen
                if (!$_POST[linkid][$i] && $_POST[linkname][$i])
                {
                    mysql_query("INSERT INTO ".$global_config_arr[pref]."news_links (news_id, link_name, link_url, link_target)
                                 VALUES ('".$_POST[enewsid]."',
                                         '".$_POST[linkname][$i]."',
                                         '".$_POST[linkurl][$i]."',
                                         '".$_POST[linktarget][$i]."');", $db);
                }
                // Link aktualisieren
                else
                {
                    $update = "UPDATE ".$global_config_arr[pref]."news_links
                               SET link_name   = '".$_POST[linkname][$i]."',
                                   link_url    = '".$_POST[linkurl][$i]."',
                                   link_target = '".$_POST[linktarget][$i]."'
                               WHERE link_id = ".$_POST[linkid][$i];
                    mysql_query($update, $db);
                }
            }
        }
        systext("Die News wurde editiert");
    }
}

///////////////////////////////
//// Display Action-Pages  ////
///////////////////////////////
elseif ( $_POST['news_id'] && $_POST['news_action'] )
{
	// Edit News
	if ( $_POST['news_action'] == "edit" )
	{
	    //Load News
	    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news WHERE news_id = '".$_POST['news_id']."' LIMIT 0, 1", $db );
		$news_arr = mysql_fetch_assoc ( $index );
	
		// Sended or Link Action
     	if ( isset ( $_POST['sended'] ) )
	    {
            $news_arr = getfrompost ( $news_arr );
	     	if ( isset ( $_POST['editnews'] ) )
		    {
		        systext($admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE);
		    }
	    }

	    // News Konfiguration lesen
	    $index = mysql_query ( "SELECT html_code, fs_code FROM ".$global_config_arr['pref']."news_config", $db );
	    $config_arr = mysql_fetch_assoc ( $index );
	    $config_arr[html_code] = ($config_arr[html_code] == 2 OR $config_arr[html_code] == 4) ? $admin_phrases[common][on] : $admin_phrases[common][off];
	    $config_arr[fs_code] = ($config_arr[fs_code] == 2 OR $config_arr[fs_code] == 4) ? $admin_phrases[common][on] : $admin_phrases[common][off];
	    $config_arr[para_handling] = ($config_arr[para_handling] == 2 OR $config_arr[para_handling] == 4) ? $admin_phrases[common][on] : $admin_phrases[common][off];

		// User ID ermittlen
		if ( !isset ( $news_arr['user_id'] ) )
	    {
	        $news_arr['user_id'] = $_SESSION['user_id'];
	    }

		// Security-Functions
		$news_arr['news_text'] = killhtml ( $news_arr['news_text'] );
	    $news_arr['news_title'] = killhtml ( $news_arr['news_title'] );
		settype ( $news_arr['cat_id'], "integer" );
	    settype ( $news_arr['user_id'], "integer" );

	    // Get User
	    $index = mysql_query ( "SELECT user_name, user_id FROM ".$global_config_arr['pref']."user WHERE user_id = '".$news_arr['user_id']."'", $db );
	    $news_arr['poster'] = killhtml ( mysql_result ( $index, 0, "user_name" ) );

		// Create Date-Arrays
	    if ( !isset ( $_POST['d'] ) )
	    {
	    	$_POST['d'] = date ( "d", $news_arr['news_date'] );
	    	$_POST['m'] = date ( "m", $news_arr['news_date'] );
	    	$_POST['y'] = date ( "Y", $news_arr['news_date'] );
	    	$_POST['h'] = date ( "H", $news_arr['news_date'] );
	    	$_POST['i'] = date ( "i", $news_arr['news_date'] );
		}
		$date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'], $_POST['h'], $_POST['i'] );
		$nowbutton_array = array( "d", "m", "y", "h", "i" );

	    // Display Page
	    echo'
					<form action="" method="post">
						<input type="hidden" name="go" value="newsedit">
						<input type="hidden" name="news_action" value="edit">
						<input type="hidden" name="news_id" value="'.$news_arr['news_id'].'">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$admin_phrases[news][news_information_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][news_cat].':<br>
                                    <span class="small">'.$admin_phrases[news][news_cat_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="cat_id">
		';
    									// Kategorien auflisten
    									$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat", $db );
    									while ( $cat_arr = mysql_fetch_assoc ( $index ) )
    									{
											echo '<option value="'.$cat_arr['cat_id'].'" '.getselected($cat_arr['cat_id'], $news_arr['cat_id']).'>'.$cat_arr['cat_name'].'</option>';
    									}
		echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][news_date].':<br>
                                    <span class="small">'.$admin_phrases[news][news_date_desc].'</span>
                                </td>
                                <td class="config" valign="top">
									<span class="small">
										<input class="text" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                    	<input class="text" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                    	<input class="text" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'"> '.$admin_phrases[common][at].'
                                    	<input class="text" size="3" maxlength="2" id="h" name="h" value="'.$date_arr['h'].'"> :
                                    	<input class="text" size="3" maxlength="2" id="i" name="i" value="'.$date_arr['i'].'"> '.$admin_phrases[common][time_appendix].'&nbsp;
									</span>
									'.js_nowbutton ( $nowbutton_array, $admin_phrases[common][now_button] ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[news][news_poster].':<br>
                                    <span class="small">'.$admin_phrases[news][news_poster_desc].'</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" maxlength="100" readonly="readonly" id="username" name="poster" value="'.$news_arr['poster'].'">
                                    <input type="hidden" id="userid" name="user_id" value="'.$news_arr['user_id'].'">
                                    <input class="button" type="button" onClick=\''.openpopup ( "admin_finduser.php", 400, 400 ).'\' value="'.$admin_phrases[common][change_button].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="2">'.$admin_phrases[news][news_new_title].'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[news][news_title].':
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <input class="text" size="75" maxlength="255" name="news_title" value="'.$news_arr['news_title'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[news][news_text].':<br>
									<span class="small">'.
									$admin_phrases[common][html].' '.$config_arr[html_code].'. '.
									$admin_phrases[common][fscode].' '.$config_arr[fs_code].'. '.
									$admin_phrases[common][para].' '.$config_arr[para_handling].'.</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.create_editor ( "news_text", $news_arr['news_text'], "100%", "250px", "", FALSE).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <table cellpadding="0" cellspacing="0" width="100%">
	    ';
	    
		// Load Links from DB
     	if ( !isset ( $_POST['sended'] ) )
	    {
			$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_links WHERE news_id = '".$news_arr['news_id']."' ORDER BY link_id ASC", $db );
			while ( $link_arr = mysql_fetch_assoc ( $index ) ) {
	            $_POST['linkname'][] = $link_arr['link_name'];
	  			$_POST['linkurl'][] = $link_arr['link_url'];
	            $_POST['linktarget'][] = $link_arr['link_target'];
			}
		}
		
		//Zu löschende Links löschen
		if ( isset ( $_POST['sended'] ) &&  isset ( $_POST['dolinkbutton'] ) && $_POST['do_links'] == "del" && count ( $_POST['dolink'] ) > 0 )
		{
			foreach ( $_POST['dolink'] as $key => $value )
	    	{
				if ( $value == 1 )
				{
					$_POST['linkname'][$key] = "";
	    	    	$_POST['linkurl'][$key] = "";
	    	    	$_POST['linktarget'][$key] = "";
				}
	    	}
		}

		//Links nach oben verschieben
		if ( isset ( $_POST['sended'] ) &&  isset ( $_POST['dolinkbutton'] ) && $_POST['do_links'] == "up" && count ( $_POST['dolink'] ) > 0 )
		{
			foreach ( $_POST['dolink'] as $key => $value )
	    	{
				if ( $value == 1 && $key != 0 )
				{
					$up_name = $_POST['linkname'][$key];
	    	    	$up_url = $_POST['linkurl'][$key];
	    	    	$up_target = $_POST['linktarget'][$key];
	    	    	$_POST['linkname'][$key] = $_POST['linkname'][$key-1];
	    	    	$_POST['linkurl'][$key] = $_POST['linkurl'][$key-1];
	    	    	$_POST['linktarget'][$key] = $_POST['linktarget'][$key-1];
	    	    	$_POST['linkname'][$key-1] = $up_name;
	    	    	$_POST['linkurl'][$key-1] = $up_url;
	    	    	$_POST['linktarget'][$key-1] = $up_target;
				}
	    	}
		}

		//Links nach unten verschieben
		if ( isset ( $_POST['sended'] ) &&  isset ( $_POST['dolinkbutton'] ) && $_POST['do_links'] == "down" && count ( $_POST['dolink'] ) > 0 )
		{
			foreach ( $_POST['dolink'] as $key => $value )
	    	{
				if ( $value == 1 && $key != count ( $_POST['linkname'] ) - 1 )
				{
					$down_name = $_POST['linkname'][$key];
	    	    	$down_url = $_POST['linkurl'][$key];
	    	    	$down_target = $_POST['linktarget'][$key];
	    	    	$_POST['linkname'][$key] = $_POST['linkname'][$key+1];
	    	    	$_POST['linkurl'][$key] = $_POST['linkurl'][$key+1];
	    	    	$_POST['linktarget'][$key] = $_POST['linktarget'][$key+1];
	    	    	$_POST['linkname'][$key+1] = $down_name;
	    	    	$_POST['linkurl'][$key+1] = $down_url;
	    	    	$_POST['linktarget'][$key+1] = $down_target;
				}
	    	}
		}

		//Zu bearbeitende Links löschen & Daten sichern
		unset ( $edit_name );
		unset ( $edit_url );
		unset ( $edit_target );

		if ( isset ( $_POST['sended'] ) &&  isset ( $_POST['dolinkbutton'] ) && $_POST['do_links'] == "edit" && count ( $_POST['dolink'] ) > 0 )
		{
			foreach ( $_POST['dolink'] as $key => $value )
	    	{
				if ( $value == 1 )
				{
					$edit_name = $_POST['linkname'][$key];
	    	    	$edit_url = $_POST['linkurl'][$key];
	    	    	$edit_target = $_POST['linktarget'][$key];
					$_POST['linkname'][$key] = "";
	    	    	$_POST['linkurl'][$key] = "";
	    	    	$_POST['linktarget'][$key] = "";
				}
	    	}
		}

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
				$counter = $linkid + 1;

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
	        		case 1: $link_target = $admin_phrases[news][news_link_blank]; break;
	        		default:
						$_POST['linktarget'][$key] = 0;
						$link_target = $admin_phrases[news][news_link_self];
						break;
	    		}

	            echo'
        								<tr style="cursor:pointer;"
	onmouseover=\'
		colorOver (document.getElementById("input_'.$linkid.'"), "#EEEEEE", "#64DC6A", this);\'
	onmouseout=\'
		colorOut (document.getElementById("input_'.$linkid.'"), "transparent", "#49c24f", this);\'
	onClick=\'
		createClick (document.getElementById("input_'.$linkid.'"));
		resetUnclicked ("transparent", last, lastBox, this);
		colorClick (document.getElementById("input_'.$linkid.'"), "#EEEEEE", "#64DC6A", this);\'
                            			>
											<td class="config" style="padding-left: 7px; padding-right: 7px; padding-bottom: 2px; padding-top: 2px;">
												#'.$counter.'
											</td>
											<td class="config" width="100%" style="padding-right: 5px; padding-bottom: 2px; padding-top: 2px;">
                                     			'.$link_name.' <span class="small">('.$link_target.')</span><br>
                                    			<a href="'.$link_fullurl.'" target="_blank" title="'.$link_fullurl.'">'.$_POST['linkurl'][$key].'</a>
                                    			<input type="hidden" name="linkname['.$linkid.']" value="'.$link_name.'">
                                    			<input type="hidden" name="linkurl['.$linkid.']" value="'.$link_fullurl.'">
                                    			<input type="hidden" name="linktarget['.$linkid.']" value="'.$_POST['linktarget'][$key].'">
											</td>

                                			<td align="center">
                                                <input type="radio" name="dolink['.$linkid.']" id="input_'.$linkid.'" value="1" style="cursor:pointer;" onClick=\'createClick(this);\'>
											</td>
										</tr>
	            ';
				$linkid++;
	        }
		}

		if ( $linkid > 0 )
		{
			echo'
										<tr valign="top">
											<td style="padding-right: 5px; padding-top: 11px;" align="right" colspan="2">
											    <select name="do_links" size="1">
                                                    <option value="0">'.$admin_phrases[news][news_link_no].'</option>
                                                    <option value="del">'.$admin_phrases[news][news_link_delete].'</option>
                                                    <option value="up">'.$admin_phrases[news][news_link_up].'</option>
                                                    <option value="down">'.$admin_phrases[news][news_link_down].'</option>
													<option value="edit">'.$admin_phrases[news][news_link_edit].'</option>
												</select>
											</td>
											<td style="padding-top: 11px;" align="center">
                                                <input class="button" type="submit" name="dolinkbutton" value="'.$admin_phrases[common][do_button].'">
											</td>
										</tr>
			';
		}

		if ( $edit_url == "" ) {
	    	$edit_url = "http://";
		}

		echo'
									</table>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
							<tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[news][news_link_add].':
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td class="config" style="padding-right: 5px;">
                                                '.$admin_phrases[news][news_link_title].':
											</td>
											<td class="config" style="padding-bottom: 4px;" width="100%">
                                                <input class="text" style="width: 100%;" maxlength="100" name="linkname['.$linkid.']" value="'.$edit_name.'">
											</td>
											<td class="config"style="padding-left: 5px;">
                                                '.$admin_phrases[news][news_link_open].':
											</td>
										</tr>
										<tr>
											<td class="config">
                                                '.$admin_phrases[news][news_link_url].':
											</td>
											<td class="config" style="padding-bottom: 4px;">
                                                <input class="text" style="width: 100%;" maxlength="255" name="linkurl['.$linkid.']" value="'.$edit_url.'">
											</td>
											<td style="padding-left: 5px;" valign="top">
												<select name="linktarget['.$linkid.']" size="1">
                                                    <option value="0" '.getselected(0, $edit_target).'>'.$admin_phrases[news][news_link_self].'</option>
                                                    <option value="1" '.getselected(1, $edit_target).'>'.$admin_phrases[news][news_link_blank].'</option>
												</select>
											</td>
											<td align="right" valign="top" style="padding-left: 10px;">
                                                <input class="button" type="submit" name="addlink" value="'.$admin_phrases[common][add_button].'">
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
                                    <button class="button_new" type="submit" name="editnews">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[news][news_add_button].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
	    ';

	}

	// Delete News
	elseif ( $_POST['news_action'] == "delete" )
	{
		$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news WHERE news_id = '".$_POST['news_id']."'", $db );
		$news_arr = mysql_fetch_assoc ( $index );
		
		$news_arr['news_date_formated'] = "am <b>" . date ( "d.m.Y" , $news_arr['news_date'] ) . "</b> um <b>" . date ( "H:i" , $news_arr['news_date'] );
        $news_arr['news_text_short'] = killfs ( truncate_string ( $news_arr['news_text'], 250, "..." ) );

        $index2 = mysql_query("SELECT COUNT(comment_id) AS 'number' FROM ".$global_config_arr['pref']."news_comments WHERE news_id = ".$news_arr['news_id']."", $db );
        $news_arr['num_comments'] = mysql_result ( $index2, 0, "number" );

        $index2 = mysql_query("SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$news_arr['user_id']."", $db );
        $news_arr['user_name'] = mysql_result ( $index2, 0, "user_name" );

		$index2 = mysql_query("SELECT cat_name FROM ".$global_config_arr['pref']."news_cat WHERE cat_id = ".$news_arr['cat_id']."", $db );
        $news_arr['cat_name'] = mysql_result ( $index2, 0, "cat_name" );
		
		echo '
					<form action="" method="post">
						<input type="hidden" name="sended" value="delete">
						<input type="hidden" name="news_action" value="'.$_POST['news_action'].'">
						<input type="hidden" name="news_id" value="'.$news_arr['news_id'].'">
						<input type="hidden" name="go" value="newsedit">
						<input type="hidden" name="PHPSESSID" value="'.session_id().'">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line">News löschen</td></tr>
							<tr>
                                <td class="config">
                                    '.$news_arr['news_title'].' <span class="small">(#'.$news_arr['news_id'].')</span><br>
                                    <span class="small">gepostet von <b>'.$news_arr['user_name'].'</b>
									'.$news_arr['news_date_formated'].' Uhr</b>
									in <b>'.$news_arr['cat_name'].'</b>,
									<b>'.$news_arr['num_comments'].'</b> Kommentare</span><br><br>
                                    <div class="small justify">'.$news_arr['news_text_short'].'</div>
									<div class="right"><a href="'.$global_config_arr['virtualhost'].'?go=comments&id='.$news_arr['news_id'].'" target="_blank">» News komplett betrachten</a></div>
                                </td>
                            </tr>
							<tr><td class="space"></td></tr>
						</table>
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr>
								<td class="config" style="width: 100%;">
									Soll diese News (inklusive Links und Kommentaren) wirklich gelöscht werden:
								</td>
								<td class="config right top" style="padding: 0px;">
		    						<table width="100%" cellpadding="4" cellspacing="0">
										<tr class="bottom pointer" id="tr_yes"
											onmouseover="'.color_list_entry ( "del_yes", "#EEEEEE", "#64DC6A", "this" ).'"
											onmouseout="'.color_list_entry ( "del_yes", "transparent", "#49C24f", "this" ).'"
											onclick="'.color_click_entry ( "del_yes", "#EEEEEE", "#64DC6A", "this", TRUE ).'"
										>
											<td>
												<input class="pointer" type="radio" name="news_delete" id="del_yes" value="1"
                                                    onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_yes", TRUE ).'"
												>
											</td>
											<td class="config middle">
												'.$admin_phrases[common][yes].'
											</td>
										</tr>
										<tr class="bottom red pointer" id="tr_no"
											onmouseover="'.color_list_entry ( "del_no", "#EEEEEE", "#DE5B5B", "this" ).'"
											onmouseout="'.color_list_entry ( "del_no", "transparent", "#C24949", "this" ).'"
											onclick="'.color_click_entry ( "del_no", "#EEEEEE", "#DE5B5B", "this", TRUE ).'"
										>
											<td>
												<input class="pointer" type="radio" name="news_delete" id="del_no" value="0" checked="checked"
                                                    onclick="'.color_click_entry ( "this", "#EEEEEE", "#DE5B5B", "tr_no", TRUE ).'"
												>
											</td>
											<td class="config middle">
												'.$admin_phrases[common][no].'
											</td>
										</tr>
										'.color_pre_selected ( "del_no", "tr_no" ).'
									</table>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="2">
									<button class="button_new" type="submit">
										'.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
									</button>
								</td>
							</tr>
						</table>
					</form>
		';
	}
	
	// Edit Comments
	elseif ( $_POST['news_action'] == "comments" )
	{

		// Comments Header
		echo '
					<form action="" method="post">
						<input type="hidden" name="sended" value="comment">
						<input type="hidden" name="news_action" value="'.$_POST['news_action'].'">
						<input type="hidden" name="news_id" value="'.$_POST['news_id'].'">
						<input type="hidden" name="go" value="newscomments">
						<input type="hidden" name="PHPSESSID" value="'.session_id().'">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="4">Kommentare bearbeiten</td></tr>
                            <tr>
                                <td class="config" width="35%">
                                    Titel
                                </td>
                                <td class="config" width="25%">
                                    Poster
                                </td>
                                <td class="config" width="25%">
                                    Datum
                                </td>
                                <td class="config center" width="15%">
									Auswahl
                                </td>
                            </tr>

		';

		// Get Number of Comments
  		$index = mysql_query ( "SELECT COUNT(comment_id) AS 'number' FROM ".$global_config_arr['pref']."news_comments WHERE news_id = ".$_POST['news_id']."", $db );
  		$number = mysql_result ( $index, 0, "number" );

  		if ( $number >= 1 ) {
			$index = mysql_query ( "
									SELECT *
									FROM ".$global_config_arr['pref']."news_comments
									WHERE news_id = ".$_POST['news_id']."
									ORDER BY comment_date DESC
			", $db);
			
			// Display Comment-List
			while ( $comment_arr = mysql_fetch_assoc ( $index ) ) {

				// Get other Data
				if ( $comment_arr['comment_poster_id'] != 0 ) {
					$index2 = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$comment_arr['comment_poster_id']."", $db );
					$comment_arr['comment_poster'] = mysql_result ( $index2, 0, "user_name" );
				}
				$comment_arr['comment_date_formated'] = date ( "d.m.Y" , $comment_arr['comment_date'] ) . " um " . date ( "H:i" , $comment_arr['comment_date'] );
				
				echo'
							<tr class="pointer" id="tr_'.$comment_arr['comment_id'].'"
								onmouseover="'.color_list_entry ( "input_".$comment_arr['comment_id'], "#EEEEEE", "#64DC6A", "this" ).'"
								onmouseout="'.color_list_entry ( "input_".$comment_arr['comment_id'], "transparent", "#49c24f", "this" ).'"
                                onclick="'.color_click_entry ( "input_".$comment_arr['comment_id'], "#EEEEEE", "#64DC6A", "this", TRUE ).'"
							>
								<td class="configthin">
								    '.$comment_arr['comment_title'].'
								</td>
								<td class="config">
								    <span class="small">'.$comment_arr['comment_poster'].'</span>
								</td>
								<td class="config">
								    <span class="small">'.$comment_arr['comment_date_formated'].'</span>
								</td>
								<td class="config center">
                                    <input class="pointer" type="radio" name="comment_id" id="input_'.$comment_arr['comment_id'].'" value="'.$comment_arr['comment_id'].'"
										onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$comment_arr['comment_id'], TRUE ).'"
									>
								</td>
							</tr>
				';
				        
			}
		}

		// Footer
		echo'
                            <tr><td class="space"></td></tr>
							<tr>
								<td class="right" colspan="4">
									<select name="comment_action" size="1">
										<option value="edit">'.$admin_phrases[common][selection_edit].'</option>
										<option value="delete">'.$admin_phrases[common][selection_del].'</option>
									</select>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="4">
									<button class="button_new" type="submit">
										'.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
									</button>
								</td>
							</tr>
						</table>
					</form>
		';
	}
}

////////////////////////////////////////
//// Display Default News List Page ////
////////////////////////////////////////
else
{
	// Set Default Filter Data
    if ( !isset ( $_REQUEST['order'] ) ) { $_REQUEST['order'] = "news_date"; }
    if ( !isset ( $_REQUEST['sort'] ) ) { $_REQUEST['sort'] = "DESC"; }
    if ( !isset ( $_REQUEST['cat_id'] ) ) { $_REQUEST['cat_id'] = 0; }
    
    // Security Functions for Filter Data
    $_REQUEST['order'] = savesql ( $_REQUEST['order'] );
    $_REQUEST['sort'] = savesql ( $_REQUEST['sort'] );
    settype ( $_REQUEST['cat_id'], 'integer' );

	// Display Filter Data Form
    echo'
					<form action="?mid=content&go=newsedit" method="post">
                        <input type="hidden" value="newsedit" name="go">

                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="3">Filter & Sortierung</td></tr>
							<tr>
                                <td class="config" width="100%" colspan="2">
									News aus
                                    <select name="cat_id">
                                    	<option value="0" '.getselected( 0, $_REQUEST['cat_id'] ).'>allen Kategorien</option>
	';
    									// List Categories
    									$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat", $db );
    									while ( $cat_arr = mysql_fetch_assoc ( $index ) )
    									{
											echo '<option value="'.$cat_arr['cat_id'].'" '.getselected( $cat_arr['cat_id'], $_REQUEST['cat_id'] ).'>'.$cat_arr['cat_name'].'</option>';
    									}
	echo'
                                    </select>
									und sortieren nach
                                    <select name="order">
                                        <option value="news_id" '.getselected ( "news_id", $_REQUEST['order'] ).'>News-ID</option>
                                        <option value="news_date" '.getselected ( "news_date", $_REQUEST['order'] ).'>Datum</option>
                                        <option value="news_title" '.getselected ( "news_title", $_REQUEST['order'] ).'>Titel</option>
                                    </select>,
                                    <select name="sort">
                                        <option value="ASC" '.getselected ( "ASC", $_REQUEST['sort'] ).'>'.$admin_phrases[common][ascending].'</option>
                                        <option value="DESC" '.getselected ( "DESC", $_REQUEST['sort'] ).'>'.$admin_phrases[common][descending].'</option>
                                    </select>

                                </td>
                                <td class="right">
                                    <input type="submit" value="Anwenden" class="button">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
						</table>
					</form>
	';


	// Set Default Start Value
    if ( !isset ( $_GET['start'] ) ) { $_GET['start'] = 0; }
	settype ( $_GET['start'], 'integer' );
	$limit = 15;
	
	// Create Where Clause for Category Filter
	unset ( $where_clause );
    if ( $_REQUEST['cat_id'] != 0 )
	{
        $where_clause = "WHERE cat_id = '".$_REQUEST['cat_id']."'";
    }

	// Create Pagenavigation
    $index = mysql_query ( "
							SELECT COUNT(news_id) AS 'number'
							FROM ".$global_config_arr['pref']."news
							".$where_clause."
	", $db);
	$pagenav_arr = get_pagenav_start ( mysql_result ( $index, 0, "number" ), $limit, $_GET['start'] );
	
	// Prev & Next Page Links
    if ( $pagenav_arr['newpage_exists'] )
    {
        $next_page = '<a href="'.$PHP_SELF.'?mid=content&go=newsedit&order='.$_REQUEST['order'].'&sort='.$_REQUEST['sort'].'&cat_id='.$_REQUEST['cat_id'].'&start='.$pagenav_arr['new_start'].'">weitere News »</a>';
    }
    if ( $pagenav_arr['old_start_exists'] )
    {
        $prev_page = '<a href="'.$PHP_SELF.'?mid=content&go=newsedit&order='.$_REQUEST['order'].'&sort='.$_REQUEST['sort'].'&cat_id='.$_REQUEST['cat_id'].'&start='.$pagenav_arr['old_start'].'">« vorherige News</a>';
    }

    // Current Range
    $range_begin = $pagenav_arr['cur_start'] + 1;
    $range_end = $pagenav_arr['cur_start'] + $pagenav_arr['entries_per_page'];
	if ( $range_end > $pagenav_arr['total_entries'] )
	{
        $range_end = $pagenav_arr['total_entries'];
	}
    $range = '<span class="small">zeige News<br><b>'.$range_begin.'</b> bis <b>'.$range_end.'</b></span>';
    
    // Pagenavigation Template
    $pagenav = '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr valign="middle">
                                <td width="33%" class="configthin middle">
                                    '.$prev_page.'
                                </td>
                                <td width="33%" align="center" class="middle">
                                    '.$range.'
                                </td>
                                <td width="33%" style="text-align:right;" class="configthin middle">
                                    '.$next_page.'
                                </td>
                            </tr>
			           </table>
    ';

	// Display News List Header
    echo'
                    <form action="?mid=content&go=newsedit" method="post">
                        <input type="hidden" value="newsedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="4">News auswählen ('.$pagenav_arr['total_entries'].' Datensätze gefunden)</td></tr>

    ';
    
	// Load News From DB
	$index = mysql_query ( "
							SELECT *
							FROM ".$global_config_arr['pref']."news
							".$where_clause."
							ORDER BY ".$_REQUEST['order']." ".$_REQUEST['sort']."
							LIMIT ".$pagenav_arr['cur_start'].", ".$pagenav_arr['entries_per_page']."
	", $db);

    while ($news_arr = mysql_fetch_assoc($index))
    {
		// Get other Data
		$news_arr['news_date_formated'] = "am <b>" . date ( "d.m.Y" , $news_arr['news_date'] ) . "</b> um <b>" . date ( "H:i" , $news_arr['news_date'] ) . " Uhr</b>";
        $news_arr['news_text_short'] = killfs ( truncate_string ( $news_arr['news_text'], 250, "..." ) );
        
        $index2 = mysql_query("SELECT COUNT(comment_id) AS 'number' FROM ".$global_config_arr['pref']."news_comments WHERE news_id = ".$news_arr['news_id']."", $db );
        $news_arr['num_comments'] = mysql_result ( $index2, 0, "number" );

        $index2 = mysql_query("SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$news_arr['user_id']."", $db );
        $news_arr['user_name'] = mysql_result ( $index2, 0, "user_name" );

		$index2 = mysql_query("SELECT cat_name FROM ".$global_config_arr['pref']."news_cat WHERE cat_id = ".$news_arr['cat_id']."", $db );
        $news_arr['cat_name'] = mysql_result ( $index2, 0, "cat_name" );
        
		// Display News Entrie
		echo'
							<tr class="pointer" id="tr_'.$news_arr['news_id'].'"
								onmouseover="'.color_list_entry ( "input_".$news_arr['news_id'], "#EEEEEE", "#64DC6A", "this" ).'"
								onmouseout="'.color_list_entry ( "input_".$news_arr['news_id'], "transparent", "#49c24f", "this" ).'"
                                onclick="'.color_click_entry ( "input_".$news_arr['news_id'], "#EEEEEE", "#64DC6A", "this", TRUE ).'"
							>
                                <td class="config justify" style="width: 375px; padding-right: 25px;">
                                    #'.$news_arr['news_id'].' '.$news_arr['news_title'].'<br>
                                    <span class="small">'.$news_arr['news_text_short'].'</span>
                                </td>
                                <td class="config middle" style="width: 180x;">
                                    <span class="small">von <b>'.$news_arr['user_name'].'</b><br>
									'.$news_arr['news_date_formated'].'</b><br>
									in <b>'.$news_arr['cat_name'].'</b><br>
									<b>'.$news_arr['num_comments'].'</b> Kommentare</span>
                                </td>
                                <td class="config middle center">
                                    <input class="pointer" type="radio" name="news_id" id="input_'.$news_arr['news_id'].'" value="'.$news_arr['news_id'].'"
										onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$news_arr['news_id'], TRUE ).'"
									>
                                </td>
                            </tr>
        ';
    }
    
    // Display News List Footer
    echo'
							<tr><td class="space"></td></tr>
                        </table>
						'.$pagenav.'
           ';
    
	// End of Form & Table incl. Submit-Button
 	echo '
                      <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="space"></td></tr>
							<tr>
								<td class="right">
									<select name="news_action" size="1">
										<option value="edit">'.$admin_phrases[common][selection_edit].'</option>
										<option value="delete">'.$admin_phrases[common][selection_del].'</option>
										<option value="comments">Kommentare bearbeiten</option>
									</select>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd">
									<button class="button_new" type="submit">
										'.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
									</button>
								</td>
							</tr>
						</table>
					</form>
	';
}
?>