<?php
// Security Functions
if (
        ( $_GET['dl'] == "true" || $_GET['dl'] == "TRUE" )
        && ( isset ( $_GET['id'] ) || isset ( $_GET['fileid'] ) )
    )
{
    $_GET['id'] = ( isset ( $_GET['fileid'] ) && !isset ( $_GET['id'] ) ) ? $_GET['fileid'] : $_GET['id'];
    settype( $_GET['id'], "integer" );
    $_GET['dl'] = ( $_GET['dl'] == "true" || $_GET['dl'] == "TRUE" ) ? TRUE : FALSE;
}

// Download-Link clicked
if (
        isset ( $_GET['id'] )
        && $_GET['dl'] === TRUE
        && ( $_SERVER['HTTP_REFERER'] == "" || strstr ( $_SERVER['HTTP_REFERER'], "?go=dlfile" ) )
    )
{
    // Load Config Array
    $index = mysql_query ( " SELECT * FROM `".$global_config_arr['pref']."dl_config` ", $db);
    $config_arr = mysql_fetch_assoc ( $index );
    
    // Get File Data
    $index = mysql_query ( "
                            SELECT `file_is_mirror`, `file_url`
                            FROM `".$global_config_arr['pref']."dl_files`
                            WHERE `file_id` = ".$_GET['id']."
    ", $db );
    $check_file_is_mirror = mysql_result ( $index, 0, "file_is_mirror" );
    settype( $check_file_is_mirror, "integer" );
    $file_url = stripslashes ( mysql_result ( $index, 0, "file_url" ) );
    
    // Is DL a Mirror?
    if (
            $config_arr['dl_rights'] == 2
            || ( $config_arr['dl_rights'] == 1 && $_SESSION['user_level'] == "loggedin" )
            || $check_file_is_mirror == 1
        )
    {
        // Update Counter
        mysql_query ( "
                        UPDATE `".$global_config_arr['pref']."dl_files`
                        SET `file_count` = `file_count` + 1
                        WHERE `file_id` = '".$_GET['id']."'
        ", $db );
        // Forward to the URL
        header ( "Location: " . $file_url );
    } else {
        header ( "Location: ?go=403" );
    }
}
?>