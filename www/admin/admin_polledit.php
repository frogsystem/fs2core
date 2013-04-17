<?php if (!defined('ACP_GO')) die('Unauthorized access!');

///////////////////////////////
//// Umfrage aktualisieren ////
///////////////////////////////

if (isset($_POST['polledit']) && !isset($_POST['add_answers']) && isset($_POST['editpollid']) && isset($_POST['delpoll']) && $_POST['delpoll'] == 1)
{
    // Umfrage löschen
    $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."poll WHERE poll_id = '".intval($_POST['editpollid'])."'");
    $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."poll_answers WHERE poll_id = '".intval($_POST['editpollid'])."'");
    systext('Die Umfrage wurde gel&ouml;scht');
}
elseif (isset($_POST['polledit']) && !isset($_POST['add_answers']) && isset($_POST['frage']) && !emptystr($_POST['ant'][0]) && !emptystr($_POST['ant'][1]))
{

    for($i=0; $i<count($_POST['ant']); $i++)
    {
        settype($_POST['count'][$i], 'integer');
        settype($_POST['id'][$i], 'integer');
    }

    $adate = mktime($_POST['astunde'], $_POST['amin'], 0, $_POST['amonat'], $_POST['atag'], $_POST['ajahr']);
    $edate = mktime($_POST['estunde'], $_POST['emin'], 0, $_POST['emonat'], $_POST['etag'], $_POST['ejahr']);

    $_POST['type'] = isset($_POST['type']) ? 1 : 0;
    settype($_POST['participants'], 'integer');

    // Umfrage in der DB aktualisieren
    $stmt = $FD->sql()->conn()->prepare(
              'UPDATE '.$FD->config('pref')."poll
               SET poll_quest = ?,
                   poll_start = '$adate',
                   poll_end   = '$edate',
                   poll_type  = '$_POST[type]',
                   poll_participants  = '$_POST[participants]'
               WHERE poll_id = ?");
    $stmt->execute(array($_POST['frage'], $_POST['editpollid']));

    // Antworten in der DB aktualisieren
    for($i=0; $i<count($_POST['ant']); $i++)
    {
        if (isset($_POST['dela'][$i]) || emptystr($_POST['ant'][$i]))
        {
            $FD->sql()->conn()->query('DELETE FROM '.$FD->config('pref').'poll_answers WHERE answer_id = ' . $_POST['id'][$i] );
        }
        else
        {
            if (!isset($_POST['count'][$i]))
            {
                $_POST['count'][$i] = 0;
            }

            if (!emptystr($_POST['ant'][$i])) {
                if (!$_POST['id'][$i] && $_POST['ant'][$i])
                {
                    $stmt = $FD->sql()->conn()->prepare(
                                'INSERT INTO '.$FD->config('pref')."poll_answers (poll_id, answer, answer_count)
                                 VALUES (?,
                                         ?,
                                         ?)");
                    $stmt->execute(array($_POST['editpollid'], $_POST['ant'][$i], $_POST['count'][$i]));
                }
                else
                {
                    $stmt = $FD->sql()->conn()->prepare(
                              'UPDATE '.$FD->config('pref').'poll_answers
                               SET answer       = ?,
                                   answer_count = ?
                               WHERE answer_id = ?');
                    $stmt->execute(array($_POST['ant'][$i], $_POST['count'][$i], $_POST['id'][$i]));
                }
            }
        }
    }
    systext('Umfrage wurde aktualisiert');
    unset($_POST);
}

///////////////////////////////
////// Umfrage editieren //////
///////////////////////////////

if (isset($_POST['pollid']))
{
    $_POST['pollid'] = $_POST['pollid'][0];

     if(isset($_POST['sended'])  && !isset($_POST['add_answers'])) {
        echo get_systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));
    }



    //Zeit-Array für Jetzt Button
    $jetzt['tag'] = date('d');
    $jetzt['monat'] = date('m');
    $jetzt['jahr'] = date('Y');
    $jetzt['stunde'] = date('H');
    $jetzt['minute'] = date('i');

    if (isset($_POST['tempid']))
    {
        $_POST['pollid'] = $_POST['tempid'];
    }

    settype($_POST['pollid'], 'integer');
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."poll WHERE poll_id = '$_POST[pollid]'");
    $row = $index->fetch(PDO::FETCH_ASSOC);

    if (!isset($_POST['frage']))
    {
        $_POST['frage'] = $row['poll_quest'];
    }

    $dbpollstart = $row['poll_start'];
    if (!isset($_POST['atag']))
    {
        $_POST['atag'] = date('d', $dbpollstart);
    }
    if (!isset($_POST['amonat']))
    {
        $_POST['amonat'] = date('m', $dbpollstart);
    }
    if (!isset($_POST['ajahr']))
    {
        $_POST['ajahr'] = date('Y', $dbpollstart);
    }
    if (!isset($_POST['astunde']))
    {
        $_POST['astunde'] = date('H', $dbpollstart);
    }
    if (!isset($_POST['amin']))
    {
        $_POST['amin'] = date('i', $dbpollstart);
    }

    $dbpollend = $row['poll_end'];
    if (!isset($_POST['etag']))
    {
        $_POST['etag'] = date('d', $dbpollend);
    }
    if (!isset($_POST['emonat']))
    {
        $_POST['emonat'] = date('m', $dbpollend);
    }
    if (!isset($_POST['ejahr']))
    {
        $_POST['ejahr'] = date('Y', $dbpollend);
    }
    if (!isset($_POST['estunde']))
    {
        $_POST['estunde'] = date('H', $dbpollend);
    }
    if (!isset($_POST['emin']))
    {
        $_POST['emin'] = date('i', $dbpollend);
    }

    if (!isset($_POST['type']))
    {
        $_POST['type'] = $row['poll_type'];
    }
    if ($_POST['type'] == 1)
    {
        $_POST['type'] = 'checked';
    }

    if (!isset($_POST['participants']))
    {
        $_POST['participants'] = $row['poll_participants'];
    }

    $index = $FD->sql()->conn()->query('SELECT COUNT(*) FROM '.$FD->config('pref')."poll_answers WHERE poll_id = '$_POST[pollid]'");
    $rows = $index->fetchColumn();
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."poll_answers WHERE poll_id = '$_POST[pollid]' ORDER BY answer_id");
    for($i=0; $i<$rows; $i++)
    {
        $row = $index->fetch(PDO::FETCH_ASSOC);
        if (!isset($_POST['ant'][$i]))
        {
            $_POST['ant'][$i] = $row['answer'];
        }
        if (!isset($_POST['id'][$i]))
        {
            $_POST['id'][$i] = $row['answer_id'];
        }
        if (!isset($_POST['count'][$i]))
        {
            $_POST['count'][$i] = $row['answer_count'];
        }
    }

    if (!isset($_POST['options']))
    {
        $_POST['options'] = count($_POST['ant']);
    }
    $_POST['options'] += $_POST['optionsadd'];

    echo'
                    <form id="form" action="" method="post">
                        <input type="hidden" value="poll_edit" name="go">
                        <input id="send" type="hidden" value="0" name="polledit">
                        <input id="send" type="hidden" value="edit" name="sended">
                        <input type="hidden" value="'.$_POST['pollid'].'" name="tempid">
                        <input type="hidden" value="'.$_POST['options'].'" name="options">
                        <input type="hidden" value="'.$_POST['pollid'].'" name="editpollid">
                        <input type="hidden" value="'.$_POST['pollid'].'" name="pollid[0]">
                        <table class="content select_list" cellpadding="3" cellspacing="0">
                            <tr><td colspan="5"><h3>Umfrage bearbeiten</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Frage:<br>
                                    <font class="small">Nach was soll gefragt werden</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="60" name="frage" value="'.killhtml(unslash($_POST['frage'])).'" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Erscheinungsdatum:<br>
                                    <font class="small">Die Umfrage startet am</font>
                                </td>
                                <td class="config" valign="top">
                                    <input id="startday" class="text" size="1" value="'.$_POST['atag'].'" name="atag" maxlength="2"> .
                                    <input id="startmonth" class="text" size="1" value="'.$_POST['amonat'].'" name="amonat" maxlength="2"> .
                                    <input id="startyear" class="text" size="3" value="'.$_POST['ajahr'].'" name="ajahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input id="starthour" class="text" size="1" value="'.$_POST['astunde'].'" name="astunde" maxlength="2"> :
                                    <input id="startminute" class="text" size="1" value="'.$_POST['amin'].'" name="amin" maxlength="2"> Uhr
                                    <input onClick=\'document.getElementById("startday").value="'.$jetzt['tag'].'";
                                                     document.getElementById("startmonth").value="'.$jetzt['monat'].'";
                                                     document.getElementById("startyear").value="'.$jetzt['jahr'].'";
                                                     document.getElementById("starthour").value="'.$jetzt['stunde'].'";
                                                     document.getElementById("startminute").value="'.$jetzt['minute'].'";\'  type="button" value="Jetzt">
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
                                    <input id="endday"  class="text" size="1" value="'.$_POST['etag'].'" name="etag" maxlength="2"> .
                                    <input id="endmonth" class="text" size="1" value="'.$_POST['emonat'].'" name="emonat" maxlength="2"> .
                                    <input id="endyear" class="text" size="3" value="'.$_POST['ejahr'].'" name="ejahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input id="endhour" class="text" size="1" value="'.$_POST['estunde'].'" name="estunde" maxlength="2"> :
                                    <input id="endminute" class="text" size="1" value="'.$_POST['emin'].'" name="emin" maxlength="2"> Uhr
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

    // Antwortfelder erzeugen
    for($i=0; $i<$_POST['options']; $i++)
    {
        $j = $i + 1;
        if ($_POST['ant'][$i])
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Antwort '.$j.':<br>
                                    <font class="small">[Antwort] [Votes] [l&ouml;schen]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="48" name="ant['.$i.']" value="'.killhtml(unslash($_POST['ant'][$i])).'" maxlength="100">
                                    <input class="text" size="5" name="count['.$i.']" value="'.$_POST['count'][$i].'" maxlength="5">
                                    <input name="dela['.$i.']" id="'.$i.'" value="'.$_POST['id'][$i].'" type="checkbox"
                                    onClick=\'delalert ("'.$i.'", "Soll die Antwortmöglichkeit '.$j.' wirklich gelöscht werden?")\'>
                                    <input type="hidden" name="id['.$i.']" value="'.$_POST['id'][$i].'">
                                </td>
                            </tr>
            ';
        }
        else
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Antwort '.$j.':<br>
                                    <font class="small">[Antwort] [Votes]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="48" name="ant['.$i.']" maxlength="100">
                                    <input class="text" size="5" name="count['.$i.']" maxlength="5">
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
                                <td class="config" valign="top">
                                    Teilnehmer:<br>
                                    <font class="small">Wieviele User haben teilgenommen?</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="participants" maxlength="5" value="'.$_POST['participants'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Umfrage l&ouml;schen:
                                </td>
                                <td class="config">
                                    <input onClick=\'delalert ("delpoll", "Soll die Umfrage wirklich gelöscht werden?")\' type="checkbox" name="delpoll" id="delpoll" value="1">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <br><input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

///////////////////////////////
////// Umfrage auswählen //////
///////////////////////////////

else
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="poll_edit" name="go">
                        <table class="content select_list" cellpadding="3" cellspacing="0">
                            <tr><td colspan="5"><h3>Umfrage ausw&auml;hlen</h3><hr></td></tr>
                            <tr>
                                <td class="config" width="50%">
                                    Frage
                                </td>
                                <td class="config" width="16%">
                                    Typ
                                </td>
                                <td class="config" width="12%">
                                    Start
                                </td>
                                <td class="config" width="12%">
                                    Ende
                                </td>
                                <td class="config" width="10%">
                                    bearbeiten
                                </td>
                            </tr>
    ';

    // Umfragen auflisten
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref').'poll ORDER BY poll_start DESC', $FD->sql()->conn() );
    while ($poll_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        $poll_arr['poll_start'] = date('d.m.Y' , $poll_arr['poll_start']) ;
        $poll_arr['poll_end'] = date('d.m.Y' , $poll_arr['poll_end']);
        if ($poll_arr['poll_type'] == 1)
        {
            $poll_arr['poll_type'] = $FD->text("frontend", "multiple_choice");
        }
        else
        {
            $poll_arr['poll_type'] = $FD->text("frontend", "single_choice");
        }
        echo'
                            <tr class="select_entry thin">
                                <td class="configthin">
                                    '.unslash($poll_arr['poll_quest']).'
                                </td>
                                <td class="configthin">
                                    <font class="small">'.$poll_arr['poll_type'].'</font>
                                </td>
                                <td class="configthin">
                                    <font class="small">'.$poll_arr['poll_start'].'</font>
                                </td>
                                <td class="configthin">
                                    <font class="small">'.$poll_arr['poll_end'].'</font>
                                </td>
                                <td class="top center">
                                    <input class="select_box" type="checkbox" name="pollid[]" value="'.$poll_arr['poll_id'].'">
                                </td>
                            </tr>
        ';
    }
    echo'
                            <tr style="display:none">
                                <td colspan="5">
                                    <select class="select_type" name="poll_action" size="1">
                                        <option class="select_one" value="edit">'.$FD->text("admin", "selection_edit").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" align="center">
                                    <input class="button" type="submit" value="editieren">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
