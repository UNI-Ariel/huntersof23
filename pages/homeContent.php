<?php include('./components/navbar.php'); ?>
<link rel="stylesheet" href="./css/style.css">

<section class="testimony">

    <div class="testimony_container container">
        <img src="./images/leftarrow.svg" class="testimony_arrow" id="beforee">
<!--SECTION 1-->        
        <section class="testimony_body testimony_body--show" data-id="1">
            <div class="testimony_texts">
                <h2 class="subtitle" >Bienvenidos a Spottplay</h2>
                <p class="testimony_review"> Comienza tu aventura musical
                </p>
                <?php if (!$authenticated) : ?>
                <p>
                <a href="./auth/login.php" class="login">Iniciar Sesión</a>
                <p>
                <a  id="txtreg" href="./auth/signup.php" class="ca">¿No tienes una cuenta? Registrate</a>
                <?php endif; ?>
            </div>
            <figure class="testimony_picture">
                <img src="./images/chica.jpg" class="testimony_img">
        
            </figure>
        </section>
<!--SECTION 2--> 
        <section class="testimony_body " data-id="2">
            <div class="testimony_texts">
                <h2 class="subtitle" > Las canciones que te gustan  </h2>
                <p class="testimony_review"> Todo en un solo sitio

                </p>
            </div>
            <figure class="testimony_picture">
                <img src="./images/chica1.jpg" class="testimony_img">
        
            </figure>
        </section>
<!--SECTION 3--> 
        <section class="testimony_body " data-id="3">
            <div class="testimony_texts">
                <h2 class="subtitle" > Todo sin coste alguno </h2>
                <p class="testimony_review"> Comienza a escuchar ya!

                </p>
            </div>
            <figure class="testimony_picture">
                <img src="./images/chica0.jpg" class="testimony_img">
        
            </figure>
        </section>
        <img src="./images/rightarrow.svg" class="testimony_arrow" id="nextt">
        

    </div>



</section>
<section>
    <div class="sectionRecent">
        <h1 class="sectionTitle">Canciones Recientes</h1>
        <button class="btn-refresh" onclick="refrescar();">
            <i class="fa fa-sync-alt fa-2x"></i>
        </button>
    </div>

    <div class="cards">
    </div>

    <script>
        $(document).ready(function() {
            refrescar();
        });

        function refrescar(){
            $.ajax({
                url: "./utils/getRecentSongs.php",
                type: "GET",

            success: function(response) {
                console.log(response);
                var songs = JSON.parse(response);
                var cardsHTML = "";

                songs.forEach(function(song) {
                cardsHTML += `
                    <div class="card" data="${song.id}">
                        <div class="imgContainer"><img src="${song.img}" alt=""></div>
                        <div class="cardInfo">
                            <h3>${song.title}</h3>
                            <h5 class="sectionTitle">${song.singerName}</h5>
                        </div>
                    </div>`;
                });
                $(".cards").html(cardsHTML);

                addClickEventToCards();
            },
            error: function() {
                alert("Hubo un error al refrescar las canciones");
            }
        });
        }
    </script>

</section>
<script src="./js/slider.js"></script>