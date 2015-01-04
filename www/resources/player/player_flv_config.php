<?php
// Start Session
session_start();

// fs2 include path
set_include_path ( '.' );
define ( 'FS2_ROOT_PATH', './../../', TRUE );

// set header
header('Content-type: text/plain');

// include db-data
require ( FS2_ROOT_PATH . 'login.inc.php' );
require ( FS2_ROOT_PATH . 'includes/newfunctions.php' );

if ( $FD->db()->conn() )
{
    $FD->loadConfig('video_player');
    $config_arr = $FD->configObject('video_player')->getConfigArray();

    // security functions
    settype ( $config_arr['cfg_loop'], 'integer' );
    settype ( $config_arr['cfg_autoplay'], 'integer' );
    settype ( $config_arr['cfg_autoload'], 'integer' );
    settype ( $config_arr['cfg_volume'], 'integer' );
    settype ( $config_arr['cfg_margin'], 'integer' );
    settype ( $config_arr['cfg_showstop'], 'integer' );
    settype ( $config_arr['cfg_showvolume'], 'integer' );
    settype ( $config_arr['cfg_showtime'], 'integer' );
    settype ( $config_arr['cfg_playertimeout'], 'integer' );
    settype ( $config_arr['cfg_showfullscreen'], 'integer' );
    settype ( $config_arr['cfg_playeralpha'], 'integer' );
    settype ( $config_arr['cfg_buffer'], 'integer' );
    settype ( $config_arr['cfg_buffershowbg'], 'integer' );
    settype ( $config_arr['cfg_titlesize'], 'integer' );
    settype ( $config_arr['cfg_shortcut'], 'integer' );
    settype ( $config_arr['cfg_showiconplay'], 'integer' );
    settype ( $config_arr['cfg_showtitleandstartimage'], 'integer' );
    settype ( $config_arr['cfg_iconplaybgalpha'], 'integer' );
    settype ( $config_arr['cfg_top1_x'], 'integer' );
    settype ( $config_arr['cfg_top1_y'], 'integer' );
    settype ( $config_arr['cfg_loadonstop'], 'integer' );

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

    echo 'autoplay='.$config_arr['cfg_autoplay'].'
autoload='.$config_arr['cfg_autoload'].'
buffer='.$config_arr['cfg_buffer'].'
buffermessage='.$config_arr['cfg_buffermessage'].'
buffercolor='.$config_arr['cfg_buffercolor'].'
bufferbgcolor='.$config_arr['cfg_bufferbgcolor'].'
buffershowbg='.$config_arr['cfg_buffershowbg'].'
titlesize='.$config_arr['cfg_titlesize'].'
titlecolor='.$config_arr['cfg_titlecolor'].'
margin='.$config_arr['cfg_margin'].'
showstop='.$config_arr['cfg_showstop'].'
showvolume='.$config_arr['cfg_showvolume'].'
showtime='.$config_arr['cfg_showtime'].'
showplayer='.$config_arr['cfg_showplayer'].'
showloading='.$config_arr['cfg_showloading'].'
showfullscreen='.$config_arr['cfg_showfullscreen'].'
showmouse='.$config_arr['cfg_showmouse'].'
loop='.$config_arr['cfg_loop'].'
playercolor='.$config_arr['cfg_playercolor'].'
loadingcolor='.$config_arr['cfg_loadingcolor'].'
bgcolor='.$config_arr['cfg_bgcolor'].'
bgcolor1='.$config_arr['cfg_bgcolor1'].'
bgcolor2='.$config_arr['cfg_bgcolor2'].'
buttoncolor='.$config_arr['cfg_buttoncolor'].'
buttonovercolor='.$config_arr['cfg_buttonovercolor'].'
slidercolor1='.$config_arr['cfg_slidercolor1'].'
slidercolor2='.$config_arr['cfg_slidercolor2'].'
sliderovercolor='.$config_arr['cfg_sliderovercolor'].'
loadonstop='.$config_arr['cfg_loadonstop'].'
onclick='.$config_arr['cfg_onclick'].'
ondoubleclick='.$config_arr['cfg_ondoubleclick'].'
playertimeout='.$config_arr['cfg_playertimeout'].'
videobgcolor='.$config_arr['cfg_videobgcolor'].'
volume='.$config_arr['cfg_volume'].'
shortcut='.$config_arr['cfg_shortcut'].'
playeralpha='.$config_arr['cfg_playeralpha'].'
top1='.$config_arr['cfg_top1'].'
showiconplay='.$config_arr['cfg_showiconplay'].'
iconplaycolor='.$config_arr['cfg_iconplaycolor'].'
iconplaybgcolor='.$config_arr['cfg_iconplaybgcolor'].'
iconplaybgalpha='.$config_arr['cfg_iconplaybgalpha'].'
showtitleandstartimage='.$config_arr['cfg_showtitleandstartimage'].'';
}
?>
