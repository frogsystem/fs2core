<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (isset($_POST['sended']) AND (($_POST['timed_deltime']==1 AND $_POST['deltime_time']) OR $_POST['timed_deltime']!=1) )
{

  settype($_POST['title'],'integer');
  settype($_POST['type_priority'],'integer');
  settype($_POST['use_priority_only'],'integer');
  $_POST['active'] = intval($_POST['active']);

  if ($_POST['timed_deltime']!=1) {
    settype($_POST['timed_deltime'],'integer');
  } else {
    settype($_POST['deltime_time'],'integer');
    switch ($_POST['deltime_type']) {
      case 'd':
        $deltime_mod = 60*60*24;
        break;
      case 'w':
        $deltime_mod = 60*60*24*7;
        break;
      case 'm':
        $deltime_mod = 60*60*24*30;
        break;
      default:
        $deltime_mod = 60*60;
        break;
    }
    $_POST['timed_deltime'] = $_POST['deltime_time']*$deltime_mod;
  }

  mysql_query('UPDATE '.$FD->config('pref')."screen_random_config
               SET active = '$_POST[active]',
                   type_priority = '$_POST[type_priority]',
                   use_priority_only = '$_POST[use_priority_only]'
               WHERE id = '1'", $FD->sql()->conn() );
    $FD->saveConfig('main', array('random_timed_deltime' => $_POST['timed_deltime']));
  systext('Die Konfiguration wurde aktualisiert.');
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
  $index = mysql_query('SELECT * FROM '.$FD->config('pref').'screen_random_config', $FD->sql()->conn() );
  $config_arr = mysql_fetch_assoc($index);

  $index = mysql_query('SELECT random_timed_deltime FROM '.$FD->config('pref').'global_config', $FD->sql()->conn() );
  $config_arr['timed_deltime'] = mysql_result($index,0,'random_timed_deltime');

  if ($config_arr['timed_deltime']>0) {
    $config_arr['deltime_time_h'] = $config_arr['timed_deltime']/(60*60);
    $config_arr['timed_deltime'] = 1;
    //month, weeks, days, hours
    if ($config_arr['deltime_time_h']%(24*30) == 0) {
      $config_arr['deltime_type'] = 'm';
      $config_arr['deltime_time'] = $config_arr['deltime_time_h']/(24*30);
    } elseif ($config_arr['deltime_time_h']%(24*7) == 0) {
      $config_arr['deltime_type'] = 'w';
      $config_arr['deltime_time'] = $config_arr['deltime_time_h']/(24*7);
    } elseif ($config_arr['deltime_time_h']%(24) == 0) {
      $config_arr['deltime_type'] = 'd';
      $config_arr['deltime_time'] = $config_arr['deltime_time_h']/(24);
    } else {
      $config_arr['deltime_type'] = 'h';
      $config_arr['deltime_time'] = $config_arr['deltime_time_h'];
    }
  }

  $error_message = '';

  if (isset($_POST['sended']))
  {
    $config_arr['active'] = $_POST['active'];
    $config_arr['type_priority'] = $_POST['type_priority'];
    $config_arr['timed_deltime'] = $_POST['timed_deltime'];
    $config_arr['deltime_type'] = $_POST['deltime_type'];
    $config_arr['deltime_time'] = $_POST['deltime_time'];

    $error_message = 'Bitte f&uuml;llen Sie alle Pflichfelder aus!';
  }

  systext($error_message);
  echo'<form action="" method="post">
         <input type="hidden" value="randompic_config" name="go">
         <input type="hidden" name="sended" value="1">
         <table border="0" cellpadding="4" cellspacing="0" width="600">
           <tr align="left" valign="top">
             <td class="config" valign="top" width="50%">
               System aktiv:<br>
               <font class="small">De- bzw. aktiviert das Zufallsbilds-System</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input type="checkbox" name="active" value="1"';
               if ($config_arr['active'] == 1)
                 echo " checked=checked";
               echo'/>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Vorrang:<br>
               <font class="small">Welches ZB-System erh&auml;lt den Vorrang?</font>
             </td>
             <td class="config" valign="top" width="50%">
               <select name="type_priority">
                 <option value="1"';
                   if ($config_arr['type_priority'] == 1)
                   echo ' selected="selected"';
                 echo'>Zeitgesteuerte Zufallsbilder</option>
                 <option value="2"';
                 if ($config_arr['type_priority'] == 2)
                   echo ' selected="selected"';
                 echo'>Zufallsbilder aus gew&auml;hlten Kategorien</option>
               </select>
             </td>
           </tr>
           <tr align="left" valign="top">
             <td class="config" valign="top" width="50%">
               Nur vorrangiges System:<br>
               <font class="small">Ausw&auml;hlen, wenn nur das vorrangige System verwendet werden soll.</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input type="checkbox" name="use_priority_only" value="1"';
               if ($config_arr['use_priority_only'] == 1)
                 echo " checked=checked";
               echo'/>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%" rowspan="3">
               Zeitgesteuerte ZBs l&ouml;schen:<br>
               <font class="small">Wann sollen abgelaufene ZBs gel&ouml;scht werden?</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input type="radio" name="timed_deltime" value="0"';
               if ($config_arr['timed_deltime'] == 0)
                 echo " checked=checked";
               echo'/> sofort
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               <input type="radio" name="timed_deltime" value="1"';
               if ($config_arr['timed_deltime'] == 1)
                 echo " checked=checked";
               echo'/> nach&nbsp;
               <input class="text" name="deltime_time" size="1" maxlength="2" value="'.$config_arr['deltime_time'].'" />
               <select name="deltime_type">
                 <option value="h"';
                 if ($config_arr['deltime_type'] == 'h')
                   echo ' selected="selected"';
                 echo'>Stunde(n)</option>
                 <option value="d"';
                 if ($config_arr['deltime_type'] == 'd')
                   echo ' selected="selected"';
                 echo'>Tag(en)</option>
                 <option value="w"';
                   if ($config_arr['deltime_type'] == 'w')
                   echo ' selected="selected"';
                 echo'>Woche(n)</option>
                 <option value="m"';
                   if ($config_arr['deltime_type'] == 'm')
                   echo ' selected="selected"';
                 echo'>Monat(en)</option>
               </select>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               <input type="radio" name="timed_deltime" value="-1"';
               if ($config_arr['timed_deltime'] == -1)
                 echo " checked=checked";
               echo'/> nie
             </td>
           </tr>

           <tr>
             <td align="center" colspan="2">
               <input class="button" type="submit" value="Absenden">
             </td>
           </tr>
         </table>
       </form>
      ';
}
?>
