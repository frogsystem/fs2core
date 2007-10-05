<?php

$empty_entry = true;

/////////////////////////////////////
//// Includes einfügen           ////
/////////////////////////////////////

if ($_POST['replace_thing'] AND $_POST['name'])
{
    $_POST[replace_string] = "[%".$_POST['name']."%]";
    $_POST[replace_string] = savesql($_POST[replace_string]);
    $_POST[replace_thing] = savesql($_POST[replace_thing]);

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."includes
                          WHERE replace_string = '".$_POST[replace_string]."'", $db);

    if (mysql_num_rows($index) == 0)
    {
        mysql_query("INSERT INTO ".$global_config_arr[pref]."includes (replace_string, replace_thing, include_type)
                     VALUES ('".$_POST[replace_string]."',
                             '".$_POST[replace_thing]."',
                             '".$_POST[include_type]."')", $db);

        systext("Das Ersetzungsmuster wurde erfolgreich eingefügt!");
        unset($_POST['sended']);
        unset($_POST['replace_string']);
        unset($_POST['name']);
        unset($_POST['replace_thing']);
        unset($_POST['include_type']);
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


if (isset($_POST['sended']) AND $empty_entry == true)
{
  $error_message = "Bitte füllen Sie <b>alle Felder</b> aus!";
  systext($error_message);
}

if (isset($_POST['include_type']) AND $_POST['include_type']==1) {
  $start_sv_name = killhtml($_POST['name']);
  $start_sv_replace = killhtml($_POST['replace_thing']);
  $start_in_name = "";
  $start_in_replace = "";
} elseif (isset($_POST['include_type']) AND $_POST['include_type']==2) {
  $start_sv_name = "";
  $start_sv_replace = "";
  $start_in_name = killhtml($_POST['name']);
  $start_in_replace = killhtml($_POST['replace_thing']);
} else {
  $start_sv_name = "";
  $start_sv_replace = "";
  $start_in_name = "";
  $start_in_replace = "";
}

  
  
  echo'<table border="0" cellpadding="4" cellspacing="0" width="100%">
 <tr valign="top">
  <td class="config" width="50%">Seitenvariablen<br>
  <font class="small">Werden am Ende, direkt vor der Ausgabe ersetzt und können daher überall verwendet werden.</font></td>
  <td class="config" width="50%">Includes<br>
  <font class="small">Zum Einbinden von selbsterstellten xyz.inc.php Dateien aus dem Verzeichnis "[FS-Verzeichnis]/res/" in das Template "Index.php".</font></td>
 </tr>
 <tr valign="top">
  <td class="config">Seitenvariablen dürfen keine Ersetzungsmuster enthalten!</td>
  <td class="config">Includes dürfen nur Seitenvariablen als Ersetzungsmuster enthalten!</td>
 <tr>
 <tr>
  <td class="config" colspan="2"><span style="color:red">Achtung:</span> Es wird prinzipiell dieser Ersetzungssyntax verwendet: [%ersetzungstext%]</td>
 <tr>
  <td></td>
 </tr>
 <tr>
  <td class="config">Seitenvariablen<br>
  <td class="config">Echte Includes<br>
 </tr>
 <tr valign="top">
  <td>

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


  <form action="" method="post">
         <input type="hidden" value="includes_new" name="go">
         <input type="hidden" name="sended" value="">
         <input type="hidden" name="include_type" value="1">
         <input type="hidden" value="'.session_id().'" name="PHPSESSID">

         <font class="small">Name:</font><br>
         <input class="text" size="23" name="name" id="sv_name" maxlength="255" value="'.$start_sv_name.'"
          onkeydown="actSV()" onkeypress="actSV()" onkeyup="actSV()" />
         <br><br>
         <font class="small">Suchmuster:</font><br>
         <input class="text" size="23" name="replace_string" id="sv_syntax" maxlength="255"  value="[%'.$start_sv_name.'%]" readonly="readonly" />
         <br><br>
         <font class="small">Ersetzung:</font><br>
         <textarea name="replace_thing" rows="5" cols="20" wrap="virtual">'.$start_sv_replace.'</textarea>
         <br><br>
         <input class="button" type="submit" value="hinzufügen" onclick="actSV()">
  </form>

  </td>
  <td>

  <form action="" method="post">
         <input type="hidden" value="includes_new" name="go">
         <input type="hidden" name="sended" value="">
         <input type="hidden" name="include_type" value="2">
         <input type="hidden" value="'.session_id().'" name="PHPSESSID">

         <font class="small">Name:</font><br>
         <input class="text" size="23" name="name" id="in_name" maxlength="255" value="'.$start_in_name.'"
          onkeydown="actIN()" onkeypress="actIN()" onkeyup="actIN()" />
         <br><br>
         <font class="small">Suchmuster:</font><br>
         <input class="text" size="23" name="replace_string" id="in_syntax" maxlength="255" value="[%'.$start_in_name.'%]" readonly="readonly" />
         <br><br>
         <font class="small">Dateiname:</font><br>
         <input class="text" size="23" name="replace_thing" maxlength="255" value="'.$start_in_replace.'" />
         <br><br>
         <input class="button" type="submit" value="hinzufügen" onclick="actIN()">
  </form>

  </td>
 </tr>
</table>';

?>