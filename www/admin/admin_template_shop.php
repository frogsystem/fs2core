<?php
########################################
#### explanation of editor creation ####
########################################
/*
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


    $TEMPLATE_GO = "shoptemplate";

    $TEMPLATE_EDIT[0][name] = "shop_hot";
    $TEMPLATE_EDIT[0][title] = "Hot Link";
    $TEMPLATE_EDIT[0][description] = "Hot Link für die rechte Menü Leiste.";
    $TEMPLATE_EDIT[0][rows] = "5";
    $TEMPLATE_EDIT[0][cols] = "66";
        $TEMPLATE_EDIT[0][help][0][tag] = "{titel}";
        $TEMPLATE_EDIT[0][help][0][text] = "Name des Artikels.";
        $TEMPLATE_EDIT[0][help][1][tag] = "{thumb}";
        $TEMPLATE_EDIT[0][help][1][text] = "URL des Produkt-Vorschaubildes.";
        $TEMPLATE_EDIT[0][help][2][tag] = "{link}";
        $TEMPLATE_EDIT[0][help][2][text] = "URL zum Produkt im jeweiligen Shop.";
        

    $TEMPLATE_EDIT[1][name] = "shop_body";
    $TEMPLATE_EDIT[1][title] = "Mini Shop Body";
    $TEMPLATE_EDIT[1][description] = "Mini Shop im rechten Menü.";
    $TEMPLATE_EDIT[1][rows] = "15";
    $TEMPLATE_EDIT[1][cols] = "66";
        $TEMPLATE_EDIT[1][help][0][tag] = "{hotlinks}";
        $TEMPLATE_EDIT[1][help][0][text] = "Bindet nacheinander die einzelnen Produkt-Hotlinks ein.";
        

    $TEMPLATE_EDIT[2][name] = "shop_artikel";
    $TEMPLATE_EDIT[2][title] = "Artikel";
    $TEMPLATE_EDIT[2][description] = "Ansicht eines Artikels.";
    $TEMPLATE_EDIT[2][rows] = "15";
    $TEMPLATE_EDIT[2][cols] = "66";
        $TEMPLATE_EDIT[2][help][0][tag] = "{titel}";
        $TEMPLATE_EDIT[2][help][0][text] = "Name des Artikels.";
        $TEMPLATE_EDIT[2][help][1][tag] = "{beschreibung}";
        $TEMPLATE_EDIT[2][help][1][text] = "Produkt-Beschreibung des Artikels.";
        $TEMPLATE_EDIT[2][help][2][tag] = "{preis}";
        $TEMPLATE_EDIT[2][help][2][text] = "Preis des Artikels (ohne Währung).";
        $TEMPLATE_EDIT[2][help][2][tag] = "{bestell_url}";
        $TEMPLATE_EDIT[2][help][2][text] = "URL zum Produkt im jeweiligen Shop.";
        $TEMPLATE_EDIT[2][help][2][tag] = "{bild}";
        $TEMPLATE_EDIT[2][help][2][text] = "URL des Produkt-Bildes.";
        $TEMPLATE_EDIT[2][help][2][tag] = "{thumbnail}";
        $TEMPLATE_EDIT[2][help][2][text] = "URL des Produkt-Vorschaubildes.";


    $TEMPLATE_EDIT[3][name] = "shop_main_body";
    $TEMPLATE_EDIT[3][title] = "Shop Body";
    $TEMPLATE_EDIT[3][description] = "Detailseite des Shops.";
    $TEMPLATE_EDIT[3][rows] = "20";
    $TEMPLATE_EDIT[3][cols] = "66";
        $TEMPLATE_EDIT[3][help][0][tag] = "{artikel}";
        $TEMPLATE_EDIT[3][help][0][text] = "Bindet nacheinander die einzelnen Produkte ein.";

        
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