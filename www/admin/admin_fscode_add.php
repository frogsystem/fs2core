<?php
if(isset($_POST[addcode])){
  if(isset($_POST[name]) && (isset($_POST[param_1]) || (isset($_POST[php]) && $_SESSION[fscode_add_php] == 1))){
    $codes = $sql->getData("fscodes", "name");
    if(!in_array($_POST[name], $codes)){
      if(preg_match("#[^a-zA-Z-_]+#", $_POST[name]) == 0){
        $row = "name, param_1, param_2, added_date, added_user";
        $value[] = savesql(strtolower($_POST[name]));
        $value[] = savesql(str_replace(",", "&#44;", $_POST[param_1]));
        $value[] = (!isset($_POST[param_2]) || empty($_POST[param_2])) ? savesql(str_replace(",", "&#44;", $_POST[param_1])) : savesql(str_replace(",", "&#44;", $_POST[param_2]));
        $value[] = time();
        $value[] = $_SESSION[user_id];
        if(isset($_POST[isactive]) && $_POST[isactive] != "1"){
          $row .= ", active";
          $value[] = "0";
        }
        if(isset($_POST[userusage]) && $_POST[userusage] != "1"){
          $row .= ", userusage";
          $value[] = "0";
        }
        if(isset($_POST[contenttype]) && $_POST[contenttype] != "inline"){
          $row .= ", contenttype";
          $value[] = savesql(str_replace(",", "&#44;", $_POST[contenttype]));
        }
        if(isset($_POST[allowedin]) && $_POST[allowedin] != "inline&#44; block&#44; listitem&#44; link"){
          $row .= ", allowin";
          $value[] = savesql(str_replace(",", "&#44;", $_POST[allowedin]));
        }
        if(isset($_POST[disallowedin]) && $_POST[disallowedin] != ""){
          $row .= ", disallowin";
          $value[] = savesql(str_replace(",", "&#44;", $_POST[disallowedin]));
        }
        if(isset($_POST[callbacktype]) && $_POST[callbacktype] < 4 && $_POST[callbacktype] > 0){
          $row .= ", callbacktype";
          $value[] = intval($_POST[callbacktype]);
        }
        if(isset($_POST[example]) && $_POST[example] != ""){
          $row .= ", example";
          $value[] = savesql(str_replace(",", "&#44;", $_POST[example]));
        }
        if(isset($_POST[php]) && $_POST[php] != ""){
          $row .= ", php";
          $value[] = savesql(str_replace(",", "&#44;", $_POST[php]));
        }
        if(isset($_POST[group]) && $_POST[group] != "0"){
          $row .= ", group";
          $value[] = intval($_POST[group]);
        }

        $qry = $sql->setData("fscodes", $row, implode(", ", $value));

        if($qry !== false){
          $id = $sql->getInsertId();
          $flags = array(2, 5, 3, 3, 3, 3, 3, 2);
          for($i = 0; $i < count($_POST[flag][0]); $i++){
            $flag = array(intval($_POST[flag][0][$i]), intval($_POST[flag][1][$i]));
            if($flag[0] != 0 && $flag[0] <= count($flags) && $flag[1] < $flags[$flag[0]-1]){
              $sql->setData("fscodes_flag", "code, name, value", $id.", ".$flag[0].", ".$flag[1]);
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

          unset($_POST, $qry);
          systext($adminpage->langValue("save_ok"), $TEXT["admin"]->get("changes_saved"), FALSE, $TEXT["admin"]->get("icon_save_ok"));
        } else {
          unset($qry);
          $error = $sql->getError();
          $txt = $adminpage->langValue("save_error_1");
          $txt = str_replace("{..err_msg..}", $error[0], $txt);
          $txt = str_replace("{..err_no..}", $error[1], $txt);
          systext($txt, $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
          unset($error, $txt);
        }

      } else {
        systext($adminpage->langValue("save_error_2"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
      }
    } else
      systext($adminpage->langValue("save_error_3"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
  } else
    systext($TEXT["admin"]->get("form_not_filled"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
}
if($_GET[mode] == "advanced"){
  $flags = "";
  if(isset($_POST[flag])){
    for($i = 0; $i < count($_POST[flag][0]); $i++){
      if($_POST[flag][0][$i] != "0"){
        $adminpage->addCond("curflag",    $_POST[flag][0][$i]);
        $adminpage->addCond("curflagval", $_POST[flag][1][$i]);
        $flags .= $adminpage->get("flagselect");
      }
    }
  }
}

$oldcodes = $sql->getData("fscodes", "`name`");
if($oldcodes != 0){
  $codes = array();
  foreach($oldcodes as $code)
    $codes[] = $code[name];

  $oldcodes = "\"".implode("\", \"", $codes)."\"";
} else {
  $oldcodes = "";
}

$dropdowns[] = get_dropdowns("editor_param_1");
$dropdowns[] = get_dropdowns("editor_param_2");

$groups = $sql->getData("fscodes_groups", "*");
if($groups == 0){
  $adminpage->addCond("groups", "0");
} else {
  $othergroups = "";
  foreach($groups as $group){
    if(isset($_POST[group]) && $_POST[group] == $group[id])
      $adminpage->addCond("selected", 1);

    $adminpage->addText("id", $group[id]);
    $adminpage->addText("name", $group[name]);
    $othergroups .= $adminpage->get("groups");
  }
  if(!isset($_POST[group]) || (isset($_POST[group]) && intval($_POST[group]) == 0))
    $adminpage->addCond("group", 0);
  $adminpage->addText("othergroups", $othergroups);
}

if($_GET[mode] == "advanced"){
  // conditions
  $adminpage->addCond("callbacktype", isset($_POST[callbacktype])       ? $_POST[callbacktype]      : 0);
  $adminpage->addCond("php",          isset($_SESSION[fscode_add_php])  ? $_SESSION[fscode_add_php] : 0);
  $adminpage->addCond("advanced",     "1");

  //phrases
  $adminpage->addText("flagselect",   $flags);
  $adminpage->addText("contenttype",  isset($_POST[contenttype])? $_POST[contenttype] : "inline");
  $adminpage->addText("allowedin",    isset($_POST[allowedin]) ? $_POST[allowedin] : "inline&#44; block&#44; listitem&#44; link");
  $adminpage->addText("disallowedin", $_POST[disallowedin]);
  $adminpage->addText("param_3_val",  $_POST[php]);
}
// conditions
$adminpage->addCond("isactive",   isset($_POST[isactive])   ? $_POST[isactive]  : 1);
$adminpage->addCond("userusage",  isset($_POST[userusage])  ? $_POST[userusage] : 1);
// phrases
$adminpage->addText("definedcodes", $oldcodes);
$adminpage->addText("FSROOT",       FS2_ROOT_PATH);
$adminpage->addText("name",         $_POST[name]);
$adminpage->addText("example",      $_POST[example]);
$adminpage->addText("dropdown_1_1", $dropdowns[0]['global_vars']);
$adminpage->addText("dropdown_2_1", $dropdowns[0]['applets']);
$adminpage->addText("dropdown_3_1", $dropdowns[0]['snippets']);
$adminpage->addText("dropdown_1_2", $dropdowns[1]['global_vars']);
$adminpage->addText("dropdown_2_2", $dropdowns[1]['applets']);
$adminpage->addText("dropdown_2_3", $dropdowns[1]['snippets']);
$adminpage->addText("param_1_val",  $_POST[param_1]);
$adminpage->addText("param_2_val",  $_POST[param_2]);
$adminpage->addText("tag_1", get_taglist(array(array(tag => "x", text => $adminpage->langValue("tag_1"))), "param_1" ));
$adminpage->addText("tag_2", get_taglist(array(array(tag => "x", text => $adminpage->langValue("tag_2_1")), array(tag => "y", text  => $adminpage->langValue("tag_2_2"))), "param_2" ));
echo $adminpage->get("main");
?>