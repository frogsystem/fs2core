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

    $TEMPLATE_GO = "alltemplate";

    $TEMPLATE_EDIT[0][name] = "indexphp";
    $TEMPLATE_EDIT[0][title] = "Index.php";
    $TEMPLATE_EDIT[0][description] = "Hauptdesign der Seite";
    $TEMPLATE_EDIT[0][rows] = "15";
    $TEMPLATE_EDIT[0][cols] = "66";
        $TEMPLATE_EDIT[0][help][0][tag] = "{main_menu}";
        $TEMPLATE_EDIT[0][help][0][text] = "Bindet das Template \"Haupt Menü\" ein.";
        $TEMPLATE_EDIT[0][help][1][tag] = "{announcement}";
        $TEMPLATE_EDIT[0][help][1][text] = "Bindet die Ankündigung ein.";
        $TEMPLATE_EDIT[0][help][2][tag] = "{content}";
        $TEMPLATE_EDIT[0][help][2][text] = "Markiert die Stelle, an der Seiteninhalt eingefügt wird.";
        $TEMPLATE_EDIT[0][help][3][tag] = "{user}";
        $TEMPLATE_EDIT[0][help][3][text] = "Bindet das User-Menü ein.";
        $TEMPLATE_EDIT[0][help][4][tag] = "{randompic}";
        $TEMPLATE_EDIT[0][help][4][text] = "Bindet das Zufallsbild ein.";
        $TEMPLATE_EDIT[0][help][5][tag] = "{poll}";
        $TEMPLATE_EDIT[0][help][5][text] = "Bindet das Umfragensystem ein.";
        $TEMPLATE_EDIT[0][help][6][tag] = "{stats}";
        $TEMPLATE_EDIT[0][help][6][text] = "Bindet die Statistik ein.";
        $TEMPLATE_EDIT[0][help][7][tag] = "{shop}";
        $TEMPLATE_EDIT[0][help][7][text] = "Bindet den Shop ein.";
        $TEMPLATE_EDIT[0][help][8][tag] = "{partner}";
        $TEMPLATE_EDIT[0][help][8][text] = "Bindet das Partnersystem ein.";

    $TEMPLATE_EDIT[1][name] = "error";
    $TEMPLATE_EDIT[1][title] = "Fehlermeldung";
    $TEMPLATE_EDIT[1][description] = "Systemmeldung, wenn ein Fehler auftritt";
    $TEMPLATE_EDIT[1][rows] = "15";
    $TEMPLATE_EDIT[1][cols] = "66";
        $TEMPLATE_EDIT[1][help][0][tag] = "{titel}";
        $TEMPLATE_EDIT[1][help][0][text] = "Der Titel der Systemmeldung.";
        $TEMPLATE_EDIT[1][help][1][tag] = "{meldung}";
        $TEMPLATE_EDIT[1][help][1][text] = "Der Text der Systemmeldung.";

    $TEMPLATE_EDIT[2][name] = "pic_viewer";
    $TEMPLATE_EDIT[2][title] = "Picture Viewer";
    $TEMPLATE_EDIT[2][description] = "Popup zum darstellen von Bildern";
    $TEMPLATE_EDIT[2][rows] = "25";
    $TEMPLATE_EDIT[2][cols] = "66";
        $TEMPLATE_EDIT[2][help][0][tag] = "{bannercode}";
        $TEMPLATE_EDIT[2][help][0][text] = "Bindet die Werbung ein.";
        $TEMPLATE_EDIT[2][help][1][tag] = "{weiter_grafik}";
        $TEMPLATE_EDIT[2][help][1][text] = "Bildadresse der Grafik \"images/icons/weiter.gif\".";
        $TEMPLATE_EDIT[2][help][2][tag] = "{zurück_grafik}";
        $TEMPLATE_EDIT[2][help][2][text] = "Bildadresse der Grafik \"images/icons/zurueck.gif\".";
        $TEMPLATE_EDIT[2][help][3][tag] = "{bild}";
        $TEMPLATE_EDIT[2][help][3][text] = "Bildadresse des Galerie-Bildes.";
        $TEMPLATE_EDIT[2][help][4][tag] = "{text}";
        $TEMPLATE_EDIT[2][help][4][text] = "Beschreibungs-Text des Bildes.";

    $TEMPLATE_EDIT[3][name] = "main_menu";
    $TEMPLATE_EDIT[3][title] = "Haupt Menü";
    $TEMPLATE_EDIT[3][description] = "Linke Navigationsleiste";
    $TEMPLATE_EDIT[3][rows] = "25";
    $TEMPLATE_EDIT[3][cols] = "66";
        $TEMPLATE_EDIT[3][help][0][tag] = "{virtualhost}";
        $TEMPLATE_EDIT[3][help][0][text] = "Die unter Konfiguration angegebene Adresse der Seite, auf die Links umgeschaltet werden.";
        
    $TEMPLATE_EDIT[4][name] = "community_map";
    $TEMPLATE_EDIT[4][title] = "Community Map";
    $TEMPLATE_EDIT[4][description] = "Gerüst für die Community Map";
    $TEMPLATE_EDIT[4][rows] = "15";
    $TEMPLATE_EDIT[4][cols] = "66";
        $TEMPLATE_EDIT[4][help][0][tag] = "{karte}";
        $TEMPLATE_EDIT[4][help][0][text] = "Bindet die Karte ein.";

    $TEMPLATE_EDIT[5][name] = "statistik";
    $TEMPLATE_EDIT[5][title] = "Statistik:";
    $TEMPLATE_EDIT[5][description] = "Besucher und Seiten Statistik";
    $TEMPLATE_EDIT[5][rows] = "";
    $TEMPLATE_EDIT[5][cols] = "66";
        $TEMPLATE_EDIT[5][help][0][tag] = "{visits}";
        $TEMPLATE_EDIT[5][help][0][text] = "Anzahl aller Besucher der Seite.";
        $TEMPLATE_EDIT[5][help][1][tag] = "{visits_heute}";
        $TEMPLATE_EDIT[5][help][1][text] = "Zahl aller Besucher am aktuellen Tag.";
        $TEMPLATE_EDIT[5][help][2][tag] = "{hits}";
        $TEMPLATE_EDIT[5][help][2][text] = "Anzahl aller Seitenaufrufe.";
        $TEMPLATE_EDIT[5][help][3][tag] = "{hits_heute}";
        $TEMPLATE_EDIT[5][help][3][text] = "Zahl aller Seitenaufrufe am aktuellen Tag.";
        $TEMPLATE_EDIT[5][help][4][tag] = "{user_online}";
        $TEMPLATE_EDIT[5][help][4][text] = "Zahl aller Besucher die sich zurzeit auf der Seite befinden.";
        $TEMPLATE_EDIT[5][help][5][tag] = "{news}";
        $TEMPLATE_EDIT[5][help][5][text] = "Anzahl der geschriebenen News.";
        $TEMPLATE_EDIT[5][help][6][tag] = "{user}";
        $TEMPLATE_EDIT[5][help][6][text] = "Anzahl der registrierten User.";
        $TEMPLATE_EDIT[5][help][7][tag] = "{artikel}";
        $TEMPLATE_EDIT[5][help][7][text] = "Anzahl der geschriebenen Artikel.";
        $TEMPLATE_EDIT[5][help][8][tag] = "{kommentare}";
        $TEMPLATE_EDIT[5][help][8][text] = "Anzahl der abgegebenen Kommentare.";

    $TEMPLATE_EDIT[5][name] = "announcement";
    $TEMPLATE_EDIT[5][title] = "Ankündigung";
    $TEMPLATE_EDIT[5][description] = "Globale Ankündigung auf der Seite";
    $TEMPLATE_EDIT[5][rows] = "15";
    $TEMPLATE_EDIT[5][cols] = "66";
        $TEMPLATE_EDIT[5][help][0][tag] = "{meldung}";
        $TEMPLATE_EDIT[5][help][0][text] = "Fügt die angegebene Meldung ein.";

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