<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gym App</title>
  <link rel="stylesheet" href="registro.css">
</head>
<body>
    <header class="header container">
      <div class="banner">
      
      </div>
    </header>
<?php
// Recupera el valor de la variable de consulta
require "template/redirigir.php";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$dni = "";
    if (isset($_POST['dni'])) {
      $dni = $_POST['dni'];
  }
    $nombre = "";
    if (isset($_POST['nombre'])) {
      $nombre = $_POST['nombre'];
  }
    $nombre2 = "";
    if (isset($_POST['nombre2'])) {
      $nombre2 = $_POST['nombre2'];
  }
    $email = "";
    if (isset($_POST['correo'])) {
      $email = $_POST['correo'];
  }
    $numero = "";
    if (isset($_POST['numero'])) {
      $numero = $_POST['numero'];
  }
    $direccion = "";
    if (isset($_POST['direccion'])) {
      $direccion = $_POST['direccion'];
  }
    $apellido = "";
    if (isset($_POST['apellido'])) {
      $apellido = $_POST['apellido'];
  }



    //BASE DE DATOSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
    if (empty($errors)) {
        //  base de datos
        include("config/bd.php");

        $consulta = "SELECT nombre_u,dni_admin FROM administrador WHERE nombre_u = :nombre_u OR dni_admin = :dni";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->bindParam(':nombre_u', $nombre);
        $sentencia->bindParam(':dni', $dni);
        $sentencia->execute();
        $resultado = $sentencia->fetch();

      if (!$resultado) {
          $sentenciaSQL = $conexion->prepare("INSERT INTO administrador (nombre_u,nombre_admin,apellido_admin,email_admin,direccion_admin,num_admin,gym_admin,dni_admin) VALUES (:nombre_u,:nombre2,:apellido,:email,:direccion,:num,:gym_admin,:dni);");
          $sentenciaSQL->bindParam(':nombre_u', $nombre);
          $sentenciaSQL->bindParam(':nombre2', $nombre2);
          $sentenciaSQL->bindParam(':apellido', $apellido);
          $sentenciaSQL->bindParam(':email', $email);
          $sentenciaSQL->bindParam(':direccion', $direccion);
          $sentenciaSQL->bindParam(':num', $numero);
          $sentenciaSQL->bindParam(':gym_admin', $cod_gym);
          $sentenciaSQL->bindParam(':dni', $dni);
        


          $sentenciaSQL->execute();
          

          header("Location:gestion-gym.php");
          

          
         
        } else{
          $_SESSION['mensajes'] = "El Nombre o DNI ya existe.";
        }
        
    } }






?>



<h2 class="titulo">Registro de Administrador</h2>
	<form class="form container" method="POST" enctype="multipart/form-data">
    <div class="div1">
  <div class="input-group">
    <h4>Nombre Usuario:</h4>
    <input type="text" name="nombre" pattern="^[^\s]+$" required>
    <p style="font-size: 0.8rem; ">*El nombre tiene que ser unico y sin espacios.</p>
  </div>
  <div class="input-group">
    <h4>Nombre:</h4>
    <input type="text" name="nombre2" required>
  </div>
  <div class="input-group">
    <h4>Apellido:</h4>
    <input type="text" name="apellido" required>
  </div>
  <div class="input-group">
    <h4>Correo electrónico:</h4>
    <input type="email" name="correo" required>
  </div>
  <div class="input-group">
    <h4>DNI:</h4>
    <input type="number" name="dni" required>
  </div>
</div>

<div class="div2">
  <div class="input-group">
    <h4>Número teléfono:</h4>
    <input type="number" name="numero" required>
  </div>
  <div class="input-group">
    <h4>Dirección del Administrador:</h4>
    <input type="text" name="direccion" required>
  </div>
  


<input type="submit" value="Confirmar" class="confirm">

</div>
</form>

<!--<button class="next"><a href="#"> Siguiente</a></button>-->

</body>

</html>