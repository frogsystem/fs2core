<?php

function get_player ( $MULTI, $WIDTH = true, $HEIGHT = true ) {

    global $global_config_arr, $db, $sql;

    $template_own = '
    <object type="application/x-shockwave-flash" data="'.$global_config_arr['virtualhost'].'resources/player/player_flv_maxi.swf" width="{..width..}" height="{..height..}">
        <param name="movie" value="'.$global_config_arr['virtualhost'].'resources/player/player_flv_maxi.swf"></param>
        <param name="allowFullScreen" value="true"></param>
        <param name="FlashVars" value="config='.$global_config_arr['virtualhost'].'resources/player/player_flv_config.php&amp;flv={..url..}&amp;title={..title..}&amp;width={..width..}&amp;height={..height..}"></param>
    </object>
    ';
    
    $template_youtube = '
    <object width="{..width..}" height="{..height..}">
        <param name="movie" value="http://www.youtube.com/v/{..url..}&hl=en&fs=1&rel=0"></param>
        <param name="allowFullScreen" value="true"></param>
        <embed src="http://www.youtube.com/v/{..url..}&hl=en&fs=1&rel=0" type="application/x-shockwave-flash" allowfullscreen="true" width="{..width..}" height="{..height..}"></embed>
    </object>
    ';

    $template_myvideo = "
    <object style='width:{..width_css..};height:{..height_css..};' type='application/x-shockwave-flash' data='http://www.myvideo.de/movie/{..url..}'>
        <param name='movie' value='http://www.myvideo.de/movie/{..url..}'></param>
        <param name='AllowFullscreen' value='true'></param>
    </object>
    ";


    // default width/height
    if ($WIDTH === true || $HEIGHT === true) {
        $config_arr = $sql->getById("player_config", array("cfg_player_x", "cfg_player_y"), 1);
        $WIDTH = $WIDTH ? $config_arr['cfg_player_x'] : $WIDTH;
        $HEIGHT = $HEIGHT ? $config_arr['cfg_player_y'] : $HEIGHT;
    }

    $display = FALSE;
    
    if ( is_numeric ( $MULTI ) ) {
        settype ( $MULTI, "integer" );
        $index = mysql_query ( "
                                SELECT *
                                FROM ".$global_config_arr['pref']."player
                                WHERE video_id = '".$MULTI."'
                                LIMIT 0,1
        ", $db );
        if ( mysql_num_rows ( $index ) == 1 ) {
            $video_arr = mysql_fetch_assoc ( $index );

            switch ( $video_arr['video_type'] ) {
                case -1:
                    $template_player = stripslashes ( $video_arr['video_x'] );
                    break;
                case 3:
                    $template_player = $template_myvideo;
                    break;
                case 2:
                    $template_player = $template_youtube;
                    break;
                case 1:
                    $template_player = $template_own;
                    break;
                default:
                    $video_arr['video_type'] = 0;
                    $template_player = "";
                    break;
            }
        } else {
            $video_arr['video_type'] = 0;
        }
    } else {
        $input = explode ( "|", $MULTI, 2 );
        $video_arr['video_x'] = $input[0];
        $video_arr['video_title'] = $input[1];
        $template_player = $template_own;
        $video_arr['video_type'] = 1;
    }

    $video_arr['video_x'] = htmlspecialchars ( $video_arr['video_x'] );
    $video_arr['video_title'] = htmlspecialchars ( $video_arr['video_title'] );

    // get dimensions
    if ( substr ( $WIDTH, -1 ) == "%" ) {
        $WIDTH = substr ( $WIDTH, 0, -1 );
        settype ( $WIDTH, "integer" );
        $WIDTH = substr ( $WIDTH, 0, -1 ) . "%";
        $WIDTH_CSS = substr ( $WIDTH, 0, -1 ) . "%";
    } else {
        settype ( $WIDTH, "integer" );
        $WIDTH_CSS = $WIDTH . "px";
    }
    
    if ( substr ( $HEIGHT, -1 ) == "%" ) {
        $HEIGHT = substr ( $HEIGHT, 0, -1 );
        settype ( $HEIGHT, "integer" );
        $HEIGHT = substr ( $HEIGHT, 0, -1 ) . "%";
        $HEIGHT_CSS = substr ( $HEIGHT, 0, -1 ) . "%";
    } else {
        settype ( $HEIGHT, "integer" );
        $HEIGHT_CSS = $HEIGHT . "px";
    }


    if ( $video_arr['video_type'] != 0 ) {
        $template_player = str_replace ( "{..width..}", $WIDTH, $template_player );
        $template_player = str_replace ( "{..height..}", $HEIGHT, $template_player );
        $template_player = str_replace ( "{..width_css..}", $WIDTH_CSS, $template_player );
        $template_player = str_replace ( "{..height_css..}", $HEIGHT_CSS, $template_player );

        if ( $video_arr['video_type'] == 1 || $video_arr['video_type'] == 2 || $video_arr['video_type'] == 3 ) {
            $template_player = str_replace ( "{..url..}", $video_arr['video_x'], $template_player );
        }
        if ( $video_arr['video_type'] == 1 ) {
            $template_player = str_replace ( "{..title..}", $video_arr['video_title'], $template_player );

            // Get Player Template
            $template = new template();
            $template->setFile("0_player.tpl");
            $template->load("PLAYER");
            $template->tag("player", $template_player );
            $template = $template->display ();
            $template_player = $template;
        }
    } else {
        $template_player = "";
    }
    
    return $template_player;
}
?>
