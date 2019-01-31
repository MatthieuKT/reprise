<?php
// Parametres de la page
include_once '../config/core.php';
// Vérifie si bien logué en tant qu'Admin
include_once 'login_checker.php';
// Titre de la page
$page_title = "Gestion des catégories";
// inclus la database et les objets
include_once '../config/database.php';
include_once '../objects/category.php';
// Connexion à la database
$database = new Database();
$db = $database->getConnexion();
// Instanciation des objets
$category = new Category($db);

// Inclus le header de la page
include_once 'layout_head.php';

$stmt = $category->read();
echo "<h1>Catégories <span class='bold'> " . $stmt->rowCount() . "</span></h1>";
?>
<div id="display">
<section>
  <table>
    <thead>
      <tr>
        <th scope="col">Catégorie</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
<?php
while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
  extract($row_category);
  echo "<tr>";
    echo "<td>
            <a class='product-link' href='read_category.php?cat={$name}'>".$name.'</a>
          </td>';
    echo '<td><a href="">test</a></td>';
  echo "</tr>";
}?>
    </tbody>
  </table>
</section>

<aside>
  <div id="aside-header">
    Ajouter une catégorie
  </div>
  <!-- Formulaire pour ajouter une catégorie -->
  <form  action="#" method="post" id="aside-form">
    <label for="new-category-name">Nom</label>
    <input type="text" name="new-category-name" id="new-category-name" required>
    <input type="submit" value="Ajouter">
  </form>
</aside>

</div> <!-- /display -->

<script>
// Lors du clic sur le bouton delete-category
$('#add-category').on('submit', function(event) {
  var newName = $('#new-category-name').val();
  $.post('add_category.php', {
              value : newName
          }, function(data){
              location.reload(); // Recharge la page actuelle
          }).fail(function() {
              alert('Suppression impossible.');
          });
  event.preventDefault(); // Empeche la soumission normale du formulaire
});
</script>

<?php
// Le footer
include_once 'layout_footer.php'; ?>
