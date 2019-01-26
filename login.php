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
        <label for="email">email: </label>
        <input type="email" id="email" name="email">
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

// Si le formulaire à été transmis
if ($_POST) {
  // On inclus les classes
  include_once 'config/database.php';
  include_once 'objects/user.php';
  // Récupère la connexion à la database
  $database = new Database();
  $db = $database->getConnexion();
  // Initialisation des objets
  $user = new User($db);
  // Vérifie si l'email et le mot de passe sont dans la database
  $user->email = $_POST['email'];
  // check if email exists, also get user details using this emailExists() method
  $email_exists = $user->emailExists();
  // Si emailExists() a retourné true on valide le login
  if ($email_exists && password_verify($_POST['password'], $user->password)) {
    echo "string";
    // Login validé? alors attribue true aux sessions
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user->id;
    $_SESSION['access_level'] = $user->access_level;
    $_SESSION['firstname'] = $user->firstname;
    // Si access_level = "Admin", on redirige vers la section admin
    if ($user->access_level = "Admin") {
      Header("Location: {$home_url}admin/index.php?action=login_success");
    }
    // Sinon, on le redirige seulement dans la section "client"
    else {
      header("Location: {$home_url}index.php?action=login_success");
    }
  }
  else { // L'identifiant n'existe pas ou le mot de passe est erroné
    $access_denied = true;
    echo "access_denied <br>";
  }
}
include_once 'layout_footer.php';
?>
