<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_json_message(401, "Needs to be logged in to delete an account.");
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  Helpers::return_request_json_message(422, "Parameters 'username', 'password' missing.");
}

if ($_SESSION['username'] !== $_POST['username']) {
  Helpers::return_request_json_message(403, 'Deleting other accounts is not allowed.');
}

$users = Users::get_instance();

$correct_password = $users->check_user_password($_POST['username'], $_POST['password']);
if (!$correct_password) {
  Helpers::return_request_json_message(401, 'Wrong password.');
}

$deleted_password = $users->delete_user($_POST['username']);
if (!$deleted_password) {
  Helpers::return_request_json_message(500, "Couldn't delete account.");
}

Session::logout();
Helpers::return_request_json_message(200, 'Account deleted successfully.');
