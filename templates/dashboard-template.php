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
        <div class="create-post-box">
          <button type="button" class="primary modal-opener" data-modal-name="create-post">Create Post</button>
        </div>
        <div class="main-dashboard-content" id="dashboard-posts-container"></div>
      </main>
      
      <footer>Criado por Karran Lemos.</footer>

    </div>
    
    <div class="modal js-modal">
      <div class="modal-popup">
        <header>
          <button class="close"></button>
        </header>
        <section class="modal-content-container">

          <section class="settings-popup" data-modal-name="settings">
            
          </section>

          <section class="settings-popup" data-modal-name="create-post">
            <form action="/dashboard/" method="post" class="create-post-form full-width-form">
              <input type="text" name="title" placeholder="Title" class="input-block">
              <textarea name="post_text" placeholder="Say something!" class="input-block"></textarea>
              <button type="submit" name="create-post" class="primary button-block">Submit</button>
            </form>
          </section>

        </section>
      </div>
    </div>

  <?php });
  echo $template->get_page();
}