<?php $this->_t = 'ReservationAffiche'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/reservation.css" rel="stylesheet"/>

<p class="name-welcome"><b>Modifier</b> la reservation </p>

<div class="boutonsRESERVATION">
    <a id="supprimer" href="index.php?url=reservation&action=supprimer&reservation=<?= $reservation->get_id() ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ?');">Supprimer</a>
</div>

<form method="post">

    <input class="btn" type="submit" name="submitModif" id="valider" value="valider">

    <div class="form-reservation">
        <div id="form-item">
            <div class="textbox">
                <label for="id">Id :</label>
                <input type="number" for="id" name="id" required value=<?php echo $reservation->get_id(); ?>>
            </div>

            <div class="textbox">
                <label for="dateDebut">Date de debut : </label>
                <input type="date" for="dateDebut" name="dateDebut" min="2021-03-01" max="2021-03-16" required value=<?php echo $reservation->get_dateDebut(); ?>>
            </div>

            <div class="textbox">
                <label for="dateFin">Date de fin : </label>
                <input type="date" for="dateFin" name="dateFin" min="2021-03-01" max="2021-03-16" required value=<?php echo $reservation->get_dateFin(); ?>>
            </div>
        </div>

        <div id="form-item">
            <div class="textbox">
                <label id="vipLabel" for="vip">Choisir Le Vip:</label>
                <select for="vipLabel" id="vip" name="vip">
                    <?php foreach ($vips as $vip) :
                        $so = serialize($vip); // Génère une représentation stockable d'une valeur
                        $soe = urlencode($so); //Encode une chaîne en URL
                        if ($vip->get_id() == $reservation->get_idVip() && get_class($vip) == $reservation->get_type_vip()) { ?>
                            <option for="vip" value="<?=$soe?>" selected><?= $vip->get_nom() ?> (<?= get_class($vip) ?>) </option>
                        <?php
                        } else { ?>
                            <option for="vip" value=<?=$soe?>><?= $vip->get_nom() ?> (<?= get_class($vip) ?>) </option>
                    <?php } endforeach ?>
                </select>
            </div>

            <div class="textbox">
                <label id="hebergementLabel" for="hebergement">Choisir L'hebergement :</label>
                <select for="hebergementLabel" id="hebergement" name="hebergement">
                    <?php foreach ($hebergements as $hebergement) :
                        $so = serialize($hebergement); // Génère une représentation stockable d'une valeur
                        $soH = urlencode($so); //Encode une chaîne en URL
                        if ($hebergement->get_id() == $reservation->get_idHebergement()) { ?>
                            <option for="hebergement" value="<?= $soH ?>"selected><?= $hebergement->get_nom() ?> </option>
                        <?php
                        } else { ?>
                            <option for="hebergement" value="<?= $soH ?>"><?= $hebergement->get_nom() ?> </option>
                    <?php } endforeach ?>
                </select>
            </div>
        </div>
    </div>
</form>