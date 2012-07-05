<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('active', 'type_priority', 'use_priority_only', 'timed_deltime');

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (isset($_POST['sended']) AND (($_POST['timed_deltime']==1 AND $_POST['deltime_time']) OR $_POST['timed_deltime']!=1) )
{

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

    // prepare data
    $data = frompost($used_cols);
      
    // save config
    try {
        $FD->saveConfig('preview_images', $data);
        systext($FD->text('admin', 'config_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
    } catch (Exception $e) {
        systext(
            $FD->text('admin', 'config_not_saved').'<br>'.
            (DEBUG ? $e->getMessage() : $FD->text('admin', 'unknown_error')),
            $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error')
        );        
    }

    // Unset Vars
    unset($_POST); 
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

if(true)
{
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    // Load Data from DB into Post
    } else {
        $data = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'preview_images'"));
        $data = json_array_decode($data['config_data']);
        putintopost($data);
    }

    // calc deletion time
    if ($_POST['timed_deltime']>0) {
        $_POST['deltime_time_h'] = $_POST['timed_deltime']/(60*60);
        $_POST['timed_deltime'] = 1;
        
        //month, weeks, days, hours
        if ($_POST['deltime_time_h']%(24*30) == 0) {
            $_POST['deltime_type'] = 'm';
            $_POST['deltime_time'] = $_POST['deltime_time_h']/(24*30);
        } elseif ($_POST['deltime_time_h']%(24*7) == 0) {
            $_POST['deltime_type'] = 'w';
            $_POST['deltime_time'] = $_POST['deltime_time_h']/(24*7);
        } elseif ($_POST['deltime_time_h']%(24) == 0) {
            $_POST['deltime_type'] = 'd';
            $_POST['deltime_time'] = $_POST['deltime_time_h']/(24);
        } else {
            $_POST['deltime_type'] = 'h';
            $_POST['deltime_time'] = $_POST['deltime_time_h'];
        }
    }    
    
    // security functions
    $_POST = array_map('killhtml', $_POST);
    
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
               if ($_POST['active'] == 1)
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
                   if ($_POST['type_priority'] == 1)
                   echo ' selected="selected"';
                 echo'>Zeitgesteuerte Zufallsbilder</option>
                 <option value="2"';
                 if ($_POST['type_priority'] == 2)
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
               if ($_POST['use_priority_only'] == 1)
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
               if ($_POST['timed_deltime'] == 0)
                 echo " checked=checked";
               echo'/> sofort
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               <input type="radio" name="timed_deltime" value="1"';
               if ($_POST['timed_deltime'] == 1)
                 echo " checked=checked";
               echo'/> nach&nbsp;
               <input class="text" name="deltime_time" size="1" maxlength="2" value="'.$_POST['deltime_time'].'" />
               <select name="deltime_type">
                 <option value="h"';
                 if ($_POST['deltime_type'] == 'h')
                   echo ' selected="selected"';
                 echo'>Stunde(n)</option>
                 <option value="d"';
                 if ($_POST['deltime_type'] == 'd')
                   echo ' selected="selected"';
                 echo'>Tag(en)</option>
                 <option value="w"';
                   if ($_POST['deltime_type'] == 'w')
                   echo ' selected="selected"';
                 echo'>Woche(n)</option>
                 <option value="m"';
                   if ($_POST['deltime_type'] == 'm')
                   echo ' selected="selected"';
                 echo'>Monat(en)</option>
               </select>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               <input type="radio" name="timed_deltime" value="-1"';
               if ($_POST['timed_deltime'] == -1)
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
