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
        if($listImg === NULL || empty($listImg)){
            $listImg = 'images/default/playlist.jpg';
        }
        // Consulta para obtener todas las canciones del cantante
        $songsQuery =  "SELECT songs.id, songs.title title, songs.filePath audio, songs.imgPath img, singers.name singerName,singers.id singerID, lista.idPlay, lista.idLista 
        FROM lista,songs LEFT JOIN singers on singers.id = songs.singerID 
        WHERE lista.idSong = songs.id and singers.id=songs.singerID and lista.idPlay=$listID  ORDER BY lista.idLista DESC";

        // Ejecutar la consulta para obtener las canciones del cantante
        $result2 = mysqli_query($conn, $songsQuery);
        $songs = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    } else {
        // Redirigir a la página de error 404 si no se encontró el cantante
        redirect("404.php");
    }
}
?>
<body var idSong;></body>



    <div class="cover1">
        <img src="<?php echo $listImg; ?>" alt="" />
        
        <div class="coverDetail">
            <h1 > <?php echo $listName; ?></h1>
            <p style="color: rgb(32, 106, 124) ;"><?php echo $listInfo; ?></p>
            <div class="pulse">
            <!--<button class="reproPlay"><i class="fas fa-play"></i> <p>Reproducir</p></button>-->
            </div>
        </div>
    </div>
    <div class="products">
        <?php foreach ($songs as $index => $song) : ?>
        <div class="song" data="<?php echo $song['id']; ?>">
            <div class="info">
                <h4><?php echo $index + 1; ?> </h4>
                <img src="<?php echo $song['img']; ?>">
                <div class="detail">
                    <h4><?php echo $song['title']; ?></h4>
                    <h5><?php echo $song['singerName']; ?></h5>
                </div>
            </div>
            <div class ="func" data-list="<?php echo $song["idLista"]; ?>">
            <i class="fa fa-trash"></i>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

<script>
//const traIc = document.querySelectorAll("#lista .func");
//console.log(traIc);
/*traIc.foreach(li=>{
    removeList(li, li.getAttribute('data-list'));
});*/
</script>   
