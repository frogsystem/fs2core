<?php if (!defined('ACP_GO')) die('Unauthorized access!');


    if ( $go == 'tpl_fscodes' ) {
        $TEMPLATE_GO = 'tpl_fscodes';
    } else {
        $TEMPLATE_GO = 'editor_fscodes';
    }
    $TEMPLATE_FILE = '0_fscodes.tpl';
    $TEMPLATE_EDIT = null;


    $tmp['name'] = 'QUOTE';
    $tmp['title'] = $FD->text('template', 'quote_tag_title');
    $tmp['description'] = $FD->text('template', 'quote_tag_description');
    $tmp['rows'] = '20';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'text';
        $tmp['help'][0]['text'] = $FD->text('template', 'quote_tag_help_1');
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'QUOTE_SOURCE';
    $tmp['title'] = $FD->text('template', 'quote_tag_name_title');
    $tmp['description'] = $FD->text('template', 'quote_tag_name_description');
    $tmp['rows'] = '20';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'text';
        $tmp['help'][0]['text'] = $FD->text('template', 'quote_tag_name_help_1');
        $tmp['help'][1]['tag'] = 'author';
        $tmp['help'][1]['text'] = $FD->text('template', 'quote_tag_name_help_2');
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);



    $tmp['name'] = 'CODE';
    $tmp['title'] = $FD->text('template', 'code_tag_title');
    $tmp['description'] = $FD->text('template', 'code_tag_description');
    $tmp['rows'] = '20';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'text';
        $tmp['help'][0]['text'] = $FD->text('template', 'code_tag_help_1');
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
