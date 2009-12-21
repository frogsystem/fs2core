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
            return mkdir ( $pathname, $mode, $recursive, $context );
        } else {
            return mkdir ( $pathname, $mode, $recursive );
        }
    }

}