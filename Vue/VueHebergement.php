<?php $this->_t = 'Hebergement'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/hebergement.css" rel="stylesheet" />

<?php if ($_SESSION['type_utilisateur_id'] == 4) { ?>
    <p class="name-welcome"><b>Voici</b> la liste de vos hebergements (<?= count($hebergements)?>)</p>
<?php }else{ ?>
    <p class="name-welcome"><b>Voici</b> la liste des hebergements (<?= count($hebergements)?>)</p>
<?php } ?>

<div class="hebergements">
    <?php
    if ($hebergements != null) {

        foreach ($hebergements as $hebergement) : {
    ?>
                <div>
                    <?php
                    $so = serialize($hebergement); // Génère une représentation stockable d'une valeur
                    $soe = urlencode($so); //Encode une chaîne en URL
                    ?>
                    <div class="item-carre">
                        <div id="carre">
                            <a href="index.php?url=hebergement&action=afficher&hebergement=<?= $soe ?>">Gestion</a>
                            <a href="index.php?url=hebergement&action=afficherReservations&hebergement=<?= $soe ?>">Reservations</a>
                        </div>
                        <p><?= $hebergement->get_id() ?></p>
                        <p><?= $hebergement->get_nom() ?></p>
                    </div>
                </div>
        <?php
            }
        endforeach;
    } else {
        ?>
        <p>Aucun Hebergement n'a été ajouté</p>
    <?php
    }
    ?>
    <a id="ajouter" href="index.php?url=hebergement&action=ajouter"><p>+</p></a>
</div>
