<?php include('./components/navbar.php'); ?>
<?php
  // Inicializar variables
$listName = $listInfo = $listImg = "";

// Verificar si se ha proporcionado un parámetro 'singerID' en la URL
if (isset($_GET['listID'])) {
    $listID = $_GET['listID'];

    // Consulta para obtener información del cantante con el ID proporcionado
    $listFilterQuery = "SELECT *
                    FROM playlists 
                    WHERE id=$listID";

    // Ejecutar la consulta en la conexión a la base de datos
    $result = mysqli_query($conn, $listFilterQuery);
    $playL = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Verificar si se encontró información del cantante
    if (count($playL) > 0) {
        $listName = $playL[0]["nombre"];
        $listInfo = $playL[0]["descripcion"];
        $listImg = $playL[0]["imagen"];
        // Consulta para obtener todas las canciones del cantante
        $songsQuery =  "SELECT songs.id, songs.title AS title,
                        songs.filePath AS audio, songs.imgPath AS img,
                        playlists.nombre, playlists.imagen, lista.idSong, lista.idPlay
                    FROM playlists, songs, lista
                    WHERE playlists.id=lista.idPlay AND songs.id=lista.idSong AND playlists.id=$listID
                    ORDER BY lista.idLista DESC";

        // Ejecutar la consulta para obtener las canciones del cantante
        $result2 = mysqli_query($conn, $songsQuery);
        $songs = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    } else {
        // Redirigir a la página de error 404 si no se encontró el cantante
        redirect("404.php");
    }
}
?>
<section class="pl-area">
   
    <div class="cover1">
        <img src="<?php echo $listImg; ?>" alt="" />
        
        <div class="coverDetail">
            <h1 > <?php echo $listName; ?></h1>
            <p style="color: rgb(32, 106, 124) ;"><?php echo $listInfo; ?></p>
            <div class="pulse"></div>
        </div>
    </div>
    <div class="products">
    <p>Todas las canciones de la Lista de Reproduccion</p>
        <?php foreach ($songs as $index => $song) : ?>
        <div class="song" data="<?php echo $song['id']; ?>">
            <div class="info">
                <h4><?php echo $index + 1; ?> </h4>
                <img src="<?php echo $song['img']; ?>">
                <div class="detail">
                    <h4><?php echo $song['title']; ?></h4>
                    <!--<h5 data-singer="<?php echo $song["singerID"]; ?>"><?php echo $song['singerName']; ?></h5>-->
                </div>
            </div>
            <div class ="func">
            <i class="fa fa-trash"></i>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>


<!--<script src="./js/playlists.js"></script>-->


<!--<dialog id="pl-del-modal" class="pl-modal">
    <h2>¿Eliminar de la biblioteca?</h2>
    <p>Se eliminara '<strong class="pl-del-name"></strong>' de la biblioteca</p>
    <p class="pl-del-err pl-error"></p>
    <form action="./utils/delPlaylist.php" method="post" class="pl-modal-form">
        <input type="hidden" name="id" value="">
        <div>
            <button class="closeModal">Cancelar</button>
            <button value="submit" name="submit">Eliminar</button>
        </div>
    </form>
</dialog>-->