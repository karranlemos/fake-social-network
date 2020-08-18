<?php

session_start();

define('__ROOT__', dirname(__DIR__));
define('__BASE__', '/');

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'fake-social-media');

$libs_paths = ['Template', 'Database', 'Posts', 'Users', 'UsersAuth', 'Helpers', 'Session'];

foreach ($libs_paths as $lib_path) {
  require_once __ROOT__.'/libs/'.$lib_path.'.php';
}

require_once __DIR__.'/router.php';