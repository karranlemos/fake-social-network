<?php

class Posts {

  const ROWS_PER_PAGE = 20;

  private $db;
  public function __construct() {
    $this->db = new Database();
  }

  public function get_posts($page, $rows_per_page=self::ROWS_PER_PAGE) {
    $sql = '
      SELECT posts.id, posts.title, posts.media, posts.post_text, posts.created, users.username
      FROM posts
      INNER JOIN users
      ON posts.id_user = users.id
      ORDER BY posts.created DESC LIMIT :page OFFSET :offset
    ';

    $posts = $this->db
      ->query($sql)
      ->bind(':page', $rows_per_page)
      ->bind(':offset', $page-1)
      ->fetchAll();
    return $posts;
  }

  public function create_post($id_user, $title='', $post_text=null, $media=null) {
    $sql = 'INSERT INTO posts (id_user, title, post_text, media) VALUES (:id_user, :title, :post_text, :media)';

    $success = $this->db
      ->query($sql)
      ->bind(':id_user', $id_user)
      ->bind(':title', $title)
      ->bind(':post_text', $post_text)
      ->bind(':media', $media)
      ->execute()
    ;

    return $success;
  }
}