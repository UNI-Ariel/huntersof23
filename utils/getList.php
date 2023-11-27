<?php
include("./dbConnection.php");
if (isset($_GET['listID'])) {
    $listID = $_GET['listID'];

    $listFilterQuery = "SELECT *
                    FROM playlists 
                    WHERE id=$listID";

    $result = mysqli_query($conn, $listFilterQuery);
    $list = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $songsQuery =  "SELECT songs.id, songs.title title, songs.filePath audio, songs.imgPath img, singers.name singerName,singers.id singerID, lista.idPlay, lista.idLista 
    FROM lista,songs LEFT JOIN singers on singers.id = songs.singerID 
    WHERE lista.idSong = songs.id and singers.id=songs.singerID and lista.idPlay=$listID
                    ORDER BY lista.idLista DESC";

    $result2 = mysqli_query($conn, $songsQuery);
    $songs = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    $list["songs"] = $songs;

    echo json_encode($list);
}
