<ul id='menu'>
<?php
$cats = $category->read();
while ($row_cats = $cats->fetch(PDO::FETCH_ASSOC)) {
  extract($row_cats);
  echo '<li>';
    echo "<a href='category.php?categorie={$name}'>{$name}</a>";
  echo '</li>';
}
?>
</ul>
