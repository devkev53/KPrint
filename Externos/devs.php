<?php
	session_start();

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

	// Validando para los paginadores
	if (!$_GET) {
		header('Location: devs.php?pagina=1');
	}

	if ($_GET['pagina']>$paginas) {
		header('Location: devs.php?pagina='.$paginas);
	}
	if ($_GET['pagina']<=0) {
		header('Location: devs.php?pagina=1');
	}
	if (!is_numeric ($_GET['pagina'])) {
		header('Location: devs.php?pagina=1');
	}

	$iniciar = ($_GET['pagina']-1)*$dev_x_pagina;
	// echo $iniciar;

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
			<?php require 'menu_externos.php' ?>

			<!-- Slider 
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
			</div> -->

		</div>
	</header>

	<main>
		<div class="container">
			<div class="porfolio rounded">

				<div class="row">
					<div class="col d-flex justify-content-center">
						<h2 class="tile">
							<i class="icon-developer_mode"></i>
							Nuestros Desarrolladores
						</h2>
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
											    	<img src="../Internos/uploads/avatares/<?php echo $row['img']?>" class="rounded-circle" alt="..." width="100">
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
								      	href="devs.php?pagina=<?php echo $_GET['pagina']-1; ?>">
								      		Anterior
								      	</a>
								    </li>

								    <!-- Numeros que se mostraran en al paginacion -->
								    <?php for ($i=0; $i < $paginas; $i++):?>
								    	<li class="page-item 
								    	<?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>">
								    		<a class="page-link" href="devs.php?pagina=<?php echo $i+1; ?>"> <?php echo $i+1; ?> </a>
								    	</li>
								    <?php endfor ?>

								    <li class="page-item
								    <?php echo $_GET['pagina']>=$paginas ? 'disabled' : '' ?>">
								      	<a class="page-link" href="devs.php?pagina=<?php echo $_GET['pagina']+1; ?>">
								      		Siguiente
								      	</a>
								    </li>
							  	</ul>
							</nav>

						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</main>
	

<!-- JQuery 3.5.1 -->
<script src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="../Recursos/Bootstrap/js/bootstrap.min.js"></script>
<!-- CARGANDO LOS RECURSOS DE JQUERYCONFIRM -->
<script src="../Recursos/jquery-confirm/js/jquery-confirm.js"></script>


<script>
	const info = document.getElementById('info_dev');
	const contador = document.getElementById('contador');

	info.addEventListener('input', function(e) {
	    const target = e.target;
	    const longitudMax = target.getAttribute('maxlength');
	    const longitudAct = target.value.length;
	    contador.innerHTML = `${longitudAct}/${longitudMax}`;
	});

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
			}).fail(function(resp){
				console.log('Error');
			});
	}

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
