<?php
// Security Functions
if (
        ( isset($_GET['dl']) && oneof($_GET['dl'], 'true', 'TRUE') )
        && ( isset ( $_GET['id'] ) || isset ( $_GET['fileid'] ) )
    )
{
    $_GET['id'] = ( isset ( $_GET['fileid'] ) && !isset ( $_GET['id'] ) ) ? $_GET['fileid'] : $_GET['id'];
    settype( $_GET['id'], 'integer' );
    $_GET['dl'] = ( $_GET['dl'] == 'true' || $_GET['dl'] == 'TRUE' ) ? TRUE : FALSE;
}

// Download-Link clicked
if (
    isset ($_GET['id'])
    && isset ($_GET['dl']) && $_GET['dl'] === TRUE
    && ( $_SERVER['HTTP_REFERER'] == '' || strstr ( $_SERVER['HTTP_REFERER'], '?go=dlfile' ) )
   )
{
    // Load Config Array
    $FD->loadConfig('downloads');
    $config_arr = $FD->configObject('downloads')->getConfigArray();

    // Get File Data
    $index = $FD->db()->conn()->query ( '
                    SELECT `file_is_mirror`, `file_url`
                    FROM `'.$FD->config('pref').'dl_files`
                    WHERE `file_id` = '.$_GET['id'].' ' );
    $dlf_row = $index->fetch(PDO::FETCH_ASSOC);
    $check_file_is_mirror = $dlf_row['file_is_mirror'];
    settype( $check_file_is_mirror, 'integer' );
    $file_url = $dlf_row['file_url'];

    // Is DL a Mirror?
    if (
            $config_arr['dl_rights'] == 2
            || ( $config_arr['dl_rights'] == 1 && is_loggedin() )
            || $check_file_is_mirror == 1
        )
    {
        // Update Counter
        $FD->db()->conn()->exec ( '
                UPDATE `'.$FD->config('pref')."dl_files`
                SET `file_count` = `file_count` + 1
                WHERE `file_id` = '".$_GET['id']."'" );
        // Forward to the URL
        header ( 'Location: ' . $file_url );
        exit;
    } else {
        header ( 'Location: ?go=403' );
    }
}
?>
