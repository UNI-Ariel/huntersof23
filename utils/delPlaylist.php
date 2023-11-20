<?php
    include("./dbConnection.php");
    include("../auth/auth.php");
    
    $id = $conn->real_escape_string($_POST['id']);

    $server_msg = array("msg" => "", "extra" => "");

    $sql = "DELETE FROM playlists WHERE id=$id";
    if ($conn->query($sql)) {

        /* $dir = "imagen";
        $poster = $dir . '/' . $id . '.jpg';

        if (file_exists($imagen)) {
            unlink($imagen);
        } */

        $server_msg['msg'] = "Success";
        $server_msg['extra'] = "$id";
    } else {
        $server_msg['msg'] = "Error";
        $server_msg['extra'] = "$id";
    }
    echo json_encode($server_msg);
    exit;
?>