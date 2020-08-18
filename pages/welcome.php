<?php

if (isset($_SESSION['logged_in'])) {
  Helpers::redirect('/dashboard/');
}
else if (isset($_COOKIE['logged_in'])) {
  if (Helpers::log_in_with_cookie())
    Helpers::redirect('/dashboard/');
}
else if (isset($_POST['login-form'])) {
  call_user_func(function() {
    if (!isset($_POST['username']) || !isset($_POST['password']))
      return;
    $correct_password = (new Users)->check_user_password($_POST['username'], $_POST['password']);
    if (!$correct_password)
      return;
    if (isset($_POST['remember'])) {
      $token = (new UsersAuth)->create_token($_POST['username']);
      setcookie('logged_in', $_POST['username'].':'.$token, time() + (86400 * 30 * 365), '/');
    }
    $_SESSION['logged_in'] = 'true';
    
    Helpers::redirect('/dashboard/');
  });
}
else if (isset($_POST['register-form'])) {
  call_user_func(function() {
    foreach (['username', 'email', 'password', 'password-repeat'] as $name) {
      if (!isset($_POST[$name]))
        return;
    }
    if ($_POST['password'] !== $_POST['password-repeat'])
      return;
    
    (new Users)->create_user($_POST['username'], $_POST['email'], $_POST['password']);
  });
}

$template = new Template(__DIR__.'/templates/welcome-template.php');
$template
  ->set('title', 'Fakebook - Your fake social network')
  ->set('base', __BASE__)
;
echo $template->get_page();