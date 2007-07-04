<?php
//////////////////////////////////
//// Zeitgest. Zb. eintragen /////
//////////////////////////////////
$startdate = null;
$enddate   = null;
if (!empty($_POST['screen_id'])) {
    $startdate = mktime($_POST['sstunde'], $_POST['smin'], 0, $_POST['smonat'], $_POST['stag'], $_POST['sjahr']);
    $enddate = mktime($_POST['estunde'], $_POST['emin'], 0, $_POST['emonat'], $_POST['etag'], $_POST['ejahr']);
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
    if (!isset($_POST['stag']))
    {
        $_POST['stag'] = date("d");
    }
    if (!isset($_POST['smonat']))
    {
        $_POST['smonat'] = date("m");
    }
    if (!isset($_POST['sjahr']))
    {
        $_POST['sjahr'] = date("Y");
    }
    if (!isset($_POST['sstunde']))
    {
        $_POST['sstunde'] = date("H");
    }
    if (!isset($_POST['smin']))
    {
        $_POST['smin'] = date("i");
    }
    if (!isset($_POST['etag']))
    {
        $_POST['etag'] = date("d");
    }
    if (!isset($_POST['emonat']))
    {
        $_POST['emonat'] = date("m");
    }
    if (!isset($_POST['ejahr']))
    {
        $_POST['ejahr'] = date("Y");
    }
    if (!isset($_POST['estunde']))
    {
        $_POST['estunde'] = date("H");
    }
    if (!isset($_POST['emin']))
    {
        $_POST['emin'] = date("i");
    }

    echo'
                    <form action="'.$PHP_SELF.'" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="randompic_time_add" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Bild auswählen</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="button" class="Button" value="Bild ausw&auml;hlen" onClick=\'open("admin_findpicture.php","Bild","width=480,height=300,screenX=50,screenY=50,scrollbars=YES")\'"> <input type="text" id="screen_selectortext" value="'. (!empty($_POST['screen_id'])?'Bild ausgew&auml;hlt!':'Kein Bild ausgew&auml;hlt') .'" size="17" readonly>
                                    <input type="hidden" id="screen_id" name="screen_id" value="'. $_POST['screen_id'] .'">
                                </td>
                                <td class="config" valign="top">
                                    <img id="selected_pic" src="img/no_pic2.gif" alt="" />
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Startzeit:<br>
                                    <font class="small">Bild soll angezeigt werden ab</font>
                                </td>
                                <td class="config" valign="top">
                                        <input class="text" size="2" value="'.$_POST['stag'].'" name="stag" maxlength="2">
                                    <input class="text" size="2" value="'.$_POST['smonat'].'" name="smonat" maxlength="2">
                                    <input class="text" size="4" value="'.$_POST['sjahr'].'" name="sjahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input class="text" size="2" value="'.$_POST['sstunde'].'" name="sstunde" maxlength="2">
                                    <input class="text" size="2" value="'.$_POST['smin'].'" name="smin" maxlength="2">

                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Endzeit:<br>
                                    <font class="small">Bild soll angezeigt werden bis</font>
                                </td>
                                <td class="config" valign="top">
                                        <input class="text" size="2" value="'.$_POST['etag'].'" name="etag" maxlength="2">
                                    <input class="text" size="2" value="'.$_POST['emonat'].'" name="emonat" maxlength="2">
                                    <input class="text" size="4" value="'.$_POST['ejahr'].'" name="ejahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input class="text" size="2" value="'.$_POST['estunde'].'" name="estunde" maxlength="2">
                                    <input class="text" size="2" value="'.$_POST['emin'].'" name="emin" maxlength="2">

                                </td>
                            </tr>

                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>