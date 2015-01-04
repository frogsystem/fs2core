<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('catid', 'page'));

/////////////////////////////
//// Kategorie existiert  ///
/////////////////////////////
if (isset($_GET['catid']))
{
    settype($_GET['catid'], 'integer');
    $index = $FD->sql()->conn()->query('SELECT cat_name, cat_visibility FROM '.$FD->config('pref')."screen_cat WHERE cat_id = $_GET[catid]" );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        unset($_GET['catid']);
    } elseif ($row['cat_visibility']==0) {
        unset($_GET['catid']);
    }
}

////////////////////////////
//// Kategorie anzeigen ////
////////////////////////////

if (isset($_GET['catid']))
{
    settype($_GET['catid'], 'integer');

    //config_arr
    $FD->loadConfig('screens');
    $config_arr = $FD->configObject('screens')->getConfigArray();

    //cat_arr
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."screen_cat WHERE cat_id = $_GET[catid]" );
    $cat_arr = $index->fetch(PDO::FETCH_ASSOC);

    //WP/Screen unterscheidene Abfragen
    if ($cat_arr['cat_type']==2) {
        $index = $FD->sql()->conn()->query('SELECT COUNT(wallpaper_id) AS number FROM '.$FD->config('pref')."wallpaper WHERE cat_id = $_GET[catid]");
        $config_arr['rows'] = $config_arr['wp_rows'];
        $config_arr['cols'] = $config_arr['wp_cols'];
    } else {
        $index = $FD->sql()->conn()->query('SELECT COUNT(screen_id) AS number FROM '.$FD->config('pref')."screen WHERE cat_id = $_GET[catid]");
        $config_arr['rows'] = $config_arr['screen_rows'];
        $config_arr['cols'] = $config_arr['screen_cols'];
    }

    $config_arr['number_of_screens'] = $index->fetchColumn();
    if ($config_arr['rows']==-1) {
        $config_arr['pics_per_page'] = $config_arr['number_of_screens'];
    } else {
        $config_arr['pics_per_page'] = $config_arr['rows']*$config_arr['cols'];
    }
    $config_arr['number_of_pages'] = ceil($config_arr['number_of_screens']/$config_arr['pics_per_page']);

    if (!isset($_GET['page']))
    {$_GET['page']=1;}
    if ($_GET['page']<1)
    {$_GET['page']=1;}
    if ($_GET['page']>$config_arr['number_of_pages'])
    {$_GET['page']=$config_arr['number_of_pages'];}

    $config_arr['oldpage'] = $_GET['page']-1;
    $config_arr['newpage'] = $_GET['page']+1;
    $config_arr['page_start'] = ($_GET['page']-1)*$config_arr['pics_per_page'];

    // Screenshots lesen
    if ($config_arr['number_of_screens']>0)
    {
        //Wallpaper Kategorie
        if ($cat_arr['cat_type']==2)
        {
            $zaehler = 0;
            $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper WHERE cat_id = $cat_arr[cat_id] ORDER BY wallpaper_id $config_arr[wp_sort] LIMIT $config_arr[page_start],$config_arr[pics_per_page]");
            while ($wp_arr = $index->fetch(PDO::FETCH_ASSOC))
            {
                $wp_arr['thumb_url'] = image_url('images/wallpaper/', $wp_arr['wallpaper_name'].'_s');

                $index2 = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = $wp_arr[wallpaper_id] ORDER BY size_id ASC");
                $sizes = '';
                while ($sizes_arr = $index2->fetch(PDO::FETCH_ASSOC))
                {
                    $sizes_arr['url'] = image_url('images/wallpaper/', $wp_arr['wallpaper_name'].'_'.$sizes_arr['size']);

                    // Get Template
                    $template = new template();
                    $template->setFile('0_wallpapers.tpl');
                    $template->load('SIZE');

                    $template->tag('url',  $sizes_arr['url'] );
                    $template->tag('size', $sizes_arr['size'] );

                    $template = $template->display ();
                    $sizes .= $template;
                }

                // Get Template
                $template = new template();
                $template->setFile('0_wallpapers.tpl');
                $template->load('WALLPAPER');

                $template->tag('thumb_url', $wp_arr['thumb_url'] );
                $template->tag('caption', $wp_arr['wallpaper_title'] );
                $template->tag('sizes', $sizes );

                $template = $template->display ();

                $zaehler += 1;
                switch ($zaehler)
                {
                    case $config_arr['cols'] == 1:
                        $zaehler = 0;
                        $pics .= "<tr>\n\r";
                        $pics .= $template;
                        $pics .= "</tr>\n\r";
                        break;
                    case $config_arr['cols']:
                        $zaehler = 0;
                        $pics .= $template;
                        $pics .= "</tr>\n\r";
                        break;
                    case 1:
                        $pics .= "<tr>\n\r";
                        $pics .= $template;
                        break;
                    default:
                        $pics .= $template;
                        break;
                } // Switch ende
            } // While Ende
        }
        //Screenshot Kategorie
        else
        {
            $zaehler = 0;
            $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."screen WHERE cat_id = $cat_arr[cat_id] ORDER by screen_id $config_arr[screen_sort] LIMIT $config_arr[page_start],$config_arr[pics_per_page]");

            $pics = '';
            while ($screen_arr = $index->fetch(PDO::FETCH_ASSOC))
            {
                $screen_arr['screen_thumb'] = image_url('images/screenshots/', $screen_arr['screen_id'].'_s');
                $screen_arr['screen_url'] = image_url('images/screenshots/', $screen_arr['screen_id'] );
                $screen_arr['img_link'] = url('viewer', array('id' => $screen_arr['screen_id']));
                if ( $config_arr['show_type'] == 1 ) {
                    $screen_arr['img_link'] = "javascript:popUp('".$screen_arr['img_link']."','popupviewer','".$config_arr['show_size_x']."','".$config_arr['show_size_y']."');";
                }

                // Get Template
                $template = new template();
                $template->setFile('0_screenshots.tpl');
                $template->load('IMAGE');

                $template->tag('img_url', $screen_arr['screen_url'] );
                $template->tag('viewer_link', $screen_arr['img_link'] );
                $template->tag('thumb_url', $screen_arr['screen_thumb'] );
                $template->tag('caption', $screen_arr['screen_name'] );

                $template = $template->display ();

                $zaehler += 1;
                switch ($zaehler)
                {
                    case $config_arr['cols'] == 1:
                        $zaehler = 0;
                        $pics .= "<tr>\n\r";
                        $pics .= $template;
                        $pics .= "</tr>\n\r";
                        break;
                    case $config_arr['cols']:
                        $zaehler = 0;
                        $pics .= $template;
                        $pics .= "</tr>\n\r";
                        break;
                    case 1:
                        $pics .= "<tr>\n\r";
                        $pics .= $template;
                        break;
                    default:
                        $pics .= $template;
                        break;
                } // Switch ende
            } // While Ende
        } // WP/Screen Ende
    } // Bilder > 0 Ende
    unset($sizes_arr);
    unset($wp_arr);
    unset($screen_arr);


    //Seitennavigation
    $pagenav = get_page_nav ( $_GET['page'], $config_arr['number_of_pages'], $config_arr['pics_per_page'], $config_arr['number_of_screens'], url($_GET['go'], array('catid' => $_GET['catid'], 'page' => '{..page_num..}')));

    //Keine Screenshots
    if ($config_arr['number_of_screens'] <= 0) {
        $pics = sys_message($FD->text('frontend', 'sysmessage'), $FD->text('frontend', 'no_pics'), 404);
        $pagenav = '';
    }

    //Ausgabe der Seite
    $template = new template();
    $template->setFile('0_screenshots.tpl');
    $template->load('BODY');

    $template->tag('name', $cat_arr['cat_name'] );
    $template->tag('screenshots', $pics );
    $template->tag('page_nav', $pagenav );

    $template = $template->display ();
}

////////////////////////////
//// Kategorien listen /////
////////////////////////////

else {
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_visibility = 1 ORDER BY cat_date DESC');
    $cats = '';
    while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        if ($cat_arr['cat_type']==2) {
            $index2 = $FD->sql()->conn()->query('SELECT COUNT(wallpaper_id) AS number FROM '.$FD->config('pref')."wallpaper WHERE cat_id = $cat_arr[cat_id]");
        } else {
            $index2 = $FD->sql()->conn()->query('SELECT COUNT(screen_id) AS number FROM '.$FD->config('pref')."screen WHERE cat_id = $cat_arr[cat_id]" );
        }
        $cat_arr['cat_menge'] = $index2->fetchColumn();
        $cat_arr['cat_date'] = date_loc( $FD->config('date'), $cat_arr['cat_date'] );

        // Get Template
        $template = new template();
        $template->setFile('0_screenshots.tpl');
        $template->load('CATEGORY');

        $template->tag('url', url($_GET['go'], array('catid' => $cat_arr['cat_id'])));
        $template->tag('name', $cat_arr['cat_name'] );
        $template->tag('date', $cat_arr['cat_date'] );
        $template->tag('number', $cat_arr['cat_menge'] );

        $template = $template->display ();
        $cats .= $template;
    }

    // Get Template
    $template = new template();
    $template->setFile('0_screenshots.tpl');
    $template->load('CATEGORY_LIST_BODY');
    $template->tag('cats', $cats );
    $template = $template->display ();
}
?>
