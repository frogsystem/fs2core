<?php
    // list of function files
    $list = array(
        'functions.php',
        'textfunctions.php',
        
        'features.php',
        'cronfunctions.php',
        'fscode.php',
        'imagefunctions.php',
        'indexfunctions.php',
        'searchfunctions.php',
        'statisticsfunctions.php',
        'stylefunctions.php',
        'urlfunctions.php',
        'userfunctions.php',
    );
    
    // include the files
    foreach ($list as $file) {
        include_once(FS2SOURCE.'/libs/includes/'.$file);
    }
    
    
// send email => replace by Mail and MailManager class
function send_mail ( $TO, $SUBJECT, $CONTENT, $HTML = TRUE, $FROM = FALSE, $TPL_FUNC = true)
{
    if ($FROM == FALSE) {
        $FROM = MailManager::getDefaultSender();
    }
    $mail = new Mail($FROM, $TO, $SUBJECT, MailManager::parseContent($CONTENT, $HTML, $TPL_FUNC), $HTML, $TPL_FUNC);
    return $mail->send();
}
    

//Pagenav Array with Start Number => replace by Pagination class
function get_pagenav_start ( $NUM_OF_ENTRIES, $ENTRIES_PER_PAGE, $START )
{
    if ( ! isset ( $START ) ) { $START = 0; }
    if ( ! is_int ( $START ) ) { $START = 0; }
    if ( $START < 0 ) { $START = 0; }
    if ( $START > $NUM_OF_ENTRIES ) { $START = $NUM_OF_ENTRIES - $ENTRIES_PER_PAGE; }

    $OLDSTART = $START - $ENTRIES_PER_PAGE;
    if ( $OLDSTART < 0 ) { $OLDSTART = 0; }
    $NEWSTART = $START + $ENTRIES_PER_PAGE;
    if ( $NEWSTART > $NUM_OF_ENTRIES ) { $NEWSTART = $NUM_OF_ENTRIES - $ENTRIES_PER_PAGE; }

    $PAGENAV_DATA['total_entries'] = $NUM_OF_ENTRIES;
    $PAGENAV_DATA['entries_per_page'] = $ENTRIES_PER_PAGE;
    $PAGENAV_DATA['old_start'] = $OLDSTART;
    $PAGENAV_DATA['cur_start'] = $START;
    $PAGENAV_DATA['new_start'] = $NEWSTART;

    if ( $START > 1 ) { $PAGENAV_DATA['old_start_exists'] = TRUE; }
    else { $PAGENAV_DATA['old_start_exists'] = FALSE; }
    if ( ( $START + $ENTRIES_PER_PAGE ) < $NUM_OF_ENTRIES ) { $PAGENAV_DATA['newpage_exists'] = TRUE; }
    else { $PAGENAV_DATA['newpage_exists'] = FALSE; }

    return $PAGENAV_DATA;
}
    
    
    
    
///////////////////////
// These functions should be moved to somewhere more meaningful   
///////////////////////
 
//// validation of lang dirs
function is_language_text ($TEXT) {
    if (preg_match("/[a-z]{2}_[A-Z]{2}/", $TEXT ) === 1) {
        return true;
    } else {
        return false;
    }
}    


//// Localized Date
function date_loc ($DATE_STRING, $TIMESTAMP)
{
    global $FD;

    $week_en = array ( 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday' );
    $month_en = array ( 'January','February','March','April','May','June','July','August','September','October','November','December' );

    $week_loc = explode(',', $FD->text('frontend', 'week_days_array'));
    $month_loc = explode(',', $FD->text('frontend', 'month_names_array'));

    $localized_date = str_replace($week_en, $week_loc, date($DATE_STRING, $TIMESTAMP));
    $localized_date = str_replace($month_en,$month_loc, $localized_date);

    return $localized_date;
}

    
    
?>
