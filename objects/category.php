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

  // Pour Lire le nom de la catégorie en fonction de son id
  function readName() {
    $query = "SELECT name FROM " .$this->table_name. " WHERE id = ? limit 0,1";
    $stmt = $this->conn->prepare($query);
    // Sécurise l'id car il provient d'une requête 'get'
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->name = $row['name'];
  }
} ?>
