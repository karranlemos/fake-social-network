<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_json_message(401, "The user must be logged in to post.");
}

if (!isset($_POST['id']) || !isset($_POST['post-text'])) {
  Helpers::return_request_json_message(422, "Parameters 'id', 'post-text' missing.");
}

$posts = Posts::get_instance();

if ($posts->get_post($_POST['id']) === false) {
  Helpers::return_request_json_message(400, "Post doesn't exist.");
}

$username = $_SESSION['username'];
$post_id = $_POST['id'];
$post_text = $_POST['post-text'];


if (defined('__DEMO_MAKE_DUMMY_TEXT__')) {
  $post_text = LoremIpsum::random_text(strlen($post_text));
}


if ($posts->update_post($post_id, $post_text)) {
  Helpers::return_request_json_message(200, "Post updated successfully.");
}
else {
  Helpers::return_request_json_message(500, "Couldn't update post.");
}