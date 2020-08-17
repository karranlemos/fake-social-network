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
          <div class="central-options">
            <header>
              <h1>Fakebook</h1>
              <p>Welcome back!</p>
            </header>
            <div class="account-buttons">
              <button type="button" class="primary">Login</button>
              <button type="button" class="secondary">Register</button>
            </div>
          </div>
        </section>
        <section class="optional">
          
        </section>
      </div>

    </div>

  <?php });
  echo $template->get_page();
}