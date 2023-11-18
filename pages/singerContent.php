<?php
// Inicializar variables
$singerName = $singerInfo = $singerImg = "";

// Verificar si se ha proporcionado un parámetro 'singerID' en la URL
if (isset($_GET['singerID'])) {
    $singerID = $_GET['singerID'];

    // Consulta para obtener información del cantante con el ID proporcionado
    $singerFilterQuery = "SELECT *
                    FROM singers 
                    WHERE id=$singerID";

    // Ejecutar la consulta en la conexión a la base de datos
    $result = mysqli_query($conn, $singerFilterQuery);
    $singer = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Verificar si se encontró información del cantante
    if (count($singer) > 0) {
        $singerName = $singer[0]["name"];
        $singerInfo = $singer[0]["info"];
        $singerImg = $singer[0]["image"];

        // Consulta para obtener todas las canciones del cantante
        $songsQuery =  "SELECT songs.id, songs.title title,
                        songs.filePath audio, songs.imgPath img,
                        singers.name singerName, singers.id singerID
                    FROM songs 
                    LEFT JOIN singers on singers.id = songs.singerID
                    WHERE singers.id = $singerID
                    ORDER BY songs.dateAdded DESC";

        // Ejecutar la consulta para obtener las canciones del cantante
        $result2 = mysqli_query($conn, $songsQuery);
        $songs = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    } else {
        // Redirigir a la página de error 404 si no se encontró el cantante
        redirect("404.php");
    }
}
?>
<?php include('./components/navbar.php'); ?>
<button><a href="./search.php"><i class ="fa fa-arrow-left"></i></a></button>
<div class="cover">
    <img src="<?php echo $singerImg; ?>" alt="" />
    <div class="coverDetail">
        <h1>
            <?php echo $singerName; ?>
        </h1>
        <div class="pulse"></div>
    </div>
</div>
<div class="products">
    <h1>Todas las cnciones del artista</h1>
    <?php foreach ($songs as $index => $song) : ?>
        <div class="song" data="<?php echo $song['id']; ?>">
            <div class="info">
                <h4><?php echo $index + 1; ?> </h4>
                <img src="<?php echo $song['img']; ?>">
                <div class="detail">
                    <h4><?php echo $song['title']; ?></h4>
                    <h5 data-singer="<?php echo $song["singerID"]; ?>"><?php echo $song['singerName']; ?></h5>
                </div>
            </div>
            <div class="func">
                <i class="far fa-heart"></i>
                <i class="fas fa-plus"></i>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class= "description">
    <h2 class="title">Introducción</h2>
    <div class="desDetail">
        <img src="<?php echo $singerImg; ?>" alt="" />
        <p><?php echo $singerInfo; ?></p>
    </div>
</div>
