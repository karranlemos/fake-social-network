<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_code(401, "401 (Unauthorized): user cannot logout if not logged in.");
}

Session::logout();
Helpers::return_request_code(200, "200 (OK): logged out.");