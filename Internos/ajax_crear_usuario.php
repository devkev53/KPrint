<?php 
	session_start();

	if (!isset($_SESSION['usuario'])) {
		//if ($_SESSION['usuario']['tipo'] != 0) {
		//	header('location: ../prohibido.php');
	}else{

		$user = strtoupper($_POST['usuario']);
		$email = strtoupper($_POST['correo']);
		$pass1 = $_POST['contraseña1'];
		$pass2 = $_POST['contraseña1'];
		$tipo = $_POST['tipo'];

		// Hacemos la coneccion a la DB
		require '../database.php';

		require '../prueba_correo.php';
		require '../correo_bienvenida.php';

		// vamos a validar si el usuario no exist
		$query_user_val = "SELECT usuario, email  FROM usuario WHERE usuario ='$user' OR email='$email'";
		// Realizando la consulta
		$user_con = mysqli_query($conn, $query_user_val);
		// Verificamos si la consulta tiene resultados enviamos un error
		if (mysqli_num_rows($user_con) > 0) {
			// Imprimimos un JSON con la informacion de respuesta en donde mostrara error porque ya existe
			echo json_encode(array('error' => true));
		}else{
			// Validamos si los password son iguales como segunda validacion ya que se realizo en antes de enviar el post
			if ($pass1==$pass2) {
				// Hacemos un hash con el pasword encriptando el mismo
				$passwordHash = password_hash($pass1, PASSWORD_DEFAULT);

				// Creando el query o consulta de  usuarios
				$qs_insert = "INSERT INTO usuario (codigo, usuario, email, clave, fecha_crea, fecha_act, tipo)
					VALUES(null, '$user', '$email', '$passwordHash', CURRENT_DATE, CURRENT_DATE, $tipo)";
				// Insertando el usuario con el query
				$insert = mysqli_query($conn, $qs_insert);

				$cuerpo = bienvenida_usuario($user, $email);

				$asunto = "Bienvenido a KodePrint";

				if (enviar_email($email, $user, $asunto, $cuerpo)) {
					echo json_encode(array('error' => false));
				}
			}
		}

	}
	
?>