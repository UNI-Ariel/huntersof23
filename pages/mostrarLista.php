<?php
include("../utils/dbConnection.php");  
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo '<link rel="stylesheet" type="text/css" href="css/ocultar.css">';
    echo "<p style='text-align: center;'>Acceso no autorizado. Por favor, inicia sesión.</p>";
    exit();
}
$userId = $_SESSION['id'];

if (isset($_POST['id'])) {
    $songId= $_POST['id'];
    
// Consulta SQL para obtener datos de la tabla de playlists
$sqlLista = "SELECT p.id, p.imagen, p.nombre, COUNT(l.idPlay) AS cantidad FROM playlists p LEFT JOIN lista l ON p.id = l.idPlay WHERE p.user_id = $userId GROUP BY p.id, p.nombre";

$resultCancion = $conn->query($sqlLista);

if ($resultCancion->num_rows > 0) {
   // $rowCancion = $resultCancion->fetch_assoc();
    while ($rowCancion = $resultCancion->fetch_assoc()) {
    // Imprimir la información adicional de la canción
    $imagen = !empty($rowCancion['imagen']) ? $rowCancion['imagen'] : 'images/default/playlist.jpg';
    echo '<div class="card-header" data-valor="' . htmlspecialchars($rowCancion["id"]) . '" onclick="registrarCancion(this)" >';
    echo'<div class="card-body">';
    echo '<img src="' . $imagen .'">';
    echo '</div>';
    echo '<div class="card-body">';
    echo '<p>'. $rowCancion["nombre"].'</p>';
    echo '<p>Canciones: '. $rowCancion["cantidad"] .'</p>';
    echo '</div></div>';
    }
} 
else{
    echo "<p style='text-align: center;'>No tienes Listas Creadas.</p>";
}
}
else {
    echo "Error al recuperar el id de la cancion";
}
 // Cerrar la conexión
 $conn->close();
?>
<script>
   function registrarCancion(elemento){
            var songId =<?php echo json_encode($songId); ?>;
            console.log("Valor de la cancion: " + songId);
            var playId = elemento.dataset.valor;
            console.log("Valor de data-valor: " + playId);
            // Hacer una solicitud AJAX para agregar la canción a la lista de reproducción
            $.ajax({
                type: 'POST',
                url: 'pages/agregar_a_lista.php',
                data: { idSong: songId, idPlay: playId },
                success: function (data) {
                    //alert(data);
                    $('#myModal').hide();
                    mostrarMensajeTemporal(data, 3000);
                   
                },
                error: function () {
                    alert('Error al agregar la canción a la lista de reproducción.');
                }
            });
    }
    function mostrarMensajeTemporal(mensaje, tiempo) {
            var div = document.createElement('div');
            div.textContent = mensaje;
            div.className = 'mensaje-temporal';
            document.body.appendChild(div);

            setTimeout(function () {
                div.style.opacity = '0';
                setTimeout(function () {
                    document.body.removeChild(div);
                }, 1000);
            }, tiempo);
    }


</script>