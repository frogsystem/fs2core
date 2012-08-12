<?php

  /* TODO: put titles and descriptions into $TEXT, i.e. localize them */

  $TEMPLATE_GO = 'tpl_topdownloads';
  $TEMPLATE_FILE = '0_top_downloads.tpl';
  $TEMPLATE_EDIT = array();

  $TEMPLATE_EDIT[] = array (
    'name' => 'downloads',
    'title' => 'Applet - Body',
    'description' => 'Aussehen des Applets im Men&uuml;',
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'entries', 'text' => 'Bindet hintereinander die 10 meistgeladenen Downloads ein')
    )
  );

  $TEMPLATE_EDIT[] = array (
    'name' => 'download_entry',
    'title' => 'Downloadeintrag',
    'description' => 'Ansicht eines Eintrages f&uuml;r einen einzelnen Download',
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'name', 'text' => 'Name des Downloads'),
        array ( 'tag' => 'dl_id', 'text' => 'Datenbank-ID des Downloads')
    )
  );

  $TEMPLATE_EDIT[] = array (
    'name' => 'no_entries',
    'title' => 'Keine Downloads',
    'description' => 'Ansicht der Eintr&auml;ge, wenn keine Downloads vorhanden sind',
    'rows' => 10,
    'cols' => 66,
    'help' => array ()
  );

  //Init Template-Page
  echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE );
?>
