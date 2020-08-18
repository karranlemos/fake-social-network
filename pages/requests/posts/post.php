<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_code(401, "401 (Unauthorized): The user must be logged in to post.");
}

if (!isset($_POST['create-post'])) {
  Helpers::return_request_code(422, "422 (Unprocessable Entity): 'create-post' form missing.");
}

if (!isset($_POST['title']) || !isset($_POST['post-text'])) {
  Helpers::return_request_code(422, "422 (Unprocessable Entity): 'title', 'post-text' missing.");
}

$username = $_SESSION['username'];
$title = $_POST['title'];
$post_text = $_POST['post-text'];

if ((new Posts)->create_post_username($username, $title, $post_text)) {
  Helpers::return_request_code(201, "201 (Created): Post created successfully.");
}
else {
  Helpers::return_request_code(500, "500 (Internal Server Error): Couldn't create post.");
}