<?php
if ($_POST['go'] != "login") {
  sys_message("Logout","$phrases[logged_out]");
} else {
  sys_message("Logout","$phrases[logged_in]");
}
?>