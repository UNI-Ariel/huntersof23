<?php
include('./auth.php');

if (!$authenticated) {
    header("Location: ./login.php");
} else {
    if (!$admin) {
        header("Location: ./unauth.php");
    }
}

include("../utils/dbConnection.php");
$sql = "SELECT * FROM songs";
$result = mysqli_query($conn, $sql);
$songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Musica</title>
    <link rel="stylesheet" href="./css/editSong.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Add your additional styles here */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="link">
            <a class="ca2" href="adminDashboard.php">Atrás</a>

        </div>

        <div style="float: right; margin-right: 20px; margin-top: -70px;">
    <a style="padding: 10px; background-color: #0799B6; color: #fff; border-radius: 15px; text-decoration: none;" href="insertSong.php">Registrar Música</a>
         </div>

        
        <h2>Lista De Musicas</h2>
        <table align="center" border="1"  class="displaySong">
            <tr>
                <th>No</th>
                <th>Imagenes</th>
                <th>Nombre</th>
                <th>Archivo de Musica</th>
                <th colspan="3">Acciones</th>
            </tr>

            <?php foreach ($songs as $index => $song) : if ($index == 5) break; ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><img style="width: 50px; height: 50px;" src="<?php echo '../' . $song['imgPath'] ?>"></td>
                    <td><?php echo $song['title']; ?></td>
                    <td><?php echo $song['filePath']; ?></td>
                    <td><a style="padding: 5px; background-color:rgb(7, 153, 182); color: #fff; border-radius: 15px;text-decoration: none;" href="insertSong.php?id=<?php echo $song['id'] ?>">Editar</a></td>
                    <td><a style="padding: 5px; background-color: #6B0000; color: #fff; border-radius: 15px; text-decoration: none;" href="deleteSong.php?id=<?php echo $song['id'] ?>">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="paginationButton">
            <ul style="display: flex; list-style-type: none; color: black; margin: 0 auto; justify-content: center;">
                <li onclick="previousPage();" style="padding: 10px; color: white;">&lt;</li>
                <li onclick="pagination(1);" style="padding: 10px; color: white;" value="1">1</li>
                <li onclick="pagination(2);" style="padding: 10px; color: white;" value="2">2</li>
                <li onclick="pagination(3);" style="padding: 10px; color: white;" value="3">3</li>
                <li onclick="nextPage();" style="padding: 10px; color: white;">&gt;</li>
            </ul>
        </div>
    </div>

</body>
<script type="text/javascript">
        let currentPage = 1; // Variable para almacenar la página actual

    function previousPage() {
        if (currentPage > 1) {
        currentPage--;
        pagination(currentPage);
        }
    }

    function nextPage() {
        // Aquí necesitas conocer la cantidad total de páginas para evitar avanzar más allá de la última página
        let totalPages = 3; // Por ejemplo, asumamos que hay 3 páginas en total
        if (currentPage < totalPages) {
            currentPage++;
            pagination(currentPage);
        }
    }
    function pagination(value) {
        let header = `<tr>
            <th colspan="6">SONGS INFO</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Images</th>
            <th>Name</th>
            <th>Music File</th>
            <th colspan="3">Operations</th>
        </tr>`
        let displaySong = document.getElementsByClassName("displaySong")[0];
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let results = JSON.parse(this.responseText);;

                let html = '';
                displaySong.innerHTML = header;

                results.map((value, index) => {
                    html +=
                        ` <tr>
                    <td> ${index + 1}</td>
                    <td><img style="width: 50px; height: 50px;" src='../${value['imgPath']}'></td>
                    <td>${value['title']}</td>
                    <td>${value['filePath']}</td>
                    <td><a style="padding: 5px; background-color: #66FF33; color: #fff; border-radius: 15px; text-decoration: none;" href="insertSong.php?id=${value['id']}">Update</a></td>
                    <td><a style="padding: 5px; background-color: #E3242B; color: #fff; border-radius: 15px; text-decoration: none;" href="deleteSong.php?id=${value['id']}">Delete</a></td>
                    </tr>`
                })
                displaySong.innerHTML += html;
            }
        };
        xhttp.open("GET", "paginationSong.php?page=" + value, true);
        xhttp.send();
    }
</script>



</html>