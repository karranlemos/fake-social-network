<?php

class Helpers {
  private function __construct() {
    // Cannot instantiate.
  }

  public static function redirect($page) {
    if (is_string($page))
      $location = $page;
    else
      $location = $_SERVER['SCRIPT_NAME'];
    
    header('Location: '.$location);
    exit;
  }

  public static function return_request_code($code, $message) {
    http_response_code($code);
    echo $message;
    exit;
  }

  public static function log_in_with_cookie() {
    $cookie = explode(':', $_COOKIE['logged_in'], 2);
    if (count($cookie) != 2) {
      setcookie('logged_in', '', time()-30, '/');
      return false;
    }
    [$username, $token] = [$cookie[0], $cookie[1]];
    $token_correct = (new UsersAuth())->check_token($username, $token);
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

  public static function generate_token($n_bytes=256) {
    return base64_encode(random_bytes($n_bytes));
  }
}