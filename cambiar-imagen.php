<?php
require "template/redirigir.php";
include "template/header.php";

include "config/bd.php";
$sql_gym = "SELECT * FROM gimnasio WHERE cod_gym = $cod_gym";
$resultado_gym = $conexion->query($sql_gym);
$row_gym = $resultado_gym->fetch(PDO::FETCH_ASSOC);
$image = $row_gym['imagen_gym'];
$nombre = $row_gym['nombre_gym'];

?>
 <h1 class="titulo">Cambiar Imagen de perfil</h1>
<div style="width: 300px;height: 320px;background-color: whitesmoke;border-radius: 10px;margin:0 auto;margin-top: 97px;">
<?php
            echo '<img src="' . $image . '" alt="Imagen de Usuario" width="100" style="border-radius:50%;height:100px;background-color:#585858;box-shadow:1px 1px 2px 3px black;margin-left: 98.1px;margin-top:5px;">';
    			echo "<h2 style='color: skyblue;text-align: center;'>" . $nombre . "</h2>";
?>
	<form method="post" enctype="multipart/form-data">
		<input type="file" name="imagen" style="margin-left: 3px;margin-top: 50px;" required>
		<input type="submit" name="cambiar" value="Cambiar" class='accion' style="margin-left: 98px;margin-top: 39px;">
	</form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cambiar'])) {
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

        $sentenciaSQL = $conexion->prepare("UPDATE gimnasio SET imagen_gym = :imagen WHERE cod_gym = :cod_gym;");
		$sentenciaSQL->bindParam(':imagen', $ruta_relativa);
		$sentenciaSQL->bindParam(':cod_gym', $cod_gym);
		move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta_destino . $nombre_unico);
		$sentenciaSQL->execute();
		 header ("Location:gestion-gym.php");

    } else {
        echo "No se recibió ninguna imagen.";
    }

}


?>