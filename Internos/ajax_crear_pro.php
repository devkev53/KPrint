<?php
	// Hacemos la coneccion a la DB
	require '../database.php';

	$nombre = strtoupper($_POST['nombre']); 	
	$descripcion = strtoupper($_POST['bio']); 	
	$url_video = $_POST['video']; 	
	$devs = $_POST['devs']; 	
	$codigousuario = strtoupper($_POST['usuario']);
	// Datos de la Imagen
	$nombre_imagen = $_FILES['imagen']['name'];
	$tipo_imagen = $_FILES['imagen']['type'];
	$size_imagen = $_FILES['imagen']['size'];

	// Procedemos a Guardar la Imagen

	// Validamos el tamaño de la imagen
	if ($size_imagen<= 1000000) {
		# code...

		// Donde se guardara la imagen
		$carpeta_destino=$_SERVER['DOCUMENT_ROOT'] . '/KodePrint/Internos/uploads/proyects_img/';
		move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino.$nombre_imagen);

	}else{
		echo "Imagen demasiado grande para almacenar"; 
	}

	// Creando el query para insertar el Proyecto
	$qs_insert = "INSERT INTO heroku_59b4c55ab4de36a.proyecto (nombre, descripcion, url_video, fecha_crea, img, codigousuario)
		VALUES('$nombre', '$descripcion', '$url_video', CURRENT_DATE, '$nombre_imagen', $codigousuario)";
	// Insertando el usuario con el query
	$insert = mysqli_query($conn, $qs_insert);

	echo $qs_insert;

	//   ----   YA QUE SE INSERTO EL PROYECTO NECESITAMOS SABER EL CODIGO DEL MISMO POR UNA CONSULTA ---    
	$query_pro_consult = "SELECT codigo FROM heroku_59b4c55ab4de36a.proyecto WHERE nombre='$nombre' AND codigousuario=$codigousuario";
	$pro_consult = mysqli_query($conn, $query_pro_consult);

	// Extraemos los datos del Desarrollador
	$extraido = mysqli_fetch_array($pro_consult);

	$pro_codigo = $extraido['codigo'];
	echo "<p></p>";
	echo $pro_codigo;
	echo "<p></p>";

	// Creando el query para insertar la realacion Muchoas a Muchos de Desarrollador_Proyecto

	// Para esto se debe recorrer el dato devs para insertar una fila por desarrollador
	for ($i=0; $i < count($devs); $i++) {
		$qs_insert = "INSERT INTO heroku_59b4c55ab4de36a.desarrollador_proyecto (codigo, fk_dev, fK_pro)
			VALUES(null, $devs[$i], $pro_codigo)";
		// Insertando el usuario con el query
		$insert = mysqli_query($conn, $qs_insert);
	}
	



	
	echo 'Nombre: '.$nombre;
	echo "<br>";
	echo 'Descripcion: '.$descripcion;
	echo "<br>";
	echo 'URL Video: '.$url_video;
	echo "<br>";
	echo 'Nombre Imagen: '.$nombre_imagen;
	echo "<br>";	
	echo 'Usuario Creador: '.$codigousuario;
	echo "<br>";
	echo 'Desarrolladores: ';
	echo "<br>";
	for ($i=0; $i < count($devs); $i++) { 
		echo $devs[$i];
	}

	mysqli_close($conn);
	header('Location: mi_portafolio.php');
?>
