<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <!-- CSS général -->
    <link rel="stylesheet" href="<?php echo $home_url; ?>libs/css/custom.css">
    <!-- Le CSS personnalisé pour la section Admin  -->
    <link rel="stylesheet" href="<?php echo $home_url; ?>libs/css/admin.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Jquery's CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  </head>
  <body>
    <!-- Inclus la barre de navigation -->
    <?php include_once 'navigation.php'; ?>
    <div id="container">
      <nav id="sidenav">
        <ul>
          <li><a href="categories.php">Categories</a></li>
          <li><a href="read_products.php">Liste de produits</a></li>
          <li><a href="new_product.php">Nouveau produit</a></li>
        </ul>
      </nav>
    <div id="main">
