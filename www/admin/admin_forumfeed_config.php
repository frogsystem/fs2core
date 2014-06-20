<?php if (!defined('ACP_GO')) die('Unauthorized access!');

///////////////////////
//// Update Config ////
///////////////////////

if ( isset($_POST['feed_url'])
    && isset($_POST['thread_limit']) && ($_POST['thread_limit']>0)
    && isset($_POST['title_max']) && ($_POST['title_max']>0) )
{
  // prepare data
  $_POST['thread_limit'] = intval($_POST['thread_limit']);
  if ($_POST['thread_limit']<=0)
  {
    $_POST['thread_limit'] = 1;
  }
  $_POST['title_max'] = intval($_POST['title_max']);
  if ($_POST['title_max']<=0)
  {
    $_POST['title_max'] = 1;
  }

  $data = frompost(array('feed_url', 'thread_limit', 'title_max'));

  // save config
  try {
    $FD->saveConfig('forumfeed', $data);
    systext($FD->text('admin', 'config_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
  } catch (Exception $e) {
    systext( $FD->text('admin', 'config_not_saved').'<br>'.
      (DEBUG ? $e->getMessage() : $FD->text('admin', 'unknown_error')),
    $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error')
    );
  }

  unset($_POST);
}

/////////////////////
//// Config Form ////
/////////////////////

  // Display Error Messages
  if (isset($_POST['sended'])) {
    systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));
  } else {
    // Load Data from DB into Post
    $FD->loadConfig('forumfeed');
    $data = $FD->configObject('forumfeed')->getConfigArray();
    putintopost($data);
  }

  //Is the cURL module for PHP missing?
  $curl_text = function_exists('curl_init') ? '' : $adminpage->get('no_cURL');

  // security functions
  $_POST = array_map('killhtml', $_POST);

  $adminpage->addText('feed_url', $_POST['feed_url']);
  $adminpage->addText('thread_limit', $_POST['thread_limit']);
  $adminpage->addText('title_max', $_POST['title_max']);
  $adminpage->addText('cURL_missing', $curl_text);

  echo $adminpage->get('main');
?>
