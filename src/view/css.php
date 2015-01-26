	<link rel="stylesheet" type="text/css" href="media/lib/bootstrap-3.2.0/dist/css/bootstrap.css"/>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css"/>
	<?php 
	switch ($_GET['page']) {
		case 'test' :
			echo '<link rel="stylesheet" type="text/css" href="media/css/test.css"/>';
			break;
		default :
			echo '<link rel="stylesheet" type="text/css" href="media/css/css.css"/>';
			break;
	}
	?>

	<link rel="icon" href="media/images/favicon.png"/>