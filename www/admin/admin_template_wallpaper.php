<?php
    $TEMPLATE_GO = 'tpl_wp';
    $TEMPLATE_FILE = '0_wallpapers.tpl';
    $TEMPLATE_EDIT = null;

    $tmp['name'] = 'WALLPAPER';
    $tmp['title'] = $admin_phrases['template']['wallpaper_pic']['title'];
    $tmp['description'] = $admin_phrases['template']['wallpaper_pic']['description'];
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'thumb_url';
        $tmp['help'][0]['text'] = $admin_phrases['template']['wallpaper_pic']['help_1'];
        $tmp['help'][1]['tag'] = 'caption';
        $tmp['help'][1]['text'] = $admin_phrases['template']['wallpaper_pic']['help_2'];
        $tmp['help'][2]['tag'] = 'sizes';
        $tmp['help'][2]['text'] = $admin_phrases['template']['wallpaper_pic']['help_3'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'SIZE';
    $tmp['title'] = $admin_phrases['template']['wallpaper_sizes']['title'];
    $tmp['description'] = $admin_phrases['template']['wallpaper_sizes']['description'];
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'url';
        $tmp['help'][0]['text'] = $admin_phrases['template']['wallpaper_sizes']['help_1'];
        $tmp['help'][1]['tag'] = 'size';
        $tmp['help'][1]['text'] = $admin_phrases['template']['wallpaper_sizes']['help_2'];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
