<?php

class Users {

  const ROWS_PER_PAGE = 20;

  private $db;
  public function __construct() {
    $this->db = new Database();
  }

  public function get_users($page, $rows_per_page=self::ROWS_PER_PAGE) {
    $sql = 'SELECT * FROM users ORDER BY created DESC LIMIT :offset OFFSET :page';

    $users = $this->db
      ->query($sql)
      ->bind(':offset', $rows_per_page)
      ->bind(':page', $page-1)
      ->fetchAll();
    return $users;
  }

  public function create_user($username, $email, $password) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';

    $success = $this->db
      ->query($sql)
      ->bind(':username', $username)
      ->bind(':email', $email)
      ->bind(':password', $hashed_password)
      ->execute()
    ;

    return $success;
  }

  public function check_user_password($username, $provided_password) {
    $sql = 'SELECT password FROM users WHERE username = :username';

    $user = $this->db
      ->query($sql)
      ->bind(':username', $username)
      ->fetchOne()
    ;

    return password_verify($provided_password, $user->password);
  }
}