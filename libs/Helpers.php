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


  public static function return_request_code($code, $message, $content_type=null) {
    http_response_code($code);
    if (!is_null($content_type))
      header('Content-type: '.$content_type.';');
    echo $message;
    exit;
  }

  public static function return_request_json($code, $json_array) {
    $json_string = json_encode($json_array);
    self::return_request_code($code, $json_string, 'aplication/json');
  }

  public static function return_request_json_message($code, $error_message, $extra_json_args=[]) {
    $json_array = [
      'status_code' => $code,
      'message' => $error_message,
    ];
    $json_array = array_merge($json_array, $extra_json_args);
    self::return_request_json($code, $json_array);
  }


  public static function generate_token($n_bytes=256) {
    return base64_encode(random_bytes($n_bytes));
  }
}