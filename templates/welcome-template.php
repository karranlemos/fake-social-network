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
              <h1 class="logo">Fakebook</h1>
              <p>Welcome back!</p>
            </header>
            <div class="account-buttons">
              <button type="button" class="primary modal-opener" data-modal-name="login">Login</button>
              <button type="button" class="secondary modal-opener" data-modal-name="register">Register</button>
            </div>
          </div>
        </section>
        <section class="optional">
          
        </section>
      </div>

    </div>
    
    <div class="modal">
      <div class="modal-popup">
        <header>
          <button class="close"></button>
        </header>
        <section class="modal-content-container">

          <section class="" data-modal-name="login">
            <form action="/welcome/" method="post" class="full-width-form">
              <input type="text" name="username" placeholder="Username" class="input-block">
              <input type="password" name="password" placeholder="Password" class="input-block">
              <div class="checkbox-container">
                <label>Remember me? <input type="checkbox" name="remember"></label>
              </div>
              <button type="submit" class="primary button-block" name="login-form">Login</button>
              <div class="secondary-links">
                <a href="#">Forgot Your Password?</a>
              </div>
            </form>
          </section>

          <section class="" data-modal-name="register">
            <form action="/welcome/" method="post" class="full-width-form">
              <input type="text" name="username" placeholder="Username" class="input-block">
              <input type="email" name="email" placeholder="Email" class="input-block">
              <input type="password" name="password" placeholder="Password" class="input-block">
              <input type="password" name="password-repeat" placeholder="Repeat Password" class="input-block">
              
              <button type="submit" class="primary button-block" name="register-form">Register</button>
            </form>
          </section>

        </section>
      </div>
    </div>

  <?php });
  echo $template->get_page();
}