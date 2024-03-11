<?php 
	$dni = isset($_GET['dni']) ? urldecode($_GET['dni']) : null;
/*if (isset($_POST['dni'])) {
    $dni = $_POST['dni'];
}

if (isset($_POST['id_estado'])) {
    $id_estado = $_POST['id_estado'];
}
$opcion ="";
if (isset($_POST['opcion'])) {
    $opcion = $_POST['opcion'];
}
	if ($opcion !== "update" && $opcion !== "agregar") {
	$opcion = "registro";
}*/

	require "template/redirigir.php";
	include("config/bd.php");

	
?>


<?php include "template/header.php"; ?>
<?php

    if($dni===null){
    	include("registro-membresia.php");
    	//echo "REGISTRO";
    }else{
    	include("estado_membresia.php");
    	//echo "ESTADO";
    }
    
    

	
?> 
	<div class="cuerpo">

		<div style="flex-direction: column;">
		<form action="expandir-membresia.php" method="POST">
			<input type="hidden" name="id" value="9">
			<input type="submit" name="expandir" value="Expandir"></input>
		</form>
		<div class="membresia" id="dia">
			<div style="display: flex;margin-top: 11px;">
      			<h3 class="t-memb">Un Día</h3>
      			<h3 class="precio">$-----</h3> ||
      			<h3 class="id">id: #9</h3>
      		</div>
      		<p class="duracion">Valida por un día</p>
      		<p class="servicio">Característica: Valido para actividades que se hagan en el dia</p>
      		<p class="politica">Políticas: Sin info.</p>
    	</div>
    	</div>
    	<!--................................TARJETAS BD................................................. -->
<?php
    $consulta = "SELECT id_membresia, nombre_membresia, duracion.nombre_duracion, precio_membresia, servicio_membresia, politica_membresia, color_membresia FROM membresia INNER JOIN duracion ON duracion.id_duracion = membresia.duracion_membresia WHERE gym_membresia = $cod_gym";
	$resultado = $conexion->query($consulta);

// Itera sobre los resultados
while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
    $id = $fila['id_membresia'];
    $nombre = $fila['nombre_membresia'];
    $duracion = $fila['nombre_duracion'];
    $precio = $fila['precio_membresia'];
    $servicio = $fila['servicio_membresia'];
    $politica = $fila['politica_membresia'];
    $color = $fila['color_membresia'];
    switch ($color) {
        case 'white':
            $image = "img-m/membresia-blanca.png";
            break;
        case 'red':
            $image = "img-m/membresia-roja.png";
            break;
        case 'blue':
            $image = "img-m/membresia-azul.png";
            break;
        case 'yellow':
            $image = "img-m/membresia-amarilla.png";
            break;
        case 'gold':
            $image = "img-m/membresia-dorada.png";
            break;
        case 'sky_blue':
            $image = "img-m/membresia-celeste.png";
            break;
        case 'rose':
            $image = "img-m/membresia-rosada.png";
            break;
        default:
            $image = "img-m/membresia-blanca.png";
            break;
    }


    // Ahora puedes imprimir los datos en HTML
    echo '<div style="flex-direction: column;">
    <div style="display:flex;">
        <form action="expandir-membresia.php" method="POST">
            <input type="hidden" name="id" value="' . $id . '">
            <input type="submit" name="expandir" value="Expandir"></input>
        </form>
        <form method="POST">
            <input type="hidden" name="id" value="' . $id . '">
            <input type="submit" name="borrar" value="Borrar"></input>
        </form>
        
        </div>
        <div class="membresia" style="background-image: url(' . $image . ');">
            <div style="display: flex;margin-top: 11px;">
                <h3 class="t-memb">' . $nombre . '</h3>
                <h3 class="precio">$' . $precio . '</h3> ||
                <h3 class="id">id: #' . $id . '</h3>
            </div>
            <p class="duracion">Duración: ' . $duracion . '</p>
            <p class="servicio">Característica: ' . $servicio . '</p>
            <p class="politica">Políticas: ' . $politica . '</p>
        </div>
    </div>';
}
    	?>
	</div>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrar'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $sql_borrar = "DELETE FROM membresia WHERE id_membresia = :id";
    
    $stmt = $conexion->prepare($sql_borrar);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo '<script>window.location.href = "membresia.php";</script>';
    exit();
    }
}

?>
	<script>
 const textarea = document.getElementById('myTextarea');

 textarea.addEventListener('input', function() {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
 });
 </script>
</body>
</html>