<?php
	session_start();

	if (!isset($_SESSION['usuario'])) {
			header('location: ../Externos/login');
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

	// Obtenemos el codigo logueado
	$user_inline = $_SESSION['usuario']['codigo'];
	//echo $user_inline;
	
	// Consultamos los datos del dev
	$query_user = "SELECT * FROM heroku_59b4c55ab4de36a.desarrollador WHERE codigousuario=$user_inline";
	// Realizamos la consulta
	$user = mysqli_query($conn, $query_user);

	// Extraemos los datos del Desarrollador
	$extraido = mysqli_fetch_array($user);

	// Consultamos los datos del dev
	$query_pro = "SELECT * FROM heroku_59b4c55ab4de36a.proyecto WHERE codigousuario=$user_inline";
	// Realizamos la consulta
	$pro = mysqli_query($conn, $query_pro);
	// Contamos la cantidad de proyectos
	$no_pro = $pro->num_rows;
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
			<?php require 'menu_internos.php' ?>

		</div>
	</header>

	<main>
		<div class="container">
			<div class="porfolio rounded">

				<div class="row">
					<div class="col d-flex justify-content-center">
						<h2 class="tile">
							<i class="icon-profile"></i>
							Mi Perfil
						</h2>
					</div>
				</div>

				<div class="row d-flex justify-content-center">
					<div class="container users_table pl-5 pr-5">
						<div class="row mb-5">
							<div class="col-md-12 col-lg-5">
								<img src="uploads/avatares/<?php echo $extraido['img'] ?>" class="img-fluid img-thumbnail rounded-circle shadow" alt="">
							</div>
							<div class="col">
								<div class="row" align="center">
									<h2 class="tile text-dark" align="center"> <?php echo $extraido['nombres']. ' ' .$extraido['apellidos'] ?> </h2>
								</div>
								<hr>
								<div class="row">
									<div class="col d-flex justify-content-around">
										<span><b>Telefono: </b> <?php echo $extraido['telefono']?></span>
										<span><b>Direccion: </b> <?php echo $extraido['direccion']?></span>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col" align="justify">
										<span ><?php echo $extraido['bio']?></span>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col d-flex justify-content-around" align="justify">
										<button class="btn btn-outline-warning" onclick="edit_dev('<?php echo $extraido['codigo']; ?>','<?php echo $extraido['nombres']; ?>','<?php echo $extraido['apellidos']; ?>', '<?php echo $extraido['img']; ?>', '<?php echo $extraido['telefono']; ?>','<?php echo $extraido['direccion']; ?>','<?php echo $extraido['codigodepto']; ?>','<?php echo $extraido['codigomuni']; ?>','<?php echo $extraido['bio']; ?>')"><i class="icon-edit5"></i> Editar Mi Perfil</button>
										<button class="btn btn-outline-danger" onclick="baja('<?php echo $extraido['codigo'] ?>', '<?php echo $extraido['nombres'] ?>')"><i class="icon-user-delete"></i> Darme de Baja</button>
									</div>
								</div>
								<hr>
									<div class="alert alert-success d-flex justify-content-center" role="alert">
										<span>Este Desarrollador tiene <?php if ($no_pro==1) {echo "un";} ?> <b><?php echo ' '.$no_pro.' ' ?></b> Proyecto<?php if ($no_pro!=1) {echo "s registrados";}else{ echo "registrado";} ?> en KodePrint..!</span> 
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- Editar Mi Perfil Modal -->
	<form action="ajax_edit_miperfil_dev.php" method="POST" enctype="multipart/form-data">
		<div class="modal fade" id="edit_dev_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h4 class="modal-title title" id="exampleModalLabel" align="center"> <i class="icon-document-code1"></i> Editar Mi Perfil de Desarrollador</h4>
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

	function baja (codigo, name) {
		// Tomamos el usuario qeu esta activo en este momento
		user_inline = '<?php echo $_SESSION['usuario']['usuario'] ?>';

		$.confirm({
			icon: 'icon-user-delete-outline',
		    title: 'Elminar Perfil..!',
		    type: 'red',
		    content: 'Se eliminar el perfil actual..!',
		    buttons: {
		        Ok:{
		        	text: 'Darme de Baja',
		        	btnClass: 'btn-red',
		        	keys: ['enter', 'shift'],
		        	action: function(){
		                $.ajax({
		                type: "POST",
		                url: 'ajax_delete_dev.php',
		                data: 'codigo='+codigo+'&nombres='+name+'&usuario_inline='+user_inline,
		                beforeSend: function(){
		                } 
						}).done(function(resp){
							location.href = '../logout.php';
						}).fail(function(resp){
							console.log('Error');
						});
		            }
		        },
		        cancel: function () {
		            $.alert('Se ha cancelado la baja del Perfil..!');
		        }
		    }
		});
	}
</script>

</body>
</html>