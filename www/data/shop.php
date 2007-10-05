<?php

$index = mysql_query("select * from ".$global_config_arr[pref]."shop", $db);
while ($artikel_arr = mysql_fetch_assoc($index))
{
    $artikel_arr[artikel_text] = fscode($artikel_arr[artikel_text], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
    $artikel_arr[artikel_bild] = "images/shop/" . $artikel_arr[artikel_id] . ".jpg";
    $artikel_arr[artikel_thumb] = "images/shop/" . $artikel_arr[artikel_id] . "_s.jpg";

    $index2 = mysql_query("select shop_artikel from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $artikel = stripslashes(mysql_result($index2, 0, "shop_artikel"));
    $artikel = str_replace("{titel}", $artikel_arr[artikel_name], $artikel); 
    $artikel = str_replace("{beschreibung}", $artikel_arr[artikel_text], $artikel); 
    $artikel = str_replace("{preis}", $artikel_arr[artikel_preis], $artikel); 
    $artikel = str_replace("{bestell_url}", $artikel_arr[artikel_url], $artikel); 
    $artikel = str_replace("{bild}", $artikel_arr[artikel_bild], $artikel); 
    $artikel = str_replace("{thumbnail}", $artikel_arr[artikel_thumb], $artikel);

    $artikel_list .= $artikel;
}
unset($artikel_arr);

$index = mysql_query("select shop_main_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "shop_main_body"));
$template = str_replace("{artikel}", $artikel_list, $template); 

unset($artikel_list);


?>