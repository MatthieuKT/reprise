<?php
// core configuration
include_once "config/core.php";
// set page title
$page_title = "Login";
// include login checker
$require_login=false;
include_once "login_checker.php";
// default to false
$access_denied=false;

include_once 'layout_head.php';
?>

<form action="#" method="post">
    <div>
        <label for="identifiant">Identifiant: </label>
        <input type="email" id="identifiant" name="identifiant">
    </div>
    <div>
        <label for="password">Mot de passe: </label>
        <input type="password" id="password" name="password">
    </div>
    <div>
      <input type="submit" value="Se connecter"/>
    </div>
</form>

<?php
// Récupère la valeur 'action' en paramètre URL afin d'afficher les messages
if (isset($_GET['action'])) {
  $action = $_GET['action'];
} else {
  $action = "";
}
// Annonce que l'utilisateur n'est pas encore loggué
if ($action == 'not_yet_logged_in') {
  echo '<div class="alert-danger" role="alert">
          Veuillez vous authentifier.
        </div>';
}
// demande à l'utilisateur de se logguer
elseif ($action == "please_login") {
  echo '<div class="alert-info">
          <strong>Veuillez vous connecter pour accéder à cette page.</strong>
        </div>';
}
// Annonce à l'utilisateur que l'accés est interdit
if ($access_denied) {
  echo '<div class="alert-danger" role="alert">
          Accés refusé.<br/><br/>
          identifiant ou mot de passe incorrect
        </div>';
}




include_once 'layout_footer.php';
?>
