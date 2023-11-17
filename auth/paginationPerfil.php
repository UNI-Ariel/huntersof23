<?php

include("../utils/dbConnection.php");
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
$start = ($_REQUEST['page']- 1)*5;
    $end = ($start + 5);
$listPerfil = array();

    foreach ($songs as $index => $song){
        if($start <= $index && $index < $end){
            array_push ($listPerfil, $song);
        }
    }
    echo json_encode($listPerfil, JSON_UNESCAPED_UNICODE);

?>