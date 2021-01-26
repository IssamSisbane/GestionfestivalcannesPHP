<?php $this->_t = 'VipAffiche'; 
$vipSerialise = serialize($vip); // Génère une représentation stockable d'une valeur
$vipEncode = urlencode($vipSerialise);
?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/vip.css" rel="stylesheet" />

<div class="boutonsVIP">
    <a id="supprimer" href="index.php?url=vip&action=supprimer&vip=<?=$vipEncode?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ?');">Supprimer</a>
</div>

<form method="post">

    <input class="btn" type="submit" name="submitModif" id="valider" value="valider">

    <div class="form-vips">
        <div id="form-item">
            <div class="textbox">
                <label for="id">Id :</label>
                <input type="number" for="id" name="id" required value=<?php echo $vip->get_id(); ?>>
            </div>
        </div>

        <div id="form-item">
            <div class="textbox">
                <label for="nom">Nom : </label>
                <input type="text" for="nom" name="nom" required value=<?php echo $vip->get_nom(); ?>>
            </div>

            <div class="textbox">
                <label for="prenom">Prenom : </label>
                <input type="text" for="prenom" name="prenom" required value=<?php echo $vip->get_prenom(); ?>>
            </div>

            <div class="textbox">
                <label for="dateNaissance">dateNaissance : </label>
                <input type="date" for="dateNaissance" name="dateNaissance" min="1920-01-01" max="2003-01-01" required value=<?php echo $vip->get_dateNaissance(); ?>>
            </div>
         </div>

        <div id="form-item">
            <?php
            if ($vip->get_serviceHebergement() == 0) { // on coche la case selon la valeur
            ?>

                <div class="textbox">
                    <label name="hebergementLabel" for="Service_Hebergement">Service Hebergement</label>
                    <input for="hebergementLabel" type="checkbox" id="Service_Hebergement" name="Service_Hebergement" value="Service Hebergement">

                </div>
            <?php
            } else {
            ?>
                <div class="textbox">
                <label id="hebergementLabel" for="Service_Hebergement">Service Hebergement</label>
                <input for="hebergementLabel" type="checkbox" id="Service_Hebergement" name="Service_Hebergement" value="Service Hebergement" checked>

                </div>
            <?php
            }
            ?>

            <div>
                <label id="juryLabel" for="special">Choisir Le Jury :</label>
                <select for="juryLabel" id="jury" name="special" >

                    <?php foreach ($elements as $jury) : 
                        if($selectionne == $jury->get_libelle()) {?>
                            <option value="<?= $jury->get_libelle() ?>"selected><?= $jury->get_libelle() ?> </option>
                    <?php }else{ ?>
                            <option value="<?= $jury->get_libelle() ?>"><?= $jury->get_libelle() ?> </option>
                    <?php }endforeach; ?>
            </div>
        </div>

        <div>
            <input type="hidden" for="class" name="class" required value=<?php echo get_class($vip); ?>>
        </div>

    </div>
</form>