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

  public static function generate_token($n_bytes=256) {
    return base64_encode(random_bytes($n_bytes));
  }
}