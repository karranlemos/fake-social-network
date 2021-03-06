<?php

const ROUTES = [
  '/welcome/' => 'pages/welcome.php',
  '/dashboard/' => 'pages/dashboard.php',
  // '/profile/' => 'pages/profile.php',

  '/requests/posts/post/' => 'pages/requests/posts/post.php',
  '/requests/posts/get/' => 'pages/requests/posts/get.php',
  '/requests/posts/edit/' => 'pages/requests/posts/edit.php',
  '/requests/posts/delete/' => 'pages/requests/posts/delete.php',
  
  '/requests/user/login/' => 'pages/requests/user/login.php',
  '/requests/user/register/' => 'pages/requests/user/register.php',
  '/requests/user/delete/' => 'pages/requests/user/delete.php',
  '/requests/user/logout/' => 'pages/requests/user/logout.php',
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