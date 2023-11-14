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

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevoNombre = $_POST['nuevoNombre'];
    $nuevoCorreo = $_POST['nuevoCorreo'];

    // Actualizar nombre y correo en la base de datos
    $sqlUpdate = "UPDATE usuarios SET nombre = '$nuevoNombre', correo = '$nuevoCorreo' WHERE id = $id_usuario";
    if (mysqli_query($conexion, $sqlUpdate)) {
        // Éxito en la actualización del nombre y correo
    } else {
        // Manejar errores de la consulta
        die("Error: " . mysqli_error($conexion));
    }

    // Procesar la nueva imagen si se proporciona
    if ($_FILES['nuevaImagen']['error'] == 0) {
        $imagenTmpPath = $_FILES['nuevaImagen']['tmp_name'];
        $imagenNombre = $_FILES['nuevaImagen']['name'];

        // Mover la imagen al directorio deseado (aquí deberías validar el tipo de archivo, tamaño, etc.)
        move_uploaded_file($imagenTmpPath, 'directorio_destino/' . $imagenNombre);

        // Actualizar la información de la imagen en la base de datos
        $sqlImagen = "UPDATE usuarios SET imagen = '$imagenNombre' WHERE id = $id_usuario";
        if (!mysqli_query($conexion, $sqlImagen)) {
            // Manejar errores de la consulta
            die("Error: " . mysqli_error($conexion));
        }
    }

    // Redirigir a la página de perfil o mostrar un mensaje de éxito
    header('Location: perfil.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
</head>

<body>
    <h1>Editar Perfil</h1>

    <form action="editar_perfil.php" method="post" enctype="multipart/form-data">
        <label for="nuevoNombre">Nuevo Nombre:</label>
        <input type="text" id="nuevoNombre" name="nuevoNombre" value="<?php echo $nombreActual; ?>" required>
        <br>

        <label for="nuevoCorreo">Nuevo Correo:</label>
        <input type="email" id="nuevoCorreo" name="nuevoCorreo" value="<?php echo $correoActual; ?>" required>
        <br>

        <!-- Mostrar la imagen actual -->
        <img src="directorio_destino/<?php echo $imagenActual; ?>" alt="Imagen Actual">

        <br>

        <label for="nuevaImagen">Cambiar Imagen:</label>
        <input type="file" id="nuevaImagen" name="nuevaImagen">
        <br>

        <input type="submit" value="Guardar Cambios">
    <br>   
        <input type="submit" value="Eliminar Cambios">
    </form>
</body>
</html>
