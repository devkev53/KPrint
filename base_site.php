<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="../Recursos/Bootstrap/css/bootstrap.min.css">
	<!-- Fuentes de Google -->
	<link href="https://fonts.googleapis.com/css2?family=IM+Fell+Great+Primer+SC&display=swap" rel="stylesheet">
	<!-- Mis Estilos -->
	<link rel="stylesheet" type="text/css" href="../Recursos/Css/Estilso.css">
	<!-- Mis Estilos -->
	<link rel="stylesheet" type="text/css" href="../Recursos/font-kp/fonts/style.css">
	<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
	<link rel="stylesheet" href="../Recursos/jquery-confirm-v3.3.4/css/jquery-confirm.css">
	
</head>
<body>
	<header>
		<div class="container contenido">

			<!-- Menu de Navegacion -->
			<?php require 'menu_internos.php' ?>

		</div>
	</header>

	<main>
		<div class="container">
			<div class="porfolio rounded">
				<div class="row">
					<div class="col d-flex justify-content-center">
						<h2 class="tile">
							<i class="icon-work_outline"></i>
							Portafolio de Proyectos
						</h2>
					</div>
				</div>
			</div>
		</div>
	</main>

	<?php require '../footer.php' ?>
	
	

<!-- JQuery 3.5.1 -->
<script src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="../Recursos/Bootstrap/js/bootstrap.min.js"></script>
<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
<script src="../Recursos/jquery-confirm-v3.3.4/js/jquery-confirm.js"></script>

</body>
</html>