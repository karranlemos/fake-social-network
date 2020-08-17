<?php

require_once 'config/init.php';

if (!isset($_SESSION['logged_in'])) {
  Helpers::redirect('/');
}
else if (isset($_POST['logout'])) {
  setcookie('logged_in', '', time()-30, '/');
  unset($_SESSION['logged_in']);
  Helpers::redirect('/');
}

if (isset($_POST['ajax'])) {
  if (!isset($_POST['ajax-posts-page']) || !isset($_POST['ajax-posts-number'])) {
    echo '{}';
    die;
  }
  $page = $_POST['ajax-posts-page'];
  $posts_number = $_POST['ajax-posts-number'];
  try {
    $postsObj = (new Posts())->get_posts($page, $posts_number);
  }
  catch (Exception $err) {
    echo json_encode(['error'=>'usage: ajax-posts-page >= 1 and ajax-posts-number >= 0']);
    die;
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
  die;
}
else {
  $template = new Template(__ROOT__.'/templates/dashboard-template.php');
  $template
    ->set('title', 'Fakebook - Your fake social network')
    ->set('base', __BASE__)
    ->set('posts', (new Posts)->get_posts(1, 10))
  ;
  echo $template->get_page();
}