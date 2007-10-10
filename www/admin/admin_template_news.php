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

    $TEMPLATE_GO = "newstemplate";
    unset($tmp);
    
    $tmp[name] = "news_link";
    $tmp[title] = $admin_phrases[template][news_link][title];
    $tmp[description] = $admin_phrases[template][news_link][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{name}";
        $tmp[help][0][text] = $admin_phrases[template][news_link][help_1];
        $tmp[help][1][tag] = "{target}";
        $tmp[help][1][text] = $admin_phrases[template][news_link][help_2];
        $tmp[help][2][tag] = "{url}";
        $tmp[help][2][text] = $admin_phrases[template][news_link][help_3];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "news_related_links";
    $tmp[title] = $admin_phrases[template][news_related_links][title];
    $tmp[description] = $admin_phrases[template][news_related_links][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{links}";
        $tmp[help][0][text] = $admin_phrases[template][news_related_links][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "news_headline";
    $tmp[title] = $admin_phrases[template][news_headline][title];
    $tmp[description] = $admin_phrases[template][news_headline][description];
    $tmp[rows] = "7";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{titel}";
        $tmp[help][0][text] = $admin_phrases[template][news_headline][help_1];
        $tmp[help][1][tag] = "{datum}";
        $tmp[help][1][text] = $admin_phrases[template][news_headline][help_2];
        $tmp[help][2][tag] = "{url}";
        $tmp[help][2][text] = $admin_phrases[template][news_headline][help_3];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "news_headline_body";
    $tmp[title] = $admin_phrases[template][news_headline_body][title];
    $tmp[description] = $admin_phrases[template][news_headline_body][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{headlines}";
        $tmp[help][0][text] = $admin_phrases[template][news_headline_body][help_1];
        $tmp[help][1][tag] = "{downloads}";
        $tmp[help][1][text] = $admin_phrases[template][news_headline_body][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "news_body";
    $tmp[title] = $admin_phrases[template][news_body][title];
    $tmp[description] = $admin_phrases[template][news_body][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{newsid}";
        $tmp[help][0][text] = $admin_phrases[template][news_body][help_1];
        $tmp[help][1][tag] = "{titel}";
        $tmp[help][1][text] = $admin_phrases[template][news_body][help_2];
        $tmp[help][2][tag] = "{datum}";
        $tmp[help][2][text] = $admin_phrases[template][news_body][help_3];
        $tmp[help][3][tag] = "{text}";
        $tmp[help][3][text] = $admin_phrases[template][news_body][help_4];
        $tmp[help][4][tag] = "{autor}";
        $tmp[help][4][text] = $admin_phrases[template][news_body][help_5];
        $tmp[help][5][tag] = "{autor_profilurl}";
        $tmp[help][5][text] = $admin_phrases[template][news_body][help_6];
        $tmp[help][6][tag] = "{kategorie_bildname}";
        $tmp[help][6][text] = $admin_phrases[template][news_body][help_7];
        $tmp[help][7][tag] = "{kategorie_name}";
        $tmp[help][7][text] = $admin_phrases[template][news_body][help_8];
        $tmp[help][8][tag] = "{kommentar_url}";
        $tmp[help][8][text] = $admin_phrases[template][news_body][help_9];
        $tmp[help][9][tag] = "{kommentar_anzahl}";
        $tmp[help][9][text] = $admin_phrases[template][news_body][help_10];
        $tmp[help][10][tag] = "{related_links}";
        $tmp[help][10][text] = $admin_phrases[template][news_body][help_11];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "news_container";
    $tmp[title] = $admin_phrases[template][news_container][title];
    $tmp[description] = $admin_phrases[template][news_container][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{news}";
        $tmp[help][0][text] = $admin_phrases[template][news_body][help_1];
        $tmp[help][1][tag] = "{headlines}";
        $tmp[help][1][text] = $admin_phrases[template][news_body][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "news_comment_container";
    $tmp[title] = $admin_phrases[template][news_comment_container][title];
    $tmp[description] = $admin_phrases[template][news_comment_container][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{news}";
        $tmp[help][0][text] = $admin_phrases[template][news_comment_container][help_1];
        $tmp[help][1][tag] = "{comments}";
        $tmp[help][1][text] = $admin_phrases[template][news_comment_container][help_2];;
        $tmp[help][2][tag] = "{comment_form}";
        $tmp[help][2][text] = $admin_phrases[template][news_comment_container][help_3];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $tmp[name] = "news_comment_body";
    $tmp[title] = $admin_phrases[template][news_comment_body][title];
    $tmp[description] = $admin_phrases[template][news_comment_body][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{titel}";
        $tmp[help][0][text] = $admin_phrases[template][news_comment_body][help_1];
        $tmp[help][1][tag] = "{datum}";
        $tmp[help][1][text] = $admin_phrases[template][news_comment_body][help_2];
        $tmp[help][2][tag] = "{text}";
        $tmp[help][2][text] = $admin_phrases[template][news_comment_body][help_3];
        $tmp[help][3][tag] = "{autor}";
        $tmp[help][3][text] = $admin_phrases[template][news_comment_body][help_4];
        $tmp[help][4][tag] = "{autor_avatar}";
        $tmp[help][4][text] = $admin_phrases[template][news_comment_body][help_5];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "news_comment_autor";
    $tmp[title] = $admin_phrases[template][news_comment_autor][title];
    $tmp[description] = $admin_phrases[template][news_comment_autor][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{name}";
        $tmp[help][0][text] = $admin_phrases[template][news_comment_autor][help_1];
        $tmp[help][1][tag] = "{url}";
        $tmp[help][1][text] = $admin_phrases[template][news_comment_autor][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;
    
    $tmp[name] = "news_comment_form_spam";
    $tmp[title] = $admin_phrases[template][news_comment_form_spam][title];
    $tmp[description] = $admin_phrases[template][news_comment_form_spam][description];
    $tmp[rows] = "7";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{captcha_url}";
        $tmp[help][0][text] = $admin_phrases[template][news_comment_form_spam][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "news_comment_form_spamtext";
    $tmp[title] = $admin_phrases[template][news_comment_form_spamtext][title];
    $tmp[description] = $admin_phrases[template][news_comment_form_spamtext][description];
    $tmp[rows] = "7";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "news_comment_form_name";
    $tmp[title] = $admin_phrases[template][news_comment_form_name][title];
    $tmp[description] = $admin_phrases[template][news_comment_form_name][description];
    $tmp[rows] = "4";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "news_comment_form";
    $tmp[title] = $admin_phrases[template][news_comment_form][title];
    $tmp[description] = $admin_phrases[template][news_comment_form][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{newsid}";
        $tmp[help][0][text] = $admin_phrases[template][news_comment_form][help_1];
        $tmp[help][1][tag] = "{name_input}";
        $tmp[help][1][text] = $admin_phrases[template][news_comment_form][help_2];
        $tmp[help][2][tag] = "{antispam}";
        $tmp[help][2][text] = $admin_phrases[template][news_comment_form][help_3];
        $tmp[help][3][tag] = "{antispamtext}";
        $tmp[help][3][text] = $admin_phrases[template][news_comment_form][help_4];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "news_search_form";
    $tmp[title] = $admin_phrases[template][news_search_form][title];
    $tmp[description] = $admin_phrases[template][news_search_form][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{years}";
        $tmp[help][0][text] = $admin_phrases[template][news_search_form][help_1];
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