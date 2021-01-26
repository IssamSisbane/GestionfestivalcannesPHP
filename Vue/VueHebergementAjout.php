<?php $this->_t = 'HebergementAjout'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/hebergement.css" rel="stylesheet" />

<div class="hebergements">
    <div class="item-carre-center">
        <div id="carre"></div>
    </div>
</div>

<form method="post">

    <input class="btn" type="submit" name="submitAjout" id="valider" value="valider">

    <div class="form-hebergement">
        <div id="form-item">
            <div class="textbox">
                <label for="id">Id :</label>
                <input type="number" for="id" name="id" value=<?= $maxId ?> required>
            </div>

            <div class="textbox">
                <label for="nom">Nom : </label>
                <input type="text" for="nom" name="nom" required>
            </div>

            <?php if ($_SESSION['type_utilisateur_id'] == 4) { ?>
                <div class="textbox">
                    <label for="nom_proprietaire">Nom Proprietaire : </label>
                    <input type="text" for="nom_proprietaire" name="nom_proprietaire" value=<?= $_SESSION['pseudo'] ?> required>
                </div>
            <?php }else{ ?>
                <div class="textbox">
                    <label for="nom_proprietaire">Nom Proprietaire : </label>
                    <input type="text" for="nom_proprietaire" name="nom_proprietaire">
                </div>
            <?php } ?>
        </div>


        <div id="form-item">
            <?php foreach ($TousServices as $service) : // On parcourt tous les services 
                ?>

                <div class="textbox">
                    <input type="checkbox" id="<?php echo $service->get_libelle(); ?>" name="service[]"
                        value="<?php echo $service->get_libelle(); ?>">
                    <label for="<?php echo $service->get_libelle(); ?>"><?php echo $service->get_libelle(); ?></label>
                </div>
                <?php endforeach; ?>
        </div>
        
        
        <div id="form-item">
            <div class="textbox">
                <label for="nombrePlacesDisponibles">nombrePlacesDisponibles : </label>
                <input type="number" for="nombrePlacesDisponibles" name="nombrePlacesDisponibles" required>
            </div>

            <div class="textbox">
                <label for="prixParNuit">prixParNuit : </label>
                <input type="number" for="prixParNuit" name="prixParNuit" required>
            </div>

            <div class="textbox">
                <label id="type_hebergement_label" for="type_hebergement_choix">Choisir un type d'Hebergement':</label>
                <select for="type_hebergement_label" id="type_hebergement_choix" name="type_hebergement_choix" size='3' required>

                <?php foreach ($TousTypesHebergement as $type) : ?>
                    <option value="<?php echo $type->get_libelle(); ?>"><?php echo $type->get_libelle(); ?> </option>

                <?php endforeach; ?>
            </div>

        </div>
    </div>
</form>
</body>