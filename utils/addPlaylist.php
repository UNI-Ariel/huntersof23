<?php
    include("./dbConnection.php");
    include("../auth/auth.php");

    header('Content-Type: application/json');

    $pl_name = $pl_desc = $pl_img = "";
    $server_msg = array('msg' => '', 'name' => '', 'desc' => '', 'img' => '', 'extra' => '');
    $img_dir = '../images/playlists/';

    if(isset($_POST['nombre']) && $_POST['nombre'] !== ''){
        $pl_name = $conn->real_escape_string($_POST['nombre']);
        if(strlen($pl_name) > 30){
            $server_msg['name'] = 'Nombre debe tener entre 1 y 30 caracteres';
        }
        else{
            $sql = "SELECT id FROM playlists WHERE nombre = '$pl_name' AND user_id = '$uid'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $server_msg['name'] = 'El nombre de la lista ya existe.';
            }
        }
        
        if(isset($_POST['descripcion']) && $_POST['descripcion'] !== '' ){
            $pl_desc = $conn->real_escape_string($_POST['descripcion']);
            if(strlen($pl_desc) > 60){
                $server_msg['desc'] = 'Descripcion debe tener un maximo de 60 caracteres';
            }
        }

        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0 ){
            $allow_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
            $detected_type = exif_imagetype($_FILES['imagen']['tmp_name']);
            if(!in_array($detected_type, $allow_types)){
                $server_msg['img'] = ' Formato de imágen no permitido';
            }
            else{
                $file_ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $pl_img = $img_dir . $uid . '_' . time() . '.' . $file_ext;
                if(!move_uploaded_file($_FILES['imagen']['tmp_name'], $pl_img)){
                    $server_msg['img'] = 'No se guardo la imagen';
                    $pl_img = '';
                }
                if(!empty ($pl_img) )
                    $pl_img = substr($pl_img, 1);
            }
        }

        if(array_filter($server_msg)){
            $server_msg['msg'] = 'Error';
            echo json_encode($server_msg);
            exit;
        }
        else{
            $sql = "INSERT INTO playlists(user_id, nombre, descripcion, imagen) VALUES('$uid', '$pl_name', '$pl_desc', '$pl_img')";
            if ($conn->query($sql)) {
                $server_msg['msg'] = 'Success';
                $server_msg['name'] = $pl_name;
                $server_msg['desc'] = $pl_desc;
                $server_msg['img'] = $pl_img;
                $server_msg['extra'] = $conn ->insert_id;
                echo json_encode($server_msg);
                exit;
            }
            else{
                $server_msg['msg'] = 'Error';
                echo json_encode($server_msg);
                exit;
            }
        }
    }
    $server_msg['type'] = 'Error';
    echo json_encode($server_msg);
    exit;
?>