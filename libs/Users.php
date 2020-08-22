<?php

class Users {

  const ROWS_PER_PAGE = 20;

  private static $instance = null;

  private $db;
  private function __construct() {
    $this->db = Database::get_instance();
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

  public function get_user($user_data, $user_field='username') {
    if (!in_array($user_field, ['username', 'id', 'email']))
      throw new UnexpectedValueException();
 
    $sql = 'SELECT id, username, email FROM users WHERE '.$user_field.' = :userdata';

    $user = $this->db
      ->query($sql)
      ->bind(':userdata', $user_data)
      ->fetchOne();
    
    return $user;
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

  public function delete_user($username) {
    $success = $this->db
      ->query('DELETE FROM users WHERE username = :username')
      ->bind(':username', $username)
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

    if ($user === false)
      return false;

    return password_verify($provided_password, $user->password);
  }

  public function check_user_exists($username) {
    if ($this->get_user($username) === false)
      return false;
    return true;
  }



  public function get_instance() {
    if (self::$instance === null) {
      // throws exception on failure
      self::$instance = new self;
    }

    return self::$instance;
  }
}