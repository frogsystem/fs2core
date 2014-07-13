<?php
  $FD->loadConfig('main');
  $main_config = $FD->configObject('main')->getConfigArray();
  $current_tag = $main_config['style_tag'];

  //change selected style
  if (isset($_GET['new_style']))
  {
    $stmt = $FD->sql()->conn()->prepare('SELECT * FROM `'.$FD->config('pref').'styles` WHERE `style_allow_use` = 1 AND `style_tag` != \'default\' AND `style_tag` = ?');
    $stmt->execute(array($_GET['new_style']));
    if (($row = $stmt->fetch(PDO::FETCH_ASSOC)) === false)
    {
      $template = sys_message($FD->text('frontend', 'sysmessage'), $FD->text('frontend', 'style_not_exist'));
    }
    else
    {
      //set style via cookie, expires 14 days from now
      setcookie('style', $_GET['new_style'], time()+14*86400);
      $template = forward_message($FD->text('frontend', 'new_style_selected'), $FD->text('frontend', 'style_select_reload'),
                                  url('style_selection', array()));
    }
  } //if new_style is set
  else if (isset($_GET['clear']))
  {
    //delete style cookie, "expires" 100 days ago
    setcookie('style', '', time()-100*86400);
    $template = forward_message($FD->text('frontend', 'style_select_clear'), $FD->text('frontend', 'style_select_reload'),
                                url('style_selection', array()));
  } //if clear / delete cookie
  else
  {
    //show list
    $index = $FD->sql()->conn()->query('SELECT * FROM `'.$FD->config('pref').'styles` WHERE `style_allow_use` = 1 AND `style_tag` != \'default\'');
    $styles = '';
    while (($row = $index->fetch(PDO::FETCH_ASSOC)) !== false)
    {
      $ini = FS2_ROOT_PATH . 'styles/' . $row['style_tag'] . '/style.ini';
      $data = array();
      if (is_readable($ini))
      {
        $fa = new fileaccess();
        $ini_lines = $fa->getFileArray($ini);
        unset($fa);
        $ini_lines = array_map('trim', $ini_lines);
        $ini_lines = array_map('htmlentities', $ini_lines);
        $data['name'] = $ini_lines[0];
        $data['version'] = ( !empty($ini_lines[1]) ) ? $ini_lines[1] : '';
        $data['copy'] = ( !empty($ini_lines[2]) ) ? $ini_lines[2] : '';
      }
      else
      {
        $data['name'] = $row['style_tag'];
        $data['version'] = '';
        $data['copy'] = '';
      }

      $template = new template();
      $template->setFile('0_style_select.tpl');
      $template->load('ENTRY');

      $template->tag('tag',  $row['style_tag']);
      $template->tag('name', $data['name']);
      $template->tag('version', $data['version']);
      $template->tag('copy', $data['copy']);
      $template->tag('url', url('style_selection', array('new_style' => $row['style_tag'])));

      $styles .= $template->display();
    }//while

    $clear = '';
    if (isset($_COOKIE['style']))
    {
      $template = new template();
      $template->setFile('0_style_select.tpl');
      $template->load('CLEAR');

      $template->tag('clear_url', url('style_selection', array('clear' => 1)) );

      $clear = $template->display();
    }

    $template = new template();
    $template->setFile('0_style_select.tpl');
    $template->load('BODY');

    $current = isset($_COOKIE['style']) ? htmlentities($_COOKIE['style']) : $FD->text('frontend', 'none').' ('.htmlentities($current_tag).')';
    $template->tag('styles', $styles );
    $template->tag('current', $current );
    $template->tag('clear_selection', $clear );
    $template->tag('cookie_hint', $FD->text('frontend', 'style_select_cookie_hint') );

    $template = $template->display ();
  } //else
?>
