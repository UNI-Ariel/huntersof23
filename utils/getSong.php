<?php
include("./dbConnection.php");

if (isset($_GET['filter'])) {
    $filterTexts = $_GET['filter'];

    $songsFilterQuery = "SELECT songs.id, songs.title AS title,
                        songs.filePath AS audio, songs.imgPath AS img,
                        singers.name AS singerName, singers.id AS singerID
                        FROM songs, singers 
                        WHERE singers.id = songs.singerID AND songs.id=$filterTexts";

    $result = mysqli_query($conn, $songsFilterQuery);
    $songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($songs);
}
?>