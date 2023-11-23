<?php
    include("./dbConnection.php");
    include("../auth/auth.php");

    header('Content-Type: application/json');
    $server_msg = array("msg" => "", "id" => "");

    if(!$authenticated){
        $server_msg['msg'] = "Error";
        $server_msg['id'] = "No autorizado";
        echo json_encode( $server_msg);
        exit;
    }
    
    include("./queries.php");
    include("./processData.php");


    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id = $conn->real_escape_string($_POST['id']);

        $playlist = q_get_playlist($conn, $uid, $id);
        if($playlist){
            $image = $playlist['imagen'];

            if(q_delete_playlist($conn, $uid, $id)){
                if(!empty($image)){
                    p_delete_file("../" . $image);
                }
                $server_msg['msg'] = "Success";
                $server_msg['id'] = "$id";
                echo json_encode($server_msg);
                exit;
            }
            else{
                $server_msg['msg'] = "Error";
                $server_msg['id'] = "No se borro la lista de reproducción";
                echo json_encode($server_msg);
                exit;
            }
        }
        $server_msg['msg'] = "Error";
        $server_msg['id'] = "No existe la lista de reproducción";
        echo json_encode($server_msg);
        exit;
    }
?>