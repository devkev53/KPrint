<?php
	$var=$_POST['depto'];

	function mostrarMuni($dato) {
		// Conectamos la DB
		require '../database.php';

		// enviando el comando SQL
	    $muni = mysqli_query($conn, "SELECT * FROM municipio WHERE codigodepto=$dato order by nombre");
	    if (mysqli_num_rows($muni) < 1) {
	        echo "<option>------------------</option>";
	    }else{
	        while ($row = mysqli_fetch_array($muni)) {
	            echo "<option value=" . $row['id'] . ">" . $row['nombre'];
	            echo "</option>";
	        } 			
	    }
	};

	if ($var=='none') {
	    echo "<option>------------------</option>";
	}else{
		mostrarMuni($var);
	}
?>