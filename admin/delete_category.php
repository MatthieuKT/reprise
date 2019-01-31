<?php
if ($_POST) {
  // include database and object file
  include_once '../config/database.php';
  include_once '../objects/category.php';
  // Get database connexion
  $database = new Database();
  $db = $database->getConnexion();
  // instantiate objects
  $category = new Category($db);
  $category->id = $_POST['object_id'];
  // delete the product
  $category->delete();
} ?>
