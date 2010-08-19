<?php
$TEMPLATE_GO = "tpl_gallery";
$TEMPLATE_FILE = "0_gallery.tpl";
$TEMPLATE_EDIT = array();

$TEMPLATE_EDIT[] = array (
    name => "PLAYER",
    title => $TEXT['template']->get("player_player_title"),
    description => $TEXT['template']->get("player_player_desc"),
    rows => 15,
    cols => 66,
    help => array (
        array ( tag => "player", text => $TEXT['template']->get("player_player_player") ),
    )
);

// Init Template-Page
echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>