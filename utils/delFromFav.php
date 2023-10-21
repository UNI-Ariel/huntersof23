<?php
// Incluye los archivos necesarios
include("./dbConnection.php");  // Incluye la conexión a la base de datos
include("../auth/auth.php");    // Incluye la autenticación (asegúrate de que esta inclusión sea necesaria)

// Verifica si se ha proporcionado un parámetro 'songID' a través de la URL
if (isset($_GET['songID'])) {
    $songID = $_GET['songID'];  // Obtiene el valor de 'songID' de la URL

    // Construye la consulta SQL para eliminar un registro de la tabla 'favourites'
    $addToFavQuery = "DELETE FROM favourites
                    WHERE favourites.uid=$uid and songID=$songID;";

    // Ejecuta la consulta en la conexión a la base de datos ($conn)
    if (mysqli_query($conn, $addToFavQuery)) {
        echo json_encode("Delete " . $songID);  // Devuelve una respuesta JSON exitosa
    } else {
        echo json_encode("Error " . mysqli_error($conn));  // Devuelve una respuesta JSON con un error en caso de fallo en la consulta SQL
    }
}

