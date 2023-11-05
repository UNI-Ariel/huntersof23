let ListRecent = 0;
let listSearch = 0;
let listFavourites = 0;

const inputSearchs = document.querySelectorAll(".search");
inputSearchs.forEach((inputSearch) => {
    inputSearch.addEventListener("input", search);
});

// Cargar listas iniciales
document.addEventListener("DOMContentLoaded", function() {
    refrescar();
    search();
    favorit();
});

// Buscar canciones en tiempo real
function search(e) {
    let filterTexts = "";
    if(e != null){
        filterTexts = e.target.value;
    }

    window.history.pushState(
        "",
        "",
        pageUrl + "/" + "search.php?search=" + filterTexts
    );

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText !== "") {
                listSearch = JSON.parse(this.responseText);
                const songsContain = document.querySelector(".songsContain");
                songsContain.innerHTML = "";

                listSearch.forEach((song, index) => {
                    const newTitle = makeSongTitle(index, song);
                    songsContain.appendChild(newTitle);
                });
            }
        }
    };
    xmlhttp.open("GET", "./utils/getSongs.php?filter=" + filterTexts, true);
    xmlhttp.send();
}


// Actualizar canciones recientes
function refrescar() {
    var xhr = new XMLHttpRequest();
    xhr.onload= function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            listRecent = JSON.parse(xhr.responseText);
            listSongs = listRecent;
            let cardsHTML = "";

            listRecent.forEach(function(song) {
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


function favorit() {
    var xhrm = new XMLHttpRequest();
    xhrm.onload= function() {
        if (xhrm.status >= 200 && xhrm.status < 300) {
            listFavourites = JSON.parse(xhrm.responseText);
            console.log(listFavourites);  
            listFavourites.forEach((song, index) => {
                makeSongTitleForFav(index, song);
            });
        };
    };
    xhrm.open("GET", "./utils/getFavourites.php", true);
    xhrm.send();
}

