<?php

require "template/redirigir.php";

include("config/bd.php");
//NOMBRE DEL GIMNASIO///////////////
$consulta = "SELECT nombre_gym FROM gimnasio WHERE cod_gym = $cod_gym";
	$sql = $consulta;
	$resultado = $conexion->query($sql);
//INFO GYM///////////////////////////////////
$sql_gym = "SELECT * FROM gimnasio WHERE cod_gym = $cod_gym";
$resultado_gym = $conexion->query($sql_gym);
$row_gym = $resultado_gym->fetch(PDO::FETCH_ASSOC);
$image = $row_gym['imagen_gym'];
//NOMBRE ADMIN////////////////////////////
$consulta_admin = "SELECT nombre_u FROM administrador WHERE cod_admin = $cod_admin";
    $sql_admin = $consulta_admin;
    $resultado_admin = $conexion->query($sql_admin);
//CLIENTES////////////////////////////////
 $sql_cantidad = "SELECT COUNT(*) as total_clientes FROM cliente WHERE gym_cliente = $cod_gym";

    // Preparar la consulta
    $stmt_cantidad = $conexion->prepare($sql_cantidad);

    // Ejecutar la consulta
    $stmt_cantidad->execute();

    // Obtener el resultado como un array asociativo
    $resultado_cantidad = $stmt_cantidad->fetch(PDO::FETCH_ASSOC);

    // Guardar el resultado en una variable
    $totalClientes = $resultado_cantidad['total_clientes'];
//MEMBRESIA///////////////////////////////
    $sql_membresia = "SELECT estado_membresia.nombre_estado, SUM(estado_membresia.precio_estado) AS ganancias_totales 
    FROM estado_membresia 
    INNER JOIN cliente ON cliente.dni = estado_membresia.cliente_estado 
    INNER JOIN gimnasio ON gimnasio.cod_gym = cliente.gym_cliente 
    WHERE gimnasio.cod_gym = :cod_gym AND estado_membresia.nombre_estado = 2";

    $stmt_membresia = $conexion->prepare($sql_membresia);

    // Bind de parámetros
    $stmt_membresia->bindParam(':cod_gym', $cod_gym, PDO::PARAM_INT);

    // Ejecutar la consulta
    $stmt_membresia->execute();

    // Obtener el resultado
    $resultado_membresia = $stmt_membresia->fetch(PDO::FETCH_ASSOC);

    if ($resultado_membresia && isset($resultado_membresia['ganancias_totales'])) {
    $ganancias_totales = $resultado_membresia['ganancias_totales'];
    }else{
        $ganancias_totales = 0;
    }


?>


<?php include "template/header.php"; ?>
<?php 
    if (isset($_SESSION['mensaje'])) {
      echo '<div style="color:white;">';
      echo '<img style="width: 23.5px; height: 17.5px;" src="img/logo-advertencia.png" alt="Descripción de la imagen">';
      echo $_SESSION['mensaje'];
      unset($_SESSION['mensaje']);
      echo '</div>'; }
?>
    <div>
        <h1 class="titulo">Mi Cuenta</h1>
    </div>

    <div class="user-container container">
        <div class="user-details">
            
            <?php
            echo '<img src="' . $image . '" alt="Imagen de Usuario" width="100" style="border-radius:50%;height:100px;">';
				while ($fila = $resultado->fetch()) {
   				$nombre = $fila['nombre_gym'];
    			echo "<h2 style='color: #2EFEF7;margin-left:14px;'>" . $nombre . "</h2>";
				}
			?>
        </div>
        <div class="datos-cliente">
            <div class="datos-group">
                <h4>Total de Clientes</h4>
            <?php echo "<h3 style='color: skyblue;'>" . $totalClientes . "</h3>";?>
            </div>
            <div class="datos-group">
                <h4>Proyección total de ganancias</h4>
            <?php echo "<h3 style='color: skyblue;'>" . "$" . $ganancias_totales  . "</h3>";?>
            </div>
        </div>
        <div class="options">
            
            <a href="cerrar-sesion.php" style="text-decoration: underline;color: #00FFFF;">Cerrar Sesión</a>
            <?php
                while ($fila2 = $resultado_admin->fetch()) { 
                echo "<p style='color: white;'>" . "Administrador en linea: " . $fila2['nombre_u'] . " #" . $cod_admin . "</p>";
            }
            ?>

        </div>
    </div>
    <div class="contenedor-tablas" style="display: flex;width: 1300px;margin: 0 auto;">
    <div style="width: 46%;">
    <?php
    echo "<div style='display:flex;'>";
    echo '<form action="agregar-admin.php" method="POST" style="">
            <input type="submit" name="agregar" value="Agregar" style="margin-left:5px;"></input>
        </form>';
    echo "<h4 style='color:skyblue;margin:0 auto;'>Administradores</h4>";
    echo "</div>";
    ///TABLA ADMIN//////////////////////////////////////////////
    $sql2 = "SELECT * FROM administrador WHERE gym_admin = $cod_gym";
    $resultado2 = $conexion->query($sql2);


    // Verifica si hay resultados
    if ($resultado2->rowCount() > 0) {
    echo '<table class="table user-info" style="margin-left:5px;font-size:0.67rem;width="100%;height: 250px;">';
    echo '<tr>
            <th>ID</th>
            <th>DNI</th>
            
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Acción</th>
        </tr>';

// Itera a través de los resultados y muestra cada fila

while ($fila = $resultado2->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $fila['cod_admin'] . '</td>';
    echo '<td>' . $fila['dni_admin'] . '</td>';
    
    echo '<td>' . $fila['nombre_admin'] . '</td>';
    echo '<td>' . $fila['apellido_admin'] . '</td>';
    echo '<td>' . $fila['email_admin'] . '</td>';
    echo '<td>' . $fila['direccion_admin'] . '</td>';
    echo '<td>' . $fila['num_admin'] . '</td>';
    echo "<td>";
    if($fila["cod_admin"]!=$cod_admin){
    echo "<form method='post'>"; 
    echo "<input type='hidden' name='id_admin' value='" . $fila["cod_admin"] . "'>";
    echo "<button type='submit' name='borrar' value='borrar' class='accion' style='background-color:red;'>Borrar</button>";
    echo "</form>";
    }
    echo "</td>";
    echo '</tr>';
}
echo '</table>';
    } else {
        // Mostrar un mensaje si no hay resultados
        echo '<p>No se encontraron resultados.</p>';
    }
?>
</div>
<div style="width: 40%;">
    <?php
        $sql_gimnasio = "SELECT * FROM gimnasio WHERE cod_gym = $cod_gym";
        $resultado_gimnasio = $conexion->query($sql_gimnasio);
        echo "<div style='display:flex;'>";
    echo '<form action="editar-gym.php" method="POST" style="">
            <input type="submit" name="editar" value="Editar" style="margin-left:120px;"></input>
        </form>';
    echo "<h4 style='color:#F7819F;margin:0 auto;'>Datos del Gym</h4>";
    echo "</div>";
        echo '<table class="table user-info" style="font-size:0.67rem;margin-left:120px;margin-top:;">';

        // Itera a través de los resultados y muestra cada propiedad en una fila vertical
        while ($fila2 = $resultado_gimnasio->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<th>Nombre de Gym</th><td>' . $fila2['nombre_gym'] . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<th>Contraseña de Gym</th><td><a href="recuperar-contrasena.php" style="color:#F7819F;text-decoration:underline;">Recuperar Contraseña</a></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<th>Email de Gym</th><td>' . $fila2['email_gym'] . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<th>Dirección de Gym</th><td>' . $fila2['direccion_gym'] . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<th>Imagen de Gym</th><td><a href="cambiar-imagen.php" style="color:#F7819F;text-decoration:underline;">Cambiar Imagen</a></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<th>Número de Gym</th><td>' . $fila2['num_gym'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';

    ?>
</div>
</div>
<?php
    $borrar= (isset($_POST['borrar'])) ? $_POST['borrar'] : "";
    if ($borrar=="borrar"){
        $id_admin = (isset($_POST['id_admin'])) ? $_POST['id_admin'] : "";
        try{
        $sql_eliminar = "DELETE FROM administrador WHERE cod_admin = :id_admin";
        $consulta_eliminar = $conexion->prepare($sql_eliminar);
        $consulta_eliminar->bindParam(':id_admin', $id_admin, PDO::PARAM_INT);
        $consulta_eliminar->execute();
        //header("Location: gestion-gym.php");
        echo '<script>window.location.href = "gestion-gym.php";</script>';
        exit();
    }catch (PDOException $e) {
        // Error al eliminar debido a restricción de clave externa
        $_SESSION['mensaje'] = "No se puede eliminar el administrador ya que está siendo utilizado en otras partes del sistema.";
        echo '<script>window.location.href = "gestion-gym.php";</script>';
        exit();
    }}
    include "template/pie.php";
?>
</body>
</html>
