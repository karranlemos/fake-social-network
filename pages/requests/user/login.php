<?php

if (isset($_SESSION['username'])) {
  Helpers::return_request_code(403, "403 (Forbidden): The user is already logged in.");
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  Helpers::return_request_code(422, "422 (Unprocessable Entity): 'username', 'password' missing.");
}

$correct_password = (new Users)->check_user_password($_POST['username'], $_POST['password']);
if (!$correct_password) {
  Helpers::return_request_code(401, "401 (Unauthorized): Wrong credentials.");
}

if (isset($_POST['remember'])) {
  $token = (new UsersAuth)->create_token($_POST['username']);
  setcookie('logged_in', $_POST['username'].':'.$token, time() + (86400 * 30 * 365), '/');
}

Helpers::log_in_session($_POST['username']);

Helpers::return_request_code(200, 'Logged in.');