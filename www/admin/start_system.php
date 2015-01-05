<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`alias_id`) AS 'num_aliases'
                FROM `".$FD->env('DB_PREFIX').'aliases`' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_aliases = $row['num_aliases'];
$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`alias_id`) AS 'num_aliases_active'
                FROM `".$FD->env('DB_PREFIX').'aliases`
                WHERE `alias_active` = 1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_aliases_active = $row['num_aliases_active'];

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`applet_id`) AS 'num_applets'
                FROM `".$FD->env('DB_PREFIX').'applets`' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_applets = $row['num_applets'];
$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`applet_id`) AS 'num_applets_active'
                FROM `".$FD->env('DB_PREFIX').'applets`
                WHERE `applet_active` = 1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_applets_active = $row['num_applets_active'];


$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`snippet_id`) AS 'num_snippets'
                FROM `".$FD->env('DB_PREFIX').'snippets`' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_snippets = $row['num_snippets'];
$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`snippet_id`) AS 'num_snippets_active'
                FROM `".$FD->env('DB_PREFIX').'snippets`
                WHERE `snippet_active` = 1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_snippets_active = $row['num_snippets_active'];


echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text("admin", "informations_and_statistics").'</td></tr>
                            <tr>
                                <td class="configthin" width="200">'.$FD->text("page", "num_aliases").':</td>
                                <td class="configthin"><b>'.$num_aliases.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">'.$FD->text("page", "num_aliases_active").':</td>
                                <td class="configthin"><b>'.$num_aliases_active.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">'.$FD->text("page", "num_applets").':</td>
                                <td class="configthin"><b>'.$num_applets.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">'.$FD->text("page", "num_applets_active").':</td>
                                <td class="configthin"><b>'.$num_applets_active.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">'.$FD->text("page", "num_snippets").':</td>
                                <td class="configthin"><b>'.$num_snippets.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">'.$FD->text("page", "num_snippets_active").':</td>
                                <td class="configthin"><b>'.$num_snippets_active.'</b></td>
                            </tr>
                        </table>
';
?>
