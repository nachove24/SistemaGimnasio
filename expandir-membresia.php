<?php


// Verifica si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe el dato enviado
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    //////////////////////BASE DE DATOS//////////////////////////////
    include("config/bd.php");
    $sql = "SELECT gym_membresia FROM membresia WHERE id_membresia=:id";
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();
    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
    ////////////////////////////////////////////////////////////
    if ($resultado['gym_membresia'] === 0) {
        $image = "img-m/membresia-blanca.png";
        $gym_membresia = 0;
    }else{
        //echo json_encode($resultado);
        $gym_membresia = $resultado["gym_membresia"];
        $sql_membresia= "SELECT color_membresia FROM membresia WHERE id_membresia=:id AND gym_membresia=:gym";
        $sql_membresia = $conexion->prepare($sql_membresia);
        $sql_membresia->bindParam(':id', $id, PDO::PARAM_INT);
        $sql_membresia->bindParam(':gym', $gym_membresia, PDO::PARAM_INT);
        $sql_membresia->execute();
        $resultado_membresia = $sql_membresia->fetch(PDO::FETCH_ASSOC);
        $color = $resultado_membresia["color_membresia"];

        switch ($color) {
        case 'white':
            $image = "img-m/membresia-blanca.png";
            break;
        case 'red':
            $image = "img-m/membresia-roja.png";
            break;
        case 'blue':
            $image = "img-m/membresia-azul.png";
            break;
        case 'yellow':
            $image = "img-m/membresia-amarilla.png";
            break;
        case 'gold':
            $image = "img-m/membresia-dorada.png";
            break;
        case 'sky_blue':
            $image = "img-m/membresia-celeste.png";
            break;
        case 'rose':
            $image = "img-m/membresia-rosada.png";
            break;
        default:
            $image = "img-m/membresia-blanca.png";
            break;
    }

    }
    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym App</title>
    <style type="text/css">
        *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        text-decoration: none;
        list-style: none; 
    }   

        body{
            font-family: "arial";
            background-image: url(img/fondo-mancuerna.png);
            background-repeat: repeat;
        }
        div{
            margin: 0 auto;
            margin-top: 50px;
        }   
        p{
            text-align: left;
            font-weight: bold;
            font-size: 1rem;
        }

        .titulo{
            color: #2EFEF7;
            margin: 0 auto;
            text-align: center;
            margin-top: 40px;
            display: block;
            height: 10px; 
        }
        #dia{
            background-image: url('img-m/membresia-blanca.png');
        }
        .membresia{
            width: 770px;
            height: 360px;
            background-color: white;
            text-align: left;
            padding-top: 10px;
            border-radius: 10px;
            box-shadow: 2px 2px 2px 2px #000;
            text-decoration: none;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }    
        .t-memb{
            font-size: 2.3rem;
            
            margin-top: 17px;
        }
        .duracion{
            margin-top: 40px;
        }
        .servicio{
            margin-top: 72px;
        }
        .politica{
            margin-top: 68.2px;
        }
        .button{
            width: 80px;
            height: 25px;
            border-radius: 5px;
            background-color: #0080FF;
            color: white;
            border: 1px white;
            box-shadow: 1px 1px 1px 1px black;
            cursor: pointer;
            margin-left: 300px;
        }
    </style>
</head>
<body>
    <h2 class="titulo">Membresia</h2><br>
    
    <div class="membresia" style="background-image: url('<?php echo $image; ?>');">
        <?php
        $consulta = "SELECT id_membresia, nombre_membresia, duracion.nombre_duracion, precio_membresia, servicio_membresia, politica_membresia FROM membresia INNER JOIN duracion ON duracion.id_duracion = membresia.duracion_membresia WHERE id_membresia = $id AND gym_membresia = $gym_membresia";
    $resultado = $conexion->query($consulta);

// Itera sobre los resultados
while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
    $id = $fila['id_membresia'];
    $nombre = $fila['nombre_membresia'];
    $duracion = $fila['nombre_duracion'];
    $precio = $fila['precio_membresia'];
    $servicio = $fila['servicio_membresia'];
    $politica = $fila['politica_membresia'];

        echo '<div style="display: flex;margin-top: 11px;">
                <h1 class="t-memb">' . $nombre . '</h1>
                <h1 class="precio">$' . $precio . '||</h1> 
                <h1 class="id">id: #' . $id . '</h1>
            </div>
            <p class="duracion">Duración: ' . $duracion . '</p>
            <p class="servicio">Característica: ' . $servicio . '</p>
            <p class="politica">Políticas: ' . $politica . '</p>';

        /*echo '<form method="post" class="membresia-form">';
        echo '<input type="hidden" name="id" value="' . $id . '">';
        echo '<label for="nombre">Nombre:</label><input type="text" name="nombre" value="' . $nombre . '">';
        echo '<label for="duracion">Duración:</label><input type="text" name="duracion" value="' . $duracion . '">';
        echo '<label for="precio">Precio:</label><input type="text" name="precio" value="' . $precio . '">';
        echo '<label for="servicio">Servicio:</label><input type="text" name="servicio" value="' . $servicio . '">';
        echo '<label for="politica">Política:</label><input type="text" name="politica" value="' . $politica . '">';
        echo '<button type="submit" name="editar_membresia" class="button">Actualizar</button>';
        echo '</form>';*/

        }
      ?>
      </div>
</body>
</html>