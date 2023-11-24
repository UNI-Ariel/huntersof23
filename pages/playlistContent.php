<?php include('./components/navbar.php'); ?>

<?php
     include('./utils/queries.php');
        
    $playlists = q_get_all_playlists($conn, $uid);
?>
<dialog id="pl-add-modal" class="pl-modal">
    <h2>Crear Lista De Reproducción</h2>
    <form action="./utils/addPlaylist.php" method="post" enctype="multipart/form-data" class="pl-modal-form">
        <div >
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" required>
            <p class="pl-err-name pl-error"></p>
        </div>

        <div >
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="3" maxlength="60"></textarea>
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
        <p class="pl-edit-err pl-error"></p>
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
                <div class="lista" data-idlist="<?php echo $row['id']; ?>" >
                    <?php
                        $card_img = empty($row['imagen']) ? 'images/default/playlist.jpg' : $row['imagen'];
                    ?>
                    <img src="<?= $card_img; ?>" title="<?= htmlspecialchars($row['descripcion']); ?>">
                </div>

                <div class="pl-card-info">
                    <h5><?= htmlspecialchars($row['nombre']); ?></h5>
                    <div class="pl-dropdown">
                        <button class="pl-dropdown-btn" type="button">
                            ...
                        </button>

                        <div class="pl-dropdown-menu hide" tabindex="-1">
                            <a class="pl-dropdown-item" href="#" data-target="#edit" 
                                data-id="<?= $row['id']; ?>" 
                                data-name="<?= htmlspecialchars($row['nombre']); ?>"
                                data-desc="<?= htmlspecialchars($row['descripcion']); ?>">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a class="pl-dropdown-item" href="#" data-target="#delete" 
                                data-id="<?= $row['id']; ?>" 
                                data-name="<?= htmlspecialchars($row['nombre']); ?>"
                                data-desc="<?= htmlspecialchars($row['descripcion']); ?>">
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
<!-- <script>
    function recargar(id){
        const url = './lista.php?listID='+id;
        window.location.href=url;
    }
</script> -->


