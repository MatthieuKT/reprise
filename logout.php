<?php
// Les parametres de base (qui contiennent ici le session_start)
include_once 'config/core.php';
// session_destroy efface TOUT les paramétrages de session
session_destroy();
// Redirection vers la page de login
header("Location: {$home_url}login.php");
?>
