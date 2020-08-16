<?php

define('__ROOT__', dirname(__DIR__));
define('__BASE__', '/');

$libs_paths = [
  __ROOT__.'/libs/Template.php',
];

foreach ($libs_paths as $lib_path) {
  require_once $lib_path;
}