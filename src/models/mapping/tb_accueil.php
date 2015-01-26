<?php
class tb_accueil
{
	function identifiantMessages()
	{
		return "SELECT `ID_MESSAGE` 
				FROM `chat` 
				ORDER BY `ID_MESSAGE` DESC";
	}

	function heureMessages($identifiantMessage)
	{
		return "SELECT `HEURE_MESSAGE`
				FROM `chat`
				WHERE ID_MESSAGE =". $identifiantMessage;
	}

	function contenuMessages($identifiantMessage)
	{
		return "SELECT `CONTENU_MESSAGE`
				FROM `chat`
				WHERE ID_MESSAGE =". $identifiantMessage;
	}

	function auteurMessages($identifiantMessage)
	{
		return "SELECT `AUTEUR`
				FROM `chat`
				WHERE ID_MESSAGE =". $identifiantMessage;
	}

	function posterMessage($heure, $contenuMessage, $nomAuteur)
	{
		return "INSERT INTO `u362629279_bdd`.`chat` (`ID_MESSAGE`, `HEURE_MESSAGE`, `CONTENU_MESSAGE`, 
			`AUTEUR`) 
				VALUES (NULL,". $heure. ",". $contenuMessage. ",". $nomAuteur. ")";
	}
}
?>