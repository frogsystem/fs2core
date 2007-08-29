<?php
if (!empty($_POST['op'])) {
  if ($_POST['action'] == 0 && !empty($_POST['press_cat_id'])) {
    /*
     * Bearbeite Kategorie
     */
    $_POST['press_cat_id'] = savesql($_POST['press_cat_id']);
    $_POST['press_cat_name'] = savesql($_POST['press_cat_name']);
    $sql = "UPDATE fs_press_cat SET press_cat_name = '". $_POST['press_cat_name'] ."' WHERE press_cat_id = ". $_POST['press_cat_id'];
    mysql_query($sql);
    if ($error = mysql_error()) {
        systext('Es ist ein Fehler aufgetreten.');
    }
    else {
      systext('Erfolgreich bearbeitet.');
      $_POST['press_cat_name'] = NULL;
      $_POST['press_cat_id'] = NULL;
    }
  }
  else if ($_POST['action'] == 1 && !empty($_POST['press_cat_id'])) {
    /*
     * Lösche Kategorie
     */
    $_POST['press_cat_id'] = savesql($_POST['press_cat_id']);
    $sql = "SELECT COUNT(*) FROM fs_press WHERE press_cat = ". $_POST['press_cat_id'];
    if (($result = mysql_result(mysql_query($sql), 0)) > 0) {
      systext('Die Kategorie kann nicht gel&ouml;scht werden, da ihr '. $result .' Artikel zugeordnet sind.');
    }
    else {
      $sql = "DELETE FROM fs_press_cat WHERE press_cat_id = ". $_POST['press_cat_id'];
      mysql_query($sql);
      if ($error = mysql_error()) {
          systext('Es ist ein Fehler aufgetreten.');
      }
      else {
        systext('Erfolgreich gel&ouml;scht.');
        $_POST['press_cat_name'] = NULL;
        $_POST['press_cat_id'] = NULL;
      }
    }
  }
  else if ($_POST['action'] == 2) {
    /*
     * Neuen Eintrag hinzufügen
     */
    if (!empty($_POST['press_cat_name'])) {
      $_POST['press_cat_name'] = savesql($_POST['press_cat_name']);
      $sql = "INSERT INTO fs_press_cat (press_cat_name) VALUES ('". $_POST['press_cat_name'] ."')";
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
      systext('Fehler: Sie m&uuml;ssen einen Namen f&uuml;r die hinzuzuf&uuml;gende Kategorie eingeben!');
    }
  }
}
/*
 * Kategorien anzeigen
 */
echo '
  <form action="" method="post">
    <input type="hidden" value="press_cat" name="go">
    <input type="hidden" value="'. session_id() .'" name="PHPSESSID">
    <table border="0" cellpadding="4" cellspacing="0" width="600">
      <tr>
        <td class="config" valign="top" width="80%">Kategorie</td>
        <td class="config" valign="top" width="20%">Bearbeiten</td>
      <tr>
';
$result = mysql_query("SELECT press_cat_id, press_cat_name FROM fs_press_cat ORDER BY press_cat_name");
while ($arr = mysql_fetch_assoc($result)) {
  echo '
      <tr>
        <td class="configthin">'. $arr['press_cat_name'] .'</td>
        <td>
          <input type="radio" name="press_cat_id" value="'. $arr['press_cat_id'] .'">
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
          <input type="text" name="press_cat_name" value="'. $_POST['press_cat_name'] .'">
          <input class="button" type="submit" name="op" value="Ausf&uuml;hren">
        </td>
    </table>
  </form>
';
