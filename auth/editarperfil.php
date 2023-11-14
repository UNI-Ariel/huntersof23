<!-- ./auth/editarperfil.php -->

<?php
include('./auth.php');  // Incluye el archivo de autenticación

if (!$authenticated) {  // Si no está autenticado, redirige a la página de inicio de sesión
    header("Location: ./login.php");
} else {
    if (!$Username) {  
        header("Location: ./unauth.php");
    }
}
<form action="./auth/handle-edit-profile.php" method="post">
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


