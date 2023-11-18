<?php

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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #28324b;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 10px;
            background-color: #e4e5de;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 5px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        

        input[type="submit"] {
            background-color: #181c29;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #28324b;
        }

        input[type="button"] {
            background-color: #28324b;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>
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
            <a href="..\index.php" class="ca">Guardar</a>            
        </form>
    </div>
</body>

</html>
