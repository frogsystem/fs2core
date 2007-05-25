<?php

$index = mysql_query("SELECT * FROM fs_partner ORDER BY partner_name", $db);
while ($partner_arr = mysql_fetch_assoc($index))
{
    $index2 = mysql_query("select partner_eintrag from fs_template where id = '$global_config_arr[design]'", $db);
    $partner = stripslashes(mysql_result($index2, 0, "partner_eintrag"));
    $partner = str_replace("{url}", $partner_arr[partner_link], $partner);
    $partner = str_replace("{bild}", "images/partner/".$partner_arr[partner_id]."_120x50.".$partner_arr[partner_bild120x50], $partner);
    $partner = str_replace("{name}", $partner_arr[partner_name], $partner);
    $partner = str_replace("{text}", $partner_arr[partner_beschreibung], $partner);

    $partner_list .= $partner;
}
unset($partner_arr);

$index = mysql_query("select partner_main_body from fs_template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "partner_main_body"));
$template = str_replace("{partner}", $partner_list, $template);

unset($partner_list);

?>