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
$formTitle = "Registrar Musica"; // Título por defecto

if (isset($_GET['id'])) {  // Verifica si se recibe un ID por GET para edición
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM songs WHERE id= '$id' ";
    $res2 = mysqli_query($conn, $sql2);
    $data = mysqli_fetch_array($res2);
    $titleUpdate = $data["title"];  // Obtiene el título para la edición
    $singerIDfff = $data["singerID"];  // Obtiene el ID del cantante para la edición
    $formTitle = "Editar Musica"; // Cambiar el título si se está editando
}

$errors = array('title' => '', 'mp3' => '', 'img' => '');  // Arreglo para mensajes de error
$title = $mp3 = $img = $singerID = '';  // Variables para título, archivos y ID del cantante

// Función para guardar un archivo en el servidor
function saveFile($fileInfo)
{
        // Lógica para guardar el archivo en el servidor
    $filename = $fileInfo['name'];
    $type = $fileInfo['type'];
    $folder = (strpos($type, "image") !== false) ? 'images/' : 'music/';
    $tmpPath = $fileInfo['tmp_name'];
    $destinationPath = $folder . $filename;

    if (move_uploaded_file($tmpPath, '../' . $destinationPath)) {
        echo "Successfully uploaded";
    } else {
        echo "Upload fail";
    }

    return $destinationPath;
}
// Manejo del formulario al enviar los datos
if (isset($_POST['submit'])) {
    // Validación de los campos del formulario

    // Validación del campo de título
    if (empty($_POST['title'])) {
        $errors['title'] = "Title cannot be empty";
    } else {
        $title = $_POST['title'];
    }
        // Validación del campo de cantante
    $singerID = $_POST['singer'];
        // Validación del archivo de música
    if (empty($_FILES["mp3"]["name"])) {
        $errors['mp3'] = "Music File cannot be empty";
    } else {
        $mp3 = $_FILES['mp3'];
    }
        // Validación del archivo de imagen
    if (empty($_FILES["image"]["name"])) {
        $errors['image'] = "Image file cannot be empty";
    } else {
        $img = $_FILES['image'];
    }
         // Comprobación de errores
    if (array_filter($errors)) {
        echo 'Formulario no válido';
    } else {
// Insertar o actualizar en la base de datos
        $mp3Path = saveFile($mp3);
        $imgPath = saveFile($img);

        if (isset($_GET['id'])) {
                        // Actualizar la canción en la base de datos
            $updateSong = "UPDATE songs SET title = '$title', filePath = '$mp3Path', imgPath = '$imgPath', singerID = '$singerID' WHERE id =$id";
            $res3 = mysqli_query($conn, $updateSong);
            header("Location: editSong.php");
        } else {
                        // Insertar la canción en la base de datos
            $insertSong = "INSERT INTO songs(title, filePath, imgPath, singerID) 
            VALUES ('$title', '$mp3Path', '$imgPath', $singerID)";
            if (!mysqli_query($conn, $insertSong)) {
                echo  "Error: " . "<br>" . mysqli_error($conn);
            } else {
                header("Location: editSong.php");
            }
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
        <h3 class="notice"><?php echo $formTitle; ?></h3>
        <form class="form-insert" method="POST" enctype="multipart/form-data">
            <?php foreach ($errors as $error) : ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endforeach; ?>
            <label>Nombre de la Musica</label>
            <input type="text" name="title" placeholder="Título" value="<?php echo $titleUpdate; ?>">
            <label>Nombre del Artista</label>
            <input type="text" name="singer" id="singerSearch" oninput="searchSinger(this.value)">
            <div id="singerResults"></div>
            <label>Subir Archivo</label>
            <input type="file" name="mp3" accept="audio/*">
            <label>Subir Imagen</label>
            <input type="file" name="image" accept="image/*"><br>
            <a href="editSong.php" class="ca">Cancelar</a>
            <button type="submit" name="submit">Guardar</button>
        </form>
    </div>

    <script>
        function searchSinger(query) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("singerResults").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "searchSinger.php?q=" + query, true);
            xhttp.send();
        }

        function selectSinger(name) {
            document.getElementById("singerSearch").value = name;
            document.getElementById("singerResults").innerHTML = '';
        }
    </script>
</body>

</html>

