<?php
########################################
#### explanation of editor creation ####
########################################
/*
    $TEMPLATE_GO = ""; //$_GET-variable "go", important to stay at the same page ;)

    $TEMPLATE_EDIT[0][name] = "name"; //name of the template's db-entry
    $TEMPLATE_EDIT[0][title] = "title"; //title of the template
    $TEMPLATE_EDIT[0][description] = "description"; //short description of what the template is for
    $TEMPLATE_EDIT[0][rows] = "x"; //number of rows of the textarea
    $TEMPLATE_EDIT[0][cols] = "y"; //number of cols of the textarea
        $TEMPLATE_EDIT[0][help][0][tag] = "{tag}"; //{tag}s which may be used in the template
        $TEMPLATE_EDIT[0][help][0][text] = "text"; //description of the tag, shown at the tooltip
        $TEMPLATE_EDIT[0][help][...][tag] = "{tag}"; //continue with numbers after [help]
        $TEMPLATE_EDIT[0][help][...][text] = "text"; //to add more possible tags

    $TEMPLATE_EDIT[1] = false; //creates a vertcal bar to separate templates

    $TEMPLATE_EDIT[...][name] = "..."; //continue with the numbers after $TEMPLATE_EDIT to add more template-editors
    ...
*/
##########################################
#### / explanation of editor creation ####
##########################################

    $TEMPLATE_GO = "dltemplate";

    $TEMPLATE_EDIT[0][name] = "dl_search_field";
    $TEMPLATE_EDIT[0][title] = $admin_phrases[template][dl_search_field][title];
    $TEMPLATE_EDIT[0][description] = $admin_phrases[template][dl_search_field][description];
    $TEMPLATE_EDIT[0][rows] = "15";
    $TEMPLATE_EDIT[0][cols] = "66";
        $TEMPLATE_EDIT[0][help][0][tag] = "{input_cat}";
        $TEMPLATE_EDIT[0][help][0][text] = $admin_phrases[template][dl_search_field][help_1];
        $TEMPLATE_EDIT[0][help][1][tag] = "{keyword}";
        $TEMPLATE_EDIT[0][help][1][text] = $admin_phrases[template][dl_search_field][help_2];
        $TEMPLATE_EDIT[0][help][2][tag] = "{all_url}";
        $TEMPLATE_EDIT[0][help][2][text] = $admin_phrases[template][dl_search_field][help_3];

    $TEMPLATE_EDIT[1][name] = "dl_navigation";
    $TEMPLATE_EDIT[1][title] = $admin_phrases[template][dl_navigation][title];
    $TEMPLATE_EDIT[1][description] = $admin_phrases[template][dl_navigation][description];
    $TEMPLATE_EDIT[1][rows] = "5";
    $TEMPLATE_EDIT[1][cols] = "66";
        $TEMPLATE_EDIT[1][help][0][tag] = "{icon}";
        $TEMPLATE_EDIT[1][help][0][text] = $admin_phrases[template][dl_navigation][help_1];
        $TEMPLATE_EDIT[1][help][1][tag] = "{kategorie_url}";
        $TEMPLATE_EDIT[1][help][1][text] = $admin_phrases[template][dl_navigation][help_2];
        $TEMPLATE_EDIT[1][help][2][tag] = "{kategorie_name}";
        $TEMPLATE_EDIT[1][help][2][text] = $admin_phrases[template][dl_navigation][help_3];

    $TEMPLATE_EDIT[2][name] = "dl_quick_links";
    $TEMPLATE_EDIT[2][title] = $admin_phrases[template][dl_quick_links][title];
    $TEMPLATE_EDIT[2][description] = $admin_phrases[template][dl_quick_links][description];
    $TEMPLATE_EDIT[2][rows] = "5";
    $TEMPLATE_EDIT[2][cols] = "66";
        $TEMPLATE_EDIT[2][help][0][tag] = "{datum}";
        $TEMPLATE_EDIT[2][help][0][text] = $admin_phrases[template][dl_quick_links][help_1];
        $TEMPLATE_EDIT[2][help][1][tag] = "{url}";
        $TEMPLATE_EDIT[2][help][1][text] = $admin_phrases[template][dl_quick_links][help_2];
        $TEMPLATE_EDIT[2][help][2][tag] = "{name}";
        $TEMPLATE_EDIT[2][help][2][text] = $admin_phrases[template][dl_quick_links][help_3];

    $TEMPLATE_EDIT[3] = false;

    $TEMPLATE_EDIT[4][name] = "dl_datei_preview";
    $TEMPLATE_EDIT[4][title] = $admin_phrases[template][dl_datei_preview][title];
    $TEMPLATE_EDIT[4][description] = $admin_phrases[template][dl_datei_preview][description];
    $TEMPLATE_EDIT[4][rows] = "10";
    $TEMPLATE_EDIT[4][cols] = "66";
        $TEMPLATE_EDIT[4][help][0][tag] = "{name}";
        $TEMPLATE_EDIT[4][help][0][text] = $admin_phrases[template][dl_datei_preview][help_1];
        $TEMPLATE_EDIT[4][help][1][tag] = "{url}";
        $TEMPLATE_EDIT[4][help][1][text] = $admin_phrases[template][dl_datei_preview][help_2];
        $TEMPLATE_EDIT[4][help][2][tag] = "{cat}";
        $TEMPLATE_EDIT[4][help][2][text] = $admin_phrases[template][dl_datei_preview][help_3];
        $TEMPLATE_EDIT[4][help][3][tag] = "{datum}";
        $TEMPLATE_EDIT[4][help][3][text] = $admin_phrases[template][dl_datei_preview][help_4];
        $TEMPLATE_EDIT[4][help][4][tag] = "{text}";
        $TEMPLATE_EDIT[4][help][4][text] = $admin_phrases[template][dl_datei_preview][help_5];

    $TEMPLATE_EDIT[5][name] = "dl_body";
    $TEMPLATE_EDIT[5][title] = $admin_phrases[template][dl_body][title];
    $TEMPLATE_EDIT[5][description] = $admin_phrases[template][dl_body][description];
    $TEMPLATE_EDIT[5][rows] = "20";
    $TEMPLATE_EDIT[5][cols] = "66";
        $TEMPLATE_EDIT[5][help][0][tag] = "{navigation}";
        $TEMPLATE_EDIT[5][help][0][text] = $admin_phrases[template][dl_body][help_1];
        $TEMPLATE_EDIT[5][help][1][tag] = "{suchfeld}";
        $TEMPLATE_EDIT[5][help][1][text] = $admin_phrases[template][dl_body][help_2];
        $TEMPLATE_EDIT[5][help][2][tag] = "{dateien}";
        $TEMPLATE_EDIT[5][help][2][text] = $admin_phrases[template][dl_body][help_3];

    $TEMPLATE_EDIT[6] = false;

    $TEMPLATE_EDIT[7][name] = "dl_file";
    $TEMPLATE_EDIT[7][title] = $admin_phrases[template][dl_file][title];
    $TEMPLATE_EDIT[7][description] = $admin_phrases[template][dl_file][description];
    $TEMPLATE_EDIT[7][rows] = "10";
    $TEMPLATE_EDIT[7][cols] = "66";
        $TEMPLATE_EDIT[7][help][0][tag] = "{name}";
        $TEMPLATE_EDIT[7][help][0][text] = $admin_phrases[template][dl_file][help_1];
        $TEMPLATE_EDIT[7][help][1][tag] = "{url}";
        $TEMPLATE_EDIT[7][help][1][text] = $admin_phrases[template][dl_file][help_2];
        $TEMPLATE_EDIT[7][help][2][tag] = "{size}";
        $TEMPLATE_EDIT[7][help][2][text] = $admin_phrases[template][dl_file][help_3];
        $TEMPLATE_EDIT[7][help][3][tag] = "{traffic}";
        $TEMPLATE_EDIT[7][help][3][text] = $admin_phrases[template][dl_file][help_4];
        $TEMPLATE_EDIT[7][help][4][tag] = "{hits}";
        $TEMPLATE_EDIT[7][help][4][text] = $admin_phrases[template][dl_file][help_5];
        $TEMPLATE_EDIT[7][help][5][tag] = "{mirror_ext}";
        $TEMPLATE_EDIT[7][help][5][text] = $admin_phrases[template][dl_file][help_6];
        $TEMPLATE_EDIT[7][help][6][tag] = "{mirror_col}";
        $TEMPLATE_EDIT[7][help][6][text] = $admin_phrases[template][dl_file][help_7];

    $TEMPLATE_EDIT[8][name] = "dl_stats";
    $TEMPLATE_EDIT[8][title] = $admin_phrases[template][dl_stats][title];
    $TEMPLATE_EDIT[8][description] = $admin_phrases[template][dl_stats][description];
    $TEMPLATE_EDIT[8][rows] = "10";
    $TEMPLATE_EDIT[8][cols] = "66";
        $TEMPLATE_EDIT[8][help][0][tag] = "{number}";
        $TEMPLATE_EDIT[8][help][0][text] = $admin_phrases[template][dl_stats][help_1];
        $TEMPLATE_EDIT[8][help][1][tag] = "{size}";
        $TEMPLATE_EDIT[8][help][1][text] = $admin_phrases[template][dl_stats][help_2];
        $TEMPLATE_EDIT[8][help][2][tag] = "{traffic}";
        $TEMPLATE_EDIT[8][help][2][text] = $admin_phrases[template][dl_stats][help_3];
        $TEMPLATE_EDIT[8][help][3][tag] = "{hits}";
        $TEMPLATE_EDIT[8][help][3][text] = $admin_phrases[template][dl_stats][help_4];

    $TEMPLATE_EDIT[9][name] = "dl_file_is_mirror";
    $TEMPLATE_EDIT[9][title] = "Mirror";
    $TEMPLATE_EDIT[9][description] = "Anzeige, falls das File ein Mirror ist.";
    $TEMPLATE_EDIT[9][rows] = "5";
    $TEMPLATE_EDIT[9][cols] = "66";

    $TEMPLATE_EDIT[10][name] = "dl_file_body";
    $TEMPLATE_EDIT[10][title] = "Datei Body";
    $TEMPLATE_EDIT[10][description] = "Detailseite eines Downloads.";
    $TEMPLATE_EDIT[10][rows] = "25";
    $TEMPLATE_EDIT[10][cols] = "66";
        $TEMPLATE_EDIT[10][help][0][tag] = "{}";
        $TEMPLATE_EDIT[10][help][0][text] = "";
        $TEMPLATE_EDIT[10][help][1][tag] = "{}";
        $TEMPLATE_EDIT[10][help][1][text] = "";
        $TEMPLATE_EDIT[10][help][2][tag] = "{}";
        $TEMPLATE_EDIT[10][help][2][text] = "";
        
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