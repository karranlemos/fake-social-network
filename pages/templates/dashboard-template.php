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
            <button class="nav-button home-button logo"></button>
            <div class="nav-options">
              <button class="nav-button home-button mobile-only">Home</button>
              <button class="nav-button js-modal-opener" data-modal-name="settings">Settings</button>
              <button class="nav-button js-logout" name="logout">Logout</button>
            </div>
            <button class="nav-button mobile-menu-button"></button>
          </div>
        </nav>
      </div>

      <main class="dashboard">
        <?php if(!$data['single-page']): ?>
          <div class="functionality">
            <button type="button" class="primary js-modal-opener" data-modal-name="create-post">Create Post</button>
          </div>
        <?php endif;?>

        <div class="main-dashboard-content" id="dashboard-posts-container"></div>

        <?php if($data['single-page']): ?>
          <div class="js-post-not-found-message hidden functionality">
            <h2>Post does not exist.</h2>
          </div>
          <div class="functionality">
            <a href="/"><button type="button" class="primary">See All Posts</button></a>
          </div>
        <?php endif;?>
      </main>
      
      <?php if($data['single-page']): ?>
        <footer class="page-footer">Criado por Karran Lemos.</footer>
      <?php endif;?>

    </div>
    
    <div class="modal js-modal" data-modal-name="settings">
      <div class="modal-popup modal-popup-big">
        <header>
          <button class="close"></button>
        </header>
        <section class="modal-content-container">

          <section class="settings-popup">
            <form action="" method="post" class="full-width-form js-delete-account-form">
              <h2>Delete account</h2>
              <div class="js-errors-container"></div>
              
              <input type="hidden" name="username" value="<?=$_SESSION['username']?>">
              <input type="password" name="password" placeholder="Confirm Your Password" class="input-block" required>
              <button type="submit" class="warning button-block">Delete Account</button>
            </form>
          </section>

        </section>
      </div>
    </div>

    <div class="modal js-modal" data-modal-name="create-post">
      <div class="modal-popup modal-popup-big">
        <header>
          <button class="close"></button>
        </header>
        <section class="modal-content-container">

          <section class="settings-popup">
            <form action="" method="post" class="create-post-form full-width-form">
              <div class="js-errors-container"></div>

              <input type="text" name="title" placeholder="Title" class="input-block" required>
              <textarea name="post-text" placeholder="Say something!" class="input-block"></textarea>
              <button type="submit" name="create-post" class="primary button-block">Submit</button>

              <p class="warning">Attention: this is a demo. To avoid misuse due to the lack of moderation, all text will be converted to Lorem Ipsum in the backend.</p>
            </form>
          </section>

        </section>
      </div>
    </div>

    <div class="modal js-modal" data-modal-name="edit-post">
      <div class="modal-popup modal-popup-big">
        <header>
          <button class="close"></button>
        </header>
        <section class="modal-content-container">

          <section class="settings-popup">
            <form action="" method="post" class="js-edit-post-form full-width-form">
              <div class="js-errors-container"></div>

              <input type="hidden" name="post-id" value="">
              <input type="text" name="title" placeholder="Title" class="input-block" disabled>
              <textarea name="post-text" placeholder="Say something!" class="input-block"></textarea>
              <button type="submit" class="primary button-block">Update</button>

              <p class="warning">Attention: this is a demo. To avoid misuse due to the lack of moderation, all text will be converted to Lorem Ipsum in the backend.</p>
            </form>
          </section>

        </section>
      </div>
    </div>

    <div class="modal js-modal" data-modal-name="delete-post">
      <div class="modal-popup modal-popup-big">
        <header>
          <button class="close"></button>
        </header>
        <section class="modal-content-container">

          <section class="settings-popup">
            <form action="" method="post" class="js-delete-post-form full-width-form">
              <div class="js-errors-container"></div>
              
              <input type="hidden" name="post-id" value="">
              <button type="submit" class="primary button-block">Delete?</button>
            </form>
          </section>

        </section>
      </div>
    </div>



  <?php });
  echo $template->get_page();
}