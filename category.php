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
include_once 'objects/category.php';
// Database connexion
$database = new Database();
$db = $database->getConnexion();
// Instanciation des objets
$product = new Product($db);
$product_images = new ProductImages($db);
$category = new Category($db);
// TODO: ajouter le titre de la page
include_once 'layout_head.php';
// Le menu contenant les catégories de produits
include_once 'menu.php';

// Récupère le nom de la catégorie en URL
if (isset($_GET['categorie'])) {
  $param = $_GET['categorie'];
} else {
  die('ERREUR: Catégorie manquante');
}
// BreadCrumb
echo '<ul id="breadcrumb">';
  echo "<li><a href='{$home_url}'> Accueil </a></li> ";
  echo "<li>/ <a href='category.php?categorie={$param}'>" .$param. "</a></li>";
echo '</ul>';

// récupère l'id de la catégorie passée en URL pour la transmettre à $product
$req = $category->read();
while ($row_category = $req->fetch(PDO::FETCH_ASSOC)) {
  if ($row_category['name'] == $param) {
    $product->category_id = $row_category['id'];
  }
}

// Affichage tout les produits appartenants à la catégorie en URL
echo '<div class="products-display">';
$stmt = $product->readAllByCategory($from_record_num, $records_per_page);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  echo '<div class="product">';
    echo '<div class="container">';
    // Select and show first product image
    $product_images->product_id = $id;
    $stmt_product_image = $product_images->readFirst();
    while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
      echo "<img src='admin/uploads/images/{$row_product_image['image1']}' alt='#'/>";
    }

      echo '<div class="invisible">';
        echo '<div class="transition">';
          echo "<a href='product.php?cat={$param}&id={$id}'>Voir plus</a>";
        echo '</div>';
      echo '</div>';
    echo '</div>';
    echo "<div class='product-name'>{$name}</div>";
    echo "<div class='product-price'><b>{$price} &euro;</b></div>";
  echo '</div>';
}
echo '</div>';

// Footer de la page
include_once 'layout_footer.php';
?>
