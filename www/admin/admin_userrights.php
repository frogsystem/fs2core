<?php

///////////////////////
//// Rechte ändern ////
///////////////////////

if (isset($_POST[ueuserid]))
{
    settype($_POST[ueuserid], 'integer');
    if ($_POST[ueuserid] != 1)
    {
        $_POST[uepermnewsadd] = isset($_POST[uepermnewsadd]) ? 1 : 0;
        $_POST[uepermnewsedit] = isset($_POST[uepermnewsedit]) ? 1 : 0;
        $_POST[uepermnewscat] = isset($_POST[uepermnewscat]) ? 1 : 0;
        $_POST[uepermnewsnewcat] = isset($_POST[uepermnewsnewcat]) ? 1 : 0;
        $_POST[uepermnewsconfig] = isset($_POST[uepermnewsconfig]) ? 1 : 0;
        $_POST[uepermdladd] = isset($_POST[uepermdladd]) ? 1 : 0;
        $_POST[uepermdledit] = isset($_POST[uepermdledit]) ? 1 : 0;
        $_POST[uepermdlcat] = isset($_POST[uepermdlcat]) ? 1 : 0;
        $_POST[uepermdlnewcat] = isset($_POST[uepermdlnewcat]) ? 1 : 0;
        $_POST[uepermpolladd] = isset($_POST[uepermpolladd]) ? 1 : 0;
        $_POST[uepermpolledit] = isset($_POST[uepermpolledit]) ? 1 : 0;
        $_POST[uepermpotmadd] = isset($_POST[uepermpotmadd]) ? 1 : 0;
        $_POST[uepermpotmedit] = isset($_POST[uepermpotmedit]) ? 1 : 0;
        $_POST[uepermscreenadd] = isset($_POST[uepermscreenadd]) ? 1 : 0;
        $_POST[uepermscreenedit] = isset($_POST[uepermscreenedit]) ? 1 : 0;
        $_POST[uepermscreencat] = isset($_POST[uepermscreencat]) ? 1 : 0;
        $_POST[uepermscreennewcat] = isset($_POST[uepermscreennewcat]) ? 1 : 0;
        $_POST[uepermscreenconfig] = isset($_POST[uepermscreenconfig]) ? 1 : 0;
        $_POST[uepermshopadd] = isset($_POST[uepermshopadd]) ? 1 : 0;
        $_POST[uepermshopedit] = isset($_POST[uepermshopedit]) ? 1 : 0;
        $_POST[uepermmap] = isset($_POST[uepermmap]) ? 1 : 0;
        $_POST[uepermstatview] = isset($_POST[uepermstatview]) ? 1 : 0;
        $_POST[uepermstatedit] = isset($_POST[uepermstatedit]) ? 1 : 0;
        $_POST[uepermstatref] = isset($_POST[uepermstatref]) ? 1 : 0;
        $_POST[uepermuseradd] = isset($_POST[uepermuseradd]) ? 1 : 0;
        $_POST[uepermuseredit] = isset($_POST[uepermuseredit]) ? 1 : 0;
        $_POST[uepermuserrights] = isset($_POST[uepermuserrights]) ? 1 : 0;
        $_POST[uepermartikeladd] = isset($_POST[uepermartikeladd]) ? 1 : 0;
        $_POST[uepermartikeledit] = isset($_POST[uepermartikeledit]) ? 1 : 0;
        $_POST[uepermtemplateedit] = isset($_POST[uepermtemplateedit]) ? 1 : 0;
        $_POST[uepermallphpinfo] = isset($_POST[uepermallphpinfo]) ? 1 : 0;
        $_POST[uepermallconfig] = isset($_POST[uepermallconfig]) ? 1 : 0;
        $_POST[uepermallanouncement] = isset($_POST[uepermallanouncement]) ? 1 : 0;
        $_POST[uepermstatspace] = isset($_POST[uepermstatspace]) ? 1 : 0;
        $_POST[uepermgbedit] = isset($_POST[uepermgbedit]) ? 1 : 0;
        $_POST[uepermgbcat] = isset($_POST[uepermgbcat]) ? 1 : 0;

        $update = "UPDATE fs_permissions
                   SET perm_newsadd = $_POST[uepermnewsadd],
                       perm_newsedit = $_POST[uepermnewsedit],
                       perm_newscat = $_POST[uepermnewscat],
                       perm_newsnewcat = $_POST[uepermnewsnewcat],
                       perm_newsconfig = $_POST[uepermnewsconfig],
                       perm_dladd = $_POST[uepermdladd],
                       perm_dledit = $_POST[uepermdledit],
                       perm_dlcat = $_POST[uepermdlcat],
                       perm_dlnewcat = $_POST[uepermdlnewcat],
                       perm_polladd = $_POST[uepermpolladd],
                       perm_polledit = $_POST[uepermpolledit],
                       perm_potmadd = $_POST[uepermpotmadd],
                       perm_potmedit = $_POST[uepermpotmedit],
                       perm_screenadd = $_POST[uepermscreenadd],
                       perm_screenedit = $_POST[uepermscreenedit],
                       perm_screencat = $_POST[uepermscreencat],
                       perm_screennewcat = $_POST[uepermscreennewcat],
                       perm_screenconfig = $_POST[uepermscreenconfig],
                       perm_shopadd = $_POST[uepermshopadd],
                       perm_shopedit = $_POST[uepermshopedit],
                       perm_statedit = $_POST[uepermstatedit],
                       perm_useradd = $_POST[uepermuseradd],
                       perm_useredit = $_POST[uepermuseredit],
                       perm_userrights = $_POST[uepermuserrights],
                       perm_map = $_POST[uepermmap],
                       perm_statview = $_POST[uepermstatview],
                       perm_statref = $_POST[uepermstatref],
                       perm_artikeladd = $_POST[uepermartikeladd],
                       perm_artikeledit = $_POST[uepermartikeledit],
                       perm_templateedit = $_POST[uepermtemplateedit],
                       perm_allphpinfo = $_POST[uepermallphpinfo],
                       perm_allconfig = $_POST[uepermallconfig],
                       perm_allanouncement = $_POST[uepermallanouncement],
                       perm_statspace = $_POST[uepermstatspace],
                       perm_gbedit = $_POST[uepermgbedit],
                       perm_gbcat = $_POST[uepermgbcat]
                   WHERE user_id = $_POST[ueuserid]";

        mysql_query($update, $db);
        systext('User wurde geändert');
    }
    else
    {
        systext("Dieser User kann nicht editiert werden");
    }
}
  
///////////////////////
/// Rechte editieren //
///////////////////////

elseif (isset($_POST[euuserid]))
{
    settype($euuserid, 'integer');
    $userindex = mysql_query("SELECT user_name FROM fs_user WHERE user_id = $euuserid", $db);
    $dbusername = mysql_result($userindex, 0, "user_name");

    $index = mysql_query("SELECT * FROM fs_permissions WHERE user_id = $euuserid", $db);
    $perm_arr = mysql_fetch_assoc($index);

    $perm_arr[perm_newsadd] = ($perm_arr[perm_newsadd] == 1) ? "checked" : "";
    $perm_arr[perm_newsedit] = ($perm_arr[perm_newsedit] == 1) ? "checked" : "";
    $perm_arr[perm_newscat] = ($perm_arr[perm_newscat] == 1) ? "checked" : "";
    $perm_arr[perm_newsnewcat] = ($perm_arr[perm_newsnewcat] == 1) ? "checked" : "";
    $perm_arr[perm_newsconfig] = ($perm_arr[perm_newsconfig] == 1) ? "checked" : "";
    $perm_arr[perm_dladd] = ($perm_arr[perm_dladd] == 1) ? "checked" : "";
    $perm_arr[perm_dledit] = ($perm_arr[perm_dledit] == 1) ? "checked" : "";
    $perm_arr[perm_dlcat] = ($perm_arr[perm_dlcat] == 1) ? "checked" : "";
    $perm_arr[perm_dlnewcat] = ($perm_arr[perm_dlnewcat] == 1) ? "checked" : "";
    $perm_arr[perm_polladd] = ($perm_arr[perm_polladd] == 1) ? "checked" : "";
    $perm_arr[perm_polledit] = ($perm_arr[perm_polledit] == 1) ? "checked" : "";
    $perm_arr[perm_potmadd] = ($perm_arr[perm_potmadd] == 1) ? "checked" : "";
    $perm_arr[perm_potmedit] = ($perm_arr[perm_potmedit] == 1) ? "checked" : "";
    $perm_arr[perm_screenadd] = ($perm_arr[perm_screenadd] == 1) ? "checked" : "";
    $perm_arr[perm_screenedit] = ($perm_arr[perm_screenedit] == 1) ? "checked" : "";
    $perm_arr[perm_screencat] = ($perm_arr[perm_screencat] == 1) ? "checked" : "";
    $perm_arr[perm_screennewcat] = ($perm_arr[perm_screennewcat] == 1) ? "checked" : "";
    $perm_arr[perm_screenconfig] = ($perm_arr[perm_screenconfig] == 1) ? "checked" : "";
    $perm_arr[perm_shopadd] = ($perm_arr[perm_shopadd] == 1) ? "checked" : "";
    $perm_arr[perm_shopedit] = ($perm_arr[perm_shopedit] == 1) ? "checked" : "";
    $perm_arr[perm_map] = ($perm_arr[perm_map] == 1) ? "checked" : "";
    $perm_arr[perm_statview] = ($perm_arr[perm_statview] == 1) ? "checked" : "";
    $perm_arr[perm_statedit] = ($perm_arr[perm_statedit] == 1) ? "checked" : "";
    $perm_arr[perm_statref] = ($perm_arr[perm_statref] == 1) ? "checked" : "";
    $perm_arr[perm_useradd] = ($perm_arr[perm_useradd] == 1) ? "checked" : "";
    $perm_arr[perm_userrights] = ($perm_arr[perm_userrights] == 1) ? "checked" : "";
    $perm_arr[perm_artikeladd] = ($perm_arr[perm_artikeladd] == 1) ? "checked" : "";
    $perm_arr[perm_artikeledit] = ($perm_arr[perm_artikeledit] == 1) ? "checked" : "";
    $perm_arr[perm_templateedit] = ($perm_arr[perm_templateedit] == 1) ? "checked" : "";
    $perm_arr[perm_allphpinfo] = ($perm_arr[perm_allphpinfo] == 1) ? "checked" : "";
    $perm_arr[perm_allconfig] = ($perm_arr[perm_allconfig] == 1) ? "checked" : "";
    $perm_arr[perm_allanouncement] = ($perm_arr[perm_allanouncement] == 1) ? "checked" : "";
    $perm_arr[perm_statspace] = ($perm_arr[perm_statspace] == 1) ? "checked" : "";
    $perm_arr[perm_gbedit] = ($perm_arr[perm_gbedit] == 1) ? "checked" : "";
    $perm_arr[perm_perm_gbcat] = ($perm_arr[perm_perm_gbcat] == 1) ? "checked" : "";
    echo'
          <form action="'.$PHP_SELF.'" method="post">
          <input type="hidden" value="userrights" name="go">
          <input type="hidden" value="'.session_id().'" name="PHPSESSID">
          <input type="hidden" value="'.$euuserid.'" name="ueuserid">
          <table border="0" cellpadding="4" cellspacing="0" width="600">
           <tr>
             <td class="config" colspan="2" valign="top"><b>Rechte für '.$dbusername.' einstellen</b></td
           </tr>
           <tr>
             <td class="configthin" width="50%">Allgemeine Konfiguration:</td>
             <td align="center" width="50%"><input type="checkbox" name="uepermallconifg" value="1" '.$perm_arr[perm_allconfig].'></td>
           </tr>
           <tr>
             <td class="configthin" width="50%">Ankündigungen:</td>
             <td align="center" width="50%"><input type="checkbox" name="uepermallanouncement" value="1" '.$perm_arr[perm_allanouncement].'></td>
           </tr>
           <tr>
             <td class="configthin" width="50%">PHP Info:</td>
             <td align="center" width="50%"><input type="checkbox" name="uepermallphpinfo" value="1" '.$perm_arr[perm_allphpinfo].'></td>
           </tr>
           <tr>
             <td class="configthin" width="50%">News schreiben:</td>
             <td align="center" width="50%"><input type="checkbox" name="uepermnewsadd" value="1" '.$perm_arr[perm_newsadd].'></td>
           </tr>
           <tr>
             <td class="configthin">News Archiv:</td>
             <td align="center"><input type="checkbox" name="uepermnewsedit" value="1" '.$perm_arr[perm_newsedit].'></td>
           </tr>
           <tr>
             <td class="configthin">News Kategorien:</td>
             <td align="center"><input type="checkbox" name="uepermnewscat" value="1" '.$perm_arr[perm_newscat].'></td>
           </tr>
           <tr>
             <td class="configthin">News Kategorie hinzufügen:</td>
             <td align="center"><input type="checkbox" name="uepermnewsnewcat" value="1" '.$perm_arr[perm_newsnewcat].'></td>
           </tr>
           <tr>
             <td class="configthin">News Konfiguration:</td>
             <td align="center"><input type="checkbox" name="uepermnewsconfig" value="1" '.$perm_arr[perm_newsconfig].'></td>
           </tr>
           <tr>
             <td class="configthin">Artikel schreiben:</td>
             <td align="center"><input type="checkbox" name="uepermartikeladd" value="1" '.$perm_arr[perm_artikeladd].'></td>
           </tr>
           <tr>
             <td class="configthin">Artikel editieren:</td>
             <td align="center"><input type="checkbox" name="uepermartikeledit" value="1" '.$perm_arr[perm_artikeledit].'></td>
           </tr>
           <tr>
             <td class="configthin">Download hinzufügen:</td>
             <td align="center"><input type="checkbox" name="uepermdladd" value="1" '.$perm_arr[perm_dladd].'></td>
           </tr>
           <tr>
             <td class="configthin">Download bearbeiten:</td>
             <td align="center"><input type="checkbox" name="uepermdledit" value="1" '.$perm_arr[perm_dledit].'></td>
           </tr>
           <tr>
             <td class="configthin">Download Kategorien:</td>
             <td align="center"><input type="checkbox" name="uepermdlcat" value="1" '.$perm_arr[perm_dlcat].'></td>
           </tr>
           <tr>
             <td class="configthin">Download Kategorie hinzufügen:</td>
             <td align="center"><input type="checkbox" name="uepermdlnewcat" value="1" '.$perm_arr[perm_dlnewcat].'></td>
           </tr>
           <tr>
             <td class="configthin">Umfrage hinzufügen:</td>
             <td align="center"><input type="checkbox" name="uepermpolladd" value="1" '.$perm_arr[perm_polladd].'></td>
           </tr>
           <tr>
             <td class="configthin">Umfrage Archiv:</td>
             <td align="center"><input type="checkbox" name="uepermpolledit" value="1" '.$perm_arr[perm_polledit].'></td>
           </tr>
           <tr>
             <td class="configthin">POTM Bild hinzufügen:</td>
             <td align="center"><input type="checkbox" name="uepermpotmadd" value="1" '.$perm_arr[perm_potmadd].'></td>
           </tr>
           <tr>
             <td class="configthin">POTM Übersicht:</td>
             <td align="center"><input type="checkbox" name="uepermpotmedit" value="1" '.$perm_arr[perm_potmedit].'></td>
           </tr>
           <tr>
             <td class="configthin">Screenshot hinzufügen:</td>
             <td align="center"><input type="checkbox" name="uepermscreenadd" value="1" '.$perm_arr[perm_screenadd].'></td>
           </tr>
           <tr>
             <td class="configthin">Screenshots Übersicht:</td>
             <td align="center"><input type="checkbox" name="uepermscreenedit" value="1" '.$perm_arr[perm_screenedit].'></td>
           </tr>
           <tr>
             <td class="configthin">Screenshot Kategorien:</td>
             <td align="center"><input type="checkbox" name="uepermscreencat" value="1" '.$perm_arr[perm_screencat].'></td>
           </tr>
           <tr>
             <td class="configthin">Screenshot Kategorie hinzufügen</td>
             <td align="center"><input type="checkbox" name="uepermscreennewcat" value="1" '.$perm_arr[perm_screennewcat].'></td>
           </tr>
           <tr>
             <td class="configthin">Screenshot Konfiguration:</td>
             <td align="center"><input type="checkbox" name="uepermscreenconfig" value="1" '.$perm_arr[perm_screenconfig].'></td>
           </tr>
           <tr>
             <td class="configthin">Shop Artikel hinzufügen:</td>
             <td align="center"><input type="checkbox" name="uepermshopadd" value="1" '.$perm_arr[perm_shopadd].'></td>
           </tr>
           <tr>
             <td class="configthin">Shop Übersicht:</td>
             <td align="center"><input type="checkbox" name="uepermshopedit" value="1" '.$perm_arr[perm_shopedit].'></td>
           </tr>
           <tr>
             <td class="configthin">Community Map:</td>
             <td align="center"><input type="checkbox" name="uepermmap" value="1" '.$perm_arr[perm_map].'></td>
           </tr>
           <tr>
             <td class="configthin">Statistik anzeigen:</td>
             <td align="center"><input type="checkbox" name="uepermstatview" value="1" '.$perm_arr[perm_statview].'></td>
           </tr>
           <tr>
             <td class="configthin">Statistik bearbeiten:</td>
             <td align="center"><input type="checkbox" name="uepermstatedit" value="1" '.$perm_arr[perm_statedit].'></td>
           </tr>
           <tr>
             <td class="configthin">Referrer Statistik:</td>
             <td align="center"><input type="checkbox" name="uepermstatref" value="1" '.$perm_arr[perm_statref].'></td>
           </tr>
           <tr>
             <td class="configthin">Speicherplatz Statistik:</td>
             <td align="center"><input type="checkbox" name="uepermstatspace" value="1" '.$perm_arr[perm_statspace].'></td>
           </tr>
           <tr>
             <td class="configthin">Template:</td>
             <td align="center"><input type="checkbox" name="uepermtemplateedit" value="1" '.$perm_arr[perm_templateedit].'></td>
           </tr>
           <tr>
             <td class="configthin">Gästebuch editieren:</td>
             <td align="center"><input type="checkbox" name="uepermgbedit" value="1" '.$perm_arr[perm_gbedit].'></td>
           </tr>
           <tr>
             <td class="configthin">Gästebuch Kategorien:</td>
             <td align="center"><input type="checkbox" name="uepermgbcat" value="1" '.$perm_arr[perm_gbcat].'></td>
           </tr>
           <tr>
             <td class="configthin">Benutzer hinzufügen:</td>
             <td align="center"><input type="checkbox" name="uepermuseradd" value="1" '.$perm_arr[perm_useradd].'></td>
           </tr>
           <tr>
             <td class="configthin">Benutzer editieren:</td>
             <td align="center"><input type="checkbox" name="uepermuseredit" value="1" '.$perm_arr[perm_useredit].'></td>
           </tr>
           <tr>
             <td class="configthin">Benutzer Rechte:</td>
             <td align="center"><input type="checkbox" name="uepermuserrights" value="1" '.$perm_arr[perm_userrights].'></td>
           </tr>
           <tr>
             <td colspan="2"><input type="submit" class="button" value="Absenden"></td>
           </tr>
         </table>
         </form>
    ';
}

///////////////////////
/// User auswählen ////
///////////////////////

else
{
    echo'
          <form action="'.$PHP_SELF.'" method="post">
          <input type="hidden" value="userrights" name="go">
          <input type="hidden" value="'.session_id().'" name="PHPSESSID">
          <table border="0" cellpadding="2" cellspacing="0" width="600">
           <tr>
            <td align="center" class="config" width="50%">Username</td>
            <td align="center" class="config" width="50%">bearbeiten</td>
           </tr>
    ';
    $index = mysql_query("SELECT user_id, user_name
                           FROM fs_user
                           WHERE user_id != 1 AND is_admin = 1
                           ORDER BY user_name", $db);
    while ($user_arr = mysql_fetch_assoc($index))
    {
        echo'
           <tr>
            <td class="configthin">'.killhtml($user_arr[user_name]).'</td>
            <td class="config"><input type="radio" name="euuserid" value="'.$user_arr[user_id].'"></td>
           </tr>
        ';
    }
    echo'
           <tr><td colspan="3">&nbsp;</td></tr>
           <tr>
            <td colspan="2"><input class="button" type="submit" value="editieren"></td>
           </tr>
          </table>
          </form>
    ';
}
?>