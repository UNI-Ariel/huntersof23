<?php
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
</html>