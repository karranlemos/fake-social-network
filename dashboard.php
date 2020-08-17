<?php

require_once 'config/init.php';

if (!isset($_COOKIE['logged_in'])) {
  Helpers::redirect('/');
}
else if (isset($_POST['logout'])) {
  setcookie('logged_in', '', time()-30, '/');
  Helpers::redirect('/');
}

$template = new Template(__ROOT__.'/templates/dashboard-template.php');
$template
  ->set('title', 'Fakebook - Your fake social network')
  ->set('base', __BASE__)
  ->set('posts', (new Posts)->get_posts(1, 10))
;
echo $template->get_page();