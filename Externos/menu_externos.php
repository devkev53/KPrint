<!-- Barra Nombre y Inicio o Fin de Sesion -->
			<div class="barra_navegacion">
				<div class="navbar navbar-expand-lg navbar-light bg-light rounded-top">
					<a class="barra_title" href="">
						<h2 class="barra_title">
						<img class="img-fluid" width="50" src="../Recursos/img/kp_black.png" alt="">
						- KodePrint
					</h2>
					</a>
					<div class="ml-auto sesion">
						<?php							
							if (isset($_SESSION['usuario'])) {
								echo "<a class='submenu off' href=''>";
								echo "<i class='icon-switch mr-2'></i>";
								echo "<span>Cerrar Sesion</span>";
								echo "</a>";
							}else{
								echo "<a class='submenu on' href='login.php'>";
								echo "<i class='icon-login mr-2'></i>";
								echo "<span>Iniciar Sesion</span>";
								echo "</a>";
							} 

						?>
					</div>
				</div>
			</div>

			<!-- Segunda Barra -->
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Submenu -->
				    <ul class="submenu navbar-nav d-flex justify-content-center">
				    	<li class="nav-item active">
				        	<a class="submenu nav-link" href="portafolio.php">
				        		<i class="icon-work_outline"></i>
				        		Proyectos
				        		<span class="sr-only">(current)</span>
				        	</a>
				      	</li>
				      	<li class="nav-item active">
				        	<a class="submenu nav-link" href="devs.php">
				        		<i class="icon-developer_mode"></i>
				        		Nuestros Desarrolladores 
				        		<span class="sr-only">(current)</span>
				        	</a>
				      	</li>
				      	<li class="nav-item active">
				        	<a class="submenu nav-link" href="about.php">
				        		<i class="icon-info2"></i>
				        		Sobre Nosotros
				        		<span class="sr-only">(current)</span>
				        	</a>
				      	</li>
				      	<li class="nav-item active">
				        	<a class="submenu nav-link" href="contacto.php">
				        		<i class="icon-mail_outline"></i>
				        		Contacto 
				        		<span class="sr-only">(current)</span>
				        	</a>
				      	</li>
				    </ul>
				</div>
			</nav>