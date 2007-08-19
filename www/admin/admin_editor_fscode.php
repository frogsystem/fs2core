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

    //just continue with new templates
    ...
*/
##########################################
#### / explanation of editor creation ####
##########################################

    $TEMPLATE_GO = "editorfscode";
    unset($tmp);

    $tmp[name] = "quote_tag";
    $tmp[title] = $admin_phrases[template][quote_tag][title];
    $tmp[description] = $admin_phrases[template][quote_tag][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{text}";
        $tmp[help][0][text] = $admin_phrases[template][quote_tag][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "quote_tag_name";
    $tmp[title] = $admin_phrases[template][quote_tag_name][title];;
    $tmp[description] = $admin_phrases[template][quote_tag_name][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{text}";
        $tmp[help][0][text] = $admin_phrases[template][quote_tag_name][help_1];
        $tmp[help][1][tag] = "{author}";
        $tmp[help][1][text] = $admin_phrases[template][quote_tag_name][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;
    
    $tmp[name] = "code_tag";
    $tmp[title] = $admin_phrases[template][code_tag][title];
    $tmp[description] = $admin_phrases[template][code_tag][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{text}";
        $tmp[help][0][text] = $admin_phrases[template][code_tag][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

        
//////////////////////////
//// Intialise Editor ////
//////////////////////////

if (templatepage_postcheck($TEMPLATE_EDIT))
{
    templatepage_save($TEMPLATE_EDIT);
    systext("Template wurde aktualisiert");
}
else
{
    echo create_templatepage ($TEMPLATE_EDIT, $TEMPLATE_GO);
}
?>