<?php
    if ( $go == "tpl_fscodes" ) {
        $TEMPLATE_GO = "tpl_fscodes";
    } else {
        $TEMPLATE_GO = "editor_fscodes";
    }
    $TEMPLATE_FILE = "0_fscodes.tpl";
    $TEMPLATE_EDIT = null;


    $tmp[name] = "QUOTE";
    $tmp[title] = $admin_phrases[template][quote_tag][title];
    $tmp[description] = $admin_phrases[template][quote_tag][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "text";
        $tmp[help][0][text] = $admin_phrases[template][quote_tag][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "QUOTE_SOURCE";
    $tmp[title] = $admin_phrases[template][quote_tag_name][title];;
    $tmp[description] = $admin_phrases[template][quote_tag_name][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "text";
        $tmp[help][0][text] = $admin_phrases[template][quote_tag_name][help_1];
        $tmp[help][1][tag] = "author";
        $tmp[help][1][text] = $admin_phrases[template][quote_tag_name][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    
    $tmp[name] = "CODE";
    $tmp[title] = $admin_phrases[template][code_tag][title];
    $tmp[description] = $admin_phrases[template][code_tag][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "text";
        $tmp[help][0][text] = $admin_phrases[template][code_tag][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

        
//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>