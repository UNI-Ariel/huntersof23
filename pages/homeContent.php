<?php include('./components/navbar.php'); ?>
<link rel="stylesheet" href="./css/style.css">

<section class="testimony">

    <div class="testimony_container container">
        <img src="./images/leftarrow.svg" class="testimony_arrow" id="beforee">
<!--SECTION 1-->        
        <section class="testimony_body testimony_body--show" data-id="1">
            <div class="testimony_texts">
                <h2 class="subtitle" > SpottPlay (aniadir texto de prefefrencia devs),  </h2>
                <p class="testimony_review"> aqui hagan full publicidad respecto al tema

                </p>
            </div>
            <figure class="testimony_picture">
                <img src="./images/chica.jpg" class="testimony_img">
        
            </figure>
        </section>
<!--SECTION 2--> 
        <section class="testimony_body " data-id="2">
            <div class="testimony_texts">
                <h2 class="subtitle" > aqui igual FULL publicidad  </h2>
                <p class="testimony_review"> aqui hagan full publicidad respecto al tema

                </p>
            </div>
            <figure class="testimony_picture">
                <img src="./images/chica1.jpg" class="testimony_img">
        
            </figure>
        </section>
<!--SECTION 3--> 
        <section class="testimony_body " data-id="3">
            <div class="testimony_texts">
                <h2 class="subtitle" > SpottPlay (aniadir texto de prefefrencia devs),  </h2>
                <p class="testimony_review"> aqui hagan full publicidad respecto al tema

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
    <h1 class="sectionTitle" style="color: white">Nuevas Canciones</h1>
    <div class="cards">
        <div class="card" data="<?php echo $songs[0]["id"]; ?>">
            <div class="imgContainer">
                <img src="<?php echo $songs[0]["img"]; ?>" alt="">
            </div>
            <div class="cardInfo">
                <h3><?php echo $songs[0]["title"]; ?></h3>
                <h5><?php echo $songs[0]["singerName"]; ?></h5>
            </div>
        </div>
        <div class="card" data="<?php echo $songs[1]["id"]; ?>">
            <div class="imgContainer">
                <img src="<?php echo $songs[1]["img"]; ?>" alt="">
            </div>
            <div class="cardInfo">
                <h3><?php echo $songs[1]["title"]; ?></h3>
                <h5><?php echo $songs[1]["singerName"]; ?></h5>
            </div>
        </div>
    </div>
</section>
<script src="./js/slider.js"></script>