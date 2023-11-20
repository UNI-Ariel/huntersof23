<?php
include('./auth.php');

if (!$authenticated) {
    header("Location: ./login.php");
} else {
    if (!$admin) {
        header("Location: ./unauth.php");
    }
}

include("../utils/dbConnection.php");
$sql = "SELECT * FROM singers";
$result = mysqli_query($conn, $sql);
$singers = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artistas</title>
    <link rel="stylesheet" href="./css/editSinger.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container">
        <div class="link">
            <a class="ca2" href="adminDashboard.php">Atras</a>
        </div>

        <table id="customers" align="center" border="1" style="border-color: #fff; background-color: white;" class="displaySinger">
            <tr>
                <th colspan="6">Artistas</th>
            </tr>
            <tr>
                <th>Nº de Registro</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Información </th>
                <th colspan="3">Operaciones</th>
            </tr>


            <?php foreach ($singers as $index => $singer) : if ($index == 100) break; ?>
                <tr>
                    <td><?php echo $singer['id']; ?></td>
                    <td WIDTH="50" HEIGHT="auto" ><img style="width: 50px; height: 50px;" src="<?php echo '../' . $singer['image'] ?>"></td>
                    <td WIDTH="550" max-width="550"  HEIGHT="auto"><?php echo $singer['name']; ?></td>
                    <td WIDTH="550" max-width="550"  ><?php echo $singer['info']; ?></td>
                    <td WIDTH="200" max-width="200"  HEIGHT="auto"><a style="padding: 5px; background-color: #0799B6; color: #fff; border-radius: 15px; text-decoration: none;" href="insertSinger.php?id=<?php echo $singer['id'] ?>"><strong>Editar</strong></a>
                    <a style="padding: 5px; background-color: #E3242B; color: #fff; border-radius: 15px; text-decoration: none;" href="deleteSinger.php?id=<?php echo $singer['id'] ?>"><strong>Eliminar</strong></a></td>
                </tr>
            <?php endforeach; ?>

        </table>
        <div class="c3"><a href=insertSinger.php>Agregar Artista</a></div>
        
    </div>

</body>
<script type="text/javascript">
    function pagination(value) {
        let header = `<tr>
        <th colspan="6">Artistas</th>
            </tr>
            <tr>
                <th>Nº de Registro</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Información </th>
                <th colspan="3">Operaciones</th>
            </tr>`
        let displaySinger = document.getElementsByClassName("displaySinger")[0];
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let results = JSON.parse(this.responseText);;

                let html = '';
                displaySinger.innerHTML = header;

                results.map((value, index) => {
                    html +=
                        ` <tr>
                    <td> ${value['id']}</td>
                    <td WIDTH="50" HEIGHT="auto"><img style="width: 50px; height: 50px;" src='../${value['image']}'></td>
                    <td WIDTH="550" max-width="550">${value['name']}</td>
                    <td WIDTH="550" max-width="550">${value['info']}</td>
                    <td WIDTH="200" max-width="200"><a style="padding: 5px; background-color: #0799B6; color: #fff; border-radius: 15px; text-decoration: none;" href="insertSinger.php?id=<?php echo $singer['id'] ?>"><strong>Editar</strong></a>
                    <a style="padding: 5px; background-color: #E3242B; color: #fff; border-radius: 15px; text-decoration: none;" href="deleteSinger.php?id=<?php echo $singer['id'] ?>"><strong>Eliminar</strong></a></td>
                </tr>`
                })
                displaySinger.innerHTML += html;
            }
        };
        xhttp.open("GET", "paginationSinger.php?page=" + value, true);
        xhttp.send();
    }
</script>

</html>