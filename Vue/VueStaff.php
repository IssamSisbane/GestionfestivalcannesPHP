<?php $this->_t = 'Accueil Staff'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />

<p class="name-welcome"><b>Bienvenue <?= $_SESSION['pseudo']?>,</b> Voici le Menu Principal</p>

<div class="menu">
    <div>
        <a href="index.php?url=hebergement">
            <div class="gerant">
                <div class="access">
                <a href="index.php?url=hebergement"><img src="Assets\images\home-icon.png" class="home-icon"></a>
                    <p>Gestion Hebergements</p>
                </div>
            </div>
        </a>
    </div>

    <div>
        <a href="index.php?url=vip">
            <div class="gerant">
                <div class="access">
                <a href="index.php?url=vip"><img src="Assets\images\vip-card.png" class="home-icon"></a>
                    <p>Gestion Vips</p>
                </div>
            </div>
        </a>
    </div>

    <div>
        <a href="index.php?url=reservation">
            <div class="gerant">
                <div class="access">
                <a href="index.php?url=reservation"><img src="Assets\images\reservation.png" class="home-icon"></a>
                    <p>Gestion Reservation</p>
                </div>
            </div>
        </a>
    </div>
</div>