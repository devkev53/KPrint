<?php 
	
	$user = strtoupper($_POST['usuario']);
	$email = strtoupper($_POST['correo']);
	$pass1 = $_POST['contraseña1'];
	$pass2 = $_POST['contraseña1'];
	$tipo = $_POST['tipo'];

	// Hacemos la coneccion a la DB
	require 'database.php';

	require 'prueba_correo.php';
	require 'correo_bienvenida.php';
		
	if ($pass1==$pass2) {
		// Hacemos un hash con el pasword encriptando el mismo
		$passwordHash = password_hash($pass1, PASSWORD_DEFAULT);


		// Creando el query o consulta de  usuarios Heroku
		$qs_insert = "INSERT INTO heroku_59b4c55ab4de36a.usuario (codigo, usuario, email, clave, fecha_crea, fecha_act, tipo)
			VALUES(null, '$user', '$email', '$passwordHash', CURRENT_DATE, CURRENT_DATE, $tipo)";


		// Insertando el usuario con el query
		$insert = mysqli_query($conn, $qs_insert);

		if ($insert) {
			echo json_encode(array('error' => false));
		}

		$cuerpo = bienvenida_usuario($user, $email);

		$asunto = "Bienvenido a KodePrint";

		if (enviar_email($email, $user, $asunto, $cuerpo)) {
			echo json_encode(array('error' => false));
		}
	}
?>