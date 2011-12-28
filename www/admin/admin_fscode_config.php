<?php
if(isset($_POST[save])){
  $post = array_map("intval", $_POST);
  if(isset($post[file_max_size],$post[file_max_width],$post[file_max_height],$post[image]) &&
    !empty($post[file_max_size]) && !empty($post[file_max_width]) && !empty($post[file_max_height]) &&
   ($post[image] == 1 || $post[image] == 0)){
    $sql->updateData("fscodes_config", "value", $post[file_max_size], "WHERE `type`='file_size'");
    $sql->updateData("fscodes_config", "value", $post[file_max_width], "WHERE `type`='file_height'");
    $sql->updateData("fscodes_config", "value", $post[file_max_height], "WHERE `type`='file_width'");
    $sql->updateData("fscodes_config", "value", $post[image], "WHERE `type`='image'");
    systext($TEXT['admin']->get("changes_saved"), false, false, $TEXT["admin"]->get("icon_save_ok"));
  } else
    systext($TEXT['admin']->get("form_not_filled"), false, true, $TEXT["admin"]->get("icon_save_error"));
}
$data = $sql->getData("fscodes_config", "*");
foreach($data as $tmp)
  $tmp2[$tmp[type]] = $tmp[value];
$data = $tmp2;
unset($tmp, $tmp2);
//conditions
$adminpage->addCond("image", $data[image]);
//phrases
$adminpage->addText("file_max_size",    $data[file_size]);
$adminpage->addText("file_max_width",   $data[file_height]);
$adminpage->addText("file_max_height",  $data[file_width]);
$adminpage->addText("submitarrow",      $admin_phrases[common][arrow]);
$adminpage->addText("submittext",       $admin_phrases[common][save_long]);
echo $adminpage->get("main");

?>