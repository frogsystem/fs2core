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


    $TEMPLATE_GO = "shoptemplate";
    unset($tmp); //unsets $tmp for safety-issues
    
    $tmp[name] = "shop_hot";
    $tmp[title] = "Hot Link";
    $tmp[description] = "Hot Link für die rechte Menü Leiste.";
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{titel}";
        $tmp[help][0][text] = "Name des Artikels.";
        $tmp[help][1][tag] = "{thumb}";
        $tmp[help][1][text] = "URL des Produkt-Vorschaubildes.";
        $tmp[help][2][tag] = "{link}";
        $tmp[help][2][text] = "URL zum Produkt im jeweiligen Shop.";
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "shop_body";
    $tmp[title] = "Mini Shop Body";
    $tmp[description] = "Mini Shop im rechten Menü.";
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{hotlinks}";
        $tmp[help][0][text] = "Bindet nacheinander die einzelnen Produkt-Hotlinks ein.";
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "shop_artikel";
    $tmp[title] = "Artikel";
    $tmp[description] = "Ansicht eines Artikels.";
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{titel}";
        $tmp[help][0][text] = "Name des Artikels.";
        $tmp[help][1][tag] = "{beschreibung}";
        $tmp[help][1][text] = "Produkt-Beschreibung des Artikels.";
        $tmp[help][2][tag] = "{preis}";
        $tmp[help][2][text] = "Preis des Artikels (ohne Währung).";
        $tmp[help][2][tag] = "{bestell_url}";
        $tmp[help][2][text] = "URL zum Produkt im jeweiligen Shop.";
        $tmp[help][2][tag] = "{bild}";
        $tmp[help][2][text] = "URL des Produkt-Bildes.";
        $tmp[help][2][tag] = "{thumbnail}";
        $tmp[help][2][text] = "URL des Produkt-Vorschaubildes.";
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues

    $tmp[name] = "shop_main_body";
    $tmp[title] = "Shop Body";
    $tmp[description] = "Detailseite des Shops.";
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{artikel}";
        $tmp[help][0][text] = "Bindet nacheinander die einzelnen Produkte ein.";
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues
        
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