<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include("./utils/getUrl.php");  // Incluye un archivo de utilidad para obtener la URL actual.
include("./utils/dbConnection.php");  // Incluye un archivo de utilidad para establecer la conexión a la base de datos.
include("./auth/auth.php");  // Incluye un archivo relacionado con la autenticación de usuarios.
function redirect($url)
{
    echo "<script type='text/javascript'>document.location.href='{$url}';</script>";  // Redirige a una URL mediante JavaScript.
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $url . '">';  // También redirige mediante una etiqueta META.
}

$getAllSongsQuery = "SELECT songs.id, songs.title title,
                            songs.filePath audio, songs.imgPath img,
                            singers.name singerName, singers.id singerID
                    FROM songs 
                    LEFT JOIN singers on singers.id = songs.singerID
                    ORDER BY songs.dateAdded DESC";  // Consulta SQL para obtener información de canciones.

$result = mysqli_query($conn, $getAllSongsQuery);  // Ejecuta la consulta en la base de datos.
$songs = mysqli_fetch_all($result, MYSQLI_ASSOC);  // Obtiene un arreglo asociativo con los resultados.

// Genera claves aleatorias para seleccionar canciones al azar.
$randomKeys = (count($songs) >= 3) ? array_rand($songs, 3) : $songs;

$formatSongs = array();

foreach ($songs as $song) {
    $formatSongs[$song["id"]] = $song;  // Formatea las canciones en un arreglo asociativo.
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/homePage.css">
    <link rel="stylesheet" href="./css/singerPage.css">
    <link rel="stylesheet" href="./css/searchPage.css">
    <link rel="stylesheet" href="./css/favourite.css">
    <link rel="stylesheet" href="./css/playlists.css">
    <link rel="stylesheet" href="./css/play.css">
    <link rel="icon" href="./favicon.png">
    <!--<link href='https://css.gg/home.css' rel='stylesheet'>-->

    <!-- Librería jQuery para utilizar AJAX que permite actualizar dinámicamente porciones de HTML -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>SpottPlay</title>
</head>

<body>
    <div class="login-modal">
        <div class="login-modal__logo">
            <img src="./favicon.png" alt="..." width="125", height="150">
            <h2>SpottPlay</h2>
        </div>
        <div class="login-modal__info">
            <p>Tienes que iniciar sesión para utilizar esta función.</p>
            <a href="./auth/login.php" class="login">Acceso</a>
            <a href="./auth/signup.php" class="signup">¿Aún no has creado una cuenta?</a>
            <div class="close">+</div>
        </div>
    </div>
    <div class="container">
        <div class="content">
            <?php #Incluir Barra Lateral
                include("./components/sidebar.php"); 
            ?>
            <?php 
                #Fin barra Lateral 
                #Inicio Music UI
            ?>
            <div class="musicContainer" id="home">
                <?php #Incluye el contenido de la página de inicio
                    include("./pages/homeContent.php"); ?>
            </div>
            <div class="musicContainer hide" id="favourites">
                <?php if ($authenticated) : ?>
                    <?php #Incluye el contenido de la página de favoritos si el usuario está autenticado
                        include("./pages/favContent.php"); ?>
                <?php endif; ?>
            </div>
            <div class="musicContainer hide" id="search">
                <?php #Incluye el contenido de la página de búsqueda.
                    include("./pages/searchContent.php"); ?>
            </div>
            <div class="musicContainer hide" id="singer">
                <?php #Incluye el contenido de la página de cantantes.
                    include("./pages/singerContent.php"); ?>
            </div>
            <!----------implementando por mari----->
            <div class="musicContainer hide" id="lista">
                <?php #Incluye el contenido de la página de cantantes.
                    include("./pages/listContent.php"); ?>
            </div>
            <!----------implementando por mari----->
            <div class="musicContainer hide" id="playlists">
                <?php if ($authenticated) : ?>
                    <?php #Incluye el contenido de la página de playlist si el usuario está autenticado.
                        include("./pages/playlistContent.php"); ?>
                <?php endif; ?>
            </div>
            <?php #End Music UI ?>
        </div>
        <?php #Music Player ?>
        <?php #Incluye un componente de reproductor de música.
            include("./components/musicPlayer.php"); ?>
    </div>
</body>
<script>
    let songDetails = JSON.parse('<?php echo json_encode($formatSongs); ?>');  // Convierte los detalles de la canción en un objeto JavaScript.
    let authenticated = JSON.parse('<?php echo json_encode($authenticated); ?>');  // Convierte el estado de autenticación en un valor JavaScript.
</script>
<script src="./js/songTile.js"></script>
<script src="./js/playingQueue.js"></script>
<script src="./js/loginRequired.js"></script>
<script src="./js/recentPlaylist.js"></script>
<script src="./js/main.js"></script>
<?php if ($authenticated) : ?>
    <script src="./js/favourite.js"></script>  <?php #Incluye un script JavaScript si el usuario está autenticado. ?>
<?php endif; ?>
<?php include("./utils/changePageJs.php"); ?>  <!-- Incluye un archivo de utilidad para cambiar la página en JavaScript. -->







<!-------------------------------------------------------------------------->
 <!-- Modal1 -->
 <div id="myModal" class="modal">
    <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <button class="open-modal-button" onclick="openModal2()">Agregar nuevo</button>
      <div id="modalContent">
      
      </div>
    </div>
  </div>

 <!-- Modal2 -->
 <div id="myModal2" class="modal">
    <div class="modal-content">
    <span class="close" onclick="closeModal2()">&times;</span>
      <div id="modalContent2">
      <form id="formularioP">
        <label for="nombre">Ponle nombre a tu Lista de Reproduccion</label> 
        <input type="text" id="nombreP" name="nombreP"minlength="2" maxlength="30" pattern="[a-zA-Z0-9]+" title="Solo se permiten caracteres alfanuméricos" required>
        <span style="color: red;" class="error" id="error"></span>
        <!-- Agrega más campos según tus necesidades -->
        <button style="background-color: #979a9e; color: white;  border: none; border-radius: 5px; cursor: pointer; width: 25%; " onclick="closeModal2()">Cancelar</button>
        <button style="background-color: #266882; color: white;  border: none; border-radius: 5px; cursor: pointer; width: 25%; " type="button" onclick="insertarDatos()">Aceptar</button>
      </form>
      </div>
    </div>
  </div>


  <!-- JavaScript (index.php) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
  var datoAlmacenado;
  function openModal(button) {
    var modal = document.getElementById('myModal');
    var dataId = button.getAttribute('data-songid');

// Puedes hacer lo que quieras con el valor data-id, por ejemplo, imprimirlo
    console.log("ID del botón: " + dataId);
    datoAlmacenado = dataId;
            // Hacer una solicitud AJAX para obtener información adicional de la canción
            $.ajax({
                type: 'POST',
                url: 'pages/mostrarLista.php',
                data: { id: dataId },
                success: function (data) {
                  //console.log(data);
                    // Mostrar los resultados en la ventana modal
                    $('#modalContent').html(data);
                   // $('#myModal').modal('show');
                },
                error: function () {
                    alert('Error al obtener la información de la canción.');
                }
            });
   modal.style.display = 'block';

 }
 function openModal2() {
    //var modal = document.getElementById('myModal2');
    $('#myModal').hide();
    // Muestra el dato en el segundo modal
    //$('#dato').text(datoAlmacenado);
    $('#myModal2').show();
    //alert("Dato usado en otra función: " + datoAlmacenado);

 }
 function insertarDatos() {
       // Obtener el valor del campo nombre
       var nombre = document.getElementById('nombreP').value;
        var errorNombre = document.getElementById('error');

        // Validar la longitud del campo nombre
        var expresionRegular = /^[a-zA-Z0-9\s]+$/;
        if (nombre.length < 2 || nombre.length > 30 || !expresionRegular.test(nombre)) {
            errorNombre.textContent = 'El nombre debe tener entre 2 y 30 caracteres alfanumericos.';
        } else {
            // Si la validación pasa, puedes enviar los datos al servidor aquí
            errorNombre.textContent = '';
            $.ajax({
            type: 'POST',
            url: 'pages/addPlay.php',
            data: { nombre: nombre, idSong: datoAlmacenado},
            //dataType: 'json',
            success: function(response) {
                console.log(response);
                alert(response);
                updatePlaylists();
               closeModal2();
               $('#nombreP').val('');
            },
            error: function() {
                //console.error('Error:', error);
                alert("Error al registra!! ");
            }
           });
            //cerrarModal();
        }
    }
    function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
    }
    function closeModal2() {
    var modal = document.getElementById('myModal2');
    modal.style.display = 'none';
  }
  function closeModalE() {
    var modal = document.getElementById('eliminarLista');
    modal.style.display = 'none';
  }
</script>


<!-- Modal de confirmación -->
    <div class="modal"  id="eliminarLista">
        <div class="modal-contentE">
                <p>¿Estás seguro de que deseas eliminar?</p>
            <div class="modal-footerE">
                <button type="button" class="btn-cancelar" onclick="closeModalE()">Cancelar</button>
                <button type="button" class="btn-eliminar" id="btnConfirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</html>