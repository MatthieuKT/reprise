<?php
// Contrôle de login pour ceux dont l'access_level est 'customer'.

// Si le niveau d'acces est 'Admin', redirection vers la page d'acceuil admin.
if (isset($_SESSION['access_level']) && $_SESSION['access_level']=="Admin ") {
  header("Location: {$home_url}admin/index.php?action=logged_in_as_admin");
}
// Si $require_login est présent et sa valeur est 'true'.
elseif (isset($require_login) && $require_login == true) {
  // l'user n'est pas encore loggé, redirection vers la page login.
  if (!isset($_SESSION['access_level'])) {
    header("Location: {$home_url}login.php?action=please_login");
  }
}
// Si c'est la page 'login' ou 'inscription', mais le client est déjà loggué.
elseif (isset($page_title) && ($page_title == "Login" || $page_title == "Sign Up")) {
  if (isset($_SESSION['access_level']) && $_SESSION['access_level'] == "Customer") {
    header("Location/ {$home_url}index.php?action=already_logged_in");
  }
}
?>
