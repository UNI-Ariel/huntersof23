<?php
// Función para reformatear los datos del resultado de la consulta
function reformData($queryResult)
{
    return ($queryResult["songID"]);
}

// Consulta para obtener los IDs de las canciones favoritas del usuario
$favSongsQuery = "SELECT favourites.songID FROM favourites
                  WHERE favourites.uid = $uid";

// Ejecutar la consulta en la conexión a la base de datos
$result = mysqli_query($conn, $favSongsQuery);
$queryResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Mapear los resultados utilizando la función "reformData" para obtener un array de IDs de canciones favoritas
$favSongs = array_map("reformData", $queryResult);
?>
<?php include('./components/navbar.php'); ?>
<div class="fav">
    <h1 style="color: white">Canciones Favoritas</h1>
    <button>Play all</button>
    <div style="width: 100%;" class="tileContainer">
        <?php foreach ($favSongs as $index => $songID) : ?>
            <div class="song" data="<?php echo $songID; ?>">
                <div class="info">
                    <h4 style="color: white"><?php echo $index + 1; ?> </h4>
                    <img src="<?php /* Coloca la URL de la imagen aquí */ ?>">
                    <div class="detail">
                        <h4><?php /* Coloca el título de la canción aquí */ ?></h4>
                        <h5 data-singer="<?php /* Coloca el ID del cantante aquí */ ?>"><?php /* Coloca el nombre del cantante aquí */ ?></h5>
                    </div>
                </div>
                <div class="func" style="color: white">
                    <i class="fas fa-trash"></i>
                    <i class="fas fa-list-ul"></i>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    // Convierte la matriz de canciones favoritas a un objeto JavaScript
    let favSongIDs = JSON.parse('<?php echo json_encode($favSongs); ?>');
</script>
