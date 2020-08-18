<?php

if (isset($_SESSION['logged_in'])) {
  Helpers::redirect('/dashboard/');
}
else if (isset($_COOKIE['logged_in'])) {
  if (Helpers::log_in_with_cookie())
    Helpers::redirect('/dashboard/');
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