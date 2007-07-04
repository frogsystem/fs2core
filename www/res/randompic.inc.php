<?php
$index = mysql_query("SELECT * FROM fs_screen_random_config WHERE id = 1", $db);
$config_arr = mysql_fetch_assoc($index);

if ($config_arr[active] == 1)
{
  if ($config_arr[type_priority] == 1)
  {
    // random pic (time controlled)
    $index = mysql_query("SELECT * FROM fs_screen_random a INNER JOIN fs_screen b ON (a.screen_id = b.screen_id) AND a.start <= UNIX_TIMESTAMP() AND a.end >= UNIX_TIMESTAMP()", $db);
    $rows = mysql_num_rows($index);
  }
  else
  {
    // random pic (random from categories)
    $index = mysql_query("SELECT * FROM fs_screen_cat a INNER JOIN fs_screen b ON (a.cat_id = b.cat_id) AND a.randompic = 1 AND a.cat_type != 2 ORDER BY RAND() LIMIT 1", $db); //cat_type = 2 => wallpaper!
    $rows = mysql_num_rows($index);
  }

  if ($rows > 0)
  {
    $dbscreenid = mysql_result($index, $randompic, "screen_id");
    $dbscreenname = mysql_result($index, $randompic, "screen_name");

    $bild = "images/screenshots/" . $dbscreenid . ".jpg";
    $mini = "images/screenshots/" . $dbscreenid . "_s.jpg";
    $link = 'showimg.php?pic='.$bild.'&amp;title='.$dbscreenname;

    $tindex = mysql_query("select potm_body from fs_template where id = '$global_config_arr[design]'", $db);
    $body = stripslashes(mysql_result($tindex, 0, "potm_body"));
    $body = str_replace("{titel}", $dbpotmtitle, $body);
    $body = str_replace("{thumb}", $mini, $body);
    $body = str_replace("{link}", $link, $body);

    $template = $body;
  }
  else
  {
    $index = mysql_query("select potm_nobody from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "potm_nobody"));
  }
  
}
else
{
  $template = "";
}
?>
