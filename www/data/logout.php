<?php
if ($_POST['go'] != "login") {
  $template = sys_message("Logout","$phrases[logged_out]");
} else {
  $template = sys_message("Login","$phrases[logged_in]");
}
?>