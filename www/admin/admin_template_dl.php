<?php

    $TEMPLATE_GO = "tpl_dl";
    $TEMPLATE_FILE = "0_downloads.tpl";
    $TEMPLATE_EDIT = null;

$TEMPLATE_EDIT[] = array (
    name => "APPLET_LINE",
    title => $TEXT['template']->get("dl_applet_line_title"),
    description => $TEXT['template']->get("dl_applet_line_desc"),
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "title", text => $TEXT['template']->get("dl_applet_line_dl_title") ),
        array ( tag => "date", text => $TEXT['template']->get("dl_applet_line_date") ),
        array ( tag => "url", text => $TEXT['template']->get("dl_applet_line_url") ),
        array ( tag => "download_id", text => $TEXT['template']->get("dl_applet_line_dl_id") ),
    )
);

    $tmp[name] = "SEARCH";
    $tmp[title] = $admin_phrases[template][dl_search_field][title];
    $tmp[description] = $admin_phrases[template][dl_search_field][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "input_cat";
        $tmp[help][0][text] = $admin_phrases[template][dl_search_field][help_1];
        $tmp[help][1][tag] = "keyword";
        $tmp[help][1][text] = $admin_phrases[template][dl_search_field][help_2];
        $tmp[help][2][tag] = "all_url";
        $tmp[help][2][text] = $admin_phrases[template][dl_search_field][help_3];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

$TEMPLATE_EDIT[] = array (
    name => "NAVIGATION_LINE",
    title => $TEXT['template']->get("dl_navigation_line_title"),
    description => $TEXT['template']->get("dl_navigation_line_desc"),
    rows => 15,
    cols => 66,
    help => array (
        array ( tag => "icon_url", text => $TEXT['template']->get("dl_navigation_line_icon_url") ),
        array ( tag => "cat_url", text => $TEXT['template']->get("dl_navigation_line_cat_url") ),
        array ( tag => "cat_name", text => $TEXT['template']->get("dl_navigation_line_cat_name") ),
    )
);

$TEMPLATE_EDIT[] = array (
    name => "NAVIGATION_BODY",
    title => $TEXT['template']->get("dl_navigation_body_title"),
    description => $TEXT['template']->get("dl_navigation_body_desc"),
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "lines", text => $TEXT['template']->get("dl_navigation_body_lines") ),
    )
);

$TEMPLATE_EDIT[] = array (
    name => "PREVIEW_LINE",
    title => $TEXT['template']->get("dl_preview_line_title"),
    description => $TEXT['template']->get("dl_preview_line_desc"),
    rows => 15,
    cols => 66,
    help => array (
        array ( tag => "title", text => $TEXT['template']->get("dl_preview_line_entry_title") ),
        array ( tag => "url", text => $TEXT['template']->get("dl_preview_line_url") ),
        array ( tag => "cat_name", text => $TEXT['template']->get("dl_preview_line_cat_name") ),
        array ( tag => "date", text => $TEXT['template']->get("dl_preview_line_date") ),
        array ( tag => "text", text => $TEXT['template']->get("dl_preview_line_text") ),
    )
);



$TEMPLATE_EDIT[] = array (
    name => "NO_PREVIEW_LINE",
    title => $TEXT['template']->get("dl_no_preview_line_title"),
    description => $TEXT['template']->get("dl_no_preview_line_desc"),
    rows => 10,
    cols => 66,
    help => array (
    )
);

$TEMPLATE_EDIT[] = array (
    name => "PREVIEW_LIST",
    title => $TEXT['template']->get("dl_preview_list_title"),
    description => $TEXT['template']->get("dl_preview_list_desc"),
    rows => 15,
    cols => 66,
    help => array (
        array ( tag => "entries", text => $TEXT['template']->get("dl_preview_list_entries") ),
        array ( tag => "page_title", text => $TEXT['template']->get("dl_page_title") ),
    )
);



$TEMPLATE_EDIT[] = array (
    name => "BODY",
    title => $TEXT['template']->get("dl_body_title"),
    description => $TEXT['template']->get("dl_body_desc"),
    rows => 20,
    cols => 66,
    help => array (
        array ( tag => "navigation", text => $TEXT['template']->get("dl_body_navigation") ),
        array ( tag => "search", text => $TEXT['template']->get("dl_body_search") ),
        array ( tag => "entries", text => $TEXT['template']->get("dl_body_entries") ),
        array ( tag => "page_title", text => $TEXT['template']->get("dl_page_title") ),
    )
);



    $tmp[name] = "ENTRY_FILE_LINE";
    $tmp[title] = $admin_phrases[template][dl_file][title];
    $tmp[description] = $admin_phrases[template][dl_file][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "name";
        $tmp[help][0][text] = $admin_phrases[template][dl_file][help_1];
        $tmp[help][1][tag] = "url";
        $tmp[help][1][text] = $admin_phrases[template][dl_file][help_2];
        $tmp[help][2][tag] = "size";
        $tmp[help][2][text] = $admin_phrases[template][dl_file][help_3];
        $tmp[help][3][tag] = "traffic";
        $tmp[help][3][text] = $admin_phrases[template][dl_file][help_4];
        $tmp[help][4][tag] = "hits";
        $tmp[help][4][text] = $admin_phrases[template][dl_file][help_5];
        $tmp[help][5][tag] = "mirror_ext";
        $tmp[help][5][text] = $admin_phrases[template][dl_file][help_6];
        $tmp[help][6][tag] = "mirror_col";
        $tmp[help][6][text] = $admin_phrases[template][dl_file][help_7];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "ENTRY_FILE_IS_MIRROR";
    $tmp[title] = $admin_phrases[template][dl_file_is_mirror][title];
    $tmp[description] = $admin_phrases[template][dl_file_is_mirror][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "ENTRY_STATISTICS";
    $tmp[title] = $admin_phrases[template][dl_stats][title];
    $tmp[description] = $admin_phrases[template][dl_stats][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "number";
        $tmp[help][0][text] = $admin_phrases[template][dl_stats][help_1];
        $tmp[help][1][tag] = "size";
        $tmp[help][1][text] = $admin_phrases[template][dl_stats][help_2];
        $tmp[help][2][tag] = "traffic";
        $tmp[help][2][text] = $admin_phrases[template][dl_stats][help_3];
        $tmp[help][3][tag] = "hits";
        $tmp[help][3][text] = $admin_phrases[template][dl_stats][help_4];
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues


$TEMPLATE_EDIT[] = array (
    name => "ENTRY_BODY",
    title => $TEXT['template']->get("dl_entry_body_title"),
    description => $TEXT['template']->get("dl_entry_body_desc"),
    rows => 25,
    cols => 66,
    help => array (
        array ( tag => "title", text => $TEXT['template']->get("dl_entry_body_entry_title") ),
        array ( tag => "img_url", text => $TEXT['template']->get("dl_entry_body_img_url") ),
        array ( tag => "thumb_url", text => $TEXT['template']->get("dl_entry_body_thumb_url") ),
        array ( tag => "viewer_link", text => $TEXT['template']->get("dl_entry_body_viewer_link") ),
        array ( tag => "navigation", text => $TEXT['template']->get("dl_entry_body_navigation") ),
        array ( tag => "search", text => $TEXT['template']->get("dl_entry_body_search") ),
        array ( tag => "uploader", text => $TEXT['template']->get("dl_entry_body_uploader") ),
        array ( tag => "uploader_url", text => $TEXT['template']->get("dl_entry_body_uploader_url") ),
        array ( tag => "author", text => $TEXT['template']->get("dl_entry_body_author") ),
        array ( tag => "author_url", text => $TEXT['template']->get("dl_entry_body_author_url") ),
        array ( tag => "author_link", text => $TEXT['template']->get("dl_entry_body_author_link") ),
        array ( tag => "date", text => $TEXT['template']->get("dl_entry_body_date") ),
        array ( tag => "cat_name", text => $TEXT['template']->get("dl_entry_body_cat_name") ),
        array ( tag => "text", text => $TEXT['template']->get("dl_entry_body_text") ),
        array ( tag => "files", text => $TEXT['template']->get("dl_entry_body_files") ),
        array ( tag => "statistics", text => $TEXT['template']->get("dl_entry_body_statistics") ),
        array ( tag => "messages", text => $TEXT['template']->get("dl_entry_body_messages") ),
        //TODO: localize texts
        array ( 'tag' => 'comments_url', 'text' => 'URL zur Kommentaransicht des Downloads' ),
        array ( 'tag' => 'comments_number', 'text' => 'Anzahl der zum Download abgegebenen Kommentare' )
    )
);


//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>