<?php 
	$user = $_POST['usuario'];
	$email = $_POST['correo'];
	$inline = $_POST['usuario_inline'];

	// Hacemos la coneccion a la DB
	require '../database.php';

	// Realizando la consulta de BUSCEDA de USUARIO
	$user = mysqli_query($conn, "SELECT * FROM heroku_59b4c55ab4de36a.usuario WHERE usuario ='$user' OR email='$email'");
	
	// Extraemos el dato
	$extraido = mysqli_fetch_array($user); 

	// Tomamos el codigo del usuario
	$codigo = $extraido['codigo'];


	// Ahora preguntamos si el usuario tiene algun perfil de desarrollador
	$dev = mysqli_query($conn, "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador WHERE codigousuario=$codigo");

	// Validamos si nuestra consulta trajo algun resultado
	if (mysqli_num_rows($dev) > 0) {

		echo "Encontro un desarrollador";

		// Eliminamos el dato que se encontro
		$dev_delete = mysqli_query($conn, "DELETE FROM heroku_59b4c55ab4de36a.desarrollador WHERE codigousuario=$codigo");
	}

	// Realizando la consulta
	$user_con = mysqli_query($conn, "DELETE FROM heroku_59b4c55ab4de36a.usuario WHERE codigo=$codigo");

	// Verificamos si el usuario que se elimino era el usuario en linea
	if ($user==$inline) {
		header('location: ../logout');
	}
?>