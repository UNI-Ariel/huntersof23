let now_playing = document.querySelector('.now-playing');
let track_art = document.querySelector('.track-art');
let track_name = document.querySelector('.track-name');
let track_artist = document.querySelector('.track-artist');

let playpause_btn = document.querySelector('.playpause-track');
let next_btn = document.querySelector('.next-track');
let prev_btn = document.querySelector('.prev-track');

let seek_slider = document.querySelector('.seek_slider');
let volume_slider = document.querySelector('.volume_slider');
let vol = document.querySelector('.vol');
let curr_time = document.querySelector('.current-time');
let total_duration = document.querySelector('.total-duration');
let wave = document.getElementById('wave');
let randomIcon = document.querySelector('.fa-random');
let curr_track = document.createElement('audio');

let track_index = 0;
let isPlaying = false;
let isRandom = false;
let updateTimer;

const inputBusqueda = document.getElementById('inputBusqueda');
const mensaje0Advertencia = document.getElementById('mensajeAdvertencia');

const botonBusqueda = document.getElementById('botonBusqueda');
const resultadosNoEncontrados = document.getElementById('resultadosNoEncontrados');
const tarjetas = document.querySelectorAll('.tarjeta');


inputBusqueda.addEventListener('input', () => {
    const longitudTexto = inputBusqueda.value.length;
    if (longitudTexto >= 2 && longitudTexto <= 52) {
        mensajeAdvertencia.style.display = 'none';
    } else {
        mensajeAdvertencia.style.display = 'block';
    }
});


const music_list = [
    {
        img : 'stay.png',
        name : 'Stay',
        artist : 'The Kid LAROI, Justin Bieber',
        music : 'music/stay.mp3'
    },
    {
        img : 'fallingdown.jpg',
        name : 'Falling Down',
        artist : 'Wid Cards',
        music : 'music/fallingdown.mp3'
    },
    {
        img : 'faded.png',
        name : 'Faded',
        artist : 'Alan Walker',
        music : 'music/Faded.mp3'
    },
    {
        img : 'ratherbe.jpg',
        name : 'Rather Be-12',
        artist : 'Clean Bandit ft Jess Glynne',
        music : 'music/Rather Be-12.mp3'
    },
    {
        img : 'bloodymary.jpg',
        name : 'bloody mary',
        artist : 'Lady gaga',
        music : 'music/Bloody Mary.mp3'
    }
];



loadTrack(track_index);

function loadTrack(track_index){
    clearInterval(updateTimer);
    reset();

    curr_track.src = music_list[track_index].music;
    curr_track.load();

    let imgPath = `images/${music_list[track_index].img}`;
    track_art.style.backgroundImage = `url(${imgPath})`;

    /*track_art.style.backgroundImage = "url(" + music_list[track_index].img + ")";

    track_art.style.backgroundSize = "cover";  // Ajustar tamaño de la imagen
    track_art.style.backgroundRepeat = "no-repeat";  // Evitar repetición de la imagen
*/
    
    track_name.textContent = music_list[track_index].name;
    track_artist.textContent = music_list[track_index].artist;
   // now_playing.textContent = "Playing music " + (track_index + 1) + " of " + music_list.length;

    updateTimer = setInterval(setUpdate, 1000);

    curr_track.addEventListener('ended', nextTrack);
    random_bg_color();
}

// Añade un evento click a los títulos de las canciones para cargar y reproducir la canción correspondiente
document.querySelectorAll(".titulo").forEach((titulo, index) => {
    titulo.addEventListener("click", () => {
        loadTrack(index); // Carga la canción correspondiente al índice del título
        playTrack(); // Reproduce la canción
    });
});
// Añade un evento click a las imágenes de las canciones para cargar y reproducir la canción correspondiente
document.querySelectorAll(".imagen-musica").forEach((imagen, index) => {
    imagen.addEventListener("click", () => {
        loadTrack(index); // Carga la canción correspondiente al índice de la imagen
        playTrack(); // Reproduce la canción
    });
});

function random_bg_color(){
    let hex = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e'];
    let a;

    function populate(a){
        for(let i=0; i<6; i++){
            let x = Math.round(Math.random() * 14);
            let y = hex[x];
            a += y;
        }
        return a;
    }
    let Color1 = populate('#101010');
    let Color2 = populate('##101010');
    var angle = 'to right';

    let gradient = 'linear-gradient(' + angle + ',' + Color1 + ', ' + Color2 + ")";
    document.body.style.background = gradient;
}
function reset(){
    curr_time.textContent = "00:00";
    total_duration.textContent = "00:00";
    seek_slider.value = 0;
}
function randomTrack(){
    isRandom ? pauseRandom() : playRandom();
}
function playRandom(){
    isRandom = true;
    randomIcon.classList.add('randomActive');
}
function pauseRandom(){
    isRandom = false;
    randomIcon.classList.remove('randomActive');
}
function repeatTrack(){
    let current_index = track_index;
    loadTrack(current_index);
    playTrack();
}
function playpauseTrack(){
    isPlaying ? pauseTrack() : playTrack();
}
function playTrack(){
    curr_track.play();
    isPlaying = true;
    track_art.classList.add('rotate');
    wave.classList.add('loader');
    playpause_btn.innerHTML = '<i class="fa fa-pause-circle fa-5x"></i>';
}
function pauseTrack(){
    curr_track.pause();
    isPlaying = false;
    track_art.classList.remove('rotate');
    wave.classList.remove('loader');
    playpause_btn.innerHTML = '<i class="fa fa-play-circle fa-5x"></i>';
}
function nextTrack(){
    if(track_index < music_list.length - 1 && isRandom === false){
        track_index += 1;
        loadTrack(track_index);
        playTrack();
        prev_btn.innerHTML='<i  style="color: #0799B6;" class="fa fa-step-backward fa-2x"></i>';
        
    }else if(track_index < music_list.length - 1 && isRandom === true){
        
        let random_index = Number.parseInt(Math.random() * music_list.length);
        track_index = random_index;  
    }
    else{
        next_btn.innerHTML='<i  style="color: #898c8d;" class="fa fa-step-forward fa-2x"></i>';
    }
}
function prevTrack(){
    if(track_index > 0){
        track_index -= 1;
        loadTrack(track_index);
        playTrack();
        next_btn.innerHTML='<i  style="color: #0799B6;" class="fa fa-step-forward fa-2x"></i>';
    }
    else{
        prev_btn.innerHTML='<i  style="color: #898c8d;" class="fa fa-step-backward fa-2x"></i>';
    }
}
function seekTo(){
    let seekto = curr_track.duration * (seek_slider.value / 100);
    curr_track.currentTime = seekto;
}
function setVolume(){
    if( curr_track.volume = volume_slider.value / 100){
        vol.style='color: #0799B6;';
       }
      
        else{
            vol.style='color: #a9200b;'; 
            
        }
}
function setUpdate(){
    let seekPosition = 0;
    if(!isNaN(curr_track.duration)){
        seekPosition = curr_track.currentTime * (100 / curr_track.duration);
        seek_slider.value = seekPosition;

        let currentMinutes = Math.floor(curr_track.currentTime / 60);
        let currentSeconds = Math.floor(curr_track.currentTime - currentMinutes * 60);
        let durationMinutes = Math.floor(curr_track.duration / 60);
        let durationSeconds = Math.floor(curr_track.duration - durationMinutes * 60);

        if(currentSeconds < 10) {currentSeconds = "0" + currentSeconds; }
        if(durationSeconds < 10) { durationSeconds = "0" + durationSeconds; }
        if(currentMinutes < 10) {currentMinutes = "0" + currentMinutes; }
        if(durationMinutes < 10) { durationMinutes = "0" + durationMinutes; }

        curr_time.textContent = currentMinutes + ":" + currentSeconds;
        total_duration.textContent = durationMinutes + ":" + durationSeconds;
    }
}

function reproducirCancion(rutaCancion) {
    // Detiene la canción actual si se está reproduciendo
    if (isPlaying) {
        pauseTrack();
    }

    // Carga y reproduce la nueva canción
    curr_track.src = rutaCancion;
    curr_track.load();
    loadTrack(track_index);
    playTrack();
}
  // JavaScript para la funcionalidad del buscador

  document.addEventListener("DOMContentLoaded", function () {
    const inputBusqueda = document.getElementById("inputBusqueda");
    const botonBusqueda = document.getElementById("botonBusqueda");
    const tarjetas = document.querySelectorAll(".tarjeta");
    const resultadosNoEncontrados = document.getElementById("resultadosNoEncontrados");

    botonBusqueda.addEventListener("click", realizarBusqueda);

    function realizarBusqueda() {
        const terminoBusqueda = inputBusqueda.value.trim().toLowerCase();
        //inputBusqueda.addEventListener();
        //Verificar que el término de búsqueda tenga al menos 2 caracteres alfanuméricos
        if (terminoBusqueda.length < 2 || terminoBusqueda.length > 52) {
           // alert("Ingrese entre 2 y 52 caracteres alfanuméricos para buscar.");
            return;
        } 

        // Ocultar mensaje de "resultados no encontrados"
        resultadosNoEncontrados.style.display = "none";

        // Realizar la búsqueda y mostrar resultados
        let resultadosEncontrados = 0;

        tarjetas.forEach((tarjeta) => {
            const titulo = tarjeta.querySelector(".titulo").textContent.toLowerCase();
            const artista = tarjeta.querySelector(".artista").textContent.toLowerCase();

            if (titulo.includes(terminoBusqueda) || artista.includes(terminoBusqueda)) {
                tarjeta.style.display = "block";
                resultadosEncontrados++;
            } else {
                tarjeta.style.display = "none";
            }
        });

        // Mostrar mensaje de "resultados no encontrados" si no se encontraron resultados
        if (resultadosEncontrados === 0) {
            resultadosNoEncontrados.style.display = "block";
        }

    }
     // Función para cerrar el cuadro de mensaje al hacer clic en "Aceptar"
     function cerrarMensajeEmergente() {
        mensajeEmergente.style.display = "none"; // Ocultar el cuadro de mensaje
    }

    // Asociar la función de cierre al botón "Aceptar"
    botonAceptar.addEventListener("click", cerrarMensajeEmergente);
});
function toggleMenu() {
    const menu = document.querySelector('.menu');
    menu.classList.toggle('active');

    const menuToggle = document.querySelector('.menu-toggle');
    menuToggle.classList.toggle('active');
  }
  function toggleMenuClose() {
    const menu = document.querySelector('.menu');
    menu.classList.remove('active');

    const menuToggle = document.querySelector('.menu-toggle');
    menuToggle.classList.remove('active');
}





