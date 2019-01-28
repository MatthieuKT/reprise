<?php
// Montre le rapport d'erreurs
error_reporting(E_ALL);
// Démarre une session php
session_start();
// votre fuseau horaire
date_default_timezone_set('Europe/Paris');
// L'URL de la page d'acceuil
$home_url="http://localhost/reprise/";
// la page donnée en paramètre URL, par défaut à 1
if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}
// Le nombre d'enregistrements affichés par page
$records_per_page = 5;
// Calcul pour le parametre de requête LIMIT
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>
