<?php

class Database {
  const DB_HOST = DB_HOST;
  const DB_USERNAME = DB_USERNAME;
  const DB_PASSWORD = DB_PASSWORD;
  const DB_NAME = DB_NAME;

  private static $instance = null;

  private $db_handler;
  private $statement;

  private function __construct() {
    $dsn = sprintf('mysql:host=%s;dbname=%s', self::DB_HOST, self::DB_NAME);
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    try {
      $this->db_handler = new PDO($dsn, self::DB_USERNAME, self::DB_PASSWORD, $options);
    }
    catch (PDOException $e) {
      throw $e;
    }

    // throws exception if failed.
    $this->create_tables_if_needed();
  }

  private function create_tables_if_needed() {
    $tables = [
      'users' => $this->query("SHOW TABLES LIKE 'users'")->fetchAll(),
      'posts' => $this->query("SHOW TABLES LIKE 'posts'")->fetchAll(),
      'users_authentication' => $this->query("SHOW TABLES LIKE 'users_authentication'")->fetchAll(),
    ];

    foreach ($tables as $name => $table) {
      if (count($table) > 0)
        continue;

      $creation_script = file_get_contents(__ROOT__.'/misc/database/'.$name.'.sql');
      if ($creation_script === false)
        throw new Exception("Couldn't create database.");
      $this->query($creation_script)->execute();
    }
  }


  public function query($query) {
    $this->statement = $this->db_handler->prepare($query);
    return $this;
  }

  public function bind($parameter, $value, $type=null) {
    if (is_null($type)) {
      if (is_int($value))
        $type = PDO::PARAM_INT;
      else if (is_bool($value))
        $type = PDO::PARAN_BOOL;
      else if (is_null($value))
        $type = PDO::PARAM_NULL;
      else
        $type = PDO::PARAM_STR;
    }
    $this->statement->bindValue($parameter, $value, $type);
    return $this;
  }

  public function execute() {
    return $this->statement->execute();
  }

  public function fetchAll() {
    $this->execute();
    return $this->statement->fetchAll(PDO::FETCH_OBJ);
  }

  public function fetchOne() {
    $this->execute();
    return $this->statement->fetch(PDO::FETCH_OBJ);
  }



  public function get_instance() {
    if (self::$instance === null) {
      // throws exception on failure
      self::$instance = new self;
    }

    return self::$instance;
  }
}