<?php
	function bienvenida_usuario($usuario, $email){
		$msj = "
		<table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
			<tr>
				<td style='background-color: #ecf0f1; text-align: left; padding: 0'>
					<a style='text-decoration: none;' href='http://localhost:8082/KodePrint/index.php'>
						<img width='20%' style='display: blocck; margin: 1.5% 3%' src='https://i.postimg.cc/nrf7tWHv/kp-black.png'>
					</a>
				</td>
			</tr>
			<tr>
				<td style='padding: 0;'>
					<img style='padding:0; display:block;' src='https://i.postimg.cc/jSfbDkKW/1.png' width='100%'>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ecf0f1'>
					<div style='color: #34495e; margin: 4% 10% 2%; text-align: justify; font-family: sans-serif'>
						<h2 style='color: #0749AC; margin: 0 0 7px;'>Bienvenido a: <b>KodePrint</b></h2>
						<p style='margin: 2px; font-size: 15px;'>Gracias por formar parte de nuestro equipo, tus aportes seran de gran ayuda para nuestro equipo de trabajo, en nuestro app web tendras acceso a ver, ingresar, editar o eliminar proyectos o desarrolladores segun tu <i>tipo</i> de <b>usuario</b> tu informacion de registro en nuestra plataforma es la siguiente:</p>
					</div>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ecf0f1'>
					<div style='background-color: #34495e; padding: 10px; color: #e2e2e2; margin: 0 10% 1%; text-align: justify; font-family: sans-serif'>
						<p style='margin: 2px; font-size: 15px;'>Usuario: <b>".$usuario."</b></p>
					</div>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ecf0f1'>
					<div style='background-color: #34495e; padding: 10px; color: #e2e2e2; margin: 0 10% 1%; text-align: justify; font-family: sans-serif'>
						<p style='margin: 2px; font-size: 15px;'>Correo Electronico: <b>".$email."</b></p>
					</div>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ecf0f1'>
					<div style='color: #34495e; margin: 0% 10% 4%; text-align: justify; font-family: sans-serif'>
						<p style='color: #FF6000; margin: 2px; font-size: 15px;'>No Revele esta informacion con nadie..!</p>
					</div>
					<div style='width: 100%; text-align: center'>
						<a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #0749AC;' href='http://localhost:8082/KodePrint/Externos/login.php'>Ir al Sitio</a>
					</div>
					<p style='color: #b3b3b3; font-size: 12px; text-align: center; margin: 30px 0 0;'><small>KodePrint 2020</small></p>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ecf0f1'>
					<div style='color: #34495e; margin: 0% 10% 0%; text-align: justify; font-family: sans-serif'>
						<p style=''>Enviado desde: <b> <?php echo php_uname(); ?> </b></p>
					</div>
					<div style='color: #34495e; margin: 0% 10% 0%; text-align: justify; font-family: sans-serif'>
						<p style=''>Fecha: <b> <?php echo date('l \t\h\e jS'); ?> </b></p>
					</div>
				</td>
			</tr>
		</table>
		";

		return $msj;
	}
?>
