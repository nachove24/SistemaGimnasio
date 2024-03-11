<?php
require "template/redirigir.php";



?>

<?php include "template/header.php"; ?>
	<div class="form-contest">
		<form method="post" class="form-list">
			<h2 style="color: #A9F5F2;">Lista de Clientes</h2>
			<select name="filtro">
    			<option value="dni">DNI:</option>
    			<option value="nombre">Nombre:</option>
    			<option value="apellido">Apellido:</option>
  			</select>
			<input type="text" class="text" name="cliente">
			<input type="submit" name="accion" value="Buscar" class="accion" style="background-color: #5882FA; margin: 5px;">
			<input type="submit" name="accion" value="Volver" class="accion" style="background-color: red;">
		</form>
	</div>
	<?php 


$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";



switch ($accion) {
	case 'Volver':
	
	header("Location:lista-cliente.php");
		break;

	case 'Buscar':
		?>


	<div class="container">
	<table>
		<table class="table table-bordered">
	<thead>
		<tr>
			<th>DNI</th>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Email</th>
			<th>Membresia</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
		
		// Incluir archivo de conexión
		include("config/bd.php");

		// Verificar si se ha enviado el formulario
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
		$filtro = $_POST["filtro"];

		// Validar y tratar el valor según el tipo de búsqueda
		$cliente = $_POST["cliente"];

switch ($filtro) {
    case 'dni':
        
        $int = intval($cliente);
        $consulta = "SELECT * FROM cliente WHERE dni = $int AND gym_cliente = $cod_gym";
        break;
    case 'nombre':
        
        $cliente = $conexion->quote($cliente);
        $consulta = "SELECT * FROM cliente WHERE nombre_c = $cliente AND gym_cliente = $cod_gym";
        break;
    case 'apellido':
        
        $cliente = $conexion->quote($cliente);
        $consulta = "SELECT * FROM cliente WHERE apellido_c = $cliente AND gym_cliente = $cod_gym";
        break;
    }

        $sql = $consulta;
		$resultado = $conexion->query($sql);

		if ($resultado->rowCount() > 0) {
		 while ($fila = $resultado->fetch()) {
        	echo "<tr>";
        	echo "<td>" . $fila["dni"] . "</td>";
        	echo "<td>" . $fila["nombre_c"] . "</td>";
        	echo "<td>" . $fila["apellido_c"] . "</td>";
        	echo "<td>" . $fila["email"] . "</td>";

        	$cliente_dni = $fila["dni"];
        	$sql_estado = "SELECT estado_membresia.id_estado FROM estado_membresia WHERE cliente_estado = $cliente_dni";
			$resultado_estado = $conexion->query($sql_estado);
			$row = $resultado_estado->fetch(PDO::FETCH_ASSOC);

        	if (isset($row['id_estado']) && !is_bool($row['id_estado'])) {
    			// $id_estado está definido y no es un booleano
    		$id_estado = $row['id_estado'];
    		$sql_membresia = "SELECT * FROM estado_membresia WHERE estado_membresia.id_estado = $id_estado AND cliente_estado = $cliente_dni";
			$resultado_membresia = $conexion->query($sql_membresia);
			$row_membresia = $resultado_membresia->fetch(PDO::FETCH_ASSOC);
			$abonado = $row_membresia['abonado'];
			$precio_estado = $row_membresia['precio_estado'];
			$membresia_estado = $row_membresia['membresia_estado'];
			$id_nombre = $row_membresia['nombre_estado'];
			$fecha_alta = $row_membresia['fecha_alta'];
			$fecha_baja = $row_membresia['fecha_baja'];
			$fecha_actual = date('Y-m-d');
			$adeuda = $precio_estado - $abonado;
			if ($adeuda < 0) {
    			$adeuda = 0;
			}
			if ($fecha_actual > $fecha_baja) {
    			echo "<td style='color: red;'>Expirada</td>";
			}else{
    			if ($adeuda != 0) {
        			echo "<td style='color: red;'>Adeuda</td>";
    			}else{echo "<td style='color: green;'>Activa</td>";}
			}
			} else {
    			// En caso de que $id_estado no esté definido o sea un booleano
    			echo "<td style='color: white;'>Ninguna</td>";
			}
			

        	echo "<td>";
        	echo "<form method='post'>";
       		echo "<input type='hidden' name='dni' value='" . $fila["dni"] . "'>";
        	echo "<button type='submit' name='acceder' value='acceder' class='accion'>Más Info.</button>";
        	echo "</form>";
        	echo "</td>";
        	echo "</tr>";
			}
			}else {
				// Mostrar mensaje de que no se encontró el registro
				echo "<tr><td colspan='6'>No se encontró el registro $cliente.</td></tr>";
			}
		}
		?>

		</tbody>
</table>
</div>
		
		<?php
	
		break;
	
	default:
		include("config/bd.php");

		// Consulta SQL para obtener todos los registros
		$sql = "SELECT * FROM cliente WHERE gym_cliente = :cod_gym";
		$resultado = $conexion->prepare($sql);
		$resultado->bindParam(":cod_gym", $cod_gym, PDO::PARAM_INT);
		$resultado->execute();
		//$resultado = $conexion->query($sql);

		// Obtener todos los registros
		$registros = $resultado->fetchAll();

?>

		<div class="container">
	<table>
		<table class="table table-bordered">
	<thead>
		<tr>
			<th>DNI</th>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Email</th>
			<th>Membresia</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>

		<?php
		// Iterar sobre todos los registros
		foreach ($registros as $fila) {
			echo "<tr>";
			echo "<td>" . $fila["dni"] . "</td>";
			echo "<td>" . $fila["nombre_c"] . "</td>";
			echo "<td>" . $fila["apellido_c"] . "</td>";
			echo "<td>" . $fila["email"] . "</td>";
			$cliente_dni = $fila["dni"];
        	$sql_estado = "SELECT estado_membresia.id_estado FROM estado_membresia WHERE cliente_estado = $cliente_dni";
			$resultado_estado = $conexion->query($sql_estado);
			$row = $resultado_estado->fetch(PDO::FETCH_ASSOC);

        	if (isset($row['id_estado']) && !is_bool($row['id_estado'])) {
    			// $id_estado está definido y no es un booleano
    		$id_estado = $row['id_estado'];
    		$sql_membresia = "SELECT * FROM estado_membresia WHERE estado_membresia.id_estado = $id_estado AND cliente_estado = $cliente_dni";
			$resultado_membresia = $conexion->query($sql_membresia);
			$row_membresia = $resultado_membresia->fetch(PDO::FETCH_ASSOC);
			$abonado = $row_membresia['abonado'];
			$precio_estado = $row_membresia['precio_estado'];
			$membresia_estado = $row_membresia['membresia_estado'];
			$id_nombre = $row_membresia['nombre_estado'];
			$fecha_alta = $row_membresia['fecha_alta'];
			$fecha_baja = $row_membresia['fecha_baja'];
			$fecha_actual = date('Y-m-d');
			$adeuda = $precio_estado - $abonado;
			if ($adeuda < 0) {
    			$adeuda = 0;
			}
			if ($fecha_actual > $fecha_baja) {
    			echo "<td style='color: red;'>Expirada</td>";
			}else{
    			if ($adeuda != 0) {
        			echo "<td style='color: red;'>Adeuda</td>";
    			}else{echo "<td style='color: green;'>Activa</td>";}
			}
			} else {
    			// En caso de que $id_estado no esté definido o sea un booleano
    			echo "<td style='color: white;'>Ninguna</td>";
			}
			
			echo "<td>";
			echo "<form method='post'>";
			echo "<input type='hidden' name='dni' value='" . $fila["dni"] . "'>";
			echo "<button type='submit' name='acceder' value='acceder' class='accion'>Más Info.</button>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";
		}
		?>
		</tbody>
</table>
	<?php
		break;
	
}
		
	$acceder= (isset($_POST['acceder'])) ? $_POST['acceder'] : "";

	if ($acceder=="acceder"){
		$dni = (isset($_POST['dni'])) ? $_POST['dni'] : "";
		header("Location: gestion-cliente.php?dni=" . urlencode($dni));
	}
		?>

</body>

</html>
