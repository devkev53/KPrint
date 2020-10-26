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
	<link rel="stylesheet" href="Recursos/Bootstrap/css/bootstrap.min.css">
	<!-- Fuentes de Google -->
	<link href="https://fonts.googleapis.com/css2?family=IM+Fell+Great+Primer+SC&display=swap" rel="stylesheet">
	<!-- Mis Estilos -->
	<link rel="stylesheet" type="text/css" href="Recursos/Css/Estilso.css">
	<!-- Mis Estilos -->
	<link rel="stylesheet" type="text/css" href="Recursos/font-kp/fonts/style.css">
	
</head>
<body>
	<header>
		<div class="container contenido">

			<!-- Menu de Navegacion -->
			<?php //require 'Externos/menu_externos.php' ?>

		</div>
	</header>

	<main>
		<div class="container mb-5">
			<div class="porfolio rounded" style="border-top: 10px solid red">
				<div class="row">
					<div class="col d-flex text-danger justify-content-center">
						<h2 class="tile text-danger">
							<i class="icon-cloud-error1 mr-2"></i>
							Eror 404 Pagina no encontrada..!
						</h2>
					</div>
				</div>
				
				<div class="contenido_main col-12 d-flex justify-content-center">
					<img src="https://i.pinimg.com/originals/2e/b4/12/2eb4120ff4df5c3800a523fcdaf347fb.gif" class="d-flex justify-content-center" width="500">
				</div>		
				
			</div>			
		</div>
	</main>

	<?php //require 'footer.php' ?>
	
	

<!-- JQuery 3.5.1 -->
<script src="Recursos/Js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="Recursos/Bootstrap/js/bootstrap.min.js"></script>

</body>
</html>