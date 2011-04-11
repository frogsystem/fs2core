<?php
if ( $_POST['go'] != "login" ) {
  $template = forward_message ( $TEXT->get("user_logout"), $TEXT->get("user_logout_ok"), "?go=login" );
} else {
  $template = forward_message ( $TEXT->get("user_login"), $TEXT->get("user_login_ok"), '?go='.$global_config_arr['home_real'] );
}
?>