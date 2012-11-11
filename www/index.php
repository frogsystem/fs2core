<?php
/* FS2 PHP Init */
set_include_path('.');
define('FS2_ROOT_PATH', './', true);
require_once(FS2_ROOT_PATH . 'includes/phpinit.php');
phpinit();
/* End of FS2 PHP Init */


// Inlcude DB Connection File or exit()
require_once(FS2_ROOT_PATH . 'login.inc.php');

//Include Functions-Files
require_once(FS2_ROOT_PATH . 'classes/exceptions.php');
require_once(FS2_ROOT_PATH . 'includes/cookielogin.php');
require_once(FS2_ROOT_PATH . 'includes/imagefunctions.php');
require_once(FS2_ROOT_PATH . 'includes/indexfunctions.php');

// Constructor Calls
// TODO: "Constructor Hook"
get_goto();
setTimezone($FD->cfg('timezone'));
run_cronjobs();
count_all($FD->cfg('goto'));
save_visitors();
if (!$FD->configExists('main', 'count_referers') || $FD->cfg('main', 'count_referers')==1) {
  save_referer();
}
set_style();
copyright();


// Get Body-Template
$theTemplate = new template();
$theTemplate->setFile('0_main.tpl');
$theTemplate->load('MAIN');
$theTemplate->tag('content', get_content($FD->cfg('goto')));
$theTemplate->tag('copyright', get_copyright());

$template_general = (string) $theTemplate;
// TODO: "Template Manipulation Hook"

// Display Page
echo tpl_functions_init(get_maintemplate($template_general));


// Shutdown System
// TODO: "Shutdown Hook"
unset($FD);
?>
