<?php

function get_player ( $MULTI, $WIDTH = true, $HEIGHT = true, $MODIFIER = false ) {

    global $FD;
    $FD->loadConfig('video_player');

    $template_own = '
    <object type="application/x-shockwave-flash" data="'.$FD->config('virtualhost').'assets/player_flv_maxi.swf" width="{..width..}" height="{..height..}">
        <param name="movie" value="'.$FD->config('virtualhost').'assets/player_flv_maxi.swf"></param>
        <param name="allowFullScreen" value="true"></param>
        <param name="FlashVars" value="'.get_player_flashvars(array(
            'flv' => "{..url..}",
            'title' => "{..title..}"
        )).'"></param>

    </object>
    ';
    //~ <param name="FlashVars" value="config='.$FD->config('virtualhost').'resources/player/player_flv_config.php&amp;flv={..url..}&amp;title={..title..}&amp;width={..width..}&amp;height={..height..}"></param>


    $template_youtube = '
    <iframe width="{..width..}" height="{..height..}" src="//www.youtube.com/embed/{..url..}" frameborder="0" allowfullscreen></iframe>
    ';

    $template_myvideo = "
    <object style='width:{..width_css..};height:{..height_css..};' type='application/x-shockwave-flash' data='http://www.myvideo.de/movie/{..url..}'>
        <param name='movie' value='http://www.myvideo.de/movie/{..url..}'></param>
        <param name='AllowFullscreen' value='true'></param>
    </object>
    ";


    // default width/height
    if ($WIDTH === true || $HEIGHT === true) {
        $WIDTH = $WIDTH ? $FD->cfg('video_player', 'cfg_player_x') : $WIDTH;
        $HEIGHT = $HEIGHT ? $FD->cfg('video_player', 'cfg_player_y') : $HEIGHT;
    }

    $display = FALSE;

    if ( is_numeric ( $MULTI ) ) {
        settype ( $MULTI, 'integer' );
        $index = $FD->db()->conn()->query ( '
                        SELECT COUNT(*) AS num_rows
                        FROM '.$FD->env('DB_PREFIX')."player
                        WHERE video_id = '".$MULTI."'
                        LIMIT 0,1" );
        $num_rows = $index->fetchColumn();
        if ( $num_rows == 1 ) {
            $index = $FD->db()->conn()->query ( '
                        SELECT *
                        FROM '.$FD->env('DB_PREFIX')."player
                        WHERE video_id = '".$MULTI."'
                        LIMIT 0,1" );
            $video_arr = $index->fetch( PDO::FETCH_ASSOC );

            switch ( $video_arr['video_type'] ) {
                case -1:
                    $template_player = $video_arr['video_x'];
                    break;
                case 3:
                    $template_player = $template_myvideo;
                    break;
                case 2:
                    parse_str('v='.$video_arr['video_x'], $data);
                    $video_arr['video_x'] = array_shift($data);
                    $video_arr['video_x'] .= '?'.http_build_query($data);
                    $template_player = $template_youtube;
                    break;
                case 1:
                    $template_player = $template_own;
                    break;
                default:
                    $video_arr['video_type'] = 0;
                    $template_player = '';
                    break;
            }

            // DL?


        } else {
            $video_arr['video_type'] = 0;
        }
    } else {
        $input = explode ( '|', $MULTI, 2 );
        $video_arr['video_x'] = $input[0];
        $video_arr['video_title'] = $input[1];
        $template_player = $template_own;
        $video_arr['video_type'] = 1;
        $video_arr['dl_id'] = 0;
    }

    $video_arr['video_x'] = killhtml ( $video_arr['video_x'] );
    $video_arr['video_title'] = killhtml ( $video_arr['video_title'] );

    // return text output?
    if ($MODIFIER == 'text') {
        return get_video_text($video_arr['video_x'], $video_arr['video_title'], $video_arr['video_type'], $video_arr['dl_id']);
    } else if ($MODIFIER == 'bbcode') {
        return get_video_bbcode($video_arr['video_x'], $video_arr['video_title'], $video_arr['video_type'], $video_arr['dl_id']);
    }

    // get dimensions
    if ( substr ( $WIDTH, -1 ) == '%' ) {
        $WIDTH = substr ( $WIDTH, 0, -1 );
        settype ( $WIDTH, 'integer' );
        $WIDTH = substr ( $WIDTH, 0, -1 ) . '%';
        $WIDTH_CSS = substr ( $WIDTH, 0, -1 ) . '%';
    } else {
        settype ( $WIDTH, 'integer' );
        $WIDTH_CSS = $WIDTH . 'px';
    }

    if ( substr ( $HEIGHT, -1 ) == '%' ) {
        $HEIGHT = substr ( $HEIGHT, 0, -1 );
        settype ( $HEIGHT, 'integer' );
        $HEIGHT = substr ( $HEIGHT, 0, -1 ) . '%';
        $HEIGHT_CSS = substr ( $HEIGHT, 0, -1 ) . '%';
    } else {
        settype ( $HEIGHT, 'integer' );
        $HEIGHT_CSS = $HEIGHT . 'px';
    }


    if ( $video_arr['video_type'] != 0 ) {
        $template_player = str_replace ( '{..width..}', $WIDTH, $template_player );
        $template_player = str_replace ( '{..height..}', $HEIGHT, $template_player );
        $template_player = str_replace ( '{..width_css..}', $WIDTH_CSS, $template_player );
        $template_player = str_replace ( '{..height_css..}', $HEIGHT_CSS, $template_player );

        if ( $video_arr['video_type'] == 1 || $video_arr['video_type'] == 2 || $video_arr['video_type'] == 3 ) {
            $template_player = str_replace ( '{..url..}', $video_arr['video_x'], $template_player );
        }
        if ( $video_arr['video_type'] == 1 ) {
            $template_player = str_replace ( '{..title..}', $video_arr['video_title'], $template_player );

            // Get Player Template
            $template = new template();
            $template->setFile('0_player.tpl');
            $template->load('PLAYER');
            $template->tag('player', $template_player );
            $template = $template->display ();
            $template_player = $template;
        }
    } else {
        $template_player = '';
    }

    return $template_player;
}

function get_video_url($url, $type, $dl_id = 0) {
    // Existing Download?
    if ($type <= 1 && $dl_id != 0) {
        $type = 1;
        $url = url('dlfile', array('id' => $dl_id), true);
    }

    // $URL ermitteln
    switch ($type) {
        case 3: // MyVideo
            $url = 'http://www.myvideo.de/watch/'.$url.'/';
            break;
        case 2: // YouTube
            $url = 'http://www.youtube.com/watch?v='.$url;
            break;
        case 1:
            $url = $url;
            break;
        default:
            return null;
    }

    return $url;
}
function get_video_text($url, $title, $type, $dl_id = 0) {
    global $FD;

    // get url
    $url = get_video_url($url, $type, $dl_id);
    if (empty($url)) {
        return '';
    }

    // Return Text
    if (!empty($title)) {
        return $FD->text('frontend', 'video').': '.$title.' ('.$url.')';
    } else {
        return $FD->text('frontend', 'video').': '.$url;
    }
}
function get_video_bbcode($url, $title, $type, $dl_id = 0) {
    global $FD;

    // get url
    $url = get_video_url($url, $type, $dl_id);
    if (empty($url)) {
        return '';
    }

    // Return Text
    if (!empty($title)) {
        $content = $FD->text('frontend', 'video').': '.$title;
    } else {
        $content = $FD->text('frontend', 'video').': '.$url;
    }
    return '[url='.$url.']'.$content.'[/url]';
}


function get_player_flashvars(array $config = array()) {
    $allowed_options = array(
        'autoplay',
        'autoload',
        'buffer',
        'buffermessage',
        'buffercolor',
        'bufferbgcolor',
        'buffershowbg',
        'titlesize',
        'titlecolor',
        'margin',
        'showstop',
        'showvolume',
        'showtime',
        'showplayer',
        'showloading',
        'showfullscreen',
        'showmouse',
        'loop',
        'playercolor',
        'loadingcolor',
        'bgcolor',
        'bgcolor1',
        'bgcolor2',
        'buttoncolor',
        'buttonovercolor',
        'slidercolor1',
        'slidercolor2',
        'sliderovercolor',
        'loadonstop',
        'onclick',
        'ondoubleclick',
        'playertimeout',
        'videobgcolor',
        'volume',
        'shortcut',
        'playeralpha',
        'top1',
        'showiconplay',
        'iconplaycolor',
        'iconplaybgcolor',
        'iconplaybgalpha',
        'showtitleandstartimage',
    );

    global $FD;

    $FD->loadConfig('video_player');
    $config_arr = $FD->configObject('video_player')->getConfigArray();


    if ( strlen ( $config_arr['cfg_top1_url'] ) > 0 ) {
        $config_arr['cfg_top1'] = $config_arr['cfg_top1_url'].'|'.$config_arr['cfg_top1_x'].'|'.$config_arr['cfg_top1_y'];
    } else {
        $config_arr['cfg_top1'] = '';
    }

    // kill color hashes
    $config_arr = array_map(create_function('$ele', '
        if (is_hexcolor($ele))
            $ele = substr($ele, 1);
        return $ele;
    '),  $config_arr);
    
    // merge config array
    $the_conf = array();
    foreach ($config_arr as $conf => $value) {
        $conf = substr($conf, 4);
        if (in_array($conf, $allowed_options)) {
            $the_conf[$conf] = $value;
        }
    }
    $the_conf = array_merge($the_conf, $config);
    
    // create output array
    $the_output = array();
    foreach ($the_conf as $conf => $value) {
        $the_output[] = $conf.'='.$value;
    }
    return implode('&amp;', $the_output);

}
?>
