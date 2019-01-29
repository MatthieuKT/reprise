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
include_once 'objects/product.php';
include_once 'objects/product_images.php';
// Database connexion
$database = new Database();
$db = $database->getConnexion();
// Instanciation des objets
$product = new Product($db);
$product_images = new ProductImages($db);
// TODO: ajouter le titre de la page
include_once 'layout_head.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  die('ERREUR: id manquant');
}

$product->id = $id;
$product_images->product_id = $id;
$stmt = $product_images->readAllImages();
while($row_image = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo '<div id="display-images">';
    echo '<div id="main-image">';
      echo '<img src="admin/uploads/images/'.$row_image['image1'].'" alt="#"/>';
    echo '</div>';
    echo '<div id="row-images">';
    if (!empty($row_image['image2'])) {
      echo '<div class="images">';
        echo '<img src="admin/uploads/images/'. $row_image['image2'] .'"/>';
      echo '</div>';
    }
    echo '</div>';
  echo '</div>';
}

// Read the details of product to be edited
$product->readOne();
echo '<div id="infos-product">';
  echo '<h1 id="product-name">' . $product->name . '</h1>';
  echo '<a id="add-to-cart" href="">AJOUTER AU PANIER</a>';
  echo '<p id="description">' . $product->description . '</p>';
echo '</div>';

echo '</div>';
// Layout footer
include_once 'layout_footer.php';
 ?>
