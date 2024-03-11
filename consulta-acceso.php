<?php
include "template/header.php";
	session_start();
	if(isset($_POST['dni'])) {
        $dni = $_POST['dni'];
    }
    $_SESSION['pdf_data'] = $dni;
    $dnipdf = $_SESSION['pdf_data'];

	require("config/bd.php");

	
$sql = "SELECT acceso.cliente_acceso,cliente.nombre_c,cliente.apellido_c,acceso.fecha_acceso,acceso.ubicacion_acceso
        FROM acceso
        INNER JOIN cliente ON cliente.dni = acceso.cliente_acceso
        WHERE acceso.cliente_acceso = $dnipdf
        ORDER BY acceso.fecha_acceso DESC";
$stmt = $conexion->query($sql);
$result = $stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
        <h1 class="titulo">Historial del cliente</h1>
    </div>
<?php if (count($rows) > 0): ?>

    <table class="table user-info" style="margin-top:100px;">
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha de Acceso</th>
            <th>Ubicación</th>
        </tr>

        <?php foreach ($rows as $fila): ?>
            <tr>
                <td><?php echo $fila['cliente_acceso']; ?></td>
                <td><?php echo $fila['nombre_c']; ?></td>
                <td><?php echo $fila['apellido_c']; ?></td>
                <td><?php echo $fila['fecha_acceso']; ?></td>
                <td><?php echo $fila['ubicacion_acceso']; ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php else: ?>
    <p>No se encontraron resultados.</p>
<?php endif; ?>

    
<?php
    /*foreach ($rows as $row) {
    $csvData .= $row["cliente_acceso"] . ";" . $row["nombre_c"] . ";" . $row["apellido_c"] . ";" . $row["fecha_acceso"] . ";" . "\n";
	}
	foreach ($rows as $row) {
    	print $row["cliente_acceso"].";".$row["nombre_c"].";".$row["apellido_c"].";".$row["fecha_acceso"].";"."\n";
    }*/

	// Guardar los datos en una variable de sesión
	

    
?>