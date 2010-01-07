<?php

    $TEMPLATE_GO = "tpl_press";
    $TEMPLATE_FILE = "0_press.tpl";
    $TEMPLATE_EDIT = null;

    $tmp[name] = "NAVIGATION_LINE";
    $tmp[title] = $admin_phrases[template][press_navi_line][title];
    $tmp[description] = $admin_phrases[template][press_navi_line][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "navi_url";
        $tmp[help][0][text] = $admin_phrases[template][press_navi_line][help_1];
        $tmp[help][1][tag] = "title";
        $tmp[help][1][text] = $admin_phrases[template][press_navi_line][help_2];
        $tmp[help][2][tag] = "img_url";
        $tmp[help][2][text] = $admin_phrases[template][press_navi_line][help_3];
        $tmp[help][3][tag] = "icon_url";
        $tmp[help][3][text] = $admin_phrases[template][press_navi_line][help_4];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "NAVIGATION";
    $tmp[title] = $admin_phrases[template][press_navi_main][title];
    $tmp[description] = $admin_phrases[template][press_navi_main][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "lines";
        $tmp[help][0][text] = $admin_phrases[template][press_navi_main][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "ENTRY_INTRO";
    $tmp[title] = $admin_phrases[template][press_intro][title];
    $tmp[description] = $admin_phrases[template][press_intro][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "intro_text";
        $tmp[help][0][text] = $admin_phrases[template][press_intro][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "ENTRY_NOTE";
    $tmp[title] = $admin_phrases[template][press_note][title];
    $tmp[description] = $admin_phrases[template][press_note][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "note_text";
        $tmp[help][0][text] = $admin_phrases[template][press_note][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $tmp[name] = "ENTRY_BODY";
    $tmp[title] = $admin_phrases[template][press_body][title];
    $tmp[description] = $admin_phrases[template][press_body][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "title";
        $tmp[help][0][text] = $admin_phrases[template][press_body][help_1];
        $tmp[help][1][tag] = "url";
        $tmp[help][1][text] = $admin_phrases[template][press_body][help_2];
        $tmp[help][2][tag] = "date";
        $tmp[help][2][text] = $admin_phrases[template][press_body][help_3];
        $tmp[help][3][tag] = "intro";
        $tmp[help][3][text] = $admin_phrases[template][press_body][help_4];
        $tmp[help][4][tag] = "text";
        $tmp[help][4][text] = $admin_phrases[template][press_body][help_5];
        $tmp[help][5][tag] = "note";
        $tmp[help][5][text] = $admin_phrases[template][press_body][help_6];
        $tmp[help][6][tag] = "game_title";
        $tmp[help][6][text] = $admin_phrases[template][press_body][help_7];
        $tmp[help][7][tag] = "game_img_url";
        $tmp[help][7][text] = $admin_phrases[template][press_body][help_8];
        $tmp[help][8][tag] = "cat_title";
        $tmp[help][8][text] = $admin_phrases[template][press_body][help_9];
        $tmp[help][9][tag] = "cat_img_url";
        $tmp[help][9][text] = $admin_phrases[template][press_body][help_10];
        $tmp[help][10][tag] = "lang_title";
        $tmp[help][10][text] = $admin_phrases[template][press_body][help_11];
        $tmp[help][11][tag] = "lang_img_url";
        $tmp[help][11][text] = $admin_phrases[template][press_body][help_12];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "ENTRY_CONTAINER";
    $tmp[title] = $admin_phrases[template][press_container][title];
    $tmp[description] = $admin_phrases[template][press_container][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "press_releases";
        $tmp[help][0][text] = $admin_phrases[template][press_container][help_1];

    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp[name] = "BODY";
    $tmp[title] = $admin_phrases[template][press_main_body][title];
    $tmp[description] = $admin_phrases[template][press_main_body][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "navigation";
        $tmp[help][0][text] = $admin_phrases[template][press_main_body][help_1];
        $tmp[help][1][tag] = "press_container";
        $tmp[help][1][text] = $admin_phrases[template][press_main_body][help_2];
        
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>