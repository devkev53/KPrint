<?php
	session_start();

	if (!isset($_SESSION['usuario'])) {
			header('location: ../Externos/login.php');
	}

	// Importamos la coneccion a la DB
	require '../database.php';

	function mostrarDeptos() {
		// Importamos la coneccion a la DB
		require '../database.php';

		// enviando el comando SQL
		$deptos = mysqli_query($conn, "SELECT * FROM heroku_59b4c55ab4de36a.departamento order by nombre");

	    if (mysqli_num_rows($deptos) < 1) {
	    	echo "<span class='text-danger'>No hay Departamentos Registrados..!</span>";
	    }else{
	    	echo "<select class='form-control mb-2' name='depto' id='DeptoId' onchange='llenarMuni(this.options[this.selectedIndex].value)'>";
	    	echo "<option value='none'>-------------</option>";
	        while ($row = mysqli_fetch_array($deptos)) {
	            echo "<option value=" . $row['id'] . ">" . $row['nombre'];
	            echo "</option>";
	        } 			
	        echo "</select>";
	    }
	};


	// Consultamos los usuarios
	$query_dev = "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador";
	// Realizamos la consulta
	$dev = mysqli_query($conn, $query_dev);

	// No de usuarios encontados
	$no_dev = $dev->num_rows;
	//echo $no_dev;
	$dev_x_pagina = 4;
	// No de paginas a mostrar
	$paginas = ceil($no_dev/$dev_x_pagina);
	if ($paginas<=0) {
		$paginas += 1;
	}

	if (!$_GET) {
		header('Location: desarrolladores.php?pagina=1');
	}

	$iniciar = ($_GET['pagina']-1)*$dev_x_pagina;
	// echo $iniciar;

	if ($_GET['pagina']>$paginas) {
		header('Location: desarrolladores.php?pagina='.$paginas);
	}
	if ($_GET['pagina']<=0) {
		header('Location: desarrolladores.php?pagina=1');
	}
	if (!is_numeric ($_GET['pagina'])) {
		header('Location: desarrolladores.php?pagina=1');
	}

	// Traemos solo los desarrolladores por paginas es decir solo 2 desarrolladores por pagina
	$sql_devs_pag = "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador LIMIT $iniciar, $dev_x_pagina";
	$dev_pag = mysqli_query($conn, $sql_devs_pag);
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

				<div class="row">
					<div class="col d-flex justify-content-center">
						<h2 class="tile pl-5">
							<i class="icon-developer_mode"></i>
							Desarrolladores
						</h2>
					</div>
					<div class="ml-auto pr-5 d-flex align-items-center">
						<button class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#add_user_modal">
							<i class="icon-plus1"></i>
						</button>
					</div>
				</div>

				<div class="row d-flex justify-content-center">
					<div class="container users_table pl-5 pr-5">
						
						<?php if (mysqli_num_rows($dev_pag) < 1){?>
							<div class="col alert alert-danger" role="alert" align="center">
							  	No logro encontrar ningun registro en la base de datos..!
							</div>
							<div class="col" align="center">
								<button class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#add_user_modal">
									<i class="icon-add_circle"></i>
									<b>Agregar Desarrollador</b>
								</button>
							</div>

						<?php }else{ ?>
							<!-- -- *** MOSTRANDO DESARROLLADORES *** -- -->

							<div class="row row-cols-1 row-cols-lg-2">

							<?php while ($row = mysqli_fetch_array($dev_pag)) {?>
									<div class="col mb-4">
										<div class="card dev_card">
											
											<div class="card-header d-flex justify-content-start align-items-center">
												<div class="img_container col-3">
											    	<img src="uploads/avatares/<?php echo $row['img']?>" class="rounded-circle" alt="..." width="100">
											    </div>
											    <div class="col">
											    	<h5 class="card-title name_dev"><?php echo $row['nombres']. ' ' .$row['apellidos'] ?></h5>
											    </div>
											</div>

										    <div class="card-body">
										    	<div class="info" align="justify">
										    		<small><?php echo $row['bio']?></small>
										    	</div>
										    </div>

										    <?php if ($_SESSION['usuario']['tipo']==0) { ?>
										    	<div class="card-footer">
										    		<div class="options d-flex justify-content-end">
										    			<button class="btn btn_dev dev_edit mr-4" onclick="edit_dev('<?php echo $row['codigo']; ?>','<?php echo $row['nombres']; ?>','<?php echo $row['apellidos']; ?>', '<?php echo $row['img']; ?>', '<?php echo $row['telefono']; ?>','<?php echo $row['direccion']; ?>','<?php echo $row['codigodepto']; ?>','<?php echo $row['codigomuni']; ?>','<?php echo $row['bio']; ?>')"><i class="icon-pencil"></i></button>
										    			<button class="btn btn_dev dev_delete" onclick="delete_dev('<?php echo $row['codigo']; ?>','<?php echo $row['nombres']; ?>','<?php echo $row['apellidos']; ?>', '<?php echo $row['img']; ?>')"><i class="icon-trashcan1"></i></button>
											    	</div>
										    	</div>
											<?php }else{ ?>
												
											<?php } ?>
										</div>
									</div>
							<?php } ?>

							</div>

							<!-- Paginador -->
							<nav aria-label="Page navigation example">
								<ul class="pagination justify-content-center">
								    <li class="page-item 
								    <?php echo $_GET['pagina']<=1 ? 'disabled' : '' ?>">
								      	<a class="page-link" 
								      	href="desarrolladores.php?pagina=<?php echo $_GET['pagina']-1; ?>">
								      		Anterior
								      	</a>
								    </li>

								    <!-- Numeros que se mostraran en al paginacion -->
								    <?php for ($i=0; $i < $paginas; $i++):?>
								    	<li class="page-item 
								    	<?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>">
								    		<a class="page-link" href="desarrolladores.php?pagina=<?php echo $i+1; ?>"> <?php echo $i+1; ?> </a>
								    	</li>
								    <?php endfor ?>

								    <li class="page-item
								    <?php echo $_GET['pagina']>=$paginas ? 'disabled' : '' ?>">
								      	<a class="page-link" href="desarrolladores.php?pagina=<?php echo $_GET['pagina']+1; ?>">
								      		Siguiente
								      	</a>
								    </li>
							  	</ul>
							</nav>

							<!-- Boton de Agregar Usuario -->
							<div class="col" align="center">
								<button class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#add_user_modal">
									<i class="icon-add_circle"></i>
									<b>Agregar Desarrollador</b>
								</button>
							</div>

						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- Agregar Desarroolador Modal -->
	<form enctype="multipart/form-data" method="POST" action="ajax_crear_dev.php" id="add_dev_form">
		<div class="modal fade" id="add_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered modal-lg">
		    <div class="modal-content new">
		      <div class="modal-header">
		        <h5 class="modal-title title" id="exampleModalLabel"> <i class="icon-document-code1"></i> Nuevo Desarrollador</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="col-12 text-uppercase">
		      		<div class="row d-flex align-items-center">
		      			<!-- Btn Subir Imagen -->
		      			<div class="col img_dev mb-2">
							<input class="form-control" type="file" id="file" name="imagen" hidden="hidden">
							<button id="custom_btn" type="button"><i class="icon-file-image-o"></i> Avatar</button>
							<span id="custom_text" class="text-capitalize">Seleccione Imagen..!</span>
					    </div>
					    <!-- Preview Imagen -->
					    <div class="col justify-content-center mb-2" align="center">
					    	<div id="preview_img"></div>
					    </div>
					</div>
		      		<div class="row">
		      			<div class="col">
					      	<input class="form-control" name="usuario" id="username" type="text" placeholder="NOMBRE DE USUARIO" required>
					      	<div id="result-username" class="mb-2"></div>
					    </div>
					    <div class="col">
					      	<input class="form-control" name="correo" type="email" id="user_email" placeholder="CORREO ELECTRONICO" required>
					      	<div id="result-email" class="mb-2"></div>
					    </div>
					</div>
					<div class="row">
		      			<div class="col">
			      			<input class="form-control mb-2" name="contraseña1" id="p1" type="password" placeholder="CONTRASEÑA" required>
			      		</div>
		      			<div class="col">
			      			<input class="form-control" name="contraseña2" id="p2" type="password" placeholder="VERIFICACION DE CONTRASEÑA" required>
			      		</div>
			      	</div>
			      	<div id="result-contraseñas" class="mb-2"></div>
			      	<div class="row">
		      			<div class="col">
					      	<input class="form-control mb-2" name="nombres" id="p2" type="text" placeholder="NOMBRES" required>
					    </div>
					    <div class="col">
					      	<input class="form-control mb-2" name="apellidos" id="p2" type="text" placeholder="APELLIDOS" required>
					    </div>
					</div>
			      	<div class="row">
		      			<div class="col">
					      	<input class="form-control mb-2 tel" name="telefono" id="tel" type="text" placeholder="TELEFONO" required>
					    </div>
					    <div class="col">
					      	<input class="form-control mb-2" name="direccion" id="p2" type="text" placeholder="DIRECCIÓN" required>
					    </div>
					</div>
					<div class="row">
		      			<div class="col">
		      				<label>DEPARTAMENTO: 
		      				</label>
			      			<?php mostrarDeptos() ?>
			      		</div>
			      		<div class="col">
			      			<label>MUNICIPIO: 
			      			</label>
							<select class="form-control" name="muni" id="divMuni">
								<option value="">---------------------</option>
							</select>
						</div>
					</div>
					<div c>
						<textarea name="bio" class="form-control" rows="3" id="info_dev" maxlength="250" placeholder="Ingrese una corta descripcion de sus habilidades como desarrollador..!"></textarea>
						<div id="contador" align="right" style="color: #aaa;">0/250</div>
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

	<!-- Editar Usuario Modal -->
	<form action="ajax_edit_dev.php" method="POST" enctype="multipart/form-data">
		<div class="modal fade" id="edit_dev_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered modal-lg">
		    <div class="modal-content edit">
		      <div class="modal-header">
		        <h4 class="modal-title title" id="exampleModalLabel" align="center"> <i class="icon-document-code1"></i> Editar Desarrollador</h4>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="col-12 text-uppercase">
		      		<div class="row d-flex align-items-center">
		      			<!-- Btn Subir Imagen -->
		      			<div class="col img_dev mb-2">
							<input class="form-control" type="file" id="avatar" name="imagen2" hidden="hidden">
							<button id="btn_edit_img" type="button"><i class="icon-file-image-o"></i> Avatar</button>
							<span id="text_edit_img" class="text-capitalize">Cambiar Imagen..!</span>
					    </div>
					    <!-- Preview Imagen -->
					    <div class="col justify-content-center mb-2" align="center">
					    	<div id="preview_img2"></div>
					    </div>
					</div>
		      		<!--div class="row">
		      			<div class="col">
					      	<input class="form-control" name="usuario" id="username" type="text" placeholder="NOMBRE DE USUARIO" required>
					      	<div id="result-username" class="mb-2"></div>
					    </div>
					    <div class="col">
					      	<input class="form-control" name="correo" type="email" id="user_email" placeholder="CORREO ELECTRONICO" required>
					      	<div id="result-email" class="mb-2"></div>
					    </div>
					</div>
					<div class="row">
		      			<div class="col">
			      			<input class="form-control mb-2" name="contraseña1" id="p1" type="password" placeholder="CONTRASEÑA" required>
			      		</div>
		      			<div class="col">
			      			<input class="form-control" name="contraseña2" id="p2" type="password" placeholder="VERIFICACION DE CONTRASEÑA" required>
			      		</div>
			      	</div-->
			      	<div id="result-contraseñas" class="mb-2"></div>
			      	<div class="row">
		      			<div class="col">
		      				<input class="form-control mb-2" name="codigo" id="codigo" type="text" placeholder="NOMBRES" required hidden="hidden">
					      	<input class="form-control mb-2" name="nombres" id="name" type="text" placeholder="NOMBRES" required>
					    </div>
					    <div class="col">
					      	<input class="form-control mb-2" name="apellidos" id="lastname" type="text" placeholder="APELLIDOS" required>
					    </div>
					</div>
			      	<div class="row">
		      			<div class="col">
					      	<input class="form-control mb-2 tel" name="telefono" id="phone" type="text" placeholder="TELEFONO" required>
					    </div>
					    <div class="col">
					      	<input class="form-control mb-2" name="direccion" id="address" type="text" placeholder="DIRECCIÓN" required>
					    </div>
					</div>
					<div class="row">
		      			<div class="col">
		      				<label>DEPARTAMENTO: 
		      				</label>
			      			<?php mostrarDeptos() ?>
			      		</div>
			      		<div class="col">
			      			<label>MUNICIPIO: 
			      			</label>
							<select class="form-control" name="muni2" id="divMuni2">
								<option value="">---------------------</option>
							</select>
						</div>
					</div>
					<div c>
						<textarea name="bio" class="form-control" rows="3" id="info_dev2" maxlength="250" placeholder="Ingrese una corta descripcion de sus habilidades como desarrollador..!"></textarea>
						<div id="contador" align="right" style="color: #aaa;">0/250</div>
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

	<!-- Eliminar Usuario Modal -->
	<form action="ajax_delete_dev.php" method="POST" id="delete_dev_form">
	<div class="modal fade" id="delete_dev_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title title" id="exampleModalLabel"> <i class="icon-trashcan"></i> Eliminar Desarrollador</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      
	      <div class="modal-body">
	      	<div class="col-12 d-flex justify-content-center align-items-center">
	      		<div class="img_container col-3">
					<img id="img_dev_delete" src="" class="rounded-circle" alt="..." width="100">
				</div>
				<div class="col">
					<span class="name_dev tile" id="delete_dev_name"></span>
				</div>
	      	</div>
	      	<!-- DATOS OCULTOS DEL FORM -->
	      	<input type="text" name="codigo" id="codigo_del" hidden="hiden">
	      	<input type="text" name="nombres" id="name_del" hidden="hiden">
	      	<input type="text" name="usuario_inline" id="inline" hidden="hiden">
	      	<div class="container">
	      		<small id="eliminar_content">Si elimina este desarrollador tambien eliminara el usuario de este sistema</small>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-danger"><i class="icon-trashcan"></i> Eliminar</button>
	      </div>
	      
	    </div>
	  </div>
	</div>
	</form>

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


<script>
	$(document).ready(function(){
  		$('.tel').mask('0000-0000');
  	});
	const info = document.getElementById('info_dev');
	const contador = document.getElementById('contador');

	info.addEventListener('input', function(e) {
	    const target = e.target;
	    const longitudMax = target.getAttribute('maxlength');
	    const longitudAct = target.value.length;
	    contador.innerHTML = `${longitudAct}/${longitudMax}`;
	});

	// Campos del edit dev
	const btn_edit = document.getElementById('btn_edit_img');
	const text_edit = document.getElementById('text_edit_img');
	const real_img = document.getElementById('avatar');

	btn_edit.addEventListener('click', function(){
		real_img.click();
	});

	real_img.addEventListener('change', function(){
		if (real_img.value) {
			text_edit.innerHTML = real_img.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
		}else{
			text_edit.innerHTML = 'Seleccione Imagen..!';
		}
	});

	// Campos del create dev
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

	function validarTipoArchivo2(){
		var fileInput = document.getElementById('avatar');
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
	        text_edit.innerHTML = 'Seleccione Imagen..!';
	        return false;
	    }
	}

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

	// Preview Avatar de Edicion
	document.getElementById("avatar").onchange = function(e) {

		if (validarTipoArchivo2()!=false) {
			// Creamos el objeto de la clase FileReader
			let reader = new FileReader();

			// Leemos el archivo subido y se lo pasamos a nuestro fileReader
			reader.readAsDataURL(e.target.files[0]);

			// Le decimos que cuando este listo ejecute el código interno
			reader.onload = function(){
			    let preview = document.getElementById('preview_img2'),
			    image = document.createElement('img');

			    image.src = reader.result;
			    image.setAttribute("id", "vista_img;");
			    image.setAttribute("width", "100");
			    image.setAttribute("height", "100");
			    image.setAttribute("overflow", "hidden");
			    image.classList.add('shadow', 'p-1', 'bg-white')
			    image.classList.add('img-responsive')
			    image.classList.add('rounded-circle')

			    preview.innerHTML = '';
			    preview.append(image);
			};
		}
	}

	// Preview Avatar de creacion
	document.getElementById("file").onchange = function(e) {

		if (validarTipoArchivo()!=false) {
			// Creamos el objeto de la clase FileReader
			let reader = new FileReader();

			// Leemos el archivo subido y se lo pasamos a nuestro fileReader
			reader.readAsDataURL(e.target.files[0]);

			// Le decimos que cuando este listo ejecute el código interno
			reader.onload = function(){
			    let preview = document.getElementById('preview_img'),
			    image = document.createElement('img');

			    image.src = reader.result;
			    image.setAttribute("id", "vista_img;");
			    image.setAttribute("width", "100");
			    image.setAttribute("height", "100");
			    image.setAttribute("overflow", "hidden");
			    image.classList.add('shadow', 'p-1', 'bg-white')
			    image.classList.add('img-responsive')
			    image.classList.add('rounded-circle')

			    preview.innerHTML = '';
			    preview.append(image);
			};
		}
	}

	// Preview Avatar de edicion
	function mostrar_imagen_edit_dev(ruta){
		let preview = document.getElementById('preview_img2'),
		image = document.createElement('img');

		image.src = ruta
		image.setAttribute("id", "vista_img;");
		image.setAttribute("width", "100");
		image.setAttribute("height", "100");
		image.setAttribute("overflow", "hidden");
		image.classList.add('shadow', 'p-1', 'bg-white')
		image.classList.add('img-responsive')
		image.classList.add('rounded-circle')

		preview.innerHTML = '';
		preview.append(image);

	};

	/* --------   VALIDACIONES DE FRONTEND Y BACKEND CON AJAX -------- */
	// Validar si el usuario existe en tiempo real
	$(document).ready(function() {
		var loading = "<div class='spinner-border text-secondary' role='status'><span class='sr-only'>Loading...</span></div>";

	    $('#username').on('blur', function() {
	    	var dato = $('#username').val().length;
	    	if (dato>0) {
		        $('#result-username').html(loading);
		 
		        var username = $(this).val();		
		        var dataString = 'username='+username;
		 		//alert('Desenfocaste')
		        $.ajax({
		            type: "POST",
		            url: "validar_user.php",
		            data: dataString,
		            success: function(data) {
		                $('#result-username').fadeIn(1000).html(data);
		            }
		        });
		    }
	    });              
	});
	// Validar si el correo electronico ya existe o esta disponible en tiempo real
	$(document).ready(function() {
		var loading = "<div class='spinner-border text-secondary' role='status'><span class='sr-only'>Loading...</span></div>";

	    $('#user_email').on('blur', function() {
	    	var dato = $('#user_email').val().length;
	    	if (dato>0) {
		        $('#result-email').html(loading);
		 
		        var username = $(this).val();		
		        var dataString = 'username='+username;
		 		//alert('Desenfocaste')
		        $.ajax({
		            type: "POST",
		            url: "validar_email.php",
		            data: dataString,
		            success: function(data) {
		                $('#result-email').fadeIn(1000).html(data);
		            }
		        });
		    }
	    });              
	});
	// Validar si las contraseñas coinciden
	$(document).ready(function() {
		var loading = "<div class='spinner-border text-secondary' role='status'><span class='sr-only'>Loading...</span></div>";

	    // Valida la opcion de crear
	    $('#p2').on('blur', function() {
	    	var dato = $('#p2').val().length;
		    	if (dato>0) {
		        $('#result-contraseñas').fadeIn(10).html(loading);
		        var data = "<small class='text-danger'><strong><i class='icon-cancel1 mr-2'></i>Las contraseñas no coinciden..!</strong></small>";
		        var p1 = $('#p1').val();
		        var p2 = $('#p2').val();		
		        var dataString = 'pass1='+p1+'&pass2='+p2;
		 		//alert('Desenfocaste')
		        $.ajax({
		            type: "POST",
		            url: "validar_pass.php",
		            data: dataString,
		            success: function(data) {
		                $('#result-contraseñas').fadeIn(1000).html(data);
		            }
		        });
		    }
	    });             
	});
	// Funcion que en variable al departamento recogera los municipios
	function llenarMuni(dato) {
		//alert(dato);
		$.ajax({
            type: "POST",
            url: 'ajax_llenar_munis.php',
            data: dato='depto='+dato,
            beforeSend: function(){
          	//console.log(resp);
         	} 
			}).done(function(resp){
				$('#divMuni').html(resp);
				$('#divMuni2').html(resp);
			}).fail(function(resp){
				console.log('Error');
			});
	};

	function edit_dev(codigo, nombre, apellido, img, telefono, direccion, codigodepto, codigomuni, bio){
		/*
		$('#divMuni2')
		*/
		var ruta = 'uploads/avatares/'+img;
		$('#codigo').val(codigo);
		$('#file2').val(ruta);
		$('#name').val(nombre);
		$('#lastname').val(apellido);
		$('#phone').val(telefono);
		$('#address').val(direccion);
		$('#info_dev2').val(bio);
		mostrar_imagen_edit_dev(ruta);
		$('#edit_dev_form').modal('show');
		
	};

	function delete_dev(codigo, nombre, apellido, img){
		// Tomamos el usuario qeu esta activo en este momento
		user_inline = '<?php echo $_SESSION['usuario']['usuario'] ?>';
		//var fullname = nombre+' '+apellido;
		$('#codigo_del').val(codigo);
		$('#inline').val(user_inline);
		$('#name_del').val(nombre);
		var name = nombre;
		alert($('#codigo_del').val());
		alert($('#name_del').val());
		alert(codigo);
		
		console.log(name);
		var ruta = 'uploads/avatares/' + img;
		var span = document.getElementById('delete_dev_name');
		document.getElementById('img_dev_delete').setAttribute('src', ruta);
		span.innerHTML = name + ' ' + apellido;
		$('#delete_dev_modal').modal('show');
		// Ajax para eliminar el dev
	};

	// AJAX para crear el desarrollador
	/*$('#add_dev_form').on('submit', function (event) {
			event.preventDefault();
			var p = $('input[name=contraseña1]').val();
			var p2 = $('input[name=contraseña2]').val();
			if (p==p2) {
				var datos = new FormData(event.currentTarget);
				$.ajax({
                type: "POST",
                url: 'ajax_crear_dev.php',
                data: datos,
                beforeSend: function(){
                } 
				}).done(function(resp){
					if (!resp.error) {
						location.reload();
					}else{
						$.alert({
							icon: 'icon-error',
						    title: 'Error..!',
						    type: 'red',
		    				typeAnimated: true,
						    content: 'No fue posible crear el usuario..!',
						});		
					}
				}).fail(function(resp){
					console.log('Error');
				});
			}else{
				$.alert({
					icon: 'icon-error',
				    title: 'Error..!',
				    type: 'red',
    				typeAnimated: true,
				    content: 'Las contraseñas no coinciden..!',
				});
			}
	})*/
</script>

</body>
</html>
