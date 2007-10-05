<?php

////////////////////////////
//// Umfrage hinzufügen ////
////////////////////////////

if ($_POST[polladd] && $_POST[frage] && $_POST[ant][0] && $_POST[ant][1])
{
    $_POST[frage] = savesql($_POST[frage]);
    settype($_POST[type], "integer");
    for ($i=0; $i<count($_POST[ant]); $i++)
    {
        $_POST[ant][$i] = savesql($_POST[ant][$i]);
    }

    $adate = mktime($_POST[nowstunde], $_POST[nowmin], 0, $_POST[nowmonat], $_POST[nowtag], $_POST[nowjahr]);
    $edate = mktime($_POST[endstunde], $_POST[endmin], 0, $_POST[endmonat], $_POST[endtag], $_POST[endjahr]);

    $_POST[type] = ($_POST[type] == 1) ? 1 : 0;

    // Umfrage in die DB eintragen
    mysql_query("INSERT INTO ".$global_config_arr[pref]."poll (poll_quest, poll_start, poll_end, poll_type)
                 VALUES ('".$_POST[frage]."',
                         '$adate',
                         '$edate',
                         '".$_POST[type]."');", $db);

    // Antworten in die DB eintragen
    $index = mysql_query("SELECT poll_id FROM ".$global_config_arr[pref]."poll WHERE poll_quest = '".$_POST[frage]."'");
    $id = mysql_result($index, 0, "poll_id");

    for ($i=0; $i<count($_POST[ant]); $i++)
    {
        mysql_query("INSERT INTO ".$global_config_arr[pref]."poll_answers (poll_id, answer)
                     VALUES ('$id',
                             '".$_POST[ant][$i]."');", $db);
    }
    systext("Umfrage wurde hinzugefügt");
}

////////////////////////////
///// Umfrage Formular /////
////////////////////////////

else
{
    //Zeit-Array für Jetzt Button
    $jetzt[tag] = date("d");
    $jetzt[monat] = date("m");
    $jetzt[jahr] = date("Y");
    $jetzt[stunde] = date("H");
    $jetzt[minute] = date("i");

    if (!isset($_POST[nowtag]))
    {
        $_POST[nowtag] = date("d");
        $_POST[endtag] = date("d");
    }
    if (!isset($_POST[nowmonat]))
    {
        $_POST[nowmonat] = date("m");
    }
    if (!isset($_POST[nowjahr]))
    {
        $_POST[nowjahr] = date("Y");
    }
    if (!isset($_POST[nowstunde]))
    {
        $_POST[nowstunde] = date("H");
        $_POST[endstunde] = date("H");
    }
    if (!isset($_POST[nowmin]))
    {
        $_POST[nowmin] = date("i");
        $_POST[endmin] = date("i");
    }
 
    if (!isset($_POST[options]))
    {
        $_POST[options] = 2;
    }
    $_POST[options] += $_POST[optionsadd];

    if (isset($_POST[type]))
    {
        $_POST[type] = "checked";
    }

    if (!isset($_POST[endmonat]))
    {
        $_POST[endmonat] = ($_POST[nowmonat] < 12) ? ($_POST[nowmonat] + 1) : 1;
        $enddate = mktime(0, 0, 0, $_POST[endmonat], $_POST[nowtag], $_POST[nowjahr]);
        $_POST[endmonat] = date("m", $enddate);
    }
    
    if (!isset($_POST[endjahr]))
    {
        $_POST[endjahr] = ($_POST[nowmonat] > $_POST[endmonat]) ? ($_POST[nowjahr] + 1) : $_POST[nowjahr];
    }

    
    echo'
                    <form id="form" action="" method="post">
                        <input type="hidden" value="polladd" name="go">
                        <input id="send" type="hidden" value="0" name="polladd">
                        <input type="hidden" value="'.$_POST[options].'" name="options">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Frage:<br>
                                    <font class="small">Nach was soll gefragt werden</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="60" value="'.$_POST[frage].'" name="frage" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Erscheinungsdatum:<br>
                                    <font class="small">Die Umfrage startet am</font>
                                </td>
                                <td class="config" valign="top">
                                    <input id="startday" class="text" size="1" value="'.$_POST[nowtag].'" name="nowtag" maxlength="2"> .
                                    <input id="startmonth" class="text" size="1" value="'.$_POST[nowmonat].'" name="nowmonat" maxlength="2"> .
                                    <input id="startyear" class="text" size="3" value="'.$_POST[nowjahr].'" name="nowjahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input id="starthour" class="text" size="1" value="'.$_POST[nowstunde].'" name="nowstunde" maxlength="2"> :
                                    <input id="startminute" class="text" size="1" value="'.$_POST[nowmin].'" name="nowmin" maxlength="2"> Uhr
                                    <input onClick=\'document.getElementById("startday").value="'.$jetzt[tag].'";
                                                     document.getElementById("startmonth").value="'.$jetzt[monat].'";
                                                     document.getElementById("startyear").value="'.$jetzt[jahr].'";
                                                     document.getElementById("starthour").value="'.$jetzt[stunde].'";
                                                     document.getElementById("startminute").value="'.$jetzt[minute].'";\' class="button" type="button" value="Jetzt">
                                    <input onClick=\'var startdate = new Date(document.getElementById("startyear").value, document.getElementById("startmonth").value, document.getElementById("startday").value, document.getElementById("starthour").value, document.getElementById("startminute").value);
                                                     var newmonth = startdate.getMonth();
                                                     var Monat = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                                                     document.getElementById("startmonth").value = Monat[newmonth];
                                                     if (Monat[newmonth] == "01")
                                                     {
                                                         document.getElementById("startyear").value = startdate.getFullYear();
                                                     }
                                                     \' class="button" type="button" value="+1 Monat">
                                    <input onClick=\'var startdate = new Date(document.getElementById("startyear").value, document.getElementById("startmonth").value, document.getElementById("startday").value, document.getElementById("starthour").value, document.getElementById("startminute").value);
                                                     var newmonth = startdate.getMonth() - 2;
                                                     if (newmonth == -1)
                                                     {
                                                         newmonth = 11;
                                                     }
                                                     if (newmonth == -2)
                                                     {
                                                         newmonth = 10;
                                                     }
                                                     var Monat = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                                                     document.getElementById("startmonth").value = Monat[newmonth];
                                                     if (Monat[newmonth] == "12")
                                                     {
                                                         document.getElementById("startyear").value = startdate.getFullYear() - 1;
                                                     }
                                                     \' class="button" type="button" value="-1 Monat">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Enddatum:<br>
                                    <font class="small">Die Umfrage endet am</font>
                                </td>
                                <td class="config" valign="top">
                                    <input id="endday"  class="text" size="1" value="'.$_POST[endtag].'" name="endtag" maxlength="2"> .
                                    <input id="endmonth" class="text" size="1" value="'.$_POST[endmonat].'" name="endmonat" maxlength="2"> .
                                    <input id="endyear" class="text" size="3" value="'.$_POST[endjahr].'" name="endjahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input id="endhour" class="text" size="1" value="'.$_POST[endstunde].'" name="endstunde" maxlength="2"> :
                                    <input id="endminute" class="text" size="1" value="'.$_POST[endmin].'" name="endmin" maxlength="2"> Uhr
                                    <input onClick=\'document.getElementById("endday").value="'.$jetzt[tag].'";
                                                     document.getElementById("endmonth").value="'.$jetzt[monat].'";
                                                     document.getElementById("endyear").value="'.$jetzt[jahr].'";
                                                     document.getElementById("endhour").value="'.$jetzt[stunde].'";
                                                     document.getElementById("endminute").value="'.$jetzt[minute].'";\' class="button" type="button" value="Jetzt">
                                    <input onClick=\'var enddate = new Date(document.getElementById("endyear").value, document.getElementById("endmonth").value, document.getElementById("endday").value, document.getElementById("endhour").value, document.getElementById("endminute").value);
                                                     var newmonth = enddate.getMonth();
                                                     var Monat = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                                                     document.getElementById("endmonth").value = Monat[newmonth];
                                                     if (Monat[newmonth] == "01")
                                                     {
                                                         document.getElementById("endyear").value = enddate.getFullYear();
                                                     }
                                                     \' class="button" type="button" value="+1 Monat">
                                    <input onClick=\'var enddate = new Date(document.getElementById("endyear").value, document.getElementById("endmonth").value, document.getElementById("endday").value, document.getElementById("endhour").value, document.getElementById("endminute").value);
                                                     var newmonth = enddate.getMonth() - 2;
                                                     if (newmonth == -1)
                                                     {
                                                         newmonth = 11;
                                                     }
                                                     if (newmonth == -2)
                                                     {
                                                         newmonth = 10;
                                                     }
                                                     var Monat = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                                                     document.getElementById("endmonth").value = Monat[newmonth];
                                                     if (Monat[newmonth] == "12")
                                                     {
                                                         document.getElementById("endyear").value = enddate.getFullYear() - 1;
                                                     }
                                                     \' class="button" type="button" value="-1 Monat">
                                </td>
                            </tr>
    ';

    // Antwortfelder hinzufügen
    for ($i=1; $i<$_POST[options]+1; $i++)
    {
        $j = $i - 1;
        if ($_POST[ant][$j])
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Antwort '.$i.':
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$_POST[ant][$j].'" size="60" name="ant['.$j.']" maxlength="100">
                                </td>
                            </tr>
            ';
        }
        else
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Antwort '.$i.':
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="60" name="ant['.$j.']" maxlength="100">
                                </td>
                            </tr>
            ';
        }
    }

    echo'
                            <tr>
                                <td class="configthin">
                                    &nbsp;
                                </td>
                                <td class="configthin">
                                    <input size="2" class="text" name="optionsadd">
                                    Antwortfelder
                                    <input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Mehrfachauswahl:<br>
                                    <font class="small">Mehrere Antworten können gewählt werden</font>
                                </td>
                                <td class="config" valign="top">
                                    <input value="1" name="type" type="checkbox" '.$_POST[type].'>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <br><input class="button" onClick="javascript:document.getElementById(\'send\').value=\'1\'; document.getElementById(\'form\').submit();" type="button" value="Hinzufügen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>