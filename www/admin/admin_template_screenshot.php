<?php if (!defined('ACP_GO')) die('Unauthorized access!');

    $TEMPLATE_GO = 'tpl_screens';
    $TEMPLATE_FILE = '0_screenshots.tpl';
    $TEMPLATE_EDIT = null;

    $tmp['name'] = 'CATEGORY';
    $tmp['title'] = $FD->text("template", "screenshot_cat_title");
    $tmp['description'] = $FD->text("template", "screenshot_cat_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'url';
        $tmp['help'][0]['text'] = $FD->text("template", "screenshot_cat_help_1");
        $tmp['help'][1]['tag'] = 'name';
        $tmp['help'][1]['text'] = $FD->text("template", "screenshot_cat_help_2");
        $tmp['help'][2]['tag'] = 'date';
        $tmp['help'][2]['text'] = $FD->text("template", "screenshot_cat_help_3");
        $tmp['help'][3]['tag'] = 'number';
        $tmp['help'][3]['text'] = $FD->text("template", "screenshot_cat_help_4");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'CATEGORY_LIST_BODY';
    $tmp['title'] = $FD->text("template", "screenshot_body_title");
    $tmp['description'] = $FD->text("template", "screenshot_body_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'cats';
        $tmp['help'][0]['text'] = $FD->text("template", "screenshot_body_help_1");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'IMAGE';
    $tmp['title'] = $FD->text("template", "screenshot_pic_title");
    $tmp['description'] = $FD->text("template", "screenshot_pic_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'img_url';
        $tmp['help'][0]['text'] = $FD->text("template", "screenshot_pic_help_1");
        $tmp['help'][1]['tag'] = 'viewer_link';
        $tmp['help'][1]['text'] = 'Link zum Bild, je nach Anzeigeart URL oder JS';
        $tmp['help'][2]['tag'] = 'thumb_url';
        $tmp['help'][2]['text'] = $FD->text("template", "screenshot_pic_help_2");
        $tmp['help'][3]['tag'] = 'caption';
        $tmp['help'][3]['text'] = $FD->text("template", "screenshot_pic_help_3");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'BODY';
    $tmp['title'] = $FD->text("template", "screenshot_cat_body_title");
    $tmp['description'] = $FD->text("template", "screenshot_cat_body_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'name';
        $tmp['help'][0]['text'] = $FD->text("template", "screenshot_cat_body_help_1");
        $tmp['help'][1]['tag'] = 'screenshots';
        $tmp['help'][1]['text'] = $FD->text("template", "screenshot_cat_body_help_2");
        $tmp['help'][2]['tag'] = 'page_nav';
        $tmp['help'][2]['text'] = $FD->text("template", "screenshot_cat_body_help_3");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
