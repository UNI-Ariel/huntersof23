<?php
include("../utils/dbConnection.php");
session_start();
if (isset($_SESSION['id'])) {
    header("Location: ../index.php");
}
$username = $password = "";
$errors = array('username' => '', 'password' => '');

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

    if (empty($username)) {
        $errors['username'] = "Nombre de usuario Vacio";
    }

    if (empty($password)) {
        $errors['password'] = "Contraseña vacia";
    } else {
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username && $row['password'] === $password) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['admin'] = ($row['groupID'] == 1) ? true : false;

                header("Location: ../index.php");
                exit();
            } else {
                $errors['password'] = "Nombre de Usuario o Contraseña incorrectos";
            }
        } else {
            $errors['username'] = "Nombre de Usuario o Contraseña incorrectos";
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
    <title>Login</title>
    <link rel="stylesheet" href="./css/iniciosesion.css">

</head>

<body>
    <form action="login.php" method="post">
        <h2>INICIAR SESIÓN</h2>
        <label>Nombre de Usuario</label>
        <input class="<?php if ($errors['username'] != '') {
                        echo 'error1';
                        } ?>" 
        type="text" name="username" placeholder="Ejemplo : Noel" value="<?php echo $username; ?>">
        <p class="error-container"><?php echo $errors['username']; ?></p>

        <label>Contraseña</label>
        <input class="<?php if ($errors['password'] != '') {
                        echo 'error1';
                        } ?>"
         type="password" name="password" placeholder="Contraseña">
        <p class="error-container"><?php echo $errors['password']; ?></p>

        <button type="submit" name="submit">Iniciar Sesión</button>
        <a href="signup.php" class="ca">Crear cuenta</a>
    </form>
</body>

</html>