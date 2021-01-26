<?php
if (isset($_GET['message'])) {
    echo "<h1>".$_GET['message']."</h1>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>login</title>
    <link rel="stylesheet" href="Assets/css/style.css">

</head>

<body>

    <div class="login-box">
        <img src="Assets/images/Festival_de_Cannes_Logo.png" class="LogoFestival">
        <h1>Connexion</h1>

        <form method="post">

            <div class="textbox">
                <input type="text" name="lpseudo" id="lpseudo" placeholder="Votre Pseudo"><br />
            </div>

            <div class="textbox">
                <input type="password" name="lpassword" id="lpassword" placeholder="Votre Mot de passe"><br />
            </div>

            <input class="btn" type="submit" name="formlogin" id="formlogin" value="Valider">

        </form>

    </div>

</body>

</html>