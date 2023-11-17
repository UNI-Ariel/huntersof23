

function openModal2() {
     
    var modal = document.getElementById('myModal2');
    var modalContent = document.getElementById('modalContent2');
  
        var modalHTML = '';
    //var modalHTML = '<button class="open-modal-button" onclick="">Agregar nuevo</button>';
        modalHTML += '<form id="myForm">';
        modalHTML += '<label for="nombre">Ponle nombre a tu Lista de Reproduccion</label>';
        modalHTML += '<input type="text" id="nombre" name="nombre" required><br>';
        
        modalHTML += '<input type="reset" onclick="closeModal2()" value="Cancelar">';
        modalHTML += '<input type="submit" value="Aceptar">';
       // modalHTML += '<button class="" onclick="closeModal()">Cancelar</button>';
   
    modalContent.innerHTML = modalHTML;
    
    // Mostrar la modal
    modal.style.display = 'block';
  //});
}
  function closeModal2() {
    var modal = document.getElementById('myModal2');
    modal.style.display = 'none';
  }
  
  // Cerrar la modal si el usuario hace clic fuera de ella
  window.addEventListener('click', function(event) {
    var modal = document.getElementById('myModal2');
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  });
  

