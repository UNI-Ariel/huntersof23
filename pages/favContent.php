
<head>
<style>
    #btn{
        padding: 10px;
        background-color: rgba(0,0,0,0);
        cursor: pointer;
    }
        /* The container <div> - needed to position the dropdown content */
        .dropdown {
        position: relative;
        display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.8);
        z-index: 1;
        }
        /* Links inside the dropdown */
        .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        }
        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {background-color: #f1f1f1}

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
        display: block;
        }
        /* Change the background color of the dropdown button when the dropdown content is shown */
        .dropdown:hover #btn {
        background-color: rgba(0,0,0,0);
        }
</style>
</head>

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
    <h1 style="color: white; text-align:center">Canciones Favoritas</h1>
    <!--<button>Play all</button>-->
    <div style="width: 100%;" class="tileContainer">
        <?php foreach ($favSongs as $index => $songID) : ?>
            <div class="song" data="<?php echo $formatSongs[$songID]['id']; ?>">
                <div class="info">
                    <h4 style="color: white"><?php echo $index + 1; ?> </h4>
                    <img src="<?php echo $formatSongs[$songID]['img']; ?>">
                    <div class="detail">
                        <h4><?php echo $formatSongs[$songID]['title']; ?></h4>
                        <h5 data-singer="<?php echo $formatSongs[$songID]['singerID']; ?>"><?php echo $formatSongs[$songID]['singerName'];?></h5>
                    </div>
                </div>
                <div class="func"  style="color: white">
                    <!--<i class="fas fa-list-ul"></i>
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>-->
                    <div class="dropdown">
                   <i class="fa fa-ellipsis-v" id="btn" style="color: white" aria-hidden="true"></i>
                        <div class="dropdown-content">
                            <a href="#">Eliminar </a>
                            <a href="#">Agregar una lista</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    // Convierte la matriz de canciones favoritas a un objeto JavaScript
    let favSongIDs = JSON.parse('<?php echo json_encode($favSongs); ?>');
</script>
