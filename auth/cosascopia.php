<?php

// Archivo de conexión a la base de datos 
include("../utils/dbConnection.php");

$id_user = $_REQUEST['user'];

// Obtener datos actuales del usuario para mostrar en el formulario
$sql = "SELECT username, email, userImg FROM users WHERE id = $id_user";
$resultado = mysqli_query($conn, $sql);

if ($resultado) {
    $fila = mysqli_fetch_assoc($resultado);
    $usernameActual = $fila['username'];
    $emailActual = $fila['email'];
    $imgUserActual = $fila['userImg'];
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

        <form action="editarperfil.php" method="post" enctype="multipart/form-data">
            <label for="nuevoNombre">Nuevo Nombre:</label>
            <input type="text" id="nuevoNombre" name="nuevoNombre" value="<?php echo $usernameActual; ?>" required>

            <label for="nuevoemail">Nuevo Correo:</label>
            <input type="email" id="nuevoemail" name="nuevoemail" value="<?php echo $emailActual; ?>" required>

            <label for="imagenActual">Imagen Actual:</label>
            <img src="directorio_destino/<?php echo $imagenActual; ?>" alt="Imagen Actual">

            <label for="nuevaImagen">Cambiar Imagen:</label>
            <input type="file" id="nuevaImagen" name="nuevaImagen">

            <input type="submit" value="Guardar Cambios">
            <input type="submit" value="Eliminar  Cambios">
        </form>
    </div>
</body>
</html>