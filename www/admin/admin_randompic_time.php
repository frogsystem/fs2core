<?php
//////////////////////////////
/// Randompic editieren //////
//////////////////////////////
$startdate = null;
$enddate   = null;
if (!empty($_POST['screen_id'])
    && $_POST['random_action'] == 'edit'
    && $_POST['sended'] == 'edit'
    && isset($_POST['random_id'])
   )
{
    settype($_POST['screen_id'], 'integer');
    settype($_POST['random_id'], 'integer');
    $startdate = mktime($_POST['nowstunde'], $_POST['nowmin'], 0, $_POST['nowmonat'], $_POST['nowtag'], $_POST['nowjahr']);
    $enddate = mktime($_POST['endstunde'], $_POST['endmin'], 0, $_POST['endmonat'], $_POST['endtag'], $_POST['endjahr']);

    if ($startdate < $enddate)
    {
       $update = 'UPDATE '.$global_config_arr['pref']."screen_random
                  SET screen_id = '$_POST[screen_id]',
                      start = '$startdate',
                      end = '$enddate'
                  WHERE random_id = '$_POST[random_id]'";
        mysql_query($update, $FD->sql()->conn() );

        systext('Das zeitgesteuerte Zufallsbild wurde ge&auml;ndert!');
    }
    else
    {
        systext('Das zeitgesteuerte Zufallsbild konnte nicht ge&auml;ndert werden!');
    }

    unset($_POST['random_action']);
    unset($_POST['sended']);
    unset($_POST['random_id']);
    unset($_POST['screen_id']);
}



//////////////////////////////
/// Randompic löschen ////////
//////////////////////////////
elseif ($_POST['random_action'] == 'delete'
    && $_POST['sended'] == 'delete'
    && isset($_POST['random_id'])
   )
{
    settype($_POST['random_id'], 'integer');

    if ($_POST['delete_random'])   // Randompic löschen
    {
        mysql_query('DELETE FROM '.$global_config_arr['pref']."screen_random WHERE random_id = '$_POST[random_id]'", $FD->sql()->conn() );
        systext($FD->text("page", "note_deleted"));
    }
    else
    {
        systext($FD->text("page", "note_notdeleted"));
    }

    unset($_POST['delete_random']);
    unset($_POST['random_action']);
    unset($_POST['sended']);
    unset($_POST['random_id']);
}



//////////////////////////////
/// Randompic editieren //////
//////////////////////////////
elseif ($_POST['random_action'] == 'edit'
        && isset($_POST['random_id'])
       )
{
    settype($_POST['random_id'], 'integer');

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref']."screen_random WHERE random_id = $_POST[random_id]", $FD->sql()->conn() );
    $random_arr = mysql_fetch_assoc($index);

    //Zeitdaten
    $random_arr['start_d'] = date('d', $random_arr['start']);
    $random_arr['start_m'] = date('m', $random_arr['start']);
    $random_arr['start_y'] = date('Y', $random_arr['start']);
    $random_arr['start_h'] = date('H', $random_arr['start']);
    $random_arr['start_min'] = date('i', $random_arr['start']);

    $random_arr['end_d'] = date('d', $random_arr['end']);
    $random_arr['end_m'] = date('m', $random_arr['end']);
    $random_arr['end_y'] = date('Y', $random_arr['end']);
    $random_arr['end_h'] = date('H', $random_arr['end']);
    $random_arr['end_min'] = date('i', $random_arr['end']);

    //Zeit-Array für Jetzt Button
    $jetzt['time'] = time();
    $jetzt['tag'] = date('d', $jetzt['time']);
    $jetzt['monat'] = date('m', $jetzt['time']);
    $jetzt['jahr'] = date('Y', $jetzt['time']);
    $jetzt['stunde'] = date('H', $jetzt['time']);
    $jetzt['minute'] = date('i', $jetzt['time']);

    //Error Message
    if ($_POST['sended'] == 'edit') {
        systext ($FD->text("admin", "note_notfilled"));

        $random_arr['start_d'] = $_POST['start_d'];
        $random_arr['start_m'] = $_POST['start_m'];
        $random_arr['start_y'] = $_POST['start_y'];
        $random_arr['start_h'] = $_POST['start_h'];
        $random_arr['start_min'] = $_POST['start_min'];

        $random_arr['end_d'] = $_POST['end_d'];
        $random_arr['end_m'] = $_POST['end_m'];
        $random_arr['end_y'] = $_POST['end_y'];
        $random_arr['end_h'] = $_POST['end_h'];
        $random_arr['end_min'] = $_POST['end_min'];
    }

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="timedpic_edit" name="go">
                        <input type="hidden" value="edit" name="random_action">
                        <input type="hidden" value="edit" name="sended">
                        <input type="hidden" value="'.$random_arr['random_id'].'" name="random_id">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="160">
                                    Bild:<br>
                                    <font class="small">Bild ausw&auml;hlen</font>
                                </td>
                                <td valign="top" width="240">
                                    <input type="button" class="button" value="Bild ausw&auml;hlen" onClick=\'open("admin_findpicture.php","Bild","width=360,height=300,screenX=50,screenY=50,scrollbars=YES")\'">
                                    <input type="text" id="screen_selectortext" value="'. (!empty($random_arr['screen_id'])?'Bild ausgew&auml;hlt!':'Kein Bild gew&auml;hlt!') .'" size="17" readonly="readonly" class="text">
                                    <input type="hidden" id="screen_id" name="screen_id" value="'.$random_arr['screen_id'].'">
                                </td>
                                <td class="config" valign="top" width="200">
                                    <img id="selected_pic" src="'.image_url('images/screenshots/', $random_arr['screen_id'].'_s').'" alt="" />
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Startzeit:<br>
                                    <font class="small">Bild soll angezeigt werden ab</font>
                                </td>
                                <td class="config" valign="top" colspan="2">
                                    <input id="startday" class="text" size="1" value="'.$random_arr['start_d'].'" name="nowtag" maxlength="2"> .
                                    <input id="startmonth" class="text" size="1" value="'.$random_arr['start_m'].'" name="nowmonat" maxlength="2"> .
                                    <input id="startyear" class="text" size="3" value="'.$random_arr['start_y'].'" name="nowjahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input id="starthour" class="text" size="1" value="'.$random_arr['start_h'].'" name="nowstunde" maxlength="2"> :
                                    <input id="startminute" class="text" size="1" value="'.$random_arr['start_min'].'" name="nowmin" maxlength="2"> Uhr
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
                                    <input id="endday"  class="text" size="1" value="'.$random_arr['end_d'].'" name="endtag" maxlength="2"> .
                                    <input id="endmonth" class="text" size="1" value="'.$random_arr['end_m'].'" name="endmonat" maxlength="2"> .
                                    <input id="endyear" class="text" size="3" value="'.$random_arr['end_y'].'" name="endjahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input id="endhour" class="text" size="1" value="'.$random_arr['end_h'].'" name="endstunde" maxlength="2"> :
                                    <input id="endminute" class="text" size="1" value="'.$random_arr['end_min'].'" name="endmin" maxlength="2"> Uhr
                                    <input onClick=\'document.getElementById("endday").value="'.$jetzt['tag'].'";
                                                     document.getElementById("endmonth").value="'.$jetzt['monat'].'";
                                                     document.getElementById("endyear").value="'.$jetzt['jahr'].'";
                                                     document.getElementById("endhour").value="'.$jetzt['stunde'].'";
                                                     document.getElementById("endminute").value="'.$jetzt['minute'].'";\' class="button" type="button" value="Jetzt">
                                    <input onClick=\'changeDate ("endday", "endmonth", "endyear", "endhour", "endminute", "7", "0", "0", "0", "0");\' class="button" type="button" value="+1 Woche">
                                    <input onClick=\'changeDate ("endday", "endmonth", "endyear", "endhour", "endminute", "-7", "0", "0", "0", "0");\' class="button" type="button" value="-1 Woche">
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td></td>
                                <td align="left" colspan="2">
                                    <input class="button" type="submit" value="&Auml;nderungen speichern">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

}



//////////////////////////////
/// Randompic löschen ////////
//////////////////////////////
elseif ($_POST['random_action'] == 'delete'
        && isset($_POST['random_id'])
       )
{
    settype($_POST['random_id'], 'integer');

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref']."screen_random WHERE random_id = $_POST[random_id]", $FD->sql()->conn() );
    $random_arr = mysql_fetch_assoc($index);

    $random_arr['start'] = date('d.m.Y H:i ', $random_arr['start']) . 'Uhr';
    $random_arr['end'] = date('d.m.Y H:i ', $random_arr['end']) . 'Uhr';

    $index = mysql_query('SELECT screen_name FROM '.$global_config_arr['pref']."screen WHERE screen_id = $random_arr[screen_id]", $FD->sql()->conn() );
    $random_arr['title'] = mysql_result($index,0,'screen_name');

    if ($random_arr['title'] != '') {
        $random_arr['title'] = '<b>'.killhtml($random_arr['title']).'</b><br /><br />';
    } else {
        $random_arr['title'] = '<br />';
    }

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="timedpic_edit" name="go">
                        <input type="hidden" value="delete" name="random_action">
                        <input type="hidden" value="delete" name="sended">
                        <input type="hidden" value="'.$random_arr['random_id'].'" name="random_id">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr align="left" valign="top">
                                <td class="config" colspan="2">
                                    '.$FD->text("page", "delpic").':<br />
                                    <span class="small">'.$FD->text("page", "delnote").'</span>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr valign="top">
                                <td class="config" colspan="2">
                                    <img src="'.image_url('images/screenshots/', $random_arr['screen_id'].'_s').'" alt=""  style="float:left; padding-right:10px;" />
                                    '.$random_arr['title'].'
                                    <span class="small">aktiv vom <b>'.$random_arr['start'].'</b><br />
                                    bis zum <b>'.$random_arr['end'].'</b></span>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr valign="top">
                                <td width="50%" class="config">
                                    '.$FD->text("page", "delpic_question").'
                                </td>
                                <td width="50%" align="right">
                                    <select name="delete_random" size="1">
                                        <option value="0">'.$FD->text("page", "delnotconfirm").'</option>
                                        <option value="1">'.$FD->text("page", "delconfirm").'</option>
                                    </select>
                                    <input type="submit" value="'.$FD->text("admin", "do_button").'" class="button" />
                                </td>
                            </tr>
                        </table>
                    </form>';
}



//////////////////////////////
/// Randompic Auswahl ////////
//////////////////////////////
if (!isset($_POST['random_id']))
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="timedpic_edit" name="go">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr><td></td></tr>
                            <tr>
                                <td></td>
                                <td class="config">
                                    '.$FD->text("page", "title").'
                                </td>
                                <td class="config">
                                    '.$FD->text("page", "start_time").'
                                </td>
                                <td class="config">
                                    '.$FD->text("page", "end_time").'
                                </td>
                                <td class="config" style="text-align:right;">
                                    '.$FD->text("admin", "selection").'
                                </td>
                            </tr>
    ';
    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'screen_random a, '.$global_config_arr['pref'].'screen b WHERE a.screen_id = b.screen_id ORDER BY a.end DESC', $FD->sql()->conn() );
    while ($random_arr = mysql_fetch_assoc($index))
    {
        $random_arr['start'] = date('d.m.Y H:i', $random_arr['start']);
        $random_arr['end'] = date('d.m.Y H:i', $random_arr['end']);

        echo'
                            <tr style="cursor:pointer;"
onmouseover=\'
  colorOver (document.getElementById("input_'.$random_arr['random_id'].'"), "#EEEEEE", "#64DC6A", this);\'
onmouseout=\'
  colorOut (document.getElementById("input_'.$random_arr['random_id'].'"), "transparent", "#49c24f", this);\'
onClick=\'
  createClick(document.getElementById("input_'.$random_arr['random_id'].'"));
  resetUnclicked("reset", "transparent");
  colorClick (document.getElementById("input_'.$random_arr['random_id'].'"), "#EEEEEE", "#64DC6A", this);\'
                              >
                                <td class="configthin">
                                    <img src="'.image_url('images/screenshots/', $random_arr['screen_id'].'_s').'" alt="" />
                                </td>
                                 <td class="configthin">
                                    '.$random_arr['screen_name'].'
                                </td>
                                <td class="configthin">
                                    '.$random_arr['start'].'
                                </td>
                                <td class="configthin">
                                    '.$random_arr['end'].'
                                </td>
                                <td class="configthin" style="text-align:right;">
                                    <input type="radio" name="random_id" id="input_'.$random_arr['random_id'].'" value="'.$random_arr['random_id'].'" style="cursor:pointer;" onClick=\'createClick(this);\' />
                                </td>
                            </tr>

        ';
    }
    echo'
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td class="config" colspan="5" style="text-align:center;">
                                   <select name="random_action" size="1">
                                     <option value="edit">'.$FD->text("admin", "selection_edit").'</option>
                                     <option value="delete">'.$FD->text("admin", "selection_del").'</option>
                                   </select>
                                   <input class="button" type="submit" value="'.$FD->text("admin", "do_button").'">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
