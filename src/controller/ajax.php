<?php
include_once 'src/models/mapping/tb_accueil.php';
include_once 'src/models/mapping/tb_jeuquicassetout.php';

class ajaxController
{
	function __construct()
	{
		/* ------------------------ accueil ------------------------ */
		$sql_tbAccueil = new tb_accueil();

		if (isset($_GET['identifiant'])) 
		{
			if (strlen(htmlspecialchars(rtrim($_GET['identifiant']))) < 31 
					&& htmlspecialchars(rtrim($_GET['identifiant'])) != "MISE A JOUR CONTENU")
				$_SESSION['identifiant'] = htmlspecialchars(rtrim($_GET['identifiant']));

			if ($_SESSION['identifiant'] !== NULL && $_SESSION['identifiant'] !== "")
				echo '<span id="accueil_conteneurB">
						<a id="accueil_deconnexion">Changer de nom ('. $_SESSION['identifiant']. ')</a>
							<br/><br/>
						</span>';
			else
				echo '<span id="accueil_conteneurA">
							<label class="accueil_label" for="identifiant">Nom utilisateur : </label>
							<input id="accueil_nomUtilisateur" type="text" class="form-control" name="identifiant">
					  </span>';
		}

		if (isset($_GET['deconnexion']))
		{
			session_destroy();
			echo '<span id="accueil_conteneurA">
						<label class="accueil_label" for="identifiant">Nom utilisateur : </label>
						<input id="accueil_nomUtilisateur" type="text" class="form-control" name="identifiant">
				  </span>';
		}

		if (isset($_GET['message']))
		{
			$heure = (intval(date("H")) + 1). ":". (intval(date("i")));
			$msg = htmlspecialchars(rtrim($_GET['message']));			

				// entre le message en BDD
			if ($msg !== NULL && $msg != "" && strlen($msg) < 251)
			{
				if (isset($_SESSION['identifiant']))
					$identifiant = SPDO::getInstance()->quote($_SESSION['identifiant']);
				else
					$identifiant = "NULL";

				SPDO::getInstance()->query($sql_tbAccueil->posterMessage(
					SPDO::getInstance()->quote($this->formaterHeures($heure)),
					SPDO::getInstance()->quote($msg),
					$identifiant)
				);
			}

				// envoie le nouveau contenu à afficher, pour AJAX
			foreach (SPDO::getInstance()->query($sql_tbAccueil->identifiantMessages()) as $id)
			{
				echo "<div> <span class=\"accueil_auteurEtHeureMessage\">".
				SPDO::getInstance()->query($sql_tbAccueil->auteurMessages($id['0']))['0']['0']. " [".
				SPDO::getInstance()->query($sql_tbAccueil->heureMessages($id['0']))['0']['0']. "] : </span>";
				echo "<span class=\"accueil_contenuMessage\">".
				SPDO::getInstance()->query($sql_tbAccueil->contenuMessages($id['0']))['0']['0']. "</span> </div>";
			}
		}
		/* ------------------------ jeuquicassetout ------------------------ */
		if (isset($_GET['identifiant2']))
		{
			$sql = new tb_jeuquicassetout();

			$_SESSION['identifiant2'] = htmlspecialchars(rtrim($_GET['identifiant2']));
			if ($_SESSION['identifiant2'] !== NULL && $_SESSION['identifiant2'] !== "")
			{
				echo "<h1>Maison</h1> <p>Connecté en tant que : ". $_SESSION['identifiant2']. "</p>";
				foreach (SPDO::getInstance($sql->afficherJoueursConnecte()) as $joueurs)
					echo "<div>". $joueurs['0']. "</div>";
			}
			else
				echo "<h1>Maison</h1> <form method=\"post\">
					  <input id=\"jeuquicassetout_nomUtilisateur\" type=\"text\" name=\"pseudo\" id=\"pseudo\" 
					  placeholder=\"Nom du personnage : \" size=\"20\" maxlength=\"15\" required/>
					  <input id=\"jeuquicassetout_submit\" type=\"submit\" onclick=\"return false;\"></form>";
		}
	}

	function formaterHeures($heure)
	{            
		$heure = explode(':', $heure); 

		if (strlen($heure['0']) == 1) 
			$heure['0'] = '0'. $heure['0'];
		if (strlen($heure['1']) == 1) 
			$heure['1'] = '0'. $heure['1'];

		return $heure['0']. ":". $heure['1'];
	}
}
?>