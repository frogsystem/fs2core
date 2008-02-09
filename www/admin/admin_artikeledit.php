<?php

//////////////////////////
//// DB Aktualisieren ////
//////////////////////////

if ($_POST[url] && $_POST[title] && $_POST[text] && $_POST[cat_id])
{
    if(!isset($_POST[delit]))
    {
        if ($_POST[tag] && $_POST[monat] && $_POST[jahr])
        {
            $date = mktime(0, 0, 0, $_POST[monat], $_POST[tag], $_POST[jahr]);
        }
        else
        {
            $date = 0;
        }

        $_POST[url] = savesql($_POST[url]);
        $index = mysql_query("SELECT artikel_url FROM ".$global_config_arr[pref]."artikel WHERE artikel_url = '$_POST[url]'");
        if ((mysql_num_rows($index) == 0) ||
            ($_POST[oldurl] == $_POST[url])
           )
        {
            $_POST[oldurl] = savesql($_POST[oldurl]);
            $_POST[title] = savesql($_POST[title]);
            $_POST[text] = savesql($_POST[text]);
            settype($_POST[cat_id], 'integer');
            settype($_POST[posterid], 'integer');
            $_POST[search] = isset($_POST[search]) ? 1 : 0;
            $_POST[fscode] = isset($_POST[fscode]) ? 1 : 0;

            $update = "UPDATE ".$global_config_arr[pref]."artikel
                       SET artikel_url    = '".$_POST[url]."',
                           artikel_title  = '".$_POST[title]."',
                           artikel_date   = '$date',
                           artikel_user   = '".$_POST[posterid]."',
                           artikel_text   = '".$_POST[text]."',
                           artikel_index  = '".$_POST[search]."',
                           artikel_fscode = '".$_POST[fscode]."',
                           artikel_cat_id =	'".$_POST[cat_id]."'
                       WHERE artikel_url = '".$_POST[oldurl]."'";

            mysql_query($update, $db);
            systext("Artikel wurde geändert");
        }
        else
        {
            systext("Diese Artikel URL exitiert bereits");
        }
    }
    else
    {
        mysql_query("DELETE FROM ".$global_config_arr[pref]."artikel WHERE artikel_url = '$_POST[oldurl]'", $db);
        mysql_query("UPDATE ".$global_config_arr[pref]."counter SET artikel = artikel - 1", $db);
        systext("Der Artikel wurde gelöscht");
    }
}

//////////////////////////
//// Update Formular /////
//////////////////////////

elseif (isset($_POST[artikelurl]) OR isset($_POST[sended]))
{
    $_POST[artikelurl] = savesql($_POST[artikelurl]);
    if (isset($_POST['artikelurl']))
    {
      $_POST['oldurl'] =  $_POST[artikelurl];
    }

    // Artikel aus der DB holen
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."artikel WHERE artikel_url = '$_POST[oldurl]'", $db);
    $artikel_arr = mysql_fetch_assoc($index);
    $artikel_arr[artikel_text] = ereg_replace ("<textarea>", "&lt;textarea&gt;", $artikel_arr[artikel_text]); 
    $artikel_arr[artikel_text] = ereg_replace ("</textarea>", "&lt;/textarea&gt;", $artikel_arr[artikel_text]);

    if (!isset($_POST['title']))
    {
      $_POST['title'] =  $artikel_arr[artikel_title];
    }
    if (!isset($_POST['url']))
    {
      $_POST['url'] =  $artikel_arr[artikel_url];
    }

    //Poster Name für Anzeige bei fehlenden Daten
    if (!isset($_POST['posterid']) AND $artikel_arr[artikel_user] != 0)
    {
    $index = mysql_query("SELECT user_id FROM ".$global_config_arr[pref]."user WHERE user_id = '$artikel_arr[artikel_user]'", $db);
    $_POST['posterid']= mysql_result($index, 0, "user_id");
    }
    if ($_POST[posterid])
    {
      $index = mysql_query("SELECT user_name FROM ".$global_config_arr[pref]."user WHERE user_id = '$_POST[posterid]'", $db);
      $dbusername = mysql_result($index, 0, "user_name");
    }

    // Datum erzeugen
    if ($artikel_arr[artikel_date] != 0)
    {
        $nowtag = date("d", $artikel_arr[artikel_date]);
        $nowmonat = date("m", $artikel_arr[artikel_date]);
        $nowjahr = date("Y", $artikel_arr[artikel_date]);
    }

    if (!isset($_POST['tag']))
    {
      $_POST['tag'] =  $nowtag;
    }
    if (!isset($_POST['monat']))
    {
      $_POST['monat'] =  $nowmonat;
    }
    if (!isset($_POST['jahr']))
    {
      $_POST['jahr'] =  $nowjahr;
    }
    
    //Datum-Array für Heute Button
    $heute[tag] = date("d");
    $heute[monat] = date("m");
    $heute[jahr] = date("Y");

    if (!isset($_POST['sended']))
    {
      $_POST['search'] =  $artikel_arr[artikel_index];
    }
    // Suchindex
    $dbartikelindex = ($_POST['search'] == 1) ? "checked" : "";

    if (!isset($_POST['sended']))
    {
      $_POST['fscode'] =  $artikel_arr[artikel_fscode];
    }
    // verwendet fs code
    $dbartikelfscode = ($_POST['fscode'] == 1) ? "checked" : "";

    if (!isset($_POST['text']))
    {
      $_POST['text'] =  stripslashes($artikel_arr[artikel_text]);
    }
    
    // category id
	$cats_options = '';
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."artikel_cat", $db);
    
    while ($arr = mysql_fetch_assoc($index)) {
	    $state = ($artikel_arr[artikel_cat_id] == $arr[cat_id]) ? "selected" : "";
	    $cats_options .= '<option value="'.$arr[cat_id].'" selected="'.$state.'">'.$arr[cat_name].'</option>';
    }

    echo'
                    <form id="send1" action="" method="post" target="_self">
                        <input type="hidden" value="artikeledit" name="go">
                        <input type="hidden" value="" name="sended">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$_POST[oldurl].'" name="oldurl">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Teil der an ?go= angehängt wird</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="33" value="'.stripslashes(killhtml($_POST[url])).'" name="url" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Diesen Titel bekommt der Artikel</font>
                                </td>
                                <td class="config" valign="top">
                                    <input value="'.stripslashes(killhtml($_POST[title])).'" class="text" size="40" name="title" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                            	<td class="config" valign="top">
                            		Kategorie:<br>
                            		<font class="small">Kategorie</font>
                            	</td>
                            	<td class="config" valign="top">
                            		<select name="cat_id">
                            			'.$cats_options.'
                            		</select>
                            	</td>
                            </tr>                            
                            <tr>
                                <td class="config" valign="top">
                                    Autor:<br>
                                    <font class="small">Verfasser des Artikels (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" id="username" name="poster" value="'.$dbusername.'" maxlength="100" readonly="readonly">
                                    <input type="hidden" id="userid" name="posterid" value="'.$_POST[posterid].'">
                                    <input onClick=\'open("admin_finduser.php","Poster","width=360,height=300,screenX=50,screenY=50,scrollbars=YES")\' class="button" type="button" value="Ändern">
                                    <input onClick=\'document.getElementById("username").value="";
                                                     document.getElementById("userid").value="0";\' class="button" type="button" value="Löschen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Datum des Artikels (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input id="day" class="text" size="2" name="tag" value="'.stripslashes(killhtml($_POST[tag])).'" maxlength="2">
                                    <input id="month" class="text" size="2" name="monat" value="'.stripslashes(killhtml($_POST[monat])).'" maxlength="2">
                                    <input id="year" class="text" size="4" name="jahr" value="'.stripslashes(killhtml($_POST[jahr])).'" maxlength="4">
                                    <input onClick=\'document.getElementById("day").value="'.$heute[tag].'";
                                                     document.getElementById("month").value="'.$heute[monat].'";
                                                     document.getElementById("year").value="'.$heute[jahr].'";\' class="button" type="button" value="Heute">
                                    <input onClick=\'document.getElementById("day").value="";
                                                     document.getElementById("month").value="";
                                                     document.getElementById("year").value="";\' class="button" type="button" value="Löschen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Such-Index:<br>
                                    <font class="small">Diesen Artikel zum Such-Index hinzufügen</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="search" '.$dbartikelindex.'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    FS-Code:<br>
                                    <font class="small">FS-Code in diesem Artikel aktivieren</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="fscode" '.$dbartikelfscode.'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Html ist an. FScode ist an</font>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" colspan="2">
                                    '.create_editor("text", stripslashes(killhtml($_POST[text])), "100%", 380, "", false).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Artikel löschen:
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="delit" id="delit" value="1"
                                    onClick=onClick=\'delalert ("delit", "Soll der Artikel wirklich gelöscht werden?")\'>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="button" type="button" value="Vorschau" onClick="javascript:open(\'about:blank\',\'prev\',\'width=700,height=710,screenX=0,screenY=0,scrollbars=yes\'); document.getElementById(\'send1\').action=\'admin_artikelprev.php\'; document.getElementById(\'send1\').target=\'prev\'; document.getElementById(\'send1\').submit();">
                                    <input class="button" type="button" value="Absenden" onClick="javascript:document.getElementById(\'send1\').target=\'_self\'; document.getElementById(\'send1\').action=\'\'; document.getElementById(\'send1\').submit();">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

//////////////////////////
/// Artikel ausflisten ///
//////////////////////////

else
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="artikeledit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="20%">
                                    URL
                                </td>
                                <td class="config" width="40%">
                                    Titel
                                </td>
                                <td class="config" width="20%">
                                    Autor
                                </td>
                                <td class="config" width="20%">
                                    bearbeiten
                                </td>
                            </tr>
    ';
    $index = mysql_query("SELECT artikel_url, artikel_title, artikel_user FROM ".$global_config_arr[pref]."artikel ORDER BY artikel_url", $db);
    while ($artikel_arr = mysql_fetch_assoc($index))
    {
        $index2 = mysql_query("select user_name from ".$global_config_arr[pref]."user where user_id = '$artikel_arr[artikel_user]'", $db);
        $dbartikeluservalue = mysql_num_rows($index2) ? mysql_result($index2, 0, "user_name") : "";
        echo'
                            <tr>
                                <td class="configthin">
                                    '.$artikel_arr[artikel_url].'
                                </td>
                                <td class="configthin">
                                    '.$artikel_arr[artikel_title].'
                                </td>
                                <td class="configthin">
                                    '.$dbartikeluservalue.'
                                </td>
                                <td class="config">
                                    <input type="radio" name="artikelurl" value="'.$artikel_arr[artikel_url].'">
                                </td>
                            </tr>
        ';
    }
    echo'
                            <tr>
                                <td colspan="3">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                    <input class="button" type="submit" value="editieren">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>