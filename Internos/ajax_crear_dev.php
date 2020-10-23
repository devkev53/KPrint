<?php 
	// Recibimos los datos de la imagen
	$nombre_imagen = $_FILES['imagen']['name'];
	$tipo_imagen = $_FILES['imagen']['type'];
	$size_imagen = $_FILES['imagen']['size'];

	// Validamos el tamaño de la imagen
	if ($size_imagen<= 1000000) {
		# code...

		// Donde se guardara la imagen
		$carpeta_destino=$_SERVER['DOCUMENT_ROOT'] . '/KodePrint/Internos/uploads/avatares/';
		move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino.$nombre_imagen);

	}else{
		echo "Imagen demasiado grande para almacenar"; 
	}

	$user = strtoupper($_POST['usuario']);
	$email = strtoupper($_POST['correo']);
	$pass1 = strtoupper($_POST['contraseña1']);
	$pass2 = strtoupper($_POST['contraseña1']);
	$tipo = 1;

	// Hacemos la coneccion a la DB
	require '../database.php';

	require '../prueba_correo.php';
	require '../correo_bienvenida.php';

	// vamos a validar si el usuario no exist
	$query_user_val = "SELECT * FROM usuario WHERE usuario ='$user' OR email='$email'";
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

			// Antes de crear el profesor como ya existe el usuario buscamos el codigo del usuario
			
			// Realizando la consulta de BUSCEDA de USUARIO
			$new_user = mysqli_query($conn, $query_user_val);
			// Extraemos el dato
			$extraido = mysqli_fetch_array($new_user); 
			$codigo = $extraido['codigo'];

			$nombres = strtoupper($_POST['nombres']);
			$apellidos = strtoupper($_POST['apellidos']);
			$tel = strtoupper($_POST['telefono']);
			$direc = strtoupper($_POST['direccion']);
			$depto = $_POST['depto'];
			$muni = $_POST['muni'];
			$bio = strtoupper($_POST['bio']);

			$qs_insert_dev = "INSERT INTO desarrollador (codigo, nombres, apellidos, telefono, direccion, codigodepto, codigomuni, codigousuario, img, bio)
				VALUES(null, '$nombres', '$apellidos', '$tel', '$direc', $depto, $muni, $codigo, '$nombre_imagen', '$bio')";

			// Insertando el Desarrollador con el query
			$insert_dev = mysqli_query($conn, $qs_insert_dev);

		}
	}
	header('location: ../Internos/desarrolladores');
?>