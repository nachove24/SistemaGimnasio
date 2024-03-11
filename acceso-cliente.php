<?php include "template/header.php"; ?>
<?php
    require "template/redirigir.php";
    include "config/bd.php";
?>
<?php
    
?>

	<div id="contest-form" class="contest-form">
		<form class="form-acces" id="miFormulario" action="acceso-cliente.php" method="post" autocomplete="off">
			<h2 class="h2">Acceso Gym</h2>
			<br>
			<h4 style="color:white;">Ingrese su número de documento:</h4>
			<input id="num-input" type="number" name="dni" class="ingreso" style="margin-left: 5px;" required>
			<input id="botonEnviar" type="submit" name="aceptar" value="Aceptar" class="accion" style="background-color: #5882FA;">
            <a href="historial-acceso.php" style="text-decoration: underline;color: #00FFFF;margin-left: 5px;">Historial</a>
		</form>

        <form method="post">
            <input  type="hidden" name="none" value="none" class="">
            <input  type="submit" name="quitar" value="Volver" class="accion" style="background-color: #FE9A2E;margin-top: 10px;">
        </form>
        <?php
            if (isset($_SESSION['msj_acceso'])) {
                echo '<div style="color:white;">';
                echo '<img style="width: 23.5px; height: 17.5px; margin: 0 auto;" src="img/logo-advertencia.png" alt="Descripción de la imagen">';
                echo $_SESSION['msj_acceso'];
                unset($_SESSION['msj_acceso']);
                echo '</div>';
        }?>
	</div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quitar'])) {
            header('Location:acceso-cliente.php');
            exit();
        }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['aceptar'])) {
    $dni = "";
    if (isset($_POST['dni'])) {
        $dni = $_POST['dni'];
    }
    
      

    $consulta = "SELECT COUNT(*) as total FROM cliente WHERE dni = :dni";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->bindParam(':dni', $dni, PDO::PARAM_STR);
    $sentencia->execute();

    // Obtiene el resultado
    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
    $total = $resultado['total'];

    // Verifica el resultado
    if ($total > 0) {
        // El DNI ya existe en la base de datos
        $sql_cliente = "SELECT * FROM cliente WHERE dni = $dni";
    $resultado_cliente = $conexion->query($sql_cliente);
    $row_cliente = $resultado_cliente->fetch(PDO::FETCH_ASSOC);
    $nombre_cliente = $row_cliente['nombre_c'];            
    $apellido_cliente = $row_cliente['apellido_c'];
    
        $sql_ingreso = "SELECT fecha_acceso FROM acceso WHERE cliente_acceso = $dni ORDER BY id_acceso DESC LIMIT 1";
        $resultado_ingreso = $conexion->query($sql_ingreso);
        $row_ingreso = $resultado_ingreso->fetch(PDO::FETCH_ASSOC);  
        if ($row_ingreso) {
            // Hay un registro de acceso, muestra la última fecha
            $ultimo_ingreso = $row_ingreso['fecha_acceso'];
        } else {
                // No hay registros de acceso, muestra un guion (-)
            $ultimo_ingreso = '--/--/-- --:--:--';
        }

         $fecha = date("Y-m-d H:i:s");

        $consulta = "SELECT * FROM gimnasio WHERE cod_gym = $cod_gym";
        $resultado = $conexion->query($consulta);
        $row = $resultado->fetch(PDO::FETCH_ASSOC);
        $direccion = $row['direccion_gym'];

        $sentenciaSQL = $conexion->prepare("INSERT INTO acceso (cliente_acceso,fecha_acceso,ubicacion_acceso,admin_acceso) VALUES (:dni,:fecha,:ubicacion,:admin);");
        $sentenciaSQL->bindParam(':dni', $dni);
        $sentenciaSQL->bindParam(':fecha', $fecha);
        $sentenciaSQL->bindParam(':ubicacion', $direccion);
        $sentenciaSQL->bindParam(':admin', $cod_admin);
        $sentenciaSQL->execute();

         $sql_membresia = "SELECT * FROM estado_membresia WHERE cliente_estado = $dni";
        $resultado_membresia = $conexion->query($sql_membresia);
        $row_membresia = $resultado_membresia->fetch(PDO::FETCH_ASSOC);

        if ($row_membresia) {
            // El registro existe, puedes acceder a los valores
            $membresia_estado = $row_membresia['membresia_estado'];
            $id_nombre = $row_membresia['nombre_estado'];
            $id_estado = $row_membresia['id_estado'];
            $fecha_baja = $row_membresia['fecha_baja'];

            $fecha_actual = date("Y-m-d");

            if ($fecha_actual > $fecha_baja) {
            $id_nombre = 1;
            }

            $sql_nombre = "SELECT * FROM membresia WHERE id_membresia = $membresia_estado";
            $resultado_nombre = $conexion->query($sql_nombre);
            $row_nombre = $resultado_nombre->fetch(PDO::FETCH_ASSOC);
            $nombre_membresia = $row_nombre['nombre_membresia'];
            $fondo_membresia = $row_nombre['color_membresia'];

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
            default :
                $color_estado = "gray";
            break;     
            }

            

            
            
                    
        echo '<div class="contest-form">
    <div id="card-acces" class="card-acces" style="display:flex;background-color:' . $color_estado . ';">
        <img src="img/logo-perfil.png" alt="" style="width: 100px; height: 60px; padding: 5px;">
        <h2 class="title">' . $nombre_cliente . " " . $apellido_cliente .'</h2>
        <div class="info">
            <h3>Membresía' . " " . $nombre_estado . '</h3>
            <p>Vencimiento: ' . $fecha_baja . '</p>
            <h3>Último ingreso: ' . $ultimo_ingreso . '</h3>
        </div>
    </div>
</div>';


        } else {
            // El registro no existe, puedes manejar este caso según tus necesidades
            echo '<div class="contest-form">
    <div id="card-acces" class="card-acces" style="display:flex;background-color:gray;">
        <img src="img/logo-perfil.png" alt="" style="width: 100px; height: 60px; padding: 5px;">
        <h2 class="title">' . $nombre_cliente . " " . $apellido_cliente .'</h2>
        <div class="info">
            <h3>NO TIENE MEMBRESIA</h3>
            <p>No se ha iniciado una membresia</p>
            <h3>Último ingreso: ' . $ultimo_ingreso . '</h3>
        </div>
    </div>
</div>';
        }


        

    } else {
        // El DNI no existe en la base de datos, puedes continuar con tu lógica
        $_SESSION['msj_acceso'] = "  El DNI no existe.";
    }
        }



        ?>
		<br>
        
	<!--<div class="contest-form">
    <div id="card-acces" class="card-acces">
        <img src="img/logo-perfil.png" alt="" style="width: 100px; height: 60px; padding: 5px;">
        <h2 class="title">Pedro Perez</h2>
        <div class="info">
            <h3>Membresía caducada</h3>
            <p>Vencimiento: 02/08/2023</p>
            <h3>Último ingreso: 03/08/2023</h3>
        </div>
    </div>
</div>-->

</body>
<!--<script type="text/javascript">

	const contestForm = document.getElementById("contest-form");
contestForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Evita el envío predeterminado del formulario

    var numInput = document.getElementById("num-input");
    var num = parseInt(numInput.value); // Convierte el valor del campo en un número entero

    showCard(num);
});

// Agregar un evento de escucha para las teclas
document.addEventListener("keydown", function(event) {
    // Obtener la referencia al elemento card-acces
    var cardAcces = document.getElementById("card-acces");

    // Comprobar si card-acces está en display: flex
    if (cardAcces.style.display === "flex") {
        // Refrescar la página
        location.reload();
    }
});


function showCard(num) {
    var cardAcces = document.getElementById("card-acces");
    if (cardAcces.style.display === "none") {
        cardAcces.style.display = "flex";
        //cardAcces.style.backgroundColor = num === 1 ? "red" : "green";
    } else {
        cardAcces.style.display = "none";
    }
}

</script>-->
</html>