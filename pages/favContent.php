<?php
function reformData($queryResult){
    return ($queryResult["songID"]);
}
$favSongsQuery = "SELECT favourites.songID
                     FROM favourites
                    WHERE favourites.uid=$uid";

$result = mysqli_query($conn, $favSongsQuery);
$queryResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
$favSongs = array_map("reformData", $queryResult);
?>

<?php include('./components/navbar.php'); ?>
<div class="fav">
    <h1 style="color: white; text-align:center">Canciones Favoritas</h1>
    <div style="width: 100%;" class="tileContainer">
    </div>
</div>

<script>
    let favSongIDs = JSON.parse('<?php echo json_encode($favSongs); ?>');
</script>
