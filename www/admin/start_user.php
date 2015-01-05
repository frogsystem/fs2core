<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$index = $FD->db()->conn()->query ( '
                SELECT `user`
                FROM '.$FD->env('DB_PREFIX').'counter
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_user = $row['user'];

$index = $FD->db()->conn()->query ( '
                SELECT `user_name`
                FROM '.$FD->env('DB_PREFIX').'user
                ORDER BY `user_reg_date` DESC
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$last_user = $row['user_name'];

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`user_id`) AS 'num_staff'
                FROM ".$FD->env('DB_PREFIX').'user
                WHERE `user_is_staff` = 1
                AND `user_is_admin` = 0
                AND `user_id` != 1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_staff = $row['num_staff'];

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`user_group_id`) AS 'num_groups'
                FROM ".$FD->env('DB_PREFIX').'user_groups
                WHERE `user_group_id` > 1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_groups = $row['num_groups'];
$num_groups++;

$temp_biggest_exists = false;
if ( $num_groups  > 0 ) {
    $index = $FD->db()->conn()->query ( "
                    SELECT G.`user_group_name`, COUNT(U.`user_id`) AS 'biggest_num'
                    FROM ".$FD->env('DB_PREFIX').'user_groups G, '.$FD->env('DB_PREFIX')."user U
                    WHERE U.`user_group` = G.`user_group_id`
                    AND U.`user_group` > '1'
                    AND U.`user_is_staff` = '1'
                    AND U.`user_is_admin` = '0'
                    AND U.`user_id` != '1'
                    GROUP BY `user_group_name`
                    ORDER BY `biggest_num` DESC
                    LIMIT 0,1" );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $temp_biggest_exists = ( $row !== false );
}
if ( $temp_biggest_exists ) {
    $biggest_group = $row['user_group_name'];
    $biggest_num = $row['biggest_num'];
}

$index = $FD->db()->conn()->query ( '
                SELECT `user_group_name`
                FROM '.$FD->env('DB_PREFIX').'user_groups
                ORDER BY `user_group_date` DESC
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$last_group = $row['user_group_name'];

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`user_id`) AS 'num_admin'
                FROM ".$FD->env('DB_PREFIX').'user
                WHERE `user_is_admin` = 1
                OR `user_id` = 1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_admin = $row['num_admin'];
$num_staff += $num_admin;

$index = $FD->db()->conn()->query ( '
                SELECT `user_name`
                FROM '.$FD->env('DB_PREFIX').'user
                WHERE `user_id` = 1
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$super_admin = $row['user_name'];

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text('admin', 'informations_and_statistics').'</td></tr>
                            <tr>
                                <td class="configthin" width="200">'.$FD->text('page', 'registered_users').':</td>
                                <td class="configthin"><b>'.$num_user .'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">'.$FD->text('page', 'newest_user').':</td>
                                <td class="configthin"><b>'.$last_user .'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">'.$FD->text('page', 'number_of_staff_members').':</td>
                                <td class="configthin"><b>'.$num_staff .'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">'.$FD->text('page', 'number_of_groups').':</td>
                                <td class="configthin"><b>'.$num_groups .'</b></td>
                            </tr>
';

if ( $num_groups  > 0 && $temp_biggest_exists ) {
    echo '
                            <tr>
                                <td class="configthin">'.$FD->text('page', 'biggest_group').':</td>
                                <td class="configthin"><b>'.$biggest_group .'</b> '.$FD->text('admin', 'with').' <b>'.$biggest_num.'</b> '.$FD->text('page', 'staff_member_s').'</td>
                            </tr>
    ';
}

echo '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">'.$FD->text('page', 'number_of_admins').':</td>
                                <td class="configthin"><b>'.$num_admin .'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">'.$FD->text('page', 'name_of_superadmin').':</td>
                                <td class="configthin"><b>'.$super_admin .'</b></td>
                            </tr>
                        </table>
';
?>
