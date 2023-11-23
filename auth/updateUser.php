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
$sql = "SELECT * FROM users WHERE id!='1'";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="./css/editSong.css">
</head>

<body>
    <div class="container-User">
        <div class="link">
            <a class="ca2" href="adminDashboard.php">Atrás</a>
        </div>

        <h2>Usuarios Registrados</h2>
        <table align="center" border="2" class="displayUser">
            <tr>
                <th>No</th>
                <th>Nombre Usuario</th>
                <th>Admin</th>
            </tr>
            <?php foreach ($users as $index => $user) : ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <div class="checkbox-style"></div>
                    <td><input type="checkbox" name="<?php echo $user['id'] ?>" id="<?php echo $user['id'] ?>" <?php if ($user['groupID'] == 1) : ?> checked <?php endif; ?> <?php if ($user['id'] == $uid) : ?> fromUser <?php endif; ?>></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="message">
        </div>
    </div>
    <div class="rolModal">
        <div class="contentRolModal">
            <p>Actualización realizada con éxito</p>
            <button class="close">Aceptar</button>
        </div>
    </div>

    <script>
        const checkboxes = document.querySelectorAll("input[type=checkbox]");
        const rolModal = document.querySelector(".rolModal");
        const pageContainer = document.querySelector(".container-User");
        const closeModal = document.querySelector(".rolModal .close");


        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("input", () => {
                if (checkbox.hasAttribute('fromuser')) {
                    //alert("You can not change your own role!!!")
                    checkbox.checked = !checkbox.checked;
                } else {
                    const id = checkbox.id;
                    const admin = (checkbox.checked) ? 1 : 2;
                    pageContainer.classList.add("blur");
                    rolModal.classList.add("active");

                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            if (this.responseText !== "") {
                                //showMessage(this.responseText);
                            }
                        }
                    };
                    
                    closeModal.addEventListener("click", () => {
                        pageContainer.classList.remove("blur");
                        rolModal.classList.remove("active");
                    });

                    xmlhttp.open("GET", `changeRole.php?uid=${id}&admin=${admin}`, true);
                    xmlhttp.send();
                }
            })
        });
    </script>
</body>

</html>