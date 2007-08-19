<?php

//////////////////////////////////////
//// Tagesstatistik aktualisieren ////
//////////////////////////////////////

if ($_POST[d] && $_POST[m] && $_POST[y] && $_POST[v] && $_POST[h])
{
    settype($_POST[d], 'integer');
    settype($_POST[m], 'integer');
    settype($_POST[y], 'integer');
    settype($_POST[v], 'integer');
    settype($_POST[h], 'integer');
    mysql_query("UPDATE fs_counter_stat
                 SET s_visits = $_POST[v],
                     s_hits   = $_POST[h]
                 WHERE s_day   = $_POST[d] AND
                       s_month = $_POST[m] AND
                       s_year  = $_POST[y]", $db);
    systext("Der Counter wurde aktualisiert");
}

//////////////////////////////////////
////// Tagesstatistik editieren //////
//////////////////////////////////////

elseif ($_POST[ed] && $_POST[em] && $_POST[ey])
{
    settype($_POST[ed], 'integer');
    settype($_POST[em], 'integer');
    settype($_POST[ey], 'integer');
    $index = mysql_query("SELECT s_visits,
                                 s_hits
                          FROM fs_counter_stat
                          WHERE s_day = $_POST[ed] and
                                s_month = $_POST[em] and
                                s_year = $_POST[ey]", $db);
    if (mysql_num_rows($index) == 0)
    {
        systext("Keine Daten unter dem angegebenen Datum gefunden");
    }
    else
    {
        $counter_arr = mysql_fetch_assoc($index);
        echo'
                    <form action="" method="post">
                        <input type="hidden" value="statedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$_POST[ed].'" name="d">
                        <input type="hidden" value="'.$_POST[em].'" name="m">
                        <input type="hidden" value="'.$_POST[ey].'" name="y">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="60%">
                                    Besucher:<br>
                                    <font class="small">Anzahl der Besucher am '.$_POST[ed].'.'.$_POST[em].'.'.$_POST[ey].'</font>
                                </td>
                                <td class="config" width="40%">
                                    <input class="text" size="16" name="v" maxlength="16" value="'.$counter_arr[s_visits].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" width="60%">
                                    Hits:<br>
                                    <font class="small">Anzahl der Seitenaufrufe am '.$_POST[ed].'.'.$_POST[em].'.'.$_POST[ey].'</font>
                                </td>
                                <td class="config" width="40%">
                                    <input class="text" size="16" name="h" maxlength="16" value="'.$counter_arr[s_hits].'">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
}

//////////////////////////////////////
/// Gesamtstatistik aktualisieren ////
//////////////////////////////////////

elseif ($_POST[editvisits] != "" &&
        $_POST[edithits] != "" &&
        $_POST[edituser] != "" &&
        $_POST[editnews] != "" &&
        $_POST[editartikel] != "" &&
        $_POST[editcomments] != "")
{
    settype($_POST[editvisits], 'integer');
    settype($_POST[edithits], 'integer');
    settype($_POST[edituser], 'integer');
    settype($_POST[editnews], 'integer');
    settype($_POST[editartikel], 'integer');
    settype($_POST[editcomments], 'integer');
    mysql_query("UPDATE fs_counter
                 SET visits = '$_POST[editvisits]',
                     hits = '$_POST[edithits]',
                     user = '$_POST[edituser]',
                     news = '$_POST[editnews]',
                     artikel = '$_POST[editartikel]',
                     comments = '$_POST[editcomments]'", $db);
    systext("Der Counter wurde aktualisiert");
}

//////////////////////////////////////
///// Gesamtstatistik editieren //////
//////////////////////////////////////

else
{
    //Zeit-Array für Heute Button
    $heute[d] = date("d");
    $heute[m] = date("m");
    $heute[y] = date("Y");

    $index = mysql_query("SELECT * FROM fs_counter", $db);
    $counter_arr = mysql_fetch_assoc($index);
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="statedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="60%">
                                    Besucher gesamt:<br>
                                    <font class="small">Anzahl der Besucher die bisher auf der Site waren</font>
                                </td>
                                <td class="config" width="40%">
                                    <input class="text" size="16" name="editvisits" maxlength="16" value="'.$counter_arr[visits].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" width="60%">
                                    Hits gesamt:<br>
                                    <font class="small">Anzahl der Seitenaufrufe</font>
                                </td>
                                <td class="config" width="40%">
                                    <input class="text" size="16" name="edithits" maxlength="16" value="'.$counter_arr[hits].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" width="60%">
                                    User gesamt:<br>
                                    <font class="small">Anzahl der registrierten USer</font>
                                </td>
                                <td class="config" width="40%">
                                    <input class="text" size="16" name="edituser" maxlength="16" value="'.$counter_arr[user].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" width="60%">
                                    News gesamt:<br>
                                    <font class="small">Anzahl der geschriebenen News</font>
                                </td>
                                <td class="config" width="40%">
                                    <input class="text" size="16" name="editnews" maxlength="16" value="'.$counter_arr[news].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" width="60%">
                                    Artikel gesamt:<br>
                                    <font class="small">Anzahl der geschriebenen Artikel</font>
                                </td>
                                <td class="config" width="40%">
                                    <input class="text" size="16" name="editartikel" maxlength="16" value="'.$counter_arr[artikel].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" width="60%">
                                    Kommentare gesamt:<br>
                                    <font class="small">Anzahl der geschriebenen News Kommentare</font>
                                </td>
                                <td class="config" width="40%">
                                    <input class="text" size="16" name="editcomments" maxlength="16" value="'.$counter_arr[comments].'">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <p>
                    <form action="" method="post">
                        <input type="hidden" value="statedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="60%">
                                    Tag editieren:<br>
                                    <font class="small">Gib das Datum ein, das du editieren möchtest.<br />
                                    [TT].[MM].[JJJJ]</font>
                                </td>
                                <td class="config" width="40%">
                                    <input class="text" size="1" name="ed" id="ed" maxlength="2"> .
                                    <input class="text" size="1" name="em" id="em"  maxlength="2"> .
                                    <input class="text" size="3" name="ey" id="ey"  maxlength="4">&nbsp;&nbsp;
                                    <input class="button" type="button" value="Heute"
                                           onClick=\'document.getElementById("ed").value="'.$heute[d].'";
                                                     document.getElementById("em").value="'.$heute[m].'";
                                                     document.getElementById("ey").value="'.$heute[y].'";\'>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input class="button" type="submit" value="Auswählen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>