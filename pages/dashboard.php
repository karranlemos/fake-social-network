<?php

if (!Session::is_logged_in_session()) {
  Helpers::redirect('/welcome/');
}
else if (isset($_POST['logout'])) {
  Session::logout();
  Helpers::redirect('/welcome/');
}

$template = new Template(__DIR__.'/templates/dashboard-template.php');
$template
  ->set('title', 'Fakebook - Your fake social network')
  ->set('base', __BASE__)
  ->set('posts', (new Posts)->get_posts(1, 10))
;
echo $template->get_page();