<?php
require "template/redirigir.php";

include "template/header.php";

require "config/bd.php";

$dni = isset($_GET['dni']) ? $_GET['dni'] : null;

if (isset($_SESSION['mensaje'])) {
      echo '<div style="color:white;">';
      echo '<img style="width: 23.5px; height: 17.5px;" src="img/logo-advertencia.png" alt="Descripción de la imagen">';
      echo $_SESSION['mensaje'];
      unset($_SESSION['mensaje']);
      echo '</div>'; }
?>
<h1 class="titulo">Eliminar Cliente</h1>
<div style="width: 300px;height: 155px;background-color: whitesmoke;border-radius: 10px;margin: 0 auto;margin-top: 100px;box-shadow: 2px 2px 2px 2px black;">
	<h2 style="text-decoration: underline;margin-left: 8px;padding-top: 4px;">¿Estás seguro de eliminar este cliente?</h2>
	<form method="post" style="display: flex;margin-top: 50px;">
	<input type="hidden" name="dni" value="<?php echo $dni; ?>">
	<button type="submit" name="cerrar" class="accion" style="margin: 0 auto;">Si</button>
	</form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cerrar'])) {
	
        $dni = (isset($_POST['dni'])) ? $_POST['dni'] : "";
        try{
        $sql_eliminar = "DELETE FROM cliente WHERE dni = :dni";
        $consulta_eliminar = $conexion->prepare($sql_eliminar);
        $consulta_eliminar->bindParam(':dni', $dni, PDO::PARAM_INT);
        $consulta_eliminar->execute();
        //header("Location: gestion-gym.php");
        echo '<script>window.location.href = "lista-cliente.php";</script>';
        exit();
    }catch (PDOException $e) {
        // Error al eliminar debido a restricción de clave externa
        $_SESSION['mensaje'] = "No se puede eliminar el cliente ya que está siendo utilizado en otras partes del sistema. " . $e;
        echo '<script>window.location.href = "eliminar-cliente.php";</script>';
        exit();
    }
}

?>