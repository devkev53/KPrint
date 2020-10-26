<?php 
	session_start();

	// Importamos la coneccion a la DB
	require '../database.php';
	
	// Consultamos los usuarios
	$query_users = "SELECT * FROM heroku_59b4c55ab4de36a.usuario";
	
	// Realizamos la consulta
	$users = mysqli_query($conn, $query_users);

	// No de usuarios encontados
	$no_Users = $users->num_rows;
	
	echo $no_Users;

	$codigo_pro=$_GET['identificador'];

	$qs_pro = "SELECT * FROM heroku_59b4c55ab4de36a.proyecto WHERE heroku_59b4c55ab4de36a.proyecto.codigo=$codigo_pro";

	$execute = mysqli_query($conn, $qs_pro);

	$extraido = mysqli_fetch_array($execute);

	if (!$extraido) {
		header('location: ../404_page');
	}
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
	<link rel="stylesheet" href="../Recursos/jquery-confirm/css/jquery-confirm.css">
	
</head>
<body>
	<header>
		<div class="container contenido">

			<!-- Menu de Navegacion -->
			<?php require 'menu_externos.php'; ?>

		</div>
	</header>

	<main>
		<div class="container">
			<div class="porfolio rounded">

				<div class="row">
					<div class="col d-flex justify-content-center">
						<h2 class="tile col-8" align="center">
							<i class="icon-profile"></i>
							<?php echo $extraido['nombre'] ?>
						</h2>
					</div>
				</div>

				<div class="row d-flex justify-content-center">
					<div class="container users_table pl-5 pr-5">

						<!-- Linea de Imagen y video -->
						<div class="row">
							<div class="col-md-12 col-lg-7 d-flex align-items-center">
								<img src="../Internos/uploads/proyects_img/<?php echo $extraido['img'] ?>" class="img-fluid img-thumbnail shadow" alt="">
							</div>
							<div class="col-md-12 col-lg-5 d-flex align-items-center">
								<?php if ($extraido['url_video']) { ?>
									<div class="embed-responsive embed-responsive-4by3 my-1 d-inline-flex p-3 bg-primary text-white rounded">
				                        <iframe class="embed-responsive-item" src='<?php echo $extraido['url_video'] ?>' frameborder="0" allowfullscreen></iframe>
				                    </div>
								<?php }else{ ?>
									<img src="../Recursos/img/not_found.jpg" class="rounded img-fluid" alt="">
								<?php } ?>								
							</div>
						</div>
						<hr>
						<!-- Descripcion -->
						<div class="row d-flex justify-content-center">
							<div class="col-md-12 col-lg-10 d-flex align-items-center">
								<p align="justify"><?php echo $extraido['descripcion'] ?></p>								
							</div>
						</div>
						<hr>
						<!-- Desarrolladores -->
						<div class="row">
							<div class="col-12">
								<h3 class="title d-flex justify-content-center text-muted">Desarrolladores</h3>
							</div>
							<div class="col-12 d-flex justify-content-center">
								<?php 
								$q_devs = "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador_proyecto D INNER JOIN heroku_59b4c55ab4de36a.proyecto ON D.fk_pro WHERE D.fk_pro=$codigo_pro AND heroku_59b4c55ab4de36a.proyecto.codigo=$codigo_pro";

								$q_conn_devs = mysqli_query($conn, $q_devs);

								while ($row_dev = mysqli_fetch_array($q_conn_devs)) {
								    $id_dev = $row_dev['fk_dev'];

								    $q_img_devs = "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador WHERE codigo=$id_dev";	
									$q_conn_img = mysqli_query($conn, $q_img_devs);

									while ($img_row = mysqli_fetch_array($q_conn_img)) {
										echo "<div class='mr-4'>";
									    echo "<img class='rounded-circle shadow p-1 mr-2 bg-white img_avatars_devs_pro' src='../Internos/uploads/avatares/".$img_row['img']."''></img>";
									    echo "<p class='title d-flex justify-content-center text-muted'>".$img_row['nombres']."</p>";
									    echo "</div>";
								    }
								}
								?>
							</div>
						</div>
						<hr>

					</div>
				</div>
			</div>
		</div>
	</main>

	<div id="respuesta"></div>
	<?php require '../footer.php' ?>
	
	

	<!-- JQuery 3.5.1 -->
	<script src="../Recursos/Js/jquery-3.5.1.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="../Recursos/Bootstrap/js/bootstrap.min.js"></script>
	<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
	<script src="../Recursos/jquery-confirm/js/jquery-confirm.js"></script>
	<!-- CARGANDO Jquery Mask-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

</body>
</html>
