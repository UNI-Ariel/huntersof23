<?php include('./components/navbar.php'); ?>
<?php

    function getPlaylists(){
        global $uid, $conn;
        $sql = "SELECT id, nombre, descripcion, imagen FROM playlists WHERE user_id=$uid";
        return $conn->query($sql);
    }

    
    function getPlaylist($pid){
        global $uid, $conn;
        $sql = "SELECT id, nombre, descripcion, imagen FROM playlists WHERE user_id=$uid AND id=$pid";
        $resultado = $conn->query($sql);
        $rows = $resultado->num_rows;
        return rows;
    }
    
    $playlists = getPlaylists();
    $dir = "./images/playlists/";
?>

<dialog id="pl-add-modal" class="pl-modal">
    <h2>Crear Lista De Reproducción</h2>
    <form action="./utils/addPlaylist.php" method="post" enctype="multipart/form-data" class="pl-modal-form">
        <div >
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <p class="pl-err-name pl-error"></p>
        </div>

        <div >
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="3" ></textarea>
            <p class="pl-err-desc pl-error"></p>
        </div>

        <div >
            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png, image/jpg">
            <img id="imagenPreview" src="./images/playlists/default.png" width="300" height="300" >
        </div>

        <p class="pl-err-img pl-error"></p>

        <div>
            <button class="closeModal">Cerrar</button>
            <button value="submit" name="submit" class="disable" disabled>
                <i class="fa fa-save"></i> Guardar
            </button>
        </div>
    </form>
</dialog>

<dialog id="pl-del-modal" class="pl-modal">
    <h2>¿Eliminar de la biblioteca?</h2>
    <p>Se eliminara '<strong class="pl-del-name"></strong>' de la biblioteca</p>
    <p class="pl-del-err pl-error"></p>
    <form action="./utils/delPlaylist.php" method="post" class="pl-modal-form">
        <input type="hidden" name="id" value="">
        <div>
            <button class="closeModal">Cancelar</button>
            <button value="submit" name="submit">Eliminar</button>
        </div>
    </form>
</dialog>

<section class="pl-area">
    <h2>Mi Biblioteca</h2>
    <div class="pl-result hide">
        <p><i class="fa fa-info-circle"></i> <span class="pl-result-msg"></span></p>
        <div class="pl-result-btn"><i class="fa fa-times"></i></div>
    </div>
    <div class="pl-btns">
        <a href="#" class="pl-btn" id="pl-add-btn">
            <i class="fa fa-plus-circle"></i>
            Crear Lista De Reproduccion
        </a>
    </div>

    <div class="pl-items" >
        <?php while ($row = $playlists->fetch_assoc()) { ?>
            <div class="pl-card">
                <td>
                    <?php
                        echo "<img src='";
                        $pl_img = $row['imagen'];
                        if( file_exists($pl_img) ){
                           echo $pl_img . "'>";
                        }
                        else{
                            echo $dir . "default.png'>";
                        }
                    ?>
                </td>
                <div class="pl-card-info">
                    <h5><?= $row['nombre']; ?></h5>
                    <div class="pl-dropdown">
                        <button class="pl-dropdown-btn" type="button">
                            ...
                        </button>

                        <div class="pl-dropdown-menu hide" tabindex="-1">
                            <a class="pl-dropdown-item" href="#" data-target="#edit" data-id="<?= $row['id']; ?>" data-name="<?= $row['nombre']; ?>">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a class="pl-dropdown-item" href="#" data-target="#delete" data-id="<?= $row['id']; ?>" data-name="<?= $row['nombre']; ?>">
                                <i class="fa fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</section>
<script src="./js/playlists.js"></script>