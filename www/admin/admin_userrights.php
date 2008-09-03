<?php
///////////////////////
//// Rechte ändern ////
///////////////////////

if (isset($_POST[userid]))
{
    settype($_POST[userid], 'integer');
    if ($_POST[userid] != 1 AND $_POST[userid] != $_SESSION[user_id])
    {
        foreach($all_perms AS $value)
        {
            $_POST[$value[perm]] = isset($_POST[$value[perm]]) ? 1 : 0;
            $update = "UPDATE ".$global_config_arr[pref]."permissions
                       SET $value[perm] = '".$_POST[$value[perm]]."'
                       WHERE user_id = $_POST[userid]";
            mysql_query($update, $db);
        }
        systext('User wurde geändert');
    }
    else
    {
        systext("Dieser User kann nicht bearbeitet werden!");
    }
}
  
///////////////////////
/// Rechte editieren //
///////////////////////

elseif (isset($_POST[edituserid]))
{
    settype($_POST[edituserid], 'integer');
    $userindex = mysql_query("SELECT user_name FROM ".$global_config_arr[pref]."user WHERE user_id = $_POST[edituserid]", $db);
    $dbusername = mysql_result($userindex, 0, "user_name");

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."permissions WHERE user_id = $_POST[edituserid]", $db);
    $perm_arr = mysql_fetch_assoc($index);

    foreach($all_perms AS $value)
    {
        $perm_arr[$value[perm]] = ($perm_arr[$value[perm]] == 1) ? 'checked="checked"' : "";
    }
    
    echo'
          <form action="" method="post">
          <input type="hidden" value="userrights" name="go">
          <input type="hidden" value="'.session_id().'" name="PHPSESSID">
          <input type="hidden" value="'.$_POST[edituserid].'" name="userid">
          <table border="0" cellpadding="0" cellspacing="0" align="center" width="600">
            <tr>
              <td class="config" colspan="2" valign="top">
                <b>Rechte für '.$dbusername.' einstellen</b><br /><br />
              </td>
            </tr>
            <tr>
              <td width="50%" valign="top">';
              
    $per_col = ceil(count($all_perms)/2);
    $i=0;
    foreach($all_perms AS $value)
    {
        $i++;
        if ($i==1) {echo'<table border="0" cellpadding="1" cellspacing="0">';}
        echo'<tr>
               <td>
                 <input type="checkbox" style="vertical-align:bottom;" name="'.$value[perm].'" value="1" '
                 .$perm_arr[$value[perm]].'>
               </td>
               <td style="font-size:8pt; font-family:Verdana;" width="100%">
                 '.$value[description].'
               </td>
             </tr>';
        if ($i==$per_col) {echo'</table></td><td width="50%" valign="top"><table border="0" cellpadding="1" cellspacing="0">';}
    }
              
    echo'       </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <br /><br />
                <input type="submit" class="button" value="Absenden">
              </td>
            </tr>
         </table>
         </form>';
}

///////////////////////
/// User auswählen ////
///////////////////////

else
{
    echo'
          <form action="" method="post">
          <input type="hidden" value="userrights" name="go">
          <input type="hidden" value="'.session_id().'" name="PHPSESSID">
          <table border="0" cellpadding="2" cellspacing="0" width="600">
           <tr>
            <td align="center" class="config" width="50%">Username</td>
            <td align="center" class="config" width="50%">bearbeiten</td>
           </tr>
    ';
    $index = mysql_query("SELECT user_id, user_name
                          FROM ".$global_config_arr[pref]."user
                          WHERE is_admin = 1 AND user_id != 1 AND user_id != $_SESSION[user_id]
                          ORDER BY user_name", $db);
    while ($user_arr = mysql_fetch_assoc($index))
    {
        echo'
           <tr>
            <td class="configthin">'.killhtml($user_arr[user_name]).'</td>
            <td class="config"><input type="radio" name="edituserid" value="'.$user_arr[user_id].'"></td>
           </tr>
        ';
    }
    if (mysql_num_rows($index) <= 0) {
        echo'
           <tr>
            <td class="configthin" colspan="2"><br />Keine User gefunden!</td>
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