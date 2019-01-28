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
include_once '../objects/product_images.php';
include_once '../php/utils.php';
// Connexion à la database
$database = new Database();
$db = $database->getConnexion();
// Instanciation des objets
$product = new Product($db);
$category = new Category($db);
$product_images = new ProductImages($db);
$utils = new Utils();

// Inclus le header de la page
include_once 'layout_head.php';

// Si le formulaire est soumis
if ($_POST) {
  // Assigne les valeurs postés aux propriétés de l'objet $product
  $product->name = $_POST['name'];
  $product->price = $_POST['price'];
  $product->description = $_POST['description'];
  $product->category_id = $_POST['category_id'];

  // 1: On insère les données collectées dans l'objet product
  if($product->addProduct()) {
    // On réorganise le tableau d'images afin de pouvoir mieux les manipuler
    $file_array = $utils->reorganise($_FILES['image']);
    foreach ($file_array as $file) {
      // La fonction sha1_file() permet d'obtenir un nom unique pour chaque image
      $file["name"] = sha1_file($file['tmp_name']) ."-". basename($file["name"]);
      // 2: On upload les images
      $product_images->uploadPhoto($file);
      // Insertion du nom de chaque image dans l'object product_image
      array_push($product_images->images, $file['name']);
    }
    // On récupère l'id du produit que l'on vient juste d'enregistrer
    $current_product_id = $product->getLastRecord();
    // On transfère cet ID à l'objet images_product
    while($donnees = $current_product_id->fetch(PDO::FETCH_ASSOC)) {
      $product_images->id_produit = $donnees['id'];
    }

    // 3:On peut maintenant insérer les propriétés de $product_images au complet
    if ($product_images->addImage()) {
       echo '<div class="alert-success">Le produit a bien été ajouté.</div>';
    }
    else {
      echo '<div class="alert-danger">Le produit n\'a pas pu être ajouté.</div>';
    }
  }
}
?>

<form action="#" method="post" enctype="multipart/form-data">
    <div>
        <label for="name">Nom du produit: </label>
        <input type="text" id="name" name="name" required>
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
        <label for="price">Prix: </label>
        <input type="prix" id="price" name="price" required>
    </div>
    <div>
        <label for="description">Description: </label>
        <textarea id="description" name="description"></textarea>
    </div>
    <div>
      <label for="imagePrincipale">Image principale: </label>
      <input type="file" id="imagePrincipale" name="image[]">
    </div>
    <div>
      <label for="image2">image2: </label>
      <input type="file" id="image2" name="image[]">
    </div>
    <div class="button">
        <button type="submit">Ajouter le produit</button>
    </div>
</form>

<?php
// Le footer de la page
include_once 'layout_head.php';
 ?>
