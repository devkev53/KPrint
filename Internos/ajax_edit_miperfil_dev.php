<?php 
	// Recibimos los datos del formulario
	$codigo = strtoupper($_POST['codigo']);
	$nombres = strtoupper($_POST['nombres']);
	$apellidos = strtoupper($_POST['apellidos']);
	$tel = strtoupper($_POST['telefono']);
	$direc = strtoupper($_POST['direccion']);
	$depto = $_POST['depto'];
	$muni = $_POST['muni2'];
	$bio = strtoupper($_POST['bio']);

	// Hacemos la coneccion a la DB
	require '../database.php';

	// vamos a validar si el Desarrollador no exist
	$query_dev_val = "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador WHERE codigo=$codigo OR nombres='$nombres'";
	// Realizando la consulta
	$dev_con = mysqli_query($conn, $query_dev_val);
	// Verificamos si la consulta tiene resultados enviamos un error
	if (mysqli_num_rows($dev_con) < 1) {
		// Imprimimos un JSON con la informacion de respuesta en donde mostrara error porque ya existe
	?>
		<div class="alert alert-danger" role="alert">
		  A simple danger alert—check it out!
		</div>
	<?php
		echo $query_dev_val;
	}else{
		// Si encontro el Desarrollador buscamos su imagen para eliminarla
		$extraido = mysqli_fetch_array($dev_con); 

		if (empty($depto) or $depto=="none") {
			echo "El departamento viene";
			$depto = $extraido['codigodepto'];
		}
		if (empty($muni)) {
			echo "El Municipio viene vacio";
			$muni = $extraido['codigomuni'];
		}

		if (empty($_FILES['imagen2']['name'])) { 
			echo "no se cargo ningun archivo";
			$query_dev_edit = "UPDATE heroku_59b4c55ab4de36a.desarrollador SET nombres='$nombres', apellidos='$apellidos', telefono='$tel', direccion='$direc', codigodepto=$depto, codigomuni=$muni, bio='$bio' WHERE codigo=$codigo OR nombres='$nombres'";
		}else{

			// Obtenemos los datos de la nueva imagen
			$nombre_imagen = $_FILES['imagen2']['name'];
			$tipo_imagen = $_FILES['imagen2']['type'];
			$size_imagen = $_FILES['imagen2']['size'];

			echo "El Nombre de la nueva imagen es: ".$nombre_imagen;

			//echo "La imagen se cambiara";
			$ruta_img_antigua = 'uploads/avatares/'.$extraido['img'];
			// Eliminamos la imagen antigua del servicor
			unlink($ruta_img_antigua);
			// Procedemos a almacenar la nueva img*/
			$query_dev_edit = "UPDATE heroku_59b4c55ab4de36a.desarrollador SET nombres='$nombres', apellidos='$apellidos', telefono='$tel', direccion='$direc', codigodepto=$depto, codigomuni=$muni, img='$nombre_imagen', bio='$bio' WHERE codigo=$codigo OR nombres='$nombres'";

			echo $size_imagen;

			// Validamos el tamaño de la imagen
			if ($size_imagen<= 1000000) {
				# code...

				// Donde se guardara la imagen
				$carpeta_destino=$_SERVER['DOCUMENT_ROOT'] . '/KodePrint/Internos/uploads/avatares/';
				move_uploaded_file($_FILES['imagen2']['tmp_name'], $carpeta_destino.$nombre_imagen);

			}else{
				echo "Imagen demasiado grande para almacenar"; 
			}
		}

		// Insertando la actualizacion del Desarrollador con el query
		$update_dev = mysqli_query($conn, $query_dev_edit);

	}
	header('location: ../Internos/mi_perfil.php');

?>
