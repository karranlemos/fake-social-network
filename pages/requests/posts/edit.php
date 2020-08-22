<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_code(401, "401 (Unauthorized): The user must be logged in to post.");
}

if (!isset($_POST['id']) || !isset($_POST['post-text'])) {
  Helpers::return_request_code(422, "422 (Unprocessable Entity): 'id', 'post-text' missing.");
}

$posts = Posts::get_instance();

if ($posts->get_post($_POST['id']) === false) {
  Helpers::return_request_code(400, "400 (Internal Server Error): post doesn't exist.");
}

$username = $_SESSION['username'];
$post_id = $_POST['id'];
$post_text = $_POST['post-text'];

if ($posts->update_post($post_id, $post_text)) {
  Helpers::return_request_code(200, "200 (OK): post updated successfully.");
}
else {
  Helpers::return_request_code(500, "500 (Internal Server Error): Couldn't update post.");
}