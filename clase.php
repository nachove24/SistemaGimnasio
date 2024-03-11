<?php
require "template/redirigir.php";
	include("config/bd.php");

	include "template/header.php";

    
?>

	<h2 class="titulo">Registro de Clases</h2> 
		<div style="display: flex;"> 
			<div style="width: 50%;"> 
	<?php
				$errors = [];
if (isset($_SESSION['mensaje'])) {
      echo '<div style="color:white;">';
      echo '<img style="width: 23.5px; height: 17.5px;" src="img/logo-advertencia.png" alt="Descripción de la imagen">';
      echo $_SESSION['mensaje'];
      unset($_SESSION['mensaje']);
      echo '</div>';}
if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['confirm'])) {

     // Ajusta según el nombre real del campo en tu formulario
    if (isset($_POST['nombre_clase'])) {
        $nombre_clase = $_POST['nombre_clase'];
    }

    // Ajusta según el nombre real del campo en tu formulario
    if (isset($_POST['descripcion_clase'])) {
        $descripcion_clase = $_POST['descripcion_clase'];
    }

    // Ajusta según el nombre real del campo en tu formulario
    if (isset($_POST['duracion_clase'])) {
        $duracion_clase = $_POST['duracion_clase'];
    }

     // Ajusta según el nombre real del campo en tu formulario
    if (isset($_POST['instructor_clase'])) {
        $instructor_clase = $_POST['instructor_clase'];
    }
   

    if (empty($errors)) {
        //  base de datos
        include("config/bd.php");

      $consulta = "SELECT nombre_clase FROM clase WHERE nombre_clase = :nombre_clase AND gym_clase = :cod_gym";
$sentencia = $conexion->prepare($consulta);
$sentencia->bindParam(':nombre_clase', $nombre_clase, PDO::PARAM_STR); // Asegúrate de especificar el tipo de dato
$sentencia->bindParam(':cod_gym', $cod_gym, PDO::PARAM_INT); // Asegúrate de especificar el tipo de dato
$sentencia->execute();
$resultado = $sentencia->fetch();


      if (!$resultado) {

        $sentenciaClase = $conexion->prepare("INSERT INTO clase (nombre_clase, descripcion_clase, duracion_clase, instructor_clase, gym_clase) VALUES (:nombre_clase, :descripcion_clase, :duracion_clase, :instructor_clase, :gym_clase)");
        $sentenciaClase->bindParam(':nombre_clase', $nombre_clase);
        $sentenciaClase->bindParam(':descripcion_clase', $descripcion_clase);
        $sentenciaClase->bindParam(':duracion_clase', $duracion_clase);
        $sentenciaClase->bindParam(':instructor_clase', $instructor_clase);
        $sentenciaClase->bindParam(':gym_clase', $cod_gym);
        $sentenciaClase->execute();


          header("Location: clase.php");
          exit(); 
}else{    $_SESSION['mensaje'] = "El Nombre de la clase ya existe.";
            header("Location: clase.php");
            exit(); 
        }
    } 
}
    ?>


  
  <form class="form container" method="POST" style="width: 95%;">
    <div class="div1" style="width: 100%;">
  <div class="input-group">
        <h4>Nombre de la clase:</h4>
        <input type="text" maxlength="10" name="nombre_clase" required>
    </div>

    <div class="input-group">
        <h4>Descripción de la clase:</h4>
        <input type="text" maxlength="45" name="descripcion_clase" required>
    </div>

    <div class="input-group">
        <h4>Duración de la clase:</h4>
        <input type="text" maxlength="5" name="duracion_clase" required>
    </div>

    <div class="input-group">
        <h4>Instructor de la clase:</h4>
        <input type="text" name="instructor_clase" required>
    </div>
 
<div style="">
  <?php foreach ($errors as $error) {
        echo '<br>' . '<p style="color: red;"> ¡'. $error .'!</p>' . '<br>';
      } ?>
<?php if (isset($_SESSION['mensajes'])) {
  echo $_SESSION['mensajes'];
  unset($_SESSION['mensajes']);
}
?>
<br>
<input type="submit" value="Confirmar" name="confirm" class="confirm">
</div>
</div>
</form>
			</div>

			<div style="width: 50%;">
    		<?php
    			$sentenciaConsulta = $conexion->prepare("SELECT clase.id_clase, clase.nombre_clase, clase.descripcion_clase, clase.cant_alumnos, clase.duracion_clase, clase.instructor_clase FROM clase  WHERE clase.gym_clase = :cod_gym");
				$sentenciaConsulta->bindParam(':cod_gym', $cod_gym, PDO::PARAM_STR);
				$sentenciaConsulta->execute();

				echo '<table class="table user-info" style="margin-top:60px;width:90%;font-size:0.68rem;box-shadow: none;">';
				echo '<tr>
        			<th>ID Clase</th>
        			<th>Nombre Clase</th>
        			<th>Descripción Clase</th>
        			<th>Cantidad de Alumnos</th>
        			<th>Duración Clase</th>
        			<th>Instructor Clase</th>
    			</tr>';

				// Itera a través de los resultados y muestra cada fila
				while ($filaConsulta = $sentenciaConsulta->fetch(PDO::FETCH_ASSOC)) {
   					echo '<tr>';
    			echo '<td>' . $filaConsulta['id_clase'] . '</td>';
    			echo '<td>' . $filaConsulta['nombre_clase'] . '</td>';
    			echo '<td>' . $filaConsulta['descripcion_clase'] . '</td>';
    			echo '<td>' . $filaConsulta['cant_alumnos'] . '</td>';
    			echo '<td>' . $filaConsulta['duracion_clase'] . '</td>';
    			echo '<td>' . $filaConsulta['instructor_clase'] . '</td>';
    			echo "<td style='box-shadow: none;'>";
        		echo "<form method='post'>";
       			echo "<input type='hidden' name='id' value='" . $filaConsulta["id_clase"] . "'>";
        		echo '<button type="submit" value="borrar" name="borrar" class="basura-clase"></button>';
        		echo "</form>";
        		echo "</td>";
    			echo '</tr>';
				}

				echo '</table>';

    		?>
			</div>
		</div>
	<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrar'])) {

            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $sql_actualizar1 = "UPDATE cliente SET cliente.clase_cliente = 0 WHERE cliente.clase_cliente = :id";
            $sql_actualizar3 = $conexion->prepare($sql_actualizar1);
            $sql_actualizar3->bindParam(':id', $id);
            $sql_actualizar3->execute();

    		
    		$sql_borrar = "DELETE FROM clase WHERE id_clase = :id";
    		$stmt = $conexion->prepare($sql_borrar);
    		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    		// Ejecutar la consulta
    		if ($stmt->execute()) {
        		echo '<script>window.location.href = "clase.php";</script>';
    		exit();
    		}else{
    			$_SESSION['mensaje']="NO PUEDE ELIMINAR LA CLASE YA QUE ESTÁ SIENDO OCUPADA";
    		}
		}
	?>
	</body> 
</html>