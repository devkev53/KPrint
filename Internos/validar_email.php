<?php 
	// Hacemos la coneccion a la DB
	require '../database.php';
	
	sleep(1);
	if (isset($_POST)) {
	    $username = (string)$_POST['username'];
	 
	    // vamos a validar si el usuario no exist
		$query_user_val = "SELECT * FROM usuario WHERE email ='$username' ";
		// Realizando la consulta
		$user_con = mysqli_query($conn, $query_user_val);
		// Verificamos si la consulta tiene resultados enviamos un error
	 
	    if (mysqli_num_rows($user_con) > 0) {
	        echo '<small class="text-danger"><strong><i class="icon-cancel1 mr-2"></i>Este correo ya esta registrado..!</strong></small>';
	    } else {
	        echo '<small class="text-success"><strong><i class="icon-checkmark1 mr-2"></i>Correo disponible..!</strong></small>';
	    }
	}
?>