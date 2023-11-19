<?php
include('./auth.php');
include("../utils/dbConnection.php");

//$name = $infoSinger = $imgFile = "";
$sql = "SELECT username, email, userImg FROM users WHERE id = $uid";
$resultado = mysqli_query($conn, $sql);
if ($resultado) {
    $fila = mysqli_fetch_assoc($resultado);
    $usernameActual = $fila['username'];
    $emailActual = $fila['email'];
    $imgUserActual = $fila['userImg'];
} else {
    // Manejar errores de la consulta
    die("Error: " . mysqli_error($conn));
}

$errors = array('username' => '', 'email' => '');
if (isset($_POST['submit'])) {
    function cleanData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = cleanData($_POST['username']);
    $email = cleanData($_POST['email']);

    //Verificaciones del nombre de usuario
    if($username === ""){
        $errors['username'] = "El nombre esta vacio";
    }
    elseif(strlen($username) < 3 or strlen($username) > 20) {
        $errors['username'] = "El nombre debe tener entre 3 y 20 caracteres";
    }
    elseif (!ctype_alnum($username))
    {
        $errors['username'] = "El nombre no puede contener caracteres especiales ni espacios";
    }
    elseif ($usernameActual != $username){
        $sql = "SELECT * FROM users WHERE username = '$username' ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $errors['username'] = "El usuario ya existe";
        }
    }

    //Verificaciones del correo
    $valid_emails = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];
    if($email === ""){
        $errors['email'] = "EL correo esta vacio";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "EL correo es inválido";
    }
    elseif(!in_array(explode("@", $email)[1], $valid_emails) ){
        $errors['email'] = "EL correo es inválido";
    }
    elseif ($emailActual != $email){
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = "El correo ya existe";
        }
    }

    if (array_filter($errors)) {
        echo "";
    } else {
        $updatePerfil = "UPDATE users SET username = '$username', email = '$email' WHERE id =$uid";
        $res3 = mysqli_query($conn, $updatePerfil);
        echo '<meta http-equiv="refresh" content="0;URL=\'editProfile.php?user=' . $uid . '\'">';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="./css/iniciosesion.css">
</head>
<body>
    <div class="container">
        <form action="editProfile.php" method="post">
            <h2>Editar Perfil</h2>

            <label for="nuevoNombre">Nuevo Nombre:</label>
            <input class="<?php if ($errors['username'] != '') {
                        echo 'error1';
                        } ?>" 
            type="text" name="username" placeholder="(Mínimo 3 caracteres)" value="<?php echo $usernameActual; ?>" required>
            <p class="error-container"><?php echo $errors['username']; ?></p>

            <label for="nuevoemail">Nuevo Correo:</label>
            <input class="<?php if ($errors['email'] != '') {
                        echo 'error1';
                        } ?>" 
            type="text" name="email" placeholder="(Ejemplo: john@gmail.com)" value="<?php echo $emailActual; ?>" required>
            <p class="error-container"><?php echo $errors['email']; ?></p>

            <a href="../index.php" class="ca">Cancelar</a>
            <button type="submit" name="submit">Guardar</button>        
        </form>
    </div>     
</body>

</html>