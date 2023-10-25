<?php
session_start();

require 'config/dbConnection.php';

$sqlPlaylists = "SELECT id, nombre, descripcion FROM playlists AS p";
$playlists = $conn->query($sqlPlaylists);
$dir = "imagen/";
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>playList</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <style>
        .btn-primary {
    bs-btn-color: #fff;
    bs-btn-bg: while; 
    bs-btn-border-color: while;
        }
        /* Estilo personalizado para las tarjetas */
        .card {
            height: 345px;
            background-color: #f2e6cf; /* Cambia el color de fondo a azul */

        }
        .modal-content {
        background-color: #214252; /* Cambia el color de fondo del modal a azul */
        }
        .modal-content .modal-body {
        color: white; /* Cambia el color del texto a blanco */
        }
        .card-img-top {
            height: 150px;
            object-fit: cover;
        }
        /* Estilo personalizado para los botones */
     .btn-editar {
            background-color: #0799b6;
            color: white;
        }

        .btn-eliminar {
            background-color:#056496;
            color: white;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">

    <div class="container py-3">
        <h2 class="text-left" style="color: white;" >Mi Biblioteca</h2>
        <hr>

        <?php if (isset($_SESSION['msg']) && isset($_SESSION['color'])) { ?>
            <div class="alert alert-<?= $_SESSION['color']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['msg']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['color']);
            unset($_SESSION['msg']);
        } ?>

        <div class="row justify-content-end">
            <div class="col-auto">
                <br>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal"><i class="fa-solid fa-circle-plus"></i>Crear PlayList</a>
            </div>
        </div>

        <div class="row">
            <?php while ($row = $playlists->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                       
                    <td><img src="<?= $dir . $row['id'] . '.jpg?n=' . time(); ?>" width="345" style="height: 220px; width: 100%;"></td>

                        <div class="card-body">
                            <h5 class="card-title"><?= $row['nombre']; ?></h5>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-trash"></i> Eliminar</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include 'nuevoModal.php'; ?>
    <?php include 'editaModal.php'; ?>
    <?php include 'eliminaModal.php'; ?>


    <script>
        let nuevoModal = document.getElementById('nuevoModal')
        let editaModal = document.getElementById('editaModal')
        let eliminaModal = document.getElementById('eliminaModal')

        nuevoModal.addEventListener('shown.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #nombre').focus()
        })

        nuevoModal.addEventListener('hide.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #nombre').value = ""
            nuevoModal.querySelector('.modal-body #descripcion').value = ""
            nuevoModal.querySelector('.modal-body #imagen').value = ""

            
        })

        editaModal.addEventListener('hide.bs.modal', event => {
            editaModal.querySelector('.modal-body #nombre').value = ""
            editaModal.querySelector('.modal-body #descripcion').value = ""
            editaModal.querySelector('.modal-body #img_imagen').value = ""

        })

        editaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')

            let inputId = editaModal.querySelector('.modal-body #id')
            let inputNombre = editaModal.querySelector('.modal-body #nombre')
            let inputDescripcion = editaModal.querySelector('.modal-body #descripcion')
            let imagen = editaModal.querySelector('.modal-body #img_imagen')


            let url="getPlaylist.php"
            let formData = new FormData()
            formData.append('id', id)

            fetch(url, {
                    method: "POST",
                    body: formData
                }).then(response => response.json())
                .then(data => {

                    inputId.value = data.id
                    inputNombre.value = data.nombre
                    inputDescripcion.value = data.descripcion
                    imagen.src = '<?= $dir ?>' + data.id + '.jpg'


                }).catch(err => console.log(err))

        })

        eliminaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            eliminaModal.querySelector('.modal-footer #id').value = id

        })
       
    </script>
  
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <style>
    body {
        background-color: #214252;
    }
    table {
        background-color: #f1f1f1;
    }
     
</style>

</body>

</html>