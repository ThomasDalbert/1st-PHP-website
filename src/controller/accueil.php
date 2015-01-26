<?php
class accueilController
{
	function __construct()
	{
		$sql = new tb_accueil();
		$identifiantMessages = SPDO::getInstance()->query($sql->identifiantMessages());

		include 'src/view/accueil.php';
	}
}
?>