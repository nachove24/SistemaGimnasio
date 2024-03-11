<?php
require "template/redirigir.php";

$dni = isset($_GET['dni']) ? urldecode($_GET['dni']) : null;

	include("config/bd.php");
	///////////NOMBRE Y APELLIDO////////////////////////////
	$consulta = "SELECT nombre_c, apellido_c FROM cliente WHERE dni = $dni AND gym_cliente = $cod_gym";
	$sql = $consulta;
	$resultado = $conexion->query($sql);
    //REGISTRO ////////////////////////////////////////////////
	$sql_registro = "SELECT fecha_registro, nombre_admin FROM registro INNER JOIN administrador ON administrador.cod_admin = registro.admin_registro WHERE cliente_registro = $dni AND gym_registro = $cod_gym";
	$resultado_registro = $conexion->query($sql_registro);
	//PESO Y ALTURA //////////////////////////////////////////
	//$peso = isset($peso) ? $peso : 0;
	//$altura = isset($altura) ? $altura : 0;
	$sql_peso_altura = "SELECT peso, altura FROM cliente WHERE dni = $dni AND gym_cliente = $cod_gym";
	$resultado_peso_altura = $conexion->query($sql_peso_altura);
	
?>

<?php include "template/header.php"; ?>

    <div>
        <h1 class="titulo">Gestión Cliente</h1>
    </div>

    <div class="user-container container">
        <div class="user-details">
            <img src="img/logo-perfil.png" alt="Imagen de Usuario" width="100">
            <?php
				while ($fila = $resultado->fetch()) {
   				$nombre = $fila['nombre_c'];
    			$apellido = $fila['apellido_c'];

    			echo "<h2 style='color: #2EFEF7;'>" . $nombre . " " . $apellido . "</h2>";
				}
			?>

        </div>
        <?php  
        	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['peso1'])) {
        		$peso = $_POST["peso"];
        		$altura = $_POST["altura"];

        		$sql_actualizar = "UPDATE cliente SET peso = :peso, altura = :altura WHERE dni = :dni AND gym_cliente = :cod_gym";
        		$sql_actualizar2 = $conexion->prepare($sql_actualizar);
            	$sql_actualizar2->bindParam(':peso', $peso);
            	$sql_actualizar2->bindParam(':altura', $altura);
            	$sql_actualizar2->bindParam(':dni', $dni);
            	$sql_actualizar2->bindParam(':cod_gym', $cod_gym);
            	$sql_actualizar2->execute();

            	header("Location: gestion-cliente.php?dni=" . urlencode($dni));
        	}

        ?>
        <form method="post" class="datos-cliente" id="myForm" onpagehide="clearForm()">
        	<?php
				while ($fila_ap = $resultado_peso_altura->fetch()) {
   				$peso = $fila_ap['peso'];
    			$altura = $fila_ap['altura'];
			?>
        	<div class="datos-group">
        		<h4>Peso</h4>
        	<?php echo "<h3>" . $peso . "Kg." . "</h3>";?>
        		<input type="number" name="peso" max="636" required>
        	</div>
        	<div class="datos-group">
        		<h4>Altura</h4>
        	<?php echo "<h3>" . $altura . "cm" . "</h3>";?>
        		<input type="number" name="altura" max="300" required>
        	</div>
        	<?php } ?>
        	<div class="datos-group">
        		<button type="submit" name="peso1" value="" class="submit-img"></button>
        	</div>
        </form>
        <div class="options">
            <!--<a href="#">Configuración</a> |-->
            <a href="eliminar-cliente.php?dni=<?php echo $dni; ?>">Dar de baja</a>
            <?php
            	while ($fila2 = $resultado_registro->fetch()) { 
            	echo "<p style='color: white;'>" . "Ingresó: " . $fila2['fecha_registro'] . "</p>";
            	echo "<p style='color: white;'>" . "Hecho por: " . $fila2['nombre_admin'] . "</p>";
            }
            ?>

        </div>
    </div>
    <div class="include">
    <?php include("membresia-cliente.php"); ?>
    <?php include("acceso-gestion.php"); ?>
    <?php include("clase-gestion.php"); ?>
    </div>

<?php 
    $sql2 = "SELECT dni,email,genero,direccion,telefono,nacimiento FROM cliente WHERE dni = $dni AND gym_cliente = $cod_gym";
	$resultado2 = $conexion->query($sql2);

	// Verifica si hay resultados
	if ($resultado2->rowCount() > 0) {
    echo '<table class="table user-info" style="margin-top:100px;">';
    echo '<tr>
			<th>DNI</th>
			<th>Correo Electrónico</th>
			<th>Genero</th>
			<th>Dirección</th>
			<th>Teléfono</th>
			<th>Nacimiento</th>
		</tr>';

// Itera a través de los resultados y muestra cada fila
echo '<tr>';
while ($fila = $resultado2->fetch(PDO::FETCH_ASSOC)) {
    echo '<td>' . $fila['dni'] . '</td>';
    echo '<td>' . $fila['email'] . '</td>';
    echo '<td>' . $fila['genero'] . '</td>';
    echo '<td>' . $fila['direccion'] . '</td>';
    echo '<td>' . $fila['telefono'] . '</td>';
    echo '<td>' . $fila['nacimiento'] . '</td>';
}
echo '</tr>';
echo '</table>';
	} else {
    	// Mostrar un mensaje si no hay resultados
    	echo '<p>No se encontraron resultados.</p>';
	}
?>


<?php //include("template/pie.php"); ?>
<script type="text/javascript">
	function clearForm() {
    document.getElementById("myForm").reset();
}

    window.onload = function() {
        window.history.replaceState({}, document.title, window.location.href);
    };


</script>
</body>
</html>
