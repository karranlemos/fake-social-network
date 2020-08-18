<?php

$template = new Template(__DIR__.'/include/base-template.php', $data);
$template->set('get_body_content', function() { ?>

    <div class="content floating-block-container">
        <div class="modal show modal-no-overlay">
            <div class="modal-popup modal-popup-big modal-popup-direct-content full-center">
                <div>
                    <h1>404 - Page not found.</h1>
                    <a href="/"><button type='button' class="primary big">Go back to homepage</button></a>
                </div>
            </div>
        </div>
    </div>

<?php });
echo $template->get_page();