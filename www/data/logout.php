<?php
if ($_POST['go'] != "login") {
  $template = forward_message ( "Logout",$phrases[logged_out], "?go=login" );
} else {
  $template = forward_message ( "Login", $phrases[logged_in], "?go=news" );
}
?>