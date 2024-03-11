<?php
    $sql_acceso = "SELECT * FROM acceso WHERE cliente_acceso = $dni";
    $resultado_acceso = $conexion->query($sql_acceso);
    $row_acceso= $resultado_acceso->fetch(PDO::FETCH_ASSOC);

    if ($resultado_acceso->rowCount() > 0) {

        $sql_ingreso = "SELECT 
                    (SELECT fecha_acceso FROM acceso WHERE cliente_acceso = $dni ORDER BY id_acceso DESC LIMIT 1) AS ultimo_ingreso,
                    (SELECT fecha_acceso FROM acceso WHERE cliente_acceso = $dni ORDER BY id_acceso ASC LIMIT 1) AS primer_ingreso";

        $resultado_ingreso = $conexion->query($sql_ingreso);
        $row_ingreso = $resultado_ingreso->fetch(PDO::FETCH_ASSOC);

        $ultimo_ingreso = $row_ingreso['ultimo_ingreso'] ?? '--/--/-- --:--:--';
        $primer_ingreso = $row_ingreso['primer_ingreso'] ?? '--/--/-- --:--:--';

        echo '<div class="membresia-cliente">
        <table class="table-membresia">
            <thead>
                <div style="display:flex;">
                <p style="text-align: left;color: white;font-family: fantasy;margin-top:11px;">ACCESO</p>
                <form method="post" action="consulta-acceso.php">
                <input type="hidden" name="dni" value="' . $dni . '">
                <button type="submit" value="" name="dni-acceso" class="submit-img-ver"></button>
                </form>
                </div>
                
                <tr>
                    <th style="background-color: skyblue;">
                        Registro
                    </th>
                </tr>
            </thead>
            <tbody>
                <td>
                <div class="membresia-group" style="background-color:#0B4C5F;">
                    <ul>
                            <li><p>Primer Ingreso: ' . $primer_ingreso . '</p></li>
                            <li><p>Ultimo Ingreso: ' . $ultimo_ingreso . '</p></li>
                    </ul>
                </div>
                </td>
            </tbody>
        </table>
</div>';

    }else{ 
?>
<div class="membresia-cliente">
        <table class="table-membresia">
            <thead>
                <p style="text-align: center;color: white;font-family: fantasy;">ACCESO</p>
                <tr>
                    <th style="background-color: skyblue;">
                        Registro
                    </th>
                </tr>
            </thead>
            <tbody>
                <td>
                <div class="membresia-group">
                    <form action="acceso-cliente.php" method="post">
                       <!--<?php //echo '<input type="hidden" name="dni" value="' . $dni . '">'?>-->
                       <!--<p style="text-align: center;color: white;background-color: black;">AÑADIR</p>-->
                       <button type="submit" value="" name="acces" class="submit-img2"></button>
                    </form>
                </div>
                </td>
            </tbody>
        </table>
</div>
<?php
    }
?>
