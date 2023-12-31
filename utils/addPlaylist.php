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

    if(isset($_POST['nombre']) && $_POST['nombre'] !== ''){
        $pl_name = $_POST['nombre'];
        $pl_name = trim($pl_name);  #Quitar espacios del inicio y fin
        if(!p_valid_length($pl_name, 2, 30)){
            $errors['name'] = 'Nombre debe tener entre 2 y 30 caracteres';
        }
        elseif(q_playlist_name_exists($conn, $uid, $pl_name)){ #ver si ya existe una playlist con ese nombre
            $errors['name'] = 'El nombre de la lista ya existe.';
        }
        
        if(isset($_POST['descripcion']) && $_POST['descripcion'] !== '' ){
            $pl_desc = $_POST['descripcion'];
            $pl_desc = trim($pl_desc);
            if(!p_valid_length($pl_desc, 0, 60)){
                $errors['desc'] = 'Descripcion debe tener un maximo de 60 caracteres';
            }
        }
        if(empty($pl_desc)){ #Agregar descripcion por defecto
            $pl_desc = 'Agrega una descripción';
        }

        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0 && empty($errors['name'])){
            $img = $_FILES['imagen'];
            if(!p_valid_img_type($img)){
                $errors['img'] = ' Formato de imágen no permitido';
            }
            else{                
                $file_ext = p_get_file_ext($img);
                $pl_img = p_generate_file_name($uid, $file_ext); 
                if(!p_save_file($img, $img_dir, $pl_img)){
                    $errors['img'] = 'No se guardo la imagen intente de nuevo';
                }
                else{
                    $pl_img = substr($img_dir, 3) . $pl_img;
                }
            }
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
            $data = array("name" => $pl_name, "desc" => $pl_desc, "img" => $pl_img);            
            $res = q_add_to_playlists($conn, $uid, $data);
            if($res){
                $server_msg['msg'] = 'Success';
                $server_msg['id'] = $res;
                $server_msg['name'] = $pl_name;
                $server_msg['desc'] = $pl_desc;
                $server_msg['img'] = $pl_img;
                echo json_encode($server_msg);
                exit;
            }
            $server_msg['msg'] = 'Error';
            $server_msg['id'] = 'Fallo al agregar el usuario';
            echo json_encode($server_msg);
            exit;
        }
    }
    $server_msg['msg'] = 'Error';
    $server_msg['id'] = 'Parametros invalidos';
    echo json_encode($server_msg);
    exit;
?>