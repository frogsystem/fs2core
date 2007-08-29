<?php
if (!empty($_POST['op'])) {
  if ($_POST['action'] == 0 && !empty($_POST['game_id'])) {
    /*
     * Bearbeite Spiel
     */
    $_POST['game_id'] = savesql($_POST['game_id']);
    $_POST['game_name'] = savesql($_POST['game_name']);
    $sql = "UPDATE fs_game SET game_name = '". $_POST['game_name'] ."' WHERE game_id = ". $_POST['game_id'];
    mysql_query($sql);
    if ($error = mysql_error()) {
        systext('Es ist ein Fehler aufgetreten.');
    }
    else {
      systext('Erfolgreich bearbeitet.');
      $_POST['game_name'] = NULL;
      $_POST['game_id'] = NULL;
    }
  }
  else if ($_POST['action'] == 1 && !empty($_POST['game_id'])) {
    /*
     * Lösche Spiel
     */
    $_POST['game_id'] = savesql($_POST['game_id']);
    $sql = "SELECT COUNT(*) FROM fs_press WHERE press_game = ". $_POST['game_id'];
    if (($result = mysql_result(mysql_query($sql), 0, 0)) > 0) {
      systext('Das Spiel kann nicht gel&ouml;scht werden, da ihm '. $result .' Artikel zugeordnet sind.');
    }
    else {
      $sql = "DELETE FROM fs_game WHERE game_id = ". $_POST['game_id'];
      mysql_query($sql);
      if ($error = mysql_error()) {
          systext('Es ist ein Fehler aufgetreten.');
      }
      else {
        systext('Erfolgreich gel&ouml;scht.');
        $_POST['game_name'] = NULL;
        $_POST['game_id'] = NULL;
      }
    }
  }
  else if ($_POST['action'] == 2) {
    /*
     * Neuen Eintrag hinzufügen
     */
    if (!empty($_POST['game_name'])) {
      $_POST['game_name'] = savesql($_POST['game_name']);
      $sql = "INSERT INTO fs_game (game_name) VALUES ('". $_POST['game_name'] ."')";
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
      systext('Fehler: Sie m&uuml;ssen einen Namen f&uuml;r das hinzuzuf&uuml;gende Spiel eingeben!');
    }
  }
}
/*
 * Spielübersicht anzeigen
 */
echo '
  <form action="" method="post">
    <input type="hidden" value="game" name="go">
    <input type="hidden" value="'. session_id() .'" name="PHPSESSID">
    <table border="0" cellpadding="4" cellspacing="0" width="600">
      <tr>
        <td class="config" valign="top" width="80%">Spiel</td>
        <td class="config" valign="top" width="20%">Bearbeiten</td>
      <tr>
';
$result = mysql_query("SELECT game_id, game_name FROM fs_game ORDER BY game_name");
while ($arr = mysql_fetch_assoc($result)) {
  echo '
      <tr>
        <td class="configthin">'. $arr['game_name'] .'</td>
        <td>
          <input type="radio" name="game_id" value="'. $arr['game_id'] .'">
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
          <input type="text" name="game_name" value="'. $_POST['game_name'] .'">
          <input class="button" type="submit" name="op" value="Ausf&uuml;hren">
        </td>
    </table>
  </form>
';
