<?php
	session_start();

	if (isset($_SESSION['usuario'])) {
		if ($_SESSION['usuario']['tipo'] != 1) {
			header('location: ../Externos/login');
		}
	}else{
		header('Location: ../Externos/login');
	}
	
	// Obtenemos el codigo logueado
	$user_inline = $_SESSION['usuario']['codigo'];

	// Importamos la coneccion a la DB
	require '../database.php';

	function mostrarDevs() {
		// Importamos la coneccion a la DB
		require '../database.php';

		// enviando el comando SQL
		$devs = mysqli_query($conn, "SELECT * FROM desarrollador order by nombres");

		//echo $devs->num_rows;
		
	    if (mysqli_num_rows($devs) < 1) {
	    	echo "<span class='text-danger'>No hay Desarrolladores Registrados..!</span>";
	    }else{
	    	echo "<select multiple  class='form-control mb-2' name='devs[]' id='devs'>";
	        while ($row = mysqli_fetch_array($devs)) {
	            echo "<option value=" . $row['codigo'] . ">" . $row['nombres']. ' ' .$row['apellidos'];
	            echo "</option>";
	        } 			
	        echo "</select>";
	    }
	};

	// Consultamos los Proyectos
	$query_pro = "SELECT * FROM proyecto WHERE codigousuario=$user_inline";
	// Realizamos la consulta
	$pro = mysqli_query($conn, $query_pro);

	// No de Proyectos encontados
	$no_pro = $pro->num_rows;
	//echo $no_pro;
	$pro_x_pagina = 4;
	// No de paginas a mostrar
	$paginas = ceil($no_pro/$pro_x_pagina);
	if ($paginas<=0) {
		$paginas += 1;
	}
	//echo $paginas;

	if (!$_GET) {
		header('Location: mi_portafolio.php?pagina=1');
	}

	$iniciar = ($_GET['pagina']-1)*$pro_x_pagina;
	// echo $iniciar;

	if ($_GET['pagina']>$paginas) {
		header('Location: mi_portafolio.php?pagina='.$paginas);
	}
	if ($_GET['pagina']<=0) {
		header('Location: mi_portafolio.php?pagina=1');
	}
	if (!is_numeric ($_GET['pagina'])) {
		header('Location: mi_portafolio.php?pagina=1');
	}

	// Traemos solo los desarrolladores por paginas es decir solo 2 desarrolladores por pagina
	$sql_pros_pag = "SELECT * FROM proyecto WHERE codigousuario=$user_inline LIMIT $iniciar, $pro_x_pagina";
	$pro_pag = mysqli_query($conn, $sql_pros_pag);

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
	<!-- Mis Fuentes -->
	<link rel="stylesheet" type="text/css" href="../Recursos/font-kp/fonts/style.css">
	<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
	<link rel="stylesheet" href="../Recursos/jquery-confirm/css/jquery-confirm.css">
	
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
				<div class="">
					<div class="d-flex bd-highlight">
					  <div class="p-2 w-100 bd-highlight">
					  	<h2 class="tile d-flex justify-content-center pl-5 ml-4">
							<i class="icon-work_outline"></i>
							Mi Portafolio de Proyectos
						</h2>
					  </div>
					  <div class="p-2 flex-shrink-1 bd-highlight d-flex align-items-center">
					  	<button class="btn btn-outline-success" onclick="nuevo_proyecto()"><i class="icon-plus1"></i></button>
					  </div>
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

										<a class="d-flex col-12 col-lg-10 contenedor_proyecto" data-toggle="tooltip" data-placement="top" title="Ver Datos del Proyecto" href="proyecto_in?identificador=<?php echo $row['codigo'] ?>">
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
															    $q_devs = "SELECT * FROM desarrollador_proyecto D INNER JOIN proyecto ON D.fk_pro WHERE D.fk_pro=$codigo_proyecto AND proyecto.codigo=$codigo_proyecto";

															    $q_conn_devs = mysqli_query($conn, $q_devs);

															    while ($row_dev = mysqli_fetch_array($q_conn_devs)) {
																    $id_dev = $row_dev['fk_dev'];

																    $q_img_devs = "SELECT img FROM desarrollador WHERE codigo=$id_dev";	
																	$q_conn_img = mysqli_query($conn, $q_img_devs);

																	while ($img_row = mysqli_fetch_array($q_conn_img)) {
																	    echo "<img class='rounded-circle shadow p-1 mr-2 bg-white' width='50' src='uploads/avatares/".$img_row['img']."''></img>";
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
													<img src="uploads/proyects_img/<?php echo $row['img']?>" class="img-fluid img-thumbnail rounded shadow p-1 bg-white" alt="...">
												</div>
											</div>
										</a>
										
									</div>
								<?php } 
						 } ?>
						<!-- Boton Agregar -->
						<hr>
						<div class="col d-flex justify-content-center">
							<button class="btn btn-success" onclick="nuevo_proyecto()"><i class="icon-plus1"></i> Agregar Proyecto</button>
						</div>
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
								      	href="mi_portafolio.php?pagina=<?php echo $_GET['pagina']-1; ?>">
								      		Anterior
								      	</a>
								    </li>

								    <!-- Numeros que se mostraran en al paginacion -->
								    <?php for ($i=0; $i < $paginas; $i++):?>
								    	<li class="page-item 
								    	<?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>">
								    		<a class="page-link" href="mi_portafolio.php?pagina=<?php echo $i+1; ?>"> <?php echo $i+1; ?> </a>
								    	</li>
								    <?php endfor ?>

								    <li class="page-item
								    <?php echo $_GET['pagina']>=$paginas ? 'disabled' : '' ?>">
								      	<a class="page-link" href="mi_portafolio.php?pagina=<?php echo $_GET['pagina']+1; ?>">
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

	<!-- Agregar Proyecto Modal -->
	<form enctype="multipart/form-data" method="POST" action="ajax_crear_pro.php" id="add_pro_form">
		<div class="modal fade" id="add_pro_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered modal-lg">
		    <div class="modal-content new">
		      <div class="modal-header">
		        <h5 class="modal-title title text-primary" id="exampleModalLabel"> <i class="icon-file-code-o"></i> Registrar Nuevo Proyecto</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="col-12 text-uppercase">
		      		<input type="text" name="usuario" id="inline_user" hidden="hidden">
		      		<input type="text" name="nombre" class="form-control mb-3" placeholder="Ingrese el Nombre o Alias del Proyecto" required>
		      		<input type="text" name="video" class="form-control mb-3" placeholder="Ingrese una url para mostrar un video">
		      		<div>
						<textarea name="bio" class="form-control" rows="3" id="info_dev" maxlength="800" placeholder="Ingrese una descripcion de lo que es este proyecto..!" required></textarea>
						<div id="contador" align="right" style="color: #aaa;">0/800</div>
					</div>
					<?php mostrarDevs() ?>
		      		<div class="row d-flex align-items-center">
		      			<!-- Btn Subir Imagen -->
		      			<div class="col img_dev mb-2">
							<input class="form-control" type="file" id="file" name="imagen" hidden="hidden">
							<button id="custom_btn" type="button"><i class="icon-file-image-o"></i> Imagen del Proyecto</button>
							<span id="custom_text" class="text-capitalize">Seleccione Imagen..!</span>
					    </div>
					    <!-- Preview Imagen -->
					    <div class="col justify-content-center mb-2" align="center">
					    	<div id="preview_img_proyecto"></div>
					    </div>
					</div>
					
		      	</div>	
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		        <button type="submit" class="btn btn-primary"><i class="icon-save1"></i> Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>
	</form>

	<?php require '../footer.php' ?>
	
	

<!-- JQuery 3.5.1 -->
<script src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="../Recursos/Bootstrap/js/bootstrap.min.js"></script>
<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
<script src="../Recursos/jquery-confirm/js/jquery-confirm.js"></script>
<!-- CARGANDO Jquery Mask-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>

	// Contador de caracteres descripcion
	const info = document.getElementById('info_dev');
	const contador = document.getElementById('contador');

	info.addEventListener('input', function(e) {
	    const target = e.target;
	    const longitudMax = target.getAttribute('maxlength');
	    const longitudAct = target.value.length;
	    contador.innerHTML = `${longitudAct}/${longitudMax}`;
	});

	// Campos del create pro
	const realfilebtn = document.getElementById('file');
	const custombtn = document.getElementById('custom_btn');
	const customtext = document.getElementById('custom_text');

	custombtn.addEventListener('click', function(){
		realfilebtn.click();
	});

	realfilebtn.addEventListener('change', function(){
		if (realfilebtn.value) {
			customtext.innerHTML = realfilebtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
		}else{
			customtext.innerHTML = 'Seleccione Imagen..!';
		}
	});

	// Validar tipo de archivo
	function validarTipoArchivo(){
		var fileInput = document.getElementById('file');
	    var filePath = fileInput.value;
	    var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
	    if(!allowedExtensions.exec(filePath)){
	    	$.alert({
					icon: 'icon-error',
				    title: 'Error..!',
				    type: 'red',
    				typeAnimated: true,
				    content: 'Solamente se admiten archivos con extensiones .jpeg/.jpg/.png/.gif',
				});
	        fileInput.value = '';
	        customtext.innerHTML = 'Seleccione Imagen..!';
	        return false;
	    }
	}

	// Preview Imagen de creacion Proyecto
	document.getElementById("file").onchange = function(e) {

		if (validarTipoArchivo()!=false) {
			// Creamos el objeto de la clase FileReader
			let reader = new FileReader();

			// Leemos el archivo subido y se lo pasamos a nuestro fileReader
			reader.readAsDataURL(e.target.files[0]);

			// Le decimos que cuando este listo ejecute el código interno
			reader.onload = function(){
			    let preview = document.getElementById('preview_img_proyecto'),
			    image = document.createElement('img');

			    image.src = reader.result;
			    image.setAttribute("id", "vista_img_pro");

			    preview.innerHTML = '';
			    preview.append(image);
			};
		}
	}

	function nuevo_proyecto() {
		// Tomamos el usuario qeu esta activo en este momento
		user_inline = '<?php echo $_SESSION['usuario']['codigo'] ?>';
		$('#inline_user').val(user_inline);
		$('#add_pro_modal').modal('show');
	}
</script>

</body>
</html>