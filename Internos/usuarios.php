<?php
	session_start();

	if (!isset($_SESSION['usuario'])) {
			header('location: ../Externos/login.php');
	}

	// Importamos la coneccion a la DB
	require '../database.php';

	// Consultamos los usuarios Heroku
	$query_users = "SELECT * FROM heroku_59b4c55ab4de36a.usuario";
	
	// Realizamos la consulta
	$users = mysqli_query($conn, $query_users);

	// No de usuarios encontados
	$no_Users = $users->num_rows;
	//echo $no_Users;
	$usuarios_x_pagina = 4;
	// No de paginas a mostrar
	$paginas = ceil($no_Users/$usuarios_x_pagina);
	//echo $paginas;

	if (!$_GET) {
		header('Location: usuarios.php?pagina=1');
	}

	if ($_GET['pagina']>$paginas) {
		header('Location: usuarios.php?pagina='.$paginas);
	}
	if ($_GET['pagina']<=0) {
		header('Location: usuarios.php?pagina=1');
	}
	if (!is_numeric ($_GET['pagina'])) {
		header('Location: usuarios.php?pagina=1');
	}

	$iniciar = ($_GET['pagina']-1)*$usuarios_x_pagina;
	// echo $iniciar;

	// Traemos solo los Usuarios por paginas es decir solo 4 Usuarios por pagina Heroku
	$sql_users_pag = "SELECT * FROM heroku_59b4c55ab4de36a.usuario ORDER BY tipo LIMIT $iniciar, $usuarios_x_pagina";

	$users_pag = mysqli_query($conn, $sql_users_pag);
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
							<i class="icon-user-o"></i>
							Usuarios
						</h2>
					</div>
				</div>

				<div class="row d-flex justify-content-center">
					<div class="container users_table pl-5 pr-5">
						<?php if (mysqli_num_rows($users_pag) < 1){?>
							<div class="col alert alert-danger" role="alert" align="center">
							  	No se ha encontrado ningun usuario registrado..!
							</div>
							<div class="col" align="center">
								<button class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#add_user_modal">
									<i class="icon-add_circle"></i>
									<b>Agregar Usuario</b>
								</button>
							</div>
						<?php }else{ ?>
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
									    <tr>
									      <th scope="col" class="title"><i class="icon-person_outline"></i> Usuario</th>
									      <th scope="col" class="title"><i class="icon-mail_outline"></i> Email</th>
									      <th scope="col" class="title"><i class="icon-calendar"></i> Fecha de Creación</th>
									      <th scope="col" class="title"><i class="icon-calendar3"></i> Ultima Actualización</th>
									      <th scope="col" class="title"><i class="icon-gears1"></i> Tipo de Usuario</th>
									      <?php if ($_SESSION['usuario']['tipo']==0) { ?>
									      <th scope="col" colspan="2" class="title text-center"><i class="icon-more_vert"></i> Opciones</th>
									  <?php }else{ }?>
									    </tr>
									</thead>
									<tbody>
										<?php while ($row = mysqli_fetch_array($users_pag)) {
											echo "<tr><td>" .$row['usuario']."</td><td>" .$row['email']."</td>";
											echo "<td>" .$row['fecha_crea']."</td><td>" .$row['fecha_act']."</td>";
											if ($row['tipo']==0) {
												echo "<td>Administrador</td>";
											}else{
												echo "<td>Desarrollador</td>";
											}
											if ($_SESSION['usuario']['tipo']==0) {
												echo "<td class=\"text-center\"><button class=\"btn btn-warning\" onclick=\"editarUsuario('".$row['usuario']."','".$row['email']."','".$row['tipo']."')\"><i class=\"icon-edit1\"></i></button></td>";
												echo "<td class=\"text-center\"><button class=\"btn btn-danger\" onclick=\"eliminarUsuario('".$row['usuario']."','".$row['email']."','".$row['tipo']."')\"><i class=\"icon-trash\"></i></button></td>";
												echo "</tr>";
											}else{
											}
											
										} ?>
									</tbody>
								</table>
							</div>

							<!-- Paginador -->
							<nav aria-label="Page navigation example">
								<ul class="pagination justify-content-center">
								    <li class="page-item 
								    <?php echo $_GET['pagina']<=1 ? 'disabled' : '' ?>">
								      	<a class="page-link" 
								      	href="usuarios.php?pagina=<?php echo $_GET['pagina']-1; ?>">
								      		Anterior
								      	</a>
								    </li>

								    <!-- Numeros que se mostraran en al paginacion -->
								    <?php for ($i=0; $i < $paginas; $i++):?>
								    	<li class="page-item 
								    	<?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>">
								    		<a class="page-link" href="usuarios.php?pagina=<?php echo $i+1; ?>"> <?php echo $i+1; ?> </a>
								    	</li>
								    <?php endfor ?>

								    <li class="page-item
								    <?php echo $_GET['pagina']>=$paginas ? 'disabled' : '' ?>">
								      	<a class="page-link" href="usuarios.php?pagina=<?php echo $_GET['pagina']+1; ?>">
								      		Siguiente
								      	</a>
								    </li>
							  	</ul>
							</nav>

							<!-- Boton de Agregar Usuario -->
							<div class="col" align="center">
								<button class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#add_user_modal">
									<i class="icon-add_circle"></i>
									<b>Agregar Usuario</b>
								</button>
							</div>

						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- Agregar Usuario Modal -->
	<div class="modal fade" id="add_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title title" id="exampleModalLabel"> <i class="icon-note_add"></i> Agregar Usuario</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="" id="add_user_form">
	      <div class="modal-body">
	      	<div class="col-12">
		      	<input class="form-control" name="usuario" id="username" type="text" placeholder="Nombre de Usuario" required>
		      	<div id="result-username" class="mb-2"></div>
		      	<input class="form-control" name="correo" type="email" id="user_email" placeholder="Correo Electronico" required>
		      	<div id="result-email" class="mb-2"></div>
		      	<input class="form-control mb-2" name="contraseña1" id="p1" type="password" placeholder="Contraseña" required>
		      	<input class="form-control" name="contraseña2" id="p2" type="password" placeholder="Veirificacion de Contraseña" required>
		      	<div id="result-contraseñas" class="mb-2"></div>
		      	<label for="tipo_user">Tipo de Usuario:</label>
		      	<select class="form-control mb-2" name="tipo" id="tipo_user">
		      		<option value="0">Administrador</option>
		      		<option value="1">Desarrollador</option>
		      	</select>
	      	</div>	
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary"><i class="icon-save1"></i> Guardar</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<!-- Editar Usuario Modal -->
	<div class="modal fade" id="edit_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title title" id="exampleModalLabel"> <i class="icon-document-edit1"></i> Editar Usuario</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="" id="edit_user_form">
	      <div class="modal-body" id="respuesta_edit">
	      		
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary"><i class="icon-save1"></i> Guardar</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<!-- Eliminar Usuario Modal -->
	<div class="modal fade" id="delete_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title title" id="exampleModalLabel"> <i class="icon-trashcan"></i> Eliminar Usuario</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="" id="edit_user_form">
	      <div class="modal-body">
	      	<div class="col-12">
	      		<span id="eliminar_content"></span>
	      	</div>	
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-danger"><i class="icon-trashcan"></i> Eliminar</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<div id="respuesta"></div>
	<?php require '../footer.php' ?>
	
	

<!-- JQuery 3.5.1 -->
<script src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="../Recursos/Bootstrap/js/bootstrap.min.js"></script>
<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
<script src="../Recursos/jquery-confirm/js/jquery-confirm.js"></script>

<script>

	function eliminarUsuario(user, email, tipo){
		alert(typeof(tipo));
		alert(tipo);
		if (tipo==0) {
			var data = "Esta seguro de eliminar al usuario: <b>"+user+"</b> de tipo: <b>Administrador</b>...?";
		}else{
			var data = "Esta seguro de eliminar al usuario: <b>"+user+"</b> de tipo: <b>Desarrollador</b>...?";
		};

		// Tomamos el usuario qeu esta activo en este momento
		user_inline = '<?php echo $_SESSION['usuario']['usuario'] ?>';
		
		$('#eliminar_content').html(data);
		$('#delete_user_modal').modal('show');
		$(this).on('submit', function(event) {
			event.preventDefault();
			$.ajax({
                type: "POST",
                url: 'ajax_eliminar_usuario.php',
                data: 'usuario='+user+'&correo='+email+"&usuario_inline="+user_inline,
                beforeSend: function(){
                } 
				}).done(function(resp){
					location.reload();
				}).fail(function(resp){
					console.log('Error');
				});
		});
	}

	function editarUsuario(user, email){
		//alert(user + " - " + email+ " - " +tipo);
		// vamos a traer los datos y el form para editar
		$.ajax({
            type: "POST",
            url: 'ajax_recoger_usuario.php',
            data: 'usuario='+user+'&correo='+email,
            beforeSend: function(){
            } 
			}).done(function(resp){
				$('#respuesta_edit').html(resp);
				$('#edit_user_modal').modal('show');
				//console.log(resp);
				//location.reload();
			}).fail(function(resp){
				console.log('Error');
		});
		$(this).on('submit', function(event) {
			event.preventDefault();
			mail = $('#edit_email').val();
			tipo = $('#edit_tipo_user').val();
			$.ajax({
                type: "POST",
                url: 'ajax_edit_usuario.php',
                data: 'usuario='+user+'&correo='+mail+"&tipo="+tipo,
                beforeSend: function(){
                } 
				}).done(function(resp){
					//console.log(resp);
					location.reload();
				}).fail(function(resp){
					console.log('Error');
			});
		});
	};

	$("#username").focus();

	/* --------   VALIDACIONES DE FRONTEND Y BACKEND CON AJAX -------- */
	// Validar si el usuario existe en tiempo real
	$(document).ready(function() {
		var loading = "<div class='spinner-border text-secondary' role='status'><span class='sr-only'>Loading...</span></div>";

	    $('#username').on('blur', function() {
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
	    });              
	});
	// Validar si el correo electronico ya existe o esta disponible en tiempo real
	$(document).ready(function() {
		var loading = "<div class='spinner-border text-secondary' role='status'><span class='sr-only'>Loading...</span></div>";

	    $('#user_email').on('blur', function() {
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
	    });              
	});
	// Validar si las contraseñas coinciden
	$(document).ready(function() {
		var loading = "<div class='spinner-border text-secondary' role='status'><span class='sr-only'>Loading...</span></div>";

	    // Valida la opcion de crear
	    $('#p2').on('blur', function() {
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
	    });             
	});

	// AJAX para crear el usuario
	$('#add_user_form').on('submit', function (event) {
			event.preventDefault();
			// alert($(this).serialize());
			var p = $('input[name=contraseña1]').val();
			var p2 = $('input[name=contraseña2]').val();
			if (p==p2) {
				$.ajax({
                type: "POST",
                url: 'ajax_crear_usuario.php',
                data: $(this).serialize(),
                beforeSend: function(){
                } 
				}).done(function(resp){
					if (!resp.error) {
						console.log(resp);
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
		})
</script>

</body>
</html>
