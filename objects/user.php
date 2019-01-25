<?php
// 'user' object
class User {
  // Database connexion
  private $conn;
  private $table_name = "users";

  // Object properties
  public $id;
  public $email;
  public $password;
  public $access_level;

  // Constructor
  public function __construct($db) {
  $this->conn = $db
  }
}

?>
