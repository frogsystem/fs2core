<?php
$index = mysql_query ( "
						SELECT T.`name`
						FROM ".$global_config_arr['pref']."template T, ".$global_config_arr['pref']."global_config C
						WHERE T.`id` = C.`design`
						LIMIT 0,1
", $db);
$active_design = stripslashes ( mysql_result ( $index, 0, "name" ) );

$index = mysql_query ( "
						SELECT COUNT(`id`) AS 'num_designs'
						FROM ".$global_config_arr['pref']."template
", $db);
$num_designs = mysql_result ( $index, 0, "num_designs" );

$index = mysql_query ( "
						SELECT `name`
						FROM ".$global_config_arr['pref']."template
						ORDER BY `id` DESC
						LIMIT 0,1
", $db);
$last_design = stripslashes ( mysql_result ( $index, 0, "name" ) );

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">Informationen & Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Aktives Design:</td>
                                <td class="configthin"><b>'.$active_design.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Anzahl Designs:</td>
                                <td class="configthin"><b>'.$num_designs.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Neuestes Designs:</td>
                                <td class="configthin"><b>'.$last_design.'</b></td>
                            </tr>
						</table>
';
?>