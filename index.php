<?php
/* Démarre la session */
session_start();

/* Connexion à la base de données */
require_once 'src/models/model/SPDO.php';

/* Inclut le contrôleur chargé d'afficher le header */
include 'src/controller/header.php';

// On inclut le modèle et le contrôleur (sauf s'il est == à "ajax"), s'ils sont spécifiés et existent
if (!empty($_GET['page']) && is_file('src/controller/'. $_GET['page']. '.php'))
{ 
		// inclusion du modèle
	if (is_file('src/models/mapping/tb_'. $_GET['page']. '.php'))
		include_once 'src/models/mapping/tb_'. $_GET['page']. '.php';
	
		// inclusion du contrôleur
	include 'src/controller/'. $_GET['page']. '.php';
	$controller = $_GET['page']. "Controller";
	$controller = new $controller();
}
// Sinon, on affiche la page d'accueil
else
{
	include 'src/models/mapping/tb_accueil.php';
	include 'src/controller/accueil.php';
	$controller = new accueilController();
}

include 'src/controller/footer.php';
?>

