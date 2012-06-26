<?php
    $TEMPLATE_GO = 'tpl_affiliates';
    $TEMPLATE_FILE = '0_affiliates.tpl';
    $TEMPLATE_EDIT = null;

    $tmp['name'] = 'APPLET_ENTRY';
    $tmp['title'] = $FD->text("template", "partner_navi_eintrag_title");
    $tmp['description'] = $FD->text("template", "partner_navi_eintrag_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'url';
        $tmp['help'][0]['text'] = $FD->text("template", "partner_eintrag_help_1");
        $tmp['help'][1]['tag'] = 'img_url';
        $tmp['help'][1]['text'] = $FD->text("template", "partner_eintrag_help_2");
        $tmp['help'][2]['tag'] = 'button_url';
        $tmp['help'][2]['text'] = $FD->text("template", "partner_eintrag_help_3");
        $tmp['help'][3]['tag'] = 'name';
        $tmp['help'][3]['text'] = $FD->text("template", "partner_eintrag_help_4");
        $tmp['help'][4]['tag'] = 'text';
        $tmp['help'][4]['text'] = $FD->text("template", "partner_eintrag_help_5");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'APPLET_BODY';
    $tmp['title'] = $FD->text("template", "partner_navi_body_title");
    $tmp['description'] = $FD->text("template", "partner_navi_body_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'all_affiliates';
        $tmp['help'][0]['text'] = $FD->text("template", "partner_main_body_help_1");
        $tmp['help'][1]['tag'] = 'permanents';
        $tmp['help'][1]['text'] = $FD->text("template", "partner_main_body_help_2");
        $tmp['help'][2]['tag'] = 'non_permanents';
        $tmp['help'][2]['text'] = $FD->text("template", "partner_main_body_help_3");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'ENTRY';
    $tmp['title'] = $FD->text("template", "partner_eintrag_title");
    $tmp['description'] = $FD->text("template", "partner_eintrag_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'url';
        $tmp['help'][0]['text'] = $FD->text("template", "partner_eintrag_help_1");
        $tmp['help'][1]['tag'] = 'img_url';
        $tmp['help'][1]['text'] = $FD->text("template", "partner_eintrag_help_2");
        $tmp['help'][2]['tag'] = 'button_url';
        $tmp['help'][2]['text'] = $FD->text("template", "partner_eintrag_help_3");
        $tmp['help'][3]['tag'] = 'name';
        $tmp['help'][3]['text'] = $FD->text("template", "partner_eintrag_help_4");
        $tmp['help'][4]['tag'] = 'text';
        $tmp['help'][4]['text'] = $FD->text("template", "partner_eintrag_help_5");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'BODY';
    $tmp['title'] = $FD->text("template", "partner_main_body_title");
    $tmp['description'] = $FD->text("template", "partner_main_body_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'all_affiliates';
        $tmp['help'][0]['text'] = $FD->text("template", "partner_main_body_help_1");
        $tmp['help'][1]['tag'] = 'permanents';
        $tmp['help'][1]['text'] = $FD->text("template", "partner_main_body_help_2");
        $tmp['help'][2]['tag'] = 'non_permanents';
        $tmp['help'][2]['text'] = $FD->text("template", "partner_main_body_help_3");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
