<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Gimnasio</title>
  <link rel="stylesheet" href="registro.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <header class="header container">
      <div class="banner">
      
      </div>
    </header>

    <?php 
    session_start();
//  RECAPTCHA EN EL PHP //////////////////////////////////////////////////////////////////////
    $errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = "";
    if (isset($_POST['nombre'])) {
      $nombre = $_POST['nombre'];
  }
    $contrasena = "";
    if (isset($_POST['contrasena'])) {
      $contrasena = $_POST['contrasena'];
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
    $contrasena2 = "";
    if (isset($_POST['contrasena2'])) {
      $contrasena2 = $_POST['contrasena2'];
  }
      if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        // Ruta donde se guardará la imagen (ajusta según tu configuración)
        $carpeta_destino = "img-u/";

        // Nombre original del archivo
       $nombre_original = basename($_FILES["imagen"]["name"]);
       $nombre_unico = uniqid() . '_' . $nombre_original;
       $ruta_relativa = 'img-u/' . $nombre_unico;

        // Guardar la imagen con el nombre único en el servidor
        //move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta_destino . $nombre_unico);

        /*if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta_destino . $nombre_unico)) {
            
        } else {
            echo "Error al subir la imagen.";
        }*/
    } else {
        echo "No se recibió ninguna imagen.";
    }

    
    // Verificar reCAPTCHA solo si es una solicitud POST
    if (!isset($_POST['g-recaptcha-response'])) {
        // El campo no está presente, maneja el error
        $errors[] = "No se recibió la respuesta de reCAPTCHA.";
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $secretkey = "6LfvshApAAAAAMB-FIDXx-M3XEm-vZAdBsaJejX6";

        $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

        $atributos = json_decode($respuesta, TRUE);

        if (!$atributos['success']) {
            $errors[] = 'Verificar captcha';
        }
    }
  if ($contrasena2 != $contrasena) {
    $_SESSION['mensajes'] = "Las contraseñas no coinciden.";
  }else{
    if (empty($errors)) {
        //  base de datos
        include("config/bd.php");

        $consulta = "SELECT nombre_gym FROM gimnasio WHERE nombre_gym = :nombre_gym";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->bindParam(':nombre_gym', $nombre);
        $sentencia->execute();
        $resultado = $sentencia->fetch();

      if (!$resultado) {
          $sentenciaSQL = $conexion->prepare("INSERT INTO gimnasio (nombre_gym,contrasena_gym,email_gym,direccion_gym,imagen_gym,num_gym) VALUES (:nombre,:contrasena,:email,:direccion,:imagen,:num);");
          $sentenciaSQL->bindParam(':nombre', $nombre);
          $sentenciaSQL->bindParam(':contrasena', $contrasena);
          $sentenciaSQL->bindParam(':email', $email);
          $sentenciaSQL->bindParam(':direccion', $direccion);
          // Almacenar la ruta relativa en la base de datos
          $sentenciaSQL->bindParam(':imagen', $ruta_relativa);
          $sentenciaSQL->bindParam(':num', $numero);
        
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta_destino . $nombre_unico);


          $sentenciaSQL->execute();
          session_destroy();

          $cod_gym = $conexion->lastInsertId();
          

          header("Location: registro-admin2.php?id=" . urlencode($cod_gym));
          exit();
        } else{
          $_SESSION['mensajes'] = "El Nombre de gimnasio ya existe.";
        }
        
    } }/*else {
        // Si hay errores, imprímelos o manejalos de la manera que prefieras
        foreach ($errors as $error) {
            echo $error . '<br>';
        }*/

    

      /*if (!isset($_POST['g-recaptcha-response'])) {
    // El campo no está presente, maneja el error
    exit("No se recibió la respuesta de reCAPTCHA.");*/
}

    ?>







	<h2 class="titulo">Registro de Gimnasio</h2>
	<form class="form container" method="POST" enctype="multipart/form-data">
    <div class="div1">
  <div class="input-group">
    <h4>Nombre:</h4>
    <input type="text" name="nombre" pattern="^[^\s]+$" required>
    <p style="font-size: 0.8rem; ">*El nombre tiene que ser unico y sin espacios.</p>
  </div>
  <div class="input-group">
    <h4>Contraseña:</h4>
    <input type="password" minlength="8" name="contrasena" required>
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
    <h4>Imagen de perfil:</h4>
    <input type="file" name="imagen" required>
  </div>
</div>
<div class="div2">
  <div class="input-group">
    <h4>Número teléfono:</h4>
    <input type="number" name="numero" required>
  </div>
  <div class="input-group">
    <h4>Confirmar contraseña:</h4>
    <input type="password" name="contrasena2" minlength="8" required>
  </div>

  <div class="input-group" id="recaptcha">

    <div class="g-recaptcha" data-sitekey="6LfvshApAAAAABul-M_JuNpjXAUeQ1zjMU03CPme"></div> <br>

<?php foreach ($errors as $error) {
        echo '<br>' . '<p style="color: red;"> ¡'. $error .'!</p>' . '<br>';
      } ?>
<?php if (isset($_SESSION['mensajes'])) {
  echo $_SESSION['mensajes'];
}else {
  echo "*A través de la cuenta que usted está creando ahora, ingresará a la página. Luego de confirmar la creación de su cuenta, se lo enviará a el registro de administrador.";
} 
?>

  </div>

<input type="submit" value="Confirmar" class="confirm">

</div>
</form>

<!--<button class="next"><a href="#"> Siguiente</a></button>-->

</body>

</html>