<?php
session_start();

require 'config/dbConnection.php';

$nombre = $conn->real_escape_string($_POST['nombre']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);

$sql = "INSERT INTO playlists (nombre, descripcion)
VALUES ('$nombre', '$descripcion')";


if ($conn->query($sql)) {
    $id = $conn->insert_id;
    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "PlayList guardado";

    if ($_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $permitidos = array("image/jpg", "image/jpeg","image/png");
        if (in_array($_FILES['imagen']['type'], $permitidos)) {

            $dir = "imagen";

            $info_img = pathinfo($_FILES['imagen']['name']);
            $info_img['extension'];

            $imagen = $dir . '/' . $id . '.jpg';

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
    $_SESSION['msg'] = "Error al guarda imágen";
}
header('Location: playList.php');