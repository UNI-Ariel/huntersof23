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

<!-- Sección canciones recientes -->
<div>
    <div class="sectionRecent">
        <h1 class="sectionTitle" style="color: white">Canciones Recientes</h1>
        <button class="btn-refresh" onclick="refrescar();">
            <i class="fa fa-sync-alt fa-2x"></i>
        </button>
    </div>

    <div class="cards">
        <?php foreach ($randomKeys as $key) : ?>
            <div class="card" data="<?php echo $songs[$key]["id"]; ?>">
                <div class="imgContainer">
                    <img src="<?php echo $songs[$key]["img"]; ?>" alt="">
                </div>
                <div class="cardInfo">
                    <h3><?php echo $songs[$key]["title"]; ?></h3>
                    <h5><?php echo $songs[$key]["singerName"]; ?></h5>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="./js/slider.js"></script>