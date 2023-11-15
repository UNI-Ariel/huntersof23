<?php
// Archivo de conexión a la base de datos 
include("../utils/dbConnection.php");


$id_usuario = 1;

// Obtener datos actuales del usuario para mostrar en el formulario
$sql = "SELECT nombre, correo, imagen FROM usuarios WHERE id = $id_usuario";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    $fila = mysqli_fetch_assoc($resultado);
    $nombreActual = $fila['nombre'];
    $correoActual = $fila['correo'];
    $imagenActual = $fila['imagen'];
} else {
    // Manejar errores de la consulta
    die("Error: " . mysqli_error($conexion));
}
?> 

<?php
// Archivo de conexión a la base de datos (reemplázalo con tus propios detalles de conexión)
include 'conexion.php';

// ID del usuario (ajústalo según tu aplicación, por ejemplo, desde la sesión)
$id_usuario = 1;

// Obtener datos actuales del usuario para mostrar en el formulario
$sql = "SELECT nombre, correo, imagen FROM usuarios WHERE id = $id_usuario";
$resultado = mysqli_query($conn, $sql);

if ($resultado) {
    $fila = mysqli_fetch_assoc($resultado);
    $nombreActual = $fila['nombre'];
    $correoActual = $fila['correo'];
    $imagenActual = $fila['imagen'];
} else {
    // Manejar errores de la consulta
    die("Error: " . mysqli_error($conn));
}

// Cerrar la conexión a la base de datos después de obtener los datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 16px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Perfil</h1>

        <form action="editar_perfil.php" method="post" enctype="multipart/form-data">
            <label for="nuevoNombre">Nuevo Nombre:</label>
            <input type="text" id="nuevoNombre" name="nuevoNombre" value="<?php echo $nombreActual; ?>" required>

            <label for="nuevoCorreo">Nuevo Correo:</label>
            <input type="email" id="nuevoCorreo" name="nuevoCorreo" value="<?php echo $correoActual; ?>" required>

            <label for="imagenActual">Imagen Actual:</label>
            <img src="directorio_destino/<?php echo $imagenActual; ?>" alt="Imagen Actual">

            <label for="nuevaImagen">Cambiar Imagen:</label>
            <input type="file" id="nuevaImagen" name="nuevaImagen">

            <input type="submit" value="Guardar Cambios">
        </form>
    </div>
</body>
</html>
