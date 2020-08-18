<?php

$template = new Template(__DIR__.'/templates/404-template.php');
$template
  ->set('title', 'Fakebook - Page not found')
  ->set('base', __BASE__)
;
echo $template->get_page();