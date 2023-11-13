<?php
include("../utils/dbConnection.php");

if (isset($_GET['q'])) {
    $query = $_GET['q'];

    $searchQuery = "SELECT * FROM singers WHERE name LIKE '%$query%'";
    $result = mysqli_query($conn, $searchQuery);
    $singers = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (count($singers) > 0) {
        echo '<table style="width: 100%; background-color: #28324b; color: #fff; border-collapse: collapse;">';
        echo '<tr><th style="padding: 10px;">Artista Registrados</th></tr>';
        foreach ($singers as $singer) {
            echo '<tr>';
            echo '<td style="padding: 10px; cursor: pointer;" onclick="selectSinger(\'' . $singer['name'] . '\')">' . $singer['name'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p style="background-color: #28324b; color: #fff; padding: 10px;">Artista no encontrado</p>';
    }
}
?>


