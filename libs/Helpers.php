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
}