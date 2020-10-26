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
				<div class="row">
					<div class="col d-flex justify-content-center">
						<h2 class="tile">
							<i class="icon-emoji_people mr-2"></i>
							Quienes Somos
						</h2>
					</div>
				</div>
				
				<div class="contenido_main col-12">
					<div class="row d-flex justify-content-center">
						<div class="col-12">
							<p align="justify">Somos organización guatemalteca formada por un pequeño grupo de estudiantes, amigos y profesionales que se ha propuesto estar al servicio de quienes necesiten una solución tecnológica, brindado servicios de desarrollo de software.</p>
							<p align="justify"><b>KodePrint</b> nació como un proyecto de desarrollo realizado en la universidad, en donde compañeros estudiantes de la carrera de Ingeniería en Sistemas aportaron sus conocimientos en tecnología, tanto del lado del back-end como el front-end, realizando así varios proyectos, personales y proyectos para instituciones, los cuales se realizaban por medio de la facultad de Ingeniería en Sistemas de la Universidad Mariano Gálvez de Guatemala.</p>
						</div>	
					</div>
					<div class="row">
							<div class="col-12 col-lg-6">
								<h4 align="center">
									<i class="icon-hardware mr-2"></i>
									Misión
								</h4>
								<p align="justify">Desarrollar una empresa dedicada a la creación e implementación de productos y servicios de software apoyándonos permanentemente en criterios innovadores y tecnologías en evolución.</p>

								<p align="justify">Para lograr estos objetivos es fundamental contar con un equipo de profesionales altamente capacitados, y con la motivación y compromiso necesarios para proveer un alto valor agregado a nuestros clientes.</p>

								<p align="justify">Con la convicción que tanto el conocimiento y capacitad técnica como la calidad del servicio de atención al cliente son las que diferencian a las Empresas Líderes, ponemos todo el esfuerzo en mejorarlos sostenidamente.</p>
							</div>
							<div class="col-12 col-lg-6">
								<h4 align="center">
									<i class="icon-eye3 mr-2"></i>
									Visión
								</h4>
								<p align="justify">En un mundo estrechamente interrelacionado por las tecnologías de información, ser líder global en la provisión de soluciones innovadoras de software.</p>

								<p align="justify">Prestando nuestros servicios primeramente a nivel nacional, hasta lograr expandirse mediante el apoyo y satisfacción de nuestros clientes, los cuales son parte fundamental para toda organización, logrando así alcanzar un estatus a nivel mundial.</p>
							</div>
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