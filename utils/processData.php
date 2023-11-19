<?php
    /**
     * Funcion para validar si el numero de caracteres de una cadena esta dentro un rango permitido
     * 
     * @param string $str La cadena a validar
     * @param int $min El numero minimo de caracteres. Mayor a cero, menor y distinto de $max
     * @param int $max El numero maximo de caracteres. Mayor a cero, mayor y distinto de $min
     * @return bool True si esta dentro el rango, False caso contrario
     */
    function p_valid_length($str, $min, $max){
        if(!is_string($str)){
            throw new InvalidArgumentException("La cadena no es de tipo string");
        }
        if(!is_int($min) || !is_int($max)){
            throw new InvalidArgumentException("El minimo($min) o maximo($max) no es de tipo entero");
        }
        if($min === $max || $min > $max || $min < 0 || $max < 0){
            throw new InvalidArgumentException("Los valores para minimo($min) y maximo($max) son incorrectos");
        }
        $len = strlen(trim($str));
        if($len < $min || $len > $max){
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Funcion para validar si el tipo del archivo es una imagen permitida
     * 
     * @param array $img Arreglo asociativo con los datos de la imagen
     * @param array $extra_types Parametro opcional. Arreglo no asociativo con tipos de imagenes permitidas adicionales
     * @return bool True si es un tipo permitido, False caso contrario
     */
    function p_valid_img_type($img, $extra_types = []){
        $types = [IMAGETYPE_PNG, IMAGETYPE_JPEG];
        $types = array_merge($types, $extra_types);
        $detected_type = exif_imagetype($img['tmp_name']);
        return in_array($detected_type, $types);
    }

    /**
     * Funcion para generar un nuevo nombre de archivo 
     * 
     * @param string $file_name Nombre base para el archivo
     * @param string $extension Extension que tendra el archivo
     * @return string Cadena con el nombre generado
     */
    function p_generate_file_name($file_name, $extension){
        return $file_name . '_' . time() . '.' . $extension;
    }

    /**
     * Funcion para obtener la extension de un archivo obtenido del formulario
     * @param array $file Arreglo asociativo con los datos del archivo
     * @return string La extension del archivo
     */
    function p_get_file_ext($file){
        return pathinfo($file['name'], PATHINFO_EXTENSION);
    }

    /**
     * Funcion para crear una carpeta unicamente si esta no existe
     * 
     * @param string $dir Direccion de la carpeta
     * @return bool False si intento crear la carpeta y fallo, True cualquier otro caso
     */
    function p_create_dir($dir){
        if(!file_exists($dir)){
            try{
                mkdir($dir, 0777, true);
            }
            catch (Exception $e){
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Funcion para guardar el archivo obtenido del formulario a una carpeta
     * 
     * @param array $file Arreglo asociativo con los datos del archivo
     * @param string $dir La direccion en donde se guardara la imagen
     * @param string $name El nombre que tendra la imagen guardada
     * @return bool True si se guardo correctamente, False caso contraio
     */
    function p_save_file($file, $dir, $name){
        if(p_create_dir($dir) ){
            return move_uploaded_file($file['tmp_name'], $dir . $name);
        }
        return FALSE;
    }

    /**
     * Funcion para borrar un archivo si este existe
     * 
     * @param string $file La direccion del archivo a borrar
     * @return void No devuelve valor
     */
    function p_delete_file($file){
        if (file_exists($file)) {
            unlink($file);
        }
        return;
    }
?>