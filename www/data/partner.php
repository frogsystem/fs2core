<?php

$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."partner ORDER BY partner_name", $db);
while ($partner_arr = mysql_fetch_assoc($index))
{
    $index2 = mysql_query("select partner_eintrag from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $partner = stripslashes(mysql_result($index2, 0, "partner_eintrag"));
    $partner = str_replace("{url}", $partner_arr[partner_link], $partner);
    $partner = str_replace("{img_url}", image_url("images/partner/",$partner_arr[partner_id]."_big"), $partner);
    $partner = str_replace("{button_url}", image_url("images/partner/",$partner_arr[partner_id]."_small"), $partner);
    $partner = str_replace("{name}", $partner_arr[partner_name], $partner);
    $partner = str_replace("{text}", $partner_arr[partner_beschreibung], $partner);

    $partner_list .= $partner;
    
    if ($partner_arr[partner_permanent] == 1) {
        $perm_list .= $partner;
    }
    if ($partner_arr[partner_permanent] == 0) {
        $nonperm_list .= $partner;
    }
}
unset($partner_arr);

$index = mysql_query("select partner_main_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "partner_main_body"));
$template = str_replace("{partner_all}", $partner_list, $template);
$template = str_replace("{permanents}", $perm_list, $template);
$template = str_replace("{non_permanents}", $nonperm_list, $template);

unset($partner_list);
unset($perm_list);
unset($nonperm_list);

?>