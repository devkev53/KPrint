<?php
// Hacemos la coneccion a la DB
require 'database.php';
// Retrasar la ejecucucion
sleep(1);
session_start();
// Tomando las variables
$nombre = $_POST['usuario'];
$pass = $_POST['contraseña'];

// Creando el query o consulta de  usuarios Local Host Heroku	
$qs = "SELECT * FROM heroku_59b4c55ab4de36a.usuario WHERE usuario ='$nombre' OR email='$nombre'";

// Creando el query o consulta de  DB Heroku

// Realizando la consulta
$usuarios = mysqli_query($conn, $qs);

// Verificamos si la consulta regreso un resultado
if (mysqli_num_rows($usuarios) > 0) {
	// Creamos una cadena asosciativa con la funcion fetch
	$datos = $usuarios->fetch_assoc();
	
	if (password_verify($pass, $datos['clave'])) {
		// Creamos la variable de sesion
		$_SESSION['usuario'] = $datos;
		
		// Imprimimos un JSON con la informacion de respuesta
		echo json_encode(array('error' => false, 'tipo' => $datos['tipo']));
	}else{
		// Imprimimos un JSON con la informacion de respuesta
		echo json_encode(array('error' => true));
	}
}else{
	// Imprimimos un JSON con la informacion de respuesta
	echo json_encode(array('error' => true));
}
mysqli_close($conn);
?>