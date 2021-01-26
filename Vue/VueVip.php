<?php $this->_t = 'Vip'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/vip.css" rel="stylesheet" />

<p class="name-welcome"><b>Voici </b> la liste des Vips (<?= count($vips) ?>)</p>

<div class="boutonsVIP">
    <a id="ajouter" href="index.php?url=vip&action=ajouter&class=MembreJury">Ajouter Membre Jury</a>
    <a id="ajouter" href="index.php?url=vip&action=ajouter&class=MembreEquipe">Ajouter Membre Equipe De Film</a>
    <a id="ajouter" href="index.php?url=vip&action=ajouter&class=Invite">Ajouter Invite</a>
</div>







<div class="vips">
    
    <div class="item-carre">
            <div id="carre" style="border: solid grey 2px;color: white;background-color: #2d2d2d;color: white;">
                <div class="MembreJury" style="color: white;">
                    <p>Nom</p>
                    <p>Prenom</p>
                    <p>Type</p>
                    <p>Id</p>
                </div>
            </div>
    </div>
    <?php

    if ($vips != null) {

        foreach ($vips as $vip) : {
    ?>
                <?php
                $so = serialize($vip); // Génère une représentation stockable d'une valeur
                $soe = urlencode($so); //Encode une chaîne en URL
                ?>
                <div class="item-carre">
                    <a href="index.php?url=vip&action=afficher&vip=<?= $soe ?>">
                        <div id="carre">
                            <div class=<?= get_class($vip); ?>>
                                <p><?= $vip->get_nom() ?></p>
                                <p><?= $vip->get_prenom() ?></p>
                                <p><?= get_class($vip); ?></p>
                                <p><?= $vip->get_id() ?></p>
                            </div>
                        </div>
                    </a>
                </div>
        <?php
            }
        endforeach;
    } else {
        ?>
        <p>Aucun Vip n'a été ajouté</p>
    <?php
    }
    ?>
</div>