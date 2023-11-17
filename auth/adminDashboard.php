<?php
include('./auth.php');

if (!$authenticated) {
    header("Location: ./login.php");
} else {
    if (!$admin) {
        header("Location: ./unauth.php");
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="./css/editSong.css">
</head>

<body>
    <a class="ca2" href="../index.php" style="margin: 10px 10px;"><strong>INICIO</strong></a>
    <div class="dashboard">
        <div class="icon-dashboard">
            <label>Usuarios</label>
            <a href="updateUser.php"><i class="fas fa-users fa-7x"></i></a>
        </div>

        <div class="icon-dashboard">
            <label>Músicas</label>
            <a href="editSong.php"><i class="fas fa-music fa-7x"></i></a>
        </div>

        <div class="icon-dashboard">
            <label>Artistas</label>
            <a href="editSinger.php"><i class="fas fa-microphone fa-7x"></i></a>
        </div>

    </div>



</body>
<script src="https://kit.fontawesome.com/6e6c14e530.js" crossorigin="anonymous"></script>

</html>