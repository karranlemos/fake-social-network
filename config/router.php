<?php

const ROUTES = [
  '/welcome/' => 'pages/welcome.php',
  '/dashboard/' => 'pages/dashboard.php',
  // '/profile/' => 'pages/profile.php',
];

const REDIRECTS = [
  '/' => '/welcome/',
];

const MESSAGES = [
  '/messages/404/' => 'pages/404.php',
];

$route = strtok($_SERVER['REQUEST_URI'], '?');
if ($route[strlen($route)-1] !== '/')
  $route .= '/';

if (array_key_exists($route, REDIRECTS))
  Helpers::redirect(REDIRECTS[$route]);

require_once (ROUTES[$route] ?? MESSAGES['/messages/404/']);