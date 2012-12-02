<?php
/*
    This file is part of the Frogsystem Forum Feed applet.
    Copyright (C) 2012  Thoronador

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.


    Additional permission under GNU GPL version 3 section 7

    If you modify this Program, or any covered work, by linking or combining it
    with Frogsystem 2 (or a modified version of Frogsystem 2), containing parts
    covered by the terms of Creative Commons Attribution-ShareAlike 3.0, the
    licensors of this Program grant you additional permission to convey the
    resulting work. Corresponding Source for a non-source form of such a
    combination shall include the source code for the parts of Frogsystem used
    as well as that of the covered work.
*/

  //load config from DB
  $ff_config = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'forumfeed'"));
  $ff_config = json_array_decode($ff_config['config_data']);

  require_once(FS2_ROOT_PATH . 'includes/forumfeedfunctions.php');

  $ffp = new ForumFeedParser();

  $threads = $ffp->parse($ff_config['feed_url']);
  $threads_output = '';

  if ($threads===false)
  {
    $template = new template();
    $template->setFile('0_forumfeed.tpl');
    $template->load('THREADS_FAILED');
    $threads_output = $template->display();
  }
  else if (empty($threads))
  {
    $template = new template();
    $template->setFile('0_forumfeed.tpl');
    $template->load('THREADS_EMPTY');
    $threads_output = $template->display();
  }
  else
  {
    //successful retrieval of threads; now list them
    $limit = (count($threads)<$ff_config['thread_limit']) ? count($threads) : $ff_config['thread_limit'];
    for ($i=0; $i<$limit; $i=$i+1)
    {
      $template = new template();
      $template->setFile('0_forumfeed.tpl');
      $template->load('THREAD_ENTRY');
      $template->tag('id', $threads[$i]['id']);
      if (strlen($threads[$i]['title'])>$ff_config['title_max'])
        $template->tag('title', htmlentities(substr($threads[$i]['title'], 0, $ff_config['title_max']), ENT_COMPAT, 'ISO-8859-1').'...' );
      else
        $template->tag('title', htmlentities($threads[$i]['title'], ENT_COMPAT, 'ISO-8859-1'));
      $template->tag('author', htmlentities($threads[$i]['author'], ENT_COMPAT, 'ISO-8859-1'));
      $template->tag('date', $threads[$i]['date']);
      $template->tag('time', $threads[$i]['time']);
      $template->tag('base', $ffp->baseURL);
      $threads_output .= $template->display();
    }//for
  }//else

  $template = new template();
  $template->setFile('0_forumfeed.tpl');
  $template->load('THREADS_BODY');
  $template->tag('entries', $threads_output);
  $template->tag('base', $ffp->baseURL);

  $template = $template->display();
?>
