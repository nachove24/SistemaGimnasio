
<?php
$consulta2 = "SELECT clase.id_clase, clase.nombre_clase FROM clase INNER JOIN cliente ON cliente.clase_cliente = clase.id_clase WHERE clase.gym_clase = $cod_gym AND cliente.dni = $dni";
$resultado2 = $conexion->query($consulta2);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clase'])) {
    $clases = $_POST["clases"];
    $sql_actualizar = "UPDATE cliente SET clase_cliente = :clases WHERE dni = $dni AND gym_cliente = $cod_gym";
    $sql_actualizar2 = $conexion->prepare($sql_actualizar);
    $sql_actualizar2->bindParam(':clases', $clases);
    $sql_actualizar2->execute();

    $sql_ingreso = "SELECT cant_alumnos FROM clase WHERE id_clase = $clases";
    $resultado_ingreso = $conexion->query($sql_ingreso);
    $row_ingreso = $resultado_ingreso->fetch(PDO::FETCH_ASSOC);
    $cant_alumnos = $row_ingreso['cant_alumnos'];
    $cant_alumnos++;

    $sql_actualizar1 = "UPDATE clase SET cant_alumnos = :cant WHERE id_clase = $clases";
    $sql_actualizar3 = $conexion->prepare($sql_actualizar1);
    $sql_actualizar3->bindParam(':cant', $cant_alumnos);
    $sql_actualizar3->execute();

    echo '<script>window.location.href = "gestion-cliente.php?dni=' . urlencode($dni) . '";</script>';
    

}

?>

<div class="membresia-cliente">
        <table class="table-membresia">
            <thead>
                <div style="display:flex;">
                <p style="text-align: center;color: white;font-family: fantasy;margin-top:11px;">CLASE</p>
                <?php
                    $condicion = $resultado2->fetch(PDO::FETCH_ASSOC);
                    if (empty($condicion['id_clase'])) {
                    }else{echo '<form method="post">
                <input type="hidden" name="id_clase" value="' . $condicion['id_clase'] . '">
                <button type="submit" value="" name="act-clase" class="submit-img-act"></button>
                </form>';}
                ?>
                </div>
                <tr>
                    <th style="background-color: orangered;">
                    <?php 
                        $sql_clase_n = "SELECT clase.nombre_clase FROM clase INNER JOIN cliente ON cliente.clase_cliente = clase.id_clase WHERE cliente.dni = $dni";
                        $resultado_clase_n = $conexion->query($sql_clase_n);
                        $row_clase_n = $resultado_clase_n->fetch(PDO::FETCH_ASSOC); 
                        echo $row_clase_n['nombre_clase'];
                    ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <td>
                <div class="membresia-group">

                    <?php
                    
                    if (empty($condicion['id_clase'])) {
                        ?>
                    
                    <form method="post">
                       <select name="clases" style="margin-bottom: 15px;margin-left: 7px;" required>
                            <?php
                    $consulta3 = "SELECT clase.id_clase, clase.nombre_clase FROM clase WHERE clase.gym_clase = $cod_gym";
                    $resultado3 = $conexion->query($consulta3);

                    // Itera sobre los resultados
                    while ($fila = $resultado3->fetch(PDO::FETCH_ASSOC)) {
                        $id = $fila['id_clase'];
                        $nombre = $fila['nombre_clase'];
                        echo '<option value="' . $id . '">' . $nombre . '</option>';
                    }?>
                        </select>
                        <br>
                        <input type="submit" value="Agregar" name="clase" class="accion" style="margin-top: 10px;">
                    </form>
                    <?php  
                    }else{ $id_clase=$condicion['id_clase'];
                        $sql_caract = "SELECT * FROM clase WHERE id_clase = $id_clase";
                        $resultado_caract = $conexion->query($sql_caract);
                        $row_caract = $resultado_caract->fetch(PDO::FETCH_ASSOC);
                        echo '<ul style="font-size:0.89rem;">
                            <li><p> Descripción: ' . $row_caract['descripcion_clase'] . '</p></li>
                            <li><p> Duración: ' . $row_caract['duracion_clase'] . '</p></li>
                            <li><p> Instructor: ' . $row_caract['instructor_clase'] . '</p></li>
                    </ul>';
                     } ?>
                </div>
                </td>
            </tbody>
        </table>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['act-clase'])) {
    $id_clase2 = isset($_POST['id_clase']) ? $_POST['id_clase'] : null;
    $sql_actualizar5 = "UPDATE cliente SET clase_cliente = 0 WHERE dni = $dni AND gym_cliente = $cod_gym";
    $sql_actualizar4 = $conexion->prepare($sql_actualizar5);
    $sql_actualizar4->execute();

    $sql_ingreso = "SELECT cant_alumnos FROM clase WHERE id_clase = $id_clase2";
    $resultado_ingreso = $conexion->query($sql_ingreso);
    $row_ingreso = $resultado_ingreso->fetch(PDO::FETCH_ASSOC);
    $cant_alumnos = $row_ingreso['cant_alumnos'];
    $cant_alumnos--;

    $sql_actualizar6 = "UPDATE clase SET cant_alumnos = :cant WHERE id_clase = $id_clase2";
    $sql_actualizar7 = $conexion->prepare($sql_actualizar6);
    $sql_actualizar7->bindParam(':cant', $cant_alumnos);
    $sql_actualizar7->execute();

   echo '<script>window.location.href = "gestion-cliente.php?dni=' . urlencode($dni) . '";</script>';

}
?>