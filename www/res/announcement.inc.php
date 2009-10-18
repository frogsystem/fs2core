<?php
///////////////////////////
//// Show Announcement ////
///////////////////////////
$index = mysql_query ( "
                        SELECT *
                        FROM `".$global_config_arr['pref']."announcement`
                        WHERE `id` = '1'
", $db );
$ann_arr = mysql_fetch_assoc ( $index );

if ( $ann_arr['show_announcement'] != 0 && $ann_arr['activate_announcement'] == 1 ) {
    $ann_arr['announcement_text'] = fscode ( $ann_arr['announcement_text'], $ann_arr['ann_fscode'], $ann_arr['ann_html'], $ann_arr['ann_para'] );
    $template = get_template ( "announcement" );
    $template = str_replace ( "{announcement_text}", $ann_arr['announcement_text'], $template );
}

if ( !( $ann_arr['show_announcement'] == 1 || ( $ann_arr['show_announcement'] == 2 && $global_config_arr['goto'] == $global_config_arr['home_real'] ) ) ) {
    unset ( $template );
}
?>