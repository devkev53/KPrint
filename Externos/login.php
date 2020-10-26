<?php
	// Importamos la coneccion a la DB
	require '../database.php';
	
	// Consultamos los usuarios
	$query_users = "SELECT * FROM heroku_59b4c55ab4de36a.usuario";

	// Consultamos los usuarios Heroku
	//$query_users = "SELECT * FROM heroku_59b4c55ab4de36a.usuario;";
	
	// Realizamos la consulta
	$users = mysqli_query($conn, $query_users);

	// No de usuarios encontados
	$no_Users = $users->num_rows;

	if ($no_Users==0) {
		header('location: ../firts_user.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login|KodePrint</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="../Recursos/Bootstrap/css/bootstrap.min.css">
	<!-- Fuentes de Google -->
	<link href="https://fonts.googleapis.com/css2?family=IM+Fell+Great+Primer+SC&display=swap" rel="stylesheet">
	<!-- Mis Estilos -->
	<link rel="stylesheet" type="text/css" href="../Recursos/Css/login.css">
	<!-- Mis Fuentes -->
	<link rel="stylesheet" type="text/css" href="../Recursos/font-kp/fonts/style.css">
	<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
	<link rel="stylesheet" href="../Recursos/jquery-confirm/css/jquery-confirm.css">
</head>
<body>
	<div class="modal-dialog text-center">
		<div class="col-sm-8 main_secction">
			<div class="modal-content">
				<div class="col-12 logo_img">
					<img src="../Recursos/img/kp_white.png" alt="" class="">
				</div>
				<div class="col-12 mb-2">
					<h3 class="title_login">KodePrint</h3>
				</div>
				<form class="col-12" action="" id="loginForm">
					<div class="form-group" id="user">
						<input type="text" name="usuario" placeholder="Usuario/Correo" required>
					</div>
					<div class="form-group" id="pass">
						<input type="password" name="contraseña" placeholder="Contraseña" required>
					</div>
					<button type="submit" class="btn btn-primary"><i class="icon-login mr-2"></i>Iniciar Sesión</button>
				</form>
				<hr>
				<div class="recuperar mb-4">
					<a href="recuperar.php" class="title_recup">¿Olvidaste tu contraseña?</a>
				</div>
				<div id="resp"></div>
				<div class="col-12">
					
				</div>
			</div>
		</div>
	</div>

<!-- JQuery 3.5.1 -->
<script src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="../Recursos/Bootstrap/js/bootstrap.min.js"></script>
<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
<script src="../Recursos/jquery-confirm/js/jquery-confirm.js"></script>

<script>
	$('#loginForm').on('submit', function(event){
			event.preventDefault();
			//alert($(this).serialize())

			$.ajax({
                type: "POST",
                url: '../loginVerify.php',
                dataType: "json",
                data: $(this).serialize(),
                beforeSend: function(){
                }
				}).done(function(resp){
					if (!resp.error) {
						if (resp.tipo=='0') {
							location.href = '../Internos/portafolio_in.php';
						}else{
							location.href = '../Internos/mi_perfil.php';
						}
					}else{
						$.alert({
							icon: 'icon-error',
						    title: 'Error..!',
						    type: 'red',
			    			typeAnimated: true,
						    content: 'Los datos ingresados no son correctos..!',
						});
					}
				}).fail(function(resp){
					$('#resp').text("Entro en el fail")
					console.log(resp.responseText);
			});
	});
</script>
</body>
</html>
