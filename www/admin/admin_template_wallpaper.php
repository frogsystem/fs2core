<?php
    $TEMPLATE_GO = 'tpl_wp';
    $TEMPLATE_FILE = '0_wallpapers.tpl';
    $TEMPLATE_EDIT = null;

    $tmp['name'] = 'WALLPAPER';
    $tmp['title'] = $FD->text("template", "wallpaper_pic_title");
    $tmp['description'] = $FD->text("template", "wallpaper_pic_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'thumb_url';
        $tmp['help'][0]['text'] = $FD->text("template", "wallpaper_pic_help_1");
        $tmp['help'][1]['tag'] = 'caption';
        $tmp['help'][1]['text'] = $FD->text("template", "wallpaper_pic_help_2");
        $tmp['help'][2]['tag'] = 'sizes';
        $tmp['help'][2]['text'] = $FD->text("template", "wallpaper_pic_help_3");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'SIZE';
    $tmp['title'] = $FD->text("template", "wallpaper_sizes_title");
    $tmp['description'] = $FD->text("template", "wallpaper_sizes_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'url';
        $tmp['help'][0]['text'] = $FD->text("template", "wallpaper_sizes_help_1");
        $tmp['help'][1]['tag'] = 'size';
        $tmp['help'][1]['text'] = $FD->text("template", "wallpaper_sizes_help_2");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
