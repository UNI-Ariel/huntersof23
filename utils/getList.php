<?php
include("./dbConnection.php");
if (isset($_GET['listID'])) {
    $listID = $_GET['listID'];

    $listFilterQuery = "SELECT *
                    FROM playlists 
                    WHERE id=$listID";

    $result = mysqli_query($conn, $listFilterQuery);
    $singer = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $songsQuery =  "SELECT songs.id, songs.title AS title,
                        songs.filePath AS audio, songs.imgPath AS img,
                        playlists.nombre, playlists.imagen, lista.idSong, lista.idPlay
                    FROM playlists, songs, lista
                    WHERE playlists.id=lista.idPlay AND songs.id=lista.idSong AND playlists.id=$listID
                    ORDER BY lista.idLista DESC";

    $result2 = mysqli_query($conn, $songsQuery);
    $songs = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    $singer["songs"] = $songs;

    echo json_encode($singer);
}
