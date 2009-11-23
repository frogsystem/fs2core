<?php
########################################
#### explanation of editor creation ####
########################################
/*
    $TEMPLATE_GO = ""; //$_GET-variable "go", important to stay at the same page ;)
    $TEMPLATE_FILE = ""; //TPL-File to be used in this template-page
    $TEMPLATE_EDIT = null; //Set to null for security-issues

    $tmp = array (
        name => "SYSTEMMESSAGE", //Name of the template section
        title => "text or $var", //Ttitle of the template section
        description => "text or $var", //Short description of what the template section is used for
        rows => 10, //Number of rows of the editor/Textarea
        cols => 66, //Number of cols of the Textarea, editor uses 100%
        help => array ( //Array of possible template-tags
            array ( tag => "tag_name", text => "text or $var" ), //Don't use "{.." or "..}" in tag-name, they are added autmatically
            array ( tag => "tag_name", text => "text or $var" ),
        )
    );
    $TEMPLATE_EDIT[] = $tmp; //$tmp is now saved in the template-creation-array
*/
##########################################
#### / explanation of editor creation ####
##########################################


    $TEMPLATE_GO = "tpl_general";
    $TEMPLATE_FILE = "0_general.tpl";
    $TEMPLATE_EDIT = null;


    $tmp = array (
        name => "SYSTEMMESSAGE",
        title => $admin_phrases[template][error][title],
        description => $admin_phrases[template][error][description],
        rows => 10,
        cols => 66,
        help => array (
            array ( tag => "message_title", text => $admin_phrases[template][error][help_1] ),
            array ( tag => "message", text => $admin_phrases[template][error][help_2] ),
        )
    );
    $TEMPLATE_EDIT[] = $tmp;


    $tmp = array (
        name => "FORWARDMESSAGE",
        title => $TEXT['template']->get("general_forwardmessage_title"),
        description => $admin_phrases[template][error][description],
        rows => 10,
        cols => 66,
        help => array (
            array ( tag => "message_title", text => $admin_phrases[template][error][help_1] ),
            array ( tag => "message", text => $admin_phrases[template][error][help_2] ),
        )
    );
    $TEMPLATE_EDIT[] = $tmp;
    

    $tmp = array (
        name => "DOCTYPE",
        title => $admin_phrases[template][doctype][title],
        description => $admin_phrases[template][doctype][description],
        rows => 5,
        cols => 66,
        help => array (
        )
    );
    $TEMPLATE_EDIT[] = $tmp;


    $tmp = array (
        name => "MAINPAGE",
        title => $admin_phrases[template][indexphp][title],
        description => $admin_phrases[template][indexphp][description],
        rows => 30,
        cols => 66,
        help => array (
            array ( tag => "main_menu", text => $admin_phrases[template][indexphp][help_1] ),
            array ( tag => "announcement", text => $admin_phrases[template][indexphp][help_2] ),
            array ( tag => "content", text => $admin_phrases[template][indexphp][help_3] ),
            array ( tag => "user", text => $admin_phrases[template][indexphp][help_4] ),
            array ( tag => "randompic", text => $admin_phrases[template][indexphp][help_5] ),
            array ( tag => "poll", text => $admin_phrases[template][indexphp][help_6] ),
            array ( tag => "stats", text => $admin_phrases[template][indexphp][help_7] ),
            array ( tag => "shop", text => $admin_phrases[template][indexphp][help_8] ),
            array ( tag => "partner", text => $TEXT['template']->get("general_mainpage_partner") ),
            array ( tag => "copyright", text => $TEXT['template']->get("general_mainpage_copyright") ),
        )
    );
    $TEMPLATE_EDIT[] = $tmp;



    $tmp[name] = "MENU1";
    $tmp[title] = $admin_phrases[template][main_menu][title] ;
    $tmp[description] = $admin_phrases[template][main_menu][description] ;
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "virtualhost";
        $tmp[help][0][text] = $admin_phrases[template][main_menu][help_1] ;
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    
    $tmp[name] = "PICTUREVIEWER";
    $tmp[title] = $admin_phrases[template][pic_viewer][title];
    $tmp[description] = $admin_phrases[template][pic_viewer][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "next_img";
        $tmp[help][0][text] = $admin_phrases[template][pic_viewer][help_1];
        $tmp[help][1][tag] = "prev_img";
        $tmp[help][1][text] = $admin_phrases[template][pic_viewer][help_2];
        $tmp[help][2][tag] = "pic";
        $tmp[help][2][text] = $admin_phrases[template][pic_viewer][help_3];
        $tmp[help][3][tag] = "title";
        $tmp[help][3][text] = $admin_phrases[template][pic_viewer][help_4];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
        
    $tmp[name] = "ANNOUNCEMENT";
    $tmp[title] = $admin_phrases[template][announcement][title];
    $tmp[description] = $admin_phrases[template][announcement][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "announcement_text";
        $tmp[help][0][text] = $admin_phrases[template][announcement][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    

    
    $tmp[name] = "STATISTICS";
    $tmp[title] = $admin_phrases[template][statistik][title];
    $tmp[description] = $admin_phrases[template][statistik][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "visits";
        $tmp[help][0][text] = $admin_phrases[template][statistik][help_1];
        $tmp[help][1][tag] = "visits_heute";
        $tmp[help][1][text] = $admin_phrases[template][statistik][help_2];
        $tmp[help][2][tag] = "hits";
        $tmp[help][2][text] = $admin_phrases[template][statistik][help_3];
        $tmp[help][3][tag] = "hits_heute";
        $tmp[help][3][text] = $admin_phrases[template][statistik][help_4];
        $tmp[help][4][tag] = "user_online";
        $tmp[help][4][text] = $admin_phrases[template][statistik][help_5];
        $tmp[help][5][tag] = "news";
        $tmp[help][5][text] = $admin_phrases[template][statistik][help_6];
        $tmp[help][6][tag] = "user";
        $tmp[help][6][text] = $admin_phrases[template][statistik][help_7];
        $tmp[help][7][tag] = "artikel";
        $tmp[help][7][text] = $admin_phrases[template][statistik][help_8];
        $tmp[help][8][tag] = "kommentare";
        $tmp[help][8][text] = $admin_phrases[template][statistik][help_9];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);



//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, ensure_copyright ( "MAINPAGE" ) );
?>