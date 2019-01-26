<?php
 // Contrôleur d'accés pour la secion admin

// Si la session est vide, il n'est pas loggé. redirection vers la page de login
if (empty($_SESSION['logged_in'])) {
  header("Location: {$home_url}login.php?action=not_yet_logged_in");
}
// Si access_level n'est pas admin, alors redirection vers la page de login
elseif ($_SESSION['access_level']!=="Admin") {
  header("Location: {$home_url}login.php?action=not_admin");
}
?>
