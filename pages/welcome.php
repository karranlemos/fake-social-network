<?php

if (isset($_SESSION['logged_in'])) {
  Helpers::redirect('/dashboard/');
}
else if (isset($_COOKIE['logged_in'])) {
  if (Session::log_in_with_cookie())
    Helpers::redirect('/dashboard/');
}

$template = new Template(__DIR__.'/templates/welcome-template.php');
$template
  ->set('title', 'Fakebook - Your fake social network')
  ->set('base', __BASE__)
;
echo $template->get_page();