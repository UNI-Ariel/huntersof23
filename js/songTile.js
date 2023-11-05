const insertToQueue = (song) => {
    if (!playingQueue.includes(song)) {
        playingQueue.push(song);
        alert(`Songs ${song["title"]} is added to queue!!`);
        resetPlayingQueue();
    } else {
        alert(`Songs ${song["title"]} is already in playing queue!!`);
    }
};

const addToFav = (song, isFav) => {
    if (!authenticated) {
        loginPopup();
    } else {
        const ajaxFile = isFav ? "delFromFav" : "addToFav";

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", `./utils/${ajaxFile}.php?songID=${song.id}`, true);
        xmlhttp.send();

        if (isFav) {
            const index = favSongIDs.indexOf(song.id);
            if (index > -1) {
                favSongIDs.splice(index, 1);
            }
            removeTileFromFav();
        } else {
            favSongIDs.push(song.id);
            makeSongTitleForFav(favSongIDs.length - 1, song);
        }
        favorit();
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
        <div class="func">
            ${heartIcon}
            <i class="fas fa-list-ul"></i>
        </div>
    `;

    // Agrega oyentes de eventos a los botones de reproducción, favoritos y cola
    const playButton = titleContainer.querySelector("h4");
    const favIcon = titleContainer.querySelector("i.fa-heart");
    const queueIcon = titleContainer.querySelector("i.fa-list-ul");

    playButton.addEventListener("click", () => {
        listSongs = listSearch;
        idActual = listSongs.findIndex(function(music) {
            return music.id === song["id"];
        });
        playSong(song["id"]);
    });

    favIcon.addEventListener("click", () => {
        addToFav(song, favIcon.classList.contains("fas")); // Agrega o quita de favoritos
        if (authenticated) {
            favIcon.className = favIcon.classList.contains("fas") ? "far fa-heart" : "fas fa-heart";
        }
    });

    queueIcon.addEventListener("click", () => {
        insertToQueue(song); // Agrega la canción a la cola de reproducción
    });

    return titleContainer; // Devuelve el elemento de título de canción
};


const makeSongTitleForFav = (index, song) => {
    const favContent = document.querySelector(".fav .tileContainer");
    const titleContainer = document.createElement("div");
    titleContainer.classList.add("song");
    titleContainer.setAttribute("data", song["id"]);

    titleContainer.innerHTML = `
    <div class="info">
        <h4>${index + 1}</h4>
        <img src="${song["img"]}">
        <div class="detail">
            <h4>${song["title"]}</h4>
            <h5 class="singerPage" data-singer="${song["singerID"]}">${
        song["singerName"]
    }</h5>
        </div>
    </div>
    <div class="func">
        <i class="fas fa-trash"></i>
        <i class="fas fa-list-ul"></i>
    </div>
    `;

    const playButton = titleContainer.querySelector("h4");
    const trashIcon = titleContainer.querySelector("i.fa-trash");
    const queueIcon = titleContainer.querySelector("i.fa-list-ul");

    playButton.addEventListener("click", () => {
        listSongs = listFavourites;
        idActual = listSongs.findIndex(function(music) {
            return music.id === song["id"];
        });
        playSong(song["id"]);
    });

    trashIcon.addEventListener("click", () => {
        const searchSongTiles = document.querySelectorAll("#search .song");
        searchSongTiles.forEach((tile) => {
            const songID = tile.getAttribute("data");

            if (songID == song.id) {
                const heartIcon = tile.querySelector(".func .fa-heart");
                heartIcon.className = "far fa-heart";
            }
        });
        addToFav(song, true);
    });

    queueIcon.addEventListener("click", () => {
        insertToQueue(song);
    });

    favContent.appendChild(titleContainer);
};

const removeTileFromFav = () => {
    const favContent = document.querySelector(".fav .tileContainer");
    favContent.innerHTML = "";
    favSongIDs.forEach((id, index) => {
        makeSongTitleForFav(index, songDetails[id]);
    });
};
