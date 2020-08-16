<?php

$logged_in = false;
if ($logged_in) {
  // TODO Redirect to logged in page
}
else {
  $template = new Template(__DIR__.'/include/base-template.php', $data);
  $template->set('get_body_content', function() { ?>
    
    <div class="content">
      
      <div class="split-page">
        <section class="relevant">
          
        </section>
        <section class="optional">
          
        </section>
      </div>

    </div>

  <?php });
  echo $template->get_page();
}