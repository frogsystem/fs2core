<?php

$index = mysql_query("select * from fs_potm", $db);
$rows = mysql_num_rows($index);
if ($rows > 0)
{
    srand((double)microtime()*1000000);
    $potm = rand(0,$rows-1);

    $dbpotmid = mysql_result($index, $potm, "potm_id");
    $dbpotmtitle = mysql_result($index, $potm, "potm_title");
    $dbpotmtitle2 = str_replace(" ","%20",$dbpotmtitle);
    $dbpotmtitle2 = savesql($dbpotmtitle2);

    $bild = "images/potm/" . $dbpotmid . ".jpg";
    $mini = "images/potm/" . $dbpotmid . "_s.jpg";
    $link = 'showimg.php?pic='.$bild.'&amp;title='.$dbpotmtitle2;

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