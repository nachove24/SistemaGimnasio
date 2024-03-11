<?php
$sql_estado = "SELECT estado_membresia.id_estado FROM estado_membresia WHERE cliente_estado = $dni";
$resultado_estado = $conexion->query($sql_estado);
$row = $resultado_estado->fetch(PDO::FETCH_ASSOC);




if ($resultado_estado->rowCount() > 0) {
    $id_estado = $row['id_estado'];

    $sql_membresia = "SELECT * FROM estado_membresia WHERE estado_membresia.id_estado = $id_estado AND cliente_estado = $dni";
$resultado_membresia = $conexion->query($sql_membresia);
$row_membresia = $resultado_membresia->fetch(PDO::FETCH_ASSOC);
$abonado = $row_membresia['abonado'];
$precio_estado = $row_membresia['precio_estado'];
$tipo_pago = $row_membresia['tipo_pago'];
$membresia_estado = $row_membresia['membresia_estado'];
$id_nombre = $row_membresia['nombre_estado'];
switch ($tipo_pago) {
    case '10':
        $tipo_nombre = "Al Contado";
        break;
    case '11':
        $tipo_nombre = "Semanal";
        break;
    case '12':
        $tipo_nombre = "Mensual";
        break;
}
$fecha_alta = $row_membresia['fecha_alta'];
$fecha_baja = $row_membresia['fecha_baja'];
$fecha_actual = date('Y-m-d');

$adeuda = $precio_estado - $abonado;

if ($adeuda < 0) {
    
    $adeuda = 0;
}

$sql_nombre = "SELECT * FROM membresia WHERE id_membresia = $membresia_estado";
$resultado_nombre = $conexion->query($sql_nombre);
$row_nombre = $resultado_nombre->fetch(PDO::FETCH_ASSOC);
$nombre_membresia = $row_nombre['nombre_membresia'];
$fondo_membresia = $row_nombre['color_membresia'];
switch ($fondo_membresia) {
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

if ($fecha_actual > $fecha_baja) {
    $id_nombre = 1;
}else{
    if ($adeuda != 0) {
        $id_nombre = 3;
    }else{$id_nombre = 2;}
}
 $sql_update = "UPDATE estado_membresia SET nombre_estado = :id_nombre WHERE estado_membresia.id_estado = :id_estado AND cliente_estado = :dni";
 $stmt_update = $conexion->prepare($sql_update);
 $stmt_update->bindParam(':id_nombre', $id_nombre);
 $stmt_update->bindParam(':id_estado', $id_estado);
 $stmt_update->bindParam(':dni', $dni);
 $stmt_update->execute();


$sql_estado = "SELECT * FROM estado WHERE id_estado = $id_nombre";
$resultado_estado = $conexion->query($sql_estado);
$row_estado = $resultado_estado->fetch(PDO::FETCH_ASSOC);
$nombre_estado = $row_estado['nombre_estado'];

switch ($nombre_estado) {
    case 'Expirada':
        $color_estado = "red";
        break;
    case 'Activa':
        $color_estado = "green";
        break;
    case 'Inactiva':
        $color_estado = "gray";
        break;
    case 'Cancelada':
        $color_estado = "orange";
    break;    
}




$editar="";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['listo'])){
    $abonado_new = $_POST["abonado_new"];
    $abonado_new = $abonado_new + $abonado;
    $tipo_new = $_POST["tipo_new"];
    $editar="";
    $sql_actualizar1 = "UPDATE estado_membresia SET abonado = :abonado, tipo_pago = :tipo_pago WHERE cliente_estado = :dni AND estado_membresia.id_estado = :id_estado";
                $sql_actualizar1 = $conexion->prepare($sql_actualizar1);
                $sql_actualizar1->bindParam(':abonado', $abonado_new);
                $sql_actualizar1->bindParam(':tipo_pago', $tipo_new);
                $sql_actualizar1->bindParam(':dni', $dni);
                $sql_actualizar1->bindParam(':id_estado', $id_estado);
                $sql_actualizar1->execute();

                header("Location: gestion-cliente.php?dni=" . urlencode($dni));
}



    echo '<div class="membresia-cliente">
        <table class="table-membresia">
            <thead>
            <div style="height:30px;display:flex;">
                <p style="text-align: center;color: white;font-family: fantasy;padding-top:13px;">MEMBRESIA</p>
                <form method="post">
                <input type="hidden" name="id_estado" value="' . $id_estado . '">
                <button type="submit" value="" name="dni-estado" class="submit-img3"></button>
                </form>
                <form action="" method="post">
                <input type="hidden" name="cambio" value="editar">
                <button type="submit" name="editar" value="" class="submit-img4"></button>
                </form>';
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dni-estado'])){
                if (isset($_POST['id_estado'])) {
                    $id_estado = $_POST['id_estado'];
                }

            $sql_eliminar = "DELETE FROM estado_membresia WHERE estado_membresia.id_estado = :id_estado";
            $consulta_eliminar = $conexion->prepare($sql_eliminar);
            $consulta_eliminar->bindParam(':id_estado', $id_estado, PDO::PARAM_INT);
            $consulta_eliminar->execute();
                
            header("Location: membresia.php?dni=" . urlencode($dni));
        }
            echo '</div>
                <tr>
                    <th style="background-color:' . $color_estado . ';">
                        ' . $nombre_estado . '
                    </th>
                </tr>
            </thead>
            <tbody>
                <td>
                 <div class="membresia-group" style="background-image: url(\'' . $image . '\');">';

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
                    $editar = $_POST["cambio"];
                }
                switch ($editar) {
                    case 'editar':
                       echo '<form action="" method="post">
                       <div style="display:flex;">
                            <p>Abonado:</p>
                            <input type="number" name="abonado_new" value="" required>
                        </div>
                        <div style="display:flex;">
                            <p>Tipo de pago:</p>
                             <select name="tipo_new">
                            <option value="10">Al Contado</option>
                            <option value="11">Semanal</option>
                            <option value="12">Mensual</option>
                             </select>
                        </div>
                            <button type="submit" name="listo" value="Aceptar" class="accion">Aceptar</button>
                            </form>';
                        break;
                    
                    default:
                        echo '<ul>
                            <li><p style="text-decoration: underline;">' . $nombre_membresia . '</p></li>
                            <li><p>Abonado: $' . $abonado . '</p></li>
                            <li><p>Adeuda: $' . $adeuda . '</p></li>
                            <li><p>' . $tipo_nombre . '</p></li>
                            <li><p>Emitido: ' . $fecha_alta . '</p></li>
                            <li><p>Vence: ' . $fecha_baja . '</p></li>
                            </ul>';
                        break;
                }
                    
               echo ' </div>
                </td>
            </tbody>
        </table>
</div>';
}else{
    ?>
    <div class="membresia-cliente">
        <table class="table-membresia">
            <thead>
                <p style="text-align: center;color: white;font-family: fantasy;">MEMBRESIA</p>
                <tr>
                    <th style="background-color: gray;">
                        Ninguna
                    </th>
                </tr>
            </thead>
            <tbody>
                <td>
                <div class="membresia-group">
                    <form method="post">
                       <!--<?php //echo '<input type="hidden" name="dni" value="' . $dni . '">'?>-->
                       <!--<p style="text-align: center;color: white;background-color: black;">AÑADIR</p>-->
                       <button type="submit" value="" name="nuevo" class="submit-img2"></button>
                    </form>
                </div>
                </td>
            </tbody>
        </table>
</div>
    <?php
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nuevo'])){
    header("Location: membresia.php?dni=" . urlencode($dni));

}

?>
