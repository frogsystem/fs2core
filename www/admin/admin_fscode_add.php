<?php
if(isset($_POST[addcode])){
  if( isset($_POST[name])         && !empty($_POST[name])         &&
      isset($_POST[contenttype])  && !empty($_POST[contenttype])  &&
      isset($_POST[allowedin])    && !empty($_POST[allowedin])    &&
     (isset($_POST[callbacktype]) && !empty($_POST[callbacktype]) || intval($_POST[callbacktype]) == 0) &&
    ((isset($_POST[param_1])      && !empty($_POST[param_1]))     ||
     (isset($_POST[php])          && !empty($_POST[php])          && $_SESSION[fscode_add_php] == 1))){
    $codes = $sql->getData("fscodes", "name");
    if(!in_array($_POST[name], $codes)){
      if(preg_match("#[^a-zA-Z-_]+#", $_POST[name]) == 0){
        $name         = savesql(strtolower($_POST[name]));
        $content      = savesql(str_replace(",", "&#44;", $_POST[contenttype]));
        $allow        = savesql(str_replace(",", "&#44;", $_POST[allowedin]));
        $disallow     = savesql(str_replace(",", "&#44;", $_POST[disallowedin]));
        $callback     = intval($_POST[callbacktype]);
        $callback   = ($callback > 6 || $callback < 0)  ? 0 : $callback;
        $active       = ($_POST[isactive] == "1")         ? 1 : 0;
        $paragraphes  = ($_POST[paragraphes] == "1")      ? 1 : 0;
        $param_1      = savesql(str_replace(",", "&#44;", $_POST[param_1]));
        $param_2      = (!isset($_POST[param_2]) || empty($_POST[param_2]))?$param_1:savesql(str_replace(",", "&#44;", $_POST[param_2]));
        $php          = ($_SESSION[fscode_add_php]) ? savesql(str_replace(",", "&#44;", $_POST[php])) : "";
        if($sql->setData("fscodes",
          "name, contenttype, callbacktype, allowin, disallowin, param_1, param_2, php, active, added",
          "$name, $content, $callback, $allow, $disallow, $param_1, $param_2, $php, $active, ".$_SESSION[user_id]." ".time()."")){
          $id = mysql_insert_id($sql->getRes());
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

          unset($_POST, $name, $content, $allow, $disallow, $callback, $active, $paragraphes, $param_1, $param_2, $php);
          systext($adminpage->lang("save_ok"), $TEXT["admin"]->get("changes_saved"), FALSE, $TEXT["admin"]->get("icon_save_ok"));
        } else {
          unset($name, $content, $allow, $disallow, $callback, $active, $paragraphes, $param_1, $param_2, $php);
          $error = $sql->getError();
          $txt = $adminpage->lang("save_error_1");
          $txt = str_replace("{..err_msg..}", $error[0], $txt);
          $txt = str_replace("{..err_no..}", $error[1], $txt);
          systext($txt, $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
          unset($error, $txt);
        }

      } else {
        systext($adminpage->lang("save_error_2"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
      }
    } else
      systext($adminpage->lang("save_error_3"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
  } else
    systext($TEXT["admin"]->get("form_not_filled"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
}
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

// conditions
$adminpage->addCond("callbacktype", isset($_POST[callbacktype])       ? $_POST[callbacktype]      : 0);
$adminpage->addCond("isactive",     isset($_POST[isactive])           ? $_POST[isactive]          : 1);
$adminpage->addCond("php",          isset($_SESSION[fscode_add_php])  ? $_SESSION[fscode_add_php] : 0);
// phrases
$adminpage->addPhrase("flagselect",   $flags);
$adminpage->addPhrase("definedcodes", $oldcodes);
$adminpage->addPhrase("FSROOT",       FS2_ROOT_PATH);
$adminpage->addPhrase("name",         $_POST[name]);
$adminpage->addPhrase("contenttype",  $_POST[contenttype]);
$adminpage->addPhrase("allowedin",    $_POST[allowedin]);
$adminpage->addPhrase("disallowedin", $_POST[disallowedin]);
$adminpage->addPhrase("dropdown_1_1", $dropdowns[0]['global_vars']);
$adminpage->addPhrase("dropdown_2_1", $dropdowns[0]['applets']);
$adminpage->addPhrase("dropdown_3_1", $dropdowns[0]['snippets']);
$adminpage->addPhrase("dropdown_1_2", $dropdowns[1]['global_vars']);
$adminpage->addPhrase("dropdown_2_2", $dropdowns[1]['applets']);
$adminpage->addPhrase("dropdown_3_2", $dropdowns[1]['snippets']);
$adminpage->addPhrase("param_1_val",  $_POST[param_1]);
$adminpage->addPhrase("param_2_val",  $_POST[param_2]);
$adminpage->addPhrase("param_3_val",  $_POST[php]);
$adminpage->addPhrase("submitarrow",  $admin_phrases[common][arrow]);
$adminpage->addPhrase("submittext",   $admin_phrases[common][save_long]);
$adminpage->addPhrase("tag_1", get_taglist(array(array(tag => "x", text => $adminpage->lang("tag_1"))), "param_1" ));
$adminpage->addPhrase("tag_2", get_taglist(array(array(tag => "x", text => $adminpage->lang("tag_2_1")), array(tag => "y", text  => $adminpage->lang("tag_2_2"))), "param_2" ));
echo $adminpage->get("main");
?>