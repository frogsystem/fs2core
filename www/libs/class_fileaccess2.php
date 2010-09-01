<?php
// Klasse zum flexiblen Datei-Zugriff (kann bei Bedarf erweitert werden für FTP-Zugriff, etc.)

// Quelle:
// Basiert auf Code aus dem Projekt "Frogsystem 2 [http://www.frogsystem.de/]"
// Ursprünglicher Hauptautor: Moritz "Sweil" Kornher, Co-Autor: "Satans Krümelmonster" (Pseudonym)
// für das Kino-Projekt minimal überarbeitet und angepasst von Moritz Kornher
// hauptsächlich Kommentare hinzugefügt und überflüßiges zeug rausgemschissen

class Fileaccess
{
    // Klassen-Variablen
    private $file               = null; // Datei oder Ordner auf den eine Aktion ausgeführt werden soll
    private $folder             = FALSE; // Wenn "Datei" ein Ordner ist

    // Konstruktor
    public function  __construct( $file ) {
        $this->setFile( $file );
    }
    
    // Setter für Datei/Ordner
    private function setFile ( $file ) {
        if ( is_link ( $file ) ) { // Systemlink unter Linux
            $this->setFile ( readlink ( $file ) ); // Mit richtiger Datei neu aufrufen
        } elseif ( file_exists ( $file ) ) { // Nur wenn die Datei auch existiert
            $this->file = $file;
            if ( is_dir ( $file ) ) { // Ist ein Ordner
                $this->folder = $TRUE;
            }
        } else {
            $this->__destruct ();
        }
    }
    
    // erzeugt Datei, wenn nicht vorhanden
    public function createFile () {
        return file_put_contents ( $this->file, "" );
    }
    
    // erzeugt Ordner, wenn nicht vorhanden
    public function createDir ( $mode = 0777, $recursive = FALSE, $context = null ) {
        if ( is_resource ( $context ) ) {
            $return = mkdir ( $pathname, $mode, $recursive, $context );
        } else {
            $return = mkdir ( $pathname, $mode, $recursive );
        }
        if ( $return === TRUE ) { // Chmod nochmal explizit setzten, da das Verlassen auf $mode auf einigen Systemen zu Problem führen kann
            chmod ( $pathname, $mode );
        }
        return $return;
    }
    
    // ersetzt file_get_contents
    public function getData ( $flags = 0, $context = null, $offset = -1, $maxlen = -1 ) {
        // FALSE bei Ordner
        if ( $this->folder ) {
            return FALSE;
        }

        if ( $maxlen == -1 ) { // Workaround, da -1 nicht der richtige Standard-Wert ist (siehe PHP-Doku)
            return file_get_contents ( $this->file, $flags, $context, $offset );
        } else {
            return file_get_contents ( $this->file, $flags, $context, $offset, $maxlen );
        }
    }
    
    // ersetzt file
    public function getDataArray ( $flags = 0, $context = null ) {
        // FALSE bei Ordner
        if ( $this->folder ) {
            return FALSE;
        }
        return file ( $this->file, $flags, $context );
    }
    
    // ersetzt file_put_contents
    public function setData ( $data, $flags = 0, $context = null ) {
        // FALSE bei Ordner
        if ( $this->folder ) {
            return FALSE;
        }
        return file_put_contents ( $this->file, $data, $flags, $context );
    }
    

    // ersetzt unlink mit Erweiterung für Rekursives Löschen von Ordnern
    public function delete ( $recursive = FALSE ) {
        if ( is_file ( $this->file ) ) { // Datei => einfach löschen
            return @unlink ( $this->file );
            
        } elseif ( $recursive === FALSE && is_dir ( $this->file ) ) { // Ordner und kein reksurives löschen => versuche Ordner zu löschen
            return @rmdir ( $this->file );
            
        } elseif ( $recursive === TRUE && is_dir ( $this->file ) )  { // Ordner und reksurives löschen => Funktion rekursiv aufrufen
            $filename = rtrim ( $this->file, '\/' ) . "/"; // evtl. Slashes entfernen und eines am Ende hinzufügen
            $contents = @scandir ( $filename ); // Ordner-Inhalt laden
            if ( is_array ( $contents ) ) { // Ordner-Inhalte vorhanden
                $contents = array_diff ( $contents, array ( ".", ".." ) ); // System Links entfernen
                foreach ( $contents as $aContent ) { // Alle Ordner-Inhalte durchgehen
                    $FILE = new Fileaccess ( $filename.$aContent );
                    $FILE->delete ( TRUE ); // Rekursiver Aufruf der Funktion
                    unset ( $FILE );
                }
            }
            return @rmdir ( $filename ); // Keine Ordnerinhalte mehr => versuche Ordner zu löschen
        }
    }

    // kopiert Datei/Ordner zu Datei/Ordner
    public function copy ( $destination, $foldermode = 0777, $filemode = 0777 ) {
        if ( is_file ( $this->file ) ) {
            $result = FALSE;
            
            // Fall 1: Datei -> Ordner    $this->file
            if ( is_dir ( $destination ) ) {
                $destination = rtrim ( $destination, '\/' ) . "/"; // evtl. Slashes entfernen und eines am Ende hinzufügen
                $destination = $destination . basename ( $this->file );  // Ziel-Datei-Pfad erstelleb
                $result = copy ( $this->file, $destination ); // Datei kopieren
                
            // Fall 2: Datei -> Datei (inkl. überschreiben)
            } elseif ( is_file ( $destination ) || !file_exists ( $destination ) ) { // Ziel ist Datei oder Ziel nicht vorhanden
                $result = copy ( $this->file, $destination ); // Datei kopieren
            }
            
            chmod ( $destination, $filemode ); // Ziel Chmod setzen
            return $result; // Resultat zurückgeben
            
        } elseif ( is_dir ( $this->file ) ) {
        
            // Fall 3: Ordner -> vorhandener Ordner (alle Dateien der Quelle rekusiv in den Ziel-Ordner kopieren)
            if ( is_dir ( $destination ) ) {
                $source = rtrim ( $this->file , '\/' ) . "/"; // evtl. Slashes entfernen und eines am Ende hinzufügen
                $destination = rtrim ( $destination, '\/' ) . "/"; // evtl. Slashes entfernen und eines am Ende hinzufügen
                $contents = scandir ( $source ); // Ordner-Inhalt der Quelle laden
                if ( is_array ( $contents ) ) { // Ordner-Inhalte vorhanden
                    $contents = array_diff ( $contents, array ( ".", ".." ) ); // System Links entfernen
                    $result = TRUE;
                    foreach ( $contents as $aContent ) { // Alle Ordner-Inhalte durchgehen
                        $old_result = $result; // Result rekursiv mitschleifen
                        $FILE = new Fileaccess ( $source.$aContent );
                        $result = $result && $FILE->copy ( $destination.$aContent, $foldermode, $filemode ); // Rekursiver Aufruf der Funktion
                        unset ( $FILE );
                    }
                    return $result; // Result zurückgeben
                } else {
                    return TRUE; // Alles wurde kopiert
                }
                
            // Fall 4: Ordner -> nicht vorhandener Ordner
            } elseif ( !file_exists ( $destination ) ) {
                $FILE = new Fileaccess ( $destination );
                $FILE->createDir ( $foldermode ); // Ziel-Ordner erstellen
                unset ( $FILE );
                return $this->copy ( $destination, $foldermode, $filemode ); // Funktion erneut aufrufen => Fall 3
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}

?>