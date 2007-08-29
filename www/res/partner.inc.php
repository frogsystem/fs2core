<?php
////////////////////////////////////////
//// Permanent anzuzeigende Partner ////
////////////////////////////////////////

$permanent = mysql_query("SELECT partner_id, 
                                 partner_name,
                                 partner_link,
                                 partner_beschreibung,
                                 partner_permanent
                          FROM fs_partner WHERE partner_permanent = 1", $db);
while ($permanent_arr = mysql_fetch_assoc($permanent))
{
    $index2 = mysql_query("select partner_navi_eintrag from fs_template where id = '$global_config_arr[design]'", $db);
    $partner = stripslashes(mysql_result($index2, 0, "partner_navi_eintrag"));
    $partner = str_replace("{url}", $permanent_arr[partner_link], $partner);
    $partner = str_replace("{img_url}", image_url("images/partner/",$permanent_arr[partner_id]."_big"), $partner);
    $partner = str_replace("{button_url}", image_url("images/partner/",$permanent_arr[partner_id]."_small"), $partner);
    $partner = str_replace("{name}", $permanent_arr[partner_name], $partner);
    $partner = str_replace("{text}", $permanent_arr[partner_beschreibung], $partner);
    
    $permanent_list .= $partner;
    $shuffle_arr[] = $partner;

}
unset($permanent_arr);


//////////////////////////////////////
//// Variablen für Zufallspartner ////
//////////////////////////////////////

// Zahl der aus der Gesamtzahl auszuwählenden Partner        
$index = mysql_query("SELECT partner_anzahl FROM fs_partner_config", $db);
$rand_arr[shuffle_non_perm] = mysql_result($index,0,"partner_anzahl");
$rand_arr[shuffle_all] = mysql_result($index,0,"partner_anzahl");
//Zahl der existierenden Partner
$index = mysql_query("SELECT COUNT(partner_id) AS number FROM fs_partner", $db);
if (mysql_result($index,0,"number")<$rand_arr[shuffle_all]){
    $rand_arr[shuffle_all] = mysql_result($index,0,"number");
}
$index = mysql_query("SELECT COUNT(partner_id) AS number FROM fs_partner WHERE partner_permanent = 0", $db);
if (mysql_result($index,0,"number")<$rand_arr[shuffle_non_perm]){
    $rand_arr[shuffle_non_perm] = mysql_result($index,0,"number");
}


////////////////////////
//// Zufallsauswahl ////
////////////////////////

$non_permanent = mysql_query("SELECT partner_id,
                                     partner_name,
                                     partner_link,
                                     partner_beschreibung,
                                     partner_permanent
                              FROM fs_partner WHERE partner_permanent = 0", $db);
while ($non_permanent_arr = mysql_fetch_assoc($non_permanent))
{
    $index2 = mysql_query("SELECT partner_navi_eintrag FROM fs_template WHERE id = '$global_config_arr[design]'", $db);
    $partner = stripslashes(mysql_result($index2, 0, "partner_navi_eintrag"));
    $partner = str_replace("{url}", $non_permanent_arr[partner_link], $partner);
    $partner = str_replace("{img_url}", image_url("images/partner/",$non_permanent_arr[partner_id]."_big"), $partner);
    $partner = str_replace("{button_url}", image_url("images/partner/",$non_permanent_arr[partner_id]."_small"), $partner);
    $partner = str_replace("{name}", $non_permanent_arr[partner_name], $partner);
    $partner = str_replace("{text}", $non_permanent_arr[partner_beschreibung], $partner);

    $non_perm_shuffle_arr[] = $partner;
    $shuffle_arr[] = $partner;

}
unset($non_permanent_arr);

if ($rand_arr[shuffle_non_perm] > 0)
{
    srand((float) microtime() * 10000000);
    shuffle($non_perm_shuffle_arr);
    for ($i=0;$i<$rand_arr[shuffle_non_perm];$i++) {
        $non_permanent_list .= $non_perm_shuffle_arr[$i];
    }
}
if ($rand_arr[shuffle_all] > 0)
{
    srand((float) microtime() * 10000000);
    shuffle($shuffle_arr);
    for ($i=0;$i<$rand_arr[shuffle_all];$i++) {
        $partner_all_list .= $shuffle_arr[$i];
    }
}

$index = mysql_query("select partner_navi_body from fs_template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "partner_navi_body"));
$template = str_replace("{partner_all}", $partner_all_list, $template);
$template = str_replace("{permanents}", $permanent_list, $template);
$template = str_replace("{non_permanents}", $non_permanent_list, $template);
?>