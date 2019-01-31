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
// Le header de la page
include_once 'layout_head.php';

echo '<div class="products-display">';
$stmt = $product->readAll($from_record_num, $records_per_page);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  echo '<div class="product">';
    echo '<div class="container">';
    // Select and show first product image
    $product_image->product_id = $id;
    $stmt_product_image = $product_image->readFirst();

    while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
      echo "<img src='admin/uploads/images/{$row_product_image['image1']}'/>";
    }
      echo '<div class="invisible">';
        echo '<div class="transition">';
          echo "<a href='product.php?id={$id}'>Voir plus</a>";
        echo '</div>';
      echo '</div>';
    echo '</div>';
    echo "<div class='product-name'>{$name}</div>";
    echo "<div class='product-price'><b>{$price} &euro;</b></div>";
  echo '</div>';
}
echo '</div>';
?>
