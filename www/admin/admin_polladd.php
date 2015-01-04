<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//////////////////
//// Add poll ////
//////////////////

if (isset($_POST['polladd']) && !isset($_POST['add_answers']) && isset($_POST['frage']) && !emptystr($_POST['ant'][0]) && !emptystr($_POST['ant'][1]))
{
    settype($_POST['type'], 'integer');
    $adate = mktime($_POST['nowstunde'], $_POST['nowmin'], 0, $_POST['nowmonat'], $_POST['nowtag'], $_POST['nowjahr']);
    $edate = mktime($_POST['endstunde'], $_POST['endmin'], 0, $_POST['endmonat'], $_POST['endtag'], $_POST['endjahr']);

    $_POST['type'] = ($_POST['type'] == 1) ? 1 : 0;

    // Insert poll into DB
    $stmt = $FD->db()->conn()->prepare(
                'INSERT INTO '.$FD->config('pref')."poll (poll_quest, poll_start, poll_end, poll_type)
                 VALUES (?,
                         '$adate',
                         '$edate',
                         '".$_POST['type']."')");
    $stmt->execute(array($_POST['frage']));

    // Insert answers into DB
    $stmt = $FD->db()->conn()->prepare('SELECT poll_id FROM '.$FD->config('pref').'poll WHERE poll_quest = ?');
    $stmt->execute(array($_POST['frage']));
    $id = $stmt->fetchColumn();

    $stmt = $FD->db()->conn()->prepare(
                  'INSERT INTO '.$FD->config('pref')."poll_answers (poll_id, answer)
                   VALUES ('$id', ?)");
    for ($i=0; $i<count($_POST['ant']); $i++)
    {
        if (!emptystr($_POST['ant'][$i])) {
            $stmt->execute(array($_POST['ant'][$i]));
        }
    }
    systext('Umfrage wurde hinzugef&uuml;gt');
    unset($_POST);
}

/////////////////////
///// Poll Form /////
/////////////////////

if(true)
{
    if(isset($_POST['sended']) && !isset($_POST['add_answers'])) {
        echo get_systext($FD->text("admin", "changes_not_saved").'<br>'.$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), 'red', $FD->text("admin", "icon_save_error"));
    }

    //time array for "Now" Button
    $jetzt['tag'] = date('d');
    $jetzt['monat'] = date('m');
    $jetzt['jahr'] = date('Y');
    $jetzt['stunde'] = date('H');
    $jetzt['minute'] = date('i');

    if (!isset($_POST['nowtag']))
    {
        $_POST['nowtag'] = date('d');
        $_POST['endtag'] = date('d');
    }
    if (!isset($_POST['nowmonat']))
    {
        $_POST['nowmonat'] = date('m');
    }
    if (!isset($_POST['nowjahr']))
    {
        $_POST['nowjahr'] = date('Y');
    }
    if (!isset($_POST['nowstunde']))
    {
        $_POST['nowstunde'] = date('H');
        $_POST['endstunde'] = date('H');
    }
    if (!isset($_POST['nowmin']))
    {
        $_POST['nowmin'] = date('i');
        $_POST['endmin'] = date('i');
    }

    if (!isset($_POST['options']))
    {
        $_POST['options'] = 2;
    }
    if (!isset($_POST['optionsadd']))
    {
      $_POST['optionsadd'] = '';
    }
    $_POST['options'] += $_POST['optionsadd'];

    if (isset($_POST['type']))
    {
        $_POST['type'] = 'checked';
    }
    else
    {
        $_POST['type'] = '';
    }

    if (!isset($_POST['endmonat']))
    {
        $_POST['endmonat'] = ($_POST['nowmonat'] < 12) ? ($_POST['nowmonat'] + 1) : 1;
        $enddate = mktime(0, 0, 0, $_POST['endmonat'], $_POST['nowtag'], $_POST['nowjahr']);
        $_POST['endmonat'] = date('m', $enddate);
    }

    if (!isset($_POST['endjahr']))
    {
        $_POST['endjahr'] = ($_POST['nowmonat'] > $_POST['endmonat']) ? ($_POST['nowjahr'] + 1) : $_POST['nowjahr'];
    }

    if(!isset($_POST['frage']))
    {
      $_POST['frage'] = '';
    }

    echo'
                    <form id="form" action="" method="post">
                        <input type="hidden" name="go" value="poll_add">
                        <input type="hidden" name="sended" value="add">
                        <input id="send" type="hidden" value="0" name="polladd">
                        <input type="hidden" value="'.$_POST['options'].'" name="options">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Umfrage hinzuf&uuml;gen</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top" width="120">
                                    Frage:<br>
                                    <font class="small">Nach was soll gefragt werden</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="60" value="'.$_POST['frage'].'" name="frage" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Erscheinungsdatum:<br>
                                    <font class="small">Die Umfrage startet am</font>
                                </td>
                                <td class="config" valign="top">
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
                                                     document.getElementById("startminute").value="'.$jetzt['minute'].'";\' type="button" value="Jetzt">
                                    <input onClick=\'var startdate = new Date(document.getElementById("startyear").value, document.getElementById("startmonth").value, document.getElementById("startday").value, document.getElementById("starthour").value, document.getElementById("startminute").value);
                                                     var newmonth = startdate.getMonth();
                                                     var Monat = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                                                     document.getElementById("startmonth").value = Monat[newmonth];
                                                     if (Monat[newmonth] == "01")
                                                     {
                                                         document.getElementById("startyear").value = startdate.getFullYear();
                                                     }
                                                     \'  type="button" value="+1 Monat">
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
                                                     \'  type="button" value="-1 Monat">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Enddatum:<br>
                                    <font class="small">Die Umfrage endet am</font>
                                </td>
                                <td class="config" valign="top">
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
                                                     document.getElementById("endminute").value="'.$jetzt['minute'].'";\'  type="button" value="Jetzt">
                                    <input onClick=\'var enddate = new Date(document.getElementById("endyear").value, document.getElementById("endmonth").value, document.getElementById("endday").value, document.getElementById("endhour").value, document.getElementById("endminute").value);
                                                     var newmonth = enddate.getMonth();
                                                     var Monat = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                                                     document.getElementById("endmonth").value = Monat[newmonth];
                                                     if (Monat[newmonth] == "01")
                                                     {
                                                         document.getElementById("endyear").value = enddate.getFullYear();
                                                     }
                                                     \'  type="button" value="+1 Monat">
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
                                                     \'  type="button" value="-1 Monat">
                                </td>
                            </tr>
    ';

    // add fields for answer options
    for ($i=1; $i<$_POST['options']+1; $i++)
    {
        $j = $i - 1;
        if (isset($_POST['ant'][$j]))
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Antwort '.$i.':
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$_POST['ant'][$j].'" size="60" name="ant['.$j.']" maxlength="100">
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
                                    <input size="2" maxlength="2" class="text" name="optionsadd">
                                    Antwortfelder
                                    <input type="submit" name="add_answers" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Mehrfachauswahl:<br>
                                    <font class="small">Mehrere Antworten k&ouml;nnen gew&auml;hlt werden</font>
                                </td>
                                <td class="config" valign="top">
                                    <input value="1" name="type" type="checkbox" '.$_POST['type'].'>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <br><input class="button" type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
