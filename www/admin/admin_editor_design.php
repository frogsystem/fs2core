<?php if (!defined("ACP_GO")) die("Unauthorized access!");


    if ( $go == "tpl_editor" ) {
        $TEMPLATE_GO = "tpl_editor";
    } else {
        $TEMPLATE_GO = "editor_design";
    }
    $TEMPLATE_FILE = "0_editor.tpl";
    $TEMPLATE_EDIT = null;
    

    $tmp[name] = "BUTTON";
    $tmp[title] = $FD->text("template", "editor_button_title");
    $tmp[description] = $FD->text("template", "editor_button_description");
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "img_file_name";
        $tmp[help][0][text] = $FD->text("template", "editor_button_help_1");
        $tmp[help][1][tag] = "alt";
        $tmp[help][1][text] = $FD->text("template", "editor_button_help_2");
        $tmp[help][2][tag] = "title";
        $tmp[help][2][text] = $FD->text("template", "editor_button_help_3");
        $tmp[help][3][tag] = "javascript";
        $tmp[help][3][text] = $FD->text("template", "editor_button_help_4");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "SEPERATOR";
    $tmp[title] = $FD->text("template", "editor_separator_title");
    $tmp[description] = $FD->text("template", "editor_separator_description");
    $tmp[rows] = "10";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "SMILIES_BODY";
    $tmp[title] = $FD->text("template", "editor_smilies_title");
    $tmp[description] = $FD->text("template", "editor_smilies_description");
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "smilies_table";
        $tmp[help][0][text] = $FD->text("template", "editor_smilies_help_table");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $tmp[name] = "BODY";
    $tmp[title] = $FD->text("template", "editor_design_title");
    $tmp[description] = $FD->text("template", "editor_design_description");
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "style";
        $tmp[help][0][text] = $FD->text("template", "editor_design_help_1");
        $tmp[help][1][tag] = "text";
        $tmp[help][1][text] = $FD->text("template", "editor_design_help_2");
        $tmp[help][2][tag] = "buttons";
        $tmp[help][2][text] = $FD->text("template", "editor_design_help_3");
        $tmp[help][3][tag] = "smilies";
        $tmp[help][3][text] = $FD->text("template", "editor_design_help_smilies");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
        
//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
