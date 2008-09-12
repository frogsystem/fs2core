<?php
$index = mysql_query ( "
						SELECT COUNT(`partner_id`) AS 'num_partner'
						FROM ".$global_config_arr['pref']."partner
", $db);
$num_partner = mysql_result ( $index, 0, "num_partner" );

if ( $num_partner  > 0 ) {
	$index = mysql_query ( "
							SELECT `partner_name`
							FROM ".$global_config_arr['pref']."partner
							ORDER BY `partner_id` DESC
							LIMIT 0,1
	", $db);
	$last_partner = stripslashes ( mysql_result ( $index, 0, "partner_name" ) );
}

$index = mysql_query ( "
						SELECT COUNT(`artikel_id`) AS 'num_shop'
						FROM ".$global_config_arr['pref']."shop
", $db);
$num_shop = mysql_result ( $index, 0, "num_shop" );

if ( $num_shop  > 0 ) {
	$index = mysql_query ( "
							SELECT `artikel_name`
							FROM ".$global_config_arr['pref']."shop
							ORDER BY `artikel_id` DESC
							LIMIT 0,1
	", $db);
	$last_shop = stripslashes ( mysql_result ( $index, 0, "artikel_name" ) );
}


echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">Informationen & Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Partnerseiten:</td>
                                <td class="configthin"><b>'.$num_partner.'</b></td>
                            </tr>
';

if ( $num_partner  > 0 ) {
	echo '
                            <tr>
                                <td class="configthin">Neuester Partner:</td>
                                <td class="configthin"><b>'.$last_partner .'</b></td>
                            </tr>
	';
}

echo '
                            <tr>
                                <td class="configthin">Anzahl Produkte:</td>
                                <td class="configthin"><b>'.$num_shop.'</b></td>
                            </tr>
';

if ( $num_shop  > 0 && $temp_biggest_exists  > 0 ) {
	echo '
                            <tr>
                                <td class="configthin">Neuestes Produkt:</td>
                                <td class="configthin"><b>'.$last_shop .'</b></td>
                            </tr>
	';
}

echo '
						</table>
';
?>