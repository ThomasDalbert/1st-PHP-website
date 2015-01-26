<?php
class tb_jeuquicassetout
{	
	function verifierIdentifiants($pseudo, $mdp)
	{
		return "SELECT $pseudo, $mdp";
	}

	function creerPersonnage($pseudo, $mdp)
	{
		return "INSERT INTO `u362629279_bdd`.`Personnages` (`ID_PERSONNAGE`, `PSEUDO`, `MOT_DE_PASSE`, `PV_MAX`, `PV`, `FORCE`, `INTELLIGENCE`, `REDUC_P`, 
					`REDUC_M`, `VISION`, `PT_ACTION_MAX`, `PT_ACTION`, `CONNECTE`, `LIEU`) 
				VALUES (NULL,". $pseudo. ",". $mdp. ", '10', '10', '1', '1', '0', '0', '3', '3', '3', '1', 'maison')";
	}
	
	function afficherJoueursConnecte()
	{
		return "SELECT `Personnages`.`PSEUDO` FROM `Personnages` WHERE `Personnages`.`CONNECTE` = '1'";
	}
}
?>