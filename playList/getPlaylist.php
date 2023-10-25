<?php

require 'config/dbConnection.php';

$id = $conn->real_escape_string($_POST['id']);

$sql = "SELECT id, nombre, descripcion FROM playlists WHERE id=$id LIMIT 1";
$resultado = $conn->query($sql);
$rows = $resultado->num_rows;

$playlists = [];

if ($rows > 0) {
    $playlists = $resultado->fetch_array();
}

echo json_encode($playlists, JSON_UNESCAPED_UNICODE);