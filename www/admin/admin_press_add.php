<?php

//////////////////////////////////////////////////
//// Neues Pre-, Re oder Interview einstellen ////
//////////////////////////////////////////////////

if ($_POST['title'] && $_POST['url'] && $_POST['day'] && $_POST['month'] && $_POST['year'])
{
	$datum = mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']);
  $_POST['title'] = savesql($_POST['title']);
  $_POST['url'] = savesql($_POST['url']);
  $_POST['date'] = savesql($_POST['date']);
  $_POST['text'] = savesql($_POST['text']);
  $_POST['lang'] = savesql($_POST['lang']);
  $_POST['game'] = savesql($_POST['game']);
  $_POST['cat'] = savesql($_POST['cat']);
  $_POST['rating'] = savesql($_POST['rating']);
  mysql_query("INSERT INTO fs_press (press_title, press_url, press_date, press_text, press_lang, press_game, press_cat, press_rating)
    VALUES ('". $_POST['title'] ."', '". $_POST['url'] ."', '". $datum ."', '". $_POST['text'] ."', ". $_POST['lang'] .", ". $_POST['game'] .", ". $_POST['cat'] .", ". (!empty($_POST['rating']) ? "'". $_POST['rating'] ."'" : 'NULL') .")");
  if ($error = mysql_error()) {
    systext('Es ist ein Fehler aufgetreten.');
  }
  else {
    systext("Pre-, Re- oder Interview wurde gespeichert.");
  }
}

////////////////////////////////////////////
///// Pre-, Re oder Interview Formular /////
////////////////////////////////////////////

else
{
    echo'
                    <form action="'.$PHP_SELF.'" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="press_add" name="go">
                        <input type="hidden" value="content" name="mid">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Der Name der Website. Kommt auch in den Hotlink.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Link zum Artikel.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="url" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Datum der Originalver&ouml;ffentlichung. Wichtig f&uuml;r die Sortierung. (TT MM JJJJ)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="2" name="day" maxlength="2">
                                    <input class="text" size="2" name="month" maxlength="2">
                                    <input class="text" size="4" name="year" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Ein kurzer Auszug aus dem Artikel.</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea class="text" name="text" rows="7" cols="49"></textarea>
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
                                      <td><input type="radio" name="lang" value="'. $arr['lang_id'] .'">'. $arr['lang_name'] .'</td>';
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
                                  <table width="100%">';
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
                                      <td><input type="radio" name="game" value="'. $arr['game_id'] .'">'. $arr['game_name'] .'</td>';
      if ($i++ == 4) {
        echo '
                                    </tr>';
        $i = 0;
      }
    }
    echo '
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
                                      <td><input type="radio" name="cat" value="'. $arr['press_cat_id'] .'">'. $arr['press_cat_name'] .'</td>';
      if ($i++ == 4) {
        echo '
                                    </tr>';
        $i = 0;
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
                                    <input class="text" name="wertung" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
