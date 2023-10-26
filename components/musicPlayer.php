<div class="musicPlayerContainer">
    <div class="musicInfo">
        <img id="imgCover" src="./images/logo.png" alt="">
        <div class="musicDetail">
            <h4 id="title"></h4> <!-- Título de la canción -->
            <h5 id="singerName" style="color:white"></h5> <!-- Nombre del cantante -->
        </div>
        <!-- Icono para agregar a favoritos (comentado) -->
        <!-- <i class="far fa-heart"></i> -->
    </div>
    <div class="musicPlayer">
        <div class="navigation">
            <button id="prev" class="action-btn">
                <i class="fas fa-backward"></i> <!-- Botón de reproducción anterior -->
            </button>
            <button id="play" class="action-btn action-btn-big">
                <i class="fas fa-play"></i> <!-- Botón de reproducción/pausa -->
            </button>
            <button id="next" class ="action-btn">
                <i class="fas fa-forward"></i> <!-- Botón de reproducción siguiente -->
            </button>
        </div>
        <div class="progressContainer">
            <div class="progress"></div> <!-- Barra de progreso de la canción -->
        </div>
        <audio id="audio" src="#"></audio> <!-- Elemento de audio para reproducir la canción -->
    </div>
    <div class="funcContainer">
        <img id="playtist" src="./images/icons/queue.png" alt="" /> <!-- Icono de lista de reproducción -->
        <i class="fas fa-volume-up" id="mute"></i> <!-- Icono para silenciar -->
        <div class="volumeInfo">
            <div class="volume"></div> <!-- Barra de volumen -->
        </div>
    </div>
    <div class="queue">
        <div class="queue-title">
            <h3 style="color: white">Reproduciendo</h3> <!-- Título de la lista de reproducción actual -->
            <i class="fas fa-chevron-up"></i> <!-- Icono para ocultar la lista de reproducción -->
        </div>
        <ul class="playing-songs">
            <!-- Lista de canciones en la lista de reproducción actual -->
        </ul>
    </div>
</div>
