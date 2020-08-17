<?php

require_once 'config/init.php';

$template = new Template(__ROOT__.'/templates/dashboard-template.php');
$template
  ->set('title', 'Fakebook - Your fake social network')
  ->set('base', __BASE__)
  ->set('posts', (new Posts)->get_posts(1, 10))
;
echo $template->get_page();