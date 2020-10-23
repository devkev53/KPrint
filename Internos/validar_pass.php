<?php 
	// Hacemos la coneccion a la DB
	require '../database.php';
	
	sleep(1);
	if (isset($_POST)) {
	    $p1 = (string)$_POST['pass1'];
	    $p2 = (string)$_POST['pass2'];
	 
	    if ($p1 != $p2) {
	        echo '<small class="text-danger"><strong><i class="icon-cancel1 mr-2"></i>Las contraseñas no coinciden..!</strong></small>';
	    } else {
	        echo '<small class="text-success"><strong><i class="icon-checkmark1 mr-2"></i>Excelente..!</strong></small>';
	    }
	}
?>