<?php
    $TEMPLATE_GO = 'tpl_affiliates';
    $TEMPLATE_FILE = '0_affiliates.tpl';
    $TEMPLATE_EDIT = null;

    $tmp['name'] = 'APPLET_ENTRY';
    $tmp['title'] = $admin_phrases['template']['partner_navi_eintrag']['title'];
    $tmp['description'] = $admin_phrases['template']['partner_navi_eintrag']['description'];
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'url';
        $tmp['help'][0]['text'] = $admin_phrases['template']['partner_eintrag']['help_1'];
        $tmp['help'][1]['tag'] = 'img_url';
        $tmp['help'][1]['text'] = $admin_phrases['template']['partner_eintrag']['help_2'];
        $tmp['help'][2]['tag'] = 'button_url';
        $tmp['help'][2]['text'] = $admin_phrases['template']['partner_eintrag']['help_3'];
        $tmp['help'][3]['tag'] = 'name';
        $tmp['help'][3]['text'] = $admin_phrases['template']['partner_eintrag']['help_4'];
        $tmp['help'][4]['tag'] = 'text';
        $tmp['help'][4]['text'] = $admin_phrases['template']['partner_eintrag']['help_5'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'APPLET_BODY';
    $tmp['title'] = $admin_phrases['template']['partner_navi_body']['title'];
    $tmp['description'] = $admin_phrases['template']['partner_navi_body']['description'];
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'all_affiliates';
        $tmp['help'][0]['text'] = $admin_phrases['template']['partner_main_body']['help_1'];
        $tmp['help'][1]['tag'] = 'permanents';
        $tmp['help'][1]['text'] = $admin_phrases['template']['partner_main_body']['help_2'];
        $tmp['help'][2]['tag'] = 'non_permanents';
        $tmp['help'][2]['text'] = $admin_phrases['template']['partner_main_body']['help_3'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'ENTRY';
    $tmp['title'] = $admin_phrases['template']['partner_eintrag']['title'];
    $tmp['description'] = $admin_phrases['template']['partner_eintrag']['description'];
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'url';
        $tmp['help'][0]['text'] = $admin_phrases['template']['partner_eintrag']['help_1'];
        $tmp['help'][1]['tag'] = 'img_url';
        $tmp['help'][1]['text'] = $admin_phrases['template']['partner_eintrag']['help_2'];
        $tmp['help'][2]['tag'] = 'button_url';
        $tmp['help'][2]['text'] = $admin_phrases['template']['partner_eintrag']['help_3'];
        $tmp['help'][3]['tag'] = 'name';
        $tmp['help'][3]['text'] = $admin_phrases['template']['partner_eintrag']['help_4'];
        $tmp['help'][4]['tag'] = 'text';
        $tmp['help'][4]['text'] = $admin_phrases['template']['partner_eintrag']['help_5'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'BODY';
    $tmp['title'] = $admin_phrases['template']['partner_main_body']['title'];
    $tmp['description'] = $admin_phrases['template']['partner_main_body']['description'];
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'all_affiliates';
        $tmp['help'][0]['text'] = $admin_phrases['template']['partner_main_body']['help_1'];
        $tmp['help'][1]['tag'] = 'permanents';
        $tmp['help'][1]['text'] = $admin_phrases['template']['partner_main_body']['help_2'];
        $tmp['help'][2]['tag'] = 'non_permanents';
        $tmp['help'][2]['text'] = $admin_phrases['template']['partner_main_body']['help_3'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
