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
$sql = "INSERT INTO playlist (nomPlay, desPlay, imgPlay, idUser ) VALUES ('$nombre', 'Lista de Reproduccion creada recientemente','playList/imagen/18.jpg',$userId)";

if ($conn->query($sql) === TRUE) {
    // Éxito
    echo json_encode(['status' => 'success', 'message' => 'Datos insertados con éxito']);
} else {
    // Error
    echo json_encode(['status' => 'error', 'message' => 'Error al insertar datos: ' . $conn->error]);
}

// Cerrar conexión
$conn->close();

?>