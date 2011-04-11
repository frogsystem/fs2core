<?php
include ( "inc/ftp_data.php" );

$conn = ftp_connect ( $host, $port, 10 );
$login = FALSE;

if ( $conn != FALSE ) {
    $login = ftp_login ( $conn, $user, $pass );
}
?>