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

    $TEMPLATE_GO = "alltemplate";
    unset($tmp);

    $tmp[name] = "error";
    $tmp[title] = $admin_phrases[template][error][title];
    $tmp[description] = $admin_phrases[template][error][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{titel}";
        $tmp[help][0][text] = $admin_phrases[template][error][help_1];
        $tmp[help][1][tag] = "{meldung}";
        $tmp[help][1][text] = $admin_phrases[template][error][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "doctype";
    $tmp[title] = $admin_phrases[template][doctype][title];
    $tmp[description] = $admin_phrases[template][doctype][description];
    $tmp[rows] = "3";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "indexphp";
    $tmp[title] = $admin_phrases[template][indexphp][title];
    $tmp[description] = $admin_phrases[template][indexphp][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{main_menu}";
        $tmp[help][0][text] = $admin_phrases[template][indexphp][help_1];
        $tmp[help][1][tag] = "{announcement}";
        $tmp[help][1][text] = $admin_phrases[template][indexphp][help_2];
        $tmp[help][2][tag] = "{content}";
        $tmp[help][2][text] = $admin_phrases[template][indexphp][help_3];
        $tmp[help][3][tag] = "{user}";
        $tmp[help][3][text] = $admin_phrases[template][indexphp][help_4];
        $tmp[help][4][tag] = "{randompic}";
        $tmp[help][4][text] = $admin_phrases[template][indexphp][help_5];
        $tmp[help][5][tag] = "{poll}";
        $tmp[help][5][text] = $admin_phrases[template][indexphp][help_6];
        $tmp[help][6][tag] = "{stats}";
        $tmp[help][6][text] = $admin_phrases[template][indexphp][help_7];
        $tmp[help][7][tag] = "{shop}";
        $tmp[help][7][text] = $admin_phrases[template][indexphp][help_8];
        $tmp[help][8][tag] = "{partner}";
        $tmp[help][8][text] = $admin_phrases[template][indexphp][help_9];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "main_menu";
    $tmp[title] = $admin_phrases[template][main_menu][title] ;
    $tmp[description] = $admin_phrases[template][main_menu][description] ;
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{virtualhost}";
        $tmp[help][0][text] = $admin_phrases[template][main_menu][help_1] ;
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $TEMPLATE_EDIT[] = false;
    
    $tmp[name] = "pic_viewer";
    $tmp[title] = $admin_phrases[template][pic_viewer][title];
    $tmp[description] = $admin_phrases[template][pic_viewer][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{next_img}";
        $tmp[help][0][text] = $admin_phrases[template][pic_viewer][help_1];
        $tmp[help][1][tag] = "{prev_img}";
        $tmp[help][1][text] = $admin_phrases[template][pic_viewer][help_2];
        $tmp[help][2][tag] = "{pic}";
        $tmp[help][2][text] = $admin_phrases[template][pic_viewer][help_3];
        $tmp[help][3][tag] = "{title}";
        $tmp[help][3][text] = $admin_phrases[template][pic_viewer][help_4];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
        
    $tmp[name] = "announcement";
    $tmp[title] = $admin_phrases[template][announcement][title];
    $tmp[description] = $admin_phrases[template][announcement][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{meldung}";
        $tmp[help][0][text] = $admin_phrases[template][announcement][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $TEMPLATE_EDIT[] = false;
    
    $tmp[name] = "statistik";
    $tmp[title] = $admin_phrases[template][statistik][title];
    $tmp[description] = $admin_phrases[template][statistik][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{visits}";
        $tmp[help][0][text] = $admin_phrases[template][statistik][help_1];
        $tmp[help][1][tag] = "{visits_heute}";
        $tmp[help][1][text] = $admin_phrases[template][statistik][help_2];
        $tmp[help][2][tag] = "{hits}";
        $tmp[help][2][text] = $admin_phrases[template][statistik][help_3];
        $tmp[help][3][tag] = "{hits_heute}";
        $tmp[help][3][text] = $admin_phrases[template][statistik][help_4];
        $tmp[help][4][tag] = "{user_online}";
        $tmp[help][4][text] = $admin_phrases[template][statistik][help_5];
        $tmp[help][5][tag] = "{news}";
        $tmp[help][5][text] = $admin_phrases[template][statistik][help_6];
        $tmp[help][6][tag] = "{user}";
        $tmp[help][6][text] = $admin_phrases[template][statistik][help_7];
        $tmp[help][7][tag] = "{artikel}";
        $tmp[help][7][text] = $admin_phrases[template][statistik][help_8];
        $tmp[help][8][tag] = "{kommentare}";
        $tmp[help][8][text] = $admin_phrases[template][statistik][help_9];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $tmp[name] = "community_map";
    $tmp[title] = $admin_phrases[template][community_map][title];
    $tmp[description] = $admin_phrases[template][community_map][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{karte}";
        $tmp[help][0][text] = $admin_phrases[template][community_map][help_1];
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