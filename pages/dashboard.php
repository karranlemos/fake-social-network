<?php

if (!Session::is_logged_in_session()) {
  Helpers::redirect('/welcome/');
}

$template = new Template(__DIR__.'/templates/dashboard-template.php');
$template
  ->set('title', 'Fakebook - Your fake social network')
  ->set('base', __BASE__)
  ->set('single-page', (isset($_GET['post-id'])))
;
echo $template->get_page();