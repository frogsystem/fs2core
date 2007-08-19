<?php
//////////////////////////////////
//// Zeitgest. Zb. eintragen /////
//////////////////////////////////
$startdate = null;
$enddate   = null;
if (!empty($_POST['screen_id'])) {
    $startdate = mktime($_POST[nowstunde], $_POST[nowmin], 0, $_POST[nowmonat], $_POST[nowtag], $_POST[nowjahr]);
    $enddate = mktime($_POST[endstunde], $_POST[endmin], 0, $_POST[endmonat], $_POST[endtag], $_POST[endjahr]);
}
if ($startdate < $enddate) {
    settype($_POST['screen_id'], 'integer');
    mysql_query("INSERT INTO fs_screen_random (screen_id, start, end) 
        VALUES (
            '". $_POST['screen_id'] ."',
            '". $startdate ."',
            '". $enddate ."'
        )", $db);
    systext("Zeitgesteuertes Zufallsbild wurde hinzugefügt");
}
/////////////////////////////
//// Screenshot Formular ////
/////////////////////////////
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
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="randompic_time_add" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="160">
                                    Bild:<br>
                                    <font class="small">Bild auswählen</font>
                                </td>
                                <td valign="top" width="240">
                                    <input type="button" class="button" value="Bild ausw&auml;hlen" onClick=\'open("admin_findpicture.php","Bild","width=360,height=300,screenX=50,screenY=50,scrollbars=YES")\'"> <input type="text" id="screen_selectortext" value="'. (!empty($_POST['screen_id'])?'Bild ausgew&auml;hlt!':'Kein Bild gew&auml;hlt!') .'" size="17" readonly="readonly" class="text">
                                    <input type="hidden" id="screen_id" name="screen_id" value="'. $_POST['screen_id'] .'">
                                </td>
                                <td class="config" valign="top" width="200">
                                    <img id="selected_pic" src="img/no_pic_small.gif" alt="" />
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Startzeit:<br>
                                    <font class="small">Bild soll angezeigt werden ab</font>
                                </td>
                                <td class="config" valign="top" colspan="2">
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
                                    Endzeit:<br>
                                    <font class="small">Bild soll angezeigt werden bis</font>
                                </td>
                                <td class="config" valign="top" colspan="2">
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

                            <tr>
                                <td></td>
                                <td align="left" colspan="2">
                                    <input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>