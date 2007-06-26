<?php
// Zeitgesteuert (einzelnes Bild)
$index = mysql_query("select * from fs_screen_random a inner join fs_screen b on (a.screen_id = b.screen_id) and a.start <= UNIX_TIMESTAMP() and a.end >= UNIX_TIMESTAMP()", $db);
$rows = mysql_num_rows($index);
if ($rows == 0)
{
    // Zufallsgesteuert (ganze Kategorie)
    $index = mysql_query("select * from fs_screen_cat a inner join fs_screen b on (a.cat_id = b.cat_id) and a.randompic = 1", $db);
    $rows = mysql_num_rows($index);
}
if ($rows > 0)
{
    srand((double)microtime()*1000000);
    $randompic = rand(0,$rows-1);

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
?>

