<?php

if (!isset($_SESSION['username'])) {
  Helpers::return_request_code(401, "401 (Unauthorized): The user must be logged in to see posts.");
}

if (!isset($_GET['page']) || !isset($_GET['number-rows'])) {
  Helpers::return_request_code(422, "422 (Unprocessable Entity): 'page', 'number-rows' missing.");
}

$username = $_SESSION['username'];
$page = $_GET['page'];
$number_rows = $_GET['number-rows'];

try {
  $postsObj = (new Posts())->get_posts($page, $number_rows);
}
catch (Exception $err) {
  Helpers::return_request_code(500, "500 (Internal Server Error): Couldn't fetch posts.");
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

echo json_encode($postsArray);
exit;

