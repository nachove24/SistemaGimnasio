<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gym App</title>
	<link rel="stylesheet" href="style_gym.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
	<header class="header">
		<div class="menu container">
			<div class="banner">
				
			</div>
			<nav class="navbar">
				<nav class="bar-1">
		        	<a href="#" class="logo" style="color: #F8E0F1;">Gym App</a>
		        	<input type="checkbox" id="menu">
		    		<ul>
		    			<li><a href="registro-admin.php">Registrarse</a></li>
		    		</ul>
		    	</nav>
		    </nav>
	    </div>
    </header>

    <?php
    session_start();
    $errors = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

          $gimnasio = "";
          if (isset($_POST['gimnasio'])) {
          $gimnasio = $_POST['gimnasio'];
        }

        $admin = "";
          if (isset($_POST['admin'])) {
          $admin = $_POST['admin'];
        }

        $contrasena = "";
          if (isset($_POST['contrasena'])) {
          $contrasena = $_POST['contrasena'];
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

      if (empty($errors)) {
        //  base de datos
        include("config/bd.php");

        $consulta = "SELECT nombre_u,nombre_gym FROM gimnasio INNER JOIN administrador ON administrador.gym_admin = gimnasio.cod_gym WHERE nombre_u = :nombre_u AND nombre_gym = :nombre_gym";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->bindParam(':nombre_u', $admin);
        $sentencia->bindParam(':nombre_gym', $gimnasio);
        $sentencia->execute();
        $resultado = $sentencia->fetch();

        if ($resultado) {
          $consulta2 = "SELECT contrasena_gym FROM gimnasio WHERE contrasena_gym = :contrasena";
          $sentencia2 = $conexion->prepare($consulta2);
          $sentencia2->bindParam(':contrasena', $contrasena);
          $sentencia2->execute();
          $resultado2 = $sentencia2->fetch();
          if ($resultado2) {
            $consulta_admin = "SELECT cod_admin FROM administrador WHERE nombre_u = :nombre_u";
            $sentencia_admin = $conexion->prepare($consulta_admin);
            $sentencia_admin->bindParam(':nombre_u', $admin);
            $sentencia_admin->execute();
            $cod_admin = $sentencia_admin->fetchColumn();
            $_SESSION['cod_admin'] = $cod_admin;

            $consulta_gym = "SELECT cod_gym FROM gimnasio WHERE nombre_gym = :nombre_gym";
            $sentencia_gym = $conexion->prepare($consulta_gym);
            $sentencia_gym->bindParam(':nombre_gym', $gimnasio);
            $sentencia_gym->execute();
            $cod_gym = $sentencia_gym->fetchColumn();
            $_SESSION['cod_gym'] = $cod_gym;

            header("Location: gestion-admin.php");

          }else {
            $_SESSION['alerta'] = "Contraseña incorrecta.";
          }

        }else {

          $_SESSION['alerta'] = "Los datos del gimnasio o el nombre de administrador son erroneos.";
        }
    }
}
        
    ?>

    <div class="gestion container">
    <!--<div class="form admin">
    	<label class="form-1" id="admin">
    		<h2>Gestión Administrador</h2>
    		<h3>Usuario:</h3>
    		<input type="textarea" name="usuario_admin">
    		<h3>Contraseña:</h3>
    		<input type="textarea" name="contrasena_admin">
    	<ul>
    		<li><a href="#" onclick="showCard()">Recuperar Contraseña</a></li>
    		<li><a href="#">Registrar Gimnasio</a></li>
    	</ul>
    	</label>
    </div>-->
    <form class="form usuario" method="POST" style="text-align: center;">
    	<label class="form-1" id="usuario">
    		<h2>Inicio de sesión</h2>
    		<h3>Gimnasio:</h3>
    		<input type="text" name="gimnasio" required>
        <h3>Usuario Administrador:</h3>
        <input type="text" name="admin" required>
    		<h3>Contraseña:</h3>
    		<input type="password" name="contrasena" required><br>
        <div class="input-group" id="recaptcha">
    <div class="g-recaptcha" data-sitekey="6LfvshApAAAAABul-M_JuNpjXAUeQ1zjMU03CPme"></div> 
      <?php foreach ($errors as $error) {
        echo '<p style="color: red;"> ¡'. $error .'!</p>' ;//. '<br>';
      } ?>
    </div>
        <input type="submit" name="Entrar" style="width: 105px; background-color: #21979e; color: white; cursor: pointer;">
        <?php if (isset($_SESSION['alerta'])) {
        echo $_SESSION['alerta'];
        unset($_SESSION['alerta']);
        }
?>
    	<ul>
    		<!--<li><a href="#" onclick="showCard2()">Recuperar Contraseña</a></li>-->
        <li><a href="recuperar-contrasena.php">Recuperar Contraseña</a></li>
    	</ul>
    	</label>
    </form>
    <div class="container2">
    <div class="box b-1">
        <h2>Gestionar Clientes</h2>
        <p>Aquí podrás agregar, editar y eliminar información de tus clientes.</p>
    </div>

    <div class="box b-2">
        <h2>Gestionar Membresías</h2>
        <p>Administra y gestiona a los tipos de servicios que ofreces en tu gimnasio.</p>
    </div>

    <div class="box b-3">
        <h2>Gestionar Clases</h2>
        <p>Planifica y crea las clases de entrenamiento que se brindarán.</p>
    </div>

    <div class="box b-4">
        <h2>Reportes y Estadísticas</h2>
        <p>Consulta informes y estadísticas del desempeño del gimnasio.</p>
    </div>
</div>
    </div>


  <div class="card-container" id="card-container">
    <div class="card">
      <h3>Recuperar Contraseña</h3>
      <label for="nombre_admin">Nombre de Administrador:</label>
      <input type="text" id="nombre_admin" name="nombre_admin">
    </div>
  </div>

  <div class="card-container" id="card-container-2">
    <div class="card">
      <h3>Recuperar Contraseña</h3>
      <label for="nombre_usuario">Nombre de Usuario:</label>
      <input type="text" id="nombre_usuario" name="nombre_usuario">
      <h4>*Si es su primera vez ingresando como usuario, debe ingresar su id<br> (num. de identificación) como contraseña. Luego deberá cambiarla.</h4>
    </div>
  </div>

  <script>
    // Función para mostrar/ocultar la tarjeta de registro
    function showCard() {
      var cardContainer = document.getElementById("card-container");
      if (cardContainer.style.display === "none") {
        cardContainer.style.display = "flex";
      } else {
        cardContainer.style.display = "none";
      }
    }

    function showCard2() {
      var cardContainer2 = document.getElementById("card-container-2");
      if (cardContainer2.style.display === "none") {
        cardContainer2.style.display = "flex";
        // Seleccionar el elemento interno
		const card = cardContainer2.querySelector('.card');
		// Cambiar el fondo del elemento interno
		card.style.backgroundColor = "#E0FFFF";

      } else {
        cardContainer2.style.display = "none";
      }
    }

    
  window.onload = function() {
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  }

  history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });

  </script>

</body>
</html>