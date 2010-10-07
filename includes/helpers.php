<?php 

function set_notice($notice) {
  $_SESSION['notice'] = $notice;
}

function redirect_to($file) {
  $url = "http://" . $_SERVER['HTTP_HOST'];
  $url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  session_write_close();
  header("Location: $url/$file");
}

function is_signed_in() {
  return isset($_SESSION['user_id']);
}

function allow_only_users() {
  if(!is_signed_in()) {
    set_notice("You have to log in to view that page.");
    redirect_to('sign_in.php');
  }
}

function get_facebook_cookie() {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . Config::get()->fb_app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . Config::get()->fb_secret) != $args['sig']) {
    return null;
  }
  return $args;
}