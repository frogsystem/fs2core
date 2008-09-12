<?php
$index = mysql_query ( "
						SELECT COUNT(`id`) AS 'num_sv'
						FROM ".$global_config_arr['pref']."includes
						WHERE `include_type` = '1'
", $db);
$num_sv = mysql_result ( $index, 0, "num_sv" );

$index = mysql_query ( "
						SELECT COUNT(`id`) AS 'num_res_user'
						FROM ".$global_config_arr['pref']."includes
						WHERE `include_type` = '2'
", $db);
$num_res_user = mysql_result ( $index, 0, "num_res_user" );

$index = mysql_query ( "
						SELECT COUNT(`id`) AS 'num_res_sys'
						FROM ".$global_config_arr['pref']."resources
						WHERE `hardcoded` = '1'
", $db);
$num_res_sys = mysql_result ( $index, 0, "num_res_sys" );

$num_res = $num_res_sys + $num_res_user;

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">Informationen & Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Seitenvariablen:</td>
                                <td class="configthin"><b>'.$num_sv.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Anzahl Ressourcen (gesamt):</td>
                                <td class="configthin"><b>'.$num_res.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Anzahl Ressourcen (System):</td>
                                <td class="configthin"><b>'.$num_res_sys.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Anzahl echte Includes (User):</td>
                                <td class="configthin"><b>'.$num_res_user.'</b></td>
                            </tr>
						</table>
';
?>