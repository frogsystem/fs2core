<?php if (!defined('ACP_GO')) die('Unauthorized access!');

    $TEMPLATE_GO = 'tpl_press';
    $TEMPLATE_FILE = '0_press.tpl';
    $TEMPLATE_EDIT = null;

    $tmp['name'] = 'NAVIGATION_LINE';
    $tmp['title'] = $FD->text("template", "press_navi_line_title");
    $tmp['description'] = $FD->text("template", "press_navi_line_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'navi_url';
        $tmp['help'][0]['text'] = $FD->text("template", "press_navi_line_help_1");
        $tmp['help'][1]['tag'] = 'title';
        $tmp['help'][1]['text'] = $FD->text("template", "press_navi_line_help_2");
        $tmp['help'][2]['tag'] = 'img_url';
        $tmp['help'][2]['text'] = $FD->text("template", "press_navi_line_help_3");
        $tmp['help'][3]['tag'] = 'icon_url';
        $tmp['help'][3]['text'] = $FD->text("template", "press_navi_line_help_4");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'NAVIGATION';
    $tmp['title'] = $FD->text("template", "press_navi_main_title");
    $tmp['description'] = $FD->text("template", "press_navi_main_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'lines';
        $tmp['help'][0]['text'] = $FD->text("template", "press_navi_main_help_1");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'ENTRY_INTRO';
    $tmp['title'] = $FD->text("template", "press_intro_title");
    $tmp['description'] = $FD->text("template", "press_intro_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'intro_text';
        $tmp['help'][0]['text'] = $FD->text("template", "press_intro_help_1");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'ENTRY_NOTE';
    $tmp['title'] = $FD->text("template", "press_note_title");
    $tmp['description'] = $FD->text("template", "press_note_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'note_text';
        $tmp['help'][0]['text'] = $FD->text("template", "press_note_help_1");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'ENTRY_BODY';
    $tmp['title'] = $FD->text("template", "press_body_title");
    $tmp['description'] = $FD->text("template", "press_body_description");
    $tmp['rows'] = '20';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'title';
        $tmp['help'][0]['text'] = $FD->text("template", "press_body_help_1");
        $tmp['help'][1]['tag'] = 'url';
        $tmp['help'][1]['text'] = $FD->text("template", "press_body_help_2");
        $tmp['help'][2]['tag'] = 'date';
        $tmp['help'][2]['text'] = $FD->text("template", "press_body_help_3");
        $tmp['help'][3]['tag'] = 'intro';
        $tmp['help'][3]['text'] = $FD->text("template", "press_body_help_4");
        $tmp['help'][4]['tag'] = 'text';
        $tmp['help'][4]['text'] = $FD->text("template", "press_body_help_5");
        $tmp['help'][5]['tag'] = 'note';
        $tmp['help'][5]['text'] = $FD->text("template", "press_body_help_6");
        $tmp['help'][6]['tag'] = 'game_title';
        $tmp['help'][6]['text'] = $FD->text("template", "press_body_help_7");
        $tmp['help'][7]['tag'] = 'game_img_url';
        $tmp['help'][7]['text'] = $FD->text("template", "press_body_help_8");
        $tmp['help'][8]['tag'] = 'cat_title';
        $tmp['help'][8]['text'] = $FD->text("template", "press_body_help_9");
        $tmp['help'][9]['tag'] = 'cat_img_url';
        $tmp['help'][9]['text'] = $FD->text("template", "press_body_help_10");
        $tmp['help'][10]['tag'] = 'lang_title';
        $tmp['help'][10]['text'] = $FD->text("template", "press_body_help_11");
        $tmp['help'][11]['tag'] = 'lang_img_url';
        $tmp['help'][11]['text'] = $FD->text("template", "press_body_help_12");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'ENTRY_CONTAINER';
    $tmp['title'] = $FD->text("template", "press_container_title");
    $tmp['description'] = $FD->text("template", "press_container_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'press_releases';
        $tmp['help'][0]['text'] = $FD->text("template", "press_container_help_1");

    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp['name'] = 'BODY';
    $tmp['title'] = $FD->text("template", "press_main_body_title");
    $tmp['description'] = $FD->text("template", "press_main_body_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'navigation';
        $tmp['help'][0]['text'] = $FD->text("template", "press_main_body_help_1");
        $tmp['help'][1]['tag'] = 'press_container';
        $tmp['help'][1]['text'] = $FD->text("template", "press_main_body_help_2");

    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
