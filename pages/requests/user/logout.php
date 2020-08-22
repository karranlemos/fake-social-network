<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_json_message(401, "User cannot logout if not logged in.");
}

Session::logout();
Helpers::return_request_json_message(200, "Logged out.");