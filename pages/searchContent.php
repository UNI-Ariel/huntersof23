<?php
if (isset($_GET['search'])) {
    $filterTexts = $_GET['search'];
    // Get songs from database
    $songsFilterQuery = "SELECT songs.id, songs.title title, singers.name singerName, 
                        songs.filePath audio, songs.imgPath img, singers.id singerID
                        FROM songs 
                        LEFT JOIN singers on singers.id = songs.singerID
                        WHERE title LIKE '%$filterTexts%' OR singers.name LIKE '%$filterTexts%'";

    $result = mysqli_query($conn, $songsFilterQuery);
    $songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>
<?php include('./components/navbar.php'); ?>
<section class="text-color">
    <h1 class="sectionTitle" >Canciones</h1>
    <div class="songsContain">
        <?php foreach ($songs as $index => $song) : ?>
            <?php
            $heartIcon = '<i class="far fa-heart"></i>';
            if ($authenticated) {
                if (in_array($song["id"], $favSongs)) {
                    $heartIcon = '<i class="fas fa-heart" fav="1"></i>';
                }
            }
            ?>
            <div class="song" data="<?php echo $song['id']; ?>">
                <div class="info">
                    <h4><?php echo $index + 1; ?> </h4>
                    <img src="<?php echo $song['img']; ?>">
                    <div class="detail">
                        <h4><?php echo $song['title']; ?></h4>
                        <h5 class="singerPage" data-singer="<?php echo $song["singerID"]; ?>"><?php echo $song['singerName']; ?></h5>
                    </div>
                </div>
                <div class="func" >
                    <?php echo $heartIcon; ?>
                    <button class="open-modal-button" data-songid="<?php echo $song['id']; ?>" onclick="openModal(this)" ><i class="fas fa-plus" ></i></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!------Agregar auna lista de Reproduccion--
<link rel="stylesheet" href="pages/play.css">-------->


  <!-- Modal1 -->
  <div id="myModal" class="modal">
    <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <button class="open-modal-button" onclick="openModal2()">Agregar nuevo</button>
      <div id="modalContent">
      
      </div>
    </div>
  </div>

 <!-- Modal2 -->
 <div id="myModal2" class="modal">
    <div class="modal-content">
    <span class="close" onclick="closeModal2()">&times;</span>
      <div id="modalContent2">
      <form id="formularioP">
        <label for="nombre">Ponle nombre a tu Lista de Reproduccion</label> 
        <input type="text" id="nombreP" name="nombreP"minlength="2" maxlength="30" pattern="[a-zA-Z0-9]+" title="Solo se permiten caracteres alfanuméricos" required>
        <span style="color: red;" class="error" id="error"></span>
        <!-- Agrega más campos según tus necesidades -->
        <button style="background-color: #979a9e; color: white;  border: none; border-radius: 5px; cursor: pointer; width: 25%; " onclick="closeModal2()">Cancelar</button>
        <button style="background-color: #266882; color: white;  border: none; border-radius: 5px; cursor: pointer; width: 25%; " type="button" onclick="insertarDatos()">Aceptar</button>
      </form>
      </div>
    </div>
  </div>


  <!-- JavaScript (index.php) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
  var datoAlmacenado;
  function openModal(button) {
    var modal = document.getElementById('myModal');
    var dataId = button.getAttribute('data-songid');

// Puedes hacer lo que quieras con el valor data-id, por ejemplo, imprimirlo
    console.log("ID del botón: " + dataId);
    datoAlmacenado = dataId;
            // Hacer una solicitud AJAX para obtener información adicional de la canción
            $.ajax({
                type: 'POST',
                url: 'pages/mostrarLista.php',
                data: { id: dataId },
                success: function (data) {
                  //console.log(data);
                    // Mostrar los resultados en la ventana modal
                    $('#modalContent').html(data);
                   // $('#myModal').modal('show');
                },
                error: function () {
                    alert('Error al obtener la información de la canción.');
                }
            });
   modal.style.display = 'block';

 }
 function openModal2() {
    //var modal = document.getElementById('myModal2');
    $('#myModal').hide();
    // Muestra el dato en el segundo modal
    //$('#dato').text(datoAlmacenado);
    $('#myModal2').show();
    //alert("Dato usado en otra función: " + datoAlmacenado);

 }
 function insertarDatos() {
       // Obtener el valor del campo nombre
       var nombre = document.getElementById('nombreP').value;
        var errorNombre = document.getElementById('error');

        // Validar la longitud del campo nombre
        var expresionRegular = /^[a-zA-Z0-9]+$/;
        if (nombre.length < 2 || nombre.length > 30 || !expresionRegular.test(nombre)) {
            errorNombre.textContent = 'El nombre debe tener entre 2 y 30 caracteres alfanumericos.';
        } else {
            // Si la validación pasa, puedes enviar los datos al servidor aquí
            errorNombre.textContent = '';
            $.ajax({
            type: 'POST',
            url: 'pages/addPlay.php',
            data: { nombre: nombre, idSong: datoAlmacenado},
            dataType: 'json',
            success: function(response) {
                // Puedes manejar la respuesta del servidor aquí
                console.log(response);
                alert("Registro exitoso!! ");
                // Cerrar la ventana modal después de insertar datos
                $('#myModal2').hide();
            },
            error: function(error) {
                console.error('Error:', error);
            }
           });
            //cerrarModal();
        }
    }
</script>

<!--<script src="pages/mosPlayList.js"></script>-->
<!-- <script src="pages/addPlay.js"></script>-->