<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_json_message(401, "The user must be logged in to delete posts.");
}

if (!isset($_POST['post-id'])) {
  Helpers::return_request_json_message(422, "'post-id' missing.");
}

$posts = Posts::get_instance();
$username_from_post_id = $posts->get_username_from_post($_POST['post-id']);

if ($username_from_post_id === false) {
  Helpers::return_request_json_message(400, "400 (Bad Request): post doesn't exist");
}

if ($_SESSION['username'] !== $username_from_post_id) {
  Helpers::return_request_json_message(401, "401 (Unauthorized): cannot delete posts from other users");
}

if (!$posts->delete_post($_POST['post-id'])) {
  Helpers::return_request_json_message(500, "500 (Internal Server Error): couldn't delete post");
}

Helpers::return_request_json_message(200, "Post deleted successfully");



