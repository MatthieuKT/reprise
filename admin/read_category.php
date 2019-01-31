<?php
// Les variables de pagination sont contenues dans core.php
include_once '../config/core.php';
// Le contrôleur de login
include_once 'login_checker.php';
// la database et les fichiers objets
include_once '../config/database.php';
include_once '../objects/category.php';
include_once '../objects/product.php';
include_once '../objects/product_images.php';
// Instanciation de la database et des objets
$database = new Database();
$db = $database->getConnexion();
$category = new Category($db);
$product = new Product($db);
$product_images = new ProductImages($db);

// Titre de la page et header
$page_title = "Catégorie";
include_once 'layout_head.php';

// Récupère la catégorie passé en paramètres
if (isset($_GET['cat'])) {
  $param = $_GET['cat'];
}
// Vérifie si la catégorie entrée en URL existe bien depuis son ID
$req = $category->read();
while ($row_category = $req->fetch(PDO::FETCH_ASSOC)) {
  if ($row_category['name'] == $param) {
    $category->name = $row_category['name'];
    $category->id = $row_category['id'];
  }
}

// BreadCrumb
echo '<ul id="breadcrumb">';
  echo "<li><a href='{$home_url}admin'> Admin </a></li> ";
  echo "<li>/ <a href='{$home_url}admin/categories.php'>categories</a></li>";
echo '</ul>';

// attribue à la propriété $category_id la valeur du parametre pour la requête
$product->category_id = $category->id;
$stmt = $product->readAllByCategory($from_record_num, $records_per_page);
?>

<h1><?php echo $category->name ?></h1>
<div id='display'>

  <section id='category'>
    <div id='category-head'>
      Articles dans la catégorie <?php echo  $stmt->rowCount(); ?>
    </div>
    <div id='category-content'>
    <?php  while ($row_product = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row_product);
      echo "<div class='product-from-cat'>";
        // Select and show first product image
        $product_images->product_id = $id;
        $stmt_product_image = $product_images->readFirst();
        while ($row_product_img = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
          echo "<img src='uploads/images/{$row_product_img['image1']}' alt='#'/>";
        }
        // Affichage du nom
        echo '<div class="product-name">' . $name . '</div>';
      echo "</div>";
      }
      ?>
    </div>
  </section>

  <aside>
    <div id='aside-header'>Infos Catégorie</div>
    <div id='aside-body'>
      <form id="aside-form" action="#" method="post">
        <label for="category_name">Nom catégorie</label>
        <input type="text" id ="category_name" name="category_name" value="<?php echo $category->name; ?>" required>
        <input type="submit" value="Mettre à jour">
      </form>
      <?php
      if ($_POST) { // Si le formulaire d'update est envoyé
        // set product property values
        $category->name = $_POST['category_name'];
        if ($category->update()) {
          header("Location: {$home_url}admin/categories.php?action=success");
        }
      }
      ?>
      <button id="delete-category" value="<?php echo $category->id; ?>">Supprimer</button>
  </aside>
</div> <!-- /display-->

<script>
// Lors du clic sur le bouton delete-category
$(document).on('click', '#delete-category', function() {
  // récupère l'id de la catégorie en question contenue dans la valeur du bouton
  var id = $(this).val();
  // Apparition de la fenêtre de confirmation
  if (confirm("Voulez-vous vraiment supprimer la catégorie?")) {
    // Si la réponse est oui, on poste l'id à la page delete_category.php
    $.post('delete_category.php', {
      object_id: id
    }, function(data){
    // Redirection vers la liste des catégories
    window.location = "categories.php";
    }).fail(function() {
      alert('Suppression impossible.');
    });
  }
});
</script>

<!-- Footer de la page -->
<?php include_once "layout_footer.php";?>
