<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_code(401, "401 (Unauthorized): The user must be logged in to post.");
}

if (!isset($_POST['title']) || !isset($_POST['post-text'])) {
  Helpers::return_request_code(422, "422 (Unprocessable Entity): 'title', 'post-text' missing.");
}

$username = $_SESSION['username'];
$title = $_POST['title'];
$post_text = $_POST['post-text'];

$post_id = Posts::get_instance()->create_post_username($username, $title, $post_text);
if ($post_id === false) {
  Helpers::return_request_code(500, "500 (Internal Server Error): Couldn't create post.");
}

Helpers::return_request_code(201, '{"post_id":'.$post_id.'}', 'application/json');