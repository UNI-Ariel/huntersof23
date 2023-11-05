<?php
// Función para reformatear los datos del resultado de la consulta
function reformData($queryResult)
{
    return ($queryResult["songID"]);
}

// Consulta para obtener los IDs de las canciones favoritas del usuario
$favSongsQuery = "SELECT favourites.songID
                     FROM favourites
                    WHERE favourites.uid = $uid";

// Ejecutar la consulta en la conexión a la base de datos
$result = mysqli_query($conn, $favSongsQuery);
$queryResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Mapear los resultados utilizando la función "reformData" para obtener un array de IDs de canciones favoritas
$favSongs = array_map("reformData", $queryResult);
?>
<?php include('./components/navbar.php'); ?>
<div class="fav">
    <h1>Canciones Favoritas</h1>
    <button class="playAllFav">
        <i class="fas fa-play"></i>
        <p>Reproducir</p>
    </button>
    <div class="tileContainer">
        <?php foreach ($favSongs as $index => $songID) : ?>
            <div class="song" data="<?php echo $formatSongs[$songID]['id']; ?>">
                <div class="info">
                    <h4><?php echo $index + 1; ?> </h4>
                    <img src="<?php echo $formatSongs[$songID]['img']; ?>">
                    <div class="detail">
                        <h4><?php echo $formatSongs[$songID]['title']; ?></h4>
                        <h5 data-singer="<?php echo $formatSongs[$songID]['singerID']; ?>"><?php echo $formatSongs[$songID]['singerName'];?></h5>
                    </div>
                </div>
                <div class="func">
                    <i class="fas fa-trash"></i>
                    <i class="fas fa-plus"></i>
                   
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    // Convierte la matriz de canciones favoritas a un objeto JavaScript
    let favSongIDs = JSON.parse('<?php echo json_encode($favSongs); ?>');
</script>