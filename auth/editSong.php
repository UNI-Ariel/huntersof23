<?php
include('./auth.php');
include("../utils/dbConnection.php");

if (!$authenticated) {
    header("Location: ./login.php");
} else {
    if (!$admin) {
        header("Location: ./unauth.php");
    }
}
// Consulta para obtener el número total de canciones
$countQuery = "SELECT COUNT(*) as total FROM songs";
$countResult = mysqli_query($conn, $countQuery);
$countData = mysqli_fetch_assoc($countResult);
$totalSongs = $countData['total'];

// Define la cantidad de canciones por página
$perPage = 5; // Cantidad de canciones que deseas mostrar por página

$totalPages = ceil($totalSongs / $perPage); // Calcula el número total de páginas



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

        
        <h2>Lista de Músicas</h2>
        <table align="center" border="1"  class="displaySong">
            <tr>
                <th>No</th>
                <th>Imagenes</th>
                <th>Nombre</th>
                <th>Archivo de Música</th>
                <th colspan="3">Acciones</th>
            </tr>

            <?php foreach ($songs as $index => $song) : if ($index == 5) break; ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><img style="width: 50px; height: 50px;" src="<?php echo '../' . $song['imgPath'] ?>"></td>
                    <td><?php echo $song['title']; ?></td>
                    <td><?php echo $song['filePath']; ?></td>
                    <td><a style="padding: 5px; background-color:rgb(7, 153, 182); color: #fff; border-radius: 15px;text-decoration: none;" href="insertSong.php?id=<?php echo $song['id'] ?>">Editar</a></td>
                   <!-- <td><a style="padding: 5px; background-color: #6B0000; color: #fff; border-radius: 15px; text-decoration: none;" href="deleteSong.php?id=<?php echo $song['id'] ?>">Eliminar</a></td>  -->
                    <!-- Dentro del bucle foreach en editSong.php -->
                  <td><a style= "padding: 5px; background-color: #6B0000;  color: #fff; border-radius: 15px; text-decoration: none; cursor: pointer;"  onclick="openModal()"  >Eliminar</a></td>

                </tr>

            <?php endforeach; ?>
        </table>
        <div class="paginationButton">
            <ul style="display: flex; list-style-type: none; color: black; margin: 0 auto; justify-content: center;">
                <li onclick="previousPage();" style="padding: 10px; color: white;">&lt;</li>
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li onclick="pagination(<?php echo $i; ?>);" style="padding: 10px; color: white;" value="<?php echo $i; ?>"><?php echo $i; ?></li>
                <?php endfor; ?>
                <li onclick="nextPage();" style="padding: 10px; color: white;">&gt;</li>
            </ul>
        </div>
    </div>
    <span id="totalPages" style="display: none;"><?php echo $totalPages; ?></span>

<script type="text/javascript">
        let currentPage = 1; // Variable para almacenar la página actual
        let pagesData = {}; // Objeto para almacenar los datos de cada página
    
        function previousPage() {
        if (currentPage > 1) {
        currentPage--;
        pagination(currentPage);
        }
    }

    function nextPage() {
        // Aquí necesitas conocer la cantidad total de páginas para evitar avanzar más allá de la última página
        
        if (currentPage < <?php echo $totalPages;?>) {
            currentPage++;
            displayPageData(currentPage);
        }

    }


    function pagination(value) {
            currentPage = value;
            displayPageData(value);
        }

        function displayPageData(value) {
            // Verificar si los datos de la página ya han sido cargados previamente
            if (!pagesData[value]) {
                // Si los datos de la página no están disponibles, realizar una solicitud AJAX para obtenerlos
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let results = JSON.parse(this.responseText);
                        pagesData[value] = results; // Almacenar los datos en el objeto pagesData

                        // Llamar a una función para mostrar los datos en la tabla
                        renderPageData(results);
                    }
                };
                xhttp.open("GET", "paginationSong.php?page=" + value, true);
                xhttp.send();
            } else {
                // Si los datos de la página ya están disponibles en pagesData, mostrarlos directamente
                renderPageData(pagesData[value]);
            }
        }




    function renderPageData(results) {
        let header = `
        <tr>
            <th colspan="6"></th>
        </tr>
        <tr>
            <th>No</th>
            <th>Imagenes</th>
            <th>Nombre</th>
            <th>Archivo de Música</th>
            <th colspan="3">Acciones</th>
        </tr>`;
        let displaySong = document.getElementsByClassName("displaySong")[0];

        let html = '';
        displaySong.innerHTML = header;

        results.map((value, index) => {
        html +=
            ` <tr>
                <td> ${index + 1}</td>
                    <td><img style="width: 50px; height: 50px;" src='../${value['imgPath']}'></td>
                    <td>${value['title']}</td>
                    <td>${value['filePath']}</td>
                    <td><a style="padding: 5px; background-color:rgb(7, 153, 182); color: #fff; border-radius: 15px;text-decoration: none;" href="insertSong.php?id=<?php echo $song['id'] ?>">Editar</a></td>
                    <td><a style="padding: 5px; cursor: pointer; background-color: #6B0000; color: #fff; border-radius: 15px; text-decoration: none;"onclick="openModal()"  >Eliminar</a>
</td>
                    </tr>`;
        });
        displaySong.innerHTML += html;
    }
        
</script>
</body>
<!-- Dentro del body en editSong.php -->
<div id="confirmDeleteModal" class="modal">
<div class="modal-content" style="width: 10cm; height: 4cm; background-color: #28324b; color: white;">
        
      <!--  <span class="close" onclick="closeModal()">&times;</span>  -->
        <p>¿Estás seguro de eliminar este elemento de tu lista?</p>
        <div class="modal-buttons" style="margin-top: 1cm;" >
              <button onclick="deleteSong()" style="cursor: pointer; background-color: #6B0000; color: white;">Aceptar</button>
             <button onclick="closeModal()" style=" cursor: pointer; background-color: #0799B6; color: white;">Cancelar</button>
        </div>
    </div>
</div>

<!-- Agrega el script al final del body para manipular el modal -->
<script>
    function openModal() {
        document.getElementById('confirmDeleteModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('confirmDeleteModal').style.display = 'none';
    }

    function deleteSong() {
        // Aquí puedes redirigir a deleteSong.php para eliminar la canción
        window.location.href = 'deleteSong.php?id=<?php echo $song['id']; ?>';
    }
</script>


</html>