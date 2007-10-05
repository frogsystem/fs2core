<?php
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen_random_config WHERE id = 1", $db);
$config_arr = mysql_fetch_assoc($index);

if ($config_arr[active] == 1)
{
    $index_timed = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen_random a INNER JOIN ".$global_config_arr[pref]."screen b ON (a.screen_id = b.screen_id) AND a.start <= UNIX_TIMESTAMP() AND a.end >= UNIX_TIMESTAMP() ORDER BY RAND() LIMIT 1", $db);

    $index_cat = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen_cat a INNER JOIN ".$global_config_arr[pref]."screen b ON (a.cat_id = b.cat_id) AND a.randompic = 1 AND a.cat_type != 2 ORDER BY RAND() LIMIT 1", $db); //cat_type = 2 => wallpaper!

  if ($config_arr[type_priority] == 1)
  {
    // random pic (time controlled)
    $index = $index_timed;
    $rows = mysql_num_rows($index_timed);
    $type = 1;
  }
  else
  {
    // random pic (random from categories)
    $index = $index_cat;
    $rows = mysql_num_rows($index_cat);
    $type = 2;
  }

  if ($rows <= 0 AND $config_arr[use_priority_only] != 1)
  {
    if ($config_arr[type_priority] == 1) {
      // random pic (random from categories)
      $index = $index_cat;
      $rows = mysql_num_rows($index_cat);
      $type = 2;
    } else {
      // random pic (time controlled)
      $index = $index_timed;
      $rows = mysql_num_rows($index_timed);
      $type = 1;
    }
  }

  if ($rows > 0)
  {
    $dbscreenid = mysql_result($index, $randompic, "screen_id");
    $dbscreenname = mysql_result($index, $randompic, "screen_name");
    $dbscreencat = mysql_result($index, $randompic, "cat_id");

    $bild = image_url("images/screenshots/", $dbscreenid);
    $mini = image_url("images/screenshots/", $dbscreenid."_s");

    if ($type==1) {
      $link = 'showimg.php?pic='.$bild.'&amp;title='.$dbscreenname;
    } else {
      $link = "showimg.php?screen=1&amp;catid=$dbscreencat&amp;screenid=$dbscreenid";
    }

    $tindex = mysql_query("select randompic_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $body = stripslashes(mysql_result($tindex, 0, "randompic_body"));
    $body = str_replace("{titel}", $dbpotmtitle, $body);
    $body = str_replace("{thumb}", $mini, $body);
    $body = str_replace("{link}", $link, $body);

    $template = $body;
  }
  else
  {
    $index = mysql_query("select randompic_nobody from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "randompic_nobody"));
  }
  
}
else
{
  $template = "";
}
?>