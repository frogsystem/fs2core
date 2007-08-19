<?php

/////////////////////////////////
////// CSS Datei speichern //////
/////////////////////////////////

if ($_POST[code] && (($_POST[design] OR $_POST[design]==0) AND $_POST[design]!="") && ($_SESSION[user_level] == "authorised"))
{
    $index = mysql_query("SELECT id, name FROM fs_template WHERE id = '$_POST[design]'", $db);
    $design_arr = mysql_fetch_assoc($index);

    $fp = fopen("../css/".$design_arr[name].".css", "w");
    fputs($fp, $_POST[code]);
    fclose($fp);
    systext("$design_arr[name] wurde aktualisiert");
}

/////////////////////////////////
/////// Formular erzeugen ///////
/////////////////////////////////

elseif ($_SESSION[user_level] == "authorised")
{
    // CSS Dateien ermittlen
    echo'
                    <div align="left">
                        <form action="" method="post">
                            <input type="hidden" value="csstemplate" name="go">
                            <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                            <select name="design" onChange="this.form.submit();">
                                <option value="">Design auswählen</option>
                                <option value="">------------------------</option>
    ';

    $index = mysql_query("select id, name from fs_template ORDER BY id", $db);
    while ($design_arr = mysql_fetch_assoc($index))
    {
      echo '<option value="'.$design_arr[id].'"';
      if ($design_arr[id] == $_POST[design])
        echo ' selected=selected';
      echo '>'.$design_arr[name];
      if ($design_arr[id] == $global_config_arr[design])
        echo ' (aktiv)';
      echo '</option>';
    }
    
    echo'
                            </select> <input class="button" value="Los" type="submit">
                        </form>
                    </div>
    ';

    if (($_POST[design] OR $_POST[design]==0) AND $_POST[design]!="")
    {
        // Datei einlesen
        $index = mysql_query("select id, name from fs_template WHERE id = '$_POST[design]'", $db);
        $design_arr = mysql_fetch_assoc($index);
        $datei = file_get_contents("../css/".$design_arr[name].".css");

        echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="" method="post">
                        <input type="hidden" value="csstemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="120">
                                    CSS:</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="code">'.$datei.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                </td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'code\')">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
}
?>