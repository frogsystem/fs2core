<?php
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

    $template = new template();
    $template->setFile('0_style_select.tpl');
    $template->load('BODY');

    $template->tag('styles', $styles );
    $template->tag('cookie_hint', $FD->text('frontend', 'style_select_cookie_hint') );

    $template = $template->display ();
  } //else
?>
