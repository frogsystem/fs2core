<?php if (ACP_GO == 'find_applet') {

// get script
$adminpage->clearConds();
$adminpage->clearTexts();
echo $adminpage->get('script');

// load files

$files = scandir_ext (FS2_ROOT_PATH . 'applets', 'php');
if (count($files) < 1) {
    // display error
    $adminpage->clearConds();
    $adminpage->clearTexts();
    $content = $adminpage->get('no');
} else {
    // get lines
    initstr($lines);
    foreach ($files as $file) {
        $filename = basename($file, '.php');
        
        // get line tpl
        $adminpage->clearConds();
        $adminpage->clearTexts();
        $adminpage->addText('file', $file);
        $adminpage->addText('filename', $filename);
        $lines .= $adminpage->get('line');
    }
    
    //get main tpl
    $adminpage->clearConds();
    $adminpage->clearTexts();
    $adminpage->addText('lines', $lines);
    $content = $adminpage->get('main');    
}

echo get_content_container('&nbsp;', $content);

} ?>
