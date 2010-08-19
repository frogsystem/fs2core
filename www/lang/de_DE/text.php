<?php
    $file = "template.php";

    
    include ($file);
    
    header('Content-type: text/plain');
    
    echo "# Language-Definition for $file\n";
    
    $names = array_keys ( $TEXT['data'] );

    $max_length = 0;
    
    foreach ( $names as $name ) {
        $max_length = ( $max_length >= strlen ( $name ) ) ? $max_length : strlen ( $name );
    }
    
    foreach ( $TEXT['data'] as $name => $value ) {
        $spaces = $max_length - strlen ( $name ) + 2;
        echo $name.":".str_repeat ( " ", $spaces).$value."\n";
    }
?>