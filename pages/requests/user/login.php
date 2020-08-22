<?php

if (isset($_SESSION['username'])) {
  Helpers::return_request_code(403, "403 (Forbidden): the user is already logged in.");
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  Helpers::return_request_code(422, "422 (Unprocessable Entity): 'username', 'password' missing.");
}

$users = Users::get_instance();

if (!$users->check_user_exists($_POST['username'])) {
  Helpers::return_request_code(401, "401 (Unauthorized): username doesn't exist.");
}

$correct_password = $users->check_user_password($_POST['username'], $_POST['password']);
if (!$correct_password) {
  Helpers::return_request_code(401, "401 (Unauthorized): wrong password.");
}

if (isset($_POST['remember'])) {
  $token = UsersAuth::get_instance()->create_token($_POST['username']);
  setcookie('logged_in', $_POST['username'].':'.$token, time() + (86400 * 30 * 365), '/');
}

Session::log_in_session($_POST['username']);

Helpers::return_request_code(200, 'Logged in.');