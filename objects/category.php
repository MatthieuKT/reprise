<?php
class Category {
  // Database connexion and table name
  private $conn;
  private $table_name = "categories";
  // Object properties
  public $id;
  public $name;

  public function __construct($db) {
  $this->conn = $db;
  }

  // Used by select drop-down list
  function read() {
    // Select all data
    $query = "SELECT id, name
              FROM " . $this->table_name . "
              ORDER BY name";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
} ?>
