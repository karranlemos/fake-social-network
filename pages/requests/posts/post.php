<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_json_message(401, "The user must be logged in to post.");
}

if (!isset($_POST['title']) || !isset($_POST['post-text'])) {
  Helpers::return_request_json_message(422, "Parameters 'title', 'post-text' missing.");
}

$username = $_SESSION['username'];
$title = $_POST['title'];
$post_text = $_POST['post-text'];

if ($title === '') {
  Helpers::return_request_json_message(422, "Title cannot be empty.");
}


if (defined('__DEMO_MAKE_DUMMY_TEXT__')) {
  $title = LoremIpsum::random_text(strlen($title), false);
  $post_text = LoremIpsum::random_text(strlen($post_text));
}


$post_id = Posts::get_instance()->create_post_username($username, $title, $post_text);
if ($post_id === false) {
  Helpers::return_request_json_message(500, "Couldn't create post.");
}

Helpers::return_request_json_message(201, "", ["post_id" => $post_id]);