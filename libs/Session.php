<?php

class Session {

  private function __construct() {
    
  }

  public static function log_in_with_cookie() {
    $cookie = explode(':', $_COOKIE['logged_in'], 2);
    if (count($cookie) != 2) {
      setcookie('logged_in', '', time()-30, '/');
      return false;
    }
    [$username, $token] = [$cookie[0], $cookie[1]];
    $token_correct = UsersAuth::get_instance()->check_token($username, $token);
    if (!$token_correct) {
      setcookie('logged_in', '', time()-30, '/'); 
    }
    
    self::log_in_session($username);

    return true;
  }

  public static function log_in_session($username) {
    $_SESSION['logged_in'] = 'true';
    $_SESSION['username'] = $username;
  }

  public static function logout($redirect_to=null) {
    setcookie('logged_in', '', time()-30, '/');
    unset($_SESSION['logged_in']);
    unset($_SESSION['username']);

    if (!is_null($redirect_to))
      Helpers::redirect($redirect_to);
  }

  public static function is_logged_in_session() {
    return isset($_SESSION['logged_in']);
  }

  public static function has_logged_in_cookies() {
    return isset($_COOKIE['logged_in']);
  }

  public static function check_current_user_exists() {
    if (!isset($_SESSION['username']))
      return false;
    
    return (Users::get_instance()->check_user_exists($_SESSION['username']));
  }
}