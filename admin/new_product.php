<?php
// Parametres de la page
include_once '../config/core.php';
// Vérifie si bien logué en tant qu'Admin
include_once 'login_checker.php';
// Titre de la page
$page_title = "Nouveau produit";
// inclus la database et les objets
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/category.php';
// Connexion à la database
$database = new Database();
$db = $database->getConnexion();
// Instanciation des objets
$product = new Product($db);
$category = new Category($db);

// Inclus le header de la page
include_once 'layout_head.php';

// Si le formulaire est soumis
if ($_POST) {
  // Assigne les valeurs postés aux propriétés de l'objet $product
  $product->name = $_POST['nom'];
  $product->price = $_POST['prix'];
  $product->description = $_POST['description'];
  $product->category_id = $_POST['category_id'];

  // Ajoute le produit à la database et avertis l'Admin de l'opération effectuée
  if($product->addProduct()) {
    echo '<div class="alert-success">Le produit a bien été ajouté.</div>';
  }
  // Si le produit n'a pas pu être ajouté
  else {
    echo '<div class="alert-danger">Le produit n\'a pas pu être ajouté.</div>';
  }
}
?>

<form action="#" method="post">
    <div>
        <label for="nom">Nom du produit: </label>
        <input type="text" id="nom" name="nom">
    </div>
    <div>
        <label for="category_id">Categorie: </label>
        <select name="category_id" id="category_id">
          <?php
            // Lis les catégories de produits dans la database
            $stmt = $category->read();
            while($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
              extract($row_category);
              echo "<option value='$id'>{$name}</option>";
            }
           ?>
        </select>
    </div>
    <div>
        <label for="prix">Prix: </label>
        <input type="prix" id="prix" name="prix">
    </div>
    <div>
        <label for="description">Description: </label>
        <textarea id="description" name="description"></textarea>
    </div>
    <div class="button">
        <button type="submit">Ajouter le produit</button>
    </div>
</form>

<?php

// Le footer de la page
include_once 'layout_head.php';
 ?>
