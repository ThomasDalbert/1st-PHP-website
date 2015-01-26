<?php
class RPGdeCasesController
{
	function __construct()
	{
		$sql = new tb_RPGdeCases();

		include 'src/view/RPGdeCases.php';
	}
}
?>