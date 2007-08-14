<?php
include("config.inc.php");
if ($db)
{
  $template_begin = '
  
<style type="text/css"><!--
';
  $template_end = '
--></style>

';

  $index = mysql_query("SELECT editor_css FROM fs_template WHERE id = '$global_config_arr[design]'");
  $template = $template_begin . stripslashes(mysql_result($index, 0, "editor_css")) . $template_end;
}
?>