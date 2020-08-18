<?php

const ROUTES = [
  '/' => 'pages/welcome.php',
  '/welcome/' => 'pages/welcome.php',
  '/dashboard/' => 'pages/dashboard.php',
  // '/profile/' => 'pages/profile.php',
  '/messages/404/' => 'pages/404.php',
];

$route = $_SERVER['REQUEST_URI'];
$uri_info = pathinfo($route);
if ($route[strlen($route)-1] !== '/')
  $route .= '/';

require_once (ROUTES[$route] ?? ROUTES['/messages/404/']);