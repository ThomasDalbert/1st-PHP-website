<?php
class testController
{
	function __construct()
	{
		$sql = new tb_test();

		include 'src/view/test.php';
	}
}
?>