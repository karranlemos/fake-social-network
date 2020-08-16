<?php

require_once 'config/init.php';

$template = new Template(__ROOT__.'/templates/index-template.php');
$template->set('title', 'Hey');
$template->set('base', __BASE__);
echo $template->get_page();