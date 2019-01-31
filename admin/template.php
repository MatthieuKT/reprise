<table class="table">
  <thead>
    <tr>
      <th scope="col">Produit</th>
      <th scope="col">Prix</th>
      <th scope="col">Description</th>
      <th scope="col">Categorie</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $num = $stmt->rowCount();
    // Si il y'a au moins un resultat
    if ($num > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        echo "<tr>";
            echo "<td>{$name}</td>";
            echo "<td>{$price}</td>";
            echo "<td>{$description}</td>";
            echo "<td>";
                $category->id = $category_id;
                $category->read();
                echo $category->name;
            echo "</td>";
            echo "<td>";
            // read, edit and delete buttons
echo "  <a class='action' href='read_one.php?id={$id}'>Voir</a>
        <a class='action' href='update_product.php?id={$id}'>Modifier</a>
        <a class='action' delete-id='{$id}'><i class='fas fa-trash-alt'></i></a>
";
            echo "</td>";
        echo "</tr>";
      }
    }else{
    echo "Aucun produit";
    }
    ?>
  </tbody>
</table>
