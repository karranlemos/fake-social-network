<?php

if (isset($_SESSION['username'])) {
  Helpers::return_request_json_message(403, "The user is already logged in.");
}

foreach (['username', 'email', 'password', 'password-repeat'] as $name) {
  if (!isset($_POST[$name]))
    Helpers::return_request_json_message(422, "'".$name."' missing.");
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_repeat = $_POST['password-repeat'];

if ($username === '') {
  Helpers::return_request_json_message(422, "Username cannot be empty");
}

if (!preg_match("/^[a-zA-Z0-9_\-]*$/", $username)) {
  Helpers::return_request_json_message(
    422,
    "Usernames can only have letters, digits, underscores '_' and hyphens '-'"
  );
}

if ($email === '') {
  Helpers::return_request_json_message(422, "Email cannot be empty");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  Helpers::return_request_json_message(422, "Invalid email syntax");
}

if ($password !== $password_repeat) {
  Helpers::return_request_json_message(422, "Passwords don't match.");
}

if ($password === '') {
  Helpers::return_request_json_message(422, "Password cannot be empty.");
}

if (strlen($password) < 5) {
  Helpers::return_request_json_message(422, "Password must have at least 5 characters.");
}


$user = Users::get_instance();
if ($user->check_user_exists($username)) {
  Helpers::return_request_json_message(422, "Username already exists");
}
if ($user->check_email_exists($email)) {
  Helpers::return_request_json_message(422, "Email already exists");
}

$user->create_user($username, $email, $password);

Helpers::return_request_json_message(201, 'Registered.');