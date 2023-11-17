<?php

include('./auth.php');

if (!$authenticated) {
    header("Location: ./login.php");
    
} 
include("../utils/dbConnection.php");


//$name = $infoSinger = $imgFile = "";
//$id_user = $_REQUEST['user'];
$id_user = $uid;
$sql = "SELECT username, email, userImg FROM users WHERE id = $id_user";
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



if (isset($_POST['submit'])) {
    if (empty($_FILES["userImg"])) {
        if (!isset($_GET['id']))
            $errors['userImg'] = "Image field cannot be empty";
    } else {
        if (strpos($_FILES["userImg"]["type"], "image") !== false) {
            $userimg = $_FILES['userImg'];
        } else {
            $errors['userImg'] = "Wrong file format. Expect an image file. Please check your file again.";
        }
    }

    if (empty($_POST["username"])) {
        $errors["username"] = "Singer's name can not be empty";
    } else {
        $username = $_POST["username"];
    }

    if (empty($_POST["email"])) {
        $errors["email"] = "Info can not be empty";
    } else {
        $email = $_POST["email"];
    }


    if (array_filter($errors)) {
        echo 'Form not valid';
    } else {
        if ($userimg != "")
            $userimg = saveFile($userimg);
        else
            $userimg = $data["username"];



        //IF GET ID -> UPDATE IT
        if (isset($_GET['id'])) {
            $updatePerfil = "UPDATE users SET username = '$username', email = '$email', userImg = '$userimg' WHERE id =$id_user";
            $res3 = mysqli_query($conn, $updatePerfil);
            header("Location: index.php");
        } else {//creo que esto borrare
            $insertSinger = "INSERT INTO singers(name, info, image)
            VALUES ('$singername', '$info', '$images')";
            if (!mysqli_query($conn, $insertSinger)) {
                echo  "Error: " . "<br>" . mysqli_error($conn);
            } else {
                header("Location: index.php");
            }
        }//hast aqui
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Singer</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <h1>Editar Perfil</h1>

        <form action="editarPerfil.php" method="post" enctype="multipart/form-data">
            <label for="nuevoNombre">Nuevo Nombre:</label>
            <input type="text" id="nuevoNombre" name="nuevoNombre" value="<?php echo $usernameActual; ?>" required>

            <label for="nuevoemail">Nuevo Correo:</label>
            <input type="email" id="nuevoemail" name="nuevoemail" value="<?php echo $emailActual; ?>" required>

            <label for="imagenActual">Imagen Actual:</label>
            <img src="directorio_destino/<?php echo $imagenActual; ?>" alt="Imagen Actual">

            <label for="nuevaImagen">Cambiar Imagen:</label>
            <input type="file" id="nuevaImagen" name="nuevaImagen">

            <a href="..\index.php" class="ca">Cancelar</a>
            <input type="submit" name="submit" value="Guardar Cambios">
            
            
        </form>
    </div>
</body>

</html>