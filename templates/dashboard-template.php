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
              <button class="nav-button">Logout</button>
            </div>
            <button class="nav-button mobile-menu-button"></button>
          </div>
        </nav>
      </div>

      <main class="dashboard">
        <div class="main-dashboard-content">

          <!-- <section class="post" data-post-id="0"></section> -->
          <?php foreach ($data['posts'] as $post):?>
            <section class="post">
              <header>
                <h2><?=($post->title) ? $post->title : 'Untitled' ?></h1>
              </header>
              <section>
                <p><?=$post->post_text?></p>
              </section>
            </section>
          <?php endforeach;?>

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