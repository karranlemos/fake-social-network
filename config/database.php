<?php

namespace config\database;

function init() {
  define_db_variables();
}

function define_db_variables() {
  $values = get_db_variables();
  define('DB_HOST', $values['db_host']);
  define('DB_USERNAME', $values['db_username']);
  define('DB_PASSWORD', $values['db_password']);
  define('DB_NAME', $values['db_name']);
}

function get_db_variables() {
  $default_values = [
    'db_host' => '',
    'db_username' => '',
    'db_password' => '',
    'db_name' => '',
  ];

  $database_url = getenv("CLEARDB_DATABASE_URL");
  if (!$database_url)
    return $default_values;
  
  $parsed_url = parse_url($database_url);
  if (!$parsed_url)
    return $default_values;

  return [
    'db_host' => $parsed_url['host'] ?? '',
    'db_username' => $parsed_url['user'] ?? '',
    'db_password' => $parsed_url['pass'] ?? '',
    'db_name' => substr($parsed_url['path'] ?? '', 1),
  ];
}

init();