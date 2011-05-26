<?php
///////////////////
//// functions ////
///////////////////

function get_group_rights_array ( $GROUP_ID )
{
    global $global_config_arr;
    global $db;

    unset ( $rights );

    $index = mysql_query ( "
                            SELECT `perm_id`
                            FROM ".$global_config_arr['pref']."user_permissions
                            WHERE `x_id` = '".$GROUP_ID."'
                            AND`perm_for_group` = '1'
    ", $db);
    while ( $temp_arr = mysql_fetch_assoc ( $index ) ) {
            $rights[] = $temp_arr['perm_id'];
    }
    if ( !is_array ( $rights ) ) {
        $rights = array ();
    }

    return $rights;
}



////////////////////////////
//// save changes to db ////
////////////////////////////

if ( isset( $_POST['user_group_id'] ) ) {

    // security functions
    settype ( $_POST['user_group_id'], 'integer' );
     unset ( $group_rights );

    // get group of current user
    $index = mysql_query ( "
                            SELECT `user_group`
                            FROM `".$global_config_arr['pref']."user`
                            WHERE `user_id` = '".$_SESSION['user_id']."'
                            LIMIT 0,1
    ", $db);
    $current_user_group = mysql_result ( $index, 0, "user_group" );

    // if user is not in group
    if ( $_POST['user_group_id'] != $current_user_group ) {

        // get already granted rights
        $group_rights = get_group_rights_array ( $_POST['user_group_id'] );

        // get pages
        $pageaction = mysql_query ( "
                                        SELECT `page_id`
                                        FROM `".$global_config_arr['pref']."admin_cp`
                                        WHERE `group_id` > '0'
        ", $db );
        while ( $page_arr = mysql_fetch_assoc ( $pageaction ) ) {
            // permission is not longer granted
            if ( $_POST[$page_arr['page_id']] == 0 && in_array ( $page_arr['page_id'], $group_rights ) ) {
                mysql_query ( "
                                DELETE
                                FROM `".$global_config_arr['pref']."user_permissions`
                                WHERE `perm_id` = '".$page_arr['page_id']."'
                                AND `x_id` = '".$_POST['user_group_id']."'
                                AND `perm_for_group` = '1'
                ", $db );
                
            // permission is now granted
            } elseif ( $_POST[$page_arr['page_id']] == 1 && !in_array ( $page_arr['page_id'], $group_rights ) ) {
                mysql_query ( "
                                INSERT
                                INTO `".$global_config_arr['pref']."user_permissions` (`perm_id`, `x_id`, `perm_for_group`)
                                VALUES ('".$page_arr['page_id']."', '".$_POST['user_group_id']."', 1)
                ", $db );
            }
        }

        systext ( $admin_phrases[common][changes_saved], $admin_phrases[common][info] );
    }
    else {
        systext ( "Diese Gruppe kann nicht bearbeitet werden", $admin_phrases[common][error], TRUE );
    }
    
    // Unset Vars
    unset ( $_POST );
}


  
//////////////////////////
//// edit permissions ////
//////////////////////////

if ( isset ( $_POST['edit_user_group_id'] ) )
{
    // security functions
    unset ( $group_rights );
    settype ( $_POST['edit_user_group_id'], "integer" );
    
    // get group data
    $index = mysql_query ( "
                            SELECT `user_group_name`, `user_group_id`
                            FROM `".$global_config_arr['pref']."user_groups` G, `".$global_config_arr['pref']."user` U
                            WHERE G.`user_group_id` = '".$_POST['edit_user_group_id']."'
                            AND U.`user_id` = '".$_SESSION['user_id']."'
                            AND G.`user_group_id` != U.`user_group`
                            LIMIT 0,1
    ", $db);
    $user_group_arr = mysql_fetch_assoc ( $index );

    // get granted rights
    $group_rights = get_group_rights_array ( $user_group_arr['user_group_id'] );
    
    // get group of current user
    $index = mysql_query ( "
                            SELECT `user_group`
                            FROM `".$global_config_arr['pref']."user`
                            WHERE `user_id` = '".$_SESSION['user_id']."'
                            LIMIT 0,1
    ", $db);
    $current_user_group = mysql_result ( $index, 0, "user_group" );

    // security functions
    unset ( $DATA_ARR );
    $entries = 0;
    
    // get groups
    $groupaction = mysql_query ( "
                                    SELECT `group_id`
                                    FROM `".$global_config_arr['pref']."admin_groups`
                                    WHERE `menu_id` != 'none'
                                    ORDER BY `menu_id`, `group_pos`
    ", $db );
    while ( $group_arr = mysql_fetch_assoc ( $groupaction ) ) {
        $DATA_ARR[$group_arr['group_id']]['title'] = $TEXT['menu']->get("group_".$group_arr['group_id']);
        
        // get pages
        $pageaction = mysql_query ( "
                                        SELECT `page_id`
                                        FROM `".$global_config_arr['pref']."admin_cp`
                                        WHERE `group_id` = '".$group_arr['group_id']."' AND `page_int_sub_perm` = 0
                                        ORDER BY `page_pos` ASC, `page_id` ASC
        ", $db );
        $pageaction_sub = mysql_query ( "
                                        SELECT `page_id`, `page_file`
                                        FROM `".$global_config_arr['pref']."admin_cp`
                                        WHERE `group_id` = '".$group_arr['group_id']."' AND `page_int_sub_perm` = 1
                                        ORDER BY `page_file` ASC, `page_pos` ASC, `page_id` ASC
        ", $db );
        // count number of entries
        $entries = $entries + mysql_num_rows ( $pageaction ) + mysql_num_rows ( $pageaction_sub );
        
        
        while ( $page_arr_sub = mysql_fetch_assoc ( $pageaction_sub ) ) {
            $SUB_ARR[$page_arr_sub['page_file']][$page_arr_sub['page_id']] = $TEXT['menu']->get("page_link_".$page_arr_sub['page_id']);
        }
        
        
        while ( $page_arr = mysql_fetch_assoc ( $pageaction ) ) {
            $DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['page_link'] = $TEXT['menu']->get("page_link_".$page_arr['page_id']);

            // is permission granted?
            if ( $user_group_arr['user_group_id'] == $current_user_group ) {
                $DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = "bad";
            } elseif ( in_array ( $page_arr['page_id'], $group_rights ) ) {
                $DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = "group";
            } else {
                $DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = false;
            }
            
            if ( isset ( $SUB_ARR[$page_arr['page_id']] ) ) {
                foreach ( $SUB_ARR[$page_arr['page_id']] as $sub_id => $sub_link ) {
                    $DATA_ARR[$group_arr['group_id']]['links'][$sub_id]['page_link'] = $sub_link;
                    $DATA_ARR[$group_arr['group_id']]['links'][$sub_id]['sub'] = TRUE;

                    // is permission granted?
                    if ( $user_group_arr['user_group_id'] == $current_user_group ) {
                        $DATA_ARR[$group_arr['group_id']]['links'][$sub_id]['granted'] = "bad";
                    } elseif ( in_array ( $page_arr['page_id'], $group_rights ) ) {
                        $DATA_ARR[$group_arr['group_id']]['links'][$sub_id]['granted'] = "group";
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
                            <tr><td class="line" colspan="3">Gruppenrechte ändern für: '.$user_group_arr['user_group_name'].'</td></tr>
                            <tr><td align="left">
                                <span class="small"><b>Hinweise:</b><br>
                                Unter-Rechte werden nur wirksam, wenn auch das zugehörige Haupt-Recht erteilt wurde.</span>
                                <table cellpadding="4" cellspacing="0" align="center">
                                    <tr><td class="config">
    ';

    // get data for col-divisor
    $per_col = ceil ( $entries/3 ) + 2; // +2 makes it more flexible
    $i = 0;
    $j = 1;
    
    // display data from data array
    foreach ( $DATA_ARR as $GROUP_ARR ) {
        if ( is_array ( $GROUP_ARR['links'] ) ) {
            if ( $per_col < $i + count ( $GROUP_ARR['links'] ) && $j < 3 ) {
                echo '</td><td width="30" class="config"></td><td class="config">';
                $i = 1;
                $j++;
            }
            echo '<br>'.$GROUP_ARR['title'].'<br>';
            foreach ( $GROUP_ARR['links'] as $PAGE_ID => $PAGE_ARR ) {
                echo ( $PAGE_ARR['sub'] == TRUE ) ? '<img style="vertical-align: middle;" src="icons/sub-right-arrow.gif" alt="->">' : "";
                echo '<input class="pointer" type="checkbox" style="vertical-align: middle;" id="'.$PAGE_ID.'" name="'.$PAGE_ID.'" value="1"
                '.getchecked ( $PAGE_ARR['granted'], "group" ).'
                '.getdisabled ( $PAGE_ARR['granted'], "bad" ).'
                ><label class="small pointer" for="'.$PAGE_ID.'">'.$PAGE_ARR['page_link'].'</label><br>';
                 $i++;
            }
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
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
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
                            <tr><td class="line" colspan="4">Gruppe auswählen</td></tr>
    ';
    
    // get groups from db
    $index = mysql_query ( "
                            SELECT `user_group_id`, `user_group_name`, `user_group_user`, `user_group_date`
                            FROM `".$global_config_arr['pref']."user_groups` G, `".$global_config_arr['pref']."user` U
                            WHERE U.`user_id` = '".$_SESSION['user_id']."'
                            AND G.`user_group_id` != U.`user_group`
                            ORDER BY `user_group_name`
    ", $db );
    
    // groups found
    if ( mysql_num_rows ( $index ) > 0 ) {
        // display table head
        echo '
                            <tr>
                                <td class="config">Gruppenname & Grafik</td>
                                <td class="config">Informationen</td>
                                <td class="config" width="20">Mitglieder</td>
                                <td class="config" width="20"></td>
                            </tr>
                            <tr><td class="space"></td></tr>
        ';
        
        // display groups
        while ( $group_arr = mysql_fetch_assoc ( $index ) )
        {
            $index_username = mysql_query ( "
                                                SELECT `user_name`
                                                FROM `".$global_config_arr['pref']."user`
                                                WHERE `user_id` = '".$group_arr['user_group_user']."'
            ", $db );
            $group_arr['user_group_user_name'] = mysql_result ( $index_username, 0, "user_name" );

            $index_numusers = mysql_query ( "
                                                SELECT COUNT(`user_id`) AS 'num_users'
                                                FROM `".$global_config_arr['pref']."user`
                                                WHERE `user_group` = '".$group_arr['user_group_id']."'
            ", $db );
            $group_arr['user_group_num_users'] = mysql_result ( $index_numusers, 0, "num_users" );

            // Display each Group
            echo '
                            <tr class="pointer" id="tr_'.$group_arr['user_group_id'].'"
                                onmouseover="'.color_list_entry ( "input_".$group_arr['user_group_id'], "#EEEEEE", "#64DC6A", "this" ).'"
                                onmouseout="'.color_list_entry ( "input_".$group_arr['user_group_id'], "transparent", "#49c24f", "this" ).'"
                                onclick="'.color_click_entry ( "input_".$group_arr['user_group_id'], "#EEEEEE", "#64DC6A", "this", TRUE ).'"
                            >
            ';
            echo '
                                <td class="configthin middle">
                                    <b>'.$group_arr['user_group_name'].'</b>
            ';
            if ( image_exists ( "images/groups/", "staff_".$group_arr['user_group_id'] ) ) {
                echo '<br><img src="'.image_url ( "images/groups/", "staff_".$group_arr['user_group_id'] ).'" alt="'.$group_arr['user_group_name'].'" border="0">';
            }
            echo '
                                </td>
                                <td class="configthin middle">
                                    <span class="small">
                                        '.$admin_phrases[articles][list_cat_created_by].' <b>'.$group_arr['user_group_user_name'].'</b> '.$admin_phrases[articles][list_cat_created_on].' <b>'.date ( $global_config_arr['date'], $group_arr['user_group_date'] ).'</b>
                                    </span>
                                </td>
                                <td class="configthin center middle">'.$group_arr['user_group_num_users'].'</td>
                                <td class="configthin middle" style="text-align: center; vertical-align: middle;">
                                    <input class="pointer" type="radio" name="edit_user_group_id" id="input_'.$group_arr['user_group_id'].'" value="'.$group_arr['user_group_id'].'"
                                        onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$group_arr['user_group_id'], TRUE ).'"
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
                                        '.$admin_phrases[common][arrow].' '."Gruppenrrechte ändern".'
                                    </button>
                                </td>
                            </tr>
        ';
        
    // no users found
    } else {
        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config center" colspan="4">Keine Gruppen gefunden!</td>
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
