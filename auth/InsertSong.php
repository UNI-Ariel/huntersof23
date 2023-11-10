<?php
include('./auth.php');  // Incluye el archivo de autenticación

if (!$authenticated) {  // Si no está autenticado, redirige a la página de inicio de sesión
    header("Location: ./login.php");
} else {
    if (!$admin) {  // Si no es administrador, redirige a la página de no autorizado
        header("Location: ./unauth.php");
    }
}

include("../utils/dbConnection.php");  // Incluye el archivo de conexión a la base de datos
$getSingers = "SELECT * from singers";  // Consulta para obtener todos los cantantes
$result = mysqli_query($conn, $getSingers);  // Ejecuta la consulta en la base de datos
$singers = mysqli_fetch_all($result, MYSQLI_ASSOC);  // Obtiene todos los cantantes como un array asociativo

$titleUpdate = $singerIDfff = "";  // Variables para el título y el ID del cantante

if (isset($_GET['id'])) {  // Verifica si se recibe un ID por GET para edición
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM songs WHERE id= '$id' ";
    $res2 = mysqli_query($conn, $sql2);
    $data = mysqli_fetch_array($res2);
    $titleUpdate = $data["title"];  // Obtiene el título para la edición
    $singerIDfff = $data["singerID"];  // Obtiene el ID del cantante para la edición
}

$errors = array('title' => '', 'mp3' => '', 'img' => '');  // Arreglo para mensajes de error
$title = $mp3 = $img = $singerID = '';  // Variables para título, archivos y ID del cantante

// Función para guardar un archivo en el servidor
function saveFile($fileInfo)
{
    // Lógica para guardar el archivo en el servidor
}

// Manejo del formulario al enviar los datos
if (isset($_POST['submit'])) {
    // Validación de los campos del formulario

    // Validación del campo de título
    // Validación del campo de cantante
    // Validación del archivo de música
    // Validación del archivo de imagen

    // Comprobación de errores
    if (array_filter($errors)) {
        echo 'Formulario no válido';
    } else {
        // Insertar o actualizar en la base de datos

        // Guardar la ruta del archivo de música
        // Guardar la ruta del archivo de imagen

        if (isset($_GET['id'])) {
            // Actualizar la canción en la base de datos
        } else {
            // Insertar la canción en la base de datos
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancion</title>
    <link rel="stylesheet" href="./css/song.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="add-info">
        <!-- Sección para agregar información de la canción -->
        <h3 class="notice">Registrar Musica</h3>
        <form class="form-insert" method="POST" enctype="multipart/form-data">
            <?php foreach ($errors as $error) : ?>
                <p class="error"><?php echo $error; ?></p> <!-- Muestra errores del formulario -->
            <?php endforeach; ?>
            <label>Nombre de la Musica</label>
            <input type="text" name="title" placeholder="Título" value="<?php echo $titleUpdate; ?>">
            <label>Nombre del Artista</label>
            <select name="singer">
           <option value="" selected disabled>Seleccionar Artista</option>
           <?php foreach ($singers as $singer) : ?>
           <option value='<?php echo $singer['id']; ?>'>
           <?php echo $singer['name']; ?>
           </option>
           <?php endforeach; ?>
           </select>
            <label>Subir Archivo</label>
            <input type="file" name="mp3" accept="audio/*">
            <label>Subir Imagen</label>
            <input type="file" name="image" accept="image/*"><br>
            <a href="editSong.php" class="ca">Cancelar</a> <!-- Enlace para volver cancelar -->
            <button type="submit" name="submit">Guardar</button> <!-- Botón para guardar el formulario -->

        </form>
    </div>
</body>

</html>
