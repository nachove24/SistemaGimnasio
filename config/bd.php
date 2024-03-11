<?php


$host="localhost";
$bd="gym";
$usuario="root";
$contrasenia="";

//PDO: crea una conexión con la base de datos
try {
	$conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
	

} catch (Exception $ex) {
	echo $ex->getMessage();
	
}


?>