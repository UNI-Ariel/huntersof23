<?php
include('./auth.php');

if (!$authenticated) {
    header("Location: ./login.php");
} else {
    if (!$admin) {
        header("Location: ./unauth.php");
    }
}

include("../utils/dbConnection.php");
$getSingers = "SELECT * from singers";
$result = mysqli_query($conn, $getSingers);
$singers = mysqli_fetch_all($result, MYSQLI_ASSOC);

$titleUpdate = $singerIDfff = "";
$formTitle = "Registrar Musica";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM songs WHERE id= '$id' ";
    $res2 = mysqli_query($conn, $sql2);
    $data = mysqli_fetch_array($res2);
    $titleUpdate = $data["title"];
    $singerIDfff = isset($data["singerID"]) ? $data["singerID"] : '';
    $formTitle = "Editar Musica";
}

$errors = array('title' => '', 'singer' => '', 'mp3' => '', 'image' => '');
$title = $mp3 = $img = $singerID = '';

function saveFile($fileInfo)
{
    $filename = $fileInfo['name'];
    $type = $fileInfo['type'];
    $folder = (strpos($type, "image") !== false) ? 'images/' : 'music/';
    $tmpPath = $fileInfo['tmp_name'];
    $destinationPath = $folder . $filename;

    if (move_uploaded_file($tmpPath, '../' . $destinationPath)) {
        echo "";
    } else {
        echo "";
    }

    return $destinationPath;
}

if (isset($_POST['submit'])) {
    // Validación de los campos del formulario
    if (empty($_POST['title'])) {
        $errors['title'] = "El título no puede estar vacío.";
    } else {
        $title = $_POST['title'];
    }

    if (empty($_POST['singer'])) {
        $errors['singer'] = "Debes seleccionar un cantante.";
    } else {
        $singerID = $_POST['singer'];
    }

    // Obtener las rutas actuales desde los campos ocultos
    $currentMp3Path = isset($_POST['current_mp3']) ? $_POST['current_mp3'] : '';
    $currentImagePath = isset($_POST['current_image']) ? $_POST['current_image'] : '';

    // Validación del archivo de música
    if (empty($_FILES["mp3"]["name"]) && empty($currentMp3Path)) {
        $errors['mp3'] = "El archivo de música no puede estar vacío";
    } else {
        $mp3 = $_FILES['mp3'];
    }

    // Validación del archivo de imagen
    if (empty($_FILES["image"]["name"]) && empty($currentImagePath)) {
        $errors['image'] = "El archivo de imagen no puede estar vacío";
    } else {
        $img = $_FILES['image'];
    }

    // Comprobación de errores
    if (array_filter($errors)) {
        // Handle errors
    } else {
        // Insertar o actualizar en la base de datos
        $mp3Path = !empty($mp3['name']) ? saveFile($mp3) : $currentMp3Path;
        $imgPath = !empty($img['name']) ? saveFile($img) : $currentImagePath;

        if (isset($_GET['id'])) {
            // Actualizar la canción en la base de datos
            $updateSong = "UPDATE songs SET title = '$title', filePath = '$mp3Path', imgPath = '$imgPath', singerID = '$singerID' WHERE id =$id";
            $res3 = mysqli_query($conn, $updateSong);
            $success = true;
            
            //header("Location: editSong.php");
            
        } else {
            // Insertar la canción en la base de datos
            $insertSong = "INSERT INTO songs(title, filePath, imgPath, singerID) 
            VALUES ('$title', '$mp3Path', '$imgPath', $singerID)";
            
            if (!mysqli_query($conn, $insertSong)) {
                // Handle insert error
            } else {
                //header("Location: editSong.php");
                //echo '<script>openSuccessModal();</script>';
                $success = true;
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
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            text-align: center;
        }

        .modal-buttons {
            margin-top: 1cm;
        }

        .modal-button {
            cursor: pointer;
            border-radius: 15px;
            text-decoration: none;
            padding: 5px;
            margin: 0 10px;
        }

        .modal-button-confirm {
            background-color: #6B0000;
            color: #fff;
            border: none;
            padding: 10px 20px; /* Ajustar el padding para aumentar el tamaño */
            font-size: 14px; /* Cambiar el tamaño del texto del botón */
        }

        .modal-button-cancel {
            background-color: #0799B6;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="add-info">
        <h3 class="notice"><?php echo $formTitle; ?></h3>
        <form class="form-insert" method="POST" enctype="multipart/form-data">
            <label>Nombre de la Musica</label>
            <input type="text" name="title" placeholder="Título" value="<?php echo htmlspecialchars($titleUpdate); ?>">
            <p class="error"><?php echo $errors['title']; ?></p>

            <label>Nombre del Artista</label>
            <select name="singer">
                <option value="" selected disabled>Seleccionar Artista</option>
                <?php foreach ($singers as $singer) : ?>
                    <option value='<?php echo $singer['id']; ?>' <?php echo ($singer['id'] == $singerIDfff) ? 'selected' : ''; ?>>
                        <?php echo $singer['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="error"><?php echo $errors['singer']; ?></p>

            <label>Subir Archivo</label>
    <input type="file" name="mp3" accept=".mp3, .wav, audio/mpeg, audio/wav">
    <?php if (!empty($errors['mp3'])) : ?>
        <p class="error"><?php echo $errors['mp3']; ?></p>
    <?php endif; ?>

    <!-- Mostrar el archivo de música actual al editar -->
    <?php if (isset($_GET['id']) && !empty($data['filePath'])) : ?>
    <p style="padding: 10px; margin: 10px 0; border: 1px solid #0799b6; color: black;">
        <strong>Archivo de música actual:</strong> <?php echo $data['filePath']; ?>
    </p>
    <input type="hidden" name="current_mp3" value="<?php echo $data['filePath']; ?>">
<?php endif; ?>



    <label>Subir Imagen</label>
    <input type="file" name="image" accept="image/*">
    <?php if (!empty($errors['image'])) : ?>
        <p class="error"><?php echo $errors['image']; ?></p>
    <?php endif; ?>

    <!-- Mostrar la imagen actual al editar -->
    <?php if (isset($_GET['id']) && !empty($data['imgPath'])) : ?>
    <p style="padding: 10px; margin: 10px 0; border: 1px solid #0799b6; color: black;">
        <strong>Imagen actual:</strong> <?php echo $data['imgPath']; ?>
    </p>
    <input type="hidden" name="current_image" value="<?php echo $data['imgPath']; ?>">
<?php endif; ?>



            <a href="editSong.php" class="ca">Cancelar</a>
            <button type="submit" name="submit" style="cursor: pointer;">Guardar</button>
        </form>
    </div>
    
    <!-- Modal de éxito -->
<div id="successModal" class="modal">
    <div class="modal-content" style="width: 10cm; height: 4cm; background-color: #28324b; color: white;">
        <p>¡Guardado exitoso!</p>
        <div class="modal-buttons" style="margin-top: 1cm;">
            <button class="modal-button modal-button-confirm" onclick="closeSuccessModal()" style="cursor: pointer; background-color: #6B0000; color: white;">Aceptar</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php if(isset($success) && $success === true): ?>
            openSuccessModal(); // Mostrar el modal solo si se guardó exitosamente
        <?php endif; ?>
        
    });

    
    // Función para mostrar el modal de éxito
    function openSuccessModal() {
        document.getElementById('successModal').style.display = 'block';
    }

    // Función para cerrar el modal de éxito
    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
        window.location.href = 'editSong.php'; // Redirigir a la lista de canciones
    }
    
    
</script>



</body>

</html>
