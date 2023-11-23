<?php
    include("./dbConnection.php");
    include("../auth/auth.php");

    header('Content-Type: application/json');
    $server_msg = array('msg' => '', 'id' => '', 'name' => '', 'desc' => '', 'img' => '');

    if(!$authenticated){
        $server_msg['msg'] = "Error";
        $server_msg['id'] = "No autorizado";
        $server_msg['name'] = "No autorizado";
        $server_msg['desc'] = "No autorizado";
        $server_msg['img'] = "No autorizado";
        echo json_encode( $server_msg);
        exit;
    }

    include("./processData.php");
    include("./queries.php");

    $pl_name = $pl_desc = $pl_img = "";
    $errors = array('name' => '', 'desc' => '', 'img' => '');
    $img_dir = '../images/playlists/';

    $playlist_id = $conn->real_escape_string($_POST['id']);
    $current_data = q_get_playlist($conn, $uid ,$playlist_id);

    if(isset($_POST['nombre']) && $_POST['nombre'] !== ''){
        $pl_name = trim($_POST['nombre']);
        if( !p_valid_length($pl_name, 1, 30) ){
            $errors['name'] = 'Nombre debe tener entre 1 y 30 caracteres';
        }
        elseif($current_data['nombre'] !== $pl_name){
            if (q_playlist_name_exists($conn, $uid, $pl_name)) {
                $errors['name'] = 'El nombre de la lista ya existe.';
            }
        }
        else{
            $pl_name = $current_data['nombre'];
        }
        
        if(isset($_POST['descripcion']) && $_POST['descripcion'] !== '' ){
            $pl_desc = trim($_POST['descripcion']);
            if( !p_valid_length($pl_desc, 0, 60) ){
                $errors['desc'] = 'Descripcion debe tener un maximo de 60 caracteres';
            }
            elseif($pl_desc === $current_data['descripcion']){
                $pl_desc = $current_data['descripcion'];
            }
        }

        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0 ){
            $img = $_FILES['imagen'];
            if(!p_valid_img_type($img)){
                $errors['img'] = ' Formato de imágen no permitido';
            }
            else{
                $file_ext = p_get_file_ext($img);
                $pl_img = p_generate_file_name($uid, $file_ext); 
                if(!p_save_file($img, $img_dir, $pl_img)){
                    $errors['img'] = 'No se guardo la imagen intente nuevamente';
                }
                else{
                    $pl_img = substr($img_dir, 3) . $pl_img;
                }
            }
        }
        else{
            $pl_img = $current_data['imagen'];
        }

        if(array_filter($errors)){
            $server_msg['msg'] = 'Error';
            $server_msg['name'] = $errors['name'];
            $server_msg['desc'] = $errors['desc'];
            $server_msg['img'] = $errors['img'];
            echo json_encode($server_msg);
            exit;
        }
        else{
            if($pl_img !== $current_data['imagen'] || $current_data['nombre'] !== $pl_name || 
            $current_data['descripcion'] !== $pl_desc){
                $data = array('nombre' => $pl_name, 'descripcion' => $pl_desc, 'imagen' => $pl_img);
                if(q_update_playlist($conn, $uid, $playlist_id, $data)){
                    if($pl_img !== $current_data['imagen'] && !empty($current_data['imagen'])){
                        p_delete_file('../' . $current_data['imagen']);
                    }
                    $server_msg['msg'] = 'Success';
                    $server_msg['id'] = $playlist_id;
                    $server_msg['name'] = $pl_name;
                    $server_msg['desc'] = $pl_desc;
                    $server_msg['img'] = $pl_img;
                    echo json_encode($server_msg);
                    exit;
                }
                else{
                    $server_msg['msg'] = 'Error';
                    $server_msg['id'] = 'Fallo al actualizar los datos';
                    echo json_encode($server_msg);
                    exit;
                }
            }
            else{
                $server_msg['msg'] = 'Error';
                $server_msg['id'] = 'No se modifico ningun dato';
                echo json_encode($server_msg);
                exit;
            }
        }
    }
    $server_msg['msg'] = 'Error';
    $server_msg['id'] = 'Solicitud invalida';
    echo json_encode($server_msg);
    exit;
?>