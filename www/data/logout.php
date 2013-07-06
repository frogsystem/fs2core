<?php

if ($FD->cfg('goto') != 'login' && (!isset($_POST['login']) || $_POST['login'] != 1)) {
  $template = forward_message ($FD->text("frontend", "user_logout"), $FD->text("frontend", "user_logout_ok"), url('login'));
  logout_user();
} else {
  $template = forward_message ($FD->text("frontend", "user_login"), $FD->text("frontend", "user_login_ok"), url($FD->cfg('home_real')));
}
?>
