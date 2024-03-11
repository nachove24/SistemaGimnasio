<?php
session_start();

$cod_gym = isset($_SESSION['cod_gym']) ? $_SESSION['cod_gym'] : null;
$cod_admin = isset($_SESSION['cod_admin']) ? $_SESSION['cod_admin'] : null;

if ($cod_gym === null || $cod_admin === null) {
    // Si alguna de las variables no está definida, redirige a index.php
    header("Location: index.php");
    exit();
}

// Resto del código aquí...
?>
