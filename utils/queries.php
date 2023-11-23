<?php
    /**
     * Funcion para insertar una nueva playlist
     * 
     * @param mysqli $mysql Conexion a la base de datos MySQL
     * @param int $user_id El id del usuario para el cual se agregara la playlist
     * @param  array $data Datos de la playlist a insertar: name, desc, img
     * @return int|false Devuelve el id de la ultima insercion o FALSE si ocurrio error
     */
    function q_add_to_playlists($mysql, $user_id, $data){
        $user_id = $mysql->real_escape_string($user_id);
        $name= $mysql->real_escape_string($data['name']);
        $desc = $mysql->real_escape_string($data['desc']);
        $img = $mysql->real_escape_string($data['img']);
        
        $sql = "INSERT INTO playlists(user_id, nombre, descripcion, imagen) 
                    VALUES('$user_id', '$name', '$desc', '$img')";

        if(!$mysql->query($sql)){
            return FALSE;
        }

        return $mysql->insert_id;
    }

    /**
     * Funcion para obtener todas las playlist de un usuario. El resultado devuelto exitosamente
     * debe iterarse con mysqli_fetch_assoc($resultado) o $resultado->fecth_assoc();
     * 
     * @param mysqli $mysql Conexion a la base de datos MySQL
     * @param int $user_id El id del usuario
     * @return mysqli_result|false Devuelve el recurso como resultado si fue exitoso, False caso contrario
     */
    function q_get_all_playlists($mysql, $user_id){
        $sql = "SELECT id, nombre, descripcion, imagen FROM playlists WHERE user_id=$user_id";
        return $mysql->query($sql);
    }

    /**
     * Funcion para obtener una playlist por id
     * 
     * @param mysqli $mysql Conexion a la base de datos MySQL
     * @param int $user_id El id del usuario de la playlist
     * @param int $playlist_id El id de la playlist
     * @return array|null Devuelve un Arreglo asociativo si existe la playlist, NULL Caso contrario
     */
    function q_get_playlist($mysql, $user_id, $playlist_id){
        $sql = "SELECT * FROM playlists WHERE id=$playlist_id AND user_id=$user_id";
        $res = $mysql->query($sql);
        return $res->fetch_assoc();
    }

    /**
     * Funcion para actualizar una playlist
     * 
     * @param mysqli $mysql Conexion a la base de datos MySQL
     * @param int $user_id El id del usuario de la playlist
     * @param int $playlist_id El id de la playlist
     * @param array $new_data El arreglo asociativo con nuevos valores debe contener: 
     *                       nombre, descripcion, imagen, con al menos un campo distinto de vacio o nulo.
     * @return bool True si se actualizo, False caso contrario
     */
    function q_update_playlist($mysql, $user_id, $playlist_id, $new_data){
        $update = array();
        foreach ($new_data as $key => $value){
            if(!empty($value)){
                $value = $mysql->real_escape_string($value);
                $update[] = "$key = '$value'";
            }
        }
        if(!empty($update)){
            $update = implode(', ', $update);
            $sql = "UPDATE playlists SET $update WHERE id=$playlist_id AND user_id=$user_id";
            if($mysql->query($sql)){
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Funcion para eliminar una playlist por id
     * 
     * @param mysqli $mysql Conexion a la base de datos MySQL
     * @param int $user_id El id del usuario de la playlist
     * @param int $playlist_id El id de la playlist
     * @return bool True si se elimino una playlist, False caso contrario
     */
    function q_delete_playlist($mysql, $user_id, $playlist_id){
        $sql = "DELETE FROM playlists WHERE id=$playlist_id AND user_id=$user_id";
        $res = $mysql->query($sql);
        if($res && $mysql->affected_rows > 0){
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Funcion para verificar si una playlist con un nombre ya existe
     * 
     * @param mysqli $mysql Conexion a la base de datos MySQL
     * @param int $user_id El id del usuario para la playlist
     * @param  string $name El nombre de la playlist a verificar
     * @return bool Devuelve True si ya existe una playlist con el nombre ingresado, False caso contrario
     */
    function q_playlist_name_exists($mysql, $user_id, $name){
        $name = $mysql->real_escape_string($name);
        $sql = "SELECT id FROM playlists WHERE nombre = '$name' AND user_id = '$user_id'";
        $result = $mysql->query($sql);
        if ($result->num_rows > 0) {
            return TRUE;
        }
        return FALSE;
    }
?>