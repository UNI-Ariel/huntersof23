// Función para agregar una canción a la cola de reproducción
const insertToQueue = (song) => {
    // Verifica si la canción ya está en la cola de reproducción
    if (!playingQueue.includes(song)) {
        playingQueue.push(song); // Agrega la canción a la cola de reproducción
        alert(`Song "${song["title"]}" is added to the queue!!`); // Muestra una alerta
        resetPlayingQueue(); // Restablece la cola de reproducción
    } else {
        alert(`Song "${song["title"]}" is already in the playing queue!!`); // Muestra una alerta si la canción ya está en la cola
    }
};

// Función para agregar o eliminar una canción de favoritos
const addToFav = (song, isFav) => {
    if (!authenticated) {
        loginPopup(); // Muestra un formulario de inicio de sesión si el usuario no está autenticado
    } else {
        const ajaxFile = isFav ? "delFromFav" : "addToFav"; // Determina el archivo AJAX a utilizar

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", `./utils/${ajaxFile}.php?songID=${song.id}`, true);
        xmlhttp.send();

        // Actualiza la lista de canciones favoritas y la interfaz de usuario
        if (isFav) {
            const index = favSongIDs.indexOf(song.id);
            if (index > -1) {
                favSongIDs.splice(index, 1); // Elimina la canción de la lista de favoritos
            }
            removeTileFromFav(); // Actualiza la interfaz de favoritos
        } else {
            favSongIDs.push(song.id); // Agrega la canción a la lista de favoritos
            makeSongTitleForFav(favSongIDs.length - 1, song); // Actualiza la interfaz de favoritos
        }
    }
};

// Función para crear un elemento de título de canción en la interfaz
const makeSongTitle = (index, song) => {
    // Crea un contenedor de título de canción
    const titleContainer = document.createElement("div");
    titleContainer.classList.add("song");
    titleContainer.setAttribute("data", song["id"]);

    // Define el icono del corazón en función de si la canción está en favoritos
    let heartIcon = `<i class="far fa-heart"></i>`;
    if (authenticated) {
        if (favSongIDs.includes(song["id"])) {
            heartIcon = `<i class="fas fa-heart" fav="1"></i>`;
        }
    }

    // Configura el contenido HTML del elemento de título de canción
    titleContainer.innerHTML = `
        <div class="info">
            <h4>${index + 1}</h4>
            <img src="${song["img"]}">
            <div class="detail">
                <h4>${song["title"]}</h4>
                <h5 class="singerPage" data-singer="${song["singerID"]}">${song["singerName"]}</h5>
            </div>
        </div>
        <div class="func" style="color: white">
            ${heartIcon}
            <i class="fas fa-plus"></i>
        </div>
    `;

    // Agrega oyentes de eventos a los botones de reproducción, favoritos y cola
    const playButton = titleContainer.querySelector("h4");
    const favIcon = titleContainer.querySelector("i.fa-heart");
    const queueIcon = titleContainer.querySelector("i.fa-plus");

    playButton.addEventListener("click", () => {
        playImmediate(song); // Reproduce la canción de inmediato
    });

    favIcon.addEventListener("click", () => {
        addToFav(song, favIcon.classList.contains("fas")); // Agrega o quita de favoritos
        if (authenticated) {
            favIcon.className = favIcon.classList.contains("fas") ? "far fa-heart" : "fas fa-heart";
        }
    });

    /* queueIcon.addEventListener("click", () => {
        insertToQueue(song); // Agrega la canción a la cola de reproducción
    }); */

    return titleContainer; // Devuelve el elemento de título de canción
};

// Función para crear un elemento de título de canción en la sección de favoritos
const makeSongTitleForFav = (index, song) => {
    const favContent = document.querySelector(".fav .tileContainer");
    const titleContainer = document.createElement("div");
    titleContainer.classList.add("song");
    titleContainer.setAttribute("data", song["id"]);

    // Configura el contenido HTML del elemento de título de canción
    titleContainer.innerHTML = `
        <div class="info">
            <h4>${index + 1}</h4>
            <img src="${song["img"]}">
            <div class="detail">
                <h4>${song["title"]}</h4>
                <h5 class="singerPage" data-singer="${song["singerID"]}">${song["singerName"]}</h5>
            </div>
        </div>
        <div class="func">
            <i class="fas fa-trash"></i>
            <i class="fas fa-plus"></i>
        </div>
    `;

    // Agrega oyentes de eventos a los botones de reproducción, eliminar de favoritos y cola
    const playButton = titleContainer.querySelector("h4");
    const trashIcon = titleContainer.querySelector("i.fa-trash");
    const queueIcon = titleContainer.querySelector("i.fa-plus");

    playButton.addEventListener("click", () => {
        playImmediate(song); // Reproduce la canción de inmediato
    });

    trashIcon.addEventListener("click", () => {
        // Elimina de favoritos y actualiza la interfaz de búsqueda
        const searchSongTiles = document.querySelectorAll("#search .song");
        searchSongTiles.forEach((tile) => {
            const songID = tile.getAttribute("data");
            if (songID == song.id) {
                const heartIcon = tile.querySelector(".func .fa-heart");
                heartIcon.className = "far fa-heart";
            }
        });
        addToFav(song, true); // Elimina de favoritos
    });

    /* queueIcon.addEventListener("click", () => {
        insertToQueue(song); // Agrega la canción a la cola de reproducción
    }); */

    favContent.appendChild(titleContainer); // Agrega el elemento de título de canción a la sección de favoritos
};

// Función para eliminar un título de canción de la sección de favoritos
const removeTileFromFav = () => {
    const favContent = document.querySelector(".fav .tileContainer");
    favContent.innerHTML = "";
    favSongIDs.forEach((id, index) => {
        makeSongTitleForFav(index, songDetails[id]);
    });
};


document.addEventListener("DOMContentLoaded", function() {
    refrescar();
});

// Actualizar canciones recientes
function refrescar() {
    var xhr = new XMLHttpRequest();

    xhr.onload= function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            let listRecent = JSON.parse(xhr.responseText);
            recentPlay = [];
            let cardsHTML = "";

            listRecent.forEach(function(song) {
                recentPlay.push(song.id);
                cardsHTML += `
                    <div class="card" data="${song.id}">
                        <div class="imgContainer"><img src="${song.img}" alt=""></div>
                        <div class="cardInfo">
                            <h3>${song.title}</h3>
                            <h5>${song.singerName}</h5>
                        </div>
                    </div>`;
            });
            document.querySelector(".cards").innerHTML = cardsHTML;
            addClickEventToCards();
        };
    };

    xhr.open("GET", "./utils/getRecentSongs.php", true);
    xhr.send();
}
