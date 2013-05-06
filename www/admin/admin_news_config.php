<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('num_news', 'num_head', 'html_code', 'fs_code', 'para_handling', 'cat_pic_x', 'cat_pic_y', 'cat_pic_size', 'com_rights', 'com_antispam', 'news_headline_lenght', 'acp_per_page', 'acp_view', 'com_sort', 'news_headline_ext', 'acp_force_cat_selection');


///////////////////////
//// Update Config ////
///////////////////////

// Write Data into DB
if (
	isset($_POST['num_news']) && $_POST['num_news'] > 0
	&& isset($_POST['num_head']) && $_POST['num_head'] > 0
	&& isset($_POST['cat_pic_x']) && $_POST['cat_pic_x'] > 0
	&& isset($_POST['cat_pic_y']) && $_POST['cat_pic_y'] > 0
	&& isset($_POST['cat_pic_size']) && $_POST['cat_pic_size'] > 0
	&& isset($_POST['news_headline_lenght'])
	&& isset($_POST['acp_per_page']) && $_POST['acp_per_page'] > 0
   )
{
    // prepare data
    $data = frompost($used_cols);

    // save config
    try {
        $FD->saveConfig('news', $data);
        systext($FD->text('admin', 'config_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
    } catch (Exception $e) {
        systext(
            $FD->text('admin', 'config_not_saved').'<br>'.
            (DEBUG ? $e->getMessage() : $FD->text('admin', 'unknown_error')),
            $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error')
        );
    }

    // Unset Vars
    unset($_POST);
}

/////////////////////
//// Config Form ////
/////////////////////

if ( TRUE )
{
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text("admin", "changes_not_saved").'<br>'.$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), 'red', $FD->text("admin", "icon_save_error"));

    // Load Data from DB into Post
    } else {
        $FD->loadConfig('news');
        $data = $FD->configObject('news')->getConfigArray();
        putintopost($data);
    }

    // security functions
    $_POST = array_map('killhtml', $_POST);


    // Conditions
    for ($i=1; $i<=4; $i++)
        $adminpage->addCond("html_code_$i", $_POST['html_code'] === $i);

    for ($i=1; $i<=4; $i++)
        $adminpage->addCond("fs_code_$i", $_POST['fs_code'] === $i);

    for ($i=1; $i<=4; $i++)
        $adminpage->addCond("para_handling_$i", $_POST['para_handling'] === $i);

    for ($i=0; $i<=4; $i++)
        $adminpage->addCond("com_rights_$i", $_POST['com_rights'] === $i);

    $adminpage->addCond('com_sort_asc', $_POST['com_sort'] === 'ASC');
    $adminpage->addCond('com_sort_desc', $_POST['com_sort'] === 'DESC');

    for ($i=0; $i<=4; $i++)
        $adminpage->addCond("com_antispam_$i", $_POST['com_antispam'] === $i);

    for ($i=0; $i<=2; $i++)
        $adminpage->addCond("acp_view_$i", $_POST['acp_view'] === $i);

    $adminpage->addCond('force_cat_selection', $_POST['acp_force_cat_selection'] === 1);

    // Values
    foreach ($_POST as $key => $value) {
        $adminpage->addText($key, $value);
    }

    // display page
    echo $adminpage->get('main');
}

?>
