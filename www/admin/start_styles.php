<?php
$active_style = $global_config_arr['style_tag'];

$index = mysql_query ( "
                        SELECT COUNT(`style_id`) AS 'num_styles'
                        FROM `".$global_config_arr['pref']."styles`
                        WHERE `style_id` != 0
                        AND `style_tag` != 'default'
", $db);
$num_styles = mysql_result ( $index, 0, "num_styles" );

$index = mysql_query ( "
                        SELECT `style_tag`
                        FROM `".$global_config_arr['pref']."styles`
                        WHERE `style_id` != 0
                        AND `style_tag` != 'default'
                        ORDER BY `style_id` DESC
                        LIMIT 0,1
", $db);
$last_style = killhtml ( mysql_result ( $index, 0, "style_tag" ) );

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Informationen & Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Aktiver Style:</td>
                                <td class="configthin"><b>'.$active_style.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Anzahl Styles:</td>
                                <td class="configthin"><b>'.$num_styles.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Neuester Style:</td>
                                <td class="configthin"><b>'.$last_style.'</b></td>
                            </tr>
                        </table>
';
?>