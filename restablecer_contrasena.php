<?php
// restablecer_contrasena.php
session_start();
$cod_admin = $_SESSION['cod_admin'];
$id_solicitud = $_SESSION['id_solicitud'];
$admin = $_SESSION['admin'];

include("config/bd.php");

$consulta_admin = "SELECT gym_admin FROM administrador WHERE cod_admin = :cod_admin";
$sentencia_admin = $conexion->prepare($consulta_admin);
$sentencia_admin->bindParam(':cod_admin', $cod_admin);
$sentencia_admin->execute();
$cod_gym = $sentencia_admin->fetchColumn();
$_SESSION['cod_gym'] = $cod_gym;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style_gym.css">
  <title>Gym App</title>
</head>
<body>

<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contrasena = "";
          if (isset($_POST['contrasena'])) {
          $contrasena = $_POST['contrasena'];
        }
        $contrasena2 = "";
          if (isset($_POST['contrasena2'])) {
          $contrasena2 = $_POST['contrasena2'];
        }

        if ($contrasena == $contrasena2) {

            $consulta = "UPDATE gimnasio SET contrasena_gym = :contrasena WHERE gimnasio.cod_gym = :cod_gym";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->bindParam(':contrasena', $contrasena);
            $sentencia->bindParam(':cod_gym', $cod_gym);
            $sentencia->execute();

            $cambio = 1;
            $consulta2 = "UPDATE recuperar SET cambio_contrasena = :cambio WHERE recuperar.id_solicitud = :id_solicitud";
            $sentencia2 = $conexion->prepare($consulta2);
            $sentencia2->bindParam(':cambio', $cambio);
            $sentencia2->bindParam(':id_solicitud', $id_solicitud);
            $sentencia2->execute();
            //header("Location: gestion-admin.php?cod_admin=" . urlencode($cod_admin));

            $consulta_gym = "SELECT email_gym FROM gimnasio WHERE cod_gym = :cod_gym";
            $sentencia_gym = $conexion->prepare($consulta_gym);
            $sentencia_gym->bindParam(':cod_gym', $cod_gym);
            $sentencia_gym->execute();
            $email = $sentencia_gym->fetchColumn();

            $enlace = "https://localhost/sist_gym/index.php";

            $name = "Administrador";
            $asunto = "Cambio de Contraseña";
            $msg = "Hola,\n\nSe ha efectuado un cambio en tu contraseña, por parte del administrador:\n$admin\n\n$enlace";
    
            $header = "From: gym.app.20231512@gmail.com" . "\r\n";
            $header.= "Reply-to: gym.app.20231512@gmail.com" . "\r\n";
            $header.= "X-Mailer: PHP/".phpversion();

            mail($email,$asunto,$msg,$header);

            header("Location:gestion-admin.php");
            exit;
            
        }else{$_SESSION['mensages']="Las contraseñas no coinciden.";}


    }


?>










<h2 class="titulo">Restablecer Contraseña</h2>

<!-- Formulario de recuperación de contraseña -->
<form class="form-style" method="post">
  <!--<div class="input-style">
    <h4>Nombre de usuario administrador:</h4>
    <input type="text" name="admin" required>
  </div>-->
  
  <div class="input-style">
    <h4>Nueva contraseña:</h4>
    <input class="input-style" type="password" name="contrasena" required>
  </div>
  <div class="input-style">
    <h4>Confirmar contraseña:</h4>
    <input class="input-style" type="password" name="contrasena2" required>
  </div>
  <?php if (isset($_SESSION['mensages'])) {
        echo $_SESSION['mensages'];
        unset($_SESSION['mensages']);
        }?>
  <button type="submit">Enviar</button> <br>
  <button><a style="text-decoration: none; color: white;" href="gestion-admin.php">Omitir</a></button> 
</form>


</body>
</html>

