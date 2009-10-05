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

    $TEMPLATE_GO = "tpl_articles";
    $TEMPLATE_FILE = "0_articles.tpl";
    $TEMPLATE_EDIT = null;

    $tmp[name] = "artikel_autor";
    $tmp[title] = $admin_phrases[template][artikel_autor][title];
    $tmp[description] = $admin_phrases[template][artikel_autor][description];
    $tmp[rows] = "4";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{user_name}";
        $tmp[help][0][text] = $admin_phrases[template][artikel_autor][help_1];
        $tmp[help][1][tag] = "{user_id}";
        $tmp[help][1][text] = $admin_phrases[template][artikel_autor][help_2];
        $tmp[help][2][tag] = "{profile_url}";
        $tmp[help][2][text] = $admin_phrases[template][artikel_autor][help_3];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "artikel_body";
    $tmp[title] = $admin_phrases[template][artikel_body][title];
    $tmp[description] = $admin_phrases[template][artikel_body][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{title}";
        $tmp[help][0][text] = $admin_phrases[template][artikel_body][help_1];
        $tmp[help][1][tag] = "{date}";
        $tmp[help][1][text] = $admin_phrases[template][artikel_body][help_2];
        $tmp[help][2][tag] = "{text}";
        $tmp[help][2][text] = $admin_phrases[template][artikel_body][help_3];
        $tmp[help][3][tag] = "{author_template}";
        $tmp[help][3][text] = $admin_phrases[template][artikel_body][help_4];
        $tmp[help][4][tag] = "{user_name}";
        $tmp[help][4][text] = $admin_phrases[template][artikel_body][help_5];
        $tmp[help][5][tag] = "{user_id}";
        $tmp[help][5][text] = $admin_phrases[template][artikel_body][help_6];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
        
//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>