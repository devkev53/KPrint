<?php 
	// Hacemos la coneccion a la DB
		require '../database.php';

	// Validamos si se esta recogiendo un metodo GET
	if(isset($_GET['mail'])) {
		// Creamos una variable para mandar el mensaje
		$var = 0;
	    $mail = $_GET['mail'];
	    if (strlen($mail)>0) {
	    	// Verificamos si existe el email
			$qs = "SELECT * FROM usuario 
				WHERE email='$mail'";
			// Realizando la consulta
			$usuarios = mysqli_query($conn, $qs);

			if (mysqli_num_rows($usuarios) > 0) {
				// Devuelve 3 si encontro el correo
				$var=3;
			}else{
				// Devuelve 2 si el correo no existe en la base de datos
				$var=2;	
			}
	    }else{
	    	// Devuelve uno si no se ingreso correo en el input 
	    	$var=1;
	    }
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
				<div class="col-12">
					<h3 class="title_login">KodePrint</h3>
				</div>
				<form class="col-12" action="" id="recuForm">
					<div class="mb-2">
						<img class="" width="130" src="../Recursos/img/mail_chek.png" alt="">
					</div>
					<div class="form-group" id="mail">
						<input type="email" name="mail" placeholder="Correo Electronico" required>
					</div>
					<<button type="submit" class="btn btn-primary"><i class="icon-send-o mr-2"></i>Enviar Contraseña</button>
				</form>
				<hr>
				<div class="recuperar mb-2">
					<a href="login.php" class="title_recup">Volver a Iniciar Sesión</a>
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
	$(document).ready(function(){
		  var get = "<?php echo $var ?>";
		  //alert(get);
		  if (get==1) {
		  	$.alert({
				icon: 'icon-error',
			    title: 'Error..!',
			    type: 'red',
			   	typeAnimated: true,
			    content: 'El campo de correo electronico no puede ser vacio..!',
			});
		  }else{
		  	if (get==2) {
		  		$.alert({
					icon: 'icon-error',
				    title: 'Error..!',
				    type: 'red',
				   	typeAnimated: true,
				    content: 'El correo ingresado no existe..!',
				});
		  	}else{
		  		$.alert({
					icon: 'icon-mail-checked1',
				    title: 'Listo..!',
				    type: 'green',
				   	typeAnimated: true,
				    content: 'Se ha enviado un correo de recuperacion verifica tu badeja de entrada..!',
				    buttons: {
				        tryAgain: {
				            text: 'Ok',
				            btnClass: 'btn-green',
				            action: function(){
				            }
				        }
				    }
				});
		  	}
		  };
	})
</script>
</body>
</html>