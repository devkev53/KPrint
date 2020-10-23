<?php
	$codigo=$_POST['codigo'];

	// Importamos la coneccion a la DB
	require '../database.php';

	$qs_dev_pro = "SELECT * FROM desarrollador_proyecto WHERE fk_pro=$codigo";

	$execute_1 = mysqli_query($conn, $qs_dev_pro);

	// Recorremos para eliminar
	while ($row = mysqli_fetch_array($execute_1)) {
		$codigo_linea = $row['codigo'];
		$execute_2 = mysqli_query($conn, "DELETE FROM desarrollador_proyecto WHERE codigo=$codigo_linea");
		echo "Se elimino la relacion dev y proyecto con el ID: ".$codigo_linea;
	}

	// Ya que eliminamos las lineas ahora eliminamos el proyecto
	$execute_3 = mysqli_query($conn, "DELETE FROM proyecto WHERE codigo=$codigo");
	echo "Se elimino el proyecto con el ID: ".$codigo;
?>