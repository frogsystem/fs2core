<?php
/**
* @file     class_fileaccess.php
* @folder   /libs
* @version  0.1
* @author   Sweil
*
* this class is responsible for file access operations
*/

class fileaccess
{
    // constructor
    public function  __construct() {
         global $global_config_arr;
    }
    
    // getFileData
    public function getFileData($filename, $flags = 0, $context = null, $offset = -1, $maxlen = -1) {
        if ( $maxlen == -1 ) {
            return file_get_contents($filename, $flags, $context, $offset);
        } else {
            return file_get_contents($filename, $flags, $context, $offset, $maxlen);
        }
    }
    
    // getFileArray
    public function getFileArray($filename, $flags = 0, $context = null) {
        return file($filename, $flags, $context);
    }
    
    // putFileData
    public function putFileData($filename, $data, $flags = 0, $context = null) {
        return file_put_contents($filename, $data, $flags, $context);
    }
    
    // deleteFile
    public function deleteFile ( $filename, $context = null ) {
        if ( is_resource ( $context ) ) {
            return unlink( $filename, $context );
        } else {
            return unlink( $filename );
        }
    }
    
    // createDir
    public function createDir ( $pathname, $mode = 0777, $recursive = false, $context = null ) {
        if ( is_resource ( $context ) ) {
            $return = mkdir ( $pathname, $mode, $recursive, $context );
        } else {
            $return = mkdir ( $pathname, $mode, $recursive );
        }
        if ( $return === TRUE ) {
            chmod ( $pathname, $mode );
        }
        return $return;
    }
    
    // deleteAny
    public function deleteAny ( $filename, $recursive = FALSE ) {
        if ( is_file ( $filename ) ) {
            return @unlink ( $filename );
        } elseif ( $recursive === FALSE && is_dir ( $filename ) ) {
            return @rmdir ( $filename );
        } elseif ( $recursive === TRUE && is_dir ( $filename ) )  {
            $filename = rtrim ( $filename, '\/' ) . "/";
            $contents = @scandir ( $filename );
            if ( is_array ( $contents ) ) {
                $contents = array_diff ( $contents, array ( ".", ".." ) );
                foreach ( $contents as $content ) {
                    $this->deleteAny( $filename.$content, TRUE );
                }
            }
            return @rmdir ( $filename );
        }
    }
    
    // copyAny
    public function copyAny ( $source, $destination, $foldermode = 0777, $filemode = 0777 ) {
        if ( is_file ( $source ) ) {
            // Case 1: File -> Dir
            $result = FALSE;
            if ( is_dir ( $destination ) ) {
                $destination = rtrim ( $destination, '\/' ) . "/";
                $destination = $destination . basename ( $source );
                $result = copy ( $source, $destination );
            // Case 2: File -> File
            } elseif ( is_file ( $destination ) || !file_exists ( $destination ) ) {
                $result = copy ( $source, $destination );
            }
            chmod ( $destination, $filemode );
            return $result;
        } elseif ( is_dir ( $source ) ) {
            // Case 3: Dir -> Dir (Copy each file from Src to Dst)
            if ( is_dir ( $destination ) ) {
            $source = rtrim ( $source, '\/' ) . "/";
            $destination = rtrim ( $destination, '\/' ) . "/";
            $contents = scandir ( $source );
                if ( is_array ( $contents ) ) {
                    $contents = array_diff ( $contents, array ( ".", ".." ) );
                    $result = TRUE;
                    foreach ( $contents as $content ) {
                        $old_result = $result;
                        $result = $this->copyAny( $source.$content, $destination.$content, $foldermode, $filemode );
                        $result = $result && $old_result;
                    }
                    return $result;
                } else {
                    return TRUE;
                }
            // Case 4: Dir -> not existent Dir
            } elseif ( !file_exists ( $destination ) ) {
                $this->createDir ( $destination, $foldermode );
                return $this->copyAny ( $source, $destination, $foldermode, $filemode );
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    // get array of all sub dirs from given dir
    //
    // $REC = TRUE: Returns an array representing directory structure
    // $REC = FALSE: Returns an arry (depth 1) and additional level information
    // $ROOT: If TRUE, return array starts with given root-dir
    
    public function getSubDirArray($DIR, $REC=FALSE, $ROOT=FALSE, $PATH_FROM_ROOT=TRUE) {
        // no dir
        if (!is_dir($DIR)) {
            return array();
        }
        
        // Change Slashes on Windows
        if (DIRECTORY_SEPARATOR === "\\") {
            $DIR = str_replace("\\", "/", $DIR);
        }
        
        // Add slash at end
        if (substr($DIR, -1) != "/") {
            $DIR .= "/";
        }
        
        // get dirname
        $dirname = basename($DIR);
        
        // set path
        $path = $PATH_FROM_ROOT ? "/" : $DIR;
        
        // call different functions
        if ($REC) {
            $RETURN = $this->getSubDirArrayRec($DIR, 1, $path);
            // add root level
            if ($ROOT) {
                $RETURN = array("name" => $dirname,
                                "path" => $path,
                                "level" => 0,
                                "content" => $RETURN);
            }
        } else {
            $RETURN = array();
            $this->getSubDirArrayLvl($DIR, $RETURN, 1, $path);
            // add root level
            if ($ROOT) {
                array_unshift($RETURN, array("name" => $dirname,
                                             "path" => $path,
                                             "level" => 0));
            }         
        } 
        return $RETURN;
    }
    
    private function getSubDirArrayRec($DIR, $LEVEL, $PATH) {
        $RETURN = array();
        $dir_data = scandir($DIR);
        foreach ($dir_data as $aDir) {
            $realpath = $DIR.$aDir."/";
            $textpath = $PATH.$aDir."/";
            if (is_dir($realpath) && !in_array($aDir, array(".", ".."))) {
                $RETURN[] = array("name" => $aDir,
                                  "path" => $textpath,
                                  "level" => $LEVEL,
                                  "content" => $this->getSubDirArrayRec($realpath, ($LEVEL+1), $textpath));
            }
        }
        return $RETURN;
    }
    
    private function getSubDirArrayLvl($DIR, &$RETURN, $LEVEL, $PATH) {
        $dir_data = scandir($DIR);
        foreach ($dir_data as $aDir) {
            $realpath = $DIR.$aDir."/";
            $textpath = $PATH.$aDir."/";
            if (is_dir($realpath) && !in_array($aDir, array(".", ".."))) {
                $RETURN[] = array("name" => $aDir,
                                  "path" => $textpath,
                                  "level" => $LEVEL);
                $this->getSubDirArrayLvl($realpath, $RETURN, ($LEVEL+1), $textpath);
            }
        }
        return $RETURN;
    }

}

?>
