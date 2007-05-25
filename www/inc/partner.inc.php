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
    $partner = str_replace("{bild}", image_url("images/partner/", $permanent_arr[partner_id]."_small", false), $partner);
    $partner = str_replace("{name}", $permanent_arr[partner_name], $partner);
    $partner = str_replace("{text}", $permanent_arr[partner_beschreibung], $partner);
    
    $permanent_list .= $partner;

}
unset($permanent_arr);


//////////////////////////////////////
//// Variablen für Zufallspartner ////
//////////////////////////////////////

// Zahl der aus der Gesamtzahl auszuwählenden Partner        
$index = mysql_query("SELECT * FROM fs_partner_config", $db);
$rand_arr = mysql_fetch_assoc($index);
$randanzahl = $rand_arr[partner_anzahl];
unset($rand_arr);

// Abgleich mit Anzahl der existierenden Datensätze
$index = mysql_query("SELECT partner_id FROM fs_partner WHERE partner_permanent = 0", $db);
if (mysql_num_rows($index) < $randanzahl)
{
        $randanzahl = mysql_num_rows($index); // Wenn Anzahl auszuwählender Partner zu groß ist, diese Anzahl verkleinern
} 

// Gesamtzahl aller Partner
$index = mysql_query("SELECT MAX(partner_id) AS partner_id FROM fs_partner", $db); //größter Datensatz = Anzahl an Datensätzen
$rand_arr = mysql_fetch_assoc($index);
$rows = $rand_arr[partner_id];

////////////////////////
//// Zufallsauswahl ////
////////////////////////

if ($rows > 0)
{
        function checkifdouble($ran,$i) // prüft, ob diese Zahl schon "ausgewürfelt" wurde
        {
            for ($j=1; $j<$i; $j++)
            {
                if ($ran[$j] == $ran[$i])
                {
                    $ergebnis = "true";
                    break;
                }
                else
                {
                    $ergebnis = "false";
                }
            }
            return $ergebnis;
        }
        
        for ($i=1; $i<=$randanzahl; $i++) 
        {
            $ran[$i] = mt_rand(1, $rows); // "würfelt" Zahl aus
            if ($i>1) // erst ab zweiter Zahl Vergleich, ob Zahl schon dran war
            {
                while (checkifdouble($ran,$i) == "true") // so lange "würfeln", bis eine Zahl kommt, die noch nicht dran war (!=true, mit checkifdouble prüfen)
                {
                    $ran[$i] = mt_rand(1, $rows);
                }
            }
            $index2 = mysql_query("SELECT partner_id,
                                          partner_name,
                                          partner_link,
                                          partner_beschreibung,
                                          partner_permanent
                                   FROM fs_partner WHERE partner_id = '$ran[$i]'
                                                   AND partner_permanent = 0", $db);
                $partner_arr = mysql_fetch_assoc($index2);
                if ($partner_arr[partner_id] == NULL) // falls Datensatz mit der ausgewürfelten id nicht existiert (z.B. gelöscht), Zähler um 1 zurücksetzen, weiter mit for-Schleife
                {
                        $i--;
                        unset ($partner_arr);
                }
                else // Bild mit Link ausgeben
                {
                    $index3 = mysql_query("select partner_navi_eintrag from fs_template where id = '$global_config_arr[design]'", $db);
                    $partner = stripslashes(mysql_result($index3, 0, "partner_navi_eintrag"));
                    $partner = str_replace("{url}", $partner_arr[partner_link], $partner);
                    $partner = str_replace("{bild}", image_url("images/partner/", $partner_arr[partner_id]."_small", false), $partner);
                    $partner = str_replace("{name}", $partner_arr[partner_name], $partner);
                    $partner = str_replace("{text}", $partner_arr[partner_beschreibung], $partner);

                    $partner_navi_list .= $partner;

                    unset ($partner_arr);
                }
        }
}

else
{
    $partner_navi_list = '<br><br>';
}

$index = mysql_query("select partner_navi_body from fs_template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "partner_navi_body"));
$template = str_replace("{permanents}", $permanent_list, $template);
$template = str_replace("{non-permanents}", $partner_navi_list, $template);
?>