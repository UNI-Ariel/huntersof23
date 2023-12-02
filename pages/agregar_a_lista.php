<?php
include("../utils/dbConnection.php"); 

if (isset($_POST['idSong']) && isset($_POST['idPlay'])) {
    $idSong = $_POST['idSong'];
    $playlistId = $_POST['idPlay'];

    // Verificar si la canción ya está en la lista de reproducción
    $sqlVerificar = "SELECT * FROM lista WHERE idPlay= $playlistId AND idSong = $idSong";
    $resultVerificar = $conn->query($sqlVerificar);

    if ($resultVerificar->num_rows > 0) {
        //$mensaje = "La canción ya está en la lista de reproducción.";
        //echo '<div id="mensaje" style="text-align: center;"><script>mostrarMensaje("' . $mensaje. '");</script></div>';
        echo "La canción ya está en la lista de reproducción.";
        //echo '<script>window.opener.closeModal();</script>';
    } else {
        // Agregar la canción a la lista de reproducción
        $sqlAgregar = "INSERT INTO lista (idSong, idPlay) VALUES ($idSong,$playlistId)";
        if ($conn->query($sqlAgregar) === TRUE) {
           echo "Canción agregada a la lista de reproducción.";
        } else {
            echo "Error al agregar la canción a la lista de reproducción: ";
        }
    }

   
} else {
    echo "Datos incompletos";
}
 // Cerrar la conexión
    $conn->close();
?>