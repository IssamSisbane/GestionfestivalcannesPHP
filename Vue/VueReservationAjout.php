<?php $this->_t = 'ReservationAjout'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/reservation.css" rel="stylesheet"/>

<p class="name-welcome"><b>Ajouter</b> une reservation (<?= count($hebergements)?>)</p>

<?php
if(isset($_POST['submitVip']))
{
?>
<form method="post">

    <input class="btn" type="submit" name="submitAjout" id="valider" value="valider">


    <div class="form-reservation">
        <div id="form-item">
            <div class="textbox">
                <label for="id">Id :</label>
                <input type="number" for="id" name="id" value=<?= $maxId ?> required>
            </div>

            <div class="textbox">
                <label for="dateDebut">Date de debut : </label>
                <input type="date" for="dateDebut" name="dateDebut" min="2021-03-01" max="2021-03-16" required>
            </div>

            <div class="textbox">
                <label for="dateFin">Date de fin : </label>
                <input type="date" for="dateFin" name="dateFin" min="2021-03-01" max="2021-03-16" required>
            </div>
        </div>
        
        
            <div hidden>
                <input type="text" for="vipLabel" name="vip" value=<?=$_POST['vip']?> hidden>
            </div>
        

        <div id="form-item">  
                <div>
                    <label id="hebergementLabel" for="hebergement">Choisir L'hebergement :</label>
                    <select for="hebergementLabel" id="hebergement" name="hebergement">
                    <?php foreach ($hebergements as $hebergement) : 
                        $so = serialize($hebergement); // Génère une représentation stockable d'une valeur
                        $soH = urlencode($so); //Encode une chaîne en URL
                        if (isset($_POST['reservationTrouve']) && $hebergement->get_id() == $_POST['reservationTrouve']) { ?>  
                            <option for="hebergement" value="<?= $soH ?>"selected><?= $hebergement->get_nom() ?> -- occupé par un membre du même groupe</option>
                    <?php }else{ ?>
                            <option for="hebergement" value="<?= $soH ?>"><?= $hebergement->get_nom() ?></option>
                    <?php } ?>
                <?php endforeach ?>
                    </select>
                </div>
        </div>
    </div>
</form>
<?php
}else{  ?>

<form method="post">
    <div class="form-reservation">
        <div id="form-item">
            <label id="vipLabel" for="vip">Choisir Le Vip:</label>
            <select for="vipLabel" id="vip" name="vip">
            <?php foreach ($vips as $vip) : 
                $so = serialize($vip); // Génère une représentation stockable d'une valeur
                $soe = urlencode($so); //Encode une chaîne en URL?>
                <option for="vip" value=<?= $soe ?>><?= $vip->get_nom() ?> (<?= get_class($vip) ?>)  </option>
            <?php endforeach ?>
            </select>
        </div>

    <input class="btn" type="submit" name="submitVip" id="valider" value="valider">

</form>

<?php
}
?>