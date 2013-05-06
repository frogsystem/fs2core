<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$active_style = $FD->config('style_tag');

$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(`style_id`) AS 'num_styles'
                FROM `".$FD->config('pref')."styles`
                WHERE `style_id` != 0
                AND `style_tag` != 'default'");
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_styles = $row['num_styles'];

$index = $FD->sql()->conn()->query ( '
                SELECT `style_tag`
                FROM `'.$FD->config('pref').'styles`
                WHERE `style_id` != 0
                AND `style_tag` != \'default\' 
                ORDER BY `style_id` DESC
                LIMIT 0,1');
$row = $index->fetch(PDO::FETCH_ASSOC);
$last_style = killhtml ( $row['style_tag'] );

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Informationen &amp; Statistik</td></tr>
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
