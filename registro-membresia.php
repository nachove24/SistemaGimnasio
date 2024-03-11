<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registro'])) {
		$nombre = "";
		if (isset($_POST['nombre'])) {
    		$nombre = $_POST['nombre'];
		}
		$precio = "";
		if (isset($_POST['precio'])) {
    		$precio = $_POST['precio'];
		}
		$servicio = "";
		if (isset($_POST['servicio'])) {
    		$servicio = $_POST['servicio'];
		}
		$politica = "";
		if (isset($_POST['politica'])) {
    		$politica = $_POST['politica'];
		}
		$duracion = "";
		if (isset($_POST['duracion'])) {
    		$duracion = $_POST['duracion'];
		}
		$color = "";
		if (isset($_POST['color'])) {
    		$color = $_POST['color'];
		}

		$sentenciaSQL = $conexion->prepare("INSERT INTO membresia (nombre_membresia,duracion_membresia,precio_membresia,servicio_membresia,politica_membresia,color_membresia,gym_membresia) VALUES (:nombre,:duracion,:precio,:servicio,:politica,:color,:cod_gym);");
		$sentenciaSQL->bindParam(':nombre', $nombre);
		$sentenciaSQL->bindParam(':duracion', $duracion);
		$sentenciaSQL->bindParam(':precio', $precio);
		$sentenciaSQL->bindParam(':servicio', $servicio);
		$sentenciaSQL->bindParam(':politica', $politica);
		$sentenciaSQL->bindParam(':color', $color);
		$sentenciaSQL->bindParam(':cod_gym', $cod_gym);
		$sentenciaSQL->execute();
	}
?>
	<h2 class="titulo" style="color: #A9F5F2;">Registro de Membresia</h2>
	<div class="cabecera">
		<form method="post" autocomplete="off">
			<div class="form-group">
				<h4>Nombre de la membresia</h4>
				<input type="text" name="nombre" class="input-style" maxlength="11" required>
			</div>
			<div class="form-group">
				<h4>Precio</h4>
				<input type="number" name="precio" class="input-style" required>
			</div>
			<div class="form-group">
				<h4>Servicio de la membresia</h4>
				<textarea id="servis" id="myTextarea" name="servicio" rows="10" cols="20"></textarea>
			</div>
			<div class="form-group">
				<h4>Politicas de la membresia</h4>
				<textarea id="politics" name="politica" rows="10" cols="20"></textarea>
			</div>
			<div class="form-group">
				<h4>Duración</h4>
				<select name="duracion">
    				<option value="1">Una Semana</option>
    				<option value="2">Quincena</option>
    				<option value="3">Un Mes</option>
    				<option value="4">Un Año</option>
    				<option value="5">Trimestre</option>
    				<option value="6">Semestre</option>
  				</select>
  				<h4 style="margin-top: 5px;">Color</h4>
				<select name="color">
    				<option value="white">Blanco</option>
    				<option value="red">Rojo</option>
    				<option value="blue">Azul</option>
    				<option value="yellow">Amarillo</option>
    				<option value="gold">Dorado</option>
    				<option value="sky_blue">Celeste</option>
    				<option value="rose">Rosado</option>
  				</select>
			</div>
			<div class="form-group">
  				<input type="submit" value="Confirmar" name="registro" class="accion" style="margin-top: 10px;">
			</div>
		</form>
	</div>