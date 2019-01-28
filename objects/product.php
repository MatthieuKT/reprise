<?php
class Product {
  // Database connexion and table name
  private $conn;
  private $table_name = "produits";
  // Object properties
  public $name;
  public $price;
  public $description;
  public $category_id;
  public $created;
  public $timestamp;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function addProduct() {
    // The query
    $query = "INSERT INTO " . $this->table_name . "
              SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created";

    $stmt = $this->conn->prepare($query);
    // Sanitize
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->price = htmlspecialchars(strip_tags($this->price));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    // To get timestamp for "created" field
    $this->timestamp = date('Y-m-d H-i-s');
    // Bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":created", $this->timestamp);
    // Execute la requête et renvoie true/false a add_product.php pour traitement
    if ($stmt->execute()) {
      return true;
    } else {
      print_r($stmt->errorInfo());
      return false;
    }
  }

  public function readAll($from_record_num, $records_per_page) {
    $query = "SELECT id, name, description, price, category_id
              FROM " . $this->table_name. "
              ORDER BY name ASC
              LIMIT {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    // Retourne les valeurs
    return $stmt;
  }

  // Permet d'obtenir le dernier enregistrement pour le trasmetre à product_images
  function getLastRecord() {
    $query = "SELECT *
              FROM produits
              ORDER BY id
              DESC LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
} ?>
