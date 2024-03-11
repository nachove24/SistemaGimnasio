<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gym App</title>
	<link rel="stylesheet" href="registro.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .user-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .user-info {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
            width: 100%;
        }

        .user-info th, .user-info td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .options {
            width: 30%;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Panel de Usuario</h1>
    </div>

    <div class="user-container">
        <div class="user-details">
            <img src="imagen_usuario.jpg" alt="Imagen de Usuario" width="100">
            <h2>Nombre de Usuario</h2>
        </div>
        <div class="options">
            <a href="#">Configuración</a> |
            <a href="#">Cerrar Sesión</a>
        </div>
    </div>

    <table class="user-info">
        <tr>
            <th>Información</th>
            <th>Datos</th>
        </tr>
        <tr>
            <td>Nombre</td>
            <td>John Doe</td>
        </tr>
        <tr>
            <td>Correo Electrónico</td>
            <td>john.doe@example.com</td>
        </tr>
        <tr>
            <td>Fecha de Registro</td>
            <td>01/01/2023</td>
        </tr>
        <!-- Agrega más filas según sea necesario -->
    </table>

</body>
</html>