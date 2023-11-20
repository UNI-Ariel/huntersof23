<?php
include("./dbConnection.php");
include("../auth/auth.php");
include("./queries.php");

if(!$authenticated){
    http_response_code(403);
    die('Forbidden');
}

$result = q_get_all_playlists($conn, $uid);
$playlists = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($playlists);