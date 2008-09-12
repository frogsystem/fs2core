13.09.2008<?php
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

    //continue with new templates
    ...
*/
##########################################
#### / explanation of editor creation ####
##########################################

    $TEMPLATE_GO = "tpl_partner";
    unset($tmp);

    $tmp[name] = "partner_eintrag";
    $tmp[title] = $admin_phrases[template][partner_eintrag][title];
    $tmp[description] = $admin_phrases[template][partner_eintrag][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{url}";
        $tmp[help][0][text] = $admin_phrases[template][partner_eintrag][help_1];
        $tmp[help][1][tag] = "{img_url}";
        $tmp[help][1][text] = $admin_phrases[template][partner_eintrag][help_2];
        $tmp[help][2][tag] = "{button_url}";
        $tmp[help][2][text] = $admin_phrases[template][partner_eintrag][help_3];
        $tmp[help][3][tag] = "{name}";
        $tmp[help][3][text] = $admin_phrases[template][partner_eintrag][help_4];
        $tmp[help][4][tag] = "{text}";
        $tmp[help][4][text] = $admin_phrases[template][partner_eintrag][help_5];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "partner_main_body";
    $tmp[title] = $admin_phrases[template][partner_main_body][title];
    $tmp[description] = $admin_phrases[template][partner_main_body][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{partner_all}";
        $tmp[help][0][text] = $admin_phrases[template][partner_main_body][help_1];
        $tmp[help][1][tag] = "{permanents}";
        $tmp[help][1][text] = $admin_phrases[template][partner_main_body][help_2];
        $tmp[help][2][tag] = "{non_permanents}";
        $tmp[help][2][text] = $admin_phrases[template][partner_main_body][help_3];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "partner_navi_eintrag";
    $tmp[title] = $admin_phrases[template][partner_navi_eintrag][title];
    $tmp[description] = $admin_phrases[template][partner_navi_eintrag][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{url}";
        $tmp[help][0][text] = $admin_phrases[template][partner_eintrag][help_1];
        $tmp[help][1][tag] = "{img_url}";
        $tmp[help][1][text] = $admin_phrases[template][partner_eintrag][help_2];
        $tmp[help][2][tag] = "{button_url}";
        $tmp[help][2][text] = $admin_phrases[template][partner_eintrag][help_3];
        $tmp[help][3][tag] = "{name}";
        $tmp[help][3][text] = $admin_phrases[template][partner_eintrag][help_4];
        $tmp[help][4][tag] = "{text}";
        $tmp[help][4][text] = $admin_phrases[template][partner_eintrag][help_5];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "partner_navi_body";
    $tmp[title] = $admin_phrases[template][partner_navi_body][title];
    $tmp[description] = $admin_phrases[template][partner_navi_body][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{partner_all}";
        $tmp[help][0][text] = $admin_phrases[template][partner_main_body][help_1];
        $tmp[help][1][tag] = "{permanents}";
        $tmp[help][1][text] = $admin_phrases[template][partner_main_body][help_2];
        $tmp[help][2][tag] = "{non_permanents}";
        $tmp[help][2][text] = $admin_phrases[template][partner_main_body][help_3];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO);
?>