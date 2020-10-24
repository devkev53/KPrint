<?php
	// Importamos la coneccion a la DB
	require 'database.php';
	
	// Consultamos los usuarios
	$query_users = "SELECT * FROM usuario";
	
	// Realizamos la consulta
	$users = mysqli_query($conn, $query_users);

	// No de usuarios encontados
	$no_Users = $users->num_rows;

	if ($no_Users>0) {
		header('location: Externos/login');
	}
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
							<i class="icon-user5 mr-2"></i>
							Ingrese el Usuario Administrador..!
						</h2>
					</div>
				</div>
				
				<div class="row d-flex justify-content-center">
					<div class="col-12 col-lg-4">
						<form action="" id="add_user_form">
							<input class="form-control mb-2" name="usuario" id="username" type="text" placeholder="Nombre de Usuario" required>
							<input class="form-control mb-2" name="correo" type="email" id="user_email" placeholder="Correo Electronico" required>
							<input class="form-control mb-2" name="contraseña1" id="p1" type="password" placeholder="Contraseña" required>
					      	<input class="form-control mb-2" name="contraseña2" id="p2" type="password" placeholder="Veirificacion de Contraseña" required>
							<label for="tipo_user">Tipo de Usuario:</label>
					      	<select class="form-control mb-2" name="tipo" id="tipo_user">
					      		<option value="0">Administrador</option>
					      		<option value="1">Desarrollador</option>
					      	</select>
						<div class="d-flex justify-content-center">
					      	<input type="submit" class="btn btn-success" value="Crear Usuario">
						</div>
					    </form>
					</div>
				</div>
				
			</div>			
		</div>
	</main>

	<?php //require 'footer.php' ?>

	<!-- JQuery 3.5.1 -->
	<script src="Recursos/Js/jquery-3.5.1.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="Recursos/Bootstrap/js/bootstrap.min.js"></script>
	<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
	<script src="Recursos/jquery-confirm/js/jquery-confirm.js"></script>

	<script	>
		// AJAX para crear el usuario
	$('#add_user_form').on('submit', function (event) {
			event.preventDefault();
			// alert($(this).serialize());
			var p = $('input[name=contraseña1]').val();
			var p2 = $('input[name=contraseña2]').val();
			if (p==p2) {
				$.ajax({
                type: "POST",
                url: 'Internos/ajax_crear_usuario.php',
                data: $(this).serialize(),
                beforeSend: function(){
                } 
				}).done(function(resp){
					if (!resp.error) {
						console.log(resp);
						location..href = "Externos.login.php";
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
