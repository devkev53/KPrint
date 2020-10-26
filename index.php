<?php
	session_start();

	if (isset($_SESSION['usuario'])) {
		// if ($_SESSION['usuario']['tipousuario'] != 3) {
			//header('location: ../Profesor/vistaProfesor.php');
		//}
		header('location: Internos/portafolio_in.php');
	}else{
		echo "Necesita redirigirte";
		header('Location: Externos/portafolio.php');
	} 
?>