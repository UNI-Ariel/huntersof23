<nav>
    <div class="searchContainer hide">
        <div class="searchBox">
            <input type="text" name="search" spellcheck="false" class="search" placeholder="Artistas, canciones.." style="margin: 0">
            <div class="icon">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
    <div class="logo-container">    
    <img src="<?php echo $userimage; ?>" alt="Imagen Usuario" class="logo">
        <?php
        //<img src="./images/users/default.png" alt="" class="logo">
        ?>
        <ul class="logo-links">
            <h3><?php echo $username; ?></h3>
            <?php if ($authenticated) : ?>
                <li><a href="./auth/editProfile.php">Editar Perfil</a></li>
                <?php if ($admin) : ?>
                    <li><a href="./auth/adminDashboard.php">Panel de Control</a></li>
                <?php endif; ?>
                <li><a href="./auth/logout.php">Cerrar Sesión</a></li>
            <?php else : ?>
                <li><a href="./auth/login.php">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?php 
    if ($authenticated){
        $sql = "SELECT username FROM users WHERE id=$uid";
        $result = mysqli_query($conn, $sql);
        $username = mysqli_fetch_assoc($result)['username'];
    }    
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function refreshUsername() {
        const mod = document.querySelector(".logo-links h3");
        mod.innerHTML = <?php echo json_encode($username); ?>;
        }
        
        refreshUsername();
    });
</script>