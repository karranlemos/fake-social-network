<?php

$template = new Template(__DIR__.'/include/base-template.php', $data);
$template->set('get_body_content', function() { ?>

    <h1>404 - Page not found.</h1>

<?php });
echo $template->get_page();