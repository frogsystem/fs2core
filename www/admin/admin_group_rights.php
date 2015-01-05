<?php if (!defined('ACP_GO')) die('Unauthorized access!');

///////////////////
//// functions ////
///////////////////

function get_group_rights_array ( $GROUP_ID )
{
    global $FD;

    unset ( $rights );

    $index = $FD->db()->conn()->query ( '
                    SELECT `perm_id`
                    FROM '.$FD->env('DB_PREFIX')."user_permissions
                    WHERE `x_id` = '".intval($GROUP_ID)."'
                    AND `perm_for_group` = '1'" );
    while ( $temp_arr = $index->fetch(PDO::FETCH_ASSOC) ) {
            $rights[] = $temp_arr['perm_id'];
    }
    if ( !isset ( $rights ) || !is_array ( $rights ) ) {
        $rights = array ();
    }

    return $rights;
}



////////////////////////////
//// save changes to db ////
////////////////////////////

if (isset($_POST['user_group_id']) && $_POST['user_group_id'] > 1) {

    // security functions
    settype ( $_POST['user_group_id'], 'integer' );
    unset ( $group_rights );

    // get group of current user
    $index = $FD->db()->conn()->query ( '
                    SELECT `user_group`
                    FROM `'.$FD->env('DB_PREFIX')."user`
                    WHERE `user_id` = '".$_SESSION['user_id']."'
                    LIMIT 0,1" );
    $current_user_group = $index->fetchColumn();

    // if user is not in group
    if ($_POST['user_group_id'] != $current_user_group) {

        // get already granted rights
        $group_rights = get_group_rights_array ($_POST['user_group_id']);

        // get pages
        $pageaction = $FD->db()->conn()->query ( '
                            SELECT `page_id`
                            FROM `'.$FD->env('DB_PREFIX')."admin_cp`
                            WHERE `group_id` > '0'" );
        while ($page_arr = $pageaction->fetch(PDO::FETCH_ASSOC)) {
            // permission is not longer granted
            if ( ( !isset($_POST[$page_arr['page_id']]) || ($_POST[$page_arr['page_id']] == 0) ) && in_array ( $page_arr['page_id'], $group_rights ) ) {
                $FD->db()->conn()->exec ( '
                                DELETE
                                FROM `'.$FD->env('DB_PREFIX')."user_permissions`
                                WHERE `perm_id` = '".$page_arr['page_id']."'
                                AND `x_id` = '".$_POST['user_group_id']."'
                                AND `perm_for_group` = '1'" );

            // permission is now granted
            } elseif ( isset($_POST[$page_arr['page_id']]) && $_POST[$page_arr['page_id']] == 1 && !in_array ( $page_arr['page_id'], $group_rights ) ) {
                $FD->db()->conn()->exec ( '
                                INSERT
                                INTO `'.$FD->env('DB_PREFIX')."user_permissions` (`perm_id`, `x_id`, `perm_for_group`)
                                VALUES ('".$page_arr['page_id']."', '".$_POST['user_group_id']."', 1)" );
            }
        }

        systext ( $FD->text('admin', 'changes_saved'), $FD->text('admin', 'info') );
    }
    else {
        systext ( $FD->text('page', 'group_edit_not_allowed'), $FD->text('admin', 'error'), TRUE );
    }

    // Unset Vars
    unset ( $_POST );
}



//////////////////////////
//// edit permissions ////
//////////////////////////

if ( isset($_POST['edit_user_group_id']) && $_POST['edit_user_group_id'] > 1)
{
    // security functions
    unset ($group_rights);
    settype ($_POST['edit_user_group_id'], 'integer');

    // get group data
    $index = $FD->db()->conn()->query ( '
                    SELECT `user_group_name`, `user_group_id`
                    FROM `'.$FD->env('DB_PREFIX').'user_groups` G, `'.$FD->env('DB_PREFIX')."user` U
                    WHERE G.`user_group_id` = '".$_POST['edit_user_group_id']."'
                    AND U.`user_id` = '".$_SESSION['user_id']."'
                    AND G.`user_group_id` != U.`user_group`
                    LIMIT 0,1" );
    $user_group_arr = $index->fetch(PDO::FETCH_ASSOC);

    // get granted rights
    $group_rights = get_group_rights_array($user_group_arr['user_group_id']);

    // get group of current user
    $index = $FD->db()->conn()->query ( '
                    SELECT `user_group`
                    FROM `'.$FD->env('DB_PREFIX')."user`
                    WHERE `user_id` = '".$_SESSION['user_id']."'
                    LIMIT 0,1" );
    $current_user_group = $index->fetchColumn();

    // security functions
    unset ( $DATA_ARR );
    $entries = 0;

    // get groups
    $groupaction = $FD->db()->conn()->query ( '
                        SELECT `group_id`
                        FROM `'.$FD->env('DB_PREFIX')."admin_groups`
                        WHERE `menu_id` != 'none'
                        ORDER BY `menu_id`, `group_pos`" );
    while ( $group_arr = $groupaction->fetch(PDO::FETCH_ASSOC) ) {
        $DATA_ARR[$group_arr['group_id']]['title'] = $FD->text('menu', 'group_'.$group_arr['group_id']);

        // get pages
        $pageaction = $FD->db()->conn()->query ( '
                            SELECT COUNT(`page_id`)
                            FROM `'.$FD->env('DB_PREFIX')."admin_cp`
                            WHERE `group_id` = '".$group_arr['group_id']."' AND `page_int_sub_perm` = 0" );
        $pa_num_rows = $pageaction->fetchColumn();
        $pageaction = $FD->db()->conn()->query ( '
                            SELECT `page_id`
                            FROM `'.$FD->env('DB_PREFIX')."admin_cp`
                            WHERE `group_id` = '".$group_arr['group_id']."' AND `page_int_sub_perm` = 0
                            ORDER BY `page_pos` ASC, `page_id` ASC" );
        $pageaction_sub = $FD->db()->conn()->query ( '
                            SELECT COUNT(`page_id`)
                            FROM `'.$FD->env('DB_PREFIX')."admin_cp`
                            WHERE `group_id` = '".$group_arr['group_id']."' AND `page_int_sub_perm` = 1" );
        $pas_num_rows = $pageaction_sub->fetchColumn();
        $pageaction_sub = $FD->db()->conn()->query ( '
                            SELECT `page_id`, `page_file`
                            FROM `'.$FD->env('DB_PREFIX')."admin_cp`
                            WHERE `group_id` = '".$group_arr['group_id']."' AND `page_int_sub_perm` = 1
                            ORDER BY `page_file` ASC, `page_pos` ASC, `page_id` ASC" );
        // count number of entries
        $entries = $entries + $pa_num_rows + $pas_num_rows;

        while ( $page_arr_sub = $pageaction_sub->fetch(PDO::FETCH_ASSOC) ) {
            $SUB_ARR[$page_arr_sub['page_file']][$page_arr_sub['page_id']] = $FD->text('menu', 'page_link_'.$page_arr_sub['page_id']);
        }


        while ( $page_arr = $pageaction->fetch(PDO::FETCH_ASSOC) ) {
            $DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['page_link'] = $FD->text('menu', 'page_link_'.$page_arr['page_id']);

            // is permission granted?
            if ( $user_group_arr['user_group_id'] == $current_user_group ) {
                $DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = 'bad';
            } elseif ( in_array ( $page_arr['page_id'], $group_rights ) ) {
                $DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = 'group';
            } else {
                $DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = false;
            }

            if ( isset ( $SUB_ARR[$page_arr['page_id']] ) ) {
                foreach ( $SUB_ARR[$page_arr['page_id']] as $sub_id => $sub_link ) {
                    $DATA_ARR[$group_arr['group_id']]['links'][$sub_id]['page_link'] = $sub_link;
                    $DATA_ARR[$group_arr['group_id']]['links'][$sub_id]['sub'] = TRUE;

                    // is permission granted?
                    if ( $user_group_arr['user_group_id'] == $current_user_group ) {
                        $DATA_ARR[$group_arr['group_id']]['links'][$sub_id]['granted'] = 'bad';
                    } elseif ( in_array ( $page_arr['page_id'], $group_rights ) ) {
                        $DATA_ARR[$group_arr['group_id']]['links'][$sub_id]['granted'] = 'group';
                    } else {
                        $DATA_ARR[$group_arr['group_id']]['links'][$sub_id]['granted'] = false;
                    }
                }
            }

        }
    }

    // start display
    echo'
                    <form action="" method="post">
                        <input type="hidden" name="go" value="group_rights">
                        <input type="hidden" name="user_group_id" value="'.$user_group_arr['user_group_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="3">'.$FD->text('page', 'change_grouprights_for').': '.$user_group_arr['user_group_name'].'</td></tr>
                            <tr><td align="left">
                                <span class="small"><b>'.$FD->text('admin', 'note').':</b><br>
                                '.$FD->text('page', 'sub_rights_note').'</span>
                                <table cellpadding="4" cellspacing="0" align="center">
                                    <tr><td class="config"><p></p>
    ';

    // get data for col-divisor
    $per_col = ceil ( $entries/3 ) + 2; // +2 makes it more flexible
    $i = 0;
    $j = 1;

    // display data from data array
    foreach ( $DATA_ARR as $GROUP_ARR ) {
        if ( is_array ( $GROUP_ARR['links'] ) ) {
            if ( $per_col < $i + count ( $GROUP_ARR['links'] ) && $j < 3 ) {
                echo '</td><td width="30" class="config"></td><td class="config"><p></p>';
                $i = 1;
                $j++;
            }
            echo '<p>'.$GROUP_ARR['title'].' <span class="small">(<span class="link" onclick="permselect($(this), true)">'.$FD->text('page', 'all').'</span>/<span class="link" onclick="permselect($(this), false)">'.$FD->text('page', 'none').'</span>)</span><br>';
            foreach ( $GROUP_ARR['links'] as $PAGE_ID => $PAGE_ARR ) {
                echo ( isset($PAGE_ARR['sub']) && ($PAGE_ARR['sub'] == TRUE) ) ? '<img style="vertical-align: middle;" src="?icons=sub-right-arrow.gif" alt="->">' : '';
                echo '<input class="pointer" type="checkbox" style="vertical-align: middle;" id="'.$PAGE_ID.'" name="'.$PAGE_ID.'" value="1"
                '.getchecked ( $PAGE_ARR['granted'], 'group' ).'
                '.getdisabled ( $PAGE_ARR['granted'], 'bad' ).'
                ><label class="small pointer" for="'.$PAGE_ID.'">'.$PAGE_ARR['page_link'].'</label><br>';
                 $i++;
            }
            echo '</p>';
        }
    }

    echo'
                                    </td></tr>
                                </table>
                            </td></tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="3" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'save_changes_button').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}



//////////////////////
//// select group ////
//////////////////////

else
{
    // start display
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="group_rights">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="4">'.$FD->text('page', 'select_group').'</td></tr>
    ';

    // get groups from db
    $index = $FD->db()->conn()->query ( '
                    SELECT COUNT(`user_group_id`)
                    FROM `'.$FD->env('DB_PREFIX').'user_groups` G, `'.$FD->env('DB_PREFIX')."user` U
                    WHERE U.`user_id` = '".$_SESSION['user_id']."'
                    AND G.`user_group_id` != U.`user_group`
                    AND G.`user_group_id` > 1" );

    // groups found
    if ( $index->fetchColumn() > 0 ) {
        // display table head
        echo '
                            <tr>
                                <td class="config">'.$FD->text('page', 'group_name_and_symbol').'</td>
                                <td class="config">'.$FD->text('page', 'group_info').'</td>
                                <td class="config" width="20">'.$FD->text('page', 'group_members').'</td>
                                <td class="config" width="20"></td>
                            </tr>
                            <tr><td class="space"></td></tr>
        ';

        // display groups
        $index = $FD->db()->conn()->query ( '
                        SELECT `user_group_id`, `user_group_name`, `user_group_user`, `user_group_date`
                        FROM `'.$FD->env('DB_PREFIX').'user_groups` G, `'.$FD->env('DB_PREFIX')."user` U
                        WHERE U.`user_id` = '".$_SESSION['user_id']."'
                        AND G.`user_group_id` != U.`user_group`
                        AND G.`user_group_id` > 1
                        ORDER BY `user_group_name`" );
        while ( $group_arr = $index->fetch(PDO::FETCH_ASSOC) )
        {
            $index_username = $FD->db()->conn()->query ( '
                                    SELECT `user_name`
                                    FROM `'.$FD->env('DB_PREFIX')."user`
                                    WHERE `user_id` = '".$group_arr['user_group_user']."'" );
            $group_arr['user_group_user_name'] = $index_username->fetchColumn();

            $index_numusers = $FD->db()->conn()->query ( "
                                    SELECT COUNT(`user_id`) AS 'num_users'
                                    FROM `".$FD->env('DB_PREFIX')."user`
                                    WHERE `user_group` = '".$group_arr['user_group_id']."'" );
            $group_arr['user_group_num_users'] = $index_numusers->fetchColumn();

            // Display each Group
            echo '
                            <tr class="pointer" id="tr_'.$group_arr['user_group_id'].'"
                                onmouseover="'.color_list_entry ( 'input_'.$group_arr['user_group_id'], '#EEEEEE', '#64DC6A', 'this' ).'"
                                onmouseout="'.color_list_entry ( 'input_'.$group_arr['user_group_id'], 'transparent', '#49c24f', 'this' ).'"
                                onclick="'.color_click_entry ( 'input_'.$group_arr['user_group_id'], '#EEEEEE', '#64DC6A', 'this', TRUE ).'"
                            >
            ';
            echo '
                                <td class="configthin middle">
                                    <b>'.$group_arr['user_group_name'].'</b>
            ';
            if ( image_exists ( 'images/groups/', 'staff_'.$group_arr['user_group_id'] ) ) {
                echo '<br><img src="'.image_url ( 'images/groups/', 'staff_'.$group_arr['user_group_id'] ).'" alt="'.$group_arr['user_group_name'].'" border="0">';
            }
            echo '
                                </td>
                                <td class="configthin middle">
                                    <span class="small">
                                        '.$FD->text('page', 'list_cat_created_by').' <b>'.$group_arr['user_group_user_name'].'</b> '.$FD->text('page', 'list_cat_created_on').' <b>'.date ( $FD->config('date'), $group_arr['user_group_date'] ).'</b>
                                    </span>
                                </td>
                                <td class="configthin center middle">'.$group_arr['user_group_num_users'].'</td>
                                <td class="configthin middle" style="text-align: center; vertical-align: middle;">
                                    <input class="pointer" type="radio" name="edit_user_group_id" id="input_'.$group_arr['user_group_id'].'" value="'.$group_arr['user_group_id'].'"
                                        onclick="'.color_click_entry ( 'this', '#EEEEEE', '#64DC6A', 'tr_'.$group_arr['user_group_id'], TRUE ).'"
                                    >
                                </td>
                            </tr>
            ';
        }

        // End of Form & Table incl. Submit-Button
         echo '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="4">
                                    <button class="button_new" type="submit">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('page', 'change_grouprights').'
                                    </button>
                                </td>
                            </tr>
        ';

    // no users found
    } else {
        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config center" colspan="4">'.$FD->text('page', 'no_groups_found').'</td>
                            </tr>
                            <tr><td class="space"></td></tr>
        ';
    }

    echo '
                        </table>
                    </form>
    ';
}
?>
