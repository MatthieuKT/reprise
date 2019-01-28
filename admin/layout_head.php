<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="<?php echo $home_url; ?>libs/css/custom.css">
    <!-- Le CSS personnalisé pour la section Admin  -->
    <link rel="stylesheet" href="<?php echo $home_url; ?>libs/css/admin.css">
  </head>
  <body>
    <!-- Inclus la barre de navigation -->
    <?php include_once 'navigation.php'; ?>
    <div id="container">
      <nav>
        <ul>
          <li><a href="read_products.php">Liste de produits</a></li>
          <li><a href="new_product.php">Nouveau produit</a></li>
        </ul>
      </nav>
    <div id="main">
