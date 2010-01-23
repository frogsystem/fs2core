<?php
$index = mysql_query ( "
                        SELECT `user`
                        FROM ".$global_config_arr['pref']."counter
                        LIMIT 0,1
", $db);
$num_user = mysql_result ( $index, 0, "user" );

$index = mysql_query ( "
                        SELECT `user_name`
                        FROM ".$global_config_arr['pref']."user
                        ORDER BY `user_reg_date` DESC
                        LIMIT 0,1
", $db);
$last_user = stripslashes ( mysql_result ( $index, 0, "user_name" ) );

$index = mysql_query ( "
                        SELECT COUNT(`user_id`) AS 'num_staff'
                        FROM ".$global_config_arr['pref']."user
                        WHERE `user_is_staff` = '1'
                        AND `user_is_admin` = '0'
                        AND `user_id` != '1'
", $db);
$num_staff = mysql_result ( $index, 0, "num_staff" );

$index = mysql_query ( "
                        SELECT COUNT(`user_group_id`) AS 'num_groups'
                        FROM ".$global_config_arr['pref']."user_groups
                        WHERE `user_group_id` > '0'
", $db);
$num_groups = mysql_result ( $index, 0, "num_groups" );

if ( $num_groups  > 0 ) {
    $index = mysql_query ( "
                            SELECT G.`user_group_name`, COUNT(U.`user_id`) AS 'biggest_num'
                            FROM ".$global_config_arr['pref']."user_groups G, ".$global_config_arr['pref']."user U
                            WHERE U.`user_group` = G.`user_group_id`
                            AND U.`user_group` > '0'
                            AND U.`user_is_staff` = '1'
                            AND U.`user_is_admin` = '0'
                            AND U.`user_id` != '1'
                            GROUP BY `user_group_name`
                            ORDER BY `biggest_num` DESC
                            LIMIT 0,1
    ", $db);
    $temp_biggest_exists = mysql_num_rows ( $index );
}
if ( $temp_biggest_exists  > 0 ) {
    $biggest_group = stripslashes ( mysql_result ( $index, 0, "user_group_name" ) );
    $biggest_num = mysql_result ( $index, 0, "biggest_num" );
}

$index = mysql_query ( "
                        SELECT `user_group_name`
                        FROM ".$global_config_arr['pref']."user_groups
                        ORDER BY `user_group_date` DESC
                        LIMIT 0,1
", $db);
$last_group = stripslashes ( mysql_result ( $index, 0, "user_group_name" ) );

$index = mysql_query ( "
                        SELECT COUNT(`user_id`) AS 'num_admin'
                        FROM ".$global_config_arr['pref']."user
                        WHERE `user_is_admin` = '1'
                        OR `user_id` = '1'
", $db);
$num_admin = mysql_result ( $index, 0, "num_admin" );
$num_staff += $num_admin;

$index = mysql_query ( "
                        SELECT `user_name`
                        FROM ".$global_config_arr['pref']."user
                        WHERE `user_id` = '1'
                        LIMIT 0,1
", $db);
$super_admin = stripslashes ( mysql_result ( $index, 0, "user_name" ) );
        
echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Informationen & Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Registrierte Benutzer:</td>
                                <td class="configthin"><b>'.$num_user .'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Neuester Benutzer:</td>
                                <td class="configthin"><b>'.$last_user .'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Anzahl Mitarbeiter:</td>
                                <td class="configthin"><b>'.$num_staff .'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">Anzahl Gruppen:</td>
                                <td class="configthin"><b>'.$num_groups .'</b></td>
                            </tr>
';

if ( $num_groups  > 0 && $temp_biggest_exists  > 0 ) {
    echo '
                            <tr>
                                <td class="configthin">Größte Gruppe:</td>
                                <td class="configthin"><b>'.$biggest_group .'</b> mit <b>'.$biggest_num.'</b> Mitarbeiter(n)</td>
                            </tr>
    ';
}

echo '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">Anzahl Administratoren:</td>
                                <td class="configthin"><b>'.$num_admin .'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Super-Administrator:</td>
                                <td class="configthin"><b>'.$super_admin .'</b></td>
                            </tr>
                        </table>
';
?>