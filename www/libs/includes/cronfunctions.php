<?php
///////////////////////////////
//// start pseudo cronjobs ////
///////////////////////////////
function run_cronjobs ($time = null, $save_time = true) {
    global $FD;

    // set now
    if (empty($time))
        $time = $FD->env('time');

    // calc 3am
    $today_3am = mktime(3, 0, 0, date('m', $time), date ('d', $time), date ('Y', $time));
    $today_3am = ($today_3am > $FD->cfg('time')) ? $today_3am - 24*60*60 : $today_3am;

    // calc next hour
    $last_hour = $time-(date('i', $time)*60)-date('s', $time); // now - min and sec of this hour

    // Run Cronjobs or not
    if ($FD->cfg('cronjobs', 'last_cronjob_time_daily') < $today_3am)
        cronjobs_daily($time);
    if ($FD->cfg('cronjobs', 'last_cronjob_time_hourly') < $last_hour)
        cronjobs_hourly($time);
    if (($FD->cfg('cronjobs', 'last_cronjob_time')+5*60) < $time)
        cronjobs_instantly_bufferd($time);
}

////////////////////////
//// daily cronjobs ////
////////////////////////
function cronjobs_daily ($save_time = null) {
    global $FD;

    // Run Cronjobs
    search_index();
    clean_referers();
    HashMapper::deleteByTime();

    // save time
    if (!empty($save_time))
        $FD->saveConfig('cronjobs', array('last_cronjob_time_daily' => $save_time));
}

/////////////////////////
//// hourly cronjobs ////
/////////////////////////
function cronjobs_hourly ($save_time = null) {
    global $FD;

    // Run Cronjobs

    // save time
    if (!empty($save_time))
        $FD->saveConfig('cronjobs', array('last_cronjob_time_hourly' => $save_time));
}

/////////////////////////////////////////
//// instant tasks, bufferd for 5min ////
/////////////////////////////////////////
function cronjobs_instantly_bufferd ($save_time = null) {
    global $FD;

    // Run Cronjobs
    clean_timed_preview_images();

    // save time
    if (!empty($save_time))
        $FD->saveConfig('cronjobs', array('last_cronjob_time' => $save_time));
}



?>
