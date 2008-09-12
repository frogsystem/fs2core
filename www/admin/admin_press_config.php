<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (isset($_POST['sended'])
   )
{
    settype($_POST[game_navi], 'integer');
    settype($_POST[cat_navi], 'integer');
    settype($_POST[lang_navi], 'integer');
    settype($_POST[show_press], 'integer');
    settype($_POST[show_root], 'integer');
    $_POST[order_type] = savesql($_POST[order_type]);
    $_POST[order_by] = savesql($_POST[order_by]);
        
    mysql_query("UPDATE ".$global_config_arr[pref]."press_config
                 SET game_navi = '$_POST[game_navi]',
                     cat_navi = '$_POST[cat_navi]',
                     lang_navi = '$_POST[lang_navi]',
                     show_press = '$_POST[show_press]',
                     show_root = '$_POST[show_root]',
                     order_type = '$_POST[order_type]',
                     order_by = '$_POST[order_by]'
                 WHERE id = '1'", $db);
    systext("Die Konfiguration wurde aktualisiert");
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    if (isset($_POST['sended']))
    {
        $config_arr[game_navi] = $_POST['game_navi'];
        $config_arr[cat_navi] = $_POST['cat_navi'];
        $config_arr[lang_navi] = $_POST['lang_navi'];
        $config_arr[show_press] = $_POST['show_press'];
        $config_arr[show_root] = $_POST['show_root'];
        $config_arr[order_type] = $_POST['order_type'];
        $config_arr[order_by] = $_POST['order_by'];
    
        systext($admin_phrases[common][note_notfilled]);
    }
    
    settype($config_arr[game_navi], 'integer');
    settype($config_arr[cat_navi], 'integer');
    settype($config_arr[lang_navi], 'integer');
    settype($config_arr[show_press], 'integer');
    settype($config_arr[show_root], 'integer');
    $config_arr[order_type] = savesql($config_arr[order_type]);
    $config_arr[order_by] = savesql($config_arr[order_by]);
    
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="press_config" name="go">
                        <input type="hidden" name="sended" value="">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Presseberichte anzeigen:<br>
                                    <font class="small">In welchen Ordnern der Navigation sollen Presseberichte angezeigt werden?</font>
                                    </td>
                                    <td class="config" valign="top" width="50%">
                                    <select name="show_press">
                                    <option value="1"';
                 if ($config_arr[show_press] == 1)
                   echo ' selected="selected"';
                 echo'>in allen Ordnern</option>
                                  <option value="0"';
                 if ($config_arr[show_press] == 0)
                   echo ' selected="selected"';
                 echo'>nur in Ordnern der letzten Ebene</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Alle Presseberichte anzeigen:<br>
                                    <font class="small">Sollen beim Seitenaufruf ohne Parameter alle Presseberichte angezeigt werden?</font>
                                    </td>
                                    <td class="config" valign="top" width="50%">
                                    <select name="show_root">
                                    <option value="0"';
                 if ($config_arr[show_root] == 0)
                   echo ' selected="selected"';
                 echo'>nicht anzeigen</option>
                           <option value="1"';
                   if ($config_arr[show_root] == 1)
                   echo ' selected="selected"';
                 echo'>anzeigen</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    In Navigation anzeigen:<br>
                                    <font class="small">Ausgewählte werden in der Navigation als Ordner angezeigt.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input type="checkbox" style="vertical-align:middle;" name="game_navi" value="1"';
    if ($config_arr[game_navi] == 1) {echo " checked=checked";}
    echo'>Spiele<br />
                                    <input type="checkbox" style="vertical-align:middle;" name="cat_navi" value="1"';
    if ($config_arr[cat_navi] == 1) {echo " checked=checked";}
    echo'>Kategorien<br />
                                    <input type="checkbox" style="vertical-align:middle;" name="lang_navi" value="1"';
    if ($config_arr[lang_navi] == 1) {echo " checked=checked";}
    echo'>Sprachen
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Sortierung:<br>
                                    <font class="small">Wie sollen die Presseberichte sortiert werden?</font>
                                    </td>
                                    <td class="config" valign="top" width="50%">
                                    sortieren
                                    <select name="order_by">
                                    <option value="press_title"';
                 if ($config_arr[order_by] == "press_title")
                   echo ' selected="selected"';
                 echo'>nach Titel</option>
                                  <option value="press_date"';
                 if ($config_arr[order_by] == "press_date")
                   echo ' selected="selected"';
                 echo'>nach Datum</option>
                                    </select>,
                                    <select name="order_type">
                                    <option value="asc"';
                 if ($config_arr[order_type] == "asc")
                   echo ' selected="selected"';
                 echo'>aufsteigend</option>
                                  <option value="desc"';
                 if ($config_arr[order_type] == "desc")
                   echo ' selected="selected"';
                 echo'>absteigend</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>