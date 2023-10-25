<?php
include("./dbConnection.php");

$songsQuery = "SELECT songs.id, songs.title title,
                songs.filePath audio, songs.imgPath img,
                singers.name singerName, singers.id singerID
                FROM songs 
                LEFT JOIN singers ON singers.id = songs.singerID
                ORDER BY songs.id DESC
                LIMIT 10";

$result = mysqli_query($conn, $songsQuery);
$songs = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($songs);