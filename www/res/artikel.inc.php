<?php

$_GET[go] = savesql($_GET[go]);

$index = mysql_query("select * from ".$global_config_arr[pref]."artikel where artikel_url = '$_GET[go]'", $db);
$dbartikeltitle = mysql_result($index, 0, "artikel_title");

$dbartikeluser = mysql_result($index, 0, "artikel_user");
$index2 = mysql_query("select user_id, user_name from ".$global_config_arr[pref]."user where user_id = '$dbartikeluser'", $db);
if (mysql_num_rows($index2) == 1)
{
    $dbusername = mysql_result($index2, 0, "user_name");
    $userlink = '?go=profil&amp;userid=' . mysql_result($index2, 0, "user_id");

    $tindex = mysql_query("select artikel_autor from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $autor = stripslashes(mysql_result($tindex, 0, "artikel_autor"));
    $autor = str_replace("{profillink}", $userlink, $autor); 
    $autor = str_replace("{username}", $dbusername, $autor); 
}

$dbartikeldate = mysql_result($index, 0, "artikel_date");
if ($dbartikeldate != 0)
{
    $date = date("d.m.Y", $dbartikeldate);
}

if (mysql_result($index, 0, "artikel_fscode") == 1)
{
    $dbartikeltext = fscode(stripslashes(mysql_result($index, 0, "artikel_text")), 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
}
else
{
    $dbartikeltext = stripslashes(mysql_result($index, 0, "artikel_text"));
}

$tindex = mysql_query("select artikel_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$body = stripslashes(mysql_result($tindex, 0, "artikel_body"));
$body = str_replace("{titel}", $dbartikeltitle, $body); 
$body = str_replace("{datum}", $date, $body); 
$body = str_replace("{text}", $dbartikeltext, $body); 
$body = str_replace("{autor}", $autor, $body); 

$template =  $body;
?>