<?php

class UsersAuth {

  const ROWS_PER_PAGE = 20;

  private $db;
  public function __construct() {
    $this->db = new Database();
  }

  public function create_token($username, $token=null) {
    if (is_null($token)) {
      $token = Helpers::generate_token();
    }

    $user = (new Users())->get_user($username);

    $sql = 'INSERT INTO users_authentication (id_user, token) VALUES (:id_user, :token)';

    $success = $this->db
      ->query($sql)
      ->bind(':id_user', $user->id)
      ->bind(':token', $token)
      ->execute()
    ;

    return $token;
  }

  public function check_token($username, $token) {
    $user = (new Users())->get_user($username);
    $sql = 'SELECT token FROM users_authentication WHERE id_user = :id_user AND TIMESTAMPDIFF(YEAR, created, CURRENT_TIMESTAMP) < 1';

    $tokens = $this->db
      ->query($sql)
      ->bind(':id_user', $user->id)
      ->fetchAll()
    ;

    foreach ($tokens as $tokenObj) {
      if ($tokenObj->token === $token)
        return true;
    }

    return false;
  }
}