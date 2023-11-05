<?php
include("./dbConnection.php");
include("../auth/auth.php");

$songsFilterQuery = "SELECT songs.id AS id,
                    songs.title AS title, songs.filePath AS audio,
                    songs.imgPath AS img, singers.name AS singerName,
                    singers.id AS singerID FROM favourites, songs, singers
                    WHERE favourites.uid=$uid AND favourites.songid = songs.id 
                            AND singers.id = songs.singerID";

$result = mysqli_query($conn, $songsFilterQuery);
$songs = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($songs);
?>