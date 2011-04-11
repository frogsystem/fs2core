<?php
unset($_LANG);
$_LANG[id] = "de";



//////////////////////////////
/// Main
//////////////////////////////
unset($main);

$main[title]                            = "Frogsystem 2 - Installationsassistent";
$main[arrow]                            = '<img border="0" src="img/pointer.png" align="top" alt="->">';
$main[ok_img]                           = '<span style="font-weight:bold; color:#009933;"><img border="0" src="img/ok.gif" align="bottom" alt="Ok"></span>';
$main[error_img]                        = '<span style="font-weight:bold; color:#CC0000;"><img border="0" src="img/error.gif" align="bottom" alt="!"></span>';
$main[error]                            = 'Fehler';
$main[error_long]                       = 'Es trat ein Fehler auf';
$main[continue_install]                 = "mit der Installation fortfahren";
$main[finish_install]                   = "Installation abschließen";
$main[warning]                          = "Achtung!";
$main[optional]                         = '<span class="small">(optional)</span>';
$main[install_mail]                     = "Frogsystem 2 installiert";

$main[htaccess]                         = "Achtung! Dieser Installationsschritt ist zurzeit noch ohne Wirkung. D.h. es macht keinen Unterschied welchen der beiden Möglichkeiten Sie wählen. Wollen Sie dennoch schon die Funktionen von .htaccess verwenden, so kopieren Sie die Datei einfach aus dem Verzeichnis /install/copy in das Wurzel-Verzeichnis dieser Frogsystem 2 Installation. Anschließend müssen Sie den in der Datei verwendeten Platzhalter »{URL}« durch die Seiten-URL dieser Installation ersetzen, die Sie bereits bei einem der vorherigen Schritte angegeben haben. ";

$_LANG[main] = $main;
unset($main);



//////////////////////////////
/// Steps
//////////////////////////////
unset($steps);

$steps[start][title]                    = "Einführung";
$steps[start][progress]                 = "Start";
$steps[start][navi]                     = "Willkommen!";

$steps[start][step][1][title]           = "Einführung";
$steps[start][step][2][title]           = "Hinweise";
$steps[start][step][3][title]           = "Copyright";
$steps[start][step][4][title]           = "Change Log";

$steps[start][step][2][long_title]      = "Installationshinweise";

$steps[start][step][1][text_title]      = 'Herzlich Willkommen zum Frogsystem 2.alix5! <span class="normal">(Installationspaket)</span>';
$steps[start][step][2][text_title]      = "Sicherheitshinweise";
$steps[start][step][3][text_title]      = "Lizenzbedingungen";
$steps[start][step][4][text_title]      = "Änderungen";

$steps[start][step][1][text]            = nl2br(file_get_contents("doc/de/intro.txt"));
$steps[start][step][2][text]            = nl2br(file_get_contents("doc/de/notes.txt"));
$steps[start][step][3][text]            = nl2br(file_get_contents("doc/de/copyright.txt"));
$steps[start][step][4][text]            = nl2br(file_get_contents("doc/de/changelog.txt"));

$steps[start][step][release_title]      = "Installation starten";
$steps[start][step][release_notes]      = "Mit Begin der Installation erklären Sie sich mit unserem Copyright einverstanden und bestätigen die Installationshinweise gelesen und zur Kenntnis genommen zu haben.";
$steps[start][step][release_php]        = "<b>Fehler:</b> Die Installation ist leider nicht möglich, da mindestens PHP 5.0.0 vorausgesetzt wird.";
$steps[start][step][release_ftp]        = "<b>Hinweis:</b> Die FTP-Erweiterung für PHP wurde nicht gefunden. Sie werden deshalb einige Installationsschritte manuell ausführen müssen.";
$steps[start][step][release_mysql]      = "<b>Fehler:</b> Die Installation ist leider nicht möglich, da mindestens MySQL 4.0 vorausgesetzt wird.";
$steps[start][step][release_ok]         = "<b>Herzlichen Glückwunsch!</b> Ihr Webserver erfüllt alle Voraussetzungen für das Frogsystem&nbsp;2. Sie können jetzt mit der Installation beginnen.";
$steps[start][step][start_install]      = "Installation starten";



$steps[ftp][title]                      = "Dateizugriff";
$steps[ftp][progress]                   = "Dateizugriff";
$steps[ftp][navi]                       = "Dateizugriff";
$steps[ftp][step][1][title]             = "Berechtigungen";
$steps[ftp][step][1][long_title]        = "Berechtigungen für Dateizugriff prüfen";
$steps[ftp][step][2][title]             = "FTP-Verbindung";
$steps[ftp][step][2][long_title]        = "FTP-Logindaten angeben";
$steps[ftp][step][3][title]             = "Abschluss";
$steps[ftp][step][3][long_title]        = "Abschluss";

$steps[ftp][step][1][info_text]         = "Die <b>Berechtigungen</b> für den Zugriff auf die zur Installation erforderlichen Dateien müssen <b>geprüft</b> werden.";
$steps[ftp][step][1][no_ftp_error]      = "Die <b>Überprüfung</b> der Berechtigungen war <b>nicht erfolgreich</b>. Auf die untenstehenden Dateien und Ordner muss der Installationsassistent <b>Schreib-Zugriff</b> haben.<br><br>Bitte <b>passen</b> Sie die Zugriffs-Rechte der folgenden Dateien und Ordner an:";
$steps[ftp][step][1][button]            = "Berechtigungen prüfen";

$steps[ftp][step][2][info_text]         = "Die <b>Überprüfung</b> der Berechtigungen war <b>nicht erfolgreich</b>. Bitte geben Sie die Daten Ihres <b>FTP-Zugangs</b> an, damit die notwendigen Datei-Zugriffe über eine FTP-Verbindung realisiert werden können.";
$steps[ftp][step][2][info_text2]        = "Es wurden bereits Daten in das System eingetragen. Bitte <b>überprüfen</b> Sie deren Richtigkeit oder <b>geben</b> Sie eine andere Verbindung <b>an</b>.";
$steps[ftp][step][2][info_text3]        = "Das <b>Wurzelverzeichnis</b> wurde bereits automatisch ermittelt. Bitte <b>überprüfen</b> Sie es auf seine Richtigkeit oder <b>geben</b> Sie das korrekte Verzeichnis <b>an</b>.";
$steps[ftp][step][2][error1]            = "Es konnte <b>keine Verbindung</b> zum Server hergestellt werden. Bitte <b>überprüfen</b> Sie die angegebenen Daten. [FTPx1E1]";
$steps[ftp][step][2][error2]            = "Beim Versuch sich auf dem FTP-Server <b>anzumelden</b> trat ein Fehler auf. Bitte <b>überprüfen</b> Sie die angegebenen Daten. [FTPx1E2]";
$steps[ftp][step][2][error3]            = "Das Frogsystem wurde in dem angegebenen Verzeichnis <b>nicht gefunden</b>. Bitte <b>überprüfen</b> Sie das Wurzelverzeichnis. [FTPx1E3]";
$steps[ftp][step][2][error4]            = "Beim Versuch Dateien zu beschreiben trat ein Fehler auf. Bitte <b>überprüfen</b> Sie die Rechte Ihres FTP-Zugangs. [FTPx1E4]";
$steps[ftp][step][2][error5]            = "Bitte geben Sie <b>alle</b> Verbindungsdaten an. [FTPx1E5]";
$steps[ftp][step][2][host]              = "FTP-Host";
$steps[ftp][step][2][host_desc]         = "Host-Adresse des FTP-Servers";
$steps[ftp][step][2][port]              = "FTP-Port";
$steps[ftp][step][2][port_desc]         = "Port des FTP-Servers";
$steps[ftp][step][2][port_info]         = "verwendet <b>Port 21</b> als Standard";
$steps[ftp][step][2][user]              = "FTP-User";
$steps[ftp][step][2][user_desc]         = "Benutzer des FTP-Zugangs";
$steps[ftp][step][2][pass]              = "FTP-Passwort";
$steps[ftp][step][2][pass_desc]         = "Passwort des FTP-Zugangs";
$steps[ftp][step][2][root]              = "Wurzelverzeichnis";
$steps[ftp][step][2][root_desc]         = "Pfad zum FS2 ausgehend vom Wurzelverzeichnis des FTP-Users";
$steps[ftp][step][2][root_info]         = "z.B. <b>/cms/</b> oder <b>/frogsystem/</b> ";
$steps[ftp][step][2][button]            = "Daten speichern und fortfahren";

$steps[ftp][step][3][info_title]        = "Berechtigungen vorhanden";
$steps[ftp][step][3][info_text1]        = "Die <b>Überprüfung</b> der Berechtigungen war <b>erfolgreich</b>. Sie können nun mit der Installation fortfahren.";
$steps[ftp][step][3][info_text2]        = "Die Verbindung zum FTP-Server wurde <b>erfolgreich hergestellt</b>. Sie können nun mit der Installation fortfahren.";
$steps[ftp][step][3][info_text3]        = "Die Verbindung zum FTP-Server konnte nicht hergestellt werden. Bitte <b>überprüfen</b> Sie ihre Eingabe.";
$steps[ftp][step][3][button]            = "Dateizugriff erneut überprüfen";

$steps[database][title]                 = "Datenbank";
$steps[database][progress]              = "Datenbank";
$steps[database][navi]                  = "Datenbank";
$steps[database][step][1][title]        = "Verbindung";
$steps[database][step][1][long_title]   = "Verbindung zur Datenbank herstellen";
$steps[database][step][2][title]        = "Tabellen";
$steps[database][step][2][long_title]   = "Tabellen in Datenbank einfügen";
$steps[database][step][3][title]        = "Administrator";
$steps[database][step][3][long_title]   = "Super-Administrator Account erstellen";

$steps[database][step][1][info_text]    = "Bitte <b>geben</b> Sie die Verbindungsdaten ihrer MySQL-Datenbank <b>an</b>.";
$steps[database][step][1][info_text2]   = "Es wurden bereits Daten in das System eingetragen. Bitte <b>überprüfen</b> Sie deren Richtigkeit oder <b>geben</b> Sie eine andere Verbindung <b>an</b>.";
$steps[database][step][1][error1]       = "Es konnte keine Verbindung zur Datenbank hergestellt werden.<br>Bitte <b>überprüfen</b> Sie die angegebenen Daten.";
$steps[database][step][1][error2][1]    = "Die Datenbank konnte <b>nicht ausgewählt</b> werden oder <b>existiert nicht</b>.";
$steps[database][step][1][error2][2]    = "Folgende Datenbanken sind auf dem Server <b>verfügbar</b>:";
$steps[database][step][1][error2][3]    = "Bitte <b>geben</b> Sie eine andere Datenbank <b>an</b>.";
$steps[database][step][1][error2][4]    = "Es wurde leider keine verfügbare Datenbank gefunden. Bitte erstellen Sie zuerst eine Datenbank bevor Sie mit der Installation fortfahren.";
$steps[database][step][1][error3]       = "Bitte geben Sie <b>alle</b> Verbindungsdaten an.";
$steps[database][step][1][host]         = "MySQL-Host";
$steps[database][step][1][host_desc]    = "Host-Adresse des MySQL-Servers";
$steps[database][step][1][host_info]    = "<b>localhost</b> oder Adresse";
$steps[database][step][1][user]         = "MySQL-User";
$steps[database][step][1][user_desc]    = "Benutzer des MySQL-Zugangs";
$steps[database][step][1][data]         = "Datenbank";
$steps[database][step][1][data_desc]    = "Name der Datenbank";
$steps[database][step][1][pass]         = "Passwort";
$steps[database][step][1][pass_desc]    = "Passwort des MySQL-Zugangs";
$steps[database][step][1][button]       = "Verbindung testen und fortfahren";

$steps[database][step][2][info_text]    = "Bitte geben Sie ein Präfix an, mit dem die Tabellennamen versehen werden sollen. Es wird <b>empfohlen</b>, das Präfix <b>fs2_</b> zu verwenden.";
$steps[database][step][2][info_text2]   = "Es wurden bereits ein Präfix in das System eingetragen. Bitte <b>überprüfen</b> Sie dessen Richtigkeit oder <b>geben</b> Sie eine anderes Präfix <b>an</b>.";
$steps[database][step][2][info_text3]   = "Alternativ könne Sie auch mit der Installation <b>fortfahren</b>. Bitte beachten Sie, dass dabei vorhanden Tabellen und deren Inhalt <b>überschrieben</b> werden.";
$steps[database][step][2][error1][1]    = "Folgende Tabellen werden benötigt, aber existieren bereits mit diesem Präfix:";
$steps[database][step][2][error1][2]    = "Bitte <b>wählen</b> Sie ein anderes Tabellen-Präfix.";
$steps[database][step][2][error2]       = "Das Präfix <b>muss</b> angegeben werden und darf nicht leer sein.";

$steps[database][step][2][pref]         = "Tabellen-Präfix";
$steps[database][step][2][pref_desc]    = "Präfix vor den Tabellennamen";
$steps[database][step][2][button]       = "Präfix überprüfen und Tabellen anlegen";
$steps[database][step][2][button2]      = "Präfix übernehmen und vorhandene Tabellen überschreiben";

$steps[database][step][3][info_text]    = "Bitte legen Sie die Zugangsdaten des <b>Super-Administrator</b> Accounts fest. Dieser User besitzt alle Rechte und kann auch von anderen Administratoren <b>nicht verändert</b> werden.";
$steps[database][step][3][error1]       = "Das Passwort und die Sicherheits-Wiederholung sind <b>nicht identisch</b>. Bitte <b>geben</b> Sie zweimal das selbe Passwort <b>an</b>.";
$steps[database][step][3][error2]       = "Bitte geben Sie die gewünschten Zugangsdaten <b>vollständig</b> an.";
$steps[database][step][3][user]         = "Benutzername";
$steps[database][step][3][user_desc]    = "Gewünschter Benutzername";
$steps[database][step][3][mail]         = "E-Mail";
$steps[database][step][3][mail_desc]    = "Eine gültige E-Mail-Adresse";
$steps[database][step][3][pass]         = "Passwort";
$steps[database][step][3][pass_desc]    = "Gewünschtes Passwort";
$steps[database][step][3][pwwh]         = "Passwort wiederholen";
$steps[database][step][3][pwwh_desc]    = "Sicherheits-Wiederholung";
$steps[database][step][3][button]       = "Administrator-Account hinzufügen und fortfahren";

$steps[database][end_info]              = "Der Super-Administrator Account wurde <b>erfolgreich</b> in die Datenbank eingetragen.";
$steps[database][end_button]            = $_LANG[main][continue_install];


$steps[settings][title]                 = "Einstellungen";
$steps[settings][progress]              = "Einstellungen";
$steps[settings][navi]                  = "Einstellungen";
$steps[settings][step][1][title]        = "URL";
$steps[settings][step][1][long_title]   = "Seiten URL speichern";
$steps[settings][step][2][title]        = "Informationen";
$steps[settings][step][2][long_title]   = "Seiten-Informationen speichern";

$steps[settings][step][1][info_text]    = "Bitte <b>geben</b> Sie die Seiten URL <b>an</b>.";
$steps[settings][step][1][url]          = "Seiten URL";
$steps[settings][step][1][url_desc]     = "Die Haupt-URL der Seite";
$steps[settings][step][1][button]       = "URL speichern und fortfahren";

$steps[settings][step][2][info_text]    = "Bitte <b>geben</b> Sie einige Informationen zu Ihrer Seite <b>an</b>.";
$steps[settings][step][2][error1]       = "Bitte füllen Sie alle <b>Pflichtfelder</b> aus.";
$steps[settings][step][2][pagetitle]    = "Titel";
$steps[settings][step][2][pagetitle_desc]= "Titel der Seite im Browserfenster";
$steps[settings][step][2][mail]         = "Admin Email";
$steps[settings][step][2][mail_desc]    = "Email-Adresse, an die Probleme und Meldungen gesendet werden";
$steps[settings][step][2][desc]         = "Beschreibung";
$steps[settings][step][2][desc_desc]    = "Kurzer Text über die Seite für Suchmaschinen";
$steps[settings][step][2][author]       = "Autor";
$steps[settings][step][2][author_desc]  = "Webmaster der Seite";
$steps[settings][step][2][key]          = "Keywords";
$steps[settings][step][2][key_desc]     = "Stichwörter zur Seite, bitte mit Kommas trennen; Wichtig für Suchmaschinen!";
$steps[settings][step][2][fav]          = "Favicon verwenden";
$steps[settings][step][2][fav_desc]     = "Favicon einbinden oder nicht";
$steps[settings][step][2][fav_info]     = "([FS-Verzeichnis]/images/icons/favicon.ico)";
$steps[settings][step][2][button]       = "Informationen speichern und fortfahren";

$steps[settings][step][3][info_text]    = "Bitte <b>setzen</b> Sie die folgenden Einstellungen.";
$steps[settings][step][3][error1]       = "Bitte geben Sie alle <b>Felder</b> an.";
$steps[settings][step][3][feed]         = "Feed";
$steps[settings][step][3][feed_desc]    = "Feed der im Html-Kopf eingebunden wird";
$steps[settings][step][3][design]       = "Design";
$steps[settings][step][3][design_desc]  = "Design in dem die Seite angezeigt wird";
$steps[settings][step][3][aod]          = "Andere Designs erlauben";
$steps[settings][step][3][aod_desc]     = "Anzeigen der Seite in anderen Designs erlauben";
$steps[settings][step][3][aod_info]     = "(mit http://example.com/?design=name)";
$steps[settings][step][3][ann][title]   = "Ankündigung anzeigen";
$steps[settings][step][3][ann][desc]    = "Stellt ein wo die Ankündigung angezeigt wird";
$steps[settings][step][3][ann][every]   = "überall";
$steps[settings][step][3][ann][news]    = "nur auf der Startseite (News)";
$steps[settings][step][3][ann][never]   = "nie";
$steps[settings][step][3][spam][title]  = "Anti Spam bei Registrierung";
$steps[settings][step][3][spam][desc]   = "Anti Spam bei Registrierungen verwenden";
$steps[settings][step][3][spam][on]     = "ein";
$steps[settings][step][3][spam][off]    = "aus";
$steps[settings][step][3][date]         = "Datum";
$steps[settings][step][3][date_desc]    = "Datumsformat der Seite";
$steps[settings][step][3][date_info]    = 'verwendet den Syntax der PHP-Funktion <a href="http://www.php.net/manual/de/function.date.php" target="_blank" class="small">date()</a>';
$steps[settings][step][3][page]         = "Seitenanzeige";
$steps[settings][step][3][page_desc]    = "Design der Seitenanzeige bei mehrseitigen Modulen";
$steps[settings][step][3][page_info]    = '{page_number} = aktuelle Seite<br>{total_pages} = Seitenzahl (gesamt)<br>{prev} = Seite zurück; {next} = Seite weiter';
$steps[settings][step][3][prev]         = "Seite zurück";
$steps[settings][step][3][prev_desc]    = 'Design der "Seite zurück" Schaltfläche';
$steps[settings][step][3][prev_info]    = '{url} = URL zur vorherigen Seite';
$steps[settings][step][3][next]         = "Seiter weiter";
$steps[settings][step][3][next_desc]    = 'Design der "Seite weiter" Schaltfläche';
$steps[settings][step][3][next_info]    = '{url} = URL zur nächsten Seite';
$steps[settings][step][3][button]       = "Einstellungen speichern und fortfahren";

$steps[settings][end_title]             = "Seiten-Einstellungen";
$steps[settings][end_info]              = "Die Seiten-Einstellungen wurden <b>erfolgreich</b> gesetzt.";
$steps[settings][end_button]            = $_LANG[main][continue_install];


$steps[files][title]                    = "Dateien";
$steps[files][progress]                 = "Dateien";
$steps[files][navi]                     = "Dateien";
$steps[files][step][1][title]           = "Kopieren";
$steps[files][step][1][long_title]      = "Veränderte Dateien kopieren";
$steps[files][step][2][title]           = "Zugriffsrechte";
$steps[files][step][2][long_title]      = "Ordner-Zugriffsrechte ändern";
$steps[files][step][3][title]           = ".htaccess";
$steps[files][step][3][long_title]      = ".htaccess Einstellungen";

$steps[files][step][1][info_text]       = "Es werden nun einige <b>veränderte Dateien</b> aus dem Installations- in das Hauptverzeichnis Ihrer Webseite <b>kopiert</b>.";
$steps[files][step][1][error1]          = "Beim Kopieren der veränderten Dateien trat ein Fehler auf. Bitte <b>versuchen</b> Sie es <b>erneut</b>.";
$steps[files][step][1][button]          = "Dateien kopieren und fortfahren";

$steps[files][step][2][info_text]      = "Um das <b>Frogsystem 2</b> vollständig über das Webinterface <b>steuern</b> zu können, müssen die Zugriffsrechte für folgende Ordner überprüft werden:";
$steps[files][step][2][error]          = "Die <b>Überprüfung</b> der Zugriffsrechte war <b>nicht erfolgreich</b>.<br><br>Bitte <b>geben</b> Sie dem Frogsystem&nbsp;2 für diese Dateien und Ordner <b>Schreib-Zugriff</b>:";
$steps[files][step][2][button]          = "Zugriffsrechte prüfen und fortfahren";

$steps[files][step][2][end_title]        = "Zugriffsrechte vorhanden";
$steps[files][step][2][end_info]         = "Die <b>Überprüfung</b> der Zugriffsrechte war <b>erfolgreich</b>. Sie können nun mit der Installation fortfahren.";
$steps[files][step][2][end_button]       = $_LANG[main][continue_install];

$steps[files][step][3][info_text]       = "Das Frogsystem 2 erlaubt es durch Änderungen in der Datei <b>.htaccess</b> sog. personalisierte Fehlerseiten anzeigen zu lassen. Dafür müssen aber bestimmte Einstellungen auf Ihrem Webserver entsprechend gesetzt werden. Wenn Sie diese Funktion nutzen möchten, <b>stellen</b> Sie bitte <b>sicher</b>, dass Ihnen diese Möglichkeit zur Verfügung steht. Kontaktieren Sie ggf. auch Ihren Server- bzw. Webspace Anbieter.";
$steps[files][step][3][info_text2]      = "Wurden die Einstellungen nicht korrekt vorgenommen, kann es nach diesem Schritt zu einem <i>Error 500 (Internal Server Error)</i> kommen. In diesem Fall müssen Sie die dann in das Wurzel-Verzeichnis des Frogsystem 2 kopierte .htaccess Datei von Hand löschen und diesen Installationsassistenen erneut aufrufen.";
$steps[files][step][3][info_text3]      = "Alternativ können Sie auch fortfahren <b>ohne</b> personalisierte Fehlerseiten über <b>.htaccess</b> zu verwenden. In diesem Fall bekommen Ihre Besucher die Standard-Fehlerseite des Webservers zu sehen.";
$steps[files][step][3][further_info]    = "Weiterführende Informationen zu <b>.htaccess</b> finden Sie hier:";
$steps[files][step][3][further_url]     = "http://de.wikipedia.org/wiki/.htaccess";
$steps[files][step][3][error1]          = "";
$steps[files][step][3][button]          = ".htaccess verwenden und fortfahren";
$steps[files][step][3][button2]         = "ohne Verwendung von .htaccess fortfahren";

$steps[files][end_title]                = "Dateien";
$steps[files][end_info]                 = "Die Änderungen am Dateisystem wurden <b>erfolgreich</b> abgeschlossen.";
$steps[files][end_button]               = $_LANG[main][finish_install];


$steps[end][title]                      = "Abschluss";
$steps[end][progress]                   = "Abschluss";
$steps[end][navi]                       = "Abschluss";
$steps[end][link]                       = "Installationsassistenten beenden und zur Seite wechseln";
$steps[end][link_info]                  = 'Aus Sicherheitsgründen sollten Sie das zuerst das Installationsverzeichnis <b>[FS]/install</b> löschen, und dann die Seite vollständig in Betrieb nehmen.';
$steps[end][link_admin]                 = "Das <b>Administrator-Control-Panel</b> (kurz: Admin-CP) erreichen Sie über folgenden Link:";
$steps[end][step][1][title]             = "Bericht";
$steps[end][step][1][long_title]        = "Abschlussbericht der Installation";

$steps[end][step][1][text]              = nl2br(file_get_contents("doc/de/bericht.txt"));


$_LANG[steps] = $steps;
unset($steps);


//////////////////////////////
/// DB Insert
//////////////////////////////
unset($db_insert);

$db_insert[info_text]                   = "Die benötigten Tabllen werden jetzt in die Datenbank eingefügt und gefüllt:";
$db_insert[button]                      = $_LANG[main][continue_install];
$db_insert[create]                      = "anlegen";
$db_insert[fill]                        = "mit Daten füllen";

$_LANG[db_insert] = $db_insert;
unset($db_insert);


//////////////////////////////
/// Error
//////////////////////////////
unset($error);

$error[title]                           = "Fehler: Die angeforderte Seite existiert nicht!";
$error[navi_title]                      = "Willkommen!";

$error[navi_text]                       = "Bitte folgen Sie dem untenstehenden Link um mit der Installation des Frogsystem 2 zu beginnen.";
$error[navi_startlink]                  = "Installation starten";
$error[404]                             = "Folgen Sie bitte ausschließlich den angegebenen Links, um die Installation des Frogsystem 2 durchzuführen. Bitte beachten Sie den linksstehenden Hinweis um die Installation zu starten.";

$_LANG[error] = $error;
unset($error);


//////////////////////////////
/// help
//////////////////////////////
unset($help);

$help[lang][title]                      = "Languages / Sprachen";
$help[lang][text]                       = "Please select your language.<br>Bitte wählen Sie Ihre Sprache.";
$help[steps][title]                     = "Installationsfortschritt";
$help[steps][text]                      = "Zeigt den Fortschritt der Installation an.";
$help[permissions][title]               = "Berechtigungen ändern";
$help[permissions][text]                = "CHMOD der Datei oder des Ordners auf 777 setzen.";

$_LANG[help] = $help;
unset($help);
?>