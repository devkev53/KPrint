<?php
	session_start();

	// Importamos la coneccion a la DB
	require '../database.php';

	// Consultamos los Proyectos
	$query_users = "SELECT * FROM heroku_59b4c55ab4de36a.usuario";

	// Realizamos la consulta
	$users = mysqli_query($conn, $query_users);

	// No de usuarios encontados
	$no_Users = $users->num_rows;
	
	//echo $no_Users;

	// Consultamos los Proyectos
	$query_pro = "SELECT * FROM heroku_59b4c55ab4de36a.proyecto";

	// Consultamos los Proyectos BD Heroku
	//$query_pro = "SELECT * FROM heroku_59b4c55ab4de36a.proyecto;";


	// Realizamos la consulta
	$pro = mysqli_query($conn, $query_pro);

	// No de Proyectos encontados
	$no_pro = $pro->num_rows;
	//echo $no_pro;
	$pro_x_pagina = 3;
	// No de paginas a mostrar
	$paginas = ceil($no_pro/$pro_x_pagina);
	if ($paginas<=0) {
		$paginas += 1;
	}
	//echo $paginas;

	if (!$_GET) {
		header('Location: portafolio.php?pagina=1');
	}

	$iniciar = ($_GET['pagina']-1)*$pro_x_pagina;
	// echo $iniciar;

	// Validando para los paginadores

	if ($_GET['pagina']>$paginas) {
		header('Location: portafolio.php?pagina='.$paginas);
	}
	if ($_GET['pagina']<=0) {
		header('Location: portafolio.php?pagina=1');
	}
	if (!is_numeric ($_GET['pagina'])) {
		header('Location: portafolio.php?pagina=1');
	}

	// Traemos solo los desarrolladores por paginas es decir solo 2 desarrolladores por pagina
	$sql_pros_pag = "SELECT * FROM heroku_59b4c55ab4de36a.proyecto LIMIT $iniciar, $pro_x_pagina";

	// Traemos solo los desarrolladores por paginas es decir solo 2 desarrolladores por pagina BD Heroku
	//$sql_pros_pag = "SELECT * FROM heroku_59b4c55ab4de36a.proyecto LIMIT $iniciar, $pro_x_pagina";

	$pro_pag = mysqli_query($conn, $sql_pros_pag);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Portafolio | KodePrint</title>
	<link rel="shortcut icon" href="../Recursos/img/kp_black.png">

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

			<!-- Slider -->
			<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
				    <div class="carousel-item active">
				      	<img src="../Recursos/img/3.png" class="d-block w-100" alt="...">
				    </div>
				    <div class="carousel-item">
				      	<img src="../Recursos/img/1.png" class="d-block w-100" alt="...">
				    </div>
				    <div class="carousel-item">
				      	<img src="../Recursos/img/2.png" class="d-block w-100" alt="...">
				    </div>
				</div>
				  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
			</div>

		</div>
	</header>

	<main>
		<div class="container">
			<div class="porfolio rounded">
				<div class="">
					<div class="d-flex bd-highlight">
					  <div class="p-2 w-100 bd-highlight">
					  	<h2 class="tile d-flex justify-content-center">
							<i class="icon-work_outline"></i>
							Proyectos Registrados en KodePrint..!
						</h2>
					  </div>
					  <!--div class="p-2 flex-shrink-1 bd-highlight d-flex align-items-center">
					  	<button class="btn btn-outline-success" onclick="nuevo_proyecto()"><i class="icon-plus1"></i></button>
					  </div-->
					</div>
				</div>

				<div class="row">
					<div class="contenido_main col-12 container-fluid">
						<!-- Validando si no existen proyectos -->
						<?php if (mysqli_num_rows($pro_pag) < 1){?>
							<div class="col alert alert-danger" role="alert" align="center">
							  	No tienes ningun proyecto registrado..!
							</div>
						<?php }else{ ?>
							<!-- -- *** MOSTRANDO PROYECTOS *** -- -->

								<?php 		while ($row = mysqli_fetch_array($pro_pag)) {?>
									<div class="container contenedor_total d-flex justify-content-center">

										<a class="d-flex col-12 col-lg-10 contenedor_proyecto" data-toggle="tooltip" data-placement="top" title="Ver Datos del Proyecto" href="proyecto.php?identificador=<?php echo $row['codigo'] ?>">
											<div class="bg-white proyecto_pre d-flex align-items-center">

												<!-- Informacion -->
												<div class="col-5 informacion d-flex align-items-stretch">
													<div class="row">

														<!-- Titulo Proyecto -->
														<div class="col-12 title align-items-start">
															<h5 class="card-title title"><?php echo $row['nombre']?></h5>
														</div>

														<!-- Subtitulo Desarrolladores -->
														<div class="col-12 d-flex-aling-items-center">
														    <div class="d-flex justify-content-center">
														       	<h5 class="text-muted">Desarrolladores</h5>
														    </div>

														    <!-- Imagenes Devs -->
														    <div class="d-flex justify-content-center">
															    <?php
															    // Traemos los devs que participaron en el proyecto
															    $codigo_proyecto = $row['codigo'];
																
																// BD Heroku															    
															    //$q_devs = "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador_proyecto D INNER JOIN heroku_59b4c55ab4de36a.proyecto ON D.fk_pro WHERE D.fk_pro=$codigo_proyecto AND // BD Heroku.proyecto.codigo=$codigo_proyecto";

															    $q_devs = "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador_proyecto D INNER JOIN heroku_59b4c55ab4de36a.proyecto ON D.fk_pro WHERE D.fk_pro=$codigo_proyecto AND heroku_59b4c55ab4de36a.proyecto.codigo=$codigo_proyecto";

															    $q_conn_devs = mysqli_query($conn, $q_devs);

															    while ($row_dev = mysqli_fetch_array($q_conn_devs)) {
																    $id_dev = $row_dev['fk_dev'];

																    $q_img_devs = "SELECT img FROM heroku_59b4c55ab4de36a.desarrollador WHERE codigo=$id_dev";

																    // BD Heroku
																    //$q_img_devs = "SELECT img FROM heroku_59b4c55ab4de36a.desarrollador WHERE codigo=$id_dev";	
																	$q_conn_img = mysqli_query($conn, $q_img_devs);

																	while ($img_row = mysqli_fetch_array($q_conn_img)) {
																	    echo "<img class='rounded-circle shadow p-1 mr-2 bg-white' width='70' src='../Internos/uploads/avatares/".$img_row['img']."''></img>";
																    }
															    }

															    ?>
														    </div>
														</div>

													    <div class="col-12 d-flex align-items-end justify-content-end">
														    <p class="card-text"><small class="text-muted">Publicado: <?php echo $row['fecha_crea']?></small></p>
														</div>
													</div>
												</div>

												<!-- Imagen -->
												<div class="col-7">
													<img src="../Internos/uploads/proyects_img/<?php echo $row['img']?>" class="img-fluid img-thumbnail rounded shadow p-1 bg-white" alt="...">
												</div>
											</div>
										</a>
										
									</div>
								<?php } 
						 } ?>
						<!-- Boton Agregar -->
						<hr>
						<!--div class="col d-flex justify-content-center">
							<button class="btn btn-success" onclick="nuevo_proyecto()"><i class="icon-plus1"></i> Agregar Proyecto</button>
						</div-->
					</div>
				</div>	

				<!-- Paginador -->
				<div class="row">
					<div class="container">
						
							<nav aria-label="Page navigation example">
								<ul class="pagination justify-content-center">
								    <li class="page-item 
								    <?php echo $_GET['pagina']<=1 ? 'disabled' : '' ?>">
								      	<a class="page-link" 
								      	href="portafolio.php?pagina=<?php echo $_GET['pagina']-1; ?>">
								      		Anterior
								      	</a>
								    </li>

								    <!-- Numeros que se mostraran en al paginacion -->
								    <?php for ($i=0; $i < $paginas; $i++):?>
								    	<li class="page-item 
								    	<?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>">
								    		<a class="page-link" href="portafolio.php?pagina=<?php echo $i+1; ?>"> <?php echo $i+1; ?> </a>
								    	</li>
								    <?php endfor ?>

								    <li class="page-item
								    <?php echo $_GET['pagina']>=$paginas ? 'disabled' : '' ?>">
								      	<a class="page-link" href="portafolio.php?pagina=<?php echo $_GET['pagina']+1; ?>">
								      		Siguiente
								      	</a>
								    </li>
							  	</ul>
							</nav>
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

</body>
</html>
