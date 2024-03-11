
	<h2 class="titulo" style="color: #A9F5F2;">Estado de la Membresia</h2>
	<div class="cabecera">
		<form method="post">
			<div class="form-group" style="margin-left: 180px;">
				<h4>Membresia</h4>
				<select name="membresia_estado">
					<option value="9">Un día</option>
					<?php
					$consulta2 = "SELECT id_membresia, nombre_membresia FROM membresia WHERE gym_membresia = $cod_gym";
					$resultado2 = $conexion->query($consulta2);

					// Itera sobre los resultados
					while ($fila = $resultado2->fetch(PDO::FETCH_ASSOC)) {
						$id = $fila['id_membresia'];
						$nombre = $fila['nombre_membresia'];
						echo '<option value="' . $id . '">' . $nombre . '</option>';
					}
					?>
    			</select>
			</div>
			<div class="form-group">
				<h4>Tipo de pago</h4>
				<select name="tipo_pago">
    				<option value="10">Al Contado</option>
    				<option value="11">Semanal</option>
    				<option value="12">Mensual</option>
  				</select>
  			</div>
  			<div class="form-group">
				<h4>Abonado</h4>
				<input type="number" name="abonado" class="input-style">
			</div>
			<div class="form-group">
  				<input type="submit" value="Aceptar" name="estado" class="accion" style="margin-top: 10px;">
			</div>
		</form>
	</div>


	<?php
 		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['estado'])) {
		$membresia_estado = "";
		if (isset($_POST['membresia_estado'])) {
    		$membresia_estado = $_POST['membresia_estado'];
		}
		$tipo_pago = "";
		if (isset($_POST['tipo_pago'])) {
    		$tipo_pago = $_POST['tipo_pago'];
		}
		$abonado = "";
		if (isset($_POST['abonado'])) {
    		$abonado = $_POST['abonado'];
		}
		$fecha_alta = date('Y-m-d');
		
		$sql_fecha = "SELECT duracion_membresia FROM membresia WHERE id_membresia = :membresia_estado";
		$stmt = $conexion->prepare($sql_fecha);
		$stmt->bindParam(':membresia_estado', $membresia_estado, PDO::PARAM_INT);
		$stmt->execute();
		$resultado_fecha = $stmt->fetch(PDO::FETCH_ASSOC);

		switch ($resultado_fecha['duracion_membresia']) {
			case '1':
				$fecha_baja = date('Y-m-d', strtotime($fecha_alta . ' + 1 week'));
				break;
			case '2':
				$fecha_baja = date('Y-m-d', strtotime($fecha_alta . ' + 15 days'));
				break;
			case '3':
				$fecha_baja = date('Y-m-d', strtotime($fecha_alta . ' + 1 month'));
				break;
			case '4':
				$fecha_baja = date('Y-m-d', strtotime($fecha_alta . ' + 1 year'));
				break;
			case '5':
				$fecha_baja = date('Y-m-d', strtotime($fecha_alta . ' + 3 month'));
				break;
			case '6':
				$fecha_baja = date('Y-m-d', strtotime($fecha_alta . ' + 6 month'));
				break;
			case '9':
				$fecha_baja = date('Y-m-d', strtotime($fecha_alta . ' + 1 day'));
				break;
		}
		$sql_precio = "SELECT precio_membresia FROM membresia WHERE id_membresia = $membresia_estado";
		$resultado_precio = $conexion->query($sql_precio);
		$row2 = $resultado_precio->fetch(PDO::FETCH_ASSOC);
		$precio_estado = $row2['precio_membresia'];

		//EN CASO DE AÑADIR UNO NUEVO////////////////////

		$sentenciaSQL = $conexion->prepare("INSERT INTO estado_membresia (membresia_estado,fecha_alta,fecha_baja,tipo_pago,abonado,cliente_estado,precio_estado) VALUES (:membresia_estado,:fecha_alta,:fecha_baja,:tipo_pago,:abonado,:cliente_estado,:precio_estado);");
		$sentenciaSQL->bindParam(':membresia_estado', $membresia_estado);
		$sentenciaSQL->bindParam(':fecha_alta', $fecha_alta);
		$sentenciaSQL->bindParam(':fecha_baja', $fecha_baja);
		$sentenciaSQL->bindParam(':tipo_pago', $tipo_pago);
		$sentenciaSQL->bindParam(':abonado', $abonado);
		$sentenciaSQL->bindParam(':cliente_estado', $dni);
		$sentenciaSQL->bindParam(':precio_estado', $precio_estado);
		$sentenciaSQL->execute();

		header("Location: gestion-cliente.php?dni=" . urlencode($dni));
		
			}
 		

	?>
