<?php
///////////////////////////
//// Show Announcement ////
///////////////////////////
$index = mysql_query ( '
                        SELECT *
                        FROM `'.$FD->config('pref')."announcement`
                        WHERE `id` = '1'
", $FD->sql()->conn() );
$ann_arr = mysql_fetch_assoc ( $index );

if ( $ann_arr['show_announcement'] != 0 && $ann_arr['activate_announcement'] == 1 ) {

    if ( $ann_arr['show_announcement'] == 2 && $FD->config('goto') != $FD->config('home_real') ) {
        $template = '';
    } else {
        $ann_arr['announcement_text'] = fscode ( $ann_arr['announcement_text'], $ann_arr['ann_fscode'], $ann_arr['ann_html'], $ann_arr['ann_para'] );
        // Body Template
        $template = new template();
        $template->setFile('0_general.tpl');
        $template->load('ANNOUNCEMENT');
        $template->tag('announcement_text', $ann_arr['announcement_text'] );
        $template = $template->display ();
    }
} else {
    $template = '';
}
?>
