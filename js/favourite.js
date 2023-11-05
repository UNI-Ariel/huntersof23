const playFavButton = document.querySelector(".fav button");

// Agrega un oyente de eventos al botón "Play all"
playFavButton.addEventListener("click", () => {
    if (favSongIDs.length > 0) {
        // Si hay canciones favoritas, crea una lista de reproducción con las canciones favoritas
        let favouriteSongs = [];
        console.log(favSongIDs);
        favSongIDs.forEach((id) => {
            favouriteSongs.push(songDetails[id]);
        });
        playingQueue = favouriteSongs; // Asigna la lista de reproducción de canciones favoritas a la cola de reproducción
        playQueue(); // Inicia la reproducción de la cola
    } else {
        // Si no hay canciones favoritas, muestra un mensaje de alerta
        alert("You don't have any favorite song at the moment!!");
    }
});