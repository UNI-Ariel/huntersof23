<?php
include("../utils/dbConnection.php");  // Incluye el archivo de conexión a la base de datos
include('./auth.php');  // Incluye el archivo de autenticación

if (!$authenticated) {  // Si no está autenticado
    header("Location: ./login.php");  // Redirige a la página de inicio de sesión
} else {
    if (!$admin) {  // Si no es un administrador
        header("Location: ./unauth.php");  // Redirige a la página de no autorizado
    } else {
        $id = $_GET['id'];  // Obtiene el ID desde la URL

        $sql = "DELETE FROM songs WHERE id = '$id'";  // Consulta SQL para eliminar una canción con el ID proporcionado
        $result = mysqli_query($conn, $sql);  // Ejecuta la consulta en la base de datos

        if ($result)  // Si la consulta se ejecutó correctamente
            header("Location: editSong.php");  // Redirige a la página de edición de canciones
    }
}

    
?>
<td>
    <a style="padding: 5px; background-color: #6B0000; color: #fff; border-radius: 15px; text-decoration: none;"
       href="deleteSong.php?id=<?php echo $song['id']; ?>">Eliminar</a>
</td>