<?php
class secretController
{
	function __construct()
	{
		$sql = new tb_secret();

		include 'src/view/secret.php';
	}
}
?>