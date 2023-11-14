<!-- ./auth/editarperfil.php -->



<?php
// Incluye los archivos necesarios
include("../utils/dbConnection.php");
include("../auth/auth.php");

// Verifica si el usuario está autenticado
if (!$authenticated) {
    // Redirige si el usuario no está autenticado
    redirect("../index.php");
}
    <label for="newName">Nuevo Nombre:</label>
    <input type="text" id="newName" name="newName" required>

    

    <input type="submit" value="Guardar Cambios">
</form>
?>
<!-- ./auth/editarperfil.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Asegúrate de incluir las etiquetas meta y enlaces a CSS necesarios -->
    <title>Editar Perfil - SpottPlay</title>
</head>


