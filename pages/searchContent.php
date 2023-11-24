<?php
if (isset($_GET['search'])) {
    $filterTexts = $_GET['search'];
    // Get songs from database
    $songsFilterQuery = "SELECT songs.id, songs.title title, singers.name singerName, 
                        songs.filePath audio, songs.imgPath img, singers.id singerID
                        FROM songs 
                        LEFT JOIN singers on singers.id = songs.singerID
                        WHERE title LIKE '%$filterTexts%' OR singers.name LIKE '%$filterTexts%'";

    $result = mysqli_query($conn, $songsFilterQuery);
    $songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>
<?php include('./components/navbar.php'); ?>
<section class="text-color">
    <h1 class="sectionTitle" >Canciones</h1>
    <div class="songsContain">
        <?php foreach ($songs as $index => $song) : ?>
            <?php
            $heartIcon = '<i class="far fa-heart"></i>';
            if ($authenticated) {
                if (in_array($song["id"], $favSongs)) {
                    $heartIcon = '<i class="fas fa-heart" fav="1"></i>';
                }
            }
            ?>
            <div class="song" data="<?php echo $song['id']; ?>">
                <div class="info">
                    <h4><?php echo $index + 1; ?> </h4>
                    <img src="<?php echo $song['img']; ?>">
                    <div class="detail">
                        <h4><?php echo $song['title']; ?></h4>
                        <h5 class="singerPage" data-singer="<?php echo $song["singerID"]; ?>"><?php echo $song['singerName']; ?></h5>
                    </div>
                </div>
                <div class="func" >
                    <?php echo $heartIcon; ?>
                    <button class="open-modal-button" data-songid="<?php echo $song['id']; ?>" onclick="openModal(this)" ><i class="fas fa-plus" ></i></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!------Agregar auna lista de Reproduccion--
<link rel="stylesheet" href="pages/play.css">-------->

 

<!--<script src="pages/mosPlayList.js"></script>-->
<!-- <script src="pages/addPlay.js"></script>-->