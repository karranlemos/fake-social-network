<?php

class Database {
  const DB_HOST = DB_HOST;
  const DB_USERNAME = DB_USERNAME;
  const DB_PASSWORD = DB_PASSWORD;
  const DB_NAME = DB_NAME;

  private $db_handler;
  private $statement;

  public function __construct() {
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
}