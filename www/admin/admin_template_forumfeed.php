<?php
  if (!defined('ACP_GO')) die('Unauthorized access!');

  $TEMPLATE_GO = 'tpl_forumfeed';
  $TEMPLATE_FILE = '0_forumfeed.tpl';
  $TEMPLATE_EDIT = null;

  $TEMPLATE_EDIT[] = array (
    'name' => 'THREAD_ENTRY',
    'title' => $FD->text('template', 'forumfeed_entry_title'),
    'description' => $FD->text('template', 'forumfeed_entry_desc'),
    'rows' => 12,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'id', 'text' => $FD->text('template', 'forumfeed_entry_thread_id') ),
        array ( 'tag' => 'title', 'text' => $FD->text('template', 'forumfeed_entry_thread_title') ),
        array ( 'tag' => 'author', 'text' => $FD->text('template', 'forumfeed_entry_thread_author') ),
        array ( 'tag' => 'date', 'text' => $FD->text('template', 'forumfeed_entry_thread_date') ),
        array ( 'tag' => 'time', 'text' => $FD->text('template', 'forumfeed_entry_thread_time') ),
    )
  );

  $TEMPLATE_EDIT[] = array (
    'name' => 'THREADS_BODY',
    'title' => $FD->text('template', 'forumfeed_body_title'),
    'description' => $FD->text('template', 'forumfeed_body_desc'),
    'rows' => 8,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'entries', 'text' => $FD->text('template', 'forumfeed_body_entries') )
    )
  );

  $TEMPLATE_EDIT[] = array (
    'name' => 'THREADS_FAILED',
    'title' => $FD->text('template', 'forumfeed_failed_title'),
    'description' => $FD->text('template', 'forumfeed_failed_desc'),
    'rows' => 5,
    'cols' => 66,
    'help' => array()
  );

  $TEMPLATE_EDIT[] = array (
    'name' => 'THREADS_EMPTY',
    'title' => $FD->text('template', 'forumfeed_empty_title'),
    'description' => $FD->text('template', 'forumfeed_empty_desc'),
    'rows' => 5,
    'cols' => 66,
    'help' => array()
  );

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
