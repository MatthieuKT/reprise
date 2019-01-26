<?php
// 'user' object
class User {
  // Database connexion
  private $conn;
  private $table_name = "users";

  // Object properties
  public $id;
  public $email;
  public $firstname;
  public $password;
  public $access_level;

  // Constructor
  public function __construct($db) {
  $this->conn = $db;
  }

  // Vérifie si l'email fourni existe dans la database
  public function emailExists(){
    // La requête qui check l'email
    $query = "SELECT id, firstname, access_level, password
              FROM " . $this->table_name . "
              WHERE email = ?
              LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    // un peu de sécurité
    $this->email = htmlspecialchars(strip_tags($this->email));
    // Lie les parametres à la requête
    $stmt->bindParam(1,$this->email);
    $stmt->execute();
    // Récupère le nombre de colonnes
    $num = $stmt->rowCount();
    // Si une colone est retournée, c'est que l'email existe
    if ($num>0) {
      // On va donc assigner les valeurs récupérées à l'objet
      // Ce qui sera plus facile à utiliser pour les sessions.
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // transfert des valeurs aux propriétés de l'objet
      $this->id = $row['id'];
      $this->firstname = $row['firstname'];
      $this->access_level = $row['access_level'];
      $this->password = $row['password'];
      // Retourne true parce que l'email existe dans la database
      return true;
    }
    // Par défaut, retourne false si l'email n'existe pas dans la database
    return false;
  }
}
?>
