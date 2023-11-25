<?php
// Incluye los archivos necesarios
include("./dbConnection.php");  // Incluye la conexión a la base de datos
include("../auth/auth.php");    // Incluye la autenticación (asegúrate de que esta inclusión sea necesaria)

// Verifica si se ha proporcionado un parámetro 'songID' a través de la URL
if (isset($_GET['listaID'])) {
    $listID = $_GET['listaID'];  // Obtiene el valor de 'songID' de la URL

    // Construye la consulta SQL para eliminar un registro de la tabla 'favourites'
    $deleteList = "DELETE FROM lista
                    WHERE lista.idLista=$listID";

    // Ejecuta la consulta en la conexión a la base de datos ($conn)
    if (mysqli_query($conn, $deleteList)) {
        echo json_encode("Delete " . $listID);  // Devuelve una respuesta JSON exitosa
    } else {
        echo json_encode("Error " . mysqli_error($conn));  // Devuelve una respuesta JSON con un error en caso de fallo en la consulta SQL
    }
}