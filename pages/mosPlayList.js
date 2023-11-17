function openModal() {
    var modal = document.getElementById('myModal');
    var modalContent = document.getElementById('modalContent');
  
    // Puedes personalizar el contenido de la modal según el registro
    //modalContent.innerHTML = '<p>Contenido de la modal para </p>';
  
   // modal.style.display = 'block';

  
 
  // Asignar evento al botón para abrir la modal
  //modalContent.addEventListener('click', function() {
    // Simular resultados de la consulta (puedes obtener estos resultados de tu base de datos)
    var consultaResultados = [
      { idPlay: 1, nombre_playlist: 'Lista de Reproduccion 1', cantidad_canciones: 5, imagen: 'images/stay.png' },
      { idPlay: 2, nombre_playlist: 'Lista de Reproduccion 2', cantidad_canciones: 8, imagen: 'images/magic.jpg' },
      { idPlay: 3, nombre_playlist: 'Lista de Reproduccion 3', cantidad_canciones: 8, imagen: 'images/magic.jpg' },
      // ... más resultados ...
    ];

    // Construir el contenido de la modal con tarjetas horizontales
    var modalHTML = '<h2>Lista de Reproduccion</h2>';
    var modalHTML = '<button class="open-modal-button" onclick="">Agregar nuevo</button>';

    consultaResultados.forEach(function(result) {
        modalHTML += '<div class="card-header">';
        modalHTML += '<div class="card-body">';
        modalHTML += '<img src="' + result.imagen + '">';
        
        
        modalHTML += '</div>';
        modalHTML += '<div class="card-body">';
        modalHTML += '<p>'+ result.nombre_playlist +'&nbsp; &nbsp; &nbsp;'+ 'Cantidad de Canciones: ' + result.cantidad_canciones + '</p>';
       // modalHTML += '<p>ID Playlist: ' + result.idPlay + '</p>';
       // modalHTML += '<p>Cantidad de Canciones: ' + result.cantidad_canciones + '</p>';
        modalHTML += '</div></div>';
    });
    
    modalContent.innerHTML = modalHTML;
    
    // Mostrar la modal
    modal.style.display = 'block';
  //});
}
  function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
  }
  

  // Cerrar la modal si el usuario hace clic fuera de ella
  window.addEventListener('click', function(event) {
    var modal = document.getElementById('myModal');
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  });
  