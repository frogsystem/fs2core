<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('use_google_plus', 'google_plus_page', 'use_schema_org', 'use_twitter_card', 'use_external_images', 'twitter_site', 'use_open_graph', 'fb_admins', 'og_section', 'site_name', 'default_image', 'use_news_cat_prepend', 'news_cat_prepend', 'enable_news', 'enable_articles', 'enable_downloads');


//////////////////////////////
//// update configuration ////
//////////////////////////////
if (
    isset($_POST['sended'])
    && (!isset($_POST['use_google_plus']) || !empty($_POST['google_plus_page']))
    && (!isset($_POST['use_twitter_card']) || !empty($_POST['twitter_site']))
    && (!isset($_POST['use_open_graph']) || (!empty($_POST['fb_admins']) && !empty($_POST['og_section'])))
    && (!isset($_POST['use_news_cat_prepend']) || !empty($_POST['news_cat_prepend']))
   )
{
    // prepare data
    $data = frompost($used_cols);
    
    // security functions
    settype($data['use_google_plus'], 'boolean');
    settype($data['use_twitter_card'], 'boolean');
    settype($data['use_open_graph'], 'boolean');
    settype($data['use_schema_org'], 'boolean');
    settype($data['use_news_cat_prepend'], 'boolean');
    settype($data['use_external_images'], 'boolean');
    settype($data['enable_news'], 'boolean');
    settype($data['enable_articles'], 'boolean');
    settype($data['enable_downloads'], 'boolean');
    
    settype($data['google_plus_page'], 'string');
    settype($data['twitter_site'], 'string');
    settype($data['fb_admins'], 'string');
    settype($data['og_section'], 'string');
    settype($data['site_name'], 'string');
    settype($data['default_image'], 'string');
    settype($data['news_cat_prepend'], 'string');

    // save config
    try {
        $FD->saveConfig('social_meta_tags', $data);
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

/////////////////////////////////
////// Konfiguration Form ///////
/////////////////////////////////

if ( TRUE )
{
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    // Load Data from DB into Post
    } else {
        $FD->loadConfig('social_meta_tags');
        $data = $FD->configObject('social_meta_tags')->getConfigArray();
        putintopost($data);
    }

    // security functions
    $_POST = array_map('killhtml', $_POST);

    // Conditions
    $adminpage->addCond('use_google_plus', $_POST['use_google_plus'] === 1);
    $adminpage->addCond('use_twitter_card', $_POST['use_twitter_card'] === 1);
    $adminpage->addCond('use_open_graph', $_POST['use_open_graph'] === 1);
    $adminpage->addCond('use_schema_org', $_POST['use_schema_org'] === 1);
    $adminpage->addCond('use_external_images', $_POST['use_external_images'] === 1);
    $adminpage->addCond('enable_news', $_POST['enable_news'] === 1);
    $adminpage->addCond('enable_articles', $_POST['enable_articles'] === 1);
    $adminpage->addCond('enable_downloads', $_POST['enable_downloads'] === 1);
    $adminpage->addCond('use_news_cat_prepend', $_POST['use_news_cat_prepend'] === 1);

    // Values
    foreach ($_POST as $key => $value) {
        $adminpage->addText($key, $value);
    }

    // Display page
    echo $adminpage->get('main');
}

?>
