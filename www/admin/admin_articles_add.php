<?php

/////////////////////
//// Add Article ////
/////////////////////

if (
		isset ( $_POST['articlesadd'] ) &&
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
    settype ( $_POST['posterid'], "integer" );

    $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['Y'], $_POST['H'], $_POST['i'] );
	$newsdate = mktime ( $date_arr['h'], $date_arr['i'], 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );


	// MySQL-Insert-Query
    mysql_query ("
					INSERT INTO ".$global_config_arr['pref']."news (cat_id, user_id, news_date, news_title, news_text)
					VALUES (
						'".$_POST['catid']."',
						'".$_POST['posterid']."',
						'".$newsdate."',
						'".$_POST['title']."',
						'".$_POST['text']."'
					)
	", $db );

    mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET news = news + 1", $db );
    systext( $admin_phrases[news][news_added], $admin_phrases[common][info]);
}

//////////////////////////////
//// Display Articel Form ////
//////////////////////////////

else
{

	// Display Error Messages
	if ( isset ( $_POST['sended'] ) ) {
  		systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
	}

    // Load Article Config
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_config", $db );
    $config_arr = mysql_fetch_assoc ( $index );

	// Create HTML, FSCode & Para-Handling Vars
    $config_arr[html_code_bool] = ($config_arr[html_code] == 2 || $config_arr[html_code] == 4);
    $config_arr[fs_code_bool] = ($config_arr[fs_code] == 2 || $config_arr[fs_code] == 4);
    $config_arr[para_handling_bool] = ($config_arr[para_handling] == 2 || $config_arr[para_handling] == 4);
    
    $config_arr[html_code_text] = ( $config_arr[html_code_bool] ) ? $admin_phrases[common][on] : $admin_phrases[common][off];
    $config_arr[fs_code_text] = ( $config_arr[fs_code_bool] ) ? $admin_phrases[common][on] : $admin_phrases[common][off];
    $config_arr[para_handling_text] = ( $config_arr[para_handling_bool] ) ? $admin_phrases[common][on] : $admin_phrases[common][off];

	if ( !isset ( $_POST['article_html'] ) ) {
		$_POST['article_html'] = 1;
    }
	if ( !isset ( $_POST['article_fscode'] ) ) {
		$_POST['article_fscode'] = 1;
    }
	if ( !isset ( $_POST['article_para'] ) ) {
		$_POST['article_para'] = 1;
    }
    
	// Get User ID
	if ( !isset ( $_POST['article_user'] ) ) {
		$_POST['article_user'] = $_SESSION['user_id'];
    }

	// Security-Functions
    $_POST['article_url'] = killhtml ( $_POST['article_url'] );
    $_POST['article_title'] = killhtml ( $_POST['article_title'] );
	$_POST['article_text'] = killhtml ( $_POST['article_text'] );
	settype ( $_POST['article_user'], "integer" );
    settype ( $_POST['article_html'], "integer" );
	settype ( $_POST['article_fscode'], "integer" );
    settype ( $_POST['article_para'], "integer" );
	settype ( $_POST['article_cat_id'], "integer" );

    // Get User
    $index = mysql_query ( "SELECT user_name, user_id FROM ".$global_config_arr['pref']."user WHERE user_id = '".$_POST['article_user']."'", $db );
    $_POST['article_user_name'] = killhtml ( mysql_result ( $index, 0, "user_name" ) );

	// Create Date-Arrays
    if ( !isset ( $_POST['d'] ) )
    {
    	$_POST['d'] = date ( "d" );
    	$_POST['m'] = date ( "m" );
    	$_POST['y'] = date ( "Y" );
	}
	$date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
	$nowbutton_array = array( "d", "m", "y" );

    // Display Page
    echo'
					<form action="" method="post">
						<input type="hidden" value="articlesadd" name="go">
                        <input type="hidden" name="sended" value="1">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$admin_phrases[articles][articles_info_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_url].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[articles][articles_url_desc].'</span>
                                </td>
                                <td class="config">
                                    ?go = <input class="text" size="45" maxlength="100" name="article_url" value="'.$_POST['article_url'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_cat].':<br>
                                    <span class="small">'.$admin_phrases[articles][articles_cat_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="article_cat_id">
	';
    									// Kategorien auflisten
    									$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_cat", $db );
    									while ( $cat_arr = mysql_fetch_assoc ( $index ) )
    									{
											echo '<option value="'.$cat_arr['cat_id'].'" '.getselected($cat_arr['cat_id'], $_POST['article_cat_id']).'>'.$cat_arr['cat_name'].'</option>';
    									}
	echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_date].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[articles][articles_date_desc].'</span>
                                </td>
                                <td class="config">
									<span class="small">
										<input class="text" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                    	<input class="text" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                    	<input class="text" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'">&nbsp;
									</span>
									'.js_nowbutton ( $nowbutton_array, $admin_phrases[common][today] ).'
                                    <input onClick=\'document.getElementById("d").value="";
                                                     document.getElementById("m").value="";
                                                     document.getElementById("y").value="";\' class="button" type="button" value="Löschen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_poster].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[articles][articles_poster_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="30" maxlength="100" readonly="readonly" id="username" name="article_user_name" value="'.$_POST['article_user_name'].'">
                                    <input type="hidden" id="userid" name="article_user" value="'.$_POST['article_user'].'">
                                    <input class="button" type="button" onClick=\''.openpopup ( "admin_finduser.php", 400, 400 ).'\' value="'.$admin_phrases[common][change_button].'">
                                    <input onClick=\'document.getElementById("username").value="";
                                                     document.getElementById("userid").value="0";\' class="button" type="button" value="Löschen">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="2">'.$admin_phrases[articles][articles_new_title].'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[articles][articles_title].':
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <input class="text" size="75" maxlength="255" name="article_title" value="'.$_POST['article_title'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[articles][articles_text].':<br>
									<span class="small">'.
									$admin_phrases[common][html].' '.$config_arr[html_code_text].'. '.
									$admin_phrases[common][fscode].' '.$config_arr[fs_code_text].'. '.
									$admin_phrases[common][para].' '.$config_arr[para_handling_text].'.</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
	';
	
	if ( $config_arr[html_code_bool] ) {
	    echo '<input type="checkbox" name="article_html" value="1" '.getchecked ( 1, $_POST['article_html'] ).'> HTML dekativieren';
	}
	if ( $config_arr[fs_code_bool] ) {
	    echo '<input type="checkbox" name="article_fscode" value="1" '.getchecked ( 1, $_POST['article_fscode'] ).'> FSCode dekativieren';
	}
	if ( $config_arr[para_handling_bool] ) {
	    echo '<input type="checkbox" name="article_para" value="1" '.getchecked ( 1, $_POST['article_para'] ).'> Absatzbehandlung dekativieren';
	}
	
	echo '
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.create_editor ( "article_text", $_POST['article_text'], "100%", "500px", "", FALSE).'
                                </td>
                            </tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[articles][articles_add_button].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>

<?php

/////////////////////////////////////
//// Artikel in die DB schreiben ////
/////////////////////////////////////

if ($_POST[url] && $_POST[title] && $_POST[text] && $_POST[cat_id])
{
    if ($_POST[tag] && $_POST[monat] && $_POST[jahr])  // Datum überprüfen
    {
       $date = mktime(0, 0, 0, $_POST[monat], $_POST[tag], $_POST[jahr]);
    }
    else
    {
        $date = 0;
    }

    $_POST[url] = savesql($_POST[url]);
    $index = mysql_query("SELECT artikel_url FROM ".$global_config_arr[pref]."artikel WHERE artikel_url = '$_POST[url]'");
    if (mysql_num_rows($index) == 0)
    {
        $_POST[title] = savesql($_POST[title]);
        $_POST[text] = savesql($_POST[text]);
        settype($_POST[cat_id], 'integer');
        settype($_POST[posterid], 'integer');
        $_POST[search] = isset($_POST[search]) ? 1 : 0;
        $_POST[fscode] = isset($_POST[fscode]) ? 1 : 0;

        mysql_query("INSERT INTO ".$global_config_arr[pref]."artikel
                     VALUES (NULL,
                             '$_POST[url]',
                             '$_POST[title]',
                             '$date',
                             '$_POST[posterid]',
                             '$_POST[text]',
                             '$_POST[search]',
                             '$_POST[fscode]',
                             '$_POST[cat_id]');", $db);
        mysql_query("UPDATE ".$global_config_arr[pref]."counter SET artikel = artikel + 1", $db);
        systext("Artikel wurde gespeichert");
    }
    else
    {
        systext("Diese Artikel URL exitiert bereits");
    }
}

/////////////////////////////////////
///////// Artikel Formular //////////
/////////////////////////////////////

else
{
    //Datum-Array für Heute Button
    $heute[tag] = date("d");
    $heute[monat] = date("m");
    $heute[jahr] = date("Y");
    
    //Poster Name für Anzeige bei fehlenden Daten
    if ($_POST[posterid])
    {
      $index = mysql_query("SELECT user_name FROM ".$global_config_arr[pref]."user WHERE user_id = '$_POST[posterid]'", $db);
      $dbusername = mysql_result($index, 0, "user_name");
    }

    if (!isset($_POST['sended']))
    {
      $_POST['search'] =  1;
    }
    // Suchindex
    $dbartikelindex = ($_POST['search'] == 1) ? "checked" : "";

    if (!isset($_POST['sended']))
    {
      $_POST['fscode'] =  1;
    }
    // verwendet fs code
    $dbartikelfscode = ($_POST['fscode'] == 1) ? "checked" : "";
    
    // category id
	$cats_options = '';
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."artikel_cat", $db);
    
    while ($arr = mysql_fetch_assoc($index)) {
	    $cats_options .= '<option value="'.$arr[cat_id].'">'.$arr[cat_name].'</option>';
    }

    echo'
                    <form id="send1" action="" method="post">
                        <input type="hidden" value="artikeladd" name="go">
                        <input type="hidden" value="" name="sended">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    FS-Code:<br>
                                    <font class="small">FS-Code in diesem Artikel aktivieren</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="fscode" '.$dbartikelfscode.'>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="button" type="button" value="Vorschau" onClick="javascript:open(\'about:blank\',\'prev\',\'width=700,height=710,screenX=0,screenY=0,scrollbars=yes\'); document.getElementById(\'send1\').action=\'admin_artikelprev.php\'; document.getElementById(\'send1\').target=\'prev\'; document.getElementById(\'send1\').submit();">
                                    <input class="button" type="button" value="Absenden" onClick="javascript:document.getElementById(\'send1\').target=\'_self\'; document.getElementById(\'send1\').action=\'\'; document.getElementById(\'send1\').submit();">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>