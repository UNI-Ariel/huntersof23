<!-- ./auth/editarperfil.php -->

<?php
include('./auth.php');  // Incluye el archivo de autenticación

if (!$authenticated) {  // Si no está autenticado, redirige a la página de inicio de sesión
    header("Location: ./login.php");
}

?>
<!-- ./auth/editarperfil.php -->

<!DOCTYPE html>
<html lang="es">
<head>

    <title>Editar Perfil - SpottPlay</title>
    <label for="newName">Nuevo Nombre:</label>
    <input type="text" id="newName" name="newName" required>

    

    <input type="submit" value="Guardar Cambios">
</form>
</head>
