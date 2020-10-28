<?php
	$user = $_POST['usuario'];
	$email = $_POST['correo'];

	// Hacemos la coneccion a la DB
	require '../database.php';

	// vamos a validar si el usuario no exist
	$query_user_val = "SELECT * FROM heroku_59b4c55ab4de36a.usuario WHERE usuario='$user' OR email='$email'";
	// Realizando la consulta
	$user_con = mysqli_query($conn, $query_user_val);
	$extraido = mysqli_fetch_array($user_con);

?>
<div class="col-12">
	<input class="form-control" name="usuario" id="edit_username" type="text" 
	placeholder="Nombre de Usuario" readonly value="<?php echo $extraido['usuario'] ?>">
<div id="result-username" class="mb-2"></div>
	<input class="form-control" name="correo" type="email"
	id="edit_email" placeholder="Correo Electronico" required value="<?php echo $extraido['email'] ?>">
<div id="result-email" class="mb-2"></div>

<label for="tipo_user">Tipo de Usuario:</label>
<select class="form-control" name="tipo" id="edit_tipo_user" value="<?php echo $extraido['tipo'] ?>">
	<option value="0">Administrador</option>
	<option value="1">Desarrollador</option>
</select>
	<small class="text-info"><i class="icon-info6 mr-2"></i>¡La contraseña solo podrá ser cambiada en el logan por el usuario...!</small>
</div>

<script>
	$('#edit_tipo_user').val(<?php echo $extraido['tipo']?>);
</script>
