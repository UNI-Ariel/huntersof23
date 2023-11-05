// Tarjetas decanciones (inicio)
const cards = document.querySelectorAll(".card");

// Botones de reproducción
const playBtn = document.querySelector("#play");
const prevBtn = document.querySelector("#prev");
const nextBtn = document.querySelector("#next");
const muteBtn = document.querySelector("#mute");

// Información de la canción
const audio = document.querySelector("#audio");
const coverImg = document.querySelector("#imgCover");
const title = document.querySelector("#title");
const singerName = document.querySelector("#singerName");

// Controles multimedia
const progressContainer = document.querySelector(".progressContainer");
const progress = document.querySelector(".progress");
const volumeInfo = document.querySelector(".volumeInfo");
const volume = document.querySelector(".volume");

// Entrada de búsqueda


// Variables de revisión
let listSongs = 0;
let searchSongs = 0;
let idActual = 0;
let isPlaying = false;
let currentVol = 1;

// Profile Logo
const profilePics = document.querySelectorAll(".logo");
profilePics.forEach((pic) => {
    pic.addEventListener("click", () => {
        const links = document.querySelectorAll(".logo-links");

        links.forEach((link) => {
            link.classList.toggle("logo-active");
        });
    });
});


// Reproducir canción
function playSong(id) {
    fetch('utils/getSong.php?filter='+id)
    .then(response => response.json()) 
    .then(data => {
        loadSong(data);
        audio.play();
    })
    .catch(error => {
        console.error('Error:', error);
    });

    playBtn.querySelector("i.fas").classList.remove("fa-play");
    playBtn.querySelector("i.fas").classList.add("fa-pause");
    isPlaying = true;
}

// Cargar información de canción
function loadSong(song) {
    audio.src = song[0].audio;
    coverImg.src = song[0].img;
    title.innerText = song[0].title;
    singerName.innerText = song[0].singerName;
}

// Pausar canción
function pauseSong() {
    playBtn.querySelector("i.fas").classList.add("fa-play");
    playBtn.querySelector("i.fas").classList.remove("fa-pause");
    audio.pause();
    isPlaying = false;
}

// Canción siguiente
function nextSong() {
    if(idActual < listSongs.length-1){
        idActual = idActual + 1;
        playSong(listSongs[idActual].id);
    }
}

// Canción anterior
function prevSong() {
    if(idActual > 0){
        idActual = idActual - 1;
        playSong(listSongs[idActual].id);
    }
}

// Canción finalizada
function endSong(){
    if(idActual < listSongs.length-1){
        nextSong();
    }else{
        playSong(listSongs[idActual].id);
    }
}

// Actualizar barra de progreso
function updateProgess(e) {
    const { duration, currentTime } = e.srcElement;
    const progressPercent = (currentTime / duration) * 100;
    progress.style.width = `${progressPercent}%`;
}

// Modificar progreso de canción
function setProgress(e) {
    const width = this.clientWidth;
    const clickX = e.offsetX;

    const duration = audio.duration;
    audio.currentTime = (clickX / width) * duration;
}

// Modificar volumen de canción
function setVolume(e) {
    const width = this.clientWidth;
    const clickX = e.offsetX;
    volumePercent = (clickX / width) * 100;

    currentVol = (clickX / width) * 1;
    audio.volume = currentVol;
    volume.style.width = `${volumePercent}%`;
}

// Asignación Event Listener tarjetas (card)
function addClickEventToCards() {
    const cards = document.querySelectorAll(".card");
    cards.forEach((card) => {
        card.addEventListener("click", () => {
            listSongs = listRecent;
            const songID = card.getAttribute("data");
            idActual = listSongs.findIndex(function(music) {
                return music.id === songID;
            });
            playSong(songID);
        });
    });
}

//Asignación Event Listener botones de reproducción
playBtn.addEventListener("click", () => {
    if (isPlaying) { 
        pauseSong();
    } 
    else { 
        playBtn.querySelector("i.fas").classList.remove("fa-play");
        playBtn.querySelector("i.fas").classList.add("fa-pause");
        audio.play();
        isPlaying = true;
    }
})

nextBtn.addEventListener("click", () => {
    nextSong();
})

prevBtn.addEventListener("click", () => {
    prevSong();
})


// Asignación Event Listener controles multimedia
mute.addEventListener("click", () => {
    if (audio.volume != 0) {
        mute.style.color = "red";
        audio.volume = 0;
        volume.style.width = "0%";
    }else {
        mute.style.color = "#0799B6";
        audio.volume = currentVol;
        volume.style.width = `${(currentVol / 1) * 100}%`;
    }    
})

volumeInfo.addEventListener("click", setVolume);
audio.addEventListener("timeupdate", updateProgess);
audio.addEventListener("ended", endSong);
progressContainer.addEventListener("click", setProgress);