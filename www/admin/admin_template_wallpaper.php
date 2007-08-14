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

    $TEMPLATE_GO = "wallpapertemplate";
    unset($tmp);

    $tmp[name] = "wallpaper_pic";
    $tmp[title] = $admin_phrases[template][wallpaper_pic][title];
    $tmp[description] = $admin_phrases[template][wallpaper_pic][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{thumb_url}";
        $tmp[help][0][text] = $admin_phrases[template][wallpaper_pic][help_1];
        $tmp[help][1][tag] = "{text}";
        $tmp[help][1][text] = $admin_phrases[template][wallpaper_pic][help_2];
        $tmp[help][2][tag] = "{sizes}";
        $tmp[help][2][text] = $admin_phrases[template][wallpaper_pic][help_3];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "wallpaper_sizes";
    $tmp[title] = $admin_phrases[template][wallpaper_sizes][title];
    $tmp[description] = $admin_phrases[template][wallpaper_sizes][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{url}";
        $tmp[help][0][text] = $admin_phrases[template][wallpaper_sizes][help_1];
        $tmp[help][1][tag] = "{size}";
        $tmp[help][1][text] = $admin_phrases[template][wallpaper_sizes][help_2];
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