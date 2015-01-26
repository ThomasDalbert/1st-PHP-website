<div id="jeuquicassetout_dagame">
<h1>Maison</h1>

<?php
	if (isset($_SESSION['identifiant2']))
	{
		echo "<p>Connecté en tant que : ". $_SESSION['identifiant2']. "</p>";
	}
	else
	{
		echo "<form method=\"post\">
		<input id=\"jeuquicassetout_nomUtilisateur\" type=\"text\" name=\"pseudo\" id=\"pseudo\" 
		placeholder=\"Nom du personnage : \" size=\"20\" maxlength=\"15\" required/>
		<input id=\"jeuquicassetout_submit\" type=\"submit\" onclick=\"return false;\"></form>";
	}
	
	foreach (SPDO::getInstance($sql->afficherJoueursConnecte()) as $joueurs) 
	{
		echo "<div>". $joueurs['0']. "</div>";
	}
?>
</div>