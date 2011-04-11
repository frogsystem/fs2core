<?php
$index = mysql_query ( "
                        SELECT COUNT(`alias_id`) AS 'num_aliases'
                        FROM `".$global_config_arr['pref']."aliases`
", $db);
$num_aliases = mysql_result ( $index, 0, "num_aliases" );
$index = mysql_query ( "
                        SELECT COUNT(`alias_id`) AS 'num_aliases_active'
                        FROM `".$global_config_arr['pref']."aliases`
                        WHERE `alias_active` = 1
", $db);
$num_aliases_active = mysql_result ( $index, 0, "num_aliases_active" );

$index = mysql_query ( "
                        SELECT COUNT(`applet_id`) AS 'num_applets'
                        FROM `".$global_config_arr['pref']."applets`
", $db);
$num_applets = mysql_result ( $index, 0, "num_applets" );
$index = mysql_query ( "
                        SELECT COUNT(`applet_id`) AS 'num_applets_active'
                        FROM `".$global_config_arr['pref']."applets`
                        WHERE `applet_active` = 1
", $db);
$num_applets_active = mysql_result ( $index, 0, "num_applets_active" );


$index = mysql_query ( "
                        SELECT COUNT(`snippet_id`) AS 'num_snippets'
                        FROM `".$global_config_arr['pref']."snippets`
", $db);
$num_snippets = mysql_result ( $index, 0, "num_snippets" );
$index = mysql_query ( "
                        SELECT COUNT(`snippet_id`) AS 'num_snippets_active'
                        FROM `".$global_config_arr['pref']."snippets`
                        WHERE `snippet_active` = 1
", $db);
$num_snippets_active = mysql_result ( $index, 0, "num_snippets_active" );


echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("informations_and_statistics").'</td></tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT["admin"]->get("system_start_num_aliases").':</td>
                                <td class="configthin"><b>'.$num_aliases.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT["admin"]->get("system_start_num_aliases_active").':</td>
                                <td class="configthin"><b>'.$num_aliases_active.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">'.$TEXT["admin"]->get("system_start_num_applets").':</td>
                                <td class="configthin"><b>'.$num_applets.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">'.$TEXT["admin"]->get("system_start_num_applets_active").':</td>
                                <td class="configthin"><b>'.$num_applets_active.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">'.$TEXT["admin"]->get("system_start_num_snippets").':</td>
                                <td class="configthin"><b>'.$num_snippets.'</b></td>
                            </tr>
                                <td class="configthin">'.$TEXT["admin"]->get("system_start_num_snippets_active").':</td>
                                <td class="configthin"><b>'.$num_snippets_active.'</b></td>
                            </tr>
                        </table>
';
?>