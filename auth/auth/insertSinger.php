<?php
include('./auth.php');
error_reporting(0);
if (!$authenticated) {
    header("Location: ./login.php");
} else {
    if (!$admin) {
        header("Location: ./unauth.php");
    }
}

include("../utils/dbConnection.php");



$name = $infoSinger = $imgFile = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM singers WHERE id= '$id' ";
    $res2 = mysqli_query($conn, $sql2);
    $data = mysqli_fetch_array($res2);
    $name = $data["name"];
    $imgFile = "../" . $data["image"];
    $infoSinger = $data["info"];
}

function cleanData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

$errors1 = array('singername' => '');
$errors2 = array('info' => '');
$errors3 = array('img' => '');
$errors = array('singername' => '','info' => '','img' => '');
$singername = $img = $info = '';

$singername2 = cleanData($_POST['singername']);
$info2 = cleanData($_POST['info']);
$allowed_spaces = 3;
$allowed_numbers = 3;
$allowed_numbers2 = 4;


// INSERT SINGER INTO DATABASE
function saveFile($fileInfo)
{
    $filename = $fileInfo['name'];

    $tmpPath = $fileInfo['tmp_name'];
    $destinationPath = 'images/singers/' . $filename;

    if (move_uploaded_file($tmpPath, '../' . $destinationPath)) {
        echo "<script> alert('Se registro exitosamente.') </script>";

    } else {
        echo "Error de Registro";
    }

    return $destinationPath;
}




if (isset($_POST['submit'])) {
    
    
    if (empty($_FILES["img"]["name"])) {
        if (!isset($_GET['id']))
            $errors['img'] = "Imagen no puede estar vacio porfavor elija un archivo";
    } else {
        if (strpos($_FILES["img"]["type"], "image") !== false) {
            $img = $_FILES['img'];
        } else {
            $errors['img'] = "Formato Incorrecto!!.";
        }
    }

    if (empty($_POST['singername'])) {
        $errors['singername'] = "Nombre de artista no puede estar vacio";
    } else {
        if(strlen($singername2) < 3 or strlen($singername2) > 20) {
            $errors['singername'] = "El nombre debe tener entre 3 y 20 caracteres";
        }
        else{
            if(substr_count($singername2, "1") or substr_count($singername2, "2")or substr_count($singername2, "3")or substr_count($singername2, "4")or substr_count($singername2, "5")or substr_count($singername2, "6")or substr_count($singername2, "7")or substr_count($singername2, "8")or substr_count($singername2, "9")or substr_count($singername2, "0"))
            {
            $allowed_numbers++;    
            }
            else{

            }
            if(substr_count($singername2, " ") > $allowed_spaces){
                $errors['singername'] = "El nombre no puede tener mas de 3 espacios";
            }
            else{
                if($allowed_numbers > 3){
                    $errors['singername'] = "El nombre no puede tener mas de 3 numeros";
                }
                else{          
                $singername = $_POST['singername'];
                }
            }
        }
    }

    
    if (empty($_POST['info'])) {
        $errors['info'] = "Información no puede estar vacio";
    } else {
        if(strlen($info2) < 3 or strlen($info2) > 100) {
            $errors['info'] = "La Informacion del Artista debe tener en 5 y 100 caracteres, tenga en cuenta que los espacios cuentan como un caracter";
        }
        else{
            if(substr_count($info, "1") or substr_count($info, "2")or substr_count($info, "3")or substr_count($info, "4")or substr_count($info, "5")or substr_count($info, "6")or substr_count($info, "7")or substr_count($info, "8")or substr_count($info, "9")or substr_count($info, "0"))
            {
            $allowed_numbers2++;    
            }
            else{

            }
            
            
                if($allowed_numbers2 > 3){
                    $errors['info'] = "El la información no puede tener mas de 4 numeros";
                }
                else{          
                    $info = $_POST['info'];
                }
            
        }
        
    }


    if (array_filter($errors)) {
        echo 'Formato no valido';
    } else {
        if ($img != "")
            $images = saveFile($img);
        else
            $images = $data["image"];



        //IF GET ID -> UPDATE IT
        if (isset($_GET['id'])) {
            $updateSinger = "UPDATE singers SET name = '$singername', info = '$info', image = '$images' WHERE id =$id";
            $res3 = mysqli_query($conn, $updateSinger);
            echo "<script> alert('Se registro exitosamente.') </script>";

            header("Location: editSinger.php");
        } else {
            $insertSinger = "INSERT INTO singers(name, info, image)
            VALUES ('$singername', '$info', '$images')";
            echo "<script> alert('Se registro exitosamente.') </script>";

            if (!mysqli_query($conn, $insertSinger)) {
                echo  "Error: " . "<br>" . mysqli_error($conn);
            } else {
                echo "<script> alert('Se registro exitosamente.') </script>";

                header("Location: editSinger.php");
            }
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
    <title>Registrar Artista</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <form method="POST" enctype="multipart/form-data">
    
        <h2>Registrar Artista</h2>

        <label>Nombre</label>
        <input type="text" name="singername" placeholder="Nombre" value="<?php echo $name; ?>">
        
            <p class="error"><?php echo $errors['singername']; ?></p>
        
        <label>Descripción</label><br>
        <textarea style=" margin: 10px; width: 360px; height: 164px; border: 2px solid #ccc; border-radius: 5px;" name="info" type="text" placeholder=" Descripción del artista"><?php echo $infoSinger; ?></textarea>
        <p class="error"><?php echo $errors['info']; ?></p>
        <?php if ($imgFile != "") : ?>
            <label>Currrent Imagen</label>
            <img style="width: 50px; height: 50px;" src="<?php echo $imgFile; ?>" alt="">
            <br>
        <?php endif; ?>
        <label>Imagen</label>
        <input type="file" name="img" accept=".jpg, .jpeg, .png"> 
        <p class="error"><?php echo $errors['img']; ?></p>

        <a href="editSinger.php" class="ca">Atras</a>

        <button type="submit" name="submit">Registrar</button>
    </form>
</body>

</html>