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
	
</head>
<body>
	<header>
		<div class="container contenido">

			<!-- Menu de Navegacion -->
			<?php require 'menu_externos.php' ?>

		</div>
	</header>

	<main>
		<div class="container">
			<div class="porfolio rounded">

				<div class="contenido_main col-12 container-fluid">
					<div class="row">
						<div class="col d-flex justify-content-center">
							<h2 class="tile">
								<i class="icon-mail7 mr-2"></i>
								Contactanos
							</h2>
						</div>
					</div>

					<!-- Formulario de Correo -->
					<div class="row justify-content-center">
						<div class="col-8">
							<form action="" class="form-contacto">
								<div class="">
									<div class="row">
									    <div class="col-12 col-lg-6 mb-3">
									      	<input type="text" class="form-control" placeholder="Ingresa tu nombre" required>
									    </div>
									    <div class="col-12 col-lg-6 mb-3">
									      	<input type="email" class="form-control" placeholder="Ingresa tu Correo electrónico" required>
									    </div>
								  	</div>
								  	<textarea class="form-control mb-3" name="mensaje" placeholder="Cuentanos como te podemos ayudar..!" required></textarea>
								  	<div class="col mb-3" align="center">
								  		<button class="btn btn-primary">
											<span class="icon-send-o"></span>
											Enviar Correo
										</button>
								  	</div>
								</div>
							</form>
						</div>
					</div>

					<!-- Whatshap -->
					<div class="row">
						<div class="col justify-content-center">
							<div class="col-12" align="center">
								<h3 class="title title-whats">Tambien nos puedes contactar por:</h3>	
							</div>
							<div class="col-12" align="center">
								<a class="what_link" href="https://api.whatsapp.com/send?phone=50241049865" target="blank">
									<span class="icon-whatsapp1"></span>
								</a>
							</div>
						</div>
					</div>
				</div>

			</div>			
		</div>
	</main>

	<?php
		require '../footer.php'; 
	?>
	

<!-- JQuery 3.5.1 -->
<script src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="../Recursos/Bootstrap/js/bootstrap.min.js"></script>

</body>
</html>