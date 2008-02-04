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

    $TEMPLATE_GO = "dltemplate";
    unset($tmp);
    
    $tmp[name] = "dl_search_field";
    $tmp[title] = $admin_phrases[template][dl_search_field][title];
    $tmp[description] = $admin_phrases[template][dl_search_field][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{input_cat}";
        $tmp[help][0][text] = $admin_phrases[template][dl_search_field][help_1];
        $tmp[help][1][tag] = "{keyword}";
        $tmp[help][1][text] = $admin_phrases[template][dl_search_field][help_2];
        $tmp[help][2][tag] = "{all_url}";
        $tmp[help][2][text] = $admin_phrases[template][dl_search_field][help_3];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "dl_navigation";
    $tmp[title] = $admin_phrases[template][dl_navigation][title];
    $tmp[description] = $admin_phrases[template][dl_navigation][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{icon}";
        $tmp[help][0][text] = $admin_phrases[template][dl_navigation][help_1];
        $tmp[help][1][tag] = "{kategorie_url}";
        $tmp[help][1][text] = $admin_phrases[template][dl_navigation][help_2];
        $tmp[help][2][tag] = "{kategorie_name}";
        $tmp[help][2][text] = $admin_phrases[template][dl_navigation][help_3];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "dl_quick_links";
    $tmp[title] = $admin_phrases[template][dl_quick_links][title];
    $tmp[description] = $admin_phrases[template][dl_quick_links][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{datum}";
        $tmp[help][0][text] = $admin_phrases[template][dl_quick_links][help_1];
        $tmp[help][1][tag] = "{url}";
        $tmp[help][1][text] = $admin_phrases[template][dl_quick_links][help_2];
        $tmp[help][2][tag] = "{name}";
        $tmp[help][2][text] = $admin_phrases[template][dl_quick_links][help_3];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "dl_datei_preview";
    $tmp[title] = $admin_phrases[template][dl_datei_preview][title];
    $tmp[description] = $admin_phrases[template][dl_datei_preview][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{name}";
        $tmp[help][0][text] = $admin_phrases[template][dl_datei_preview][help_1];
        $tmp[help][1][tag] = "{url}";
        $tmp[help][1][text] = $admin_phrases[template][dl_datei_preview][help_2];
        $tmp[help][2][tag] = "{cat}";
        $tmp[help][2][text] = $admin_phrases[template][dl_datei_preview][help_3];
        $tmp[help][3][tag] = "{datum}";
        $tmp[help][3][text] = $admin_phrases[template][dl_datei_preview][help_4];
        $tmp[help][4][tag] = "{text}";
        $tmp[help][4][text] = $admin_phrases[template][dl_datei_preview][help_5];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "dl_body";
    $tmp[title] = $admin_phrases[template][dl_body][title];
    $tmp[description] = $admin_phrases[template][dl_body][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{navigation}";
        $tmp[help][0][text] = $admin_phrases[template][dl_body][help_1];
        $tmp[help][1][tag] = "{suchfeld}";
        $tmp[help][1][text] = $admin_phrases[template][dl_body][help_2];
        $tmp[help][2][tag] = "{dateien}";
        $tmp[help][2][text] = $admin_phrases[template][dl_body][help_3];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $TEMPLATE_EDIT[] = false;

    $tmp[name] = "dl_file";
    $tmp[title] = $admin_phrases[template][dl_file][title];
    $tmp[description] = $admin_phrases[template][dl_file][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{name}";
        $tmp[help][0][text] = $admin_phrases[template][dl_file][help_1];
        $tmp[help][1][tag] = "{url}";
        $tmp[help][1][text] = $admin_phrases[template][dl_file][help_2];
        $tmp[help][2][tag] = "{size}";
        $tmp[help][2][text] = $admin_phrases[template][dl_file][help_3];
        $tmp[help][3][tag] = "{traffic}";
        $tmp[help][3][text] = $admin_phrases[template][dl_file][help_4];
        $tmp[help][4][tag] = "{hits}";
        $tmp[help][4][text] = $admin_phrases[template][dl_file][help_5];
        $tmp[help][5][tag] = "{mirror_ext}";
        $tmp[help][5][text] = $admin_phrases[template][dl_file][help_6];
        $tmp[help][6][tag] = "{mirror_col}";
        $tmp[help][6][text] = $admin_phrases[template][dl_file][help_7];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "dl_stats";
    $tmp[title] = $admin_phrases[template][dl_stats][title];
    $tmp[description] = $admin_phrases[template][dl_stats][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{number}";
        $tmp[help][0][text] = $admin_phrases[template][dl_stats][help_1];
        $tmp[help][1][tag] = "{size}";
        $tmp[help][1][text] = $admin_phrases[template][dl_stats][help_2];
        $tmp[help][2][tag] = "{traffic}";
        $tmp[help][2][text] = $admin_phrases[template][dl_stats][help_3];
        $tmp[help][3][tag] = "{hits}";
        $tmp[help][3][text] = $admin_phrases[template][dl_stats][help_4];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "dl_file_is_mirror";
    $tmp[title] = $admin_phrases[template][dl_file_is_mirror][title];
    $tmp[description] = $admin_phrases[template][dl_file_is_mirror][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "dl_file_body";
    $tmp[title] = $admin_phrases[template][dl_file_body][title];
    $tmp[description] = $admin_phrases[template][dl_file_body][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{title}";
        $tmp[help][0][text] = $admin_phrases[template][dl_file_body][help_1];
        $tmp[help][1][tag] = "{img_url}";
        $tmp[help][1][text] = $admin_phrases[template][dl_file_body][help_2];
        $tmp[help][2][tag] = "{thumb_url}";
        $tmp[help][2][text] = $admin_phrases[template][dl_file_body][help_3];
        $tmp[help][3][tag] = "{folder_tree}";
        $tmp[help][3][text] = $admin_phrases[template][dl_file_body][help_4];
        $tmp[help][4][tag] = "{search_field}";
        $tmp[help][4][text] = $admin_phrases[template][dl_file_body][help_5];
        $tmp[help][5][tag] = "{uploader}";
        $tmp[help][5][text] = $admin_phrases[template][dl_file_body][help_6];
        $tmp[help][6][tag] = "{uploader_url}";
        $tmp[help][6][text] = $admin_phrases[template][dl_file_body][help_7];
        $tmp[help][7][tag] = "{autor}";
        $tmp[help][7][text] = $admin_phrases[template][dl_file_body][help_8];
        $tmp[help][8][tag] = "{autor_url}";
        $tmp[help][8][text] = $admin_phrases[template][dl_file_body][help_9];
        $tmp[help][9][tag] = "{date}";
        $tmp[help][9][text] = $admin_phrases[template][dl_file_body][help_10];
        $tmp[help][10][tag] = "{cat}";
        $tmp[help][10][text] = $admin_phrases[template][dl_file_body][help_11];
        $tmp[help][11][tag] = "{text}";
        $tmp[help][11][text] = $admin_phrases[template][dl_file_body][help_12];
        $tmp[help][12][tag] = "{files}";
        $tmp[help][12][text] = $admin_phrases[template][dl_file_body][help_13];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO);
?>