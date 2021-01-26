<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $_t ?></title>
</head>

<header>
    <h1><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><</a></h1>
    <h1 class="titree"><a href="index.php"><img src="Assets/images/Festival_de_Cannes_Logo.png" style="width: 10%;"></a></h1>
    <div class="user-infos">
        <p class="name" id="item"><?= $_SESSION['pseudo']?> <img src="Assets/images/user.png" class="user-icon"></p>
        <a href="#" id="item">Paramètres</a>
        <a href="index.php?action=deconnexion" id="item">Deconnexion</a>

        <?php if ($_SESSION['type_utilisateur_id'] == 4) {?>
            <p id="item">Vous etes un Gerant</p>
            <?php }else{ ?>
            <p id="item">Vous etes un Membre du Staff</p>
            <?php } ?>
    </div>
</header>

<body>
    <?php
    if (isset($_GET['message'])) {
        echo "<h1>".$_GET['message']."</h1>";
    }
    ?>
    <?= $content ?>
    
</body>

<footer>
    <p>créé par DataTech</p>
 </footer>

</html>