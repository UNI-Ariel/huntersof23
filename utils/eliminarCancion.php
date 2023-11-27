
<?php
include("../utils/dbConnection.php");
include("../auth/auth.php");
$conn = new mysqli('localhost', 'root', '', 'myspotplay');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idSong']) && isset($_POST['idPlay'])) {
        $idSong = $_POST['idSong'];
        $idPlay = $_POST['idPlay'];

        // Eliminar la canción de la lista de reproducción en la base de datos
        $deleteQuery = "DELETE FROM lista WHERE idSong = $idSong AND idPlay = $idPlay";
        $result = mysqli_query($conn, $deleteQuery);

        if ($result) {
            // La eliminación fue exitosa
            //echo json_encode(['success' => true]);
            $response=['success'=>true, 'reload'=>true];
            echo json_encode($response);
        } else {
            // Hubo un error en la eliminación
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
    } else {
        // Datos insuficientes
        echo json_encode(['success' => false, 'error' => 'Datos insuficientes']);
    }
} else {
    // Método de solicitud incorrecto
    echo json_encode(['success' => false, 'error' => 'Método de solicitud incorrecto']);
}
?>
