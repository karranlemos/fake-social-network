<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_code(401, "401 (Unauthorized): needs to be logged in to delete an account.");
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  Helpers::return_request_code(422, "422 (Unprocessable Entity): 'username', 'password' missing.");
}

if ($_SESSION['username'] !== $_POST['username']) {
  Helpers::return_request_code(403, '403 (Forbidden): deleting other accounts is not allowed.');
}

$correct_password = (new Users)->check_user_password($_POST['username'], $_POST['password']);
if (!$correct_password) {
  Helpers::return_request_code(401, '401 (Unauthorized): wrong password.');
}

$deleted_password = (new Users)->delete_user($_POST['username']);
if (!$deleted_password) {
  Helpers::return_request_code(500, "501 (Internal Server Error): couldn't delete account.");
}

Session::logout();
Helpers::return_request_code(200, 'Account deleted successfully.');
