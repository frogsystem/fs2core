<?php

    $TEMPLATE_GO = 'tpl_screens';
    $TEMPLATE_FILE = '0_screenshots.tpl';
    $TEMPLATE_EDIT = null;

    $tmp['name'] = 'CATEGORY';
    $tmp['title'] = $admin_phrases['template']['screenshot_cat']['title'];
    $tmp['description'] = $admin_phrases['template']['screenshot_cat']['description'];
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'url';
        $tmp['help'][0]['text'] = $admin_phrases['template']['screenshot_cat']['help_1'];
        $tmp['help'][1]['tag'] = 'name';
        $tmp['help'][1]['text'] = $admin_phrases['template']['screenshot_cat']['help_2'];
        $tmp['help'][2]['tag'] = 'date';
        $tmp['help'][2]['text'] = $admin_phrases['template']['screenshot_cat']['help_3'];
        $tmp['help'][3]['tag'] = 'number';
        $tmp['help'][3]['text'] = $admin_phrases['template']['screenshot_cat']['help_4'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'CATEGORY_LIST_BODY';
    $tmp['title'] = $admin_phrases['template']['screenshot_body']['title'];
    $tmp['description'] = $admin_phrases['template']['screenshot_body']['description'];
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'cats';
        $tmp['help'][0]['text'] = $admin_phrases['template']['screenshot_body']['help_1'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'IMAGE';
    $tmp['title'] = $admin_phrases['template']['screenshot_pic']['title'];
    $tmp['description'] = $admin_phrases['template']['screenshot_pic']['description'];
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'img_url';
        $tmp['help'][0]['text'] = $admin_phrases['template']['screenshot_pic']['help_1'];
        $tmp['help'][1]['tag'] = 'viewer_link';
        $tmp['help'][1]['text'] = 'Link zum Bild, je nach Anzeigeart URL oder JS';
        $tmp['help'][2]['tag'] = 'thumb_url';
        $tmp['help'][2]['text'] = $admin_phrases['template']['screenshot_pic']['help_2'];
        $tmp['help'][3]['tag'] = 'caption';
        $tmp['help'][3]['text'] = $admin_phrases['template']['screenshot_pic']['help_3'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'BODY';
    $tmp['title'] = $admin_phrases['template']['screenshot_cat_body']['title'];
    $tmp['description'] = $admin_phrases['template']['screenshot_cat_body']['description'];
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'name';
        $tmp['help'][0]['text'] = $admin_phrases['template']['screenshot_cat_body']['help_1'];
        $tmp['help'][1]['tag'] = 'screenshots';
        $tmp['help'][1]['text'] = $admin_phrases['template']['screenshot_cat_body']['help_2'];
        $tmp['help'][2]['tag'] = 'page_nav';
        $tmp['help'][2]['text'] = $admin_phrases['template']['screenshot_cat_body']['help_3'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
