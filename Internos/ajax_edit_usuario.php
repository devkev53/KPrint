<?php 
	$user = $_POST['usuario'];
	$email = $_POST['correo'];
	$tipo = $_POST['tipo'];

	// Hacemos la coneccion a la DB
	require '../database.php';

	// vamos a validar si el usuario no exist
	$query_user_val = "UPDATE heroku_59b4c55ab4de36a.usuario SET email='$email', tipo=$tipo WHERE usuario='$user' OR email='$email'";
	// Realizando la consulta
	$user_con = mysqli_query($conn, $query_user_val);

	echo $query_user_val;
?>