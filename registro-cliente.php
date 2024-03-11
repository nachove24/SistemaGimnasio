<?php include "template/header.php"; ?>
	
 <?php
require "template/redirigir.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$dni = "";
if (isset($_POST['dni'])) {
    $dni = $_POST['dni'];
}
$nombre = "";
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}
$apellido = "";
if (isset($_POST['apellido'])) {
    $apellido = $_POST['apellido'];
}
$email = "";
if (isset($_POST['correo'])) {
    $email = $_POST['correo'];
}
$nacimiento = "";
if (isset($_POST['nacimiento'])) {
    $nacimiento = $_POST['nacimiento'];
}
$direccion = "";
if (isset($_POST['direccion'])) {
    $direccion = $_POST['direccion'];
}
$genero = "";
if (isset($_POST['genero'])) {
    $genero = $_POST['genero'];
}
$telefono = "";
if (isset($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
}

include("config/bd.php");

$consulta = "SELECT dni FROM cliente WHERE dni = :dni";
$sentencia = $conexion->prepare($consulta);
$sentencia->bindParam(':dni', $dni);
$sentencia->execute();
$resultado = $sentencia->fetch();

if (!$resultado) {
    $sentenciaSQL = $conexion->prepare("INSERT INTO cliente (dni,nombre_c,apellido_c,email,genero,direccion,telefono,nacimiento,gym_cliente) VALUES (:dni,:nombre,:apellido,:email,:genero,:direccion,:telefono,:nacimiento,:cod_gym);");
    $sentenciaSQL->bindParam(':dni', $dni);
    $sentenciaSQL->bindParam(':nombre', $nombre);
    $sentenciaSQL->bindParam(':apellido', $apellido);
    $sentenciaSQL->bindParam(':email', $email);
    $sentenciaSQL->bindParam(':genero', $genero);
    $sentenciaSQL->bindParam(':direccion', $direccion);
    $sentenciaSQL->bindParam(':telefono', $telefono);
    $sentenciaSQL->bindParam(':nacimiento', $nacimiento);
    $sentenciaSQL->bindParam(':cod_gym', $cod_gym);

$sentenciaSQL->execute();
    $fecha = date("Y-m-d H:i:s");

    $sentencia = $conexion->prepare("INSERT INTO registro (cliente_registro,admin_registro,gym_registro,fecha_registro) VALUES (:dni,:cod_admin,:cod_gym,:fecha);");
    $sentencia->bindParam(':dni', $dni);
    $sentencia->bindParam(':cod_admin', $cod_admin);
    $sentencia->bindParam(':cod_gym', $cod_gym);
    $sentencia->bindParam(':fecha', $fecha);
$sentencia->execute();

    $_SESSION['mensaje'] = "    El formulario se ha enviado con éxito.";
    header("Location: registro-cliente.php");
    exit();
} else {
  $_SESSION['mensaje'] = "    El DNI ya existe.";
    // Añadimos una condición adicional para evitar redirecciones infinitas
    /*if (!isset($_SESSION['redireccion_evitada'])) {
        $_SESSION['redireccion_evitada'] = true;
        $_SESSION['mensaje'] = "El DNI ya existe.";
        header("Location: registro-cliente.php");
        exit();
    } else {
        // Limpiamos la variable de sesión para futuras solicitudes
        unset($_SESSION['redireccion_evitada']);
    }*/
}
}
?>




  

	<!--<header class="header container">
		<div class="banner">
			
		</div>
	</header>-->

    <?php
    // Mostrar mensajes almacenados en la sesión
    if (isset($_SESSION['mensaje'])) {
      echo '<div style="color:white;">';
      echo '<img style="width: 23.5px; height: 17.5px;" src="img/logo-advertencia.png" alt="Descripción de la imagen">';
      echo $_SESSION['mensaje'];
      unset($_SESSION['mensaje']);
      echo '</div>';

        //echo '<div style="color:white;">' . $_SESSION['mensaje'] . '</div>';
        // Limpiar el mensaje para que no se muestre en futuras solicitudes
        //unset($_SESSION['mensaje']);
    }?>
        <!--<div style="color:white;"> 

          <img style="width: 5px; height: 7px;" src="img/logo-advertencia">
          <?php //$_SESSION['mensaje'] ?>
            
        </div>-->
   

	<h2 class="titulo" style="color: #A9F5F2;">Registro de Cliente</h2>
<form class="form container" id="miFormulario" method="POST">
  <div class="div1">
  <div class="input-group">
    <h4>Nombre:</h4>
    <input type="text" id="nombre" name="nombre" maxlength="32" pattern="[A-Za-z -]+" required>
  </div>
  <div class="input-group">
    <h4>Apellido:</h4>
    <input type="text" id="apellido" name="apellido" maxlength="32" pattern="[A-Za-z -]+" required>
  </div>
  <div class="input-group">
    <h4>DNI:</h4>
    <input type="text" id="dni" name="dni"  maxlength="8" minlength="8" required>
  </div>
  <div class="input-group">
    <h4>Fecha de nacimiento:</h4>
    <input type="date" id="nacimiento" name="nacimiento" required>
  </div>
  <div class="input-group">
    <h4>Género:</h4>
      <select name="genero">
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>
      </select>
  </div>
</div>
  <div class="div2">
  <div class="input-group">
    <h4>Correo Electrónico:</h4>
    <input type="email" id="correo" name="correo" required>
  </div>
  <div class="input-group">
    <h4>Dirección:</h4>
    <input type="text" id="direccion" name="direccion" required>
  </div>
  <div class="input-group">
    <h4>Número Teléfono:</h4>
    <input type="number" id="telefono" name="telefono" pattern="[0-9]+" required>
  </div>
   <input type="submit" value="Confirmar" name="Confirmar" class="confirm">
</div>
</form>
<div  style=" width: 100%;
    text-align: center; padding-top: 10px;">
    <button  style="border-radius: 5px;
    background-color: blue;
    padding: 10px 20px;
    border: none;
    cursor: pointer;"><a href="lista-cliente.php" style="color: white; text-decoration: none;">Ver Lista de clientes</a></button>
</div>

<!--<script type="text/javascript">
        // Captura el evento de envío del formulario
        document.getElementById("miFormulario").addEventListener("submit", function(event) {
            event.preventDefault(); // Evita que la página se recargue al enviar

            // Obtén los valores de los campos de entrada
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var dni = document.getElementById("dni").value;
            var apellido = document.getElementById("apellido").value;
         
            var mensaje = "Ha cargado con éxito. Usuario: ("+dni+")";

            alert(mensaje);

            // Limpia los campos del formulario
            document.getElementById("nombre").value = "";
            document.getElementById("dni").value = "";
            document.getElementById("correo").value = "";
            document.getElementById("apellido").value = "";
        });
</script>-->


</body>
</html>