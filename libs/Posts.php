<?php

class Posts {

  const ROWS_PER_PAGE = 20;

  private static $instance = null;

  private $db;
  private function __construct() {
    $this->db = Database::get_instance();
  }

  public function get_posts($page, $rows_per_page=self::ROWS_PER_PAGE) {
    $sql = '
      SELECT posts.id, posts.title, posts.media, posts.post_text, posts.created, users.username
      FROM posts
      LEFT JOIN users
      ON posts.id_user = users.id
      ORDER BY posts.created DESC LIMIT :limit OFFSET :offset
    ';

    $page = (int) $page;
    $page = $page-1;
    $rows_per_page = (int) $rows_per_page;

    $offset = $page*$rows_per_page;
    
    if ($page < 0 || $rows_per_page < 0)
      throw new UnexpectedValueException('$page < 0 || $rows_per_page < 0');

    $posts = $this->db
      ->query($sql)
      ->bind(':limit', $rows_per_page)
      ->bind(':offset', $offset)
      ->fetchAll();
    return $posts;
  }

  public function get_post($post_id) {
    $sql = '
      SELECT posts.id, posts.title, posts.media, posts.post_text, posts.created, users.username
      FROM posts
      LEFT JOIN users
      ON posts.id_user = users.id
      WHERE posts.id = :post_id
    ';

    $post = $this->db
      ->query($sql)
      ->bind(':post_id', $post_id)
      ->fetchOne();

    return $post;
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

    if (!$success)
      return false;
    
    return $this->get_newest_post_id();
  }

  public function get_newest_post_id() {
    $sql = 'SELECT MAX(id) AS id FROM POSTS';

    $post_data = $this->db
      ->query($sql)
      ->fetchOne()
    ;

    if ($post_data === false)
      return false;
    return $post_data->id;
  }

  public function update_post($id, $post_text) {
    $sql = 'UPDATE posts SET post_text = :post_text WHERE id = :id';

    $success = $this->db
      ->query($sql)
      ->bind(':id', $id)
      ->bind(':post_text', $post_text)
      ->execute()
    ;

    return $success;
  }

  public function delete_post($id) {
    $sql = 'DELETE FROM posts WHERE id = :id';

    $success = $this->db
      ->query($sql)
      ->bind(':id', $id)
      ->execute()
    ;

    return $success;
  }

  
  
  public function get_username_from_post($id) {
    $post = $this->get_post($id);
    if ($post === false)
      return false;
    return $post->username;
  }

  public function create_post_username($username, $title='', $post_text=null, $media=null) {
    $user_data = Users::get_instance()->get_user($username, 'username');
    return $this->create_post($user_data->id, $title, $post_text, $media);
  }



  public function get_instance() {
    if (self::$instance === null) {
      // throws exception on failure
      self::$instance = new self;
    }

    return self::$instance;
  }
}