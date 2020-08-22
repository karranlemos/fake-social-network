<?php

if (isset($_SESSION['username'])) {
  Helpers::return_request_code(403, "403 (Forbidden): The user is already logged in.");
}

foreach (['username', 'email', 'password', 'password-repeat'] as $name) {
  if (!isset($_POST[$name]))
    Helpers::return_request_code(422, "422 (Unprocessable Entity): '".$name."' missing.");
}

if ($_POST['password'] !== $_POST['password-repeat']) {
  Helpers::return_request_code(400, "400 (Bad Request): passwords don't match.");
}

Users::get_instance()->create_user($_POST['username'], $_POST['email'], $_POST['password']);

Helpers::return_request_code(201, 'Registered.');