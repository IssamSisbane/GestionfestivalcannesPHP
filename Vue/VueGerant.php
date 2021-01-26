<?php $this->_t = 'Accueil Gerant'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />

<p class="name-welcome"><b>Bienvenue <?= $_SESSION['pseudo']?>,</b> vous pouvez ici gérer vos établissements</p>

<div>
    <a href="index.php?url=hebergement">
        <div class="gerant">
            <div class="access">
            <a href="index.php?url=hebergement"><img src="Assets/images/home-icon.png" class="home-icon"></a>
                <p>Gestion Hebergements</p>
            </div>
        </div>
    </a>
</div>