<?php 
	// Hacemos la coneccion a la DB
	require '../database.php';
	
	sleep(1);
	if (isset($_POST)) {
	    $username = (string)$_POST['username'];
	 
	   	// vamos a validar si el usuario no exist Heroku
		$query_user_val = "SELECT * FROM heroku_59b4c55ab4de36a.usuario WHERE usuario ='$username' ";

		// Realizando la consulta
		$user_con = mysqli_query($conn, $query_user_val);
		// Verificamos si la consulta tiene resultados enviamos un error
	 
	    if (mysqli_num_rows($user_con) > 0) {
	        echo '<small class="text-danger"><strong><i class="icon-cancel1 mr-2"></i>Selecciona otro nombre de Usuario..!</strong></small>';
	    } else {
	        echo '<small class="text-success"><strong><i class="icon-checkmark1 mr-2"></i>Nombre de Usuario disponible..!</strong></small>';
	    }
	}
?>