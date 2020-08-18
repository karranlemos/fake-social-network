<?php

if (Session::is_logged_in_session()) {
  Helpers::redirect('/dashboard/');
}

$template = new Template(__DIR__.'/templates/welcome-template.php');
$template
  ->set('title', 'Fakebook - Your fake social network')
  ->set('base', __BASE__)
;
echo $template->get_page();