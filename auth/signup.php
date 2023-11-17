<?php
include("../utils/dbConnection.php");
session_start();
if (isset($_SESSION['id'])) {
    header("Location: ../index.php");
}

$username = $email = $password = $re_password = "";
$errors = array('username' => '', 'password' => '', 'email' => '', 're_password' => '', "matchPass" => "", "existUser" => "");
if (isset($_POST['submit'])) {
    function cleanData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = cleanData($_POST['username']);
    $password = cleanData($_POST['password']);
    $email = cleanData($_POST['email']);
    $re_password = cleanData($_POST['re_password']);

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
    else
    {
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
    else
    {
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = "El correo ya existe";
        }
    }
    //Verificaciones de contraseña
    $allowed_spaces = 3;
    if($password === ""){
        $errors['password'] = "La contraseña esta vacia";
    }
    elseif(strlen($password) < 8 or strlen($password) > 20) {
        $errors['password'] = "La contraseña debe tener entre 8 y 20 caracteres";
    }
    elseif(substr_count($password, " ") > $allowed_spaces){
        $errors['password'] = "La contraseña no puede tener mas de " . $allowed_spaces . " espacios";
    }
    
    if (empty($re_password)) {
        $errors['re_password'] = "Confirme la contraseña";
    }
    elseif ($password !== $re_password) {
        $errors['re_password'] = "La contraseña no coincide";
    }

    if (array_filter($errors)) {
        echo "";
    } else {
        $password = md5($password);
        $sql2 = "INSERT INTO users(username, email, password, groupID) VALUE('$username', '$email', '$password', 2)";
        $result2 = mysqli_query($conn, $sql2);
        if ($result2) {
            /* header("Location: login.php"); */
            echo "<script> alert('Se registro exitosamente.') </script>";
            echo '<meta http-equiv="refresh" content="0;URL=\'login.php\'">';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="./css/iniciosesion.css">
</head>

<body>
    <form action="signup.php" method="post">
        <h2>Registro de usuario</h2>
        <p class="error-container"><?php echo $errors['matchPass']; ?></p>
        <p class="error-container"><?php echo $errors['existUser']; ?></p>
        <label>Nombre</label>
        <input class="<?php if ($errors['username'] != '') {
                        echo 'error1';
                        } ?>" 
        type="text" name="username" placeholder="(Mínimo 3 caracteres)" value="<?php echo $username; ?>">
        <p class="error-container"><?php echo $errors['username']; ?></p>
        
        <label>Correo</label>
        <input class="<?php if ($errors['email'] != '') {
                        echo 'error1';
                        } ?>" 
        type="text" name="email" placeholder="(Ejemplo: john@gmail.com)" value="<?php echo $email; ?>">
        <p class="error-container"><?php echo $errors['email']; ?></p>

        <label>Contraseña</label>
        <input class="<?php if ($errors['password'] != '') {
                        echo 'error1';
                        } ?>" 
        type="password" name="password" placeholder="(mínimo 8 caracteres)" value="<?php echo $password; ?>">
        <p class="error-container"><?php echo $errors['password']; ?></p>

        <label>Confirmar contraseña</label>
        <input class="<?php if ($errors['re_password'] != '') {
                        echo 'error1';
                        } ?>" 
        type="password" name="re_password" placeholder="(Confirmar Contraseña)">
        <p class="error-container"><?php echo $errors['re_password']; ?></p>
        <div class="show-pass-container">
            <div class="show-pass-checkbox">
                <input type="checkbox" id="show-pass">    
                Mostrar Contraseña
            </div>
        </div>

        <button type="submit" name="submit">Registrarse</button>
        <a href="..\index.php" class="ca">Cancelar</a>
    </form>
    <script src="./js/auth.js"></script>
</body>

</html>