<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_json_message(401, "The user must be logged in to see posts.");
}

if (!isset($_GET['get-all']) && !isset($_GET['post-id'])) {
  Helpers::return_request_json_message(422, "Either 'get-all' or 'post-id' must be set.");
}

$posts = Posts::get_instance();

if (isset($_GET['get-all'])) {
  if (!isset($_GET['page']) || !isset($_GET['number-rows'])) {
    Helpers::return_request_json_message(422, "Get parameters 'page' and 'number-rows' missing.");
  }

  $page = $_GET['page'];
  $number_rows = $_GET['number-rows'];

  try {
    $postsObj = $posts->get_posts($page, $number_rows);
  }
  catch (Exception $err) {
    Helpers::return_request_json_message(500, "500 (Internal Server Error): Couldn't fetch posts.");
  } 

}
else if (isset($_GET['post-id'])) {
  $post_id = $_GET['post-id'];

  try {
    $postsObj = $posts->get_post($post_id);
  }
  catch (Exception $err) {
    Helpers::return_request_json_message(500, "500 (Internal Server Error): Couldn't fetch post.");
  }

  if ($postsObj === false) {
    Helpers::return_request_json_message(404, "Post doesn't exist.");
  }

  $postsObj = [$postsObj];
}

$postsArray = [];
foreach ($postsObj as $postObj) {
  $postArray = [];
  $postArray['id'] = $postObj->id;
  $postArray['title'] = $postObj->title;
  $postArray['media'] = $postObj->media;
  $postArray['post_text'] = $postObj->post_text;
  $postArray['created'] = $postObj->created;
  $postArray['username'] = $postObj->username;
  
  $postsArray[] = $postArray;
}

Helpers::return_request_json_message(200, "", ["posts" => $postsArray]);