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
<body onload="recargar">
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
            <img id="imagenPreview" src="./images/playlists/default.png" width="300" height="300">
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

<dialog id="pl-edit-modal" class="pl-modal">
    <h2>Editar Información</h2>
    <form action="./utils/editPlaylist.php" method="post" enctype="multipart/form-data" class="pl-modal-form">
        <input type="hidden" name="id" value="">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" required>
            <p class="pl-err-name pl-error"></p>
        </div>

        <div>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="3" maxlength="60"></textarea>
            <p class="pl-err-desc pl-error"></p>
        </div>

        <div>
            <label for="imagen" class="form-label">Imagen:</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/jpeg, image/png, image/jpg">
            <img id="imagenPreview" width="300" height="300" src="">
            <p class="pl-err-img pl-error"></p>
        </div>

        <div>
            <button class="closeModal">Cerrar</button>
            <button value="submit" name="submit">
                <i class="fa fa-save"></i> Guardar
            </button>
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
            <div class="pl-card" >
            <form action="./lista.php" method="post" id="recargalista">

                <div class="lista" style="cursor: pointer;" data-idlist="<?php echo $row['id']; ?>" onclick="recargar(1)" id="recargaP">
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
                </div>

                <div class="pl-card-info">
                    <h5><?= $row['nombre']; ?></h5>
                    <div class="pl-dropdown">
                        <button class="pl-dropdown-btn" type="button">
                            ...
                        </button>

                        <div class="pl-dropdown-menu hide" tabindex="-1">
                            <a class="pl-dropdown-item" href="#" data-target="#edit" 
                                data-id="<?= $row['id']; ?>" 
                                data-name="<?= $row['nombre']; ?>"
                                data-desc="<?= $row['descripcion']; ?>">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a class="pl-dropdown-item" href="#" data-target="#delete" 
                                data-id="<?= $row['id']; ?>" 
                                data-name="<?= $row['nombre']; ?>"
                                data-desc="<?= $row['descripcion']; ?>">
                                <i class="fa fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</section>
</body>

<script src="./js/playlists.js"></script>
<script>
    function recargar(id){
    document.getElementById('recargaP').addEventListener('click', function(e){
        e.preventDefault();
        window.location.href='./lista.php?listID=1';
    });
    }
</script>


