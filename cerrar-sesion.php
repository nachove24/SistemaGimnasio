<?php
require "template/redirigir.php";

include "template/header.php";

?>
<h1 class="titulo">Cerrar Sesión</h1>
<div style="width: 300px;height: 155px;background-color: whitesmoke;border-radius: 10px;margin: 0 auto;margin-top: 100px;box-shadow: 2px 2px 2px 2px black;">
	<h2 style="text-decoration: underline;margin-left: 8px;padding-top: 4px;">¿Quieres cerrar sesión?</h2>
	<form method="post" style="display: flex;margin-top: 50px;">
	<button type="submit" name="cerrar" class="accion" style="margin: 0 auto;">Si</button>
	</form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cerrar'])) {
	session_destroy();
	header ("Location:index.php");
}

?>
