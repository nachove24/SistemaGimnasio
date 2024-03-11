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
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $fecha = date("Y-m-d H:i:s");

  $admin = "";
          if (isset($_POST['admin'])) {
          $admin = $_POST['admin'];
        }
        $_SESSION['admin'] = $admin;
  $dni = "";
          if (isset($_POST['dni'])) {
          $dni = $_POST['dni'];
        }

  include("config/bd.php");

        $consulta = "SELECT nombre_u,dni_admin FROM administrador WHERE nombre_u = :nombre_u AND dni_admin = :dni";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->bindParam(':nombre_u', $admin);
        $sentencia->bindParam(':dni', $dni);
        $sentencia->execute();
        $resultado = $sentencia->fetch();

  if ($resultado) {
    $consulta_admin = "SELECT email_admin FROM administrador WHERE nombre_u = :nombre_u";
    $sentencia_admin = $conexion->prepare($consulta_admin);
    $sentencia_admin->bindParam(':nombre_u', $admin);
    $sentencia_admin->execute();
    $email = $sentencia_admin->fetchColumn();

    $consulta_admin2 = "SELECT cod_admin FROM administrador WHERE nombre_u = :nombre_u";
    $sentencia_admin2 = $conexion->prepare($consulta_admin2);
    $sentencia_admin2->bindParam(':nombre_u', $admin);
    $sentencia_admin2->execute();
    $cod_admin = $sentencia_admin2->fetchColumn();
    $_SESSION['cod_admin'] = $cod_admin;


    /*$email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($email === false) {
    // La dirección de correo electrónico no es válida
    // Manejar el error o mostrar un mensaje al usuario
    $_SESSION['mensage'] = "Su correo electrónico no es valido.";
}else{*/

     
    $enlace = "https://localhost/sist_gym/restablecer_contrasena.php";

    $name = "Administrador";
    $asunto = "Recuperar Contraseña";
    $msg = "Hola,\n\nPara restablecer tu contraseña, haz clic en el siguiente enlace:\n$enlace";
    
    $header = "From: gym.app.20231512@gmail.com" . "\r\n";
    $header.= "Reply-to: gym.app.20231512@gmail.com" . "\r\n";
    $header.= "X-Mailer: PHP/".phpversion();

    mail($email,$asunto,$msg,$header);
    
    $_SESSION['mensage'] = "Ya se ha enviado el mensaje.";
//TABLA RECUPERAR.................................................................................
    $cambio = 0;
    $sentenciaSQL = $conexion->prepare("INSERT INTO recuperar (fecha_solicitud,cambio_contrasena,admin_solicitud) VALUES (:fecha,:cambio,:admin);");
          $sentenciaSQL->bindParam(':fecha', $fecha);
          $sentenciaSQL->bindParam(':cambio', $cambio);
          $sentenciaSQL->bindParam(':admin', $cod_admin);
          $sentenciaSQL->execute();
          $id_solicitud = $conexion->lastInsertId();
          $_SESSION['id_solicitud'] = $id_solicitud;
  }else{$_SESSION['mensage'] = "El nombre o dni son erroneos.";}
}
?>








<h2 class="titulo">Recuperar Contraseña</h2>

<!-- Formulario de recuperación de contraseña -->
<form class="form-style" method="post">
  <div class="input-style">
    <h4>Nombre de usuario administrador:</h4>
    <input type="text" name="admin" required>
  </div>
  
  <div class="input-style">
    <h4>DNI de administrador:</h4>
    <input class="input-style" type="number" name="dni" required>
  </div>
  <?php if (isset($_SESSION['mensage'])) {
        echo $_SESSION['mensage'];
        unset($_SESSION['mensage']);
        }?>
  <button type="submit">Enviar</button> <br>
  <p>*Ingrese los datos y presione enviar. Luego de esto le llegara un mensaje al mail de administrador para recuperar la contraseña de la cuenta de la empresa.</p>
</form>





</body>
</html>