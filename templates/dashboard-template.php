<?php

$logged_in = false;
if ($logged_in) {
  // TODO Redirect to logged in page
}
else {
  $template = new Template(__DIR__.'/include/base-template.php', $data);
  $template->set('get_body_content', function() { ?>
    
    <div class="content dashboard">
      <div class="nav-row-container">
        <nav class="dashboard">
          <div class="nav-container">
            <button class="nav-button home-button">Fakebook</button>
            <div class="nav-options">
              <button class="nav-button">Settings</button>
              <button class="nav-button">Logout</button>
            </div>
          </div>
        </nav>
      </div>

      <main class="dashboard">
        <div class="main-dashboard-content">

          <section class="post" data-post-id="0">
            
          </section>
          <section class="post" data-post-id="1">

          </section>

        </div>
      </main>
      
      <footer>Criado por Karran Lemos.</footer>

    </div>
    
    <div class="modal">
      <div class="modal-popup">
        <header>
          <button class="close"></button>
        </header>
        <section class="modal-content-container">

          <!-- <section class="" data-modal-name="login">
            
          </section> -->

        </section>
      </div>
    </div>

  <?php });
  echo $template->get_page();
}