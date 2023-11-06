<?php
session_start();

require '../utils/dbConnection.php';

$nombre = $conn->real_escape_string($_POST['nombre']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);

// Verificar si el nombre de la playlist ya existe en la base de datos
$sqlCheckName = "SELECT id FROM playlists WHERE nombre = '$nombre'";
$result = $conn->query($sqlCheckName);

if ($result->num_rows > 0) {
    // El nombre de la playlist ya existe, muestra un mensaje de error.
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "El nombre de la lista ya existe. Por favor, elige un nombre diferente.";
    header('Location: playList.php'); // Redirecciona de vuelta a la página de lista de playlists.
    exit;
}

// Si el nombre no existe, procede a insertar los datos.
$sql = "INSERT INTO playlists (nombre, descripcion)
        VALUES ('$nombre', '$descripcion')";

if ($conn->query($sql)) {
    $id = $conn->insert_id;
    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Lista de reproduccion guardado";

    if ($_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $permitidos = array("image/jpg", "image/jpeg", "image/png");
        if (in_array($_FILES['imagen']['type'], $permitidos)) {

            $dir = "imagen";

            $dir = "imagen";

$info_img = pathinfo($_FILES['imagen']['name']);
$extension = $info_img['extension'];

$imagen = $dir . '/' . $id . '.' . $extension; // Utiliza la extensión para construir el nombre del archivo

if (!file_exists($dir)) {
    mkdir($dir, 0777);
}

if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen)) {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] .= "<br>Error al guardar imagen";
}

        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] .= "<br>Formato de imágen no permitido";
        }
    }
} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al guardar imágen";
}


header('Location: playList.php');
