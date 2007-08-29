<?php
//////////////////////////
//// DB Aktualisieren ////
//////////////////////////

if ($_POST[tag] && $_POST[monat] && $_POST[jahr])
{

    if(!isset($_POST[delit]))
    {
      $datum = mktime(0, 0, 0, $_POST[monat], $_POST[tag], $_POST[jahr]);
      $_POST[url] = savesql($_POST[url]);
      $index = mysql_query("SELECT press_url FROM fs_press WHERE press_url = '$_POST[url]'");
      if ((mysql_num_rows($index) == 0) || ($_POST[oldurl] == $_POST[url]))
      {
			  $_POST[title] = savesql($_POST[title]);
    		$_POST[oldurl] = savesql($_POST[oldurl]);
    		$_POST['date'] = savesql($_POST['date']);
    		$_POST[text] = savesql($_POST[text]);
        $_POST[text] = ereg_replace ("&lt;textarea&gt;", "<textarea>", $_POST[text]); 
        $_POST[text] = ereg_replace ("&lt;/textarea&gt;", "</textarea>", $_POST[text]);
    		$_POST[lang] = savesql($_POST[lang]);
    		$_POST['game'] = savesql($_POST['game']);
    		$_POST[cat] = savesql($_POST[cat]);
    		$_POST[rating] = savesql($_POST[rating]);

        $update = "UPDATE fs_press
                     SET press_title  = '". $_POST['title'] ."',
                       press_url    = '". $_POST['url'] ."',
                       press_date  = '". $datum ."',
                       press_text   = '". $_POST['text'] ."',
                       press_lang   = '". $_POST['lang'] ."',
                       press_game  = '". $_POST['game'] ."',
                       press_cat    = '". $_POST['cat'] ."',
                       press_rating = ". (!empty($_POST['rating']) ? "'". $_POST['rating'] ."'" : 'NULL') ."
                     WHERE press_url = '". $_POST['oldurl'] ."'";
        mysql_query($update, $db);
        if ($error = mysql_error()) {
          systext('Es ist ein Fehler aufgetreten');
          echo $error;
        }
        else {
          systext("Der Artikel wurde bearbeitet.");
        }
      }
      else
      {
          systext("Der Artikel wurde nicht bearbeitet.");
      }
    }
    else
    {
      mysql_query("DELETE FROM fs_press WHERE press_url = '". $_POST['oldurl'] ."'", $db);
      systext("Der Artikel wurde gel&ouml;scht.");
    }
}

//////////////////////////
//// Update Formular /////
//////////////////////////

elseif (isset($_POST['url']))
{
    $_POST['url'] = savesql($_POST['url']);

    // Pre-, Re-, Interview aus der DB holen
    $index = mysql_query("SELECT * FROM fs_press WHERE press_url = '". $_POST['url'] ."'", $db);
    $prereinterviews_arr = mysql_fetch_assoc($index);
    $prereinterviews_arr['press_text'] = ereg_replace ("<textarea>", "&lt;textarea&gt;", $prereinterviews_arr['press_text']); 
    $prereinterviews_arr['press_text'] = ereg_replace ("</textarea>", "&lt;/textarea&gt;", $prereinterviews_arr['press_text']); 

    $prereinterviews_arr['press_text'] = stripslashes($prereinterviews_arr['press_text']);
	
	// Datum erzeugen
    if ($prereinterviews_arr['press_date'] != 0)
    {
        $nowtag = date("d", $prereinterviews_arr['press_date']);
        $nowmonat = date("m", $prereinterviews_arr['press_date']);
        $nowjahr = date("Y", $prereinterviews_arr['press_date']);
    }

    echo'
                    <form id="send1" action="'.$PHP_SELF.'" method="post" target="_self">
                        <input type="hidden" value="press_edit" name="go">
                        <input type="hidden" value="content" name="mid">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$_POST['url'].'" name="oldurl">
						
						<table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Der Name der Website. Kommt auch in den Hotlink.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$prereinterviews_arr['press_title'].'" name="title" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Link zum Artikel.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$prereinterviews_arr['press_url'].'" name="url" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Datum der Originalver&ouml;ffentlichung. Wichtig f&uuml;r die Sortierung. (TT MM JJJJ)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$nowtag.'" size="2" name="tag" maxlength="2">
                                    <input class="text" value="'.$nowmonat.'" size="2" name="monat" maxlength="2">
                                    <input class="text" value="'.$nowjahr.'" size="4" name="jahr" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Ein kurzer Auszug aus dem Artikel.</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea class="text" name="text" rows="7" cols="49">'.$prereinterviews_arr['press_text'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                              <td class="config" valign="top">
                                    Sprache:<br>
                                <font class="small">Sprache, in der der Artikel verfasst wurde.</font>
                              </td>
                              <td class="config" valign="top">
                                <table width="100%">';
    $sql = "SELECT lang_id, lang_name FROM fs_language ORDER BY lang_name";
    $result = mysql_query($sql);
    $i = 4;
    while ($arr = mysql_fetch_assoc($result)) {
      if ($i++ == 4) {
        echo '
                                    <tr>';
        $i = 0;
      }
      echo '
                                      <td><input type="radio" name="lang" value="'. $arr['lang_id'] .'"'. ($arr['lang_id'] == $prereinterviews_arr['press_lang'] ? ' checked' : '') .'>'. $arr['lang_name'] .'</td>';
      if ($i++ == 4) {
        echo '
                                    </tr>';
        $i = 4;
      }
    }

    echo '
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td class="config" valign="top">
                                    Spiel:<br>
                                    <font class="small">Spiel, auf das sich der Artikel bezieht.</font>
                              </td>
                              <td class="config" valign="top">
                                <table width="100%">
                                ';
    $sql = "SELECT game_id, game_name FROM fs_game ORDER BY game_name";
    $result = mysql_query($sql);
    $i = 4;
    while ($arr = mysql_fetch_assoc($result)) {
      if ($i++ == 4) {
        echo '
                                    <tr>';
        $i = 0;
      }
      echo '
                                      <td><input type="radio" name="game" value="'. $arr['game_id'] .'"'. ($arr['game_id'] == $prereinterviews_arr['press_game'] ? ' checked' : '') .'>'. $arr['game_name'] .'</td>';
      if ($i++ == 4) {
        echo '
                                    </tr>';
        $i = 4;
      }
    }
    echo'					
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td class="config" valign="top">
                                    Kategorie:<br>
                                    <font class="small">Die Kategorie, der der Artikel angeh&ouml;rt.</font>
                              </td>
                              <td class="config" valign="top">
                                <table width="100%">';
    $sql = "SELECT press_cat_id, press_cat_name FROM fs_press_cat ORDER BY press_cat_name";
    $result = mysql_query($sql);
    $i = 4;
    while ($arr = mysql_fetch_assoc($result)) {
      if ($i++ == 4) {
        echo '
                                    <tr>';
        $i = 0;
      }
      echo '
                                      <td><input type="radio" name="cat" value="'. $arr['press_cat_id'] .'"'. ($arr['press_cat_id'] == $prereinterviews_arr['press_cat'] ? ' checked' : '') .'>'. $arr['press_cat_name'] .'</td>';
      if ($i++ == 4) {
        echo '
                                    </tr>';
        $i = 4;
      }
    } 
    echo '
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td class="config" valign="top">
                                    Rating:<br>
                                    <font class="small">Nur f&uuml;r Reviews!</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$prereinterviews_arr['rating'].'" name="rating" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    L&ouml;schen?:
                                </td>
                                <td class="config">
                                    <input onClick="alert(this.value)" type="checkbox" name="delit" value="Sicher?">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="button" type="button" value="Preview" onClick="javascript:open(\'about:blank\',\'prev\',\'width=700,height=710,screenX=0,screenY=0,scrollbars=yes\'); document.getElementById(\'send1\').action=\'admin_artikelprev.php\'; document.getElementById(\'send1\').target=\'prev\'; document.getElementById(\'send1\').submit();">
                                    <input class="button" type="button" value="Speichern" onClick="javascript:document.getElementById(\'send1\').target=\'_self\'; document.getElementById(\'send1\').action=\''.$PHP_SELF.'\'; document.getElementById(\'send1\').submit();">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

///////////////////////////////////////
/// Pre-, Re-, Interview ausflisten ///
///////////////////////////////////////

else
{
    if (isset($_POST['catid']))
    {
        settype($_POST['catid'], 'integer');
        $wherecat = "WHERE press_cat = " . $_POST['catid'];
    }

    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="press_edit" name="go">
                        <input type="hidden" value="content" name="mid">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="40%">
                                    Nur Artikel aus der Kategorie:
                                    <select name="catid" size="1">';
    $sql = "SELECT press_cat_id, press_cat_name FROM fs_press_cat ORDER BY press_cat_name";
    $result = mysql_query($sql);
    while ($arr = mysql_fetch_assoc($result)) {
      echo '
                                      <option value="'. $arr['press_cat_id'] .'"'. ($_POST['catid'] == $arr['press_cat_id'] ? ' selected' : '') .'>'. $arr['press_cat_name'] .'</option>';
    }
    echo '
									                  </select>
                                    <input class="button" type="submit" value="Anzeigen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

////////////////////////////////////////
//// Pre-, Re-, Interview auswählen ////
////////////////////////////////////////

    if (isset($_POST['catid']))
    {
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="press_edit" name="go">
                        <input type="hidden" value="content" name="mid">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="30%">
                                    Titel
                                </td>
                                <td class="config" width="30%">
                                    Spiel
                                </td>
                                <td class="config" width="20%">
                                    Datum
                                </td>
                                <td class="config" width="20%">
                                    Bearbeiten
                                </td>
                                </tr>';
    $index = mysql_query("SELECT press_title, press_url, press_date, press_text, press_rating, lang_name, game_name FROM fs_press INNER JOIN fs_game ON press_game = game_id INNER JOIN fs_language ON press_lang = lang_id $wherecat ORDER BY press_date", $db);
    while ($prereinterviews_arr = mysql_fetch_assoc($index))
    {
        $nowtag = date("d", $prereinterviews_arr['press_date']);
        $nowmonat = date("m", $prereinterviews_arr['press_date']);
        $nowjahr = date("Y", $prereinterviews_arr['press_date']);
        echo'
                            <tr>
                                <td class="configthin">
                                    '.$prereinterviews_arr['press_title'].'
                                </td>
                                <td class="configthin">
                                    '.$prereinterviews_arr['game_name'].'
                                </td>
                                <td class="configthin">
                                    '.$nowtag.'.'.$nowmonat.'.'.$nowjahr.'
                                </td>
                                <td class="config">
                                    <input type="radio" name="url" value="'.$prereinterviews_arr['press_url'].'">
                                </td>
                            </tr>
        ';
    }
    echo'
                            <tr>
                                <td colspan="3">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                    <input class="button" type="submit" value="Editieren">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
	}
}
?>
