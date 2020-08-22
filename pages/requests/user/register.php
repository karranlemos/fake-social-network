<?php

if (isset($_SESSION['username'])) {
  Helpers::return_request_json_message(403, "The user is already logged in.");
}

foreach (['username', 'email', 'password', 'password-repeat'] as $name) {
  if (!isset($_POST[$name]))
    Helpers::return_request_json_message(422, "'".$name."' missing.");
}

if ($_POST['password'] !== $_POST['password-repeat']) {
  Helpers::return_request_json_message(400, "Passwords don't match.");
}

Users::get_instance()->create_user($_POST['username'], $_POST['email'], $_POST['password']);

Helpers::return_request_json_message(201, 'Registered.');