<!-- Modal nuevo registro -->
<div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="nuevoModalLabel" style="color: white;">Crear PlayList</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="guarda.php" method="post" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                        <span id="nombre-error" style="color: #9cd2d3 ;"></span>


                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3" maxlength="120"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/jpeg, image/png, image/jpg">
                        <img id="imagenPreview" src="playlist.png" width="353" height="199" />

                    </div>

                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Agregar una función para validar la longitud del campo "nombre" al cambiar
    document.getElementById('nombre').addEventListener('input', function () {
        var nombre = this.value;
        if (nombre.length > 100) {
            document.getElementById('nombre-error').textContent = 'El nombre no puede tener más de 100 caracteres.';
            this.setCustomValidity('El nombre no puede tener más de 100 caracteres.');
        } else {
            document.getElementById('nombre-error').textContent = '';
            this.setCustomValidity('');
        }
    });
</script>

