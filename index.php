<?php
// core configuration
include_once "config/core.php";
// Set page title
$page_title = "Produits";
// Include login checker
$require_login=false;
include_once "login_checker.php";
// default to false
$access_denied=false;
// La database
include_once 'config/database.php';
// Importation des objets
include_once 'objects/category.php';
include_once 'objects/product.php';
include_once 'objects/product_images.php';
// Database connexion
$database = new Database();
$db = $database->getConnexion();
// Instanciation des objets
$category = new Category($db);
$product = new Product($db);
$product_image = new ProductImages($db);
// Le titre et le header de la page
$page_title = "Laudace";
include_once 'layout_head.php';
// Le menu contenant les catégories de produits
include_once 'menu.php';

// Footer de la page
include_once 'layout_footer.php';
?>
