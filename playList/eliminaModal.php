<!-- Modal elimina registro -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="background-color: #e4e5de;">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="eliminaModalLabel" style="color: rgb(7, 153, 182);">¿Desea eliminar de tu biblioteca?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="color: rgb(7, 153, 182);">
                Se eliminará de tu biblioteca
            </div>

            <div class="modal-footer">
                <form action="elimina.php" method="post">

                    <input type="hidden" name="id" id="id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>

