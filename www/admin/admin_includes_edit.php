<?php

$empty_entry = true;

/////////////////////////////////////
//// Includes updaten            ////
/////////////////////////////////////

if (($_POST['replace_thing'] AND $_POST['name']) OR $_POST[include_del]==1)
{
    $_POST[replace_string] = "[%".$_POST['name']."%]";
    $_POST[replace_string] = savesql($_POST[replace_string]);
    $_POST[old_name] = "[%".$_POST['old_name']."%]";
    $_POST[old_name] = savesql($_POST[old_name]);
    $_POST[replace_thing] = savesql($_POST[replace_thing]);

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."includes
                          WHERE replace_string = '".$_POST[replace_string]."'", $db);

    if ($_POST[include_del]==1)
    {
        mysql_query("DELETE FROM ".$global_config_arr[pref]."includes WHERE id = '$_POST[include_id]'", $db);
        systext("Das Ersetzungsmuster wurde erfolgreich gelöscht");
        unset($_POST['sended']);
        unset($_POST['replace_string']);
        unset($_POST['name']);
        unset($_POST['replace_thing']);
        unset($_POST['include_type']);
        unset($_POST['include_id']);
    }
    elseif (mysql_num_rows($index) == 0 OR $_POST[replace_string] == $_POST[old_name])
    {
        mysql_query("UPDATE ".$global_config_arr[pref]."includes
                     SET replace_string = '$_POST[replace_string]',
                         replace_thing =  '$_POST[replace_thing]'
                     WHERE id = $_POST[include_id]", $db);

        systext("Das Ersetzungsmuster wurde erfolgreich aktualisiert!");
        unset($_POST['sended']);
        unset($_POST['replace_string']);
        unset($_POST['name']);
        unset($_POST['replace_thing']);
        unset($_POST['include_type']);
        unset($_POST['include_id']);
    }
    else
    {
        systext("Es existiert bereits ein solches Ersetzungsmuster!");
        $empty_entry = false;
    }

}

/////////////////////////////////////
////// Template Formular ////////////
/////////////////////////////////////
if ($_POST[include_id])
{

  if (isset($_POST['sended']) AND $empty_entry == true)
  {
    $error_message = "Bitte füllen Sie <b>alle Felder</b> aus!";
    systext($error_message);
  }

  $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."includes WHERE id=$_POST[include_id]", $db);
  $inc_arr = mysql_fetch_assoc($index);

  $inc_arr[replace_string] = killhtml(substr($inc_arr[replace_string], 2,strlen($inc_arr[replace_string])-4));
  $inc_arr[old_name] = $inc_arr[replace_string];
  $inc_arr[replace_thing] = killhtml($inc_arr[replace_thing]);

  if (isset($_POST['include_type'])) {
    $inc_arr[replace_string] = killhtml($_POST['name']);
    $inc_arr[replace_thing] = killhtml($_POST['replace_thing']);
  }

  echo '
         <script type="text/javascript">
         function actSV () {
         document.getElementById("sv_syntax").value = "[%" + document.getElementById("sv_name").value + "%]";
         return true;
         }
         function actIN () {
         document.getElementById("in_syntax").value = "[%" + document.getElementById("in_name").value + "%]";
         return true;
         }
         </script>
  ';

  if ($inc_arr[include_type]==1)
  {
    echo'
    <table border="0" cellpadding="4" cellspacing="0" width="100%">
      <tr valign="top">
        <td class="config">Seitenvariablen<br>
          <font class="small">Werden am Ende, direkt vor der Ausgabe ersetzt und können daher überall verwendet werden.</font>
        </td>
      </tr>
      <tr valign="top">
        <td class="config">Seitenvariablen dürfen keine Ersetzungsmuster enthalten!</td>
      </tr>
      <tr>
        <td class="config" colspan="2"><span style="color:red">Achtung:</span> Es wird prinzipiell dieser         Ersetzungssyntax verwendet: [%ersetzungstext%]</td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
    <center><table border="0" cellpadding="4" cellspacing="0">
      <tr valign="top" align="left">
        <td>
          <form action="" method="post">
            <input type="hidden" value="includes_edit" name="go">
            <input type="hidden" name="sended" value="">
            <input type="hidden" name="include_type" value="'.$inc_arr[include_type].'">
            <input type="hidden" name="include_id" value="'.$inc_arr[id].'">
            <input type="hidden" name="old_name" value="'.$inc_arr[old_name].'">
            <input type="hidden" value="'.session_id().'" name="PHPSESSID">

            <font class="small"><b>Ersetzungsmuster löschen:</b></font>
            <input onClick=\'delalert ("include_del", "Soll das Ersetzungsmuster wirklich gelöscht werden?")\' type="checkbox" name="include_del" id="include_del" value="1">
            <br /><br />
            <font class="small">Name:</font><br>
            <input class="text" size="30" name="name" id="sv_name" maxlength="255" value="'.$inc_arr[replace_string].'" onkeydown="actSV()" onkeypress="actSV()" onkeyup="actSV()" />
            <br /><br />
            <font class="small">Suchmuster:</font><br>
            <input class="text" size="20" name="replace_string" id="sv_syntax" maxlength="255"  value="[%'.$inc_arr[replace_string].'%]" readonly="readonly" />
            <br /><br />
            <font class="small">Ersetzung:</font><br>
            <textarea name="replace_thing" wrap="virtual" style="width:500px; height:200px;">'.$inc_arr[replace_thing].'</textarea>
            <br /><br />
            <input class="button" type="submit" value="Änderung speichern" onclick="actSV()">
          </form>
        </td>
      </tr>
    </table></center>';
  }
  elseif ($inc_arr[include_type]==2)
  {
    echo'
    <table border="0" cellpadding="4" cellspacing="0" width="100%">
      <tr valign="top">
        <td class="config">Includes<br>
          <font class="small">Zum Einbinden von selbsterstellten xyz.inc.php Dateien aus dem Verzeichnis "[FS-Verzeichnis]/res/" in das Template "Index.php".</font>
        </td>
      </tr>
      <tr valign="top">
        <td class="config">Includes dürfen nur Seitenvariablen als Ersetzungsmuster enthalten!</td>
      </tr>
      <tr>
        <td class="config" colspan="2"><span style="color:red">Achtung:</span> Es wird prinzipiell dieser         Ersetzungssyntax verwendet: [%ersetzungstext%]</td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
    <center><table border="0" cellpadding="4" cellspacing="0">
      <tr valign="top" align="left">
        <td>
          <form action="" method="post">
            <input type="hidden" value="includes_edit" name="go">
            <input type="hidden" name="sended" value="">
            <input type="hidden" name="include_type" value="'.$inc_arr[include_type].'">
            <input type="hidden" name="include_id" value="'.$inc_arr[id].'">
            <input type="hidden" name="old_name" value="'.$inc_arr[old_name].'">
            <input type="hidden" value="'.session_id().'" name="PHPSESSID">

            <font class="small"><b>Ersetzungsmuster löschen:</b></font>
            <input onClick=\'delalert ("include_del", "Soll das Ersetzungsmuster wirklich gelöscht werden?")\' type="checkbox" name="include_del" id="include_del" value="1">
            <br /><br />
            <font class="small">Name:</font><br>
            <input class="text" size="23" name="name" id="in_name" maxlength="255" value="'.$inc_arr[replace_string].'" onkeydown="actIN()" onkeypress="actIN()" onkeyup="actIN()" />
            <br /><br />
            <font class="small">Suchmuster:</font><br>
            <input class="text" size="23" name="replace_string" id="in_syntax" maxlength="255"  value="[%'.$inc_arr[replace_string].'%]" readonly="readonly" />
            <br /><br />
            <font class="small">Dateiname:</font><br>
            <input class="text" size="23" name="replace_thing" maxlength="255" value="'.$inc_arr[replace_thing].'" />
            <br /><br />
            <input class="button" type="submit" value="Änderung speichern" onclick="actIN()">
          </form>
        </td>
      </tr>
    </table></center>';
  }
}
////////////////////////////////
////// Includes auswählen //////
////////////////////////////////

else
{

  echo'<table border="0" cellpadding="4" cellspacing="0" width="100%">
 <tr valign="top">
  <td class="config" width="50%">Seitenvariablen<br>
  <font class="small">Werden am Ende, direkt vor der Ausgabe ersetzt und können daher überall verwendet werden.</font></td>
  <td class="config" width="50%">Includes<br>
  <font class="small">Zum Einbinden von selbsterstellten xyz.inc.php Dateien aus dem Verzeichnis "frogsystem/inc/" in das Template "Index.php".</font></td>
 </tr>
 <tr>
  <td></td>
 </tr>
 <tr valign="top">
  <form action="" method="post">
    <input type="hidden" value="includes_edit" name="go">
    <input type="hidden" value="'.session_id().'" name="PHPSESSID">

  <td  class="configthin">';
  $index = mysql_query("SELECT id, replace_string FROM ".$global_config_arr[pref]."includes WHERE include_type=1 ORDER BY replace_string ASC", $db);
  while ($inc_arr = mysql_fetch_assoc($index))
  {
    echo '<input type="radio" name="include_id" value="'.$inc_arr[id].'" /> '.$inc_arr[replace_string].'<br />';
  }
  
echo'</td>
  <td  class="configthin">';
  $index = mysql_query("SELECT id, replace_string FROM ".$global_config_arr[pref]."includes WHERE include_type=2 ORDER BY replace_string ASC", $db);
  while ($inc_arr = mysql_fetch_assoc($index))
  {
    echo '<input type="radio" name="include_id" value="'.$inc_arr[id].'" /> '.$inc_arr[replace_string].'<br />';
  }

echo'
  </td>
 </tr>
 <tr>
   <td>
   </td>
 </tr>
 <tr>
   <td align="left">
     <input class="button" type="submit" value="Auswahl bearbeiten">
   </td>
 </tr>
 </form>
</table>';

}

?>