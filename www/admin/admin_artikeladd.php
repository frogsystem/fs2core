<?php

/////////////////////////////////////
//// Artikel in die DB schreiben ////
/////////////////////////////////////

if ($_POST[url] && $_POST[title] && $_POST[text])
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
        settype($_POST[posterid], 'integer');
        $_POST[search] = isset($_POST[search]) ? 1 : 0;
        $_POST[fscode] = isset($_POST[fscode]) ? 1 : 0;

        mysql_query("INSERT INTO ".$global_config_arr[pref]."artikel
                     VALUES ('$_POST[url]',
                             '$_POST[title]',
                             '$date',
                             '$_POST[posterid]',
                             '$_POST[text]',
                             '$_POST[search]',
                             '$_POST[fscode]');", $db);
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

    echo'
                    <form id="send1" action="" method="post">
                        <input type="hidden" value="artikeladd" name="go">
                        <input type="hidden" value="" name="sended">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Teil der an ?go= angehängt wird</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="33" value="'.stripslashes(killhtml($_POST[url])).'" name="url" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Diesen Titel bekommt der Artikel</font>
                                </td>
                                <td class="config" valign="top">
                                    <input value="'.stripslashes(killhtml($_POST[title])).'" class="text" size="40" name="title" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Autor:<br>
                                    <font class="small">Verfasser des Artikels (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" id="username" name="poster" value="'.$dbusername.'" maxlength="100" readonly="readonly">
                                    <input type="hidden" id="userid" name="posterid" value="'.$_POST[posterid].'">
                                    <input onClick=\'open("admin_finduser.php","Poster","width=360,height=300,screenX=50,screenY=50,scrollbars=YES")\' class="button" type="button" value="Ändern">
                                    <input onClick=\'document.getElementById("username").value="";
                                                     document.getElementById("userid").value="0";\' class="button" type="button" value="Löschen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Datum des Artikels (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input id="day" class="text" size="2" name="tag" value="'.stripslashes(killhtml($_POST[tag])).'" maxlength="2">
                                    <input id="month" class="text" size="2" name="monat" value="'.stripslashes(killhtml($_POST[monat])).'" maxlength="2">
                                    <input id="year" class="text" size="4" name="jahr" value="'.stripslashes(killhtml($_POST[jahr])).'" maxlength="4">
                                    <input onClick=\'document.getElementById("day").value="'.$heute[tag].'";
                                                     document.getElementById("month").value="'.$heute[monat].'";
                                                     document.getElementById("year").value="'.$heute[jahr].'";\' class="button" type="button" value="Heute">
                                    <input onClick=\'document.getElementById("day").value="";
                                                     document.getElementById("month").value="";
                                                     document.getElementById("year").value="";\' class="button" type="button" value="Löschen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Such-Index:<br>
                                    <font class="small">Diesen Artikel zum Such-Index hinzufügen</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="search" '.$dbartikelindex.'>
                                </td>
                            </tr>
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
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Html ist an. FScode ist an</font>
                                </td>
                                <td valign="top">
                                    '.create_editor("text", stripslashes(killhtml($_POST[text])), 407, 380, "", false).'
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="button" type="button" value="Vorschau" onClick="javascript:open(\'about:blank\',\'prev\',\'width=700,height=710,screenX=0,screenY=0,scrollbars=yes\'); document.getElementById(\'send1\').action=\'admin_artikelprev.php\'; document.getElementById(\'send1\').target=\'prev\'; document.getElementById(\'send1\').submit();">
                                    <input class="button" type="button" value="Absenden" onClick="javascript:document.getElementById(\'send1\').target=\'_self\'; document.getElementById(\'send1\').action=\''.$PHP_SELF.'\'; document.getElementById(\'send1\').submit();">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>