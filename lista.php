<?php
include("./index.php");
?>
<script src="http://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    showContent("lista");
</script>
<script>
    
   let listSongs = JSON.parse('<?php echo json_encode($songs); ?>');
    const pulseBtn = document.querySelector(".pulse");
    pulseBtn.addEventListener("click", () => {
       playingQueue = listSongs;
       songIndex = 0;
        playQueue();
    })
</script>