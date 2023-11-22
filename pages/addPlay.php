<?php
include("../utils/dbConnection.php");  
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo "Acceso no autorizado. Por favor, inicia sesión.";
    exit();
}
$userId = $_SESSION['id'];

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$songId = $_POST['idSong'];

// Validar datos antes de insertar en la base de datos (puedes agregar más validaciones según tus necesidades)
$sqlVerificar = "SELECT * FROM playlists WHERE nombre='$nombre' and user_id= $userId";
$resultVerificar = $conn->query($sqlVerificar);

if ($resultVerificar->num_rows > 0) {
    echo "El nombre ya existe. Por favor, elige otro.";
} else {
    // Agregar una nueva  lista de reproducción
    $sql = "INSERT INTO playlists (user_id, nombre, descripcion, imagen ) VALUES ('$userId', '$nombre','Lista de Reproduccion creada recientemente','playList/imagen/18.jpg')";

    if ($conn->query($sql) === TRUE) {
        // Recupera el último ID de la inserción
        $ultimoId = $conn->insert_id;
        // Agregar la canción a la lista de reproducción
        $sqlAgregar = "INSERT INTO lista (idSong, idPlay) VALUES ($songId,$ultimoId)";
        
        if ($conn->query($sqlAgregar) === TRUE) {
            echo "Inserción exitosa en ambas tablas";
        } else {
            echo "Error al insertar en la segunda tabla: " . $conn->error;
        }
        // Éxito
        //echo "Se registro correctamente";
    } else {
        echo "Error al insertar en la primera tabla base de datos: " . $conn->error;
    }
}

// Cerrar conexión
$conn->close();

?>