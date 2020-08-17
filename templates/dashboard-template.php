<?php

$logged_in = false;
if ($logged_in) {
  // TODO Redirect to logged in page
}
else {
  $template = new Template(__DIR__.'/include/base-template.php', $data);
  $template->set('get_body_content', function($data) { ?>
    
    <div class="content dashboard">
      <div class="nav-row-container">
        <nav class="dashboard">
          <div class="nav-container">
            <button class="nav-button home-button">Fakebook</button>
            <div class="nav-options">
              <button class="nav-button home-button mobile-only">Home</button>
              <button class="nav-button modal-opener" data-modal-name="settings">Settings</button>
              <form action="" method="POST">
                <button type="submit" class="nav-button" name="logout">Logout</button>
              </form>
            </div>
            <button class="nav-button mobile-menu-button"></button>
          </div>
        </nav>
      </div>

      <main class="dashboard">
        <div class="main-dashboard-content" id="dashboard-posts-container">
          <!-- <section class="post">
            <header>
              <h2>title</h2>
              <div class="post-data">
                <span class="post-username">Posted by <em>username</em></span>
                <span class="post-created"> at 01/01/1990.</span>
              </div>
            </header>
            <section>
              <p>text</p>
            </section>
          </section> -->

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

          <section class="settings-popup" data-modal-name="settings">
            
          </section>

        </section>
      </div>
    </div>

  <?php });
  echo $template->get_page();
}