<?php
// Función para reformatear los datos del resultado de la consulta
function reformData($queryResult)
{
    return ($queryResult["songID"]);
}

// Consulta para obtener los IDs de las canciones favoritas del usuario
$favSongsQuery = "SELECT favourites.songID
                     FROM favourites
                    WHERE favourites.uid = $uid";

// Ejecutar la consulta en la conexión a la base de datos
$result = mysqli_query($conn, $favSongsQuery);
$queryResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Mapear los resultados utilizando la función "reformData" para obtener un array de IDs de canciones favoritas
$favSongs = array_map("reformData", $queryResult);
?>
<?php include('./components/navbar.php'); ?>
<div class="fav">
    <h1>Canciones Favoritas</h1>
    <button class="playAllFav">
        <i class="fas fa-play"></i>
        <p>Reproducir</p>
    </button>
    <div class="tileContainer">
        <?php foreach ($favSongs as $index => $songID) : ?>
            <div class="song" data="<?php echo $formatSongs[$songID]['id']; ?>">
                <div class="info">
                    <h4><?php echo $index + 1; ?> </h4>
                    <img src="<?php echo $formatSongs[$songID]['img']; ?>">
                    <div class="detail">
                        <h4><?php echo $formatSongs[$songID]['title']; ?></h4>
                        <h5 class="singerPage" data-singer="<?php echo $formatSongs[$songID]['singerID']; ?>"><?php echo $formatSongs[$songID]['singerName'];?></h5>
                    </div>
                </div>
                <div class="func">
                    <i class="fas fa-trash"></i>
                    <button class="open-modal-button" onclick="openModal3()"><i class="fas fa-plus" ></i></button>
                   
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    // Convierte la matriz de canciones favoritas a un objeto JavaScript
    let favSongIDs = JSON.parse('<?php echo json_encode($favSongs); ?>');

</script>

<!------Agregar auna lista de Reproduccion---------->
<link rel="stylesheet" href="pages/play.css">
  <!-- Modal1 -->
  <div id="myModal3" class="modal">
    <div class="modal-content">
    <span class="close" onclick="closeModal3()">&times;</span>
    <button class="open-modal-button" onclick="openModal5()">Agregar nuevo</button>
      <div id="modalContent3">
       <!-- <img id="imagenModalSrc" src="" alt="Imagen de la base de datos">
        <p id="nombreImagen"></p>
        <p id="cantidad"></p>-->
      </div>
    </div>
  </div>

  <!-- Modal2 -->
  <div id="myModal5" class="modal">
    <div class="modal-content">
    <span class="close" onclick="closeModal5()">&times;</span>
      <div id="modalContent5">
      </div>
    </div>
  </div>
  <script src="pages/mosPlayList.js"></script>
  <script src="pages/addPlay.js"></script>

<!------------------------->
<script>
function openModal5() {
     
     var modal = document.getElementById('myModal5');
     var modalContent = document.getElementById('modalContent5');
   
         var modalHTML = '';
     //var modalHTML = '<button class="open-modal-button" onclick="">Agregar nuevo</button>';
         modalHTML += '<form id="myForm">';
         modalHTML += '<label for="nombre">Ponle nombre a tu Lista de Reproduccion</label>';
         modalHTML += '<input type="text" id="nombre" name="nombre" required><br>';
         
         modalHTML += '<input type="reset" onclick="closeModal5()" value="Cancelar">';
         modalHTML += '<input type="submit" value="Aceptar">';
        // modalHTML += '<button class="" onclick="closeModal()">Cancelar</button>';
    
     modalContent.innerHTML = modalHTML;
     
     // Mostrar la modal
     modal.style.display = 'block';
   //});
 }
 function closeModal5() {
    var modal = document.getElementById('myModal5');
    modal.style.display = 'none';
  }
  
  // Cerrar la modal si el usuario hace clic fuera de ella
  window.addEventListener('click', function(event) {
    var modal = document.getElementById('myModal5');
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  });
 </script>