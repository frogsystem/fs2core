<?php
if (!empty($_POST['op'])) {
  if ($_POST['action'] == 0 && !empty($_POST['lang_id'])) {
    /*
     * Bearbeite Sprache
     */
    $_POST['lang_id'] = savesql($_POST['lang_id']);
    $_POST['lang_name'] = savesql($_POST['lang_name']);
    $sql = "UPDATE fs_language SET lang_name = '". $_POST['lang_name'] ."' WHERE lang_id = ". $_POST['lang_id'];
    mysql_query($sql);
    if ($error = mysql_error()) {
        systext('Es ist ein Fehler aufgetreten.');
    }
    else {
      systext('Erfolgreich bearbeitet.');
      $_POST['lang_name'] = NULL;
      $_POST['lang_id'] = NULL;
    }
  }
  else if ($_POST['action'] == 1 && !empty($_POST['lang_id'])) {
    /*
     * Lösche Sprache
     */
    $_POST['lang_id'] = savesql($_POST['lang_id']);
    $sql = "SELECT COUNT(*) FROM fs_press WHERE press_lang = ". $_POST['lang_id'];
    if (($result = mysql_result(mysql_query($sql), 0)) > 0) {
      systext('Die Sprache kann nicht gel&ouml;scht werden, da ihr '. $result .' Artikel zugeordnet sind.');
    }
    else {
      $sql = "DELETE FROM fs_language WHERE lang_id = ". $_POST['lang_id'];
      mysql_query($sql);
      if ($error = mysql_error()) {
          systext('Es ist ein Fehler aufgetreten.');
      }
      else {
        systext('Erfolgreich gel&ouml;scht.');
        $_POST['lang_name'] = NULL;
        $_POST['lang_id'] = NULL;
      }
    }
  }
  else if ($_POST['action'] == 2) {
    /*
     * Neuen Eintrag hinzufügen
     */
    if (!empty($_POST['lang_name'])) {
      $_POST['lang_name'] = savesql($_POST['lang_name']);
      $sql = "INSERT INTO fs_language (lang_name) VALUES ('". $_POST['lang_name'] ."')";
      mysql_query($sql);
      if ($error = mysql_error()) {
        systext('Es ist ein Fehler aufgetreten.');
      }
      else {
        systext('Erfolgreich hinzugef&uuml;gt.');
        $_POST['lang'] = NULL;
      }
    }
    else {
      systext('Fehler: Sie m&uuml;ssen einen Namen f&uuml;r die hinzuzuf&uuml;gende Sprache eingeben!');
    }
  }
}
/*
 * Sprachenübersicht anzeigen
 */
echo '
  <form action="" method="post">
    <input type="hidden" value="language" name="go">
    <input type="hidden" value="'. session_id() .'" name="PHPSESSID">
    <table border="0" cellpadding="4" cellspacing="0" width="600">
      <tr>
        <td class="config" valign="top" width="80%">Sprache</td>
        <td class="config" valign="top" width="20%">Bearbeiten</td>
      <tr>
';
$result = mysql_query("SELECT lang_id, lang_name FROM fs_language ORDER BY lang_name");
while ($arr = mysql_fetch_assoc($result)) {
  echo '
      <tr>
        <td class="configthin">'. $arr['lang_name'] .'</td>
        <td>
          <input type="radio" name="lang_id" value="'. $arr['lang_id'] .'">
        </td>
      </tr>
  ';
}
echo '
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">
          <select name="action">
            <option value="0" '. ($_POST['action'] == 0 ? 'selected' : '') .'>Ausgew&auml;hlten Eintrag bearbeiten</option>
            <option value="1" '. ($_POST['action'] == 1 ? 'selected' : '') .'>Ausgew&auml;hlten Eintrag l&ouml;schen</option>
            <option value="2" '. ($_POST['action'] == 2 ? 'selected' : '') .'>Neuen Eintrag hinzuf&uuml;gen</option>
          </select>
          <input type="text" name="lang_name" value="'. $_POST['lang_name'] .'">
          <input class="button" type="submit" name="op" value="Ausf&uuml;hren">
        </td>
    </table>
  </form>
';
