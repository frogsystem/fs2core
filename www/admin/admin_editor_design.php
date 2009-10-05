<?php
########################################
#### explanation of editor creation ####
########################################
/*
    $TEMPLATE_GO = ""; //$_GET-variable "go", important to stay at the same page ;)
    unset($tmp); //unsets $tmp for safety-issues
    
    $tmp[name] = "name"; //name of the template's db-entry
    $tmp[title] = "title"; //title of the template
    $tmp[description] = "description"; //short description of what the template is for
    $tmp[rows] = "x"; //number of rows of the textarea
    $tmp[cols] = "y"; //number of cols of the textarea
        $tmp[help][0][tag] = "{tag}"; //{tag}s which may be used in the template
        $tmp[help][0][text] = "text"; //description of the tag, shown at the tooltip
        $tmp[help][...][tag] = "{tag}"; //continue with numbers after [help]
        $tmp[help][...][text] = "text"; //to add more possible tags
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues
    
    $TEMPLATE_EDIT[] = false; //creates a vertcal bar to separate templates, here is no need of $tmp

    //just continue with new templates...
    ...
*/
##########################################
#### / explanation of editor creation ####
##########################################

    if ( $go == "tpl_editor" ) {
        $TEMPLATE_GO = "tpl_editor";
    } else {
        $TEMPLATE_GO = "editor_design";
    }
    $TEMPLATE_FILE = "0_fscodes.tpl";
    $TEMPLATE_EDIT = null;
    

    $tmp[name] = "editor_button";
    $tmp[title] = $admin_phrases[template][editor_button][title];
    $tmp[description] = $admin_phrases[template][editor_button][description];
    $tmp[rows] = "7";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{img_url}";
        $tmp[help][0][text] = $admin_phrases[template][editor_button][help_1];
        $tmp[help][1][tag] = "{alt}";
        $tmp[help][1][text] = $admin_phrases[template][editor_button][help_2];
        $tmp[help][2][tag] = "{title}";
        $tmp[help][2][text] = $admin_phrases[template][editor_button][help_3];
        $tmp[help][3][tag] = "{javascript}";
        $tmp[help][3][text] = $admin_phrases[template][editor_button][help_4];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "editor_seperator";
    $tmp[title] = $admin_phrases[template][editor_seperator][title];;
    $tmp[description] = $admin_phrases[template][editor_seperator][description];
    $tmp[rows] = "3";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;
    
    $tmp[name] = "editor_design";
    $tmp[title] = $admin_phrases[template][editor_design][title];
    $tmp[description] = $admin_phrases[template][editor_design][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{style}";
        $tmp[help][0][text] = $admin_phrases[template][editor_design][help_1];
        $tmp[help][1][tag] = "{text}";
        $tmp[help][1][text] = $admin_phrases[template][editor_design][help_2];
        $tmp[help][2][tag] = "{buttons}";
        $tmp[help][2][text] = $admin_phrases[template][editor_design][help_3];
        $tmp[help][3][tag] = "{smilies}";
        $tmp[help][3][text] = $admin_phrases[template][editor_design][help_4];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "editor_css";
    $tmp[title] = $admin_phrases[template][editor_css][title];;
    $tmp[description] = $admin_phrases[template][editor_css][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
        
//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>