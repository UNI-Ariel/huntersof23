const playRecentButton = document.querySelector(".playAllRecent");

playRecentButton.addEventListener("click", () => {
    if (recentPlay.length > 0) {
        let reSongs = [];
        console.log(recentPlay);
        recentPlay.forEach((id) => {
            reSongs.push(songDetails[id]);
        });
        playingQueue = reSongs; // Asigna la lista de reproducción de canciones favoritas a la cola de reproducción
        playQueue(); // Inicia la reproducción de la cola
    } else {
        // Si no hay canciones favoritas, muestra un mensaje de alerta
        alert("You don't have any favorite song at the moment!!");
    }
});