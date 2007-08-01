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
    $TEMPLATE_EDIT[0] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $TEMPLATE_EDIT[1] = false; //creates a vertcal bar to separate templates, here is no need of $tmp

    //continue with new templates and just change the numbers of $TEMPLATE_EDIT at the end
    ...
*/
##########################################
#### / explanation of editor creation ####
##########################################

    $TEMPLATE_GO = "usertemplate";
    unset($tmp);
    
    $tmp[name] = "user_mini_login";
    $tmp[title] = $admin_phrases[template][user_mini_login][title];
    $tmp[description] = $admin_phrases[template][user_mini_login][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[0] = $tmp;
    unset($tmp);

    $tmp[name] = "user_user_menu";
    $tmp[title] = $admin_phrases[template][user_user_menu][title];
    $tmp[description] = $admin_phrases[template][user_user_menu][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{username}";
        $tmp[help][0][text] = $admin_phrases[template][user_user_menu][help_1] ;
        $tmp[help][1][tag] = "{admin}";
        $tmp[help][1][text] = $admin_phrases[template][user_user_menu][help_2] ;
        $tmp[help][2][tag] = "{logout}";
        $tmp[help][2][text] = $admin_phrases[template][user_user_menu][help_3] ;
    $TEMPLATE_EDIT[1] = $tmp;
    unset($tmp);

    $tmp[name] = "user_admin_link";
    $tmp[title] = $admin_phrases[template][user_admin_link][title];
    $tmp[description] = $admin_phrases[template][user_admin_link][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{adminlink}";
        $tmp[help][0][text] = $admin_phrases[template][user_admin_link][help_1];
    $TEMPLATE_EDIT[2] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[3] = false;
    unset($tmp);

    $tmp[name] = "user_login";
    $tmp[title] = $admin_phrases[template][user_login][title];
    $tmp[description] = $admin_phrases[template][user_login][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[4] = $tmp;
    unset($tmp);

    $tmp[name] = "user_register";
    $tmp[title] = $admin_phrases[template][user_register][title];
    $tmp[description] = $admin_phrases[template][user_register][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[5] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[6] = false;
    unset($tmp);

    $tmp[name] = "user_profil";
    $tmp[title] = $admin_phrases[template][user_profil][title];
    $tmp[description] = $admin_phrases[template][user_profil][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{username}";
        $tmp[help][0][text] = $admin_phrases[template][user_profil][help_1];
        $tmp[help][1][tag] = "{avatar}";
        $tmp[help][1][text] = $admin_phrases[template][user_profil][help_2];
        $tmp[help][2][tag] = "{email}";
        $tmp[help][2][text] = $admin_phrases[template][user_profil][help_3];
        $tmp[help][3][tag] = "{reg_datum}";
        $tmp[help][3][text] = $admin_phrases[template][user_profil][help_4];
        $tmp[help][4][tag] = "{news}";
        $tmp[help][4][text] = $admin_phrases[template][user_profil][help_5];
        $tmp[help][5][tag] = "{artikel}";
        $tmp[help][5][text] = $admin_phrases[template][user_profil][help_6];
        $tmp[help][6][tag] = "{kommentare}";
        $tmp[help][6][text] = $admin_phrases[template][user_profil][help_7];
    $TEMPLATE_EDIT[7] = $tmp;
    unset($tmp);

    $tmp[name] = "user_profiledit";
    $tmp[title] = $admin_phrases[template][user_profiledit][title];
    $tmp[description] = $admin_phrases[template][user_profiledit][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{username}";
        $tmp[help][0][text] = $admin_phrases[template][user_profiledit][help_1];
        $tmp[help][1][tag] = "{avatar}";
        $tmp[help][1][text] = $admin_phrases[template][user_profiledit][help_2];
        $tmp[help][2][tag] = "{email}";
        $tmp[help][2][text] = $admin_phrases[template][user_profiledit][help_3];
        $tmp[help][3][tag] = "{email_zeigen}";
        $tmp[help][3][text] = $admin_phrases[template][user_profiledit][help_4];
    $TEMPLATE_EDIT[8] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[9] = false;
    unset($tmp);
    
    $tmp[name] = "user_memberlist_body";
    $tmp[title] = $admin_phrases[template][user_memberlist_body][title];
    $tmp[description] = $admin_phrases[template][user_memberlist_body][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{members}";
        $tmp[help][0][text] = $admin_phrases[template][user_memberlist_body][help_1];
        $tmp[help][1][tag] = "{page}";
        $tmp[help][1][text] = $admin_phrases[template][user_memberlist_body][help_2];
        $tmp[help][2][tag] = "{order_name}";
        $tmp[help][2][text] = $admin_phrases[template][user_memberlist_body][help_3];
        $tmp[help][3][tag] = "{arrow_name}";
        $tmp[help][3][text] = $admin_phrases[template][user_memberlist_body][help_4];
        $tmp[help][4][tag] = "{order_regdate}";
        $tmp[help][4][text] = $admin_phrases[template][user_memberlist_body][help_5];
        $tmp[help][5][tag] = "{arrow_regdate}";
        $tmp[help][5][text] = $admin_phrases[template][user_memberlist_body][help_6];
        $tmp[help][6][tag] = "{order_news}";
        $tmp[help][6][text] = $admin_phrases[template][user_memberlist_body][help_7];
        $tmp[help][7][tag] = "{arrow_news}";
        $tmp[help][7][text] = $admin_phrases[template][user_memberlist_body][help_8];
        $tmp[help][8][tag] = "{order_articles}";
        $tmp[help][8][text] = $admin_phrases[template][user_memberlist_body][help_9];
        $tmp[help][9][tag] = "{arrow_articles}";
        $tmp[help][9][text] = $admin_phrases[template][user_memberlist_body][help_10];
        $tmp[help][10][tag] = "{order_comments}";
        $tmp[help][10][text] = $admin_phrases[template][user_memberlist_body][help_11];
        $tmp[help][11][tag] = "{arrow_comments}";
        $tmp[help][11][text] = $admin_phrases[template][user_memberlist_body][help_12];
    $TEMPLATE_EDIT[10] = $tmp;
    unset($tmp);
    
    $tmp[name] = "user_memberlist_userline";
    $tmp[title] = $admin_phrases[template][user_memberlist_userline][title];
    $tmp[description] = $admin_phrases[template][user_memberlist_userline][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{username}";
        $tmp[help][0][text] = $admin_phrases[template][user_memberlist_adminline][help_1];
        $tmp[help][1][tag] = "{userlink}";
        $tmp[help][1][text] = $admin_phrases[template][user_memberlist_adminline][help_2];
        $tmp[help][2][tag] = "{avatar}";
        $tmp[help][2][text] = $admin_phrases[template][user_memberlist_adminline][help_3];
        $tmp[help][3][tag] = "{email}";
        $tmp[help][3][text] = $admin_phrases[template][user_memberlist_adminline][help_4];
        $tmp[help][4][tag] = "{reg_date}";
        $tmp[help][4][text] = $admin_phrases[template][user_memberlist_adminline][help_5];
        $tmp[help][5][tag] = "{news}";
        $tmp[help][5][text] = $admin_phrases[template][user_memberlist_adminline][help_6];
        $tmp[help][6][tag] = "{articles}";
        $tmp[help][6][text] = $admin_phrases[template][user_memberlist_adminline][help_7];
        $tmp[help][7][tag] = "{comments}";
        $tmp[help][7][text] = $admin_phrases[template][user_memberlist_adminline][help_8];
    $TEMPLATE_EDIT[11] = $tmp;
    unset($tmp);

    $tmp[name] = "user_memberlist_adminline";
    $tmp[title] = $admin_phrases[template][user_memberlist_adminline][title];
    $tmp[description] = $admin_phrases[template][user_memberlist_adminline][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{username}";
        $tmp[help][0][text] = $admin_phrases[template][user_memberlist_adminline][help_1];
        $tmp[help][1][tag] = "{userlink}";
        $tmp[help][1][text] = $admin_phrases[template][user_memberlist_adminline][help_2];
        $tmp[help][2][tag] = "{avatar}";
        $tmp[help][2][text] = $admin_phrases[template][user_memberlist_adminline][help_3];
        $tmp[help][3][tag] = "{email}";
        $tmp[help][3][text] = $admin_phrases[template][user_memberlist_adminline][help_4];
        $tmp[help][4][tag] = "{reg_date}";
        $tmp[help][4][text] = $admin_phrases[template][user_memberlist_adminline][help_5];
        $tmp[help][5][tag] = "{news}";
        $tmp[help][5][text] = $admin_phrases[template][user_memberlist_adminline][help_6];
        $tmp[help][6][tag] = "{articles}";
        $tmp[help][6][text] = $admin_phrases[template][user_memberlist_adminline][help_7];
        $tmp[help][7][tag] = "{comments}";
        $tmp[help][7][text] = $admin_phrases[template][user_memberlist_adminline][help_8];
    $TEMPLATE_EDIT[12] = $tmp;
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