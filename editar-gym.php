<?php
  require "template/redirigir.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gym App</title>
  <link rel="stylesheet" href="registro.css">
 
</head>
<body>
    

    <?php 
    include "template/header.php";
//  RECAPTCHA EN EL PHP //////////////////////////////////////////////////////////////////////
    $errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['confirm'])) {

    $nombre = "";
    if (isset($_POST['nombre'])) {
      $nombre = $_POST['nombre'];
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
   

    if (empty($errors)) {
        //  base de datos
        include("config/bd.php");

        $consulta = "SELECT nombre_gym FROM gimnasio WHERE nombre_gym = :nombre_gym";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->bindParam(':nombre_gym', $nombre);
        $sentencia->execute();
        $resultado = $sentencia->fetch();

      if (!$resultado) {
         $sentenciaSQL = $conexion->prepare("UPDATE gimnasio SET nombre_gym = :nombre, email_gym = :email, direccion_gym = :direccion, num_gym = :num WHERE cod_gym = :id_gym;");
        $sentenciaSQL->bindParam(':nombre', $nombre);
        $sentenciaSQL->bindParam(':email', $email);
        $sentenciaSQL->bindParam(':direccion', $direccion);
        $sentenciaSQL->bindParam(':num', $numero);
        $sentenciaSQL->bindParam(':id_gym', $cod_gym); // Ajusta el id_gym según tu caso
        $sentenciaSQL->execute();


          header("Location: gestion-gym.php");
          exit();
        } else{
          $_SESSION['mensajes'] = "El Nombre de gimnasio ya existe.";
        }
        
    } }
    ?>







  <h2 class="titulo">Editar info. de la cuenta</h2>
  <form class="form container" method="POST" enctype="multipart/form-data" style="width: 50%;">
    <div class="div1" style="width: 100%;">
  <div class="input-group">
    <h4>Nombre:</h4>
    <input type="text" name="nombre" pattern="^[^\s]+$" required>
    <p style="font-size: 0.8rem; ">*El nombre tiene que ser unico y sin espacios.</p>
  </div>
  
  <div class="input-group">
    <h4>Correo electrónico:</h4>
    <input type="email" name="correo" required>
  </div>
  <div class="input-group">
    <h4>Dirección del establecimiento:</h4>
    <input type="text" name="direccion" required>
  </div>

  <div class="input-group">
    <h4>Número teléfono:</h4>
    <input type="number" name="numero" required>
  </div>
 
<div style="">
  <?php foreach ($errors as $error) {
        echo '<br>' . '<p style="color: red;"> ¡'. $error .'!</p>' . '<br>';
      } ?>
<?php if (isset($_SESSION['mensajes'])) {
  echo $_SESSION['mensajes'];
  unset($_SESSION['mensajes']);
}else {
  echo "*Una vez confirmado será enviado a la página anterior.";
} 
?>
<br>
<input type="submit" value="Confirmar" name="confirm" class="confirm">
</div>
</div>
</form>

<!--<button class="next"><a href="#"> Siguiente</a></button>-->

</body>

</html>