<?php

const ROUTES = [
  '/welcome/' => 'pages/welcome.php',
  '/dashboard/' => 'pages/dashboard.php',
  // '/profile/' => 'pages/profile.php',
  '/messages/404/' => 'pages/404.php',
];

const REDIRECTS = [
  '/' => '/welcome/',
];

$route = $_SERVER['REQUEST_URI'];
$uri_info = pathinfo($route);
if ($route[strlen($route)-1] !== '/')
  $route .= '/';

if (array_key_exists($route, REDIRECTS))
  Helpers::redirect(REDIRECTS[$route]);

require_once (ROUTES[$route] ?? ROUTES['/messages/404/']);