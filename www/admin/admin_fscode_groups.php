<?php
if(!isset($_GET[action]) || ($_GET[action] == "delete" && ((!isset($_SESSION[fscode_groups_delete]) || $_SESSION[fscode_groups_delete] == 0) || (isset($_POST[deletegroup]) && intval($_POST[delete]) == 0)))){
  //errormessages
  if($_GET[action] == "delete" && isset($_GET[action]))
    if(isset($_POST[deletegroup]))
      systext($adminpage->langValue("notdeleted"), false, false, $TEXT[admin]->get("icon_trash_error"));
    else
      systext($adminpage->langValue("delete_norights"), false, true, $TEXT[admin]->get("icon_error"));

  // add group
  if(isset($_POST[addgroup]))
    if(preg_match("#[^a-z]+#is", $_POST[name]) == 1) //ungültige zeichen
      systext($adminpage->langValue("wrongchars"), false, true, $TEXT[admin]->get("icon_save_error"));
    else{
      if($sql->setData("fscodes_groups", "name", $_POST[name]) !== false)
        systext($adminpage->langValue("added"), false, false, $TEXT[admin]->get("icon_save_ok"));
      else{
        $error = $sql->getError();
        $adminpage->addCond("add", "1");
        $adminpage->addText("sql", $error[1]);
        systext($adminpage->get("sqlerror"), false, true, $TEXT[admin]->get("icon_save_error"));
        unset($error);
      }
      $_POST[name] = "";
    }
  //load groups
  $groups = $sql->getData("fscodes_groups", "*");
  if($groups != 0){
    foreach($groups as $group){
      //conditions
      $adminpage->addCond("delete", isset($_SESSION[fscode_groups_delete]) ? $_SESSION[fscode_groups_delete] : 0);
      //phrases
      $adminpage->addText("name", $group[name]);
      $adminpage->addText("id",   $group[id]);

      $grouplines .= $adminpage->get("edit_rows");
    }
  } else {
    $grouplines = $adminpage->get("nogroups");
  }
  $adminpage->addText("edit_rows", $grouplines);
  $adminpage->addText("submitarrow", $admin_phrases[common][arrow]);
  $adminpage->addText("name", $POST[name]);
  echo $adminpage->get("main");
} elseif($_GET[action] == "delete"){
  $name = $sql->getData("fscodes_groups", "`name`", "WHERE `id`=".intval($_GET[group]), 1);
  if($name !== 0){
    if(isset($_POST[deletegroup])){ // bestätigung abgeschickt
      if($sql->deleteData("fscodes_groups", "`name`='".savesql($name)."'"))
        systext($adminpage->langValue("deleted"), false, false, $TEXT[admin]->get("icon_trash_ok"));
      else{
        $error = $sql->getError();
        $adminpage->addText("sql", $error[1]);
        systext($adminpage->get("sqlerror"), false, true, $TEXT[admin]->get("icon_trash_error"));
        unset($error);
      }
    } else {
      $adminpage->addText("name", $name);
      echo $adminpage->get("confirm_deletion");
    }
  } else {
    systext($adminpage->langValue("notdefined"), false, true);
  }
} else {
  $name = $sql->getData("fscodes_groups", "`name`", "WHERE `id`=".intval($_GET[group]), 1);
  if($name === 0)
    systext($adminpage->langValue("notdefined"), false, true);
  else
    if(isset($_POST[editgroup])){
      if(preg_match("#[^a-z]+#is", $_POST[name]) == 0 && trim($_POST[name]) != "")
        if($sql->updateData("fscodes_groups", "name", savesql($_POST[name]), "WHERE `id`=".intval($_GET[group])) !== false)
          systext($adminpage->langValue("edited"), false, false, $TEXT[admin]->get("icon_save_ok"));
        else{
          $error = $sql->getError();
          $adminpage->addCond("edit", "1");
          $adminpage->addText("sql", $error[1]);
          systext($adminpage->get("sqlerror"), false, true, $TEXT[admin]->get("icon_save_error"));
          unset($error);
        }
      else
        systext($adminpage->langValue("wrongchars"), false, true, $TEXT[admin]->get("icon_save_error"));
    } else {
      $adminpage->addText("name", $name);
      echo $adminpage->get("editpage");
    }
}
?>