<?php

    if ( $go == "tpl_editor" ) {
        $TEMPLATE_GO = "tpl_editor";
    } else {
        $TEMPLATE_GO = "editor_design";
    }
    $TEMPLATE_FILE = "0_editor.tpl";
    $TEMPLATE_EDIT = null;
    

    $tmp[name] = "BUTTON";
    $tmp[title] = $admin_phrases[template][editor_button][title];
    $tmp[description] = $admin_phrases[template][editor_button][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "img_file_name";
        $tmp[help][0][text] = $admin_phrases[template][editor_button][help_1];
        $tmp[help][1][tag] = "alt";
        $tmp[help][1][text] = $admin_phrases[template][editor_button][help_2];
        $tmp[help][2][tag] = "title";
        $tmp[help][2][text] = "Beschreibungstext beim überfahren mit der Maus";
        $tmp[help][3][tag] = "javascript";
        $tmp[help][3][text] = "Fügt den Javascript-Code ein, der das einfügen ins Textfeld steuert";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "SEPERATOR";
    $tmp[title] = $admin_phrases[template][editor_seperator][title];;
    $tmp[description] = $admin_phrases[template][editor_seperator][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "SMILIES_BODY";
    $tmp[title] = "Smilies";
    $tmp[description] = "Smilie aussehen";
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "smilies_table";
        $tmp[help][0][text] = "Die Tabelle mit den Smilies";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $tmp[name] = "BODY";
    $tmp[title] = $admin_phrases[template][editor_design][title];
    $tmp[description] = $admin_phrases[template][editor_design][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "style";
        $tmp[help][0][text] = $admin_phrases[template][editor_design][help_1];
        $tmp[help][1][tag] = "text";
        $tmp[help][1][text] = $admin_phrases[template][editor_design][help_2];
        $tmp[help][2][tag] = "buttons";
        $tmp[help][2][text] = $admin_phrases[template][editor_design][help_3];
        $tmp[help][3][tag] = "smilies";
        $tmp[help][3][text] = "Bindet das Smilie Template ein";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
        
//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>