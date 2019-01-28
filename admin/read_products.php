<?php
// Les variables de pagination sont contenues dans core.php
include_once '../config/core.php';
// Le contrôleur de login
include_once 'login_checker.php';
// la database et les fichiers objets
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/category.php';
// Instanciation de la database et des objets
$database = new Database();
$db = $database->getConnexion();
$product = new Product($db);
$category = new Category($db);

// Titre de la page et header
$page_title = "Liste des produits";
include_once 'layout_head.php';

// La requête pour afficher les produits
$stmt = $product->readAll($from_record_num, $records_per_page);
// Le tableau qui contient les données à afficher
include_once "template.php";

?>
