<?php

  /* TODO: put titles and descriptions into $TEXT, i.e. localize them */

  $TEMPLATE_GO = 'tpl_topmodules';
  $TEMPLATE_FILE = '0_top_modules.tpl';
  $TEMPLATE_EDIT = array();

  $TEMPLATE_EDIT[] = array (
    'name' => 'modules',
    'title' => 'Modul - Body',
    'description' => 'Aussehen des Applets im Men&uuml;',
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'entries', 'text' => 'Bindet hintereinander die 10 meistgeladenen Module ein')
    )
  );

  $TEMPLATE_EDIT[] = array (
    'name' => 'module_entry',
    'title' => 'Moduleintrag',
    'description' => 'Ansicht eines Eintrages f&uuml;r ein einzelnes Modul',
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'name', 'text' => 'Name des Moduls/Downloads'),
        array ( 'tag' => 'dl_id', 'text' => 'Datenbank-ID des Downloads')
    )
  );

  $TEMPLATE_EDIT[] = array (
    'name' => 'no_entries',
    'title' => 'Keine Module',
    'description' => 'Ansicht der Eintr&auml;ge, wenn keine Module vorhanden sind',
    'rows' => 10,
    'cols' => 66,
    'help' => array ()
  );

  //Init Template-Page
  echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE );
?>