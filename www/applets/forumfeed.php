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

  //change the URL to the URL of your feed!
  $url = 'http://www.vbulletin-germany.com/forum/external.php?type=xml';
  //the maximum number of thread entries - change if desired!
  $limit = 5;
  //the maximum length of a title before it gets shortened
  $title_max = 45;

  require_once(FS2_ROOT_PATH . 'includes/forumfeedfunctions.php');

  $threads = parseForumFeedXML($url);
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
    $limit = (count($threads)<$limit) ? count($threads) : $limit;
    for ($i=0; $i<$limit; $i=$i+1)
    {
      $template = new template();
      $template->setFile('0_forumfeed.tpl');
      $template->load('THREAD_ENTRY');
      $template->tag('id', $threads[$i]['id']);
      if (strlen($threads[$i]['title'])>$title_max)
        $template->tag('title', substr($threads[$i]['title'], 0, $title_max).'...' );
      else
        $template->tag('title', $threads[$i]['title']);
      $template->tag('author', $threads[$i]['author']);
      $template->tag('date', $threads[$i]['date']);
      $template->tag('time', $threads[$i]['time']);
      $threads_output .= $template->display();
    }//for
  }//else

  $template = new template();
  $template->setFile('0_forumfeed.tpl');
  $template->load('THREADS_BODY');
  $template->tag('entries', $threads_output);

  $template = $template->display();
?>
