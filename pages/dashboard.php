<?php

if (!isset($_SESSION['logged_in'])) {
  Helpers::redirect('/welcome/');
}
else if (isset($_POST['logout'])) {
  setcookie('logged_in', '', time()-30, '/');
  unset($_SESSION['logged_in']);
  Helpers::redirect('/welcome/');
}

$template = new Template(__DIR__.'/templates/dashboard-template.php');
$template
  ->set('title', 'Fakebook - Your fake social network')
  ->set('base', __BASE__)
  ->set('posts', (new Posts)->get_posts(1, 10))
;
echo $template->get_page();