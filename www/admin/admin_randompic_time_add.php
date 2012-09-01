<?php
//////////////////////////////////
//// Zeitgest. Zb. eintragen /////
//////////////////////////////////
$startdate = null;
$enddate   = null;
if (!empty($_POST['screen_id'])) {
    $startdate = mktime($_POST['nowstunde'], $_POST['nowmin'], 0, $_POST['nowmonat'], $_POST['nowtag'], $_POST['nowjahr']);
    $enddate = mktime($_POST['endstunde'], $_POST['endmin'], 0, $_POST['endmonat'], $_POST['endtag'], $_POST['endjahr']);
}
if ($startdate < $enddate) {
    settype($_POST['screen_id'], 'integer');
    mysql_query('INSERT INTO '.$FD->config('pref')."screen_random (screen_id, start, end)
                 VALUES ('". $_POST['screen_id'] ."',
                         '". $startdate ."',
                         '". $enddate ."'
                        )", $FD->sql()->conn() );
    systext('Zeitgesteuertes Zufallsbild wurde hinzugef&uuml;gt');
}
/////////////////////////////
//// Screenshot Formular ////
/////////////////////////////
else
{

    //Zeit-Array für Jetzt Button
    $jetzt['time'] = time();
    $jetzt['tag'] = date('d', $jetzt['time']);
    $jetzt['monat'] = date('m', $jetzt['time']);
    $jetzt['jahr'] = date('Y', $jetzt['time']);
    $jetzt['stunde'] = date('H', $jetzt['time']);
    $jetzt['minute'] = date('i', $jetzt['time']);

    if (!isset($_POST['sended']))
    {
        $_POST['nowtag'] = $jetzt['tag'];
        $_POST['nowmonat'] = $jetzt['monat'];
        $_POST['nowjahr'] = $jetzt['jahr'];
        $_POST['nowstunde'] = $jetzt['stunde'];
        $_POST['nowmin'] = $jetzt['minute'];

        $end = $jetzt['time'] + 7*24*60*60;
        $_POST['endtag'] = date('d', $end);
        $_POST['endmonat'] = date('m', $end);
        $_POST['endjahr'] = date('Y', $end);
        $_POST['endstunde'] = date('H', $end);
        $_POST['endmin'] = date('i', $end);
    }

    if (!isset($_POST['screen_id'])) $_POST['screen_id'] = '';

    echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="timedpic_add" name="go">
                        <input type="hidden" value="1" name="sended">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="160">
                                    Bild:<br>
                                    <font class="small">Bild ausw&auml;hlen</font>
                                </td>
                                <td valign="top" width="240">
                                    <input type="button" class="button" value="Bild ausw&auml;hlen" onClick=\'open("admin_findpicture.php","Bild","width=360,height=300,screenX=50,screenY=50,scrollbars=YES")\'>
                                    <input type="text" id="screen_selectortext" value="'. (!empty($_POST['screen_id'])?'Bild ausgew&auml;hlt!':'Kein Bild gew&auml;hlt!') .'" size="17" readonly="readonly" class="text">
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
                                    <input id="startday" class="text" size="1" value="'.$_POST['nowtag'].'" name="nowtag" maxlength="2"> .
                                    <input id="startmonth" class="text" size="1" value="'.$_POST['nowmonat'].'" name="nowmonat" maxlength="2"> .
                                    <input id="startyear" class="text" size="3" value="'.$_POST['nowjahr'].'" name="nowjahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input id="starthour" class="text" size="1" value="'.$_POST['nowstunde'].'" name="nowstunde" maxlength="2"> :
                                    <input id="startminute" class="text" size="1" value="'.$_POST['nowmin'].'" name="nowmin" maxlength="2"> Uhr
                                    <input onClick=\'document.getElementById("startday").value="'.$jetzt['tag'].'";
                                                     document.getElementById("startmonth").value="'.$jetzt['monat'].'";
                                                     document.getElementById("startyear").value="'.$jetzt['jahr'].'";
                                                     document.getElementById("starthour").value="'.$jetzt['stunde'].'";
                                                     document.getElementById("startminute").value="'.$jetzt['minute'].'";\' class="button" type="button" value="Jetzt">
                                    <input onClick=\'changeDate ("startday", "startmonth", "startyear", "starthour", "startminute", "7", "0", "0", "0", "0");\' class="button" type="button" value="+1 Woche">
                                    <input onClick=\'changeDate ("startday", "startmonth", "startyear", "starthour", "startminute", "-7", "0", "0", "0", "0");\' class="button" type="button" value="-1 Woche">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Endzeit:<br>
                                    <font class="small">Bild soll angezeigt werden bis</font>
                                </td>
                                <td class="config" valign="top" colspan="2">
                                    <input id="endday"  class="text" size="1" value="'.$_POST['endtag'].'" name="endtag" maxlength="2"> .
                                    <input id="endmonth" class="text" size="1" value="'.$_POST['endmonat'].'" name="endmonat" maxlength="2"> .
                                    <input id="endyear" class="text" size="3" value="'.$_POST['endjahr'].'" name="endjahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input id="endhour" class="text" size="1" value="'.$_POST['endstunde'].'" name="endstunde" maxlength="2"> :
                                    <input id="endminute" class="text" size="1" value="'.$_POST['endmin'].'" name="endmin" maxlength="2"> Uhr
                                    <input onClick=\'document.getElementById("endday").value="'.$jetzt['tag'].'";
                                                     document.getElementById("endmonth").value="'.$jetzt['monat'].'";
                                                     document.getElementById("endyear").value="'.$jetzt['jahr'].'";
                                                     document.getElementById("endhour").value="'.$jetzt['stunde'].'";
                                                     document.getElementById("endminute").value="'.$jetzt['minute'].'";\' class="button" type="button" value="Jetzt">
                                    <input onClick=\'changeDate ("endday", "endmonth", "endyear", "endhour", "endminute", "7", "0", "0", "0", "0");\' class="button" type="button" value="+1 Woche">
                                    <input onClick=\'changeDate ("endday", "endmonth", "endyear", "endhour", "endminute", "-7", "0", "0", "0", "0");\' class="button" type="button" value="-1 Woche">
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td align="left" colspan="2">
                                    <input class="button" type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
