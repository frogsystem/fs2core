<?php

$index = mysql_query("select artikel_id, artikel_name, artikel_url from ".$global_config_arr[pref]."shop where artikel_hot = 1", $db);
while ($shop_arr = mysql_fetch_assoc($index))
{
   $index2 = mysql_query("select shop_hot from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
   $hotlink = stripslashes(mysql_result($index2, 0, "shop_hot"));
   $hotlink = str_replace("{titel}", $shop_arr[artikel_name], $hotlink); 
   $hotlink = str_replace("{link}", $shop_arr[artikel_url], $hotlink); 
   $hotlink = str_replace("{thumb}", "images/shop/".$shop_arr[artikel_id]."_s.jpg", $hotlink); 
   $hotlinks .= $hotlink;
}
unset($shop_arr);

$index = mysql_query("select shop_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "shop_body"));
$template = str_replace("{hotlinks}", $hotlinks, $template); 
?>