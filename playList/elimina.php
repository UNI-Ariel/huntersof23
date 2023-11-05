<?php
session_start();

require '../utils/dbConnection.php';

$id = $conn->real_escape_string($_POST['id']);

$sql = "DELETE FROM playlists WHERE id=$id";
if ($conn->query($sql)) {

    $dir = "imagen";
    $poster = $dir . '/' . $id . '.jpg';

    if (file_exists($imagen)) {
        unlink($imagen);
    }

    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Lista de reproduccion eliminada";
} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al eliminar lista de reproduccion";
}

header('Location: playList.php');