<?php

/////////////////////////////////////
//// Includes einfügen           ////
/////////////////////////////////////

if ($_POST['replace_string'] AND $_POST['replace_thing'] AND $_POST['name'])
{
    $_POST[replace_string] = "[%".$_POST['name']."%]";
    $_POST[replace_string] = savesql($_POST[replace_string]);
    $_POST[replace_thing] = savesql($_POST[replace_thing]);

    $index = mysql_query("SELECT * FROM fs_includes
                          WHERE replace_string = '".$_POST[replace_string]."'", $db);

    if (mysql_num_rows($index) == 0)
    {
        mysql_query("INSERT INTO fs_includes (replace_string, replace_thing, include_type)
                     VALUES ('".$_POST[replace_string]."',
                             '".$_POST[replace_thing]."',
                             '".$_POST[include_type]."')", $db);

        systext("Das Ersetzungsmuster wurde erfolgreich eingefügt!");
    }
    else
    {
        systext("Es existiert bereits ein solches Ersetzungsmuster!");
    }




}

/////////////////////////////////////
////// Template Formular ////////////
/////////////////////////////////////

$error_message = "";

if (isset($_POST['sended']))
{
$error_message = "Bitte füllen Sie <b>alle Felder</b> aus!";
}

  systext($error_message);
  
  
  echo'<table border="0" cellpadding="4" cellspacing="0" width="100%">
 <tr valign="top">
  <td class="config" width="50%">Seitenvariablen<br>
  <font class="small">Werden am Ende, direkt vor der Ausgabe ersetzt und können daher überall verwendet werden.</font></td>
  <td class="config" width="50%">Includes<br>
  <font class="small">Zum Einbinden von selbsterstellten xyz.inc.php Dateien aus dem Verzeichnis "frogsystem/inc/" in das Template "Index.php".</font></td>
 </tr>
 <tr valign="top">
  <td class="config">Seitenvariablen können keine Ersetzungsmuster enthalten!</td>
  <td class="config">Includes können nur Seitenvariablen als Ersetzungsmuster enthalten!</td>
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


  <form action="'.$PHP_SELF.'" method="post">
         <input type="hidden" value="includes_new" name="go">
         <input type="hidden" name="sended" value="">
         <input type="hidden" name="include_type" value="1">
         <input type="hidden" value="'.session_id().'" name="PHPSESSID">

         <font class="small">Name:</font><br>
         <input class="text" size="23" name="name" id="sv_name" maxlength="255" value=""
          onkeydown="actSV()" onkeypress="actSV()" onkeyup="actSV()" />
         <br><br>
         <font class="small">Suchmuster:</font><br>
         <input class="text" size="23" name="replace_string" id="sv_syntax" maxlength="255"  value="[%%]" disabled="disabled" />
         <br><br>
         <font class="small">Ersetzung:</font><br>
         <textarea name="replace_thing" rows="5" cols="20" wrap="virtual"></textarea>
         <br><br>
         <input class="button" type="submit" value="hinzufügen" onclick="actSV()">
  </form>

  </td>
  <td>

  <form action="'.$PHP_SELF.'" method="post">
         <input type="hidden" value="includes_new" name="go">
         <input type="hidden" name="sended" value="">
         <input type="hidden" name="include_type" value="2">
         <input type="hidden" value="'.session_id().'" name="PHPSESSID">

         <font class="small">Name:</font><br>
         <input class="text" size="23" name="name" id="in_name" maxlength="255" value=""
          onkeydown="actIN()" onkeypress="actIN()" onkeyup="actIN()" />
         <br><br>
         <font class="small">Suchmuster:</font><br>
         <input class="text" size="23" name="replace_string" id="in_syntax" maxlength="255" value="[%%]" disabled="disabled" />
         <br><br>
         <font class="small">Dateiname:</font><br>
         <input class="text" size="23" name="replace_thing" maxlength="255" value="" />
         <br><br>
         <input class="button" type="submit" value="hinzufügen" onclick="actIN()">
  </form>

  </td>
 </tr>
</table>';

?>