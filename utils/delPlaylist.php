<?php
    include("./dbConnection.php");
    include("../auth/auth.php");
    
    $id = $conn->real_escape_string($_POST['id']);

    $server_msg = array("msg" => "", "extra" => "");

    $sql = "SELECT imagen FROM playlists WHERE id=$id";

    $file = $conn->query($sql)->fetch_assoc()['imagen'];

    $sql = "DELETE FROM playlists WHERE id=$id";
    if ($conn->query($sql)) {

        $file = '.' . $file;

        if (strlen($file) > 2 && file_exists($file)) {
            unlink($file);
        }

        $server_msg['msg'] = "Success";
        $server_msg['extra'] = "$id";
    } else {
        $server_msg['msg'] = "Error";
        $server_msg['extra'] = "$id";
    }
    echo json_encode($server_msg);
    exit;
?>