<?php 
	$codigo = $_POST['codigo'];
	$nombres = $_POST['nombres'];
	$inline = $_POST['usuario_inline'];

	// Hacemos la coneccion a la DB
	require '../database.php';

	// Realizando la consulta de BUSCEDA de Desarrollador
	$dev = mysqli_query($conn, "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador WHERE codigo ='$codigo' OR nombres='$nombres'");
	
	// Extraemos el dato
	$extraido = mysqli_fetch_array($dev); 

	// Tomamos el codigo del Desarrollador
	$codigo_user = $extraido['codigousuario'];


	// Ahora preguntamos si el Desarrollador tiene algun perfil de usaurio
	$user = mysqli_query($conn, "SELECT * FROM heroku_59b4c55ab4de36a.usuario WHERE codigo=$codigo_user");

	// Validamos si nuestra consulta trajo algun resultado
	if (mysqli_num_rows($user) > 0) {

		echo "Encontro un Usuario";

		// Eliminamos el dato que se encontro
		//$user_delete = mysqli_query($conn, "DELETE FROM heroku_59b4c55ab4de36a.usuario WHERE codigo=$codigo_user");
	}

	// Realizando la consulta
	//$dev_con = mysqli_query($conn, "DELETE FROM heroku_59b4c55ab4de36a.desarrollador WHERE codigo=$codigo");

	// Verificamos si el usuario que se elimino era el usuario en linea
/*
	if ($user==$inline) {
		header('location: ../logout.php');
	}else{
		header('location: ../Internos/desarrolladores.php');
	}
	*/
?>
