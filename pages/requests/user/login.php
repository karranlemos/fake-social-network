<?php

if (isset($_SESSION['username'])) {
  Helpers::return_request_json_message(403, "The user is already logged in.");
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  Helpers::return_request_json_message(422, "Parameters 'username', 'password' missing.");
}

$users = Users::get_instance();

if (!$users->check_user_exists($_POST['username'])) {
  Helpers::return_request_json_message(401, "Username doesn't exist.");
}

$correct_password = $users->check_user_password($_POST['username'], $_POST['password']);
if (!$correct_password) {
  Helpers::return_request_json_message(401, "Wrong password.");
}

if (isset($_POST['remember'])) {
  $token = UsersAuth::get_instance()->create_token($_POST['username']);
  setcookie('logged_in', $_POST['username'].':'.$token, time() + (86400 * 30 * 365), '/');
}

Session::log_in_session($_POST['username']);

Helpers::return_request_json_message(200, 'Logged in.');