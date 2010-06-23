<?php
function overview(){
  global $sql, $adminpage;
  $item = "";
  $codes = $sql->getData("fscodes", "*");
  foreach($codes as $code)
    $item .= codelist($code);
  $adminpage->addPhrase("item", $item);
  return $adminpage->get("overview");
}

function codelist($codearr){
  global $sql, $adminpage;
  $adminpage->addPhrase("name", $codearr[name]);
  // added
  $adduser = $sql->getData("user", "`user_name`, `user_id`", "WHERE `user_id`=".substr($codearr[added],0,strpos($codearr[added], " ")),1);
  if($adduser == 0){
    $adminpage->addPhrase("add_user_id",    "1");
    $adminpage->addPhrase("add_user_name",  $sql->getData("user", "`name`", "WHERE `user_id`=1",1));
  } else {
    $adminpage->addPhrase("add_user_id",    $adduser[user_id]);
    $adminpage->addPhrase("add_user_name",  $adduser[user_name]);
  }
  $adminpage->addPhrase("add_date", date("j.n.Y \u\m H:i", substr($codearr[added],(strpos($codearr[added], " ")+1))));

  // edited
  $adminpage->addCond("edited", $codearr[edited] == 0 ? 0 : 1);
  if($codearr[edited] != 0) {
    $edituser = $sql->getData("user", "`user_name`, `user_id`", "WHERE `user_id`=".substr($codearr[edited],0,strpos($codearr[edited], " ")),1);
    $adminpage->addPhrase("edit_date", date("j.n.Y \u\m H:i", substr($codearr[edited],(strpos($codearr[edited], " ")+1))));
    $edituser = $sql->getData("user", "`user_name`, `user_id`", "WHERE `user_id`=".substr($codearr[edited],0,strpos($codearr[edited], " ")),1);
    $adminpage->addPhrase("edit_user_id",   $edituser[user_id]);
    $adminpage->addPhrase("edit_user_name", $edituser[user_name]);
  }
  return $adminpage->get("overview_item");
}

if(!isset($_GET[code]) || empty($_GET[code])){ // kein fscode gewählt
  echo overview();
} else {
  $where = is_numeric($_GET[code]) ? "`id`=".intval($_GET[code]) : "`name`='".savesql($_GET[code])."'";
  $code = $sql->getData("fscodes", "*", "WHERE ".$where, 1);
  if($code == 0){ // fscode ist nicht definiert
    systext("Dieser Code existiert nicht!", $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error"));
  } elseif($_GET[action] == 'delete'){ // fscode löschen
    if($_SESSION[fscode_edit_remove] == 1){ // benutzer hat rechte
      if($sql->query("DELETE FROM `{..pref..}fscodes` WHERE `id`=".$code[id]) !== false &&
         $sql->query("DELETE FROM `{..pref..}fscodes_flag` WHERE `code`=".$code[id])){ // löschen erfolgreich
        $filepath = FS2_ROOT_PATH."styles/".$global_config_arr[style_tag]."/icons/fscode/".$code[name];
        if(file_exists($filepath.".gif"))
          unlink($filepath.".gif");
        elseif(file_exists($filepath.".jpg"))
          unlink($filepath.".jpg");
        elseif(file_exists($filepath.".png"))
          unlink($filepath.".png");

        systext("Code erfolgreich gelöscht.", false, false, $TEXT["admin"]->get("icon_trash_ok"));
      } else {
        systext("Code konnte nicht gelöscht werden.", $TEXT["admin"]->get("error"), true, $TEXT["admin"]->get("icon_trash_error"));
      }
    } else {
      systext("Es ist dir nicht erlaubt, diese Aktion auszuführen!", $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error"));
    }
  } else { // fscode bearbeiten
    if(!isset($_POST[editcode])){ // formular noch nicht abgeschickt
      $code = !isset($_POST[addflag])?$sql->getData("fscodes", "*", "WHERE `name`='".savesql($_GET[code])."'",1):$_POST;
      $oldcodes = $sql->getData("fscodes", "`name`", "WHERE `name`!='".savesql($code[name])."'");
      $dropdowns[] = get_dropdowns("editor_param_1");
      $dropdowns[] = get_dropdowns("editor_param_2");
      if($oldcodes != 0){
        $codes = array();
        foreach($oldcodes as $oldcode)
          $codes[] = $oldcode[name];

        $oldcodes = "\"".implode("\", \"", $codes)."\"";
      } else {
        $oldcodes = "";
      }
      $flags = "";
      if(isset($_POST[flag])){
        $i=0;
        while($i < count($_POST[flag][0])){
          if($_POST[flag][0][$i] != "0"){
            $adminpage->addCond("flag",     $_POST[flag][0][$i]);
            $adminpage->addCond("flagval",  $_POST[flag][1][$i]);
            $flags .= $adminpage->get("flagselect");
          }
          $i++;
        }
      } else {
        $_flags = $sql->getData("fscodes_flag", "*", "WHERE `code`=".$code[id]);
        if($_flags != 0){
          foreach($_flags as $_flag){
            $adminpage->addCond("flag", $_flag[name]);
            $adminpage->addCond("flagval", $_flag[value]);
            $flags .= $adminpage->get("flagselect");
          }
        }
        unset($_flags, $_flagnames, $_flag);
      }
      // conditions
      $adminpage->addCond("name",         $code[name]);
      $adminpage->addCond("callbacktype", $code[callbacktype]);
      $adminpage->addCond("active",       $code[active]);
      $adminpage->addCond("php",          $_SESSION[fscode_add_php]);

      //phrases
      $adminpage->addPhrase("id",             $code[id]);
      $adminpage->addPhrase("codenames",      $oldcodes);
      $adminpage->addPhrase("FSROOT",         FS2_ROOT_PATH);
      $adminpage->addPhrase("name",           $code[name]);
      $adminpage->addPhrase("contenttype",    $code[contenttype]);
      $adminpage->addPhrase("allowin",        $code[allowin]);
      $adminpage->addPhrase("disallowin",     $code[disallowin]);
      $adminpage->addPhrase("flags",          $flags);
      $adminpage->addPhrase("global_vars_1",  $dropdowns[0]['global_vars']);
      $adminpage->addPhrase("applets_1",      $dropdowns[0]['applets']);
      $adminpage->addPhrase("snippets_1",     $dropdowns[0]['snippets']);
      $adminpage->addPhrase("global_vars_2",  $dropdowns[1]['global_vars']);
      $adminpage->addPhrase("applets_2",      $dropdowns[1]['applets']);
      $adminpage->addPhrase("snippets_2",     $dropdowns[1]['snippets']);
      $adminpage->addPhrase("taglist_1",      get_taglist(array(array(tag => "x", text => "Der angegebene Parameter")), "param_1" ));
      $adminpage->addPhrase("taglist_2",      get_taglist(array(array(tag => "x", text => "Der \"Inhalt\" des Codes.<br>[code='Parameter']<b>Inhalt</b>[/code]"), array(tag => "y", text  => "Der Parameter des Codes.<br>[code='<b>Parameter</b>']Inhalt[/code]")), "param_2" ));
      $adminpage->addPhrase("value_1",        $code[param_1]);
      $adminpage->addPhrase("value_2",        $code[param_2]);
      $adminpage->addPhrase("value_php",      $code[php]);
      $adminpage->addPhrase("submitarrow",    $admin_phrases[common][arrow]);
      $adminpage->addPhrase("submittext",     $admin_phrases[common][save_long]);

      echo $adminpage->get("detail");

    } else { // formular abgeschickt
      if(isset($_POST[name])        && !empty($_POST[name]) &&
        isset($_POST[contenttype])  && !empty($_POST[contenttype])  &&
        isset($_POST[allowin])      && !empty($_POST[allowin])      &&
       (isset($_POST[callbacktype]) && !empty($_POST[callbacktype]) || intval($_POST[callbacktype]) == 0) &&
      ((isset($_POST[param_1])      && !empty($_POST[param_1]))     ||
       (isset($_POST[php])          && !empty($_POST[php])          && $_SESSION[fscode_edit_php] == 1))){
        $codes = $sql->getData("fscodes", "`name`", "WHERE `id`!=".intval($_POST[id]));
        if(!in_array($_POST[name], $codes)){
          if(preg_match("#[^a-zA-Z-_]+#", $_POST[name]) == 0 || $sql->getData("fscodes", "`name`", "WHERE `id`=".intval($_POST[id]), 1) == $_POST[name]){
            $post = array_map("savesql", $_POST);
            $post[param_1]      = str_replace(",", "&#44;", $post[param_1]);
            $post[param_2]      = (!isset($post[param_2]) || empty($post[param_2]))?$post[param_1]:str_replace(",", "&#44;", $post[param_2]);
            $post[php]          = $_SESSION[fscode_edit_php] == 1 ? str_replace(",", "&#44;", $post[php]) : "";
            $post[contenttype]  = str_replace(",", "&#44;", $post[contenttype]);
            $post[allowin]      = str_replace(",", "&#44;", $post[allowin]);
            $post[disallowin]   = str_replace(",", "&#44;", $post[disallowin]);
            $sql->updateData("fscodes", "name, contenttype, callbacktype, allowin, disallowin, param_1, param_2, php, active, edited", $post[name].", ".$post[contenttype].", ".$post[callbacktype].", ".$post[allowin].", ".$post[disallowin].", ".$post[param_1].", ".$post[param_2].", ".$post[php].", ".$post[active].", ".$_SESSION[user_id]." ".time(), "WHERE `id`=".intval($_POST[id]));
            $sql->deleteData("fscodes_flag", "`code`=".intval($_POST[id]));

            $flags = array(2, 5, 3, 3, 3, 3, 3, 2);
            for($i = 0; $i < count($_POST[flag][0]); $i++){
              $flag = array(intval($_POST[flag][0][$i]), intval($_POST[flag][1][$i]));
              if($flag[0] != 0 && $flag[0] <= count($flags) && $flag[1] < $flags[$flag[0]-1]){
                $sql->setData("fscodes_flag", "code, name, value", intval($_POST[id]).", ".$flag[0].", ".$flag[1]);
              }
            }
            if($_FILES[icon][error] != 4){ // es wurde ein icon hochgeladen
              $tmp = $sql->getData("fscodes_config", "*");
              foreach($tmp as $conf)
                $fileconfig[$conf[type]] = $conf[value];
              unset($conf, $tmp);
              if($notice = upload_img($_FILES[icon], "media/fscode-images/", $name, $fileconfig[file_size], $fileconfig[file_width], $fileconfig[file_height]) != 0)
                systext(upload_img_notice($notice), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
            }
            systext("Code erfolgreich bearbeitet.", $TEXT["admin"]->get("changes_saved"), FALSE, $TEXT["admin"]->get("icon_save_ok"));
          } else
            systext("Der Name des Code enthält ungültige Zeichen!", $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
        } else
          systext("Ein Code mit diesem Namen existiert bereits!", $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
      } else
        systext("Fülle alle Pflichtfelder aus!", $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
    }
  }
}


?>