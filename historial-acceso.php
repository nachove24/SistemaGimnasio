<?php
require "template/redirigir.php";
    include "config/bd.php";
/*if ($resultado2->rowCount() > 0) {
    echo '<table class="table user-info" style="margin-top:100px;">';
    echo '<tr>
            <th>ID Acceso</th>
            <th>Fecha de Acceso</th>
            <th>Ubicación de Acceso</th>
            <th>ID Admin</th>
        </tr>';

    // Itera a través de los resultados y muestra cada fila
    while ($fila = $resultado2->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $fila['id_acceso'] . '</td>';
        echo '<td>' . $fila['fecha_acceso'] . '</td>';
        echo '<td>' . $fila['ubicacion_acceso'] . '</td>';
        echo '<td>' . $fila['admin_acceso'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    // Mostrar un mensaje si no hay resultados
    echo '<p>No se encontraron resultados.</p>';
}*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym App</title>
    <link rel="stylesheet" href="registro.css">
    <style>
        .containerh {
            display: flex;
            width: 100%;
            height: 100vh;
            position: relative;
        }

        .left {
            flex: 2;
            position: relative;
        }

        .right {
            flex: 1;
            position: relative;
        }
        .right p{
            color: white;
            margin-left: 90px;
            margin-top: 10px;
            
        }

        .line {
            position: absolute;
            background-color: black;
            width: 1px;
            height: 100%;
        }
    </style>
</head>
<body>
    <h2 class="titulo" style="margin-top: 30px;margin-right: 480px;">Historial de Acceso</h2>
    <div class="containerh">
        <div class="left">
            <?php
// Transforma el código SQL INSERT en una consulta SELECT para imprimir en la tabla
$sentenciaConsulta = $conexion->prepare("SELECT acceso.id_acceso, acceso.cliente_acceso,cliente.nombre_c,cliente.apellido_c, acceso.fecha_acceso, acceso.ubicacion_acceso, acceso.admin_acceso FROM acceso INNER JOIN cliente ON cliente.dni = acceso.cliente_acceso INNER JOIN gimnasio ON gimnasio.cod_gym = cliente.gym_cliente WHERE gimnasio.cod_gym = :cod_gym ORDER BY acceso.fecha_acceso DESC");
$sentenciaConsulta->bindParam(':cod_gym', $cod_gym, PDO::PARAM_STR);
$sentenciaConsulta->execute();

echo '<table class="table user-info" style="margin-top:60px;margin-left:7px;">';
echo '<tr>
        <th>ID Acceso</th>
        <th>DNI Cliente</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Fecha de Acceso</th>
        <th>Ubicación de Acceso</th>
        <th>ID Admin</th>
        <th>Membresia</th>
    </tr>';

// Itera a través de los resultados y muestra cada fila
while ($filaConsulta = $sentenciaConsulta->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $filaConsulta['id_acceso'] . '</td>';
    echo '<td>' . $filaConsulta['cliente_acceso'] . '</td>';
    echo '<td>' . $filaConsulta['nombre_c'] . '</td>';
    echo '<td>' . $filaConsulta['apellido_c'] . '</td>';
    echo '<td>' . $filaConsulta['fecha_acceso'] . '</td>';
    echo '<td>' . $filaConsulta['ubicacion_acceso'] . '</td>';
    echo '<td>' . $filaConsulta['admin_acceso'] . '</td>';
    $cliente_dni = $filaConsulta['cliente_acceso'];
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
    echo '</tr>';
}

echo '</table>';
?>

        </div>
        <div class="line"></div>
        <div class="right">
<?php
// PARA EL DÍA /////////////////////////////////////////////////////

try {
    // Preparar la consulta
    $consulta = "SELECT COUNT(*) AS total_accesos
                 FROM acceso
                 INNER JOIN cliente ON cliente.dni = acceso.cliente_acceso
                 INNER JOIN gimnasio ON gimnasio.cod_gym = cliente.gym_cliente
                 WHERE gimnasio.cod_gym = :cod_gym AND DATE(acceso.fecha_acceso) = CURDATE()";

    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':cod_gym', $cod_gym, PDO::PARAM_INT);
    
    $stmt->execute();

    // Obtener resultados
    $resultados = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mostrar resultado
    $_SESSION['total-dia']= $resultados['total_accesos'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// PARA EL MES ////////////////////////////////////////

try {
    // Preparar la consulta
    $consulta = "SELECT COUNT(*) AS total_accesos
                 FROM acceso
                 INNER JOIN cliente ON cliente.dni = acceso.cliente_acceso
                 INNER JOIN gimnasio ON gimnasio.cod_gym = cliente.gym_cliente
                 WHERE gimnasio.cod_gym = :cod_gym AND MONTH(acceso.fecha_acceso) = MONTH(CURDATE())";

    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':cod_gym', $cod_gym, PDO::PARAM_INT);
    
    $stmt->execute();

    // Obtener resultados
    $resultados = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mostrar resultado
    $_SESSION['total-mes']= $resultados['total_accesos'];
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


// PARA LA SEMANA /////////////////////////////////////////////

try {
    // Preparar la consulta
    $consulta = "SELECT COUNT(*) AS total_accesos
                 FROM acceso
                 INNER JOIN cliente ON cliente.dni = acceso.cliente_acceso
                 INNER JOIN gimnasio ON gimnasio.cod_gym = cliente.gym_cliente
                 WHERE gimnasio.cod_gym = :cod_gym AND WEEK(acceso.fecha_acceso) = WEEK(CURDATE())";

    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':cod_gym', $cod_gym, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener resultados
    $resultados = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mostrar resultado
    $_SESSION['total-semana']= $resultados['total_accesos'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


// Promedio por dia //////////////////////////

try {
    // Obtener la fecha del primer registro
    $consultaFechaPrimerRegistro = "SELECT MIN(fecha_acceso) AS fecha_primer_registro
                                    FROM acceso
                                    INNER JOIN cliente ON cliente.dni = acceso.cliente_acceso
                                    INNER JOIN gimnasio ON gimnasio.cod_gym = cliente.gym_cliente
                                    WHERE gimnasio.cod_gym = :cod_gym";

    $stmtFechaPrimerRegistro = $conexion->prepare($consultaFechaPrimerRegistro);
    $stmtFechaPrimerRegistro->bindParam(':cod_gym', $cod_gym, PDO::PARAM_INT);
    $stmtFechaPrimerRegistro->execute();

    $resultadoFechaPrimerRegistro = $stmtFechaPrimerRegistro->fetch(PDO::FETCH_ASSOC);
    $fechaPrimerRegistro = $resultadoFechaPrimerRegistro['fecha_primer_registro'];

    // Obtener la cantidad de días transcurridos
    $diasTranscurridos = 1;
    if ($fechaPrimerRegistro) {
        $fechaActual = new DateTime();
        $fechaRegistro = new DateTime($fechaPrimerRegistro);
        $intervalo = $fechaActual->diff($fechaRegistro);
        $diasTranscurridos = $intervalo->days;
        $diasTranscurridos = ($diasTranscurridos <= 0) ? 1 : $diasTranscurridos;
    }


    // Obtener la cantidad de personas que ingresaron desde el primer registro
    $consultaPersonasIngresaron = "SELECT COUNT(*) AS total_personas_ingresaron
                                   FROM acceso
                                   INNER JOIN cliente ON cliente.dni = acceso.cliente_acceso
                                   INNER JOIN gimnasio ON gimnasio.cod_gym = cliente.gym_cliente
                                   WHERE gimnasio.cod_gym = :cod_gym AND fecha_acceso >= :fecha_primer_registro";

    $stmtPersonasIngresaron = $conexion->prepare($consultaPersonasIngresaron);
    $stmtPersonasIngresaron->bindParam(':cod_gym', $cod_gym, PDO::PARAM_INT);
    $stmtPersonasIngresaron->bindParam(':fecha_primer_registro', $fechaPrimerRegistro, PDO::PARAM_STR);
    $stmtPersonasIngresaron->execute();

    $resultadoPersonasIngresaron = $stmtPersonasIngresaron->fetch(PDO::FETCH_ASSOC);
    $totalPersonasIngresaron = $resultadoPersonasIngresaron['total_personas_ingresaron'];

    // Calcular y mostrar el resultado
    if ($totalPersonasIngresaron > 0) {
        $promedioDiasPorPersona = $totalPersonasIngresaron / $diasTranscurridos;
        $_SESSION['promedio-dia']= $promedioDiasPorPersona;
    } else {
        echo "No hay personas que hayan ingresado desde el primer registro.";
        $_SESSION['promedio-dia']=0;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
    <h4 style="color: #F5A9BC;margin-left: 190px;margin-top: 40px;text-decoration: underline;">Estadísticas</h4>
    <?php
        $totaldia=$_SESSION['total-dia'];
        $totalmes=$_SESSION['total-mes'];
        $totalsemana=$_SESSION['total-semana'];
        $promediodia=$_SESSION['promedio-dia'];
        echo "<p>Total ingresos del día: " . $totaldia . "</p>";
        echo "<p>Total ingresos de la semana: " . $totalsemana . "</p>";
        echo "<p>Total ingresos del mes: " . $totalmes . "</p>";
        echo "<p>Promedio de ingresos por día: " . round($promediodia, 2) . "</p>";
    ?>
    
        </div>
    </div>
</body>
</html>
