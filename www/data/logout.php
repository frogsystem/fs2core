<?php
if ($_POST['go'] != "login") {
  $template = forward_message ($TEXT['frontend']->get("user_logout"), $TEXT['frontend']->get("user_logout_ok"), url("login"));
  logout_user();
} else {
  $template = forward_message ($TEXT['frontend']->get("user_login"), $TEXT['frontend']->get("user_login_ok"), url($FD->cfg('home_real')));
}
?>
