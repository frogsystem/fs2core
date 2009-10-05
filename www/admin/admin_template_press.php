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

    //continue with new templates
    ...
*/
##########################################
#### / explanation of editor creation ####
##########################################

    $TEMPLATE_GO = "tpl_press";
    $TEMPLATE_FILE = "0_press.tpl";
    $TEMPLATE_EDIT = null;

    $tmp[name] = "press_navi_line";
    $tmp[title] = $admin_phrases[template][press_navi_line][title];
    $tmp[description] = $admin_phrases[template][press_navi_line][description];
    $tmp[rows] = "7";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{navi_url}";
        $tmp[help][0][text] = $admin_phrases[template][press_navi_line][help_1];
        $tmp[help][1][tag] = "{title}";
        $tmp[help][1][text] = $admin_phrases[template][press_navi_line][help_2];
        $tmp[help][2][tag] = "{img_url}";
        $tmp[help][2][text] = $admin_phrases[template][press_navi_line][help_3];
        $tmp[help][3][tag] = "{icon_url}";
        $tmp[help][3][text] = $admin_phrases[template][press_navi_line][help_4];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "press_navi_main";
    $tmp[title] = $admin_phrases[template][press_navi_main][title];
    $tmp[description] = $admin_phrases[template][press_navi_main][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{lines}";
        $tmp[help][0][text] = $admin_phrases[template][press_navi_main][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "press_intro";
    $tmp[title] = $admin_phrases[template][press_intro][title];
    $tmp[description] = $admin_phrases[template][press_intro][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{intro_text}";
        $tmp[help][0][text] = $admin_phrases[template][press_intro][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "press_note";
    $tmp[title] = $admin_phrases[template][press_note][title];
    $tmp[description] = $admin_phrases[template][press_note][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{note_text}";
        $tmp[help][0][text] = $admin_phrases[template][press_note][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;
    
    $tmp[name] = "press_body";
    $tmp[title] = $admin_phrases[template][press_body][title];
    $tmp[description] = $admin_phrases[template][press_body][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{title}";
        $tmp[help][0][text] = $admin_phrases[template][press_body][help_1];
        $tmp[help][1][tag] = "{url}";
        $tmp[help][1][text] = $admin_phrases[template][press_body][help_2];
        $tmp[help][2][tag] = "{date}";
        $tmp[help][2][text] = $admin_phrases[template][press_body][help_3];
        $tmp[help][3][tag] = "{intro}";
        $tmp[help][3][text] = $admin_phrases[template][press_body][help_4];
        $tmp[help][4][tag] = "{text}";
        $tmp[help][4][text] = $admin_phrases[template][press_body][help_5];
        $tmp[help][5][tag] = "{note}";
        $tmp[help][5][text] = $admin_phrases[template][press_body][help_6];
        $tmp[help][6][tag] = "{game_title}";
        $tmp[help][6][text] = $admin_phrases[template][press_body][help_7];
        $tmp[help][7][tag] = "{game_img_url}";
        $tmp[help][7][text] = $admin_phrases[template][press_body][help_8];
        $tmp[help][8][tag] = "{cat_title}";
        $tmp[help][8][text] = $admin_phrases[template][press_body][help_9];
        $tmp[help][9][tag] = "{cat_img_url}";
        $tmp[help][9][text] = $admin_phrases[template][press_body][help_10];
        $tmp[help][10][tag] = "{lang_title}";
        $tmp[help][10][text] = $admin_phrases[template][press_body][help_11];
        $tmp[help][11][tag] = "{lang_img_url}";
        $tmp[help][11][text] = $admin_phrases[template][press_body][help_12];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "press_container";
    $tmp[title] = $admin_phrases[template][press_container][title];
    $tmp[description] = $admin_phrases[template][press_container][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{press_releases}";
        $tmp[help][0][text] = $admin_phrases[template][press_container][help_1];

    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "press_main_body";
    $tmp[title] = $admin_phrases[template][press_main_body][title];
    $tmp[description] = $admin_phrases[template][press_main_body][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{navigation}";
        $tmp[help][0][text] = $admin_phrases[template][press_main_body][help_1];
        $tmp[help][1][tag] = "{press_container}";
        $tmp[help][1][text] = $admin_phrases[template][press_main_body][help_2];
        
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>